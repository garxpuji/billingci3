<?php defined('BASEPATH') or exit('No direct script access allowed');

class Coverage extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model(['coverage_m', 'package_m', 'logs_m', 'customer_m']);
    }
    public function index()
    {
        is_logged_in();
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['show_coverage'] == 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['title'] = 'Coverage Area';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->session->userdata('role_id') == 3 && $role['coverage_operator'] == 1) {
            $operator = $this->db->get_where('cover_operator', ['operator' => $this->session->userdata('id')])->result();
            if (count($operator) == 0) {
                $this->session->set_flashdata('error', 'Tidak ada coverage untuk akun anda');
            }
            foreach ($operator as $roww) {
                $row[] = $roww->coverage_id;
            };
            // var_dump($row);
            // die;
            $data['coverage'] = $this->coverage_m->getCoverage($row)->result();
        } else {
            $row = [];
            $data['coverage'] = $this->coverage_m->getCoverage()->result();
        }
        $data['company'] = $this->db->get('company')->row_array();

        $this->template->load('backend', 'backend/coverage/coverage', $data);
    }

    public function getcoverage()
    {
        $coverage = $this->db->get('coverage')->result();
        echo json_encode($coverage);
    }
    public function getcode()
    {
        $post = $this->input->post(null, TRUE);
        $coverage = $this->db->get_where('coverage', ['coverage_id' => $post['coverage_id']])->row_array();
        $customer = $this->customer_m->getlastcoverage($post['coverage_id'])->row_array();
        if ($customer == 0) {
            echo $coverage['code_area'] . '00001';
        } else {
            echo $customer['no_services'] + 1;
        }
    }

    public function customer()
    {
        is_logged_in();
        $data['title'] = 'Customer Area';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['coverage'] = $this->coverage_m->getCoverage()->result();
        $data['company'] = $this->db->get('company')->row_array();

        $this->template->load('backend', 'backend/coverage/coverage', $data);
    }

    public function getKab($id_prov)
    {
        is_logged_in();
        $kab = $this->coverage_m->getKab($id_prov);
        echo "<option value=''>Pilih Kota/Kab</option>";
        foreach ($kab as $k) {
            echo "<option value='{$k->id}'>{$k->nama}</option>";
        }
    }

    public function getKec($id_kab)
    {
        is_logged_in();
        $kec = $this->coverage_m->getKec($id_kab);
        echo "<option value=''>Pilih Kecamatan</option>";
        foreach ($kec as $k) {
            echo "<option value='{$k->id}'>{$k->nama}</option>";
        }
    }

    public function getKel($id_kec)
    {
        is_logged_in();
        $kel = $this->coverage_m->getKel($id_kec);
        echo "<option value=''>Pilih Kelurahan/Desa</option>";
        foreach ($kel as $k) {
            echo "<option value='{$k->id}'>{$k->nama}</option>";
        }
    }

    public function edit($id)
    {
        is_logged_in();
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['edit_coverage'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('code_area', 'Kode Area', 'required|trim|callback_codearea_check');
        if ($this->form_validation->run() == false) {
            $query  = $this->db->get_where('coverage', ['coverage_id' => $id]);
            if ($query->num_rows() > 0) {
                $data['title'] = 'Edit Coverage';
                $data['company'] = $this->db->get('company')->row_array();
                $data['coverage'] = $this->db->get_where('coverage', ['coverage_id' => $id])->row_array();

                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->template->load('backend', 'backend/coverage/edit-coverage', $data);
            } else {
                echo "<script> alert ('Data tidak ditemukan');";
                echo "window.location='" . site_url('coverage') . "'; </script>";
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->coverage_m->edit($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success-sweet', 'Data Coverage berhasil diperbaharui');
            }
            echo "<script>window.location='" . site_url('coverage') . "'; </script>";
        }
    }
    function codearea_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM coverage WHERE code_area = '$post[code_area]' AND coverage_id != '$post[coverage_id]'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('codearea_check', '%s Ini sudah dipakai, Silahkan ganti !');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function add()
    {
        is_logged_in();
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['add_coverage'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('code_area', 'Kode Area', 'required|trim|is_unique[coverage.code_area]');
        $this->form_validation->set_message('is_unique', '%s Sudah dipakai, Silahkan ganti');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Add Coverage';
            $data['company'] = $this->db->get('company')->row_array();

            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->template->load('backend', 'backend/coverage/add-coverage', $data);
        } else {
            $post = $this->input->post(null, TRUE);

            $this->coverage_m->add($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Coverage area berhasil ditambahkan');
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ' ' . $this->agent->version();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                }
                $params = [
                    'datetime' => time(),
                    'category' => 'Activity',
                    'name' => $this->session->userdata('name'),
                    'role_id' => $this->session->userdata('role_id'),
                    'user_id' => $this->session->userdata('id'),
                    'remark' => 'Tambah Coverage Area ' . $post['name'] . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
                ];
                $this->db->insert('logs', $params);

                $coverage = $this->db->get_where('coverage', ['code_area' => $post['code_area']])->row_array();
                $datacover = [
                    'coverage_id' => $coverage['coverage_id'],
                    'operator' => $this->session->userdata('id'),
                ];
                if ($role_id == 3 && $role['coverage_operator'] == 1) {
                    $this->db->insert('cover_operator', $datacover);
                };
            }
            echo "<script>window.location='" . site_url('coverage') . "'; </script>";
        }
    }
    public function deletecoverage()
    {
        is_logged_in();
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['del_coverage'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $post = $this->input->post(null, TRUE);
        $cekcustomer = $this->db->get_where('customer', ['coverage' => $post['coverage_id']]);
        $odp = $this->db->get_where('m_odp', ['coverage_odp' => $post['coverage_id']])->row_array();
        $odc = $this->db->get_where('m_odc', ['coverage_odc' => $post['coverage_id']])->row_array();
        $coverage = $this->db->get_where('coverage', ['coverage_id' => $post['coverage_id']])->row_array();
        if ($cekcustomer->num_rows() > 0) {
            $this->session->set_flashdata('error-sweet', 'Tidak bisa dihapus karena masih terdaftar di data pelanggan');
        } elseif ($odp > 0) {

            $this->session->set_flashdata('error-sweet', 'Tidak bisa dihapus karena masih terdaftar di data ODP');
        } elseif ($odc > 0) {

            $this->session->set_flashdata('error-sweet', 'Tidak bisa dihapus karena masih terdaftar di data ODC');
        } else {
            $this->coverage_m->del($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success-sweet', 'Coverage Area berhasil dihapus');
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ' ' . $this->agent->version();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                }
                $params = [
                    'datetime' => time(),
                    'category' => 'Activity',
                    'name' => $this->session->userdata('name'),
                    'role_id' => $this->session->userdata('role_id'),
                    'user_id' => $this->session->userdata('id'),
                    'remark' => 'Hapus Coverage Area ' . $coverage['c_name'] . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
                ];
                $this->db->insert('logs', $params);
            }
        }
        redirect('coverage');
    }
    public function addoperator()
    {
        if ($this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        $post = $this->input->post(null, TRUE);
        $operator = $this->db->get_where('user', ['id' => $post['operator']])->row_array();
        $cekoperator = $this->db->get_where('cover_operator', ['coverage_id' => $post['coverage_id'], 'operator' => $post['operator']])->row_array();
        if ($cekoperator > 0) {
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('error-sweet', 'Operator sudah ada di Coverage ' . $post['name']);
            }
        } else {
            $post['role_id'] = $operator['role_id'];
            $this->coverage_m->addoperator($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success-sweet', 'Operator berhasil ditambahkan di Coverage ' . $post['name']);
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ' ' . $this->agent->version();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                }
                $params = [
                    'datetime' => time(),
                    'category' => 'Activity',
                    'name' => $this->session->userdata('name'),
                    'role_id' => $this->session->userdata('role_id'),
                    'user_id' => $this->session->userdata('id'),
                    'remark' => 'Tambah Operator ' . $operator['name'] . ' ke Area ' . $post['name'] . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
                ];
                $this->db->insert('logs', $params);
            }
        }

        echo "<script>window.location='" . site_url('coverage/detail/' . $post['coverage_id']) . "'; </script>";
    }
    public function deloperator($id)
    {
        $cover = $this->db->get_where('cover_operator', ['id' => $id])->row_array();
        $coverage = $this->db->get_where('coverage', ['coverage_id' => $cover['coverage_id']])->row_array();
        $user = $this->db->get_where('user', ['id' => $cover['operator']])->row_array();
        $this->db->where('id', $id);
        $this->db->delete('cover_operator');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success-sweet', 'Success');
            if ($this->agent->is_browser()) {
                $agent = $this->agent->browser() . ' ' . $this->agent->version();
            } elseif ($this->agent->is_mobile()) {
                $agent = $this->agent->mobile();
            }
            $params = [
                'datetime' => time(),
                'category' => 'Activity',
                'name' => $this->session->userdata('name'),
                'role_id' => $this->session->userdata('role_id'),
                'user_id' => $this->session->userdata('id'),
                'remark' => 'Hapus ' . $user['name'] . ' dari Coverage ' . $coverage['c_name'] . ' dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
            ];
            $this->db->insert('logs', $params);
        }
        redirect('coverage/detail/' . $cover['coverage_id']);
    }
    public function cs($coverage)
    {
        is_logged_in();
        $data['title'] = 'Customer Area';
        $data['cov'] = $coverage;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->coverage_m->getCustomer($coverage)->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/coverage/customer', $data);
    }

    function byoperatoractive()
    {
        $this->db->set('coverage_operator', 1);
        $this->db->where('role_id', 3);
        $this->db->update('role_management');
        redirect($_SERVER['HTTP_REFERER']);
    }
    function byoperatornonactive()
    {
        $this->db->set('coverage_operator', 0);
        $this->db->where('role_id', 3);
        $this->db->update('role_management');
        redirect($_SERVER['HTTP_REFERER']);
    }

    // Paket
    public function package($id)
    {
        is_logged_in();
        $data['title'] = 'Paket';
        $data['coverage_id'] = $id;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['p_item'] = $this->package_m->getPItem()->result();
        $data['package'] = $this->coverage_m->getpackagecoverage($id)->result();
        $this->template->load('backend', 'backend/coverage/package', $data);
    }

    public function addpackagecoverage()
    {
        is_logged_in();
        $post = $this->input->post(null, TRUE);
        $paket = $this->db->get_where('package_item', ['p_item_id' => $post['package_id']])->row_array();
        $coverage = $this->db->get_where('coverage', ['coverage_id' => $post['coverage_id']])->row_array();
        $cekpackage = $this->db->get_where('cover_package', ['coverage_id' => $post['coverage_id'], 'package_id' => $post['package_id']])->row_array();
        if ($cekpackage == 0) {
            $data = [
                'coverage_id' => $post['coverage_id'],
                'package_id' => $post['package_id'],
                'created' => time()
            ];
            $this->db->insert('cover_package', $data);
        } else {
            $this->session->set_flashdata('error-sweet', 'Gagal !, data paket sudah tersedia di coverage ' . $coverage['c_name']);
        }

        if ($this->db->affected_rows() > 0) {
            $message = 'Tambah Paket ' . $paket['name'] . ' di Coverage ' . $coverage['c_name'];
            $this->logs_m->activitylogs('Activity', $message);
            $this->session->set_flashdata('success-sweet', 'Paket berhasil ditambahkan');
        }
        redirect('coverage/package/' . $post['coverage_id']);
    }

    public function delpackagecoverage()
    {
        is_logged_in();
        $post = $this->input->post(null, TRUE);
        $cekpackage = $this->db->get_where('cover_package', ['id' => $post['id']])->row_array();
        $paket = $this->db->get_where('package_item', ['p_item_id' => $cekpackage['package_id']])->row_array();
        $coverage = $this->db->get_where('coverage', ['coverage_id' => $cekpackage['coverage_id']])->row_array();
        $this->db->where('id', $post['id']);
        $this->db->delete('cover_package');
        if ($this->db->affected_rows() > 0) {
            $message = 'Hapus Paket ' . $paket['name'] . ' dari Coverage ' . $coverage['c_name'];
            $this->logs_m->activitylogs('Activity', $message);
            $this->session->set_flashdata('success-sweet', 'Paket berhasil dihapus');
        }
        redirect('coverage/package/' . $post['id']);
    }
    public function getpackagebycoverage()
    {
        $post = $this->input->post(null, TRUE);
        $coverage = $post['coverage'];
        // var_dump($post['coverage']);
        // die;

        $package = $this->coverage_m->getpackagecoverage($coverage)->result();
        echo "<option value=''>Pilih Paket</option>";
        foreach ($package as $data) {
            $price = indo_currency($data->price);
            echo "<option value='{$data->p_item_id}'>{$data->nameItem} - $price</option>";
        }
    }
    public function getallpackage()
    {
        $post = $this->input->post(null, TRUE);
        $coverage = $post['coverage'];
        // var_dump($post['coverage']);
        // die;

        $package = $this->coverage_m->getallpackage()->result();
        echo "<option value=''>Pilih Paket</option>";
        foreach ($package as $data) {
            $price = indo_currency($data->price);
            echo "<option value='{$data->p_item_id}'>{$data->nameItem} - $price</option>";
        }
    }
    public function detail($coverage_id)
    {
        $data['title'] = 'Detail Coverage';
        $data['company'] = $this->db->get('company')->row_array();
        $data['coverage'] = $this->db->get_where('coverage', ['coverage_id' => $coverage_id])->row_array();
        $data['operator'] = $this->coverage_m->getcoveroperator($coverage_id)->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->template->load('backend', 'backend/coverage/detail-coverage', $data);
    }

    public function fixroleid()
    {
        $this->db->set('role_id', 3);
        $this->db->update('cover_operator');
    }

    // server side
    public function servercoverage()
    {
        $result = $this->coverage_m->servercoverage();
        $data = [];
        $no = $_POST['start'];

        foreach ($result as $result) {
            $active = $this->db->get_where('customer', ['coverage' => $result->coverage_id, 'c_status' => 'Aktif'])->num_rows();
            $nonactive = $this->db->get_where('customer', ['coverage' => $result->coverage_id, 'c_status' => 'Non-Aktif'])->num_rows();
            $waiting = $this->db->get_where('customer', ['coverage' => $result->coverage_id, 'c_status' => 'Menunggu'])->num_rows();
            $customer = 'Aktif : ' . $active . '<br>Non-Aktif : ' . $nonactive . '<br>Menunggu : ' . $waiting;


            $action = ' <a href="' . site_url('coverage/edit/' . $result->coverage_id) . '  "  title="Edit"><i class="fa fa-edit" style="font-size:20px; color:blue"></i></a> 
             <a href="' . site_url('coverage/detail/' . $result->coverage_id) . '"  title="Detail"><i class="fa fa-clone" style="font-size:20px; color:green"></i></a>
             <a href="' . site_url('coverage/cs/' . $result->coverage_id) . '"  title="Pelanggan"><i class="fa fa-users" style="font-size:20px; color:gray"></i></a>
            <a href="" data-toggle="modal" data-target="#delete' . $result->coverage_id . '" title="Hapus"><i class="fa fa-trash" style="font-size:20px; color:red"></i></a>        ';

            $paket = $this->db->get_where('cover_package', ['coverage_id' => $result->coverage_id])->num_rows();

            $row = [
                'no' => ++$no,
                'name' => $result->c_name,
                'code_area' => $result->code_area,
                'maps' => 'Latitude : ' . $result->latitude . '<br>Longitude : ' . $result->longitude . '<br> <a target="blank" href="http://www.google.com/maps/place/' . $result->latitude . ',' . $result->longitude . '">
                <div class="badge badge-primary">Rute Maps</div>
            </a>',
                'radius' => $result->radius,
                'paket' => '<a href=' . site_url('coverage/package/' . $result->coverage_id) . ' class="badge badge-success">' . $paket . ' Paket</a>',
                'address' => $result->address,
                'comment' => $result->comment,
                'action' => $action,
                'customer' => $customer,

            ];
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->coverage_m->count_all_data_coverage(),
            "recordsFiltered" => $this->coverage_m->count_filtered_data_coverage(),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
