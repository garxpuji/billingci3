<?php defined('BASEPATH') or exit('No direct script access allowed');

class Help_m extends CI_Model
{
    var $order =  array(null, null, 'date_created', 'no_ticket',  'name', 'help.no_services', 'help_type', 'status');
    public function gethelp()
    {
        $role_id = $this->session->userdata('role_id');
        $this->db->select('*');
        $this->db->from('help');
        if ($role_id == 5) {
            $this->db->where_in('teknisi',  $this->session->userdata('id'));
        }
        $this->db->order_by('date_created', 'desc');
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $tgl = date('ymd');
        $no = 001;
        $kode = ($tgl . '' .  str_pad($no, 3, "0", STR_PAD_LEFT));
        $cekinv = $this->db->get_where('help', ['no_ticket' => $kode])->row_array();
        $getRecent = $this->getRecentInv()->row_array();
        if ($cekinv > 0) {
            $notiket = $getRecent['no_ticket'] + 1;
        } else {
            $notiket = $kode;
        }
        $params = [
            'help_type' => $post['type'],
            'no_ticket' => $notiket,
            'help_solution' => $post['solution'],
            'description' => $post['remark'],
            'no_services' => $post['no_services'],
            'date_created' => time(),
            'status' => 'pending',
            'create_by' => $this->session->userdata('id'),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['picture'] = $post['picture'];
        }
        $this->db->insert('help', $params);
    }

    private function getRecentInv()
    {
        $this->db->select('*');
        $this->db->from('help');
        $this->db->limit(1);
        $this->db->order_by('no_ticket', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function getRecentTicket($no_services)
    {
        $this->db->select('*');
        $this->db->from('help');
        $this->db->limit(1);
        $this->db->where('no_services', $no_services);
        $this->db->order_by('date_created', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function getcekticket($no_services)
    {
        $this->db->select('*');
        $this->db->from('help');
        $this->db->where('no_services', $no_services);
        $this->db->where('status !=', 'close');
        $query = $this->db->get();
        return $query;
    }

    public function history($no_services)
    {
        $this->db->select('*');
        $this->db->from('help');
        $this->db->where('no_services', $no_services);
        $this->db->limit(20);
        $this->db->order_by('date_created', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function getdone()
    {
        $role_id = $this->session->userdata('role_id');
        $this->db->select('*');
        $this->db->from('help');
        if ($role_id == 5) {
            $this->db->where_in('teknisi',  $this->session->userdata('id'));
        }
        $this->db->where('status', 'close');
        $query = $this->db->get();
        return $query;
    }

    public function getprocess()
    {
        $role_id = $this->session->userdata('role_id');
        $this->db->select('*');
        $this->db->from('help');
        if ($role_id == 5) {
            $this->db->where_in('teknisi',  $this->session->userdata('id'));
        }
        $this->db->where('status', 'process');
        $query = $this->db->get();
        return $query;
    }

    // SERVER SIDE
    private function _get_data_help()
    {

        $role_id = $this->session->userdata('role_id');
        $this->db->select('*');
        $this->db->from('help');
        $this->db->join('customer', 'customer.no_services = help.no_services');
        if (isset($_POST['search']['value'])) {
            $this->db->like('no_ticket', $_POST['search']['value']);
            $this->db->or_like('help.no_services', $_POST['search']['value']);
            $this->db->or_like('description', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('no_ticket', 'desc');
        }
    }
    public function serverhelp()
    {
        $this->_get_data_help();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_all_data_help()
    {
        $this->_get_data_help();
        return $this->db->count_all_results();
    }
    public function count_filtered_data_help()
    {
        $this->_get_data_help();
        $query = $this->db->get();
        return $query->num_rows();
    }
}
