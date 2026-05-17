<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Customer extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['customer_m']);
    }

    public function index_get()
    {
        $email = $this->input->get('email');
        $customer = $this->db->get_where('customer', ['email' => $email])->row_array();
        if ($customer > 0) {
            $data = [
                'id' => $customer['customer_id'],
                'no_services' => $customer['no_services'],
                'email' => $customer['email'],
                'name' => $customer['name'],
                'register_date' => $customer['register_date'],
                'due_date' => $customer['due_date'],
                'ppn' => $customer['ppn'],
                'status' => $customer['c_status'],
                'phone' => indo_tlp($customer['no_wa']),
                'user_mikrotik' => indo_tlp($customer['user_mikrotik']),
                'mode_user' => indo_tlp($customer['mode_user']),
            ];
            $this->set_response([
                'status' => true,
                'data' => $data,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => true,
                'message' => 'Data Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
