<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        if ($this->session->userdata('role_id') == 3) {
            $this->db->where('role_id !=', 1);
            $this->db->where('role_id !=', 3);
        }
        $query = $this->db->get();
        return $query;
    }
    public function getadmin($id = null)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');
        $this->db->where('role_id', 1);
        if ($id != null) {
            $this->db->where('id', $id);
        }
        if ($this->session->userdata('role_id') == 3) {
            $this->db->where('role_id !=', 1);
            $this->db->where('role_id !=', 3);
        }
        $query = $this->db->get();
        return $query;
    }

    public  function edit($post)
    {
        $email = $this->input->post('email');
        $new_password = $this->input->post('password');
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $params['name'] = $post['name'];
        $params['is_active'] = $post['is_active'];
        $params['role_id'] = $post['role_id'];
        $params['gender'] = $post['gender'];
        $params['phone'] = $post['phone'];
        $params['address'] = $post['address'];
        if ($new_password != '') {
            $params['password'] = $password_hash;
            if ($post['sendwapelanggan'] == '1') {

                // WA GATEWAY
                // get database wa gateway

                $whatsapp = $this->db->get('whatsapp')->row_array();
                // get database other 
                $other = $this->db->get('other')->row_array();
                // get database company


                $company = $this->db->get('company')->row_array();
                $search  = array('{name}',   '{companyname}',  '{slogan}', '{link}', '{e}', '{email}', '{password}');
                $replace = array($post['name'], $company['company_name'], $company['sub_name'], base_url(), '', $email, $new_password);
                $target = indo_tlp($post['phone']);
                $subject = $other['reset_password'];
                $message = str_replace($search, $replace, $subject);
                if ($whatsapp['is_active'] == 1) {
                    sendmsg($target, $message);
                }
            }
        }


        $this->db->where('id', $post['id']);
        $this->db->update('user', $params);
    }
    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    public function getcolector($id = null)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');
        $this->db->where('role_id !=', 2);
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function adminteknisi()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');
        $this->db->where('role_id', 1);

        $this->db->where('is_active', 1);

        $query = $this->db->get();
        return $query;
    }
}
