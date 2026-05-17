<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logs_m extends CI_Model
{

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('logs');
        $this->db->order_by('datetime', 'desc');
        $this->db->limit('100');
        if ($id != null) {
            $this->db->where('log_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function getdashboard()
    {
        $this->db->select('*');
        $this->db->from('logs');
        $this->db->order_by('datetime', 'desc');
        $this->db->limit('4');
        if ($this->session->userdata('role_id') != 1) {
            $this->db->where('user_id', $this->session->userdata('id'));
        }
        $query = $this->db->get();
        return $query;
    }
    public function activitylogs($category, $message)
    {
        if ($this->session->userdata('email') != 'ginginabdulgoni@gmail.com') {

            if ($this->agent->is_browser()) {
                $agent = $this->agent->browser() . ' ' . $this->agent->version();
            } elseif ($this->agent->is_mobile()) {
                $agent = $this->agent->mobile();
            }
            $params = [
                'datetime' => time(),
                'category' => $category,
                'name' => $this->session->userdata('name'),
                'role_id' => $this->session->userdata('role_id'),
                'user_id' => $this->session->userdata('id'),
                'remark' => $message . ' dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
            ];

            $this->db->insert('logs', $params);
        }
    }
    public function getlogsuser()
    {
        $this->db->select('*');
        $this->db->from('logs');
        $this->db->order_by('datetime', 'desc');
        $this->db->limit(100);
        $this->db->where('user_id', $this->session->userdata('id'));
        $query = $this->db->get();
        return $query;
    }
    public function loginSuccess()
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'user_id' => $this->session->userdata['id'],
            'role_id' => $this->session->userdata['role_id'],
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => $this->session->userdata['email'] . ' ' . 'berhasil login' . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
        ];
        $this->db->insert('logs', $params);
    }
    public function loginSuccessTeachers()
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'user_id' => $this->session->userdata['id'],
            'role_id' => $this->session->userdata['role_id'],
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => $this->session->userdata['email'] . ' ' . 'Pengajar berhasil login' . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
        ];
        $this->db->insert('logs', $params);
    }
    public function loginFailurePassword($email)
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => '<span style="color:red">' . $email . ' ' . 'Gagal login, password salah' . ' ' . 'akses dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent . '</span>',
        ];
        $this->db->insert('logs', $params);
    }
    public function loginFailurePasswordTeachers($email)
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => '<span style="color:red">' . $email . ' ' . 'Pengajar Gagal login, password salah' . ' ' . 'akses dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent . '</span>',
        ];
        $this->db->insert('logs', $params);
    }
    public function loginEmailNotFound($email)
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => '<span style="color:red">' . $email . ' ' . 'Gagal login, alamat email tidak terdaftar.' . ' ' . 'akses dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent . '</span>',
        ];
        $this->db->insert('logs', $params);
    }
    public function loginEmailDisable($email)
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => '<span style="color:red">' . $email . ' ' . 'Gagal login, alamat email belum diaktivasi' . ' ' . 'akses dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent . '</span>',
        ];
        $this->db->insert('logs', $params);
    }
    public function logout()
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'date_log' => date('Y-m-d'),
            'user_id' => $this->session->userdata['id'],
            'role_id' => $this->session->userdata['role_id'],
            'time_log' => time(),
            'category' => 'Autentication',
            'remark' => $this->session->userdata['email'] . ' ' . 'logout' . ' ' . 'by request dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
        ];
        $this->db->insert('logs', $params);
    }
    public function invoice($invoice)
    {
        $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        }
        $params = [
            'datetime' => time(),
            'user_id' => $this->session->userdata['id'],
            'role_id' => $this->session->userdata['role_id'],
            'category' => 'Invoice',
            'name' => $user['name'],
            'remark' => 'cetak invoice' . ' ' . $invoice . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
        ];
        $this->db->insert('logs', $params);
    }
}
