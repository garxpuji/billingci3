<?php defined('BASEPATH') or exit('No direct script access allowed');

class Modem extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['logs_m', 'member_m']);
    }
    public function index()
    {
       \
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['show_modem'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $data['title'] = 'Modem';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['modem'] = $this->db->get('modem')->result();
        $this->template->load('backend', 'backend/modem/modem', $data);
    }
    public function customer()
    {
       
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['show_modem'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $data['title'] = 'Customer Modem';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['modem'] = $this->member_m->getmodemcustomer()->result();
        $this->template->load('backend', 'backend/modem/modem', $data);
    }

    public function add()
    {
        $post = $this->input->post(null, TRUE);
        $params = [
            'name' => $post['name'],
            'type' => $post['type'],
            'ip_local' => $post['ip_local'],
            'ip_public' => $post['ip_public'],
            'ssid_name' => $post['ssid_name'],
            'ssid_password' => $post['ssid_password'],
            'login_user' => $post['login_user'],
            'login_password' => $post['login_password'],
            'remark' => $post['remark'],
            'created' => time(),
            'createby' => $this->session->userdata('id'),
        ];
        if ($post['type'] == 1) {
            $params['customer_id'] = $post['customer_id'];
            $params['show_customer']  = $post['show_customer'];
        }
        $this->db->insert('modem', $params);
        if ($this->db->affected_rows() > 0) {
            $message = 'Tambah data Modem ';
            $this->logs_m->activitylogs('Activity', $message);
            $this->session->set_flashdata('success', 'Modem berhasil disimpan');
        }
        redirect('modem');
    }
    public function edit($id)
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['edit_modem'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $data['title'] = 'Edit Modem';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['modem'] = $this->db->get_where('modem', ['id' => $id])->row_array();
        $this->template->load('backend', 'backend/modem/edit-modem', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $params = [
            'name' => $post['name'],
            'type' => $post['type'],
            'ip_local' => $post['ip_local'],
            'ip_public' => $post['ip_public'],
            'ssid_name' => $post['ssid_name'],
            'ssid_password' => $post['ssid_password'],
            'login_user' => $post['login_user'],
            'login_password' => $post['login_password'],
            'remark' => $post['remark'],
            'created' => time(),
            'createby' => $this->session->userdata('id'),
        ];
        if ($post['type'] == 1) {
            $params['customer_id'] = $post['customer_id'];
            $params['show_customer']  = $post['show_customer'];
        }

        $this->db->where('id', $post['id']);
        $this->db->update('modem', $params);
        if ($this->db->affected_rows() > 0) {
            $message = 'Edit data Modem ';
            $this->logs_m->activitylogs('Activity', $message);
            $this->session->set_flashdata('success', 'Modem berhasil diperbaharui');
        }
        redirect('modem');
    }
    public function delete()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['del_modem'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('modem');

        if ($this->db->affected_rows() > 0) {
            $message = 'Hapus data Modem ';
            $this->logs_m->activitylogs('Activity', $message);
            $this->session->set_flashdata('success', 'Modem berhasil dihapus');
        }

        redirect('modem');
    }
}
