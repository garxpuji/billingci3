<?php defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['setting_m', 'customer_m', 'services_m', 'bill_m']);
    }


    public function index()
    {
        $data['title'] = 'Setting';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['country'] = $this->db->get('country')->result();
        $this->template->load('backend', 'backend/setting/company', $data);
    }
    public function editCompany()
    {
        $config['upload_path']          = './assets/images';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 10048; // 10 Mb
        $config['file_name']             = 'logo-' . date('dmY');
        $this->load->library('upload', $config);
        $post = $this->input->post(null, TRUE);

        if (@FILES['logo']['name'] != null) {
            if ($this->upload->do_upload('logo')) {
                $company = $this->setting_m->getCompany($post['id'])->row();
                if ($company->logo != null) {
                    $target_file = './assets/images/' . $company->logo;
                    unlink($target_file);
                }
                $post['logo'] =  $this->upload->data('file_name');
                $this->setting_m->editCompany($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success-sweet', 'Data perusahaan berhasil diperbaharui');
                }
                echo "<script>window.location='" . site_url('setting') . "'; </script>";
            } else {
                $post['logo'] =  null;
                $this->setting_m->editCompany($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success-sweet', 'Data perusahaan berhasil diperbaharui');
                }
                echo "<script>window.location='" . base_url('setting') . "'; </script>";
            }
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            echo "<script>window.location='" . base_url('setting') . "'; </script>";
        }
    }

    public function about()
    {
        $data['title'] = 'About';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/setting/about', $data);
    }
    public function editAbout()
    {
        $description = $this->input->post('description');
        $this->db->set('description', $description);
        $this->db->update('company');
        $this->session->set_flashdata('success-sweet', 'Deskripsi perusahaan sudah diperbaharui.
      ');
        redirect('setting/about');
    }

    public function bank()
    {
        $data['title'] = 'Bank';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['bank'] = $this->setting_m->getBank()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/setting/bank', $data);
    }

    public function addBank()
    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->addBank($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Bank berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('setting/bank') . "'; </script>";
    }
    public function editBank()
    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->editBank($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Bank berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/bank') . "'; </script>";
    }
    public function deleteBank()
    {
        $bank_id = $this->input->post('bank_id');
        $this->setting_m->deleteBank($bank_id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Bank berhasil dihapus');
        }
        echo "<script>window.location='" . site_url('setting/bank') . "'; </script>";
    }
    public function backup()
    {
        $data['title'] = 'Backup';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/setting/backup', $data);
    }
    public function backupdatabase()
    {
        $company = $this->db->get('company')->row_array();
        $this->load->dbutil();

        $config = array(
            'format'    => 'zip',
            'filename'    => 'Backup-My-Wifi-' . $company['company_name'] . '-' . date("YmdHis") . '-db.sql'
        );

        $backup = $this->dbutil->backup($config);

        $this->load->helper('file');
        $this->load->helper('download');
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'datetime' => time(),
            'category' => 'Backup',
            'user_id' => $this->session->userdata['id'],
            'role_id' => $this->session->userdata['role_id'],
            'name' => $this->session->userdata['name'],
            'remark' => 'Backup Database My-Wifi' . ' ' . date('d-m-Y H:i:s') . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
        ];
        $this->db->insert('logs', $params);
        force_download('Backup-My-Wifi-' . $company['company_name'] . '-' . date("YmdHis") . '-db.zip', $backup);
    }

    public function email()
    {
        $data['title'] = 'Email';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['email'] = $this->db->get('email')->row_array();
        $this->template->load('backend', 'backend/setting/email', $data);
    }


    public function sendemail()
    {
        $email = $this->db->get('email')->row_array();
        $config = [
            'protocol'  => $email['protocol'],
            'smtp_host' => $email['host'],
            'smtp_user' => $email['email'],
            'smtp_pass' => $email['password'],
            'smtp_port' => $email['port'],
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];
        $to_email = $this->input->post('to_email');
        $this->email->initialize($config);
        $this->load->library('email', $config);
        $this->email->from($email['email'], $email['name']); // isi Alamat email dan nama pengirim
        $this->email->to($to_email);
        $this->email->subject($this->input->post('subject'));
        $this->email->message($this->input->post('message'));
        if ($this->email->send()) {
            $this->session->set_flashdata('success-sweet', 'Email berhasil terkirim');
            redirect('setting/email');
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    public function editEmail()
    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->editEmail($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Email berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/email') . "'; </script>";
    }
    public function other()
    {
        $data['title'] = 'Lainnya';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['other'] = $this->db->get('other')->row_array();
        $this->template->load('backend', 'backend/setting/other', $data);
    }

    public function editOther()
    {
        $post = $this->input->post(null, TRUE);
        $whatsapp = $this->db->get('whatsapp')->row_array();
        if ($whatsapp['is_active'] != 1) {
            $this->db->set('say_wa', $post['say_wa']);
            $this->db->set('thanks_wa', $post['thanks_wa']);
        }
        $this->db->set('remark_invoice', $post['remark_invoice']);
        $this->db->set('inv_thermal', $post['inv_thermal']);
        $this->db->update('other');



        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/other') . "'; </script>";
    }
    public function smsgateway()
    {
        $data['title'] = 'Lainnya';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['sms'] = $this->db->get('sms_gateway')->row_array();
        $this->template->load('backend', 'backend/setting/smsgateway', $data);
    }
    public function sendsms()
    {
        $sg = $this->db->get('sms_gateway')->row_array();
        $token = $sg['sms_token'];
        $user = $sg['sms_user'];
        $password = $sg['sms_password'];
        $mobile = $this->input->post('mobile');
        $message = $this->input->post('message');

        $url = 'https://soufasms.com/sms_gateway/?user=' . $user . '&pass=' . $password . '&no=' . $mobile . '&msg=' . $message . '';

        $header = array(
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $hasil =  json_decode($result, true);
        if ($hasil['status'] == 200) {
            $this->session->set_flashdata('success-sendsms', $hasil['status_message']);
        } else {
            $this->session->set_flashdata('error-sendsms', $hasil['status_message']);
        }
        redirect('setting/smsgateway');
    }
    public function editsmsgateway()
    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->editsmsgateway($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/smsgateway') . "'; </script>";
    }
    public function wagateway()
    {
        $data['title'] = 'Lainnya';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['sms'] = $this->db->get('sms_gateway')->row_array();
        $this->template->load('backend', 'backend/setting/wa-gateway', $data);
    }

    public function editwagateway()
    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->editsmsgateway($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/smsgateway') . "'; </script>";
    }
    public function editphp()
    {
        $data['title'] = 'Lainnya';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['sms'] = $this->db->get('sms_gateway')->row_array();
        $this->template->load('backend', 'backend/setting/editphp', $data);
    }
    public function editnotifwa()
    {
        $data['title'] = 'Lainnya';
        $data['title'] = 'Bill';
        $data['customer'] = $this->customer_m->getCustomeractive()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['other'] = $this->db->get('other')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['sms'] = $this->db->get('sms_gateway')->row_array();
        $this->template->load('backend', 'backend/bill/editnotifwa', $data);
    }
    public function editnotifwaa()
    {
        $data['title'] = 'Lainnya';
        $data['title'] = 'Bill';

        $data['customer'] = $this->customer_m->getCustomeractive()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['other'] = $this->db->get('other')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['sms'] = $this->db->get('sms_gateway')->row_array();
        $this->template->load('backend', 'backend/bill/editnotifwa', $data);
    }

    public function expired()
    {
        $data['title'] = 'Expired';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->load->view('backend/setting/expired', $data);
    }


    public function router()

    {

        $data['title'] = 'Router';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['company'] = $this->db->get('company')->row_array();

        $data['router'] = $this->db->get('router')->row_array();

        $this->template->load('backend', 'backend/setting/router', $data);
    }



    public function editRouter()

    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->editRouter($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data router berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/router') . "'; </script>";
    }

    public function terms()
    {
        $data['title'] = 'Syarat dan Ketentuan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/setting/terms', $data);
    }
    public function policy()
    {
        $data['title'] = 'Kebijakan Privasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/setting/policy', $data);
    }
    public function editterms()
    {
        $terms = $this->input->post('terms');
        $this->db->set('terms', $terms);
        $this->db->update('company');
        $this->session->set_flashdata('success-sweet', 'Syarat dan ketentuan sudah diperbaharui.
      ');
        redirect('setting/terms');
    }
    public function editpolicy()
    {
        $policy = $this->input->post('policy');
        $this->db->set('policy', $policy);
        $this->db->update('company');
        $this->session->set_flashdata('success-sweet', 'Kebijakan privasi sudah diperbaharui.
      ');
        redirect('setting/policy');
    }


    // BOT TELEGRAM

    public function bottelegram()
    {
        $data['title'] = 'Bot Telegram';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['bot'] = $this->db->get('bot_telegram')->row_array();
        $this->template->load('backend', 'backend/setting/bot-telegram', $data);
    }
    public function editbottelegram()
    {
        $post = $this->input->post(null, TRUE);
        $this->setting_m->editbottelegram($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Bot berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('setting/bottelegram') . "'; </script>";
    }

    public function setWebhookTelegram()
    {
        $bot = $this->db->get('bot_telegram')->row_array();
        $token = $bot['token'];
        $url = 'https://api.telegram.org/bot' . $token . '/setWebhook?url=' . base_url() . '/mywifibot.php';

        $header = array(
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $hasil =  json_decode($result, true);
        if ($hasil['ok'] == true) {
            $this->session->set_flashdata('success-sweet', $hasil['description']);
        } else {
            $this->session->set_flashdata('error-sweet', $hasil['description']);
        }
        redirect('setting/bottelegram');
    }
    public function delWebhookTelegram()
    {
        $bot = $this->db->get('bot_telegram')->row_array();
        $token = $bot['token'];
        $url = 'https://api.telegram.org/bot' . $token . '/deleteWebhook?url=' . base_url() . '/mywifibot.php';

        $header = array(
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $hasil =  json_decode($result, true);
        if ($hasil['ok'] == true) {
            $this->session->set_flashdata('success-sweet', $hasil['description']);
        } else {
            $this->session->set_flashdata('error-sweet', $hasil['description']);
        }
        redirect('setting/bottelegram');
    }
    public function schedule()
    {
        $data['title'] = 'Schedule';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['other'] = $this->db->get('other')->row_array();
        $this->template->load('backend', 'backend/setting/schedule', $data);
    }
    public function setschedule()
    {
        $post = $this->input->post(null, TRUE);
        $this->db->set('date_create', $post['date_create']);
        $this->db->set('sch_createbill', $post['sch_createbill']);

        $this->db->update('other');

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data berhasil diperbaharui');
        }
        redirect('setting/schedule');
    }
}
