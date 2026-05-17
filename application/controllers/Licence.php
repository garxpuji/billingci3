<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Licence extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $licence = verify_license();
        $licence = json_decode($licence, true);
        if ($licence['status'] == 'macth') {
            is_logged_in();
        }
        if ($this->session->userdata('role_id') != 1) {
            redirect('front/maintenance');
        }
        $data['title'] = 'Licence';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/setting/licence', $data);
    }

    public function update()
    {
        $licence = verify_license();
        $licence = json_decode($licence, true);
        if ($licence['status'] == 'macth') {
            is_logged_in();
        }
        $post = $this->input->post(Null, TRUE);
        $this->db->set('licence', $post['licence']);
        $this->db->update('company');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Licence berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('licence') . "'; </script>";
    }
    public function renew()
    {
        $json = file_get_contents("php://input");
        renew($json);
    }
}
