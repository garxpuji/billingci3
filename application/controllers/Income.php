<?php
ob_start();

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

defined('BASEPATH') or exit('No direct script access allowed');

class Income extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model(['income_m', 'expenditure_m', 'bill_m', 'customer_m', 'user_m', 'setting_m']);
    }
    private function _menu()
    {
        $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        if ($menu == 0) {
            $params = [
                'role_id' => $this->session->userdata('role_id'),
            ];
            $this->db->insert('role_menu', $params);
        }
        return $menu;
    }
    private function _role()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        return $role;
    }
    private function _coverage()
    {
        $role = $this->_role();
        if ($role['role_id'] != 1 && $role['coverage_operator'] == 1) {
            $operator = $this->db->get_where('cover_operator', ['operator' => $this->session->userdata('id'), 'role_id' => $this->session->userdata('role_id')])->result();
            if ($this->session->userdata('role_id') != 1 && count($operator) == 0) {
                echo "<script> alert ('Tidak ada coverage untuk akun anda')</script>";
                $row[] = '';
            }
            foreach ($operator as $roww) {
                $row[] = $roww->coverage_id;
            };
            return $row;
        }
    }

    public function index()
    {
        $data['title'] = 'Income';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['income'] = $this->income_m->getincome()->result();
        $data['kolektor'] = $this->user_m->getcolector()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $data['category'] = $this->db->get('cat_income')->result();
        $this->template->load('backend', 'backend/income/income', $data);
    }
    public function kas()
    {
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['income'] = $this->income_m->getincome()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $data['report'] = $this->income_m->getReport();
        $report = $this->income_m->getReport();
        // var_dump($report);
        // die;
        $data['category'] = $this->db->get('cat_income')->result();
        $this->template->load('backend', 'backend/income/kas', $data);
    }

    public function thismonth()
    {
        $data['title'] = 'Income';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['income'] = $this->income_m->getIncomeThisMonth()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $data['category'] = $this->db->get('cat_income')->result();
        $this->template->load('backend', 'backend/income/income', $data);
    }


    public function add()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['add_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $post = $this->input->post(null, TRUE);
        $this->income_m->add($post);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pemasukan berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('income') . "'; </script>";
    }
    public function edit()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['edit_income'] == 0) {
            $this->session->set_flashdata('error-sweet', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $post = $this->input->post(null, TRUE);
        $this->income_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pemasukan berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('income') . "'; </script>";
    }
    public function delete()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['del_income'] == 0) {
            $this->session->set_flashdata('error-sweet', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $income_id = $this->input->post('income_id');

        $this->income_m->delete($income_id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pemasukan berhasil dihapus');
        }
        echo "<script>window.location='" . site_url('income') . "'; </script>";
    }
    public function category()
    {
        $data['title'] = 'Income Category';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['category'] = $this->income_m->getcategory()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/income/cat_income', $data);
    }
    public function addcategory()
    {
        $post = $this->input->post(null, TRUE);
        $this->income_m->addcategory($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kategori pemasukan berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('income/category') . "'; </script>";
    }
    public function editcategory()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['edit_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $post = $this->input->post(null, TRUE);

        $this->income_m->editcategory($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data kategori pemasukan berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('income/category') . "'; </script>";
    }
    public function deletecategory()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['del_income'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $category_id = $this->input->post('category_id');
        $cekkategori = $this->db->get_where('income', ['category' => $category_id])->row_array();
        if ($cekkategori > 0) {
            $this->session->set_flashdata('error', 'Kategori tidak dapat dihapus karena terdaftar di data pemasukan');
        } else {
            # code...
            $this->income_m->deletecategory($category_id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data kategori pemasukan berhasil dihapus');
            }
        }

        echo "<script>window.location='" . site_url('income/category') . "'; </script>";
    }
    public function printincome()
    {
        $post = $this->input->post(null, TRUE);
        $data['user_id'] = $this->input->post('user_id');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tanggal2'] = $this->input->post('tanggal2');
        $data['title'] = 'Invoice';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['income'] = $this->income_m->getFilter($post)->result();
        $this->load->view('backend/income/printincome', $data);
    }


    public function delselected()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['del_income'] == 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $income_id =  $_POST['income_id'];
        if ($income_id == null) {
            $this->session->set_flashdata('error', 'Belum ada yang dipilih');
        } else {
            $this->income_m->deleteselected($income_id);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pemasukan berhasil dihapus');
            }
        }
        redirect('income');
    }

    public function recap()
    {
        // $kolektor = $this->session->userdata('id');

        $data['title'] = 'Rekapitulasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['kolektor'] = $this->user_m->getcolector()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['bank'] = $this->setting_m->getBank()->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['other'] = $this->db->get('other')->row_array();
        $this->template->load('backend', 'backend/income/recap', $data);
    }
    public function printrecap()
    {
        $post = $this->input->post(null, TRUE);
        $data['user_id'] = $this->input->post('user_id');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tanggal2'] = $this->input->post('tanggal2');
        $data['title'] = 'Cetak rekapituasi Penerimaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['bill'] = $this->income_m->getFilterColector($post)->result();
        $this->load->view('backend/income/printrecap', $data);
    }
    public function filter()
    {
        $post = $this->input->post(null, TRUE);
        $data['title'] = 'Filter Income';
        $data['kolektor'] = $this->user_m->getcolector()->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['income'] = $this->income_m->getFilterMonth($post)->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/income/filter', $data);
    }
    public function setcategory()
    {
        $this->db->set('category', 1);
        $this->db->like('remark', 'Pembayaran Tagihan no layanan');
        $this->db->or_like('remark', 'Pembayaran Iuran no layanan');
        $this->db->update('income');
        redirect('income');
    }
    // SERVER SIDE
    public function getDataIncome()
    {
        $result = $this->income_m->getDataInc();
        $data = [];
        $no = $_POST['start'];
        foreach ($result as $result) {
            $row = array();
            $row[] = ++$no;
            $row[] = '<input type=' . 'checkbox' . ' class=' . 'check-item' . ' id="ceklis" name=' . 'income_id[]' . ' value=' . $result->income_id . '>';
            $row[] = indo_date($result->date_payment);
            $getcategory = $this->db->get_where('cat_income', ['category_id' => $result->category])->row_array();
            $row[] = indo_currency($result->nominal);
            if ($result->category != 0) {
                $row[] = $getcategory['name'];
            } else {
                $row[] = '';
            }
            $row[] = $result->mode_payment;
            $row[] = $result->remark;
            $row[] = '<a href="#" id="edit"   data-income_id="' . $result->income_id . '" data-nominal="' . $result->nominal . '" data-remark="' . $result->remark . '" data-category="' . $result->category . '" data-mode_payment="' . $result->mode_payment . '" data-receipt="' . $result->create_by . '" data-date_payment="' . $result->date_payment . '" title="Edit" data-toggle="modal" data-target="#Modaledit"><i class="fa fa-edit" style="font-size:25px"></i></a>
            <a  href="#" id="delete" data-toggle="modal" data-income_id="' . $result->income_id . '" data-nominal="' . indo_currency($result->nominal) . '" data-remark="' . $result->remark . '" data-date_payment="' . $result->date_payment . '" data-target="#Modaldelete"  title="Delete"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->income_m->count_all_data(),
            "recordsFiltered" => $this->income_m->count_filtered_data(),
            "data" => $data,
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function delincomeyear($year)
    {
        if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            $this->db->where('YEAR(date_payment)', $year);
            $this->db->delete('income');
            $this->db->where('YEAR(date_payment)', $year);
            $this->db->delete('expenditure');
        }
        redirect('income');
    }

    public function fixincome()
    {
        $invoice = $this->bill_m->fixincome()->result();
        foreach ($invoice as $data) {
            $cekincome = $this->db->get_where('income', ['invoice_id' => $data->invoice])->row_array();
            if ($cekincome == 0) {
                $params = [
                    'nominal' => $data->amount - $data->disc_coupon,
                    'date_payment' => date('Y-m-d', $data->date_payment),
                    'invoice_id' => $data->invoice,
                    'no_services' => $data->no_services,
                    'create_by' =>  $data->create_by,
                    'category' => 1,
                    'mode_payment' => $data->metode_payment,
                    'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $data->no_services . ' ' . 'a/n' . ' ' . $data->name . ' ' . 'Periode' . ' ' . indo_month($data->month) . ' ' . $data->year,
                    'created' => time()
                ];
                $this->db->insert('income', $params);
            }
        }
    }
    public function deldouble($month, $year)
    {
        $bill = $this->bill_m->fixincomethismonth($month, $year)->result();
        foreach ($bill as $data) {
            $income = $this->db->get_where('income', ['invoice_id' => $data->invoice, 'no_services' => $data->no_services])->num_rows();
            if ($income > 1) {
                $lastincome = $this->db->get_where('income', ['invoice_id' => $data->invoice, 'no_services' => $data->no_services])->row_array();
                $this->db->where('income_id', $lastincome['income_id']);
                $this->db->delete('income');
                echo $data->name . ' Total ' . $income;
                echo '<br>';
            }
            // var_dump($income);

        }
    }

    public function getreport()
    {
        $post = $this->input->post(null, TRUE);
        // var_dump($post);
        // die;
        $data = [
            'month' => $post['month'],
            'year' => $post['year'],
            'date' => $post['date'],
            'report' => $this->income_m->getReport($post['date'], $post['month'], $post['year']),
        ];
        $this->load->view('backend/income/filterreport', $data);
    }
    // EXPORT
    public function export()

    {

        $post = $this->input->post(null, TRUE);

        $data['title'] = 'Data Pemasukan ' . indo_month($post['month']) . ' ' . $post['year'];

        // $data['bill'] = $this->bill_m->getInvoicemonthyear($month, $year)->result();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');

        $sheet->setCellValue('B1', 'Tanggal');

        $sheet->setCellValue('C1', 'Metode Pembayaran');

        $sheet->setCellValue('D1', 'ID Kategori');

        $sheet->setCellValue('E1', 'Nominal');

        $sheet->setCellValue('F1', 'Keterangan');

        $sheet->setCellValue('G1', 'ID Penerima');



        $income = $this->income_m->getFilterMonth($post)->result();

        $no = 1;

        $x = 2;

        foreach ($income as $row) {

            $create_by = $this->db->get_where('user', ['id' => $row->create_by])->row_array();
            if ($create_by > 0) {
                $createby = $create_by['name'];
            } else {
                $createby = 'User Tidak Ditemukan / sudah dihapus';
            }

            $category = $this->db->get_where('cat_income', ['category_id' => $row->category])->row_array();
            if ($category > 0) {
                $cate = $category['name'];
            } else {
                $cate = 'Kategori Tidak Ditemukan / sudah dihapus';
            }
            $sheet->setCellValue('A' . $x, $no++);

            $sheet->setCellValue('B' . $x, $row->date_payment);

            $sheet->setCellValue('C' . $x, $row->mode_payment);

            $sheet->setCellValue('D' . $x, $row->category . ' - ' . $cate);

            $sheet->setCellValue('E' . $x,  $row->nominal);

            $sheet->setCellValue('F' . $x, $row->remark);

            $sheet->setCellValue('G' . $x, $row->create_by . ' - ' . $createby);
            $x++;
        }

        // Set width kolom

        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A

        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B

        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C

        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D

        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E

        $sheet->getColumnDimension('F')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(30); // Set width kolom E


        $writer = new WriterXlsx($spreadsheet);

        $filname = 'Data Tagihan Bulan ' . indo_month($post['month']) . ' ' . $post['year'] . ' Cetak ' .  date('d-M-Y') . ' ' . date('H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment; filename="' . $filname . '"');

        ob_end_clean();

        $writer->save('php://output');
        // $writer->save('php://output');
    }
}
