<?php defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;



class Payment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['payment_m']);
    }
    // MIDTRANS
    public function index()
    {

        $data = [
            'title' => 'Payment Gateway',
            'pg' => $this->db->get('payment_gateway')->row_array(),
            'user' =>  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'company' =>  $this->db->get('company')->row_array(),
        ];
        $this->template->load('backend', 'backend/payment/data', $data);
    }
    // XENDIT
    public function xendit()
    {

        $xendit = $this->db->get('payment_gateway')->row_array();
        Xendit::setApiKey($xendit['api_key']);
        $url = 'https://api.xendit.co/payment_channels/';
        $headers = [];
        $headers[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $xendit['api_key'] . ":");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $paymentChannel = json_decode($result, true);
        $data = [
            'title' => 'Xendit',
            'saldocash' => \Xendit\Balance::getBalance('CASH'),
            'holding' => \Xendit\Balance::getBalance('HOLDING'),
            'tax' => \Xendit\Balance::getBalance('TAX'),
            'paymentChannel' => $paymentChannel,
            'xendit' => $this->db->get('payment_gateway')->row_array(),
            'user' =>  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'company' =>  $this->db->get('company')->row_array(),
        ];
        $this->template->load('backend', 'backend/payment/xendit-dashboard', $data);
    }
    public function createinvoice()
    {
        $post = $this->input->post(null, TRUE);
        $xendit = $this->db->get('payment_gateway')->row_array();
        $invoice = $this->db->get_where('invoice', ['invoice' => $post['invoice']])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
        Xendit::setApiKey($xendit['api_key']);
        $exp = $xendit['expired'] * 24;
        $expp = 60 * 60 * $exp;
        // var_dump($expp);
        // die;
        $external = substr(intval(rand()), 0, 3) . '-' . $post['invoice'];
        $params = [
            'external_id' => $external,
            'payer_email' => $customer['email'],
            'description' =>  'Tagihan ' . $customer['name'] . ' - ' . $customer['no_services'] . ' Periode ' . indo_month($invoice['month']) . ' ' . $invoice['year'],
            'amount' => floor($post['amount']),
            'invoice_duration' => $expp,
            'customer' => [
                'given_names' => $customer['name'],

                'email' => $customer['email'],
                'mobile_number' => indo_tlp($customer['no_wa']),
                'address' => [
                    [

                        'street_line1' => $customer['address'],

                    ]
                ]
            ],
            'success_redirect_url' => base_url('member'),
        ];

        $createInvoice = \Xendit\Invoice::create($params);
        // var_dump($createInvoice);


        $update = [
            'x_external_id' => $createInvoice['external_id'],
            'x_id' => $createInvoice['id'],
            'x_amount' => $createInvoice['expected_amount'],
            'payment_url' => $createInvoice['invoice_url'],
            'x_expired' => $createInvoice['expiry_date'],

            'expired' => $xendit['expired'],
        ];

        $this->db->update('invoice', $update, array('invoice' => $post['invoice']));

        // $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

        redirect($createInvoice['invoice_url']);
    }
    public function retrieve()
    {
        $xendit = $this->db->get('payment_gateway')->row_array();

        Xendit::setApiKey($xendit['api_key']);

        $getAllInvoice = \Xendit\Invoice::retrieveAll();
        // var_dump(($getAllInvoice));
        echo json_encode($getAllInvoice);
    }
    public function detailinvoice($id)
    {
        $xendit = $this->db->get('payment_gateway')->row_array();

        Xendit::setApiKey($xendit['api_key']);

        $getInvoice = \Xendit\Invoice::retrieve($id);
        // var_dump($getInvoice);
        echo json_encode($getInvoice);
    }
    public function selectpayment()
    {
        $selectpayment = $this->input->post('selectpayment');
        $xendit = $this->db->get('payment_gateway')->row_array();
        Xendit::setApiKey($xendit['api_key']);
        $url = 'https://api.xendit.co/payment_channels/';
        $headers = [];
        $headers[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $xendit['api_key'] . ":");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $paymentChannel = json_decode($result, true);
        if (isset($_POST['cek_data'])) {
            if ($selectpayment != 'qrcode') {
                # code...
                echo "<option value=''>-Pilih-</option>";
                foreach ($paymentChannel as $pc) {
                    if ($pc['channel_category'] == $selectpayment and $pc['is_enabled'] == 'true') {
                        echo "<option value='{$pc['channel_code']}'>{$pc['channel_code']}</option>";
                    }
                }
            } else {
                echo "<option value='qrcode'>QRIS</option>";
            }
        }
        // $this->load->view('backend/payment/select-payment', $data);
    }
    public function createpayment()
    {
        $post = $this->input->post(null, TRUE);
        $xendit = $this->db->get('payment_gateway')->row_array();
        $invoice = $this->db->get_where('invoice', ['invoice' => $post['invoice']])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
        Xendit::setApiKey($xendit['api_key']);
        if ($post['selectpayment'] == 'VIRTUAL_ACCOUNT') {
            $exp = $xendit['expired'] * 24;
            $expp = date('c', time() + (60 * 60 * $exp));
            $expired = $expp;
            $external = substr(intval(rand()), 0, 3) . '-' . $post['invoice'];
            $params = [
                'external_id' => $external,
                'bank_code' => $post['channel_code'],
                'name' => $customer['name'],
                'is_closed' => true,
                'expiration_date' => $expired,
                'expected_amount' => floor($post['amount']),
            ];
            $createVA = \Xendit\VirtualAccounts::create($params);
            // var_dump($createVA);

            $update = [
                'x_external_id' => $createVA['external_id'],
                'x_id' => $createVA['id'],
                'x_bank_code' => $createVA['bank_code'],
                'x_method' => $post['selectpayment'],
                'admin_fee' => $xendit['admin_fee'],
                'x_account_number' => $createVA['account_number'],
                'x_amount' => $createVA['expected_amount'],
                'x_expired' => $createVA['expiration_date'],
                'expired' => $xendit['expired'],
            ];

            $this->db->update('invoice', $update, array('invoice' => $post['invoice']));

            $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

            redirect('member/xcheckout/' . $external);
        }
        if ($post['selectpayment'] == 'BANK_ACCOUNT') {
            $exp = $xendit['expired'] * 24;
            $expp = date('c', time() + (60 * 60 * $exp));
            $expired = $expp;
            $external = substr(intval(rand()), 0, 3) . '-' . $post['invoice'];
            $params = [
                'external_id' => $external,
                'bank_code' => $post['channel_code'],
                'name' => $customer['name'],
                'is_closed' => true,
                'expiration_date' => $expired,
                'expected_amount' => floor($post['amount']),
            ];
            $createVA = \Xendit\VirtualAccounts::create($params);
            // var_dump($createVA);

            $update = [
                'x_external_id' => $createVA['external_id'],
                'x_id' => $createVA['id'],
                'x_bank_code' => $createVA['bank_code'],
                'x_method' => $post['selectpayment'],
                'admin_fee' => $xendit['admin_fee'],
                'x_account_number' => $createVA['account_number'],
                'x_amount' => $createVA['expected_amount'],
                'x_expired' => $createVA['expiration_date'],
                'expired' => $xendit['expired'],
            ];

            $this->db->update('invoice', $update, array('invoice' => $post['invoice']));

            $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

            redirect('member/xcheckout/' . $external);
        }
        if ($post['selectpayment'] == 'EWALLET') {
            $external = substr(intval(rand()), 0, 5) . '-' . $post['invoice'];
            if ($post['channel_code'] == 'OVO') {
                if ($post['phone'] != null) {
                    $ovoParams = [
                        'external_id' => $external,
                        'amount' => floor($post['amount']),
                        'phone' => $post['phone'],
                        'ewallet_type' => 'OVO',
                        'callback_url' => base_url('xendit/payovo'),

                    ];
                    try {
                        $createOvo = \Xendit\EWallets::create($ovoParams);
                        var_dump($createOvo);
                    } catch (\Xendit\Exceptions\ApiException $exception) {
                        var_dump($exception);
                    }
                    $update = [
                        'x_external_id' => $createOvo['external_id'],
                        'x_amount' => $createOvo['amount'],
                        'x_bank_code' => 'OVO',
                    ];
                    $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                    $this->session->set_flashdata('success-sweet', 'Checkout Berhasil, silahkan buka aplikasi OVO anda');
                    redirect('member');
                } else {
                    $this->session->set_flashdata('error-sweet', 'Untuk pembayaran ini, harus masukkan nomor e-wallet anda');
                    redirect('member');
                }
            }
            if ($post['channel_code'] == 'LINKAJA') {
                $external = substr(intval(rand()), 0, 5) . '-' . $post['invoice'];
                $item = 'Internet ' . $invoice['no_services'] . ' Periode ' . indo_month($invoice['month'] . ' ' . $invoice['year']);
                if ($post['phone'] != null) {
                    $linkajaParams = [
                        'external_id' => $external,
                        'amount' => floor($post['amount']),
                        'phone' => $post['phone'],
                        'items' => [
                            [
                                'id' => $post['invoice'],
                                'name' => $item,
                                'price' =>  floor($post['amount']),
                                'quantity' => 1
                            ],
                        ],
                        'callback_url' => base_url('xendit/paylinkaja'),
                        'redirect_url' => base_url('member'),
                        'ewallet_type' => 'LINKAJA'
                    ];
                    $createLinkaja = \Xendit\EWallets::create($linkajaParams);

                    $update = [
                        'x_external_id' => $createLinkaja['external_id'],
                        'x_amount' => $createLinkaja['amount'],
                        'x_bank_code' => 'LINKAJA',
                        'x_method' => $post['selectpayment'],
                    ];
                    $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                    redirect($createLinkaja['checkout_url']);
                } else {
                    $this->session->set_flashdata('error-sweet', 'Untuk pembayaran ini, harus masukkan nomor e-wallet anda');
                    redirect('member');
                }
            }
            if ($post['channel_code'] == 'DANA') {
                $exp = $xendit['expired'] * 24;
                $expp = date('c', time() + (60 * 60 * $exp));
                $expired = $expp;
                $external = substr(intval(rand()), 0, 5) . '-' . $post['invoice'];
                if ($post['phone'] != null) {
                    $danaParams = [
                        'external_id' => $external,
                        'amount' => floor($post['amount']),
                        'phone' => $post['phone'],
                        'expiration_date' => $expired,
                        'callback_url' => base_url('xendit/paydana'),
                        'redirect_url' => base_url('member'),
                        'ewallet_type' => 'DANA'
                    ];
                    $createDana = \Xendit\EWallets::create($danaParams);

                    $update = [
                        'x_external_id' => $createDana['external_id'],
                        'x_expired' => $expired,
                        'x_method' => $post['selectpayment'],
                        'x_bank_code' => $createDana['ewallet_type'],
                        'x_amount' => $createDana['amount'],
                        'pdf_url' => $createDana['checkout_url'],
                    ];
                    $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                    // var_dump($createDana);
                    redirect($createDana['checkout_url']);
                } else {
                    $this->session->set_flashdata('error-sweet', 'Untuk pembayaran ini, harus masukkan nomor e-wallet anda');
                    redirect('member');
                }
            }
        }
        if ($post['selectpayment'] == 'RETAIL_OUTLET') {
            $external = substr(intval(rand()), 0, 5) . '-' . $post['invoice'];
            // $code = substr(intval(rand()), 0, 3) . '-' . $invoice['no_services'];
            $exp = $xendit['expired'] * 24;
            $expp = date('c', time() + (60 * 60 * $exp));
            $expired = $expp;
            if ($post['channel_code'] == 'ALFAMART') {
                $params = [
                    'external_id' => $external,
                    'retail_outlet_name' => 'ALFAMART',
                    'name' => $customer['name'],
                    'callback_url' => base_url('xendit/payretail'),
                    'expiration_date' => $expired,
                    'expected_amount' => floor($post['amount'])
                ];

                $createFPC = \Xendit\Retail::create($params);
                // var_dump($createFPC);
                $update = [
                    'x_external_id' => $createFPC['external_id'],
                    'x_expired' => $expired,
                    'x_method' => $post['selectpayment'],
                    'x_account_number' => $createFPC['payment_code'],
                    'x_bank_code' => $createFPC['retail_outlet_name'],
                    'x_amount' => $createFPC['expected_amount'],
                ];
                $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                // var_dump($createFPC);

                $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

                redirect('member/xcheckout/' . $external);
            }
            if ($post['channel_code'] == 'INDOMARET') {
                $params = [
                    'external_id' => $external,
                    'retail_outlet_name' => 'INDOMARET',
                    'name' => $customer['name'],
                    'callback_url' => base_url('xendit/payretail'),
                    'expiration_date' => $expired,
                    'expected_amount' => floor($post['amount'])
                ];

                $createFPC = \Xendit\Retail::create($params);
                // var_dump($createFPC);
                $update = [
                    'x_external_id' => $createFPC['external_id'],
                    'x_expired' => $expired,
                    'x_method' => $post['selectpayment'],
                    'x_account_number' => $createFPC['payment_code'],
                    'x_bank_code' => $createFPC['retail_outlet_name'],
                    'x_amount' => $createFPC['expected_amount'],
                ];
                $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                // var_dump($createFPC);

                $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

                redirect('member/xcheckout/' . $external);
            }
        }
        if ($post['selectpayment'] == 'qrcode') {
            $external = substr(intval(rand()), 0, 5) . '' . $post['invoice'];
            // $code = substr(intval(rand()), 0, 3) . '-' . $invoice['no_services'];
            $exp = $xendit['expired'] * 24;
            $expp = date('c', time() + (60 * 60 * $exp));
            $expired = $expp;
            if ($post['channel_code'] == 'qrcode') {
                $params = [
                    'external_id' =>  $external,
                    'type' => 'DYNAMIC',
                    'callback_url' => base_url('xendit/payqrcode'),
                    'amount' => floor($post['amount']),
                ];
                $created_qr_code = \Xendit\QRCode::create($params);
                // var_dump($createFPC);
                $update = [
                    'x_external_id' => $created_qr_code['external_id'],
                    'x_method' => $post['selectpayment'],
                    'x_id' => $created_qr_code['id'],
                    'x_qrcode' => $created_qr_code['qr_string'],
                    'x_amount' => $created_qr_code['amount'],
                ];
                $writer = new PngWriter();

                // Create QR code
                $qrCode = QrCode::create($created_qr_code['qr_string'])
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(300)
                    ->setMargin(10)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));

                $result = $writer->write($qrCode);
                // Directly output the QR code
                $target_file = './assets/images/pg/' . $post['invoice'] . '.png';
                unlink($target_file);

                // Save it to a file
                $result->saveToFile('./assets/images/pg/' . $post['invoice'] . '.png');
                $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

                redirect('member/xcheckout/' . $external);
            }
            if ($post['channel_code'] == 'INDOMARET') {
                $params = [
                    'external_id' => $external,
                    'retail_outlet_name' => 'INDOMARET',
                    'name' => $customer['name'],
                    'callback_url' => base_url('xendit/payretail'),
                    'expiration_date' => $expired,
                    'expected_amount' => floor($post['amount'])
                ];

                $createFPC = \Xendit\Retail::create($params);
                // var_dump($createFPC);
                $update = [
                    'x_external_id' => $createFPC['external_id'],
                    'x_expired' => $expired,
                    'x_method' => $post['selectpayment'],
                    'x_account_number' => $createFPC['payment_code'],
                    'x_bank_code' => $createFPC['retail_outlet_name'],
                    'x_amount' => $createFPC['expected_amount'],
                ];
                $this->db->update('invoice', $update, array('invoice' => $post['invoice']));
                // var_dump($createFPC);

                $this->session->set_flashdata('success-sweet', 'Checkout Berhasil');

                redirect('member/xcheckout/' . $external);
            }
        }
    }


    public function edit()
    {
        $post = $this->input->post(null, TRUE);
        $this->payment_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Payment Gateway berhasil diperbaharui');
        }
        redirect('payment');
    }

    public function test()
    {
        $xendit = $this->db->get('payment_gateway')->row_array();
        Xendit::setApiKey($xendit['api_key']);
        // $qr_code = \Xendit\QRCode::get('13879210413001');
        // var_dump($qr_code);
        // $ch = curl_init();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xendit.co/qr_codes/124');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, $xendit['api_key']);

        printf(curl_exec($ch));
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }


    public function qr()
    {
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create('00020101021226660014ID.LINKAJA.WWW011893600911002100615802152007271100615850303UME51450015ID.OR.GPNQR.WWW02150000000000000000303UME520454995802ID59111112Project6013Garut Regency610544160623801157enixdttBYWcP5L07157enixdttBYWcP5L5303360540415006304E76C')
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);
        // Directly output the QR code
        header('Content-Type: ' . $result->getMimeType());
        echo $result->getString();

        // Save it to a file
        // $result->saveToFile('./assets/images/pg/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $result->getDataUri();
    }

    public function createqr()
    {
        $xendit = $this->db->get('payment_gateway')->row_array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xendit.co/qr_codes');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "external_id=124&type=DYNAMIC&callback_url=https://yourwebsite.com/callback&amount=1500");
        curl_setopt($ch, CURLOPT_USERPWD, $xendit['api_key']);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}
