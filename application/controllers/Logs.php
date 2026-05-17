<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['logs_m']);
    }
    public function index()
    {
        $data['title'] = 'Logs';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['logs'] = $this->logs_m->get()->result();
        $this->template->load('backend', 'backend/logs/data', $data);
    }
    public function del($id)
    {
        $this->db->where('log_id', $id);
        $this->db->delete('logs');
        redirect('logs');
    }
}
