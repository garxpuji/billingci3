<?php defined('BASEPATH') or exit('No direct script access allowed');

class Odp_m extends CI_Model
{
    public function get($id_odp = null)
    {
        $this->db->select('*');
        $this->db->from('m_odp');
        if ($id_odp != null) {
            $this->db->where('id_odp', $id_odp);
        }
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $params = [
            'code_odc' => $post['code_odc'],
            'code_odp' => $post['code_odp'],
            'coverage_odp' => $post['coverage_odp'],
            'no_port_odc' => $post['no_port_odc'],
            'color_tube_fo' => $post['color_tube_fo'],
            'no_pole' => $post['no_pole'],
            'latitude' => $post['lat'],
            'longitude' => $post['long'],
            'total_port' => $post['total_port'],
            'remark' => $post['remark'],
            'created' => time(),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->insert('m_odp', $params);
    }
    public function edit($post)
    {
        $params = [
            'code_odc' => $post['code_odc'],
            'code_odp' => $post['code_odp'],
            'coverage_odp' => $post['coverage_odp'],
            'no_port_odc' => $post['no_port_odc'],
            'color_tube_fo' => $post['color_tube_fo'],
            'no_pole' => $post['no_pole'],
            'latitude' => $post['lat'],
            'longitude' => $post['long'],
            'total_port' => $post['total_port'],
            'remark' => $post['remark'],

        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->where('id_odp', $post['id_odp']);
        $this->db->update('m_odp', $params);
    }
    public function del($id_odp)
    {
        $this->db->where('id_odp', $id_odp);
        $this->db->delete('m_odp');
    }

    public function getmaps()
    {
        $this->db->select('*');
        $this->db->from('m_odp');
        $this->db->where('latitude !=', '');
        $this->db->where('longitude !=', '');
        $query = $this->db->get();
        return $query;
    }
    public function getunmaps()
    {
        $this->db->select('*');
        $this->db->from('m_odp');
        $this->db->where('latitude', '');
        $this->db->or_where('longitude', '');
        $query = $this->db->get();
        return $query;
    }

    // Document
    public function adddoc($post)
    {
        $params = [
            'odp_id' => $post['odp_id'],
            'remark' => $post['remark'],
            'created' => time(),
            'createby' => $this->session->userdata('id'),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->insert('odp_doc', $params);
    }
    public function editdoc($post)
    {
        $params = [
            'remark' => $post['remark'],
            'updated' => time(),
            'updateby' => $this->session->userdata('id'),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->where('id', $post['id']);
        $this->db->update('odp_doc', $params);
    }
    public function deletedoc($post)
    {
        $this->db->where('id', $post['id']);
        $this->db->delete('odp_doc');
    }
    public function getportactive($odp)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id_odp', $odp);
        $this->db->where('c_status !=', 'Menunggu');
        $this->db->where('c_status !=', 'Non-Aktif');
        $query = $this->db->get();
        return $query;
    }
    public function getallcustomer($odp)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id_odp', $odp);
        $this->db->order_by('no_port_odp', 'ASC');
        $query = $this->db->get();
        return $query;
    }
}
