<?php defined('BASEPATH') or exit('No direct script access allowed');
class Income_m extends CI_Model
{
    private function _role()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        return $role;
    }
    private function _menu()
    {
        $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();

        return $menu;
    }
    public function getIncome($income_id = null)
    {
        $role = $this->_role();
        $menu = $this->_menu();
        $this->db->select('*');
        $this->db->from('income');
        if ($income_id != null) {
            $this->db->where('$income_id', $income_id);
        }
        if ($this->session->userdata('role_id') != 1) {
            if ($role['coverage_operator'] ==  1) {
                $this->db->where('create_by', $this->session->userdata('id'));
            } else {
            }
        }
        $this->db->order_by('date_payment', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeThisMonth()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', date('Y'));
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function getCategoryThisMonth($category_id)
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', date('Y'));
        $this->db->where('category', $category_id);
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeLastMonth()
    {
        $lastmonth = date("m", strtotime('last month'));
        $year = date("Y", strtotime('last month'));
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', $lastmonth);
        $this->db->where('YEAR(date_payment)', $year);
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function gettoday()
    {
        $today = date("d");
        $year = date("Y");
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('DAY(date_payment)', $today);
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', $year);
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function getyesterday()
    {
        $yesterday = strtotime("-1 day", strtotime(date("Y-m-d")));
        $day = date("d", $yesterday);
        $month = date("m", $yesterday);
        $year = date("Y", $yesterday);
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('DAY(date_payment)', $day);
        $this->db->where('MONTH(date_payment)', $month);
        $this->db->where('YEAR(date_payment)', $year);
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeJan()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '01');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeFeb()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '02');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeMar()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '03');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeApr()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '04');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeMay()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '05');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeJun()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '06');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeJul()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '07');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeAug()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '08');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeSep()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '09');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeOct()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '10');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeNov()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '11');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function getIncomeDec()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', '12');
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }
    public function addPayment($post)
    {
        $params = [
            'nominal' => $post['nominal'],
            'date_payment' => $post['date_payment'],
            'invoice_id' => $post['invoice'],
            'no_services' => $post['no_services'],
            'category' => $post['category'],
            'mode_payment' => $post['metode_payment'],
            'create_by' =>  $post['create_by'],
            'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $post['no_services'] . ' ' . 'a/n' . ' ' . $post['name'] . ' ' . 'Periode' . ' ' . $post['month'] . ' ' . $post['year'],
            'created' => time()
        ];
        $this->db->insert('income', $params);
    }
    public function addPaymentFast($post)
    {
        $params = [
            'nominal' => $post['nominal'],
            'date_payment' => date('Y-m-d'),
            'invoice_id' => $post['invoice'],
            'no_services' => $post['no_services'],
            'create_by' =>  $post['create_by'],
            'category' => $post['category'],
            'mode_payment' => $post['metode_payment'],
            'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $post['no_services'] . ' ' . 'a/n' . ' ' . $post['name'] . ' ' . 'Periode' . ' ' . $post['month'] . ' ' . $post['year'],
            'created' => time()
        ];
        $this->db->insert('income', $params);
    }
    public function addbymidtrans($result)
    {
        $invoice = $this->db->get_where('invoice', ['order_id' => $result['order_id']])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
        $params = [
            'nominal' => $result['gross_amount'],
            'date_payment' => date('Y-m-d'),
            'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice['no_services'] . ' ' . 'a/n' . ' ' . $customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice['month']) . ' ' . $invoice['year'] . ' by Midtrans',
            'invoice_id' => $invoice['invoice'],
            'no_services' => $invoice['no_services'],
            'mode_payment' => 'Payment Gateway',
            'category' => 1,
            'create_by' => 0,
            'created' => time()
        ];
        $this->db->insert('income', $params);
    }
    public function getreceipt()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');
        $this->db->where('role_id !=', 2);
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        if ($this->session->userdata('role_id') == 1) {
            $create_by = $post['create_by'];
        } else {
            $create_by = $this->session->userdata('id');
        }
        $params = [
            'nominal' => $post['nominal'],
            'category' => $post['category'],
            'create_by' => $create_by,
            'date_payment' => htmlspecialchars($post['date_payment']),
            'remark' => htmlspecialchars($post['remark']),
            'created' => time()
        ];
        $this->db->insert('income', $params);
    }
    public function edit($post)
    {
        $params = [
            'nominal' => $post['nominal'],
            'category' => $post['category'],
            'mode_payment' => $post['metode_payment'],
            'date_payment' => htmlspecialchars($post['date_payment']),
            'remark' => htmlspecialchars($post['remark']),
        ];
        $this->db->where('income_id',  $post['income_id']);
        $this->db->update('income', $params);
    }

    public function delete($income_id)
    {
        $this->db->where('income_id', $income_id);
        $this->db->delete('income');
    }

    public function getFilter($post)
    {
        $this->db->select('*');
        $this->db->from('income');
        if (!empty($post['tanggal']) && !empty($post['tanggal2'])) {
            $this->db->where("income.date_payment BETWEEN '" . ($post['tanggal']) . "' AND '" . ($post['tanggal2']) . "'");
        }
        $this->db->order_by('date_payment', 'ASC');
        if ($post['category'] != null) {
            $this->db->where('category', $post['category']);
        }
        if ($post['user_id'] != null) {
            $this->db->where('create_by', $post['user_id']);
        }
        if ($post['metode_payment'] != null) {
            $this->db->where('mode_payment', $post['metode_payment']);
        }
        $query = $this->db->get();
        return $query;
    }

    // XENDIT
    public function addbyxendit($ext_id)
    {
        $invoice = $this->db->get_where('invoice', ['x_external_id' => $ext_id])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
        $params = [
            'nominal' => $invoice['amount'],
            'date_payment' => date('Y-m-d'),
            'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice['no_services'] . ' ' . 'a/n' . ' ' . $customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice['month']) . ' ' . $invoice['year'] . ' by Xendit',
            'invoice_id' => $invoice['invoice'],
            'category' => 1,
            'no_services' => $invoice['no_services'],
            'mode_payment' => 'Payment Gateway',
            'created' => time()
        ];
        $this->db->insert('income', $params);
    }
    public function payselected($params)
    {
        $this->db->insert_batch('income', $params);
    }
    public function incomeselected($invoice = null)
    {

        $this->db->from('income');
        $this->db->where_in('invoice_id', $invoice);
        $this->db->order_by('date_payment', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function deleteselected($income_id)
    {
        $this->db->where_in('income_id', $income_id);
        $this->db->delete('income');
    }
    public function getFilterColector($post)
    {
        $this->db->select('*');
        $this->db->from('income');
        if (!empty($post['tanggal']) && !empty($post['tanggal2'])) {
            $this->db->where("income.date_payment BETWEEN '" . ($post['tanggal']) . "' AND '" . ($post['tanggal2']) . "'");
        }
        if ($post['user_id'] != '') {

            $this->db->where('create_by',  $post['user_id']);
        }
        $this->db->order_by('date_payment', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function getFilterMonth($post)
    {
        $this->db->select('*');
        $this->db->from('income');
        if (!empty($this->input->post("filterbydate"))) {
            $this->db->where("income.date_payment BETWEEN '" . ($post['tanggal']) . "' AND '" . ($post['tanggal2']) . "'");
        } else {
            $this->db->where('MONTH(date_payment)', $post['month']);
            $this->db->where('YEAR(date_payment)', $post['year']);
        }

        if ($post['category'] != null) {
            $this->db->where('category', $post['category']);
        }
        if ($post['user_id'] != null) {
            $this->db->where('create_by', $post['user_id']);
        }
        if ($post['metode_payment'] != null) {
            $this->db->where('mode_payment', $post['metode_payment']);
        }
        $this->db->order_by('date_payment', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    // KATEGORI
    public function getcategory($category_id = null)
    {
        $this->db->select('*');
        $this->db->from('cat_income');
        if ($category_id != null) {
            $this->db->where('category_id', $category_id);
        }
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    public function addcategory($post)
    {
        $params = [
            'name' => $post['name'],
            'remark' => htmlspecialchars($post['remark']),
        ];
        $this->db->insert('cat_income', $params);
    }
    public function editcategory($post)
    {
        $params = [
            'name' => $post['name'],

            'remark' => htmlspecialchars($post['remark']),
        ];
        $this->db->where('category_id',  $post['category_id']);
        $this->db->update('cat_income', $params);
    }
    public function deletecategory($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->delete('cat_income');
    }
    // SERVER SIDE
    private function _get_data_query()
    {
        $role = $this->_role();
        $menu = $this->_menu();
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', date('Y'));
        if ($this->session->userdata('role_id') != 1) {
            if ($role['coverage_operator'] ==  1) {
                $this->db->where('MONTH(date_payment)', date('m'));
                $this->db->where('YEAR(date_payment)', date('Y'));
                $this->db->where('create_by', $this->session->userdata('id'));
            } else {
                $this->db->where('create_by', $this->session->userdata('id'));
                $this->db->where('MONTH(date_payment)', date('m'));
                $this->db->where('YEAR(date_payment)', date('Y'));
            }
        }
        if (isset($_POST['search']['value'])) {
            $this->db->like('remark', $_POST['search']['value']);
            $this->db->where('MONTH(date_payment)', date('m'));
            $this->db->where('YEAR(date_payment)', date('Y'));
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('date_payment', 'Desc');
        }
    }
    public function getDataInc()
    {
        $this->_get_data_query();
        if ($_POST['lengt'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data()
    {
        $this->_get_data_query();
        return $this->db->count_all_results();
    }

    public function fixdoublemonth()
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', date('Y'));
        $query = $this->db->get();
        return $query;
    }

    // debit kredit
    public function getReport($date = null, $month = null, $year = null)
    {
        if ($date != null) {
            $income = $this->db->get_where('income', ['MONTH(date_payment)' => $month, 'YEAR(date_payment)' => $year, 'DAY(date_payment)' => $date])->result();
            $expenditure = $this->db->get_where('expenditure', ['MONTH(date_payment)' => $month, 'YEAR(date_payment)' => $year, 'DAY(date_payment)' => $date])->result();
        } elseif ($month != null && $year != null) {
            $income = $this->db->get_where('income', ['MONTH(date_payment)' => $month, 'YEAR(date_payment)' => $year])->result();
            $expenditure = $this->db->get_where('expenditure', ['MONTH(date_payment)' => $month, 'YEAR(date_payment)' => $year])->result();
        } else {
            # code...
            $income = $this->db->get('income')->result();
            $expenditure = $this->db->get('expenditure')->result();
        }

        $rows = [];
        foreach ($income as $data) {
            $category = $this->db->get_where('cat_income', ['category_id' => $data->category])->row_array();
            if ($category > 0) {
                $category = $category['name'];
            } else {
                $category = '';
            }
            array_push(
                $rows,
                array(
                    'date' => $data->date_payment,
                    'income' => $data->nominal,
                    'remark' => $data->remark,
                    'category' => $category

                )
            );
        }


        $rows2 = [];
        foreach ($expenditure as $data) {
            $category = $this->db->get_where('cat_expenditure', ['category_id' => $data->category])->row_array();
            if ($category > 0) {
                $category = $category['name'];
            } else {
                $category = '';
            }
            array_push(
                $rows2,
                array(
                    'date' => $data->date_payment,
                    'expenditure' => $data->nominal,
                    'remark' => $data->remark,
                    'category' => $category

                )
            );
        }

        $result = array_merge($rows, $rows2);
        // $result = array_merge($rows, $rows2);


        asort($result);

        // foreach ($result as $x => $x_value) {
        //     echo "Key=" . $x . ", Value=" . $x_value['date'];
        //     echo "<br>";
        // }
        // print json_encode($result);
        return json_encode($result);
    }
    function manualQuery($q)
    {
        return $this->db->query($q);
    }

    public function debit()
    {
        $q = "SELECT * FROM income   ";
        $data = $this->income_m->manualQuery($q);
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $t) {
                $hasil = $t->nominal;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
    public function kredit()
    {
        $q = "SELECT * FROM expenditure";
        $data = $this->income_m->manualQuery($q);
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $t) {
                $hasil = $t->nominal;
            }
        } else {
            $hasil = 0;
        }
        return $hasil;
    }
}
