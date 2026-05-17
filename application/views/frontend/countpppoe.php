<?php
$listrouter = $this->db->get('router')->result();
foreach ($listrouter as $router) {
    $totalcustomer = $this->db->get_where('customer', ['router' => $router->id])->num_rows();
    if ($totalcustomer > 0) {
        $getuserdb = $this->customer_m->getusersinkron($router->id)->result();
        if (count($getuserdb) > 0) {
            $user = $router->username;
            $ip = $router->ip_address;
            $pass = $router->password;
            $port = $router->port;
            $API = new Mikweb();
            $API->connect($ip, $user, $pass, $port);
            foreach ($getuserdb as $data) {
                $userclient = $data->user_mikrotik;
                if ($data->mode_user == 'PPPOE') {
                    $getuserpppoe = $API->comm("/ppp/secret/print", array(
                        '?service' => 'pppoe',
                    ));

                    foreach ($getuserpppoe as $pppoe) {
                        if ($pppoe['name'] == $userclient) {
                            $getusage = $API->comm("/interface/print", array(
                                "?name" => "<pppoe-$userclient>",
                            ));

                            $usage = $getusage['0']['tx-byte'] + $getusage['0']['rx-byte'];

                            $today = date('Y-m-d');
                            $cekusage = $this->db->get_where('customer_usage', ['date_usage' => $today, 'no_services' => $data->no_services])->row_array();

                            if ($cekusage > 0) {
                                if ($usage != 0) {
                                    $params = [
                                        'count_usage' =>  $cekusage['count_usage'] + $usage,
                                        'last_update' =>  time(),
                                    ];
                                    $this->db->where('id', $cekusage['id']);
                                    $this->db->update('customer_usage', $params);
                                    $cekscript = $API->comm("/system/script/print", array('?name' => "reset-pppoe-$userclient"));
                                    $id = $cekscript[0]['.id'];
                                    if (count($cekscript) == 0) {
                                        $API->comm("/system/script/add", array(
                                            "name" =>  "reset-pppoe-$userclient",
                                            "source" => "/interface reset-counters <pppoe-$userclient>",
                                        ));
                                    } else {
                                        $API->comm("/system/script/run", array(
                                            ".id" => $id,
                                        ));
                                    }
                                }
                            } else {
                                $params = [
                                    'no_services' => $data->no_services,
                                    'count_usage' =>  $usage,
                                    'date_usage' =>  $today,
                                    'last_update' =>  time(),
                                ];
                                $this->db->insert('customer_usage', $params);
                                $cekscript = $API->comm("/system/script/print", array('?name' => "reset-pppoe-$userclient"));
                                $id = $cekscript[0]['.id'];
                                if (count($cekscript) == 0) {
                                    $API->comm("/system/script/add", array(
                                        "name" =>  "reset-pppoe-$userclient",
                                        "source" => "/interface reset-counters <pppoe-$userclient>",
                                    ));
                                } else {
                                    $API->comm("/system/script/run", array(
                                        ".id" => $id,
                                    ));
                                }
                            }
                        }
                    }
                }
                if ($data->mode_user == 'Hotspot') {
                    $userhotspot = $API->comm("/ip/hotspot/user/print");
                    foreach ($userhotspot as $hotspot) {
                        if ($hotspot['name'] == $userclient) {
                            $getuser = $API->comm("/ip/hotspot/user/print", array("?name" => $userclient));
                            $usage = $getuser['0']['bytes-out'] + $getuser['0']['bytes-in'];
                            $today = date('Y-m-d');
                            $cekusage = $this->db->get_where('customer_usage', ['date_usage' => $today, 'no_services' => $data->no_services])->row_array();
                            if ($cekusage > 0) {
                                if ($usage != 0) {
                                    $params = [
                                        'count_usage' =>  $cekusage['count_usage'] + $usage,
                                        'last_update' =>  time(),
                                    ];
                                    $this->db->where('id', $cekusage['id']);
                                    $this->db->update('customer_usage', $params);
                                }
                            } else {
                                $params = [
                                    'no_services' => $data->no_services,
                                    'count_usage' =>  $usage,
                                    'date_usage' =>  $today,
                                    'last_update' =>  time(),
                                ];
                                $this->db->insert('customer_usage', $params);
                            }
                            if ($this->db->affected_rows() > 0) {
                                $id = $getuser[0]['.id'];
                                $API->comm("/ip/hotspot/user/reset-counters", array(
                                    ".id" => $id,
                                ));
                            }
                        }
                    }
                }
                if ($data->mode_user == 'Static') {
                    $simplequeue = $API->comm("/queue/simple/print");
                    foreach ($simplequeue as $static) {
                        if ($static['name'] == $userclient) {
                            $getuser = $API->comm("/queue/simple/print", array('?name' => $userclient));
                            $byte = $getuser['0']['bytes'];
                            $updl = explode("/", $byte);
                            $up = $updl['0'];
                            $dl = $updl['1'];
                            $usage =  $up + $dl;
                            $today = date('Y-m-d');
                            $cekusage = $this->db->get_where('customer_usage', ['date_usage' => $today, 'no_services' => $data->no_services])->row_array();
                            if ($cekusage > 0) {
                                if ($usage != 0) {
                                    $params = [
                                        'count_usage' =>  $cekusage['count_usage'] + $usage,
                                        'last_update' =>  time(),
                                    ];
                                    $this->db->where('id', $cekusage['id']);
                                    $this->db->update('customer_usage', $params);
                                }
                            } else {
                                $params = [
                                    'no_services' => $data->no_services,
                                    'count_usage' =>  $usage,
                                    'date_usage' =>  $today,
                                    'last_update' =>  time(),
                                ];
                                $this->db->insert('customer_usage', $params);
                            }
                            if ($this->db->affected_rows() > 0) {
                                $id = $getuser[0]['.id'];
                                $API->comm("/queue/simple/reset-counters", array(
                                    ".id" =>  $id,
                                ));
                            }
                        }
                    }
                }
            }
        }
    }
}
