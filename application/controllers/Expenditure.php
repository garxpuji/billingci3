<?php defined('BASEPATH') or exit('No direct script access allowed');

class expenditure extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['expenditure_m']);
    }


    public function index()
    {
        $data['title'] = 'Expenditure';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['expenditure'] = $this->expenditure_m->getexpenditure()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $data['category'] = $this->db->get('cat_expenditure')->result();
        $this->template->load('backend', 'backend/expenditure/expenditure', $data);
    }


    public function add()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['add_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $post = $this->input->post(null, TRUE);
        $this->expenditure_m->add($post);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('expenditure') . "'; </script>";
    }
    public function edit()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['edit_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $post = $this->input->post(null, TRUE);

        $this->expenditure_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('expenditure') . "'; </script>";
    }
    public function delete()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['del_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $expenditure_id = $this->input->post('expenditure_id');

        $this->expenditure_m->delete($expenditure_id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil dihapus');
        }
        echo "<script>window.location='" . site_url('expenditure') . "'; </script>";
    }
    public function printexpenditure()
    {
        $post = $this->input->post(null, TRUE);
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tanggal2'] = $this->input->post('tanggal2');
        $data['title'] = 'Invoice';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['income'] = $this->expenditure_m->getFilter($post)->result();
        $this->load->view('backend/expenditure/printexpenditure', $data);
    }
    public function delselected()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['del_income'] == 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $expenditure_id =  $_POST['expenditure_id'];
        if ($expenditure_id == null) {
            $this->session->set_flashdata('error', 'Belum ada yang dipilih');
        } else {
            $this->expenditure_m->deleteselected($expenditure_id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pengeluaran berhasil dihapus');
            }
        }
        redirect('expenditure');
    }
    // SERVER SIDE
    public function getDataExpend()
    {
        $result = $this->expenditure_m->getDataExpend();
        $data = [];
        $no = $_POST['start'];
        foreach ($result as $result) {
            $row = array();
            $row[] = ++$no;
            $row[] = '<input type=' . 'checkbox' . ' class=' . 'check-item' . ' id="ceklis" name=' . 'expenditure_id[]' . ' value=' . $result->expenditure_id . '>';
            $row[] = indo_date($result->date_payment);
            $row[] = indo_currency($result->nominal);
            $getcategory = $this->db->get_where('cat_expenditure', ['category_id' => $result->category])->row_array();
            if ($result->category != 0) {
                $row[] = $getcategory['name'];
            } else {
                $row[] = '';
            }
            $row[] = $result->remark;
            $row[] = '<a href="#" id="edit"  data-expenditure_id="' . $result->expenditure_id . '" data-nominal="' . $result->nominal . '" data-remark="' . $result->remark . '" data-date_payment="' . $result->date_payment . '" data-category="' . $result->category . '" title="Edit" data-toggle="modal" data-target="#Modaledit"><i class="fa fa-edit" style="font-size:25px"></i></a>
            <a  href="#" id="delete" data-toggle="modal" data-target="#Modaldelete" data-expenditure_id="' . $result->expenditure_id . '" data-nominal="' . indo_currency($result->nominal) . '" data-remark="' . $result->remark . '" data-date_payment="' . $result->date_payment . '" title="Delete"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->expenditure_m->count_all_data(),
            "recordsFiltered" => $this->expenditure_m->count_filtered_data(),
            "data" => $data,
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    // CATEGORY
    public function category()
    {
        $data['title'] = 'Expenditure Category';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['category'] = $this->db->get('cat_expenditure')->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/expenditure/cat_expenditure', $data);
    }
    public function addcategory()
    {
        $post = $this->input->post(null, TRUE);
        $this->expenditure_m->addcategory($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kategori pengeluaran berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('expenditure/category') . "'; </script>";
    }

    public function editcategory()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['edit_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $post = $this->input->post(null, TRUE);

        $this->expenditure_m->editcategory($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kategori pengeluaran berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('expenditure/category') . "'; </script>";
    }

    public function deletecategory()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['del_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $category_id = $this->input->post('category_id');
        $cekkategori = $this->db->get_where('expenditure', ['category' => $category_id])->row_array();
        if ($cekkategori > 0) {
            $this->session->set_flashdata('error', 'Kategori tidak dapat dihapus karena terdaftar di data pengeluaran');
        } else {
            # code...
            $this->expenditure_m->deletecategory($category_id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data kategori pengeluaran berhasil dihapus');
            }
        }

        echo "<script>window.location='" . site_url('expenditure/category') . "'; </script>";
    }
}
