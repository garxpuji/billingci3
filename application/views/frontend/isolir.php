<?php
$listisolir = $this->customer_m->getisolirpasca()->result();

if (count($listisolir) > 0) {
    $listrouter = $this->db->get('router')->result();
    foreach ($listrouter as $router) {
        $totalcustomer = $this->db->get_where('customer', ['router' => $router->id])->num_rows();
        if ($totalcustomer > 0) {
            $billpasca = $this->customer_m->getisolirpasca($router->id)->result();
            $user = $router->username;
            $ip = $router->ip_address;
            $pass = $router->password;
            $port = $router->port;
            $API = new Mikweb();
            $API->connect($ip, $user, $pass, $port);
            if (count($billpasca) > 0) {
                foreach ($billpasca as $data) {
                    $userclient = $data->user_mikrotik;
                    if ($data->mode_user == 'PPPOE') {
                        if ($data->action == 0) {
                            $getuser = $API->comm("/ppp/secret/print", array(
                                '?service' => 'pppoe',
                                '?disabled' => 'no',
                            ));
                            foreach ($getuser as $pppoe) {
                                if ($pppoe['name'] == $userclient) {
                                    $API->comm("/ppp/secret/disable", array(
                                        ".id" =>  $pppoe['.id'],
                                    ));
                                    $this->db->set('connection', 1);
                                    $this->db->where('customer_id', $data->customer_id);
                                    $this->db->update('customer');
                                }
                            };
                        } else {
                            $getuser = $API->comm("/ppp/secret/print", array(
                                '?service' => 'pppoe',
                            ));
                            foreach ($getuser as $pppoe) {
                                if ($pppoe['name'] == $userclient) {
                                    if ($data->type_ip == 0) {
                                        $API->comm("/ppp/secret/set", array(
                                            ".id" => $pppoe['.id'],
                                            "profile" => 'EXPIRED'
                                        ));
                                    } else {

                                        $ipstatic = $pppoe['remote-address'];
                                        $API->comm("/ip/firewall/address-list/add", array(
                                            'list' => 'EXPIRED',
                                            'address' => $ipstatic,
                                            'comment' => 'ISOLIR|' . $data->no_services . '',

                                        ));
                                    }
                                    $this->db->set('connection', 1);
                                    $this->db->where('customer_id', $data->customer_id);
                                    $this->db->update('customer');
                                }
                            };
                        }
                        $getactive = $API->comm("/ppp/active/print", array(
                            '?name' => $userclient,
                        ));
                        $idactive = $getactive[0]['.id'];
                        $API->comm("/ppp/active/remove", array(
                            ".id" =>  $idactive,
                        ));
                    }
                    if ($data->mode_user == 'Hotspot') {
                        if ($data->action == 0) {
                            $getuser = $API->comm("/ip/hotspot/user/print", array(
                                "?disabled" => 'no',
                            ));
                            foreach ($getuser as $hotspot) {
                                if ($hotspot['name'] == $userclient) {
                                    $API->comm("/ip/hotspot/user/disable", array(
                                        ".id" =>  $hotspot['.id'],
                                    ));
                                    $this->db->set('connection', 1);
                                    $this->db->where('customer_id', $data->customer_id);
                                    $this->db->update('customer');
                                }
                            };
                        } else {
                            $getuser = $API->comm("/ip/hotspot/user/print", array(
                                "?disabled" => 'no',
                            ));
                            foreach ($getuser as $hotspot) {
                                if ($hotspot['name'] == $userclient) {
                                    $API->comm("/ip/hotspot/user/set", array(
                                        ".id" =>  $hotspot['.id'],
                                        "profile" => 'EXPIRED'
                                    ));
                                    $this->db->set('connection', 1);
                                    $this->db->where('customer_id', $data->customer_id);
                                    $this->db->update('customer');
                                }
                            };
                        }

                        $getactive = $API->comm("/ip/hotspot/active/print", array(
                            "?user" => $userclient,
                        ));
                        $idactive = $getactive[0]['.id'];
                        $API->comm("/ip/hotspot/active/remove", array(
                            ".id" => $idactive,
                        ));
                        // var_dump($getactive);
                    }
                    if ($data->mode_user == 'Static') {
                        $simplequeue = $API->comm("/queue/simple/print", array('?name' => $userclient,));
                        $ipqueue = substr($simplequeue['0']['target'], 0, -3);
                        $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
                        $getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $data->no_services . ''));
                        // var_dump($getfirewall);
                        if ($data->action == 0) {
                            if (count($getfirewall) == 0) {
                                $API->comm("/ip/firewall/filter/add", array(
                                    'chain' => 'forward',
                                    'src-address' => $ipqueue,
                                    'action' => 'drop',
                                    'comment' => 'ISOLIR|' . $data->no_services . '',
                                ));
                            }
                        } else {
                            $API->comm("/ip/firewall/address-list/add", array(
                                'list' => 'EXPIRED',
                                'address' => $ipqueue,
                                'comment' => 'ISOLIR|' . $data->no_services . '',
                            ));
                        }
                        $this->db->set('connection', 1);
                        $this->db->where('customer_id', $data->customer_id);
                        $this->db->update('customer');
                    }
                    echo  $data->name;
                    echo '<br>';
                }
            }


            // OPEN ISOLIR
            // $customerpppoe = $this->db->get_where('customer', ['c_status' => 'Aktif', 'mode_user' => 'PPPOE'])->num_rows();

            // if ($customerpppoe > 0) {
            //     $pppoedisable = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?disabled' => 'true'));
            //     // var_dump($pppoedisable);
            //     if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //         echo 'Disable user';
            //     }
            //     foreach ($pppoedisable as $data) {
            //         $customer = $this->db->get_where('customer', ['user_mikrotik' => $data['name'], 'router' => $router->id])->row_array();
            //         // cek bill
            //         $bill = $this->customer_m->getopenisolir($customer['router'], $customer['no_services'])->result();
            //         // var_dump($bill);
            //         if (count($bill) == 0) {
            //             $API->comm("/ppp/secret/enable", array(
            //                 ".id" => $data['.id'],
            //             ));
            //         };
            //         if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //             echo '<br>';
            //             echo $data['name'];
            //             echo '<br>';
            //         }
            //     }
            //     $pppoeexpired = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?profile' => 'EXPIRED'));
            //     if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //         echo 'Expired user';
            //     }
            //     foreach ($pppoeexpired as $data) {
            //         $customer = $this->db->get_where('customer', ['user_mikrotik' => $data['name'], 'router' => $router->id])->row_array();
            //         // cek bill
            //         $bill = $this->customer_m->getopenisolir($customer['router'], $customer['no_services'])->result();
            //         // var_dump($bill);
            //         if (count($bill) == 0) {
            //             $API->comm("/ppp/secret/set", array(
            //                 ".id" => $data['.id'],
            //                 "profile" => $customer['user_profile'],
            //             ));
            //         };
            //         if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //             echo '<br>';
            //             echo $data['name'];
            //             echo '<br>';
            //         }
            //     }
            // }


            // $customerhotspot = $this->db->get_where('customer', ['c_status' => 'Aktif', 'mode_user' => 'Hotspot'])->num_rows();
            // if ($customerhotspot > 0) {
            //     $hotspotdisable = $API->comm("/ip/hotspot/user/print", array('?disabled' => 'true'));
            //     // var_dump($hotspotdisable);
            //     if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //         echo 'Disable user Hotspot';
            //     }
            //     foreach ($hotspotdisable as $data) {
            //         $customer = $this->db->get_where('customer', ['user_mikrotik' => $data['name'], 'router' => $router->id])->row_array();
            //         // cek bill
            //         $bill = $this->customer_m->getopenisolir($customer['router'], $customer['no_services'])->result();
            //         // var_dump($bill);
            //         if (count($bill) == 0) {
            //             $API->comm("/ip/hotspot/user/enable", array(
            //                 ".id" => $data['.id'],
            //             ));
            //         };
            //         if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //             echo '<br>';
            //             echo $data['name'];
            //             echo '<br>';
            //         }
            //     }
            //     $hotspotexpired = $API->comm("/ip/hotspot/user/print", array('?profile' => 'EXPIRED'));
            //     if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //         echo 'Expired user Hotspot';
            //     }
            //     foreach ($hotspotexpired as $data) {
            //         $customer = $this->db->get_where('customer', ['user_mikrotik' => $data['name'], 'router' => $router->id])->row_array();
            //         // cek bill
            //         $bill = $this->customer_m->getopenisolir($customer['router'], $customer['no_services'])->result();
            //         // var_dump($bill);
            //         if (count($bill) == 0) {
            //             $API->comm("/ip/hotspot/user/set", array(
            //                 ".id" => $data['.id'],
            //                 "profile" => $customer['user_profile'],
            //             ));
            //         };
            //         if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') {
            //             echo '<br>';
            //             echo $data['name'];
            //             echo '<br>';
            //         }
            //     }
            // }
            // $customerstatic = $this->db->get_where('customer', ['c_status' => 'Aktif', 'mode_user' => 'Static'])->num_rows();
            // if ($customerstatic > 0) {
            //     // disable user
            //     $userdrop = $API->comm("/ip/firewall/filter/print", array("?action" => 'drop'));
            //     // var_dump($userdrop);
            //     // die;

            //     // echo  $router->id;
            //     foreach ($userdrop as $data) {
            //         $no_services = explode("|", $data['comment']);
            //         if ($no_services['0'] == 'ISOLIR' && $no_services['1'] != '') {
            //             $bill = $this->customer_m->getopenisolir($router->id, $no_services['1'])->result();
            //             if (count($bill) == 0) {
            //                 // echo $data['.id'];
            //                 $API->comm("/ip/firewall/filter/remove", array(
            //                     ".id" => $data['.id'],
            //                     "?comment" => 'ISOLIR|' . $no_services['1'],
            //                 ));
            //             };
            //         }
            //     }
            // }
        }
    }
}
