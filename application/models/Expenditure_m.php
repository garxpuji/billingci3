<?php defined('BASEPATH') or exit('No direct script access allowed');
class expenditure_m extends CI_Model
{
    private function _role()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        return $role;
    }
    public function getexpenditure($expenditure_id = null)
    {
        $role = $this->_role();
        $this->db->select('*');
        $this->db->from('expenditure');
        if ($expenditure_id != null) {
            $this->db->where('$expenditure_id', $expenditure_id);
        }
        $this->db->order_by('date_payment', 'DESC');
        if ($this->session->userdata('role_id') != 1) {
            if ($role['coverage_operator'] ==  1) {
                $this->db->where('create_by', $this->session->userdata('id'));
            } else {
            }
        }
        $query = $this->db->get();
        return $query;
    }
    public function getExpenditureThisMonth()
    {
        $role = $this->_role();
        $this->db->select('*');
        $this->db->from('expenditure');
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', date('Y'));
        if ($this->session->userdata('role_id') != 1 && $role['show_saldo'] == 0) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        if ($role['coverage_operator'] == 1 && $role['show_saldo'] == 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function getLastMonth()
    {
        $lastmonth = date("m", strtotime('last month'));
        $year = date("Y", strtotime('last month'));
        $this->db->select('*');
        $this->db->from('expenditure');
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $this->db->where('MONTH(date_payment)', $lastmonth);
        $this->db->where('YEAR(date_payment)', $year);

        $query = $this->db->get();
        return $query;
    }
    public function gettoday()
    {
        $role = $this->_role();
        $today = date("d");
        $year = date("Y");
        $this->db->select('*');
        $this->db->from('expenditure');
        $this->db->where('DAY(date_payment)', $today);
        if ($this->session->userdata('role_id') != 1 && $role['show_saldo'] == 0) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        if ($role['coverage_operator'] == 1 && $role['show_saldo'] == 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', $year);

        $query = $this->db->get();
        return $query;
    }
    public function getyesterday()
    {
        $role = $this->_role();
        $yesterday = strtotime("-1 day", strtotime(date("Y-m-d")));
        $day = date("d", $yesterday);
        $month = date("m", $yesterday);
        $year = date("Y", $yesterday);
        $this->db->select('*');
        $this->db->from('expenditure');
        if ($this->session->userdata('role_id') != 1 && $role['show_saldo'] == 0) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        if ($role['coverage_operator'] == 1 && $role['show_saldo'] == 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $this->db->where('DAY(date_payment)', $day);
        $this->db->where('MONTH(date_payment)', $month);
        $this->db->where('YEAR(date_payment)', $year);

        $query = $this->db->get();
        return $query;
    }
    public function getCategoryThisMonth($category_id)
    {
        $role = $this->_role();
        $this->db->select('*');
        $this->db->from('expenditure');
        $this->db->where('MONTH(date_payment)', date('m'));
        $this->db->where('YEAR(date_payment)', date('Y'));

        $this->db->where('category', $category_id);
        if ($this->session->userdata('role_id') != 1 && $role['show_saldo'] == 0) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        if ($role['coverage_operator'] == 1 && $role['show_saldo'] == 1) {
            $this->db->where('create_by', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $params = [
            'nominal' => $post['nominal'],
            'date_payment' => htmlspecialchars($post['date_payment']),
            'remark' => htmlspecialchars($post['remark']),
            'category' => $post['category'],
            'create_by' => $this->session->userdata('id'),
            'created' => time()
        ];
        $this->db->insert('expenditure', $params);
    }
    public function edit($post)
    {
        $params = [
            'nominal' => $post['nominal'],
            'date_payment' => htmlspecialchars($post['date_payment']),
            'remark' => htmlspecialchars($post['remark']),
            'category' => $post['category'],
        ];
        $this->db->where('expenditure_id',  $post['expenditure_id']);
        $this->db->update('expenditure', $params);
    }

    public function delete($expenditure_id)
    {
        $this->db->where('expenditure_id', $expenditure_id);
        $this->db->delete('expenditure');
    }

    public function deleteselected($expenditure_id)
    {
        $this->db->where_in('expenditure_id', $expenditure_id);
        $this->db->delete('expenditure');
    }
    public function getFilter($post)
    {
        $this->db->select('*');
        $this->db->from('expenditure');
        if (!empty($post['tanggal']) && !empty($post['tanggal2'])) {
            $this->db->where("expenditure.date_payment BETWEEN '" . ($post['tanggal']) . "' AND '" . ($post['tanggal2']) . "'");
        }
        $this->db->order_by('date_payment', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    // CATEGORY
    public function addcategory($post)
    {
        $params = [
            'name' => $post['name'],
            'remark' => htmlspecialchars($post['remark']),
        ];
        $this->db->insert('cat_expenditure', $params);
    }

    public function editcategory($post)
    {
        $params = [
            'name' => $post['name'],

            'remark' => htmlspecialchars($post['remark']),
        ];
        $this->db->where('category_id',  $post['category_id']);
        $this->db->update('cat_expenditure', $params);
    }

    public function deletecategory($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->delete('cat_expenditure');
    }


    // SERVER SIDE
    private function _get_data_query()
    {
        $role = $this->_role();
        $this->db->select('*');
        $this->db->from('expenditure');
        if ($this->session->userdata('role_id') != 1) {
            if ($role['coverage_operator'] ==  1) {
                $this->db->where('create_by', $this->session->userdata('id'));
            } else {
                $this->db->where('create_by', $this->session->userdata('id'));
            }
        }
        if (isset($_POST['search']['value'])) {
            // $this->db->like('date_payment', $_POST['search']['value']);
            // $this->db->or_like('nominal', $_POST['search']['value']);
            $this->db->like('remark', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('date_payment', 'Desc');
        }
    }
    public function getDataExpend()
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
}
