<?php defined('BASEPATH') or exit('No direct script access allowed');

class Odc_m extends CI_Model
{
    public function get($id_odc = null)
    {
        $this->db->select('*');
        $this->db->from('m_odc');
        if ($id_odc != null) {
            $this->db->where('id_odc', $id_odc);
        }
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $params = [
            'code_odc' => $post['code_odc'],
            'coverage_odc' => $post['coverage_odc'],
            'no_port_olt' => $post['no_port_olt'],
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
        $this->db->insert('m_odc', $params);
    }
    public function edit($post)
    {
        $params = [
            'code_odc' => $post['code_odc'],
            'coverage_odc' => $post['coverage_odc'],
            'no_port_olt' => $post['no_port_olt'],
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
        $this->db->where('id_odc', $post['id_odc']);
        $this->db->update('m_odc', $params);
    }
    public function del($id_odc)
    {
        $this->db->where('id_odc', $id_odc);
        $this->db->delete('m_odc');
    }
    public function getmaps()
    {
        $this->db->select('*');
        $this->db->from('m_odc');
        $this->db->where('latitude !=', '');
        $this->db->where('longitude !=', '');
        $query = $this->db->get();
        return $query;
    }
    public function getunmaps()
    {
        $this->db->select('*');
        $this->db->from('m_odc');
        $this->db->where('latitude', '');
        $this->db->or_where('longitude', '');
        $query = $this->db->get();
        return $query;
    }

    // Document
    public function adddoc($post)
    {
        $params = [
            'odc_id' => $post['odc_id'],
            'remark' => $post['remark'],
            'created' => time(),
            'createby' => $this->session->userdata('id'),
        ];
        if (!empty($_FILES['picture']['name'])) {
            $params['document'] = $post['picture'];
        }
        $this->db->insert('odc_doc', $params);
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
        $this->db->update('odc_doc', $params);
    }
    public function deletedoc($post)
    {
        $this->db->where('id', $post['id']);
        $this->db->delete('odc_doc');
    }
}
