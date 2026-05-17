<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mikrotik_m extends CI_Model
{
    var $order = array(null, 'no_services', 'name', 'alias', 'mode_user', 'user_mikrotik', null, 'due_date');
    public function editcustomer($post)
    {
        $params = [

            'router' => $post['router'],
            'auto_isolir' => $post['auto_isolir'],
            'due_date' => $post['due_date'],
        ];
        if ($post['changeconn'] == 1) {
            $params['router'] = $post['router'];
            if ($post['createnew'] == 1) {
                $params['user_mikrotik'] = $post['user_mikrotik'];
                $params['mode_user'] = $post['mode_user'];
            }
            if ($post['sinkron'] == 1) {
                $params['user_mikrotik'] = $post['user_sinkron'];
                $params['mode_user'] = $post['mode_user'];
            }
        }

        $this->db->where('customer_id',  $post['customer_id']);
        $this->db->update('customer', $params);
    }

    public function getInvoice()
    {
        $this->db->select('*, invoice.created as created_invoice');
        $this->db->from('invoice');
        $this->db->join('customer', 'customer.no_services = invoice.no_services');
        $this->db->where('status', 'BELUM BAYAR');
        $this->db->where('month', date('m'));
        $this->db->where('year', date('Y'));
        $this->db->where('auto_isolir', 1);
        $query = $this->db->get();
        return $query;
    }
    public function getcustomer()
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->order_by('router', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    // server side
    private function _get_data_query()
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->join('router', 'router.id = customer.router');
        if (isset($_POST['search']['value'])) {
            $this->db->like('no_services', $_POST['search']['value']);
            $this->db->or_like('name', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('router', 'Asc');
        }
    }
    public function getdatacustomer()
    {
        $this->_get_data_query();
        if ($_POST['lengt'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

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


    // Usage Internet
    public function usagethismonth($noservices = null)
    {
        $this->db->select('*');
        $this->db->from('customer_usage');
        $this->db->where('MONTH(date_usage)', date('m'));
        $this->db->where('YEAR(date_usage)', date('Y'));
        if ($noservices != null) {
            $this->db->where('no_services', $noservices);
        }
        $this->db->order_by('last_update', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function usagethisdate($noservices = null, $date = null, $month = null, $year = null)
    {
        if (strlen($date) == 1) {
            $date = '0' . $date;
        } else {
            $date = $date;
        }
        $this->db->select('*');
        $this->db->from('customer_usage');
        if ($noservices != null) {
            $this->db->where('no_services', $noservices);
        }
        if ($date != null) {
            $this->db->where('DAY(date_usage)', $date);
        }
        if ($month != null) {
            $this->db->where('MONTH(date_usage)', $month);
        }
        if ($year != null) {
            $this->db->where('YEAR(date_usage)', $year);
        }
        $this->db->order_by('last_update', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function lastusage($noservices = null)
    {
        $this->db->select('*');
        $this->db->from('customer_usage');
        if ($noservices != null) {
            $this->db->where('no_services', $noservices);
        }
        $this->db->limit('1');
        $this->db->order_by('last_update', 'DESC');

        $query = $this->db->get();
        return $query;
    }
}
