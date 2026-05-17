<?php defined('BASEPATH') or exit('No direct script access allowed');

class olt_m extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('olt');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $params = [
            'alias' => $post['name'],
            'ip_address' => $post['ipaddress'],
            'username' => $post['username'],
            'vendor' => $post['vendor'],
            'password' => $post['password'],

        ];
        $this->db->insert('olt', $params);
    }
    public function edit($post)
    {
        $params = [
            'alias' => $post['name'],
            'ip_address' => $post['ipaddress'],
            'username' => $post['username'],
            'vendor' => $post['vendor'],
        ];
        if (!empty($post['password'])) {
            $params['password'] = $post['password'];
        }
        $this->db->where('id', $post['id']);
        $this->db->update('olt', $params);
    }
    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('olt');
    }
}
