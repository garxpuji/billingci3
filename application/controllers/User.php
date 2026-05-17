<?php
//==============================START=========================================//
/*
     *  Base Code   : Gingin Abdul Goni | Rosita Wulandari, S.Kom,.MTA
     *  Email       : ginginabdulgoni@gmail.com
     *  Instagram   : @ginginabdulgoni
     *  Telegram    : @ginginabdulgoni
     *
     *  Name        : My-Wifi
     *  Function    : Manage Client and Billing
     *  Manufacture : June 2021 
     *
     *  Please do not change this code
     *  All damage caused by editing we will not be responsible please think carefully,
     *
     */
//==============================START CODE=========================================//
?>
<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['user_m', 'logs_m']);
    }
    public function index()
    {
        $data['title'] = 'User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['row'] = $this->user_m->get()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/user_data', $data);
    }
    public function admin()
    {
        $data['title'] = 'Admin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['row'] = $this->user_m->getadmin()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/user_data', $data);
    }
    public function customer()
    {
        $data['title'] = 'Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['row'] = $this->db->get_where('user', ['role_id' => 2])->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/user_data', $data);
    }
    public function mitra()
    {
        $data['title'] = 'Mitra';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['row'] = $this->db->get_where('user', ['role_id' => 4])->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/user_data', $data);
    }
    public function operator()
    {
        $data['title'] = 'Operator';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['row'] = $this->db->get_where('user', ['role_id' => 3])->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/user_data', $data);
    }
    public function teknisi()
    {
        $data['title'] = 'Teknisi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['row'] = $this->db->get_where('user', ['role_id' => 5])->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/user_data', $data);
    }
    public function profile()
    {
        $data['title'] = 'Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/profile', $data);
    }
    public function edit()
    {
        $config['upload_path'] = './assets/images/profile/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']     = '2048';
        $data['title'] = 'Edit Profile'; // Judul link
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->template->load('backend', 'backend/user/edit-profile', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $gender = $this->input->post('gender');
            $address = $this->input->post('address');
            $image1 = $this->input->post('image1');

            // cek jika ada gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . '/assets/images/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                    redirect('user/profile');
                }
            }
            if ($new_image != null) {
                $this->db->set('image', $new_image);
            } else {
                $this->db->set('image', $image1);
            }
            $this->db->set('name', $name);
            $this->db->set('email', $email);
            $this->db->set('phone', $phone);
            $this->db->set('gender', $gender);
            $this->db->set('address', $address);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('success', 'Your profile has been updated!');
            redirect('user/profile');
        }
    }
    public function editEmail()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Pastikan penulisan email baru benar');
            redirect('user/profile');
        } else {
            $id = $this->input->post('id');
            $email = $this->input->post('email');
            $cekcustomer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array();
            $this->db->set('email', $email);
            $this->db->where('id', $id);
            $this->db->update('user');
            if ($cekcustomer > 0) {
                $this->db->set('email', $email);
                $this->db->where('customer_id', $cekcustomer['customer_id']);
                $this->db->update('customer');
            }
            // CREATE LOGS
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
                'remark' => 'Ganti Email dari ' . ' ' . $this->session->userdata('email') . ' Menjadi ' . $email . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
            ];
            $this->db->insert('logs', $params);
            $this->session->unset_userdata('login');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('role_id');

            $this->session->set_flashdata('success', 'Your email has been updated! please login with new email');
            redirect('auth');
        }
    }
    public function editidcard()
    {


        $newktp = $this->input->post('no_ktp');

        $type_id = $this->input->post('type_id');
        $no_ktp =  $this->input->post('no_ktp');
        $customer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array();

        if ($customer > 0) {
            $this->db->set('no_ktp', $no_ktp);
            $this->db->set('type_id', $type_id);
            $this->db->where('customer_id', $customer['customer_id']);
            $this->db->update('customer');
        }
        // CREATE LOGS
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
            'remark' => 'Ganti ID Card dari ' . ' ' . $customer['no_ktp'] . ' Menjadi ' . $newktp . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
        ];
        $this->db->insert('logs', $params);


        $this->session->set_flashdata('success', 'Your ID Card has been updated! please login with new email');
        redirect('member/profile');
    }

    public function changepassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[5]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm Password', 'required|trim|min_length[5]|matches[new_password1]');
        if ($this->form_validation->run() == false) {
            $data['company'] = $this->db->get('company')->row_array();
            $this->template->load('backend', 'backend/user/change-password', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('error', 'Wrong current password!');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('error', 'New password cannot be the same as carrent password!');
                    redirect('user/changepassword');
                } else {
                    // password benar
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    $this->session->set_flashdata('success', 'New password has been changed!');
                    redirect('user/changepassword');
                }
            }
        }
    }
    public function edit_user($id)
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['edit_user'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }

        $data['title'] = 'Edit Pengguna'; // Judul link
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $row = $this->db->get_where('user', ['id' => $id])->num_rows();
        if ($row <= 0) {
            $this->session->set_flashdata('error', 'Data user tidak ditemukan');
            echo "<script>window.location='" . site_url('user') . "'; </script>";
        } else {
            $data['row'] = $this->db->get_where('user', ['id' => $id])->row_array();
            $data['company'] = $this->db->get('company')->row_array();
            $this->template->load('backend', 'backend/user/edit-user', $data);
        }
    }

    public function editUser()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['edit_user'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $post = $this->input->post(null, TRUE);
        $this->user_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('user') . "'; </script>";
    }
    public function del()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['del_user'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $id = $this->input->post('id');
        $user = $this->user_m->get($id)->row();
        if ($user->image != 'default.jpg') {
            $target_file = './assets/images/profile/' . $user->image;
            unlink($target_file);
        }
        $this->user_m->del($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        echo "<script>window.location='" . base_url('user') . "'; </script>";
    }
    public function register()
    {

        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id == 3 && $role['add_user'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        if ($this->session->userdata('role_id') == 2) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('member/dashboard');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]'); // cek tabel user field email
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password tidak sama !',
            'min_length' => 'Password terlalu pendek !'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        $this->form_validation->set_message('required', '%s Tidak boleh kosong, Silahkan isi');
        $this->form_validation->set_message('is_unique', '%s Sudah dipakai, Silahkan ganti');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Daftar Pelanggan';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/user/register', $data);
        } else {
            $cekCs = $this->db->get_where('customer', ['email' => $this->input->post('email')])->num_rows();
            $PsW = substr(intval(rand()), 0, 8);
            if ($cekCs > 0) {
                $email = $this->input->post('email', true);
                $data = [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($email),
                    'image' => 'default.jpg',
                    'password' => password_hash($PsW, PASSWORD_DEFAULT),
                    'role_id' => $this->input->post('role_id'),
                    'is_active' => 1,
                    'date_created' => time()
                ];

                // siapkan token
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user', $data);
                $this->db->insert('user_token', $user_token);
                $this->session->set_flashdata('error', ' Alamat email sudah terdaftar di data pelanggan, silahkan ganti password oleh admin atau reset password oleh pelanggan! ');
                redirect('user');
            } else {
                $email = $this->input->post('email', true);
                $data = [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($email),
                    'image' => 'default.jpg',
                    'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'role_id' => $this->input->post('role_id'),
                    'is_active' => 1,
                    'date_created' => time()
                ];


                $this->db->insert('user', $data);

                $this->session->set_flashdata('success', 'Data pengguna berhasil dibuat');
                redirect('user');
            }
        }
    }

    // ROLE MANAGEMENT
    public function role()
    {
        if ($this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/user/role', $data);
    }
    public function roleupdate()
    {
        $show_saldo = $this->input->get('show_saldo');
        $show_customer = $this->input->get('show_customer');
        $add_customer = $this->input->get('add_customer');
        $edit_customer = $this->input->get('edit_customer');
        $del_customer = $this->input->get('del_customer');

        $show_item = $this->input->get('show_item');
        $add_item = $this->input->get('add_item');
        $edit_item = $this->input->get('edit_item');
        $del_item = $this->input->get('del_item');

        $show_bill = $this->input->get('show_bill');
        $add_bill = $this->input->get('add_bill');
        $del_bill = $this->input->get('del_bill');

        $show_income = $this->input->get('show_income');
        $add_income = $this->input->get('add_income');
        $edit_income = $this->input->get('edit_income');
        $del_income = $this->input->get('del_income');

        $show_coverage = $this->input->get('show_coverage');
        $add_coverage = $this->input->get('add_coverage');
        $edit_coverage = $this->input->get('edit_coverage');
        $del_coverage = $this->input->get('del_coverage');

        $show_slide = $this->input->get('show_slide');
        $add_slide = $this->input->get('add_slide');
        $edit_slide = $this->input->get('edit_slide');
        $del_slide = $this->input->get('del_slide');

        $show_product = $this->input->get('show_product');
        $add_product = $this->input->get('add_product');
        $edit_product = $this->input->get('edit_product');
        $del_product = $this->input->get('del_product');

        $show_router = $this->input->get('show_router');
        $add_router = $this->input->get('add_router');
        $edit_router = $this->input->get('edit_router');
        $del_router = $this->input->get('del_router');

        $show_user = $this->input->get('show_user');
        $add_user = $this->input->get('add_user');
        $edit_user = $this->input->get('edit_user');
        $del_user = $this->input->get('del_user');

        $this->db->set('show_saldo', $show_saldo);
        $this->db->set('show_customer', $show_customer);
        $this->db->set('add_customer', $add_customer);
        $this->db->set('edit_customer', $edit_customer);
        $this->db->set('del_customer', $del_customer);

        $this->db->set('show_item', $show_item);
        $this->db->set('add_item', $add_item);
        $this->db->set('edit_item', $edit_item);
        $this->db->set('del_item', $del_item);

        $this->db->set('show_bill', $show_bill);
        $this->db->set('add_bill', $add_bill);
        $this->db->set('del_bill', $del_bill);

        $this->db->set('show_income', $show_income);
        $this->db->set('add_income', $add_income);
        $this->db->set('edit_income', $edit_income);
        $this->db->set('del_income', $del_income);

        $this->db->set('show_coverage', $show_coverage);
        $this->db->set('add_coverage', $add_coverage);
        $this->db->set('edit_coverage', $edit_coverage);
        $this->db->set('del_coverage', $del_coverage);

        $this->db->set('show_slide', $show_slide);
        $this->db->set('add_slide', $add_slide);
        $this->db->set('edit_slide', $edit_slide);
        $this->db->set('del_slide', $del_slide);

        $this->db->set('show_product', $show_product);
        $this->db->set('add_product', $add_product);
        $this->db->set('edit_product', $edit_product);
        $this->db->set('del_product', $del_product);

        $this->db->set('show_router', $show_router);
        $this->db->set('add_router', $add_router);
        $this->db->set('edit_router', $edit_router);
        $this->db->set('del_router', $del_router);

        $this->db->set('show_user', $show_user);
        $this->db->set('add_user', $add_user);
        $this->db->set('edit_user', $edit_user);
        $this->db->set('del_user', $del_user);

        $this->db->where('role_id', 3);
        $this->db->update('role_management');
        redirect('user/role');
    }
    public function roleupdateoperatorhelp()
    {

        $show_help = $this->input->get('show_help');
        $add_help = $this->input->get('add_help');
        $edit_help = $this->input->get('edit_help');
        $del_help = $this->input->get('del_help');

        $this->db->set('show_help', $show_help);
        $this->db->set('add_help', $add_help);
        $this->db->set('edit_help', $edit_help);
        $this->db->set('del_help', $del_help);
        $this->db->where('role_id', 3);
        $this->db->update('role_management');
        redirect('user/role');
    }
    public function updaterolepelanggan()
    {
        $post = $this->input->post(null, TRUE);
        $this->db->set('show_usage', $post['show_usage']);
        $this->db->set('show_history', $post['show_history']);
        $this->db->set('cek_bill', $post['cek_bill']);
        $this->db->set('cek_usage', $post['cek_usage']);
        $this->db->set('show_speedtest', $post['show_speedtest']);
        $this->db->set('show_log', $post['show_log']);
        $this->db->set('show_help', $post['show_help']);
        $this->db->set('register_maps', $post['register_maps']);
        $this->db->set('register_coverage', $post['register_coverage']);
        $this->db->set('register_show', $post['register_show']);
        $this->db->where('role_id', 2);
        $this->db->update('role_management');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbaharui');
        }



        redirect('user/role');
    }
}
