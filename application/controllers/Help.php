<?php defined('BASEPATH') or exit('No direct script access allowed');

class Help extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model(['help_m', 'customer_m', 'logs_m', 'member_m', 'user_m']);
    }
    public function index()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['show_help'] == 0) {
            $this->session->set_flashdata('error', 'Akses dilarang');
            redirect('dashboard');
        }
        is_logged_in();
        $data['title'] = 'Lapor Gangguan';
        $customer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array();

        $cektiket = $this->help_m->getcekticket($customer['no_services'])->row_array();

        if ($cektiket > 0) {
            $this->session->set_flashdata('error-sweet', 'Upps, anda masih memiliki tiket gangguan yang belum selesai !');
            redirect('help/history');
        } else {
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['customer'] = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array();
            $data['type'] = $this->db->get('help_type')->result();
            $data['solution'] = $this->db->get('help_solution')->result();
            $data['company'] = $this->db->get('company')->row_array();
            $this->template->load('member', 'member/help/add', $data);
        }
    }
    public function del()
    {
        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role_id != 1 && $role['del_help'] == 0) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $post = $this->input->post(null, TRUE);
            $id = $post['id'];
            $help = $this->db->get_where('help', ['id' => $id])->row_array();
            if ($help == 0) {
                $this->session->set_flashdata('error-sweet', 'Gagal hapus tiket, data tiket tidak ditemukan');
            } else {
                $this->db->where('help_id', $id);
                $this->db->delete('help_timeline');
                $target_file = './assets/images/help/' . $help['picture'];
                unlink($target_file);
                $this->db->where('id', $id);
                $this->db->delete('help');
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success-sweet', 'Data Tiket berhasil dihapus');
                }
            }
        }

        redirect('help/data');
    }
    public function addhelp()
    {
        $post = $this->input->post(null, TRUE);
        $config['upload_path']          = './assets/images/help';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2048; // 2 Mb
        $config['file_name']             = 'help-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
        $this->load->library('upload', $config);
        $post = $this->input->post(null, TRUE);
        $customer = $this->db->get_where('customer', ['no_services' => $post['no_services']])->row_array();
        $type = $this->db->get_where('help_type', ['help_id' => $post['type']])->row_array();
        $solution = $this->db->get_where('help_solution', ['hs_id' => $post['solution']])->row_array();
        $createby = $this->session->userdata('name');
        if ($this->session->userdata('role_id') == 1) {
            $level = 'Administrator';
        } elseif ($this->session->userdata('role_id') == 2) {
            $level = 'Pelanggan';
        } elseif ($this->session->userdata('role_id') == 3) {
            $level = 'Operator';
        } elseif ($this->session->userdata('role_id') == 4) {
            $level = 'Mitra';
        }
        if (@FILES['picture']['name'] != null) {
            if ($this->upload->do_upload('picture')) {
                $post['picture'] =  $this->upload->data('file_name');
                $this->help_m->add($post);
                if ($this->db->affected_rows() > 0) {
                    if ($this->session->userdata('role_id') != 2) {
                        $this->session->set_flashdata('success-sweet', 'Tiket gangguan berhasil dibuat');
                    } elseif ($this->session->userdata('role_id') == 2) {
                        $this->session->set_flashdata('success-sweet', 'Tiket gangguan berhasil dibuat, mohon menunggu laporan anda akan segera kami proses.');
                    }
                    $customer = $this->db->get_where('customer', ['no_services' => $post['no_services']])->row_array();
                    $whatsapp = $this->db->get('whatsapp')->row_array();
                    if ($whatsapp['is_active'] == 1) {
                        $other = $this->db->get('other')->row_array();
                        $company = $this->db->get('company')->row_array();
                        // echo  $timeex;
                        if ($whatsapp['create_help'] == 1  or $whatsapp['create_help_admin'] == 1) {
                            $cekhelp = $this->help_m->getRecentTicket($customer['no_services'])->row_array();
                            if ($cekhelp < 0) {
                                $cekhelp = $this->db->get_where('help', ['no_services' => $customer['no_services'], 'status' => 'pending'])->row_array();
                            }
                            if ($customer['latitude'] != '' && $customer['longitude'] != '') {
                                $maps = "https://www.google.com/maps/place/" . $customer['latitude'] . "," . $customer['longitude'] . "";
                            } else {
                                $maps = 'Belum disetting';
                            }
                            $search  = array('{name}', '{noservices}', '{phone}', '{address}', '{email}', '{noticket}',  '{topic}', '{report}', '{remark}', '{maps}', '{companyname}',  '{slogan}', '{link}', '{e}');
                            $replace = array($customer['name'], $customer['no_services'], indo_tlp($customer['no_wa']), $customer['address'], $customer['email'], $cekhelp['no_ticket'], $type['help_type'], $solution['hs_name'], $post['remark'], $maps, $company['company_name'], $company['sub_name'], base_url(), '');
                            $subject = $other['create_help'];
                            $message = str_replace($search, $replace, $subject);
                            if ($whatsapp['create_help'] == 1) {
                                $teknisi = $this->db->get_where('user', ['role_id' => 5, 'is_active' => 1])->result();

                                $no = 1;
                                foreach ($teknisi as $data) {
                                    $range = $no++ * $whatsapp['interval_message'];
                                    $jadwall = time() + (1  * $range);
                                    $time = date('Y-m-d H:i:s', $jadwall);
                                    sendmsgsch(indo_tlp($data->phone), $message, $time);
                                }
                            }
                            if ($whatsapp['create_help_admin'] == 1) {
                                $teknisi = $this->user_m->adminteknisi()->result();
                                $no = 1;
                                foreach ($teknisi as $data) {
                                    $range = $no++ * $whatsapp['interval_message'];
                                    $jadwall = time() + (1  * $range);
                                    $time = date('Y-m-d H:i:s', $jadwall);
                                    sendmsgsch(indo_tlp($data->phone), $message, $time);
                                }
                            }
                        }
                    }
                    $bot = $this->db->get('bot_telegram')->row_array();
                    $tokens = $bot['token']; // token bot
                    $idgroupteknisi = $bot['id_group_teknisi'];
                    $sendmessage = [
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [
                                [
                                    // ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser/' . $post['no_services'])],
                                    // ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs/' . $post['no_services'])],
                                ]
                            ]
                        ]),
                        'resize_keyboard' => true,
                        'parse_mode' => 'html',
                        'text' => "<b>TIKET BARU $type[help_type]</b>\nNama : $customer[name]\nEmail : $customer[email]\nNo WA : $customer[no_wa]\nAlamat : $customer[address]\nTopik Gangguan : $type[help_type]\nLaporan : $solution[hs_name]\nKeterangan : $post[remark]\nStatus : Pending\nCreate By : $createby ($level)",
                        'chat_id' => $idgroupteknisi
                    ];

                    file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
                    // Kirim WA

                }
                if ($this->session->userdata('role_id') != 2) {
                    redirect($_SERVER['HTTP_REFERER']);
                } elseif ($this->session->userdata('role_id') == 2) {
                    echo "<script>window.location='" . site_url('help/history') . "'; </script>";
                }
            } else {
                $post['picture'] =  null;
                $this->help_m->add($post);
                if ($this->db->affected_rows() > 0) {
                    $customer = $this->db->get_where('customer', ['no_services' => $post['no_services']])->row_array();

                    $whatsapp = $this->db->get('whatsapp')->row_array();

                    if ($whatsapp['is_active'] == 1) {


                        $cekhelp = $this->help_m->getRecentTicket($customer['no_services'])->row_array();
                        if ($cekhelp < 0) {
                            $cekhelp = $this->db->get_where('help', ['no_services' => $customer['no_services'], 'status' => 'pending'])->row_array();
                        }
                        if ($customer['latitude'] != '' && $customer['longitude'] != '') {
                            $maps = "https://www.google.com/maps/place/" . $customer['latitude'] . "," . $customer['longitude'] . "";
                        } else {
                            $maps = 'Belum disetting';
                        }
                        $other = $this->db->get('other')->row_array();
                        $company = $this->db->get('company')->row_array();

                        $search  = array('{name}', '{noservices}', '{phone}', '{address}', '{email}', '{noticket}',  '{topic}', '{report}', '{remark}', '{maps}', '{companyname}',  '{slogan}', '{link}', '{e}');
                        $replace = array($customer['name'], $customer['no_services'], indo_tlp($customer['no_wa']), $customer['address'], $customer['email'], $cekhelp['no_ticket'], $type['help_type'], $solution['hs_name'], $post['remark'], $maps, $company['company_name'], $company['sub_name'], base_url(), '');
                        $subject = $other['create_help'];
                        $message = str_replace($search, $replace, $subject);
                        if ($whatsapp['create_help'] == 1) {
                            $teknisi = $this->db->get_where('user', ['role_id' => 5, 'is_active' => 1])->result();

                            $no = 1;
                            foreach ($teknisi as $data) {
                                $range = $no++ * $whatsapp['interval_message'];
                                $jadwall = time() + (1  * $range);
                                $time = date('Y-m-d H:i:s', $jadwall);
                                sendmsgsch(indo_tlp($data->phone), $message, $time);
                            }
                        }
                        if ($whatsapp['create_help_admin'] == 1) {
                            $teknisi = $this->user_m->adminteknisi()->result();
                            $no = 1;
                            foreach ($teknisi as $data) {
                                $range = $no++ * $whatsapp['interval_message'];
                                $jadwall = time() + (1  * $range);
                                $time = date('Y-m-d H:i:s', $jadwall);
                                sendmsgsch(indo_tlp($data->phone), $message, $time);
                            }
                        }
                    }
                }
                $message = 'Tambah Tiket Gangguan';
                $this->logs_m->activitylogs('Activity', $message);
                $this->session->set_flashdata('success-sweet', 'Data Tiket berhasil disimpan');
                $bot = $this->db->get('bot_telegram')->row_array();
                $tokens = $bot['token']; // token bot
                $idgroupteknisi = $bot['id_group_teknisi'];
                $sendmessage = [
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                // ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser/' . $post['no_services'])],
                                // ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs/' . $post['no_services'])],
                            ]
                        ]
                    ]),
                    'resize_keyboard' => true,
                    'parse_mode' => 'html',
                    'text' => "<b>TIKET GANGGUAN BARU</b>\nNama : $customer[name]\nEmail : $customer[email]\nNo WA : $customer[no_wa]\nAlamat : $customer[address]\nTopik Gangguan : $type[help_type]\nLaporan : $solution[hs_name]\nKeterangan : $post[remark]\nStatus : Pending\nCreate By : $createby ($level)",
                    'chat_id' => $idgroupteknisi
                ];

                file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
            }
            if ($this->session->userdata('role_id') == 1) {
                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->session->userdata('role_id') == 3) {
                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->session->userdata('role_id') == 2) {
                echo "<script>window.location='" . site_url('help/history') . "'; </script>";
            }
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            if ($this->session->userdata('role_id') == 1) {
                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->session->userdata('role_id') == 3) {
                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->session->userdata('role_id') == 2) {
                echo "<script>window.location='" . site_url('member/help') . "'; </script>";
            }
        }
    }
    public function setting()
    {
        is_logged_in();
        $data['title'] = 'Help Setting';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['type'] = $this->db->get('help_type')->result();
        $data['solution'] = $this->db->get('help_solution')->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/help/setting', $data);
    }
    public function addtype()
    {
        $params = [
            'help_type' => $this->input->post('name'),
            'help_remark' => $this->input->post('remark'),
        ];
        $this->db->insert('help_type', $params);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Jenis Bantuan berhasil disimpan');
        }
        redirect('help/setting');
    }
    public function edittype()
    {
        $post = $this->input->post(null, true);
        $params = [
            'help_type' => $this->input->post('name'),
            'help_remark' => $this->input->post('remark'),
        ];
        $this->db->where('help_id', $post['type_id']);
        $this->db->update('help_type', $params);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Jenis Bantuan berhasil diperbaharui');
        }
        redirect('help/setting');
    }

    public function addsolution()
    {
        is_logged_in();
        $data['title'] = 'Add Solution';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['type'] = $this->db->get('help_type')->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/help/add-solution', $data);
    }

    public function adds()
    {
        // $post = $this->input->post(null, true);
        $params = [
            'hs_help_id' => $this->input->post('type'),
            'hs_name' => $this->input->post('name'),
            'solution' => $this->input->post('solution'),
        ];

        $this->db->insert('help_solution', $params);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Jenis Bantuan berhasil diperbaharui');
        }
        redirect('help/setting');
    }

    public function deltype($id)
    {
        $solution = $this->db->get_where('help_solution', ['hs_help_id' => $id])->row_array();
        $help = $this->db->get_where('help', ['help_type' => $id])->row_array();
        if ($help > 0) {
            $this->session->set_flashdata('error', 'Gagal hapus type gangguan, karena masih terikat di data bantuan pelanggan');
        } elseif ($solution > 0) {
            $this->session->set_flashdata('error', 'Gagal hapus type gangguan, karena masih terikat dengan data solusi');
        } else {
            $this->db->where('help_id', $id);
            $this->db->delete('help_type');
            $this->session->set_flashdata('success', 'Data type berhasil dihapus');
        }
        redirect('help/setting');
    }

    public function editsolution($id)
    {
        is_logged_in();
        $data['title'] = 'Edit Solution';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['type'] = $this->db->get('help_type')->result();
        $data['solution'] = $this->db->get_where('help_solution', ['hs_id' => $id])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/help/edit-solution', $data);
    }
    public function edits()
    {
        $post = $this->input->post(null, true);
        $params = [
            'hs_help_id' => $this->input->post('type'),
            'hs_name' => $this->input->post('name'),
            'solution' => $this->input->post('solution'),
        ];

        $this->db->where('hs_id', $post['hs_id']);
        $this->db->update('help_solution', $params);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Solusi berhasil diperbaharui');
        }
        redirect('help/setting');
    }

    public function delsolution($id)
    {

        $help = $this->db->get_where('help', ['help_solution' => $id])->row_array();
        if ($help > 0) {
            $this->session->set_flashdata('error', 'Gagal hapus solusi gangguan, karena masih terikat di data bantuan pelanggan');
        } else {
            $this->db->where('hs_id', $id);
            $this->db->delete('help_solution');
            $this->session->set_flashdata('success', 'Data solusi berhasil dihapus');
        }
        redirect('help/setting');
    }

    public function showsolution($id)
    {
        is_logged_in();
        $data['title'] = 'Show Solution';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['type'] = $this->db->get('help_type')->result();
        $data['solution'] = $this->db->get_where('help_solution', ['hs_id' => $id])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/help/show-solution', $data);
    }

    public function getsolution()
    {
        $id = $this->input->post('type');
        $solution = $this->db->get_where('help_solution', ['hs_help_id' => $id])->result();
        echo "<option value=''>-Pilih-</option>";
        foreach ($solution as $data) {
            echo "<option value='{$data->hs_id}'>{$data->hs_name}</option>";
        }
    }
    public function getsolutiondetail()
    {
        $id = $this->input->post('solution');
        $solution = $this->db->get_where('help_solution', ['hs_id' => $id])->row_array();
        echo $solution['solution'];
    }

    public function history()
    {

        $data['title'] = 'Riwayat Gangguan';
        $customer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array();
        $data['help'] = $this->help_m->history($customer['no_services'])->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('member', 'member/help/history', $data);
    }
    public function data()
    {
        is_logged_in();
        $data['title'] = 'Data Help';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customertiket'] = $this->customer_m->getCustomertiket()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/help/data', $data);
    }
    public function pending()
    {
        is_logged_in();
        $data['title'] = 'Data Pending';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['customeraktif'] = $this->customer_m->getCustomerActive()->result();
        $data['help'] = $this->db->get_where('help', ['status' => 'pending'])->result();
        $this->template->load('backend', 'backend/help/data', $data);
    }
    public function proses()
    {
        is_logged_in();
        $data['title'] = 'Data Proses';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['help'] = $this->help_m->getprocess()->result();
        $data['customeraktif'] = $this->customer_m->getCustomerActive()->result();
        $this->template->load('backend', 'backend/help/data', $data);
    }
    public function done()
    {
        is_logged_in();
        $data['title'] = 'Data Close';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['help'] = $this->help_m->getdone()->result();
        $data['customeraktif'] = $this->customer_m->getCustomerActive()->result();
        $this->template->load('backend', 'backend/help/data', $data);
    }
    public function detail($id)
    {
        is_logged_in();
        $help = $this->db->get_where('help', ['id' => $id])->row_array();
        if ($help == 0) {
            $this->session->set_flashdata('error-sweet', 'Data tiket tidak ditemukan !');
            redirect('dashboard');
        }
        $data = [
            'title' => 'Detail Tiket',
            'user' =>  $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'company' => $this->db->get('company')->row_array(),
            'help' => $help,
        ];
        $this->template->load('backend', 'backend/help/detail', $data);
    }

    public function gettiket()
    {
        $post = $this->input->post(null, TRUE);
        $cek = $this->db->get_where('help', ['id' => $post['id']])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $cek['no_services']])->row_array();
        if ($cek['teknisi'] != 0) {
            $user = $this->db->get_where('user', ['id' => $cek['teknisi']])->row_array();
            $this->session->set_flashdata('error-sweet', 'Data tiket sedang ditangani oleh ' . $user['name'] . '');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->db->set('status', $post['status']);
            $this->db->set('teknisi', $this->session->userdata('id'));
            $this->db->where('id', $post['id']);
            $this->db->update('help');

            $params = [
                'help_id' => $cek['id'],
                'date_update' => time(),
                'remark' => $post['description'],
                'status' => $post['status'],
                'teknisi' => $this->session->userdata('id'),
            ];
            $this->db->insert('help_timeline', $params);
            if ($this->db->affected_rows() > 0) {
                $bot = $this->db->get('bot_telegram')->row_array();
                $tokens = $bot['token']; // token bot
                $createby = $this->session->userdata('name');
                if ($this->session->userdata('role_id') == 1) {
                    $level = 'Administrator';
                } elseif ($this->session->userdata('role_id') == 2) {
                    $level = 'Pelanggan';
                } elseif ($this->session->userdata('role_id') == 3) {
                    $level = 'Operator';
                } elseif ($this->session->userdata('role_id') == 4) {
                    $level = 'Mitra';
                }
                $type = $this->db->get_where('help_type', ['help_id' => $cek['help_type']])->row_array();
                $solution = $this->db->get_where('help_solution', ['hs_id' => $cek['help_solution']])->row_array();
                $idgroupteknisi = $bot['id_group_teknisi'];
                $sendmessage = [
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                // ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser/' . $post['no_services'])],
                                // ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs/' . $post['no_services'])],
                            ]
                        ]
                    ]),
                    'resize_keyboard' => true,
                    'parse_mode' => 'html',
                    'text' => "<b>UPDATE TIKET </b>\nNo Tiket : $cek[no_ticket]\nNama : $customer[name]\nEmail : $customer[email]\nNo WA : $customer[no_wa]\nAlamat : $customer[address]\nTopik Gangguan : $type[help_type]\nLaporan : $solution[hs_name]\nKeterangan : $post[remark]\nStatus : $post[status]\nKeterangan : $post[description]\nCreate By : $createby ($level)",
                    'chat_id' => $idgroupteknisi

                ];
                file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
                $this->session->set_flashdata('success-sweet', 'Tiket berhasil diperbaharui');
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function updatetiket()
    {
        $post = $this->input->post(null, TRUE);
        $cek = $this->db->get_where('help', ['id' => $post['id']])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $cek['no_services']])->row_array();
        $this->db->set('status', $post['status']);
        if ($post['status' == 'done'] && $this->session->userdata('role_id') != 2) {
            $this->db->set('teknisi', $this->session->userdata('id'));
        };
        $this->db->where('id', $post['id']);
        $this->db->update('help');

        $params = [
            'help_id' => $cek['id'],
            'date_update' => time(),
            'status' => $post['status'],
            'remark' => $post['description'],
            'teknisi' => $this->session->userdata('id'),
        ];
        $this->db->insert('help_timeline', $params);
        if ($this->db->affected_rows() > 0) {
            $bot = $this->db->get('bot_telegram')->row_array();
            $tokens = $bot['token']; // token bot
            $createby = $this->session->userdata('name');
            if ($this->session->userdata('role_id') == 1) {
                $level = 'Administrator';
            } elseif ($this->session->userdata('role_id') == 2) {
                $level = 'Pelanggan';
            } elseif ($this->session->userdata('role_id') == 3) {
                $level = 'Operator';
            } elseif ($this->session->userdata('role_id') == 5) {
                $level = 'Teknisi';
            } elseif ($this->session->userdata('role_id') == 4) {
                $level = 'Mitra';
            }
            $type = $this->db->get_where('help_type', ['help_id' => $cek['help_type']])->row_array();
            $solution = $this->db->get_where('help_solution', ['hs_id' => $cek['help_solution']])->row_array();
            $idgroupteknisi = $bot['id_group_teknisi'];
            $sendmessage = [
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            // ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser/' . $post['no_services'])],
                            // ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs/' . $post['no_services'])],
                        ]
                    ]
                ]),
                'resize_keyboard' => true,
                'parse_mode' => 'html',
                'text' => "<b>UPDATE TIKET $type[help_type]</b>\nNo Tiket : $cek[no_ticket]\nNama : $customer[name]\nEmail : $customer[email]\nNo WA : $customer[no_wa]\nAlamat : $customer[address]\nTopik Gangguan : $type[help_type]\nLaporan : $solution[hs_name]\nKeterangan : $post[remark]\nStatus : $post[status]\nKeterangan : $post[description]\nCreate By : $createby ($level)",
                'chat_id' => $idgroupteknisi
            ];
            file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
            $this->session->set_flashdata('success-sweet', 'Tiket berhasil diperbaharui');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function donecustomer()
    {
        $post = $this->input->post(null, TRUE);
        $cek = $this->db->get_where('help', ['id' => $post['id']])->row_array();
        if ($cek['status'] == 'close') {
            $this->session->set_flashdata('success-sweet', 'Tiket berhasil diperbaharui');
        } else {
            $this->db->set('status', 'close');
            if ($post['status' == 'done'] && $this->session->userdata('role_id') != 2) {
                $this->db->set('teknisi', $this->session->userdata('id'));
            };
            $this->db->where('id', $post['id']);
            $this->db->update('help');

            $params = [
                'help_id' => $cek['id'],
                'date_update' => time(),
                'status' => 'close',
                'remark' => $post['description'],
                'teknisi' => $this->session->userdata('id'),
            ];
            $this->db->insert('help_timeline', $params);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success-sweet', 'Tiket berhasil diperbaharui');
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // server side
    public function serverhelp()
    {
        $result = $this->help_m->serverhelp();
        $data = [];
        $no = $_POST['start'];

        foreach ($result as $result) {

            $action = ' 
               <a href="' . site_url('help/detail/' . $result->id) . '"  title="Detail"><i class="fa fa-clone" style="font-size:20px; color:green"></i></a>
             
              <a href=""  data-toggle="modal" id="deletehelp" data-idhelp=' . $result->id . ' data-tiket=' . $result->no_ticket . ' data-target="#delete" title="Hapus"><i class="fa fa-trash" style="font-size:20px; color:red"></i></a>        ';

            $type = $this->db->get_where('help_type', ['help_id' => $result->help_type])->row_array();
            $hs = $this->db->get_where('help_solution', ['hs_id' => $result->help_solution])->row_array();

            $row = [
                'no' => ++$no,
                'date_created' => date('d M Y H:i:s', $result->date_created),
                'no_ticket' => $result->no_ticket,
                'name' => $result->name,
                'no_services' => $result->no_services,
                'report' => $type['help_type'] . '<br>' . $hs['hs_name'],
                'status' =>  ucwords(strtolower($result->status)),
                'action' => $action,
                'description' => $result->description,


            ];
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->help_m->count_all_data_help(),
            "recordsFiltered" => $this->help_m->count_filtered_data_help(),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
