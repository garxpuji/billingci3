<?php defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    private function role()
    {
        $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array();
        return $role;
    }
    public function index()
    {
        is_logged_in();
        $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        if ($this->session->userdata('role_id') == 1 or $menu['role_access'] == 1) {
            $data['title'] = 'Role';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['company'] = $this->db->get('company')->row_array();
            $this->template->load('backend', 'backend/role/role', $data);
        } else {
            $this->session->set_flashdata('error-sweet', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    private function _update()
    {
        $post = $this->input->post(null, TRUE);
        if (!empty($post['show_saldo'])) {
            $this->db->set('show_saldo', 1);
        } else {
            $this->db->set('show_saldo', 0);
        }
        //    MENU CUSTOMER 
        if (!empty($post['add_customer'])) {
            $this->db->set('add_customer', 1);
        } else {
            $this->db->set('add_customer', 0);
        }
        if (!empty($post['edit_customer'])) {
            $this->db->set('edit_customer', 1);
        } else {
            $this->db->set('edit_customer', 0);
        }
        if (!empty($post['del_customer'])) {
            $this->db->set('del_customer', 1);
        } else {
            $this->db->set('del_customer', 0);
        }

        // Menu Paket
        if (!empty($post['add_item'])) {
            $this->db->set('add_item', 1);
        } else {
            $this->db->set('add_item', 0);
        }
        if (!empty($post['edit_item'])) {
            $this->db->set('edit_item', 1);
        } else {
            $this->db->set('edit_item', 0);
        }
        if (!empty($post['del_item'])) {
            $this->db->set('del_item', 1);
        } else {
            $this->db->set('del_item', 0);
        }

        // Menu Tagihan
        if (!empty($post['add_bill'])) {
            $this->db->set('add_bill', 1);
        } else {
            $this->db->set('add_bill', 0);
        }
        if (!empty($post['edit_bill'])) {
            $this->db->set('edit_bill', 1);
        } else {
            $this->db->set('edit_bill', 0);
        }
        if (!empty($post['del_bill'])) {
            $this->db->set('del_bill', 1);
        } else {
            $this->db->set('del_bill', 0);
        }

        // Menu Tagihan
        if (!empty($post['add_income'])) {
            $this->db->set('add_income', 1);
        } else {
            $this->db->set('add_income', 0);
        }
        if (!empty($post['edit_income'])) {
            $this->db->set('edit_income', 1);
        } else {
            $this->db->set('edit_income', 0);
        }
        if (!empty($post['del_income'])) {
            $this->db->set('del_income', 1);
        } else {
            $this->db->set('del_income', 0);
        }

        // Menu Coverage
        if (!empty($post['add_coverage'])) {
            $this->db->set('add_coverage', 1);
        } else {
            $this->db->set('add_coverage', 0);
        }
        if (!empty($post['edit_coverage'])) {
            $this->db->set('edit_coverage', 1);
        } else {
            $this->db->set('edit_coverage', 0);
        }
        if (!empty($post['del_coverage'])) {
            $this->db->set('del_coverage', 1);
        } else {
            $this->db->set('del_coverage', 0);
        }
        if (!empty($post['coverage_operator'])) {
            $this->db->set('coverage_operator', 1);
        } else {
            $this->db->set('coverage_operator', 0);
        }
        // Menu Slide
        if (!empty($post['add_slide'])) {
            $this->db->set('add_slide', 1);
        } else {
            $this->db->set('add_slide', 0);
        }
        if (!empty($post['edit_slide'])) {
            $this->db->set('edit_slide', 1);
        } else {
            $this->db->set('edit_slide', 0);
        }
        if (!empty($post['del_slide'])) {
            $this->db->set('del_slide', 1);
        } else {
            $this->db->set('del_slide', 0);
        }
        // Menu Product
        if (!empty($post['add_product'])) {
            $this->db->set('add_product', 1);
        } else {
            $this->db->set('add_product', 0);
        }
        if (!empty($post['edit_product'])) {
            $this->db->set('edit_product', 1);
        } else {
            $this->db->set('edit_product', 0);
        }
        if (!empty($post['del_product'])) {
            $this->db->set('del_product', 1);
        } else {
            $this->db->set('del_product', 0);
        }
        // Menu Router
        if (!empty($post['add_router'])) {
            $this->db->set('add_router', 1);
        } else {
            $this->db->set('add_router', 0);
        }
        if (!empty($post['edit_router'])) {
            $this->db->set('edit_router', 1);
        } else {
            $this->db->set('edit_router', 0);
        }
        if (!empty($post['del_router'])) {
            $this->db->set('del_router', 1);
        } else {
            $this->db->set('del_router', 0);
        }
        // Menu Pengguna
        if (!empty($post['add_user'])) {
            $this->db->set('add_user', 1);
        } else {
            $this->db->set('add_user', 0);
        }
        if (!empty($post['edit_user'])) {
            $this->db->set('edit_user', 1);
        } else {
            $this->db->set('edit_user', 0);
        }
        if (!empty($post['del_user'])) {
            $this->db->set('del_user', 1);
        } else {
            $this->db->set('del_user', 0);
        }
        // Menu Bantuan
        if (!empty($post['add_help'])) {
            $this->db->set('add_help', 1);
        } else {
            $this->db->set('add_help', 0);
        }
        if (!empty($post['edit_help'])) {
            $this->db->set('edit_help', 1);
        } else {
            $this->db->set('edit_help', 0);
        }
        if (!empty($post['del_help'])) {
            $this->db->set('del_help', 1);
        } else {
            $this->db->set('del_help', 0);
        }
    }
    public function updateoperator()
    {
        $this->_update();
        $this->db->where('role_id', 3);
        $this->db->update('role_management');
        $this->session->set_flashdata('success-sweet', 'Role Akses Operator Berhasil diperbaharui');
        redirect('role');
    }
    public function updatemitra()
    {
        $this->_update();
        $this->db->where('role_id', 4);
        $this->db->update('role_management');
        $this->session->set_flashdata('success-sweet', 'Role Akses Mitra Berhasil diperbaharui');
        redirect('role');
    }
    public function updateteknisi()
    {
        $this->_update();
        $this->db->where('role_id', 5);
        $this->db->update('role_management');
        $this->session->set_flashdata('success-sweet', 'Role Akses Teknisi Berhasil diperbaharui');
        redirect('role');
    }
    public function updateoutlet()
    {
        $this->_update();
        $this->db->where('role_id', 6);
        $this->db->update('role_management');
        $this->session->set_flashdata('success-sweet', 'Role Akses Outlet Berhasil diperbaharui');
        redirect('role');
    }
    public function updatekolektor()
    {
        $this->_update();
        $this->db->where('role_id', 7);
        $this->db->update('role_management');
        $this->session->set_flashdata('success-sweet', 'Role Akses Kolektor Berhasil diperbaharui');
        redirect('role');
    }
    public function updatefinance()
    {
        $this->_update();
        $this->db->where('role_id', 8);
        $this->db->update('role_management');
        $this->session->set_flashdata('success-sweet', 'Role Akses Finance Berhasil diperbaharui');
        redirect('role');
    }



    public function updaterolepelanggan()
    {
        $post = $this->input->post(null, TRUE);
        $this->db->set('show_usage', $post['show_usage']);
        $this->db->set('show_history', $post['show_history']);
        $this->db->set('cek_bill', $post['cek_bill']);
        $this->db->set('cek_usage', $post['cek_usage']);
        $this->db->set('show_speedtest', $post['show_speedtest']);
        $this->db->set('show_log', $post['show_log']);
        $this->db->set('show_help', $post['show_help']);
        $this->db->set('show_bill', $post['show_bill']);
        $this->db->set('register_maps', $post['register_maps']);
        $this->db->set('register_coverage', $post['register_coverage']);
        $this->db->set('register_show', $post['register_show']);
        $this->db->where('role_id', 2);
        $this->db->update('role_management');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data pelanggan berhasil diperbaharui');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function menu()
    {
        $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        if ($this->session->userdata('role_id') == 1 or $menu['role_menu'] == 1) {
            $data['title'] = 'Role Menu';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['company'] = $this->db->get('company')->row_array();
            $this->template->load('backend', 'backend/role/menu', $data);
        } else {
            $this->session->set_flashdata('error-sweet', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    private function _updatemenu()
    {
        $post = $this->input->post(null, TRUE);
        //    MENU CUSTOMER 
        if (!empty($post['customer_add'])) {
            $this->db->set('customer_add', 1);
        } else {
            $this->db->set('customer_add', 0);
        }
        if (!empty($post['customer_menu'])) {
            $this->db->set('customer_menu', 1);
        } else {
            $this->db->set('customer_menu', 0);
        }

        if (!empty($post['customer_non_active'])) {
            $this->db->set('customer_non_active', 1);
        } else {
            $this->db->set('customer_non_active', 0);
        }
        if (!empty($post['customer_active'])) {
            $this->db->set('customer_active', 1);
        } else {
            $this->db->set('customer_active', 0);
        }
        if (!empty($post['customer_waiting'])) {
            $this->db->set('customer_waiting', 1);
        } else {
            $this->db->set('customer_waiting', 0);
        }
        if (!empty($post['customer_free'])) {
            $this->db->set('customer_free', 1);
        } else {
            $this->db->set('customer_free', 0);
        }
        if (!empty($post['customer_isolir'])) {
            $this->db->set('customer_isolir', 1);
        } else {
            $this->db->set('customer_isolir', 0);
        }
        if (!empty($post['customer_whatsapp'])) {
            $this->db->set('customer_whatsapp', 1);
        } else {
            $this->db->set('customer_whatsapp', 0);
        }
        if (!empty($post['customer_maps'])) {
            $this->db->set('customer_maps', 1);
        } else {
            $this->db->set('customer_maps', 0);
        }
        if (!empty($post['customer'])) {
            $this->db->set('customer', 1);
        } else {
            $this->db->set('customer', 0);
        }


        // MENU COVERAGE
        if (!empty($post['coverage_add'])) {
            $this->db->set('coverage_add', 1);
        } else {
            $this->db->set('coverage_add', 0);
        }
        if (!empty($post['coverage_menu'])) {
            $this->db->set('coverage_menu', 1);
        } else {
            $this->db->set('coverage_menu', 0);
        }
        if (!empty($post['coverage'])) {
            $this->db->set('coverage', 1);
        } else {
            $this->db->set('coverage', 0);
        }
        if (!empty($post['coverage_maps'])) {
            $this->db->set('coverage_maps', 1);
        } else {
            $this->db->set('coverage_maps', 0);
        }



        // MENU LAYANAN
        if (!empty($post['services_menu'])) {
            $this->db->set('services_menu', 1);
        } else {
            $this->db->set('services_menu', 0);
        }
        if (!empty($post['services_item'])) {
            $this->db->set('services_item', 1);
        } else {
            $this->db->set('services_item', 0);
        }
        if (!empty($post['services_category'])) {
            $this->db->set('services_category', 1);
        } else {
            $this->db->set('services_category', 0);
        }

        // MENU TAGIHAN
        if (!empty($post['bill'])) {
            $this->db->set('bill', 1);
        } else {
            $this->db->set('bill', 0);
        }
        if (!empty($post['bill_menu'])) {
            $this->db->set('bill_menu', 1);
        } else {
            $this->db->set('bill_menu', 0);
        }
        if (!empty($post['bill_unpaid'])) {
            $this->db->set('bill_unpaid', 1);
        } else {
            $this->db->set('bill_unpaid', 0);
        }
        if (!empty($post['bill_paid'])) {
            $this->db->set('bill_paid', 1);
        } else {
            $this->db->set('bill_paid', 0);
        }
        if (!empty($post['bill_due_date'])) {
            $this->db->set('bill_due_date', 1);
        } else {
            $this->db->set('bill_due_date', 0);
        }
        if (!empty($post['bill_draf'])) {
            $this->db->set('bill_draf', 1);
        } else {
            $this->db->set('bill_draf', 0);
        }
        if (!empty($post['bill_debt'])) {
            $this->db->set('bill_debt', 1);
        } else {
            $this->db->set('bill_debt', 0);
        }
        if (!empty($post['bill_confirm'])) {
            $this->db->set('bill_confirm', 1);
        } else {
            $this->db->set('bill_confirm', 0);
        }
        if (!empty($post['bill_code_coupon'])) {
            $this->db->set('bill_code_coupon', 1);
        } else {
            $this->db->set('bill_code_coupon', 0);
        }
        if (!empty($post['bill_history'])) {
            $this->db->set('bill_history', 1);
        } else {
            $this->db->set('bill_history', 0);
        }
        if (!empty($post['bill_delete'])) {
            $this->db->set('bill_delete', 1);
        } else {
            $this->db->set('bill_delete', 0);
        }
        if (!empty($post['bill_send'])) {
            $this->db->set('bill_send', 1);
        } else {
            $this->db->set('bill_send', 0);
        }

        // MENU KEUANGAN

        if (!empty($post['finance_menu'])) {
            $this->db->set('finance_menu', 1);
        } else {
            $this->db->set('finance_menu', 0);
        }
        if (!empty($post['finance_income'])) {
            $this->db->set('finance_income', 1);
        } else {
            $this->db->set('finance_income', 0);
        }
        if (!empty($post['finance_expend'])) {
            $this->db->set('finance_expend', 1);
        } else {
            $this->db->set('finance_expend', 0);
        }
        if (!empty($post['finance_report'])) {
            $this->db->set('finance_report', 1);
        } else {
            $this->db->set('finance_report', 0);
        }

        // MENU BANTUAN
        if (!empty($post['help_menu'])) {
            $this->db->set('help_menu', 1);
        } else {
            $this->db->set('help_menu', 0);
        }
        if (!empty($post['help'])) {
            $this->db->set('help', 1);
        } else {
            $this->db->set('help', 0);
        }
        if (!empty($post['help_category'])) {
            $this->db->set('help_category', 1);
        } else {
            $this->db->set('help_category', 0);
        }

        // MENU ROUTER
        if (!empty($post['router_menu'])) {
            $this->db->set('router_menu', 1);
        } else {
            $this->db->set('router_menu', 0);
        }
        if (!empty($post['router'])) {
            $this->db->set('router', 1);
        } else {
            $this->db->set('router', 0);
        }
        if (!empty($post['router_customer'])) {
            $this->db->set('router_customer', 1);
        } else {
            $this->db->set('router_customer', 0);
        }
        if (!empty($post['router_schedule'])) {
            $this->db->set('router_schedule', 1);
        } else {
            $this->db->set('router_schedule', 0);
        }

        // MENU WEBSITE
        if (!empty($post['website_menu'])) {
            $this->db->set('website_menu', 1);
        } else {
            $this->db->set('website_menu', 0);
        }
        if (!empty($post['website_slide'])) {
            $this->db->set('website_slide', 1);
        } else {
            $this->db->set('website_slide', 0);
        }
        if (!empty($post['website_product'])) {
            $this->db->set('website_product', 1);
        } else {
            $this->db->set('website_product', 0);
        }

        // MENU PENGGUNA
        if (!empty($post['user_menu'])) {
            $this->db->set('user_menu', 1);
        } else {
            $this->db->set('user_menu', 0);
        }
        if (!empty($post['user_add'])) {
            $this->db->set('user_add', 1);
        } else {
            $this->db->set('user_add', 0);
        }
        if (!empty($post['user_admin'])) {
            $this->db->set('user_admin', 1);
        } else {
            $this->db->set('user_admin', 0);
        }
        if (!empty($post['user_operator'])) {
            $this->db->set('user_operator', 1);
        } else {
            $this->db->set('user_operator', 0);
        }
        if (!empty($post['user_teknisi'])) {
            $this->db->set('user_teknisi', 1);
        } else {
            $this->db->set('user_teknisi', 0);
        }
        if (!empty($post['user_customer'])) {
            $this->db->set('user_customer', 1);
        } else {
            $this->db->set('user_customer', 0);
        }
        if (!empty($post['user_mitra'])) {
            $this->db->set('user_mitra', 1);
        } else {
            $this->db->set('user_mitra', 0);
        }
        if (!empty($post['user_outlet'])) {
            $this->db->set('user_outlet', 1);
        } else {
            $this->db->set('user_outlet', 0);
        }
        if (!empty($post['user'])) {
            $this->db->set('user', 1);
        } else {
            $this->db->set('user', 0);
        }

        // MENU Role
        if (!empty($post['role_menu'])) {
            $this->db->set('role_menu', 1);
        } else {
            $this->db->set('role_menu', 0);
        }
        if (!empty($post['role_sub_menu'])) {
            $this->db->set('role_sub_menu', 1);
        } else {
            $this->db->set('role_sub_menu', 0);
        }
        if (!empty($post['role_access'])) {
            $this->db->set('role_access', 1);
        } else {
            $this->db->set('role_access', 0);
        }






        // MENU Integrasi
        if (!empty($post['integration_menu'])) {
            $this->db->set('integration_menu', 1);
        } else {
            $this->db->set('integration_menu', 0);
        }
        if (!empty($post['integration_whatsapp'])) {
            $this->db->set('integration_whatsapp', 1);
        } else {
            $this->db->set('integration_whatsapp', 0);
        }
        if (!empty($post['integration_email'])) {
            $this->db->set('integration_email', 1);
        } else {
            $this->db->set('integration_email', 0);
        }
        if (!empty($post['integration_payment_gateway'])) {
            $this->db->set('integration_payment_gateway', 1);
        } else {
            $this->db->set('integration_payment_gateway', 0);
        }
        if (!empty($post['integration_sms'])) {
            $this->db->set('integration_sms', 1);
        } else {
            $this->db->set('integration_sms', 0);
        }
        if (!empty($post['integration_telegram'])) {
            $this->db->set('integration_telegram', 1);
        } else {
            $this->db->set('integration_telegram', 0);
        }
        if (!empty($post['integration_olt'])) {
            $this->db->set('integration_olt', 1);
        } else {
            $this->db->set('integration_olt', 0);
        }
        if (!empty($post['integration_radius'])) {
            $this->db->set('integration_radius', 1);
        } else {
            $this->db->set('integration_radius', 0);
        }


        //  // MENU Pengaturan
        if (!empty($post['setting_menu'])) {
            $this->db->set('setting_menu', 1);
        } else {
            $this->db->set('setting_menu', 0);
        }
        if (!empty($post['setting_company'])) {
            $this->db->set('setting_company', 1);
        } else {
            $this->db->set('setting_company', 0);
        }
        if (!empty($post['setting_about_company'])) {
            $this->db->set('setting_about_company', 1);
        } else {
            $this->db->set('setting_about_company', 0);
        }
        if (!empty($post['setting_bank_account'])) {
            $this->db->set('setting_bank_account', 1);
        } else {
            $this->db->set('setting_bank_account', 0);
        }
        if (!empty($post['setting_terms_condition'])) {
            $this->db->set('setting_terms_condition', 1);
        } else {
            $this->db->set('setting_terms_condition', 0);
        }
        if (!empty($post['setting_privacy_policy'])) {
            $this->db->set('setting_privacy_policy', 1);
        } else {
            $this->db->set('setting_privacy_policy', 0);
        }
        if (!empty($post['setting_logs'])) {
            $this->db->set('setting_logs', 1);
        } else {
            $this->db->set('setting_logs', 0);
        }
        if (!empty($post['setting_backup'])) {
            $this->db->set('setting_backup', 1);
        } else {
            $this->db->set('setting_backup', 0);
        }
        if (!empty($post['setting_other'])) {
            $this->db->set('setting_other', 1);
        } else {
            $this->db->set('setting_other', 0);
        }
    }

    public function updatemenuoperator()
    {

        $this->_updatemenu();
        $this->db->where('role_id', 3);
        $this->db->update('role_menu');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data menu operator berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function updatemenumitra()
    {

        $this->_updatemenu();
        $this->db->where('role_id', 4);
        $this->db->update('role_menu');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data menu Mitra berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function updatemenuteknisi()
    {

        $this->_updatemenu();
        $this->db->where('role_id', 5);
        $this->db->update('role_menu');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data menu Teknisi berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function updatemenuoutlet()
    {

        $this->_updatemenu();
        $this->db->where('role_id', 6);
        $this->db->update('role_menu');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data menu outlet berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function updatemenukolektor()
    {

        $this->_updatemenu();
        $this->db->where('role_id', 7);
        $this->db->update('role_menu');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data menu kolektor berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function updatemenufinance()
    {

        $this->_updatemenu();
        $this->db->where('role_id', 8);
        $this->db->update('role_menu');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Data menu finance berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}
