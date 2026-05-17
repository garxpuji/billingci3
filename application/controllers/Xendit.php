<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Xendit extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */


    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model(['customer_m', 'package_m', 'services_m', 'setting_m', 'bill_m', 'income_m']);
    }

    public function create()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $id = $respon['id'];
        $update = [
            'x_id' => $respon['id'],
            'x_external_id' => $respon['external_id'],
            'x_bank_code' => $respon['bank_code'],
            'x_account_number' => $respon['account_number'],
            'x_amount' => $respon['expected_amount'],
            'x_expired' => $respon['expiration_date'],
        ];
        $this->db->update('invoice', $update, array('x_id' => $id));
    }


    public function payinvoice()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $external_id = $respon['external_id'];
        if ($respon['status'] == 'PAID' or $respon['status'] == 'COMPLETED') {
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $external_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            $data = [
                'status' => 'SUDAH BAYAR',
            ];

            $this->db->where('x_external_id',  $external_id);
            $this->db->update('invoice', $data);
            if ($this->db->affected_rows() > 0) {
                $data = [
                    'metode_payment' => 'Payment Gateway',
                    'date_payment' => time(),
                ];

                $this->db->where('x_external_id',  $external_id);
                $this->db->update('invoice', $data);
                $addincome = [
                    'nominal' => $invoice['amount'] - $invoice['disc_coupon'],
                    'date_payment' => date('Y-m-d'),
                    'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice['no_services'] . ' ' . 'a/n' . ' ' . $customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice['month']) . ' ' . $invoice['year'] . ' by Xendit ' . $respon['payment_channel'],
                    'invoice_id' => $invoice['invoice'],
                    'category' => 1,
                    'create_by' => 0,
                    'no_services' => $invoice['no_services'],
                    'mode_payment' => 'Payment Gateway',
                    'created' => time()
                ];
                $this->db->insert('income', $addincome);
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
                    // echo  $timeex;
                    if ($whatsapp['paymentinvoice'] == 1) {
                        $other = $this->db->get('other')->row_array();
                        $company = $this->db->get('company')->row_array();
                        $target = indo_tlp($customer['no_wa']);
                        $nominalWA = $respon['paid_amount'];
                        $search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                        $replace = array($customer['name'], $customer['no_services'],  $customer['email'], $invoice['invoice'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $invoice['inv_due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                        $subject = $other['thanks_wa'];
                        $message = str_replace($search, $replace, $subject);
                        $target = indo_tlp($customer['no_wa']);
                        sendmsgbill($target, $message,  $invoice['invoice']);
                    }
                }
            }
        }
    }
    public function pay()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_idva = $respon['callback_virtual_account_id'];
        $x_id = $respon['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];
        $this->db->update('invoice', $data, array('x_id' => $x_idva));
        $this->income_m->addbyxendit($x_id);
        $invoice = $this->db->get_where('invoice', ['x_id' => $x_id])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
        if ($customer['auto_isolir'] == 1) {
            if ($customer['user_mikrotik'] != '') {
                openisolir($customer['no_services'], $customer['router']);
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
                $username = $whatsapp['username'];
                $APIkey = $whatsapp['api_key'];
                $target = indo_tlp($customer['no_wa']);
                echo $target, $timeex;
                $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                $subject = $other['thanks_wa'];

                $message = str_replace($search, $replace, $subject);

                sendmsg($target, $message);
            }
        }
    }
    public function payovo()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];
        if ($respon['status'] == 'COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];
                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['status'] == 'PAID') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS


                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['status'] == 'SETTLING') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }
    public function payretail()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];
        if ($respon['status'] == 'COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['status'] == 'SETTLING') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }
    public function payqrcode()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['qr_code']['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];
        if ($respon['status'] == 'COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS


                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['status'] == 'SETTLING') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS


                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }
    public function paylinkaja()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];

        if ($respon['status'] == 'SUCCESS_COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['status'] == 'COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS


                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['status'] == 'SETTLING') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS

                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }
    public function paydana()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];

        if ($respon['payment_status'] == 'PAID') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['payment_status'] == 'COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
        if ($respon['payment_status'] == 'SETTLING') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }
    public function paydompetdigital()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['external_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];
        if ($respon['status'] == 'COMPLETED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));
            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }
    public function payewallet()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
        $x_id = $respon['data']['reference_id'];
        $data = [
            'status' => 'SUDAH BAYAR',
            'date_payment' => time(),
        ];
        if ($respon['data']['status'] == 'SUCCEEDED') {
            $this->db->update('invoice', $data, array('x_external_id' => $x_id));

            $this->income_m->addbyxendit($x_id);
            $invoice = $this->db->get_where('invoice', ['x_external_id' => $x_id])->row_array();
            $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
            if ($customer['auto_isolir'] == 1) {
                if ($customer['user_mikrotik'] != '') {
                    openisolir($customer['no_services'], $customer['router']);
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
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $target = indo_tlp($customer['no_wa']);
                    echo $target, $timeex;
                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);
                    $target = indo_tlp($customer['no_wa']);
                    sendmsg($target, $message);
                }
            }
        }
    }

    public function redirectlinkaja()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
    }
    public function callback()
    {
        $respon = file_get_contents('php://input');
        $respon = json_decode($respon, true);
    }
}
