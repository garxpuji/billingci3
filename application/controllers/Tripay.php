<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tripay extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $pg = $this->db->get('payment_gateway')->row_array();
        $privateKey = $pg['server_key'];
        // ambil data json callback notifikasi
        $json = file_get_contents("php://input");
        $signature = hash_hmac('sha256', $json, $privateKey);
        $result = json_decode($json, true);
        echo $json;
        $merchantOrderId = $result['merchant_ref'];

        if ($result['status'] == "PAID") {
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $merchantOrderId])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            // echo "SUCCESS"; // Save to database
            $updateinvoice = [
                'status' => 'SUDAH BAYAR',
            ];
            $this->db->where('x_external_id', $merchantOrderId);
            $this->db->update('invoice', $updateinvoice);
            if ($this->db->affected_rows() > 0) {
                $updateinvoice = [
                    'date_payment' => time(),
                    'metode_payment' => 'Payment Gateway',
                ];
                $this->db->where('x_external_id', $merchantOrderId);
                $this->db->update('invoice', $updateinvoice);
                $addincome = [
                    'nominal' => $invoice['amount'] - $invoice['disc_coupon'],
                    'date_payment' => date('Y-m-d'),
                    'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice['no_services'] . ' ' . 'a/n' . ' ' . $customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice['month']) . ' ' . $invoice['year'] . ' by Tripay ' . $result['payment_method'],
                    'invoice_id' => $invoice['invoice'],
                    'category' => 1,
                    'create_by' => 0,
                    'no_services' => $invoice['no_services'],
                    'mode_payment' => 'Payment Gateway',
                    'created' => time()
                ];
                $this->db->insert('income', $addincome);
                $whatsapp = $this->db->get('whatsapp')->row_array();
                if ($whatsapp['is_active'] == 1) {
                    $other = $this->db->get('other')->row_array();
                    $company = $this->db->get('company')->row_array();
                    // echo  $timeex;
                    if ($whatsapp['paymentinvoice'] == 1) {
                        $other = $this->db->get('other')->row_array();
                        $company = $this->db->get('company')->row_array();
                        $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                        $search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                        $replace = array($customer['name'], $customer['no_services'],  $customer['email'], $invoice['invoice'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $invoice['inv_due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                        $subject = $other['thanks_wa'];
                        $message = str_replace($search, $replace, $subject);
                        $target = indo_tlp($customer['no_wa']);
                        sendmsgbill($target, $message,  $invoice['invoice']);
                    }
                }
                $bot = $this->db->get('bot_telegram')->row_array();
                $tokens = $bot['token']; // token bot
                $owner = $bot['id_telegram_owner'];
                $periode = indo_month($invoice['month']) . ' ' . $invoice['year'];
                $sendmessage = [
                    'reply_markup' => json_encode([
                        'inline_keyboard' => []
                    ]),
                    'resize_keyboard' => true,
                    'parse_mode' => 'html',
                    'text' => "<b>PEMBAYARAN MASUK</b>\nNama : $customer[name]\nNo Layanan : $customer[no_services]\nNo Invoice : $invoice[invoice]\nPeriode : $periode\nTotal : $result[total_amount]\nVendor : Tripay\nMetode Pembayaran : $result[payment_method]",
                    'chat_id' => $owner
                ];
                file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));

                $rt = $this->db->get_where('router', ['id' => 1])->row_array();
                if ($rt['is_active'] == 1) {
                    if ($customer['auto_isolir'] == 1) {
                        if ($customer['user_mikrotik'] != '') {
                            openisolir($customer['no_services'], $customer['router']);
                        }
                    }
                }
            }
        }
    }
    public function checkout()
    {

        $post = $this->input->post(null, TRUE);
        $customer = $this->db->get_where('customer', ['no_services' => $post['no_services']])->row_array();
        $invoice = $this->db->get_where('invoice', ['invoice' => $post['invoice']])->row_array();
        $pg = $this->db->get('payment_gateway')->row_array();
        if ($pg['mode'] == 1) {
            $url = "https://tripay.co.id/api/transaction/create"; // Production
        } else {
            $url = 'https://tripay.co.id/api-sandbox/transaction/create'; // Sandbox
        }
        $company = $this->db->get('company')->row_array();
        $apiKey =  $pg['api_key'];
        $privateKey =  $pg['server_key'];
        $merchantCode =  $pg['kodemerchant'];
        $merchantRef = sprintf(mt_rand(1, 999999)) . '-' . $post['invoice'];
        $amount = floor($post['amount']);
        if ($post['expired'] == null) {
            $expired = $pg['expired'] * 60 * 60;
        } else {
            $waktu_awal        = time();
            $waktu_akhir    = strtotime($post['expired'] . "23:59:59");
            $diff    = $waktu_akhir - $waktu_awal;
            $expired =  $diff;
        }
        $data = [
            'method'            => $post['selectpaymenttripay'],
            'merchant_ref'      => $merchantRef,
            'amount'            => $amount,
            'customer_name'     => $customer['name'],
            'customer_email'    => $customer['email'],
            'customer_phone'    => $customer['no_wa'],
            'order_items'       => [
                [
                    'sku'       => $customer['name'],
                    'name'      => 'Tagihan Internet ' . $post['no_services'] . ' Periode ' . indo_month($invoice['month']) . ' ' . $invoice['year'],
                    'price'     => $amount,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => base_url('tripay'),
            'return_url'        => base_url('member'),
            'expired_time'      => (time() + $expired), // 24 jam
            'signature'         => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $url,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $apiKey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
        ));

        $response = curl_exec($curl);
        $responseerr = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        // $response = json_encode($response);
        $response = json_decode($response, true);
        // echo $response;
        // echo !empty($err) ? $err : $response;
        if (!empty($post['codecoupontripay'])) {
            $code = $post['codecoupontripay'];
            $disc = $post['disccoupontripay'];
        } else {
            $code = '';
            $disc = '';
        }
        if ($response['success'] == 'true') {
            $update = [
                'x_external_id' => $response['data']['merchant_ref'],
                'transaction_time' => time(),
                'x_method' => $post['selectpaymenttripay'],
                'x_account_number' => $response['data']['pay_code'],
                'x_amount' => $response['data']['amount'],
                'reference' => $response['data']['reference'],
                'expired' => $pg['expired'],
                'code_coupon' => $code,
                'disc_coupon' => $disc,
                'payment_url' => $response['data']['checkout_url'],
            ];
            $this->db->where('invoice', $post['invoice']);
            $this->db->update('invoice', $update);
            $whatsapp = $this->db->get('whatsapp')->row_array();
            if ($whatsapp['is_active'] == 1) {
                $other = $this->db->get('other')->row_array();
                $company = $this->db->get('company')->row_array();

                $target = indo_tlp($customer['no_wa']);

                $nominalWA = indo_currency($post['amount']);

                $search  = array('{name}', '{noservices}',  'phone', '{email}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}', '{payment_url}');

                $replace = array($customer['name'], $customer['no_services'],  $customer['no_wa'], $customer['email'],  $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], indo_date($invoice['inv_due_date']), $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '', $response['data']['checkout_url']);

                $subject = $other['checkout'];

                $message = str_replace($search, $replace, $subject);

                sendmsg($target, $message);
            }
            echo "<script>window.location='" . $response['data']['checkout_url'] . "'; </script>";
        } else {
            $this->session->set_flashdata('error-sweet', 'Checkout Gagal <br>' . $responseerr);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function pay()
    {
        $invoice = $this->input->get('invoice');
        $data['title'] = 'Checkout';
        $data['invoice'] = $this->db->get_where('invoice', ['invoice' => $invoice])->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('member', 'member/payment/pay', $data);
    }

    public function transaction()
    {
        is_logged_in();
        $pg = $this->db->get('payment_gateway')->row_array();
        $apiKey =  $pg['api_key'];
        $apiKey = $apiKey;
        $page = $this->input->get('page');

        if ($page == null) {
            $pages = 1;
        } else {
            $pages = $page;
        }

        $payload = [
            'page' => $pages,
            'per_page' => 100,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api/merchant/transactions?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        // echo empty($err) ? $response : $error;
        $result = json_decode($response, true);
        $data['title'] = 'Data Transaksi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['transaction'] = $result['data'];
        $this->template->load('backend', 'backend/payment/transaction', $data);
    }
}
