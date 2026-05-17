<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['customer_m', 'logs_m']);
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('dashboard');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/login', $data);
        } else {
            $this->_login();
        }
    }
    private function _login()
    {
        $mode = $this->input->post('mode');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        if ($mode == 'phone') {
            $user = $this->db->get_where('user', ['phone' => $email])->row_array(); // select * where user email = email
        } else {
            $user = $this->db->get_where('user', ['email' => $email])->row_array(); // select * where user email = email
        }
        // user ada
        if ($user) {
            // jika user active
            if ($user['is_active'] == 1) {
                # cek password dan verifikasi dengan input
                if (password_verify($password, $user['password'])) {
                    # jika sama
                    $data = [
                        'login' => true,
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'role_id' => $user['role_id']
                    ];
                    if (!empty($this->input->post("remember"))) {
                        setcookie("loginId", $email, time() + (10 * 365 * 24 * 60 * 60));
                        setcookie("loginMode", $mode, time() + (10 * 365 * 24 * 60 * 60));
                        setcookie("loginPass", $password,  time() + (10 * 365 * 24 * 60 * 60));
                    } else {
                        setcookie("loginId", "");
                        setcookie("loginMode", "");
                        setcookie("loginPass", "");
                    }
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        $this->session->set_flashdata('success', 'Selamat datang kembali ' . $user['name']);
                        redirect('dashboard');
                    }
                    if ($user['role_id'] == 3) {
                        $this->session->set_flashdata('success', 'Selamat datang kembali ' . $user['name']);
                        redirect('dashboard');
                    }
                    if ($user['role_id'] == 4) {
                        $this->session->set_flashdata('success', 'Selamat datang kembali ' . $user['name']);
                        redirect('dashboard');
                    }
                    if ($user['role_id'] == 5) {
                        $this->session->set_flashdata('success', 'Selamat datang kembali ' . $user['name']);
                        redirect('dashboard');
                    } else {
                        redirect('member');
                    }
                    $message = $email . ' Berhasil Login';
                    $this->logs_m->activitylogs('Activity', $message);
                } else {
                    # jika tidak sama atau error
                    $this->session->set_flashdata('error', 'Password Salah ! ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Alamat email belum di aktivasi, silahkan cek email atau hubungi admin ! ');
                redirect('auth');
            }
        } else {
            // jika tidak ada
            $this->session->set_flashdata('error', ' Alamat email atau No Telpon belum terdaftar ! ');
            redirect('auth');
        }
    }

    public function register()
    {
        if ($this->session->userdata('email')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]'); // cek tabel user field email
        $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'required|trim|min_length[9]|is_unique[user.phone]'); // cek tabel user field email
        $this->form_validation->set_rules('no_ktp', 'No ID', 'required|trim|min_length[9]'); // cek tabel user field email
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
            $this->load->view('backend/auth/register', $data);
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
                    'role_id' => 2,
                    'phone' => $this->input->post('no_wa', true),
                    'address' => htmlspecialchars($this->input->post('address', true)),
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
                $send = $this->db->get('email')->row_array();
                if ($send['forgot_password'] == 1) {
                    $this->db->insert('user_token', $user_token);
                    $this->_sendEmail($token, 'forgot');
                    $this->session->set_flashdata('error', ' Alamat email sudah terdaftar ! silahkan cek email anda untuk perbaharui password');
                } else {
                    $this->session->set_flashdata('error', ' Alamat email sudah terdaftar ! silahkan hubungi Admin untuk perbaharui password');
                }
                redirect('auth');
            } else {
                $post = $this->input->post(null, TRUE);
                $email = $this->input->post('email', true);
                $data = [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($email),
                    'image' => 'default.jpg',
                    'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'role_id' => 2,
                    'phone' => $this->input->post('no_wa', true),
                    'address' => htmlspecialchars($this->input->post('address', true)),
                    'is_active' => 0,
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

                $this->customer_m->addregist($post);
                // TAMBAH LAYANAN
                $item = $this->db->get_where('package_item', ['p_item_id' => $post['paket']])->row_array();
                $datapaket = [
                    'item_id' => $item['p_item_id'],
                    'email' => $email,
                    'category_id' => $item['category_id'],
                    // 'no_services' => $post['no_services'],
                    'qty' => 1,
                    'disc' => 0,
                    'price' => $item['price'],
                    'total' => $item['price'],
                    'services_create' => time(),
                ];
                $this->db->insert('services', $datapaket);
                $bot = $this->db->get('bot_telegram')->row_array();
                $tokens = $bot['token']; // token bot
                $owner = $bot['id_telegram_owner'];
                $price = indo_currency($item['price']);
                $sendmessage = [
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser?email=' . $post['email'])],
                                ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs?email=' . $post['email'])],
                            ]
                        ]
                    ]),
                    'resize_keyboard' => true,
                    'parse_mode' => 'html',
                    'text' => "<b>PELANGGAN BARU</b>\nNama : $post[name]\nEmail : $post[email]\nNo WA : $post[no_wa]\n$post[type_id] : $post[no_ktp]\nAlamat : $post[address]\nPaket : $item[name] - $price\n",
                    'chat_id' => $owner
                ];

                file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
                if ($post['lat'] != null) {
                    file_get_contents("https://api.telegram.org/bot$tokens/sendlocation?chat_id=$owner&latitude=$post[lat]&longitude=$post[long]");
                }

                $send = $this->db->get('email')->row_array();
                if ($send['send_verify'] == 1) {
                    $this->db->insert('user_token', $user_token);
                    $this->_sendEmail($token, 'verify');
                    $this->session->set_flashdata('success', 'Selamat, pendaftaran berhasil, silahkan periksa email untuk aktivasi akun anda.');
                } else {
                    $this->session->set_flashdata('success', 'Selamat, pendaftaran berhasil, silahkan hubungi Admin aktivasi akun anda.');
                }
                redirect('auth');
            }
        }
    }
    private function _sendEmail($token, $type)
    {
        $email = $this->db->get('email')->row_array();
        $config = [
            'protocol'  => $email['protocol'],
            'smtp_host' => $email['host'],
            'smtp_user' => $email['email'],
            'smtp_pass' => $email['password'],
            'smtp_port' => $email['port'],
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap' => true,
            'newline'   => "\r\n"
        ];
        $this->email->initialize($config);
        $this->load->library('email', $config);
        $this->email->from($email['email'], $email['name']); // isi Alamat email dan nama pengirim
        $this->email->to($this->input->post('email'));
        if ($type == 'verify') {
            $this->email->subject('Verifikasi Akun');
            $this->email->message('Silahkan diklik untuk verifikasi akun : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activasi Akun</a> atau klik tautan ini ' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '');
        } elseif ($type == 'forgot') {
            $this->email->subject('Perbaharui Password');
            $this->email->message('Silahkan diklik untuk perbaharui password : <a href="' . base_url() . 'auth/resetpassword?mode=0&email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Perbaharui Password</a> atau klik tautan ini ' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('success', '
                    ' . $email . ' has been actived. Please login.
                  ');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('error', 'Account activation failed! Token Expired.
                  ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Account activation failed! Wrong token.
              ');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Account activation failed! Wrong email.
          ');
            redirect('auth');
        }
    }
    public function logout()
    {
        logout();
        $this->session->set_flashdata('success-sweet', ' Logout Berhasil !');
        redirect('auth');
    }
    public function forgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/forgot-password', $data);
        } else {
            $email = $this->input->post('email');
            $mode = $this->input->post('mode');


            if ($mode == 'phone') {
                $user = $this->db->get_where('user', ['phone' => $email, 'is_active' => 1])->row_array();
            } else {
                $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
            }

            if ($user) {
                if ($mode == 'phone') {
                    $token = random_int(100000, 999999);
                    $type = 1;
                } else {
                    $token = base64_encode(random_bytes(32));
                    $type = 0;
                }
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'type' => $type,
                    'date_created' => time()
                ];
                $send = $this->db->get('email')->row_array();
                if ($mode == 'phone') {
                    $whatsapp = $this->db->get('whatsapp')->row_array();
                    $other = $this->db->get('other')->row_array();
                    $company = $this->db->get('company')->row_array();
                    if ($whatsapp['is_active'] == 1) {
                        $this->db->insert('user_token', $user_token);
                        $search  = array('{otp}', '{companyname}',  '{slogan}', '{link}', '{e}');
                        $replace = array($token, $company['company_name'], $company['sub_name'], base_url(), '');
                        $subject = $other['code_otp'];
                        $message = str_replace($search, $replace, $subject);
                        $target = indo_tlp($email);
                        sendmsg($target, $message);
                        $this->session->set_userdata('reset_email', $email);
                        $this->session->set_flashdata('success', 'Silahkan cek whatsaapp anda dan masukkan kode OTP yg diterima !');

                        redirect('auth/verifyotp');
                    } else {
                        $this->session->set_flashdata('success', 'Silahkan hubungi admin untuk reset password anda');
                    }
                } else {
                    if ($send['forgot_password'] == 1) {
                        $this->db->insert('user_token', $user_token);
                        $this->_sendEmail($token, 'forgot');
                        $this->session->set_flashdata('success', 'Silahkan cek email untuk reset password !');
                    } else {
                        $this->session->set_flashdata('success', 'Silahkan hubungi admin untuk reset password anda');
                    }
                }

                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('error', 'Email belum terdaftar !');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $mode = $this->input->get('mode');
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        if ($mode == 1) {
            $user = $this->db->get_where('user', ['phone' => $email])->row_array();
        } else {

            $user = $this->db->get_where('user', ['email' => $email])->row_array();
        }

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 1)) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                } else {
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('error', '
                    Reset password failed! Token / OTP Expired.
                 ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', '
                Reset password failed! Wrong token.
             ');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', ' Email atau No Whatsapp tidak terdaftar.
         ');
            redirect('auth');
        }
    }
    public function verifyotp()
    {
        $this->form_validation->set_rules('otp', 'Otp', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/verifyotp', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $token = $this->db->get_where('user_token', ['email' => $post['phone'], 'token' => $post['otp']])->row_array();
            if ($token > 0) {
                redirect('auth/resetpassword?mode=1&email=' . $post['phone'] . '&token=' . urlencode($post['otp']));
            } else {
                $this->session->set_flashdata('error', 'No Telp atau Kode OTP tidak cocok ! ');
                redirect('auth/forgotpassword');
            }
        }
    }


    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password not match !',
            'min_length' => 'Password too short !'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Reset Password';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/change-password', $data);
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->or_where('phone', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('success', '
            Password has been changed! Please login.
         ');
            redirect('auth');
        }
    }
}
