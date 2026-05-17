<?php defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m', 'package_m', 'services_m']);
    }
    public function index()
    {
    }
    public function detail($no_services)
    {

        $services = $this->services_m->getServices($no_services)->result();
        $customer = $this->db->get_where('customer', ['no_services' => $no_services])->row_array();

        $this->fixamount($no_services);

        foreach ($services as $item) {
            $cekitem = $this->services_m->cekdoubleitem($no_services, $item->item_id)->num_rows();
            if ($cekitem > 1) {
                $lastitem = $this->services_m->cekdoubleitem($no_services, $item->item_id)->row_array();
                $this->db->where('services_id', $lastitem['services_id']);
                $this->db->delete('services');
            }
        }

        $data['title'] = 'Services List';
        $data['p_item'] = $this->package_m->getPItem()->result();
        $data['services'] = $this->services_m->getServices($no_services);
        if ($no_services == 0) {
            $this->session->set_flashdata('error-sweet', 'No layanan belum di setting');
            redirect('customer');
        }
        $query  = $this->customer_m->getNSCustomer($no_services);
        if ($query->num_rows() > 0) {
            $data['customer'] = $query->row();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        } else {
            echo "<script> alert ('Data tidak ditemukan');";
            echo "window.location='" . site_url('customer') . "'; </script>";
        }
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/customer/services/list', $data);
    }

    public function add($no_services)
    {
        $post = $this->input->post(null, TRUE);
        $cekitem = $this->services_m->cekdoubleitem($no_services, $post['item_id'])->row_array();
        if ($cekitem > 0) {
            $this->session->set_flashdata('error-sweet', 'Gagal, Item sudah ada');
        } else {
            $this->services_m->add($post);
            if ($this->db->affected_rows() > 0) {
                $this->fixamount($no_services);
                $this->session->set_flashdata('success-sweet', 'Daftar layanan berhasil ditambahkan');
            }
        }

        echo "<script>window.location='" . site_url('services/detail/' . $no_services) . "'; </script>";
    }
    public function edit()
    {
        $no_services = $this->input->post('no_services');
        $post = $this->input->post(null, TRUE);
        $this->services_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->fixamount($no_services);
            $this->session->set_flashdata('success-sweet', 'Item layanan berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('services/detail/' . $no_services) . "'; </script>";
    }

    public function delete()
    {
        $no_services = $this->input->post('no_services');
        $services_id = $this->input->post('services_id');
        $this->services_m->delete($services_id);
        if ($this->db->affected_rows() > 0) {
            $this->fixamount($no_services);
            $this->session->set_flashdata('success', 'Item layanan berhasil dihapus');
        }
        echo "<script>window.location='" . site_url('services/detail/' . $no_services) . "'; </script>";
    }

    private function fixamount($no_services)
    {
        $list = $this->services_m->getServices($no_services)->result();
        $amount = 0;
        foreach ($list as $item) {
            $amount  += (int) $item->total;
        }

        $customer = $this->db->get_where('customer', ['no_services' => $no_services])->row_array();
        $company = $this->db->get('company')->row_array();
        if ($customer['ppn'] == 1) {
            $fixamount = $amount + $amount * ($company['ppn'] / 100);
        } else {
            $fixamount = $amount;
        }

        $this->db->set('cust_amount', $fixamount);
        $this->db->where('no_services', $no_services);
        $this->db->update('customer');
    }
}
