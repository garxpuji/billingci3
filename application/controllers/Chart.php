<?php defined('BASEPATH') or exit('No direct script access allowed');

class Chart extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m']);
    }
    public function index()
    {
        $data['title'] = 'Chart';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/chart/data', $data);
    }
    public function getchart()
    {
        $chart = $this->db->get('customer_chart')->result();
        $line = $this->db->get('customer_line')->result();

        $company = $this->db->get('company')->row_array();
        $comp = [];

        array_push(
            $comp,
            array(
                'id' => $company['id'],
                'text' => 'Server',
                'title' => $company['company_name'],
                'img' => base_url('assets/images/' . $company['logo']),
                "width" => "350",
                "height" => "100",
                "dir" => "horizontal",

            )
        );

        $rows = [];
        foreach ($line as $c => $row) {
            $cs = $this->db->get_where('customer', ['customer_id' => $row->customer_id])->row_array();
            $user = $this->db->get_where('user', ['email' => $cs['email']])->row_array();
            array_push(
                $rows,
                array(
                    'id' => $row->customer_id,
                    'text' => $cs['mode_user'] . ' - ' . $cs['user_mikrotik'],
                    'title' => $cs['name'],
                    'img' => base_url('assets/images/profile/' . $user['image']),
                    "width" => "350",
                    "height" => "100",
                    "dir" => $row->dir,

                )
            );
        }


        $rows2 = [];
        foreach ($chart as $c => $row) {
            array_push(
                $rows2,
                array(
                    'id' => $row->id_chart,
                    'from' => $row->fromcs,
                    'to' => $row->tocs,
                    'type' => 'line',
                )
            );
        }

        print json_encode(array_merge($comp, $rows, $rows2));
    }


    public function addchart()
    {

        $post = $this->input->post(null, TRUE);
        $cekline = $this->db->get_where('customer_line', ['id_line' => $post['id_line'], 'customer_id' => $post['id_chart']])->row_array();
        $cekjalur = $this->db->get_where('customer_line', ['customer_id' => $post['id_chart']])->row_array();
        if ($post['id_line'] != 1) {
            $idline = $post['id_line'];
            $ceklagi = $this->db->get_where('customer_line', ['customer_id' => $idline])->row_array();
            if ($ceklagi == 0) {
                $this->session->set_flashdata('error-sweet', 'Bagan awal belum terhubung ke jalur lain / server');
            } else {
                if ($cekline > 0) {
                    $this->session->set_flashdata('error-sweet', 'Jalur tersebut sudah tersedia');
                } elseif ($cekjalur > 0) {
                    $this->session->set_flashdata('error-sweet', 'Jalur tujuan sudah terhubung ke jalur lain');
                } elseif ($post['id_line'] == $post['id_chart']) {
                    $this->session->set_flashdata('error-sweet', 'Tidak bisa ke jalur sendiri');
                } else {
                    $paramsline = [
                        'id_line' => $post['id_line'],
                        'customer_id' => $post['id_chart'],
                        'width' => 350,
                        'height' => 100,
                        'dir' => $post['dir'],
                    ];
                    $this->db->insert('customer_line', $paramsline);
                    $paramschart = [
                        'id_chart' => $post['id_line'] . '-' . $post['id_chart'],
                        'fromcs' => $post['id_line'],
                        'tocs' => $post['id_chart'],
                        'type' => 'line',
                    ];
                    $this->db->insert('customer_chart', $paramschart);
                    $this->session->set_flashdata('success-sweet', 'Berhasil');
                }
            }
        } else {
            if ($cekline > 0) {
                $this->session->set_flashdata('error-sweet', 'Jalur tersebut sudah tersedia');
            } elseif ($cekjalur > 0) {
                $this->session->set_flashdata('error-sweet', 'Jalur tujuan sudah terhubung ke jalur lain');
            } elseif ($post['id_line'] == $post['id_chart']) {
                $this->session->set_flashdata('error-sweet', 'Tidak bisa ke jalur sendiri');
            } else {
                $paramsline = [
                    'id_line' => $post['id_line'],
                    'customer_id' => $post['id_chart'],
                    'width' => 350,
                    'height' => 100,
                    'dir' => $post['dir'],
                ];
                $this->db->insert('customer_line', $paramsline);
                $paramschart = [
                    'id_chart' => $post['id_line'] . '-' . $post['id_chart'],
                    'fromcs' => $post['id_line'],
                    'tocs' => $post['id_chart'],
                    'type' => 'line',
                ];
                $this->db->insert('customer_chart', $paramschart);
                $this->session->set_flashdata('success-sweet', 'Berhasil');
            }
        }
        // var_dump($post['id_line']);
        // var_dump($post['id_chart']);
        // var_dump($cekline);
        // var_dump($ceklagi);
        // die;



        redirect('chart');
    }

    public function delchart($id)
    {
        $line = $this->db->get_where('customer_line', ['id' => $id])->row_array();
        $cekline = $this->db->get_where('customer_line', ['id_line' => $line['customer_id']])->row_array();
        if ($cekline > 0) {
            $this->session->set_flashdata('error-sweet', 'Gagal Hapus, masih ada pelanggan yang berada di bagan ini');
        } else {
            // DEL Chart
            $this->db->where('id_chart', $line['id_line'] . '-' . $line['customer_id']);
            $this->db->delete('customer_chart');
            // DEL Line
            $this->db->where('id', $id);
            $this->db->delete('customer_line');
            $this->session->set_flashdata('success-sweet', 'Bagan berhasil dihapus');
        }

        redirect('chart');
    }

    public function customer($id)
    {
        $data['title'] = 'Chart';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $data['line'] =  $this->db->get_where('customer_line', ['id_line' => $id])->result();
        $this->template->load('backend', 'backend/chart/customer', $data);
    }
    public function getchartcustomer($id)
    {
        $cs = $this->db->get_where('customer', ['customer_id' => $id])->result();
        $chart = $this->db->get_where('customer_chart', ['fromcs' => $id])->result();
        $line = $this->db->get_where('customer_line', ['id_line' => $id])->result();
        // var_dump($cs);
        // die;
        $company = $this->db->get('company')->row_array();
        $comp = [];

        array_push(
            $comp,
            array(
                'id' => 201,
                'text' => 'Server',
                'title' => 'GG',
                'img' => base_url('assets/images/' . $company['logo']),
                "width" => "350",
                "height" => "100",
                "dir" => "horizontal",

            )
        );

        $rows = [];
        foreach ($line as $c => $row) {
            $cs = $this->db->get_where('customer', ['customer_id' => $row->customer_id])->row_array();
            $user = $this->db->get_where('user', ['email' => $cs['email']])->row_array();
            array_push(
                $rows,
                array(
                    'id' => $row->customer_id,
                    'text' => $cs['mode_user'] . ' - ' . $cs['user_mikrotik'],
                    'title' => $cs['name'],
                    'img' => base_url('assets/images/profile/' . $user['image']),
                    "width" => "350",
                    "height" => "100",
                    "dir" => $row->dir,

                )
            );
        }


        $rows2 = [];
        foreach ($chart as $c => $row) {
            array_push(
                $rows2,
                array(
                    'id' => $row->id_chart,
                    'from' => $row->fromcs,
                    'to' => $row->tocs,
                    'type' => 'line',
                )
            );
        }

        print json_encode(array_merge($comp, $rows, $rows2));
    }
}
