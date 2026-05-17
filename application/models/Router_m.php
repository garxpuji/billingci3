<?php defined('BASEPATH') or exit('No direct script access allowed');

class router_m extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('router');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        // $this->db->where('id !=', 1);
        $query = $this->db->get();
        return $query;
    }
    public function getInvoice()
    {
        $today = date('Y-m-d');
        $this->db->select('*, invoice.created as created_invoice');
        $this->db->from('invoice');
        $this->db->join('customer', 'customer.no_services = invoice.no_services');
        $this->db->where('status', 'BELUM BAYAR');
        $this->db->where('inv_due_date', $today);
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $params = [
            'alias' => $post['name'],
            'ip_address' => $post['ipaddress'],
            'username' => $post['username'],
            'password' => $post['password'],
            'port' => $post['port'],
        ];
        $this->db->insert('router', $params);
    }
    public function edit($post)
    {
        $params = [
            'alias' => $post['name'],
            'ip_address' => $post['ipaddress'],
            'username' => $post['username'],
            'port' => $post['port'],
        ];
        if (!empty($post['password'])) {
            $params['password'] = $post['password'];
        }
        $this->db->where('id', $post['id']);
        $this->db->update('router', $params);
    }
    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('router');
    }
}
