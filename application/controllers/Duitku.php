<?php defined('BASEPATH') or exit('No direct script access allowed');

class Duitku extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $pg = $this->db->get('payment_gateway')->row_array();
        $apiKey = $pg['api_key']; // Your api key
        $merchantCode = isset($_POST['merchantCode']) ? $_POST['merchantCode'] : null;
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        $merchantOrderId = isset($_POST['merchantOrderId']) ? $_POST['merchantOrderId'] : null;
        $resultCode = isset($_POST['resultCode']) ? $_POST['resultCode'] : null;
        $signature = isset($_POST['signature']) ? $_POST['signature'] : null;
        if (!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
            $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
            $calcSignature = md5($params);

            if ($signature == $calcSignature) {
                //Your code here

                if ($resultCode == "00") {
                    $invoice = $this->db->get_where('invoice', ['x_external_id' => $merchantOrderId])->row_array();
                    $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
                    echo "SUCCESS"; // Save to database
                    $updateinvoice = [
                        'status' => 'SUDAH BAYAR',
                        'metode_payment' => 'Payment Gateway',
                        'date_payment' => time(),
                    ];
                    $this->db->where('x_external_id', $merchantOrderId);
                    $this->db->update('invoice', $updateinvoice);
                    $addincome = [
                        'nominal' => $invoice['amount'],
                        'date_payment' => date('Y-m-d'),
                        'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice['no_services'] . ' ' . 'a/n' . ' ' . $customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice['month']) . ' ' . $invoice['year'] . ' by Duitku',
                        'invoice_id' => $invoice['invoice'],
                        'category' => 1,
                        'create_by' => 0,
                        'no_services' => $invoice['no_services'],
                        'mode_payment' => 'Payment Gateway',
                        'created' => time()
                    ];
                    $this->db->insert('income', $addincome);

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
                        'text' => "<b>PEMBAYARAN MASUK</b>\nNama : $customer[name]\nNo Layanan : $customer[no_services]\nNo Invoice : $invoice[invoice]\nPeriode : $periode\nVendor : Duitku\n",
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
                    $whatsapp = $this->db->get('whatsapp')->row_array();
                    if ($whatsapp['is_active'] == 1) {
                        $other = $this->db->get('other')->row_array();
                        $company = $this->db->get('company')->row_array();
                        $no = 1;
                        $range = $no++ * $whatsapp['interval_message'];
                        $timeex = time() + (1 * 60 * $range);
                        $timeex = date('Y-m-d H:i:s', $timeex);

                        $timenow = time() + (1 * 60 * $range);
                        $wadateex = date('Y-m-d', $timenow);
                        $watimeex = date('H:i', $timenow);
                        // echo  $timeex;
                        if ($whatsapp['paymentinvoice'] == 1) {
                            $other = $this->db->get('other')->row_array();
                            $company = $this->db->get('company')->row_array();
                            $target = indo_tlp($customer['no_wa']);
                            echo $target, $timeex;
                            $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                            $search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                            $replace = array($customer['name'], $customer['no_services'],  $customer['email'], $invoice['invoice'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'],  $invoice['inv_due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                            $subject = $other['thanks_wa'];
                            $message = str_replace($search, $replace, $subject);
                            $target = indo_tlp($customer['no_wa']);
                            sendmsgbill($target, $message,  $invoice['invoice']);
                        }
                    }
                } else {
                    echo "FAILED"; // Please update the status to FAILED in database
                }
            } else {
                // throw new Exception('Bad Signature');
                echo 'Bad Signature';
            }
        } else {
            // throw new Exception('Bad Parameter');
            echo 'Bad Parameter';
        }
    }

    public function checkout()
    {

        $post = $this->input->post(null, TRUE);
        $customer = $this->db->get_where('customer', ['no_services' => $post['no_services']])->row_array();
        $invoice = $this->db->get_where('invoice', ['invoice' => $post['invoice']])->row_array();
        $pg = $this->db->get('payment_gateway')->row_array();
        $company = $this->db->get('company')->row_array();
        $merchantCode = $pg['kodemerchant']; // from duitku
        $merchantKey = $pg['api_key']; // from duitku
        $paymentAmount = floor($post['amount']);
        $paymentMethod = $post['selectpaymentduitku']; // VC = Credit Card
        $merchantOrderId = substr(intval(rand()), 0, 3) . '-' . $post['invoice']; // from merchant, unique
        $productDetails = 'Payment ' . $company['company_name'];
        $email = $customer['email']; // your customer email
        $phoneNumber = $customer['no_wa']; // your customer phone number (optional)
        $customerVaName = $customer['name']; // display name on bank confirmation display
        $callbackUrl = base_url('duitku'); // url for callback
        $returnUrl = base_url('dashboard'); // url for redirect
        $expiryPeriod = $pg['expired']; // set the expired time in minutes
        $signature = md5($merchantCode . $merchantOrderId . $paymentAmount . $merchantKey);

        $item1 = array(
            'name' => 'Tagihan Internet ' . $post['no_services'] . ' Periode ' . indo_month($invoice['month']) . ' ' . $invoice['year'],
            'price' => floor($post['amount']),
            'quantity' => 1
        );


        $itemDetails = array(
            $item1,
        );

        $params = array(
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,

            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'itemDetails' => $itemDetails,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => $expiryPeriod

        );

        $params_string = json_encode($params);
        //echo $params_string;
        if ($pg['mode'] == 1) {
            $url = 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry'; // Production
            # code...
        } else {
            # code...
            $url = 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry'; // Sandbox
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string)
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $result = json_decode($request, true);
            $update = [
                'x_external_id' => $merchantOrderId,
                'reference' => $result['reference'],
                'transaction_time' => time(),
                'x_method' => $post['selectpaymentduitku'],
                'x_account_number' => $result['vaNumber'],
                'x_amount' => $result['amount'],
                'expired' => $pg['expired'],
                'payment_url' => $result['paymentUrl'],
            ];
            $this->db->where('invoice', $post['invoice']);
            $this->db->update('invoice', $update);
            redirect($result['paymentUrl']);
        } else {
            echo $httpCode . "<br />";
            echo "Chekout Gagal, Silahkan coba lagi nanti, atau hubungi kami";
        }
    }
}
