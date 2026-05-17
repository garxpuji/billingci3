<?php defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['setting_m']);
    }
    public function index()
    {
        is_logged_in();
        $data['title'] = 'About My-Wifi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/about', $data);
    }
    public function about()
    {
        $data['title'] = 'Tentang Kami';
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('frontend', 'frontend/about', $data);
    }
    public function terms()
    {
        $data['title'] = 'Syarat dan Ketentuan';
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('frontend', 'frontend/terms', $data);
    }
    public function policy()
    {
        $data['title'] = 'Kebijakan Privasi';
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('frontend', 'frontend/policy', $data);
    }
    public function changelog()
    {
        $data['title'] = 'Changelog';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();

        $this->template->load('backend', 'backend/changelog', $data);
    }
}
