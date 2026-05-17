<?php
//==============================START=========================================//
/*
     *  Base Code   : Gingin Abdul Goni | Rosita Wulandari, S.Kom,.MTA
     *  Email       : ginginabdulgoni@gmail.com
     *  Instagram   : @ginginabdulgoni
     *  Telegram    : @ginginabdulgoni
     *
     *  Name        : My-Wifi
     *  Function    : Manage Client and Billing
     *  Manufacture : November 2021 
     *
     *  Please do not change this code
     *  All damage caused by editing we will not be responsible please think carefully,
     *
     */
//==============================START CODE=========================================//
?>
<?php defined('BASEPATH') or exit('No direct script access allowed');

class Maps extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model(['customer_m', 'services_m', 'bill_m', 'coverage_m']);
    }
    public function index()
    {
        $data['title'] = 'Maps';
        $data['company'] = $this->db->get('company')->row_array();
        $data['tes'] = $this->customer_m->getMaps()->result();
        $data['customer'] = $this->customer_m->unmaps()->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->template->load('backend', 'backend/maps/maps', $data);
    }
    public function set()
    {
        $post = $this->input->post(null, TRUE);

        $this->db->set('token', $post['token']);
        $this->db->set('vendor', $post['vendor']);
        $this->db->update('maps');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data Maps berhasil diperbaharui');
        }
        redirect('maps/setting');
    }
    public function setting()
    {
        $table = $this->db->get('maps')->row_array();
        if ($table == 0) {
            $params = [

                'token' => 'your token / api key',


            ];
            $this->db->insert('maps', $params);
            redirect('maps/setting');
        } else {
            $this->session->set_userdata('integration', 'maps');

            $data = [
                'title' => 'Maps',
                'maps' => $this->db->get('maps')->row_array(),
                'user' =>  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
                'company' =>  $this->db->get('company')->row_array(),
            ];
            $this->template->load('backend', 'backend/maps/setmaps', $data);
        }
    }

    public function getmaps()
    {
        $customer = $this->customer_m->getmaps()->result();


        foreach ($customer as $data) {
            $coverage = $this->db->get_where('coverage', ['coverage_id' => $data->coverage])->row_array();
            $odc = $this->db->get_where('m_odc', ['id_odc' => $data->id_odc])->row_array();
            $odp = $this->db->get_where('m_odp', ['id_odp' => $data->id_odp])->row_array();
            $getmaps = [
                'name' => $data->name,
                'no_services' => $data->no_services,
                'no_wa' => $data->no_wa,
                'address' => $data->address,
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
                'mode_user' => $data->mode_user,
                'user_mikrotik' => $data->user_mikrotik,
                'c_status' => $data->c_status,
                'coverage' => $coverage['c_name'],
                'odc' => $odc['code_odc'],
                'odp' => $odp['code_odp'] . ' | ' . $data->no_port_odp,
            ];
            $dataa[] = $getmaps;
        }
        echo json_encode($dataa);
    }
}
