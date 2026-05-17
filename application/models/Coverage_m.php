<?php defined('BASEPATH') or exit('No direct script access allowed');

class Coverage_m extends CI_Model
{
    var $order =  array(null, null, 'code_area', 'c_name', null, null, 'address', 'comment', 'radius', 'latitude', 'longitude');
    public function getCoverage($cover = null)
    {
        $this->db->select('*');
        $this->db->from('coverage');

        if ($cover != null) {
            $this->db->where_in('coverage_id', $cover);
        }
        $this->db->order_by('c_name', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    public function getcoveroperator($coverage_id = null)
    {
        $this->db->select('*, cover_operator.id as idoperator');
        $this->db->from('cover_operator');
        $this->db->join('user', 'user.id = cover_operator.operator');
        if ($coverage_id != null) {
            $this->db->where('coverage_id', $coverage_id);
        }

        $this->db->order_by('cover_operator.role_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    public function getusercoverage()
    {
        $this->db->select('*, user.id as user_id');
        $this->db->from('user');
        $this->db->where('role_id !=', 1);
        $this->db->where('role_id !=', 4);
        $this->db->where('role_id !=', 2);
        $this->db->order_by('role_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {

        $params = [
            'c_name' => $post['name'],

            'radius' => $post['radius'],
            'address' => $post['address'],
            'comment' => $post['comment'],
            'public' => $post['public'],
            'latitude' => $post['lat'],
            'code_area' => $post['code_area'],
            'longitude' => $post['long'],
        ];

        $this->db->insert('coverage', $params);
    }
    public function edit($post)
    {


        $params = [
            'c_name' => $post['name'],

            'address' => $post['address'],
            'code_area' => $post['code_area'],
            'comment' => $post['comment'],
            'public' => $post['public'],
            'radius' => $post['radius'],
            'latitude' => $post['lat'],
            'longitude' => $post['long']

        ];

        $this->db->where('coverage_id', $post['coverage_id']);
        $this->db->update('coverage', $params);
    }
    public function del($post)
    {
        $this->db->where('coverage_id', $post['coverage_id']);
        $this->db->delete('coverage');
    }

    public function getCustomer($coverage)
    {
        $this->db->select('*');
        $this->db->from('customer');
        if ($coverage != null) {
            $this->db->where('coverage', $coverage);
        }
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function addoperator($post)
    {
        $params = [
            'coverage_id' => $post['coverage_id'],
            'role_id' => $post['role_id'],
            'operator' => $post['operator'],

        ];
        $this->db->insert('cover_operator', $params);
    }

    public function getpackagecoverage($coverage_id)
    {
        $this->db->select('*, package_category.name as category_name, package_item.description as descriptionItem, package_item.name as nameItem');
        $this->db->from('cover_package');
        $this->db->join('package_item', 'package_item.p_item_id = cover_package.package_id');
        $this->db->join('package_category', 'package_category.p_category_id = package_item.category_id');
        if ($coverage_id != null) {
            $this->db->where('coverage_id', $coverage_id);
        }
        $this->db->where('is_active', 1);
        $this->db->order_by('price', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function getpackagebycoverage($coverage)
    {

        $this->db->select('*, package_category.name as category_name, package_item.description as descriptionItem, package_item.name as nameItem');
        $this->db->from('cover_package');
        $this->db->join('package_item', 'package_item.p_item_id = cover_package.package_id');
        $this->db->join('package_category', 'package_category.p_category_id = package_item.category_id');
        $this->db->where('coverage_id', $coverage);
        $this->db->where('is_active', 1);
        $this->db->order_by('price', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function getallpackage()
    {

        $this->db->select('*, package_category.name as category_name, package_item.description as descriptionItem, package_item.name as nameItem');
        $this->db->from('package_item');
        $this->db->where('is_active', 1);
        $this->db->join('package_category', 'package_category.p_category_id = package_item.category_id');

        $query = $this->db->get();
        return $query;
    }

    // SERVER SIDE
    private function _get_data_coverage()
    {


        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($this->session->userdata('role_id') == 3 && $role['coverage_operator'] == 1) {
            $operator = $this->db->get_where('cover_operator', ['operator' => $this->session->userdata('id')])->result();
            foreach ($operator as $roww) {
                $row[] = $roww->coverage_id;
            };

            $this->db->select('*');
            $this->db->from('coverage');
            $this->db->where_in('coverage_id', $row);
            if (isset($_POST['search']['value'])) {
                $this->db->like('c_name', $_POST['search']['value']);
                // $this->db->or_like('code_area', $_POST['search']['value']);

                $this->db->where_in('coverage_id', $row);
            }
        } else {
            $this->db->select('*');
            $this->db->from('coverage');
            if (isset($_POST['search']['value'])) {
                $this->db->like('c_name', $_POST['search']['value']);
                $this->db->or_like('code_area', $_POST['search']['value']);
                $this->db->or_like('latitude', $_POST['search']['value']);
                $this->db->or_like('longitude', $_POST['search']['value']);
                $this->db->or_like('address', $_POST['search']['value']);
                $this->db->or_like('comment', $_POST['search']['value']);
            }
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('c_name', 'asc');
        }
    }
    public function servercoverage()
    {
        $this->_get_data_coverage();
        if ($_POST['lengt'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_all_data_coverage()
    {
        $this->_get_data_coverage();
        return $this->db->count_all_results();
    }
    public function count_filtered_data_coverage()
    {
        $this->_get_data_coverage();
        $query = $this->db->get();
        return $query->num_rows();
    }
}
