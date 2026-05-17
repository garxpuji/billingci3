<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['customer_m']);
    }
    public function index_post()
    {
        $mode = $this->input->post('mode');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        if ($mode == 'phone') {
            $user = $this->db->get_where('user', ['phone' => $email])->row_array(); // select * where user email = email
        } else {
            $user = $this->db->get_where('user', ['email' => $email])->row_array(); // select * where user email = email
        }
        // user ada
        if ($user) {
            // jika user active
            if ($user['is_active'] == 1) {
                # cek password dan verifikasi dengan input
                if (password_verify($password, $user['password'])) {
                    # jika sama
                    $data = [
                        'login' => true,
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'role_id' => $user['role_id']
                    ];
                    $this->set_response([
                        'status' => true,
                        'data' => $data,
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                } else {
                    # jika tidak sama atau error
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Wrong password !'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User has not been activated'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            // jika tidak ada
            $this->response([
                'status' => FALSE,
                'message' => 'Email Not Found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function index_get()
    {
        $email = $this->input->get('email');
        $customer = $this->db->get_where('customer', ['email' => $email])->row_array();
        if ($customer > 0) {
            $data = [
                'id' => $customer['customer_id'],
                'email' => $customer['email'],
                'name' => $customer['name'],
            ];
            $this->set_response([
                'status' => true,
                'data' => $data,
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }
}
