    <?php $this->view('messages') ?>
    <?php $cekbillisolir = $this->customer_m->getrecheckisolir($customer['router'], $customer['no_services'])->row_array();
    if ($cekbillisolir > 0) {
        isolir($customer['no_services'], $customer['router']);
    } else {
    }
    ?>
    <?php
    $router = $this->db->get_where('router', ['id' => $customer['router']])->row_array();
    $ip = $router['ip_address'];
    $user = $router['username'];
    $pass = $router['password'];
    $port = $router['port'];
    $API = new Mikweb();
    $usermikrotik = $customer['user_mikrotik'];
    $API->connect($ip, $user, $pass, $port);
    if ($customer['user_mikrotik'] != '') {
        // countusage($customer['no_services'], $customer['router']);
    }
    // Mode Hotspot
    if ($customer['mode_user'] == 'Hotspot') {
        # code...
        $hotspotactive = $API->comm("/ip/hotspot/active/print", array("?user" => $usermikrotik));
        $userhotspot = $API->comm("/ip/hotspot/user/print", array("?name" => $usermikrotik));
        $simplequeuehotspot = $API->comm("/queue/simple/print", array('?name' => '<hotspot-' . $usermikrotik . '>',));
        $userprofilehotspot = $API->comm("/ip/hotspot/user/profile/print", array("?name" => $customer['user_profile']));
        $countuserprofilehotspot = count($userprofilehotspot);
    }

    // Mode PPPOE
    if ($customer['mode_user'] == 'PPPOE') {
        $pppoeactive = $API->comm("/ppp/active/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
        $userpppoe = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
        $getaddresslist = $API->comm("/ip/firewall/address-list/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
        $userprofilepppoe = $API->comm("/ppp/profile/print", array('?name' => $customer['user_profile'],));
        $countuserprofilepppoe = count($userprofilepppoe);
    }


    // Mode Static
    if ($customer['mode_user'] == 'Static') {
        $simplequeue = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
        $ipqueue = substr($simplequeue['0']['target'], 0, -3);
        $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
        $getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
        $getaddresslist = $API->comm("/ip/firewall/address-list/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
    }


    ?>
    <?php if ($customer['mode_user'] == 'Standalone') { ?>
        <?php

        $resource = $API->comm("/system/resource/print");

        ?>

    <?php } ?>
    <?php if ($customer['mode_user'] == 'Hotspot') { ?>
        <?php
        $byte = $simplequeuehotspot['0']['bytes'];
        $updl = explode("/", $byte);
        $up = $updl['0'];
        $dl = $updl['1'];
        ?>

        <?php $userprofile = $countuserprofilehotspot ?>
    <?php } ?>

    <?php if ($customer['mode_user'] == 'PPPOE') { ?>

        <?php $userprofile = $countuserprofilepppoe ?>
    <?php } ?>
    <?php if ($customer['mode_user'] == 'Standalone') { ?>

    <?php } ?>

    <?php if ($customer['mode_user'] == 'Static') { ?>
        <?php
        $byte = $simplequeue['0']['bytes'];
        $updl = explode("/", $byte);
        $up = $updl['0'];
        $dl = $updl['1'];
        ?>

    <?php } ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Data Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col">Nama</div>
                                <div class="col">: <?= $customer['name']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col">No Layanan</div>
                                <div class="col">: <?= $customer['no_services']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col">Router</div>
                                <?php $router = $this->db->get_where('router', ['id' => $customer['router']])->row_array() ?>
                                <div class="col">: <?= $router['alias']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col">Mode</div>
                                <div class="col">: <?= $customer['mode_user']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col">User </div>
                                <div class="col">: <?= $customer['user_mikrotik']; ?></div>
                            </div>
                            <?php if ($customer['mode_user'] == 'PPPOE') { ?>
                                <div class="row">
                                    <div class="col">Uptime</div>
                                    <div class="col">: <?= formattimemikro($pppoeactive['0']['uptime']); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col">IP Address</div>
                                    <div class="col">: <?= $pppoeactive['0']['address']; ?></div>
                                </div>
                            <?php } ?>
                            <?php if ($customer['mode_user'] == 'Static') { ?>

                                <div class="row">
                                    <div class="col">IP Address</div>
                                    <div class="col">: <?= $ipqueue; ?></div>
                                </div>
                            <?php } ?>
                            <?php if ($customer['mode_user'] == 'Standalone') { ?>
                                <div class="row">
                                    <div class="col">Uptime</div>
                                    <div class="col">: <?= formattimemikro($resource['0']['uptime']); ?></div>
                                </div>
                            <?php } ?>
                            <?php if ($customer['mode_user'] == 'Hotspot') { ?>
                                <div class="row">
                                    <div class="col">Uptime</div>
                                    <div class="col">: <?= formattimemikro($hotspotactive['0']['uptime']); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col">IP Address</div>
                                    <div class="col">: <?= $hotspotactive['0']['address']; ?></div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col">Pemakaian</div>
                                <?php $usage = $this->mikrotik_m->usagethismonth($customer['no_services'])->result();

                                $totalusage = 0;
                                foreach ($usage as $c => $usage) {
                                    $totalusage += $usage->count_usage;
                                }
                                ?>
                                <?php $last = $this->mikrotik_m->lastusage($customer['no_services'])->row_array() ?>

                                <div class="col">: <?= formatBites($totalusage, 2); ?>
                                    last Update : <?= date('d-m-Y  H:i:s', $last['last_update']); ?>
                                    <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
                                    <?php if ($rolepelanggan == 1) { ?>
                                        <?php if ($customer['mode_user'] == 'PPPOE') { ?>
                                            <a href="<?= site_url('mikrotik/refreshpppoe/' . $customer['no_services']) ?>" title="Refresh Pemakaian"><i class="fas fa-sync"></a></i>
                                        <?php } ?>
                                        <?php if ($customer['mode_user'] == 'Standalone') { ?>
                                            <a href="<?= site_url('mikrotik/refreshstandalone/' . $customer['no_services']) ?>" title="Refresh Pemakaian"><i class="fas fa-sync"></a></i>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">Status</div>
                                <div class="col">:
                                    <?php if ($customer['mode_user'] == 'Hotspot') { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if ($userhotspot['0']['disabled'] == 'true') {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (count($hotspotactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } elseif (count($hotspotactive) <= 0) {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>
                                            <?php if ($userhotspot['0']['profile'] == 'EXPIRED') {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (count($hotspotactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } elseif (count($hotspotactive) <= 0) {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'PPPOE') { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if ($userpppoe['0']['disabled'] == 'true') {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (count($pppoeactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } elseif (count($pppoeactive) <= 0) {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>


                                            <?php if ($userpppoe['0']['profile'] == 'EXPIRED' or count($getaddresslist) > 0) {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (count($pppoeactive) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } elseif (count($pppoeactive) <= 0) {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'Static') { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if (count($getfirewall) > 0) {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (count($getarp) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } elseif (count($getarp) <= 0) {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] > 0) { ?>
                                            <?php if (count($getaddresslist) > 0) {
                                                echo '<div class="badge badge-warning">Isolir</div>';
                                            } elseif (count($getarp) > 0) {
                                                echo '<div class="badge badge-success">Active</div>';
                                            } elseif (count($getarp) <= 0) {
                                                echo '<div class="badge badge-danger">Non-Active</div>';
                                            }
                                            ?>
                                        <?php } ?>

                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'Standalone') { ?>
                                        <?php if ($resource['0']['uptime'] > 0) {
                                            echo '<div class="badge badge-success">Active</div>';
                                        } elseif (count($getarp) <= 0) {
                                            echo '<div class="badge badge-danger">Non-Active</div>';
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($customer['auto_isolir'] == 1) { ?>
                                <div class="row">
                                    <div class="col">Auto Isolir</div>
                                    <div class="col">: <?= $customer['auto_isolir'] == 1 ? 'Yes' : 'No' ?></div>
                                </div>
                                <div class="row">
                                    <div class="col">Action Isolir</div>
                                    <div class="col">: <?= $customer['action'] == 1 ? 'Pindah Profile' : 'Disable User' ?>
                                        <?php if ($customer['mode_user'] == 'PPPOE' && $customer['type_ip'] == 1) { ?>
                                            - IP PPPOE Static / Remote Address masuk ke address-list IP -> Firewall -> Address List
                                        <?php } ?>

                                    </div>
                                </div>
                                <?php if ($customer['mode_user'] == 'PPPOE' or $customer['mode_user'] == 'Hotspot') { ?>
                                    <?php if ($customer['action'] == '1') { ?>
                                        <div class="row">
                                            <div class="col">User Profile Paket</div>
                                            <div class="col">:
                                                <?= $customer['user_profile']; ?>
                                                <span>
                                                    <?php if ($userprofile > 0) { ?>
                                                        <div class="badge badge-success">matching</div>
                                                    <?php } ?>

                                                    <?php if ($userprofile == 0) { ?>
                                                        <div class="badge badge-danger">mismatch</div>
                                                    <?php } ?>
                                                </span>
                                            </div>

                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <div class="row d-sm-flex align-items-center justify-content-between mt-3">
                                <div class="col mb-1">
                                    <a href="" class="btn btn-primary"> Refresh</a>
                                </div>
                                <div class="col mb-1">
                                    <a href="<?= site_url('customer/edit/' . $customer['customer_id']) ?>" class="btn btn-primary"> Edit</a>
                                </div>
                                <div class="col mb-1">
                                    <?php if ($customer['mode_user'] == "Hotspot") { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if ($userhotspot['0']['disabled'] == 'true') { ?>
                                                <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                            <?php } ?>
                                            <?php if ($userhotspot['0']['disabled'] == 'false') { ?>
                                                <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>
                                            <?php if ($userhotspot['0']['profile'] == 'EXPIRED') { ?>
                                                <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                            <?php } ?>
                                            <?php if ($userhotspot['0']['profile'] != 'EXPIRED') { ?>
                                                <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == "PPPOE") { ?>
                                        <a class="btn btn-danger" href="<?= site_url('router/kick/' . $customer['no_services']) ?>" title="Kick User Aktif" onclick="return confirm('Apakah anda yakin akan kick user  <?= $customer['user_mikrotik'] ?> dari sesi aktif ?')"></i>Kick </a>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if ($userpppoe['0']['disabled'] == 'true') { ?>
                                                <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                            <?php } ?>
                                            <?php if ($userpppoe['0']['disabled'] == 'false') { ?>
                                                <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>
                                            <?php if ($userpppoe['0']['profile'] == 'EXPIRED' or count($getaddresslist) > 0) { ?>
                                                <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                            <?php } ?>
                                            <?php if ($userpppoe['0']['profile'] != 'EXPIRED' or count($getaddresslist) < 0) { ?>
                                                <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                            <?php } ?>
                                        <?php } ?>

                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == "Static") { ?>
                                        <?php if ($customer['action'] == 0) { ?>
                                            <?php if (count($getfirewall) > 0) { ?>
                                                <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                            <?php } ?>
                                            <?php if (count($getfirewall) == 0) { ?>
                                                <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($customer['action'] == 1) { ?>
                                            <?php if (count($getaddresslist) > 0) { ?>
                                                <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                            <?php } ?>
                                            <?php if (count($getaddresslist) == 0) { ?>
                                                <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <?php $id = str_replace('*', '', $userhotspot['0']['.id']) ?>
                                <!-- <?php if ($customer['mode_user'] == "Hotspot") { ?>
                                    <a class="btn btn-warning" href="<?= site_url('mikrotik/resethotspot/' . $customer['no_services']) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user Hotspot <?= $customer['user_mikrotik'] ?> ?')"></i>Reset Pemakaian</a>
                                <?php } ?>
                                <?php if ($customer['mode_user'] == "Static") { ?>
                                    <a class="btn btn-warning" href="<?= site_url('mikrotik/resetstatic/' . $customer['no_services']) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Reset Pemakaian</a>
                                <?php } ?>
                                <?php if ($customer['mode_user'] == "PPPOE") { ?>
                                    <a class="btn btn-warning" href="<?= site_url('mikrotik/resetpppoe/' .  $customer['no_services']) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user PPPOE <?= $customer['user_mikrotik'] ?> ?')"></i>Reset Pemakaian</a>
                                <?php } ?>
                                <?php if ($customer['mode_user'] == "Standalone") { ?>
                                    <a class="btn btn-warning" href="<?= site_url('mikrotik/resetstandalone/' .  $customer['no_services']) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian Interface <?= $customer['user_mikrotik'] ?> ?')"></i>Reset Pemakaian</a>
                                <?php } ?> -->
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($customer['mode_user'] == 'PPPOE' or $customer['mode_user'] == 'Hotspot') { ?>
                    <?php if ($customer['action'] == '1') { ?>
                        <div class="container">Catatan : <br>
                            <div class="badge badge-success">matching</div> : User profile terdaftar di data profile PPPOE / Hotspot <br>
                            <div class="badge badge-danger">mismatch</div> : User profile tidak terdaftar di data profile PPPOE / Hotspot, segera edit profile agar fitur Auto Isolir (action : Ganti Profile) berjalan.<br>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <?php if ($customer['mode_user'] == 'Hotspot') { ?>
            <?php if ($customer['action'] == 0) { ?>
                <?php if ($userhotspot['0']['disabled'] == 'true') {
                    $livetrafic = 0;
                } elseif (count($hotspotactive) > 0) {
                    $livetrafic = 1;
                } elseif (count($hotspotactive) <= 0) {
                    $livetrafic = 0;
                }
                ?>
            <?php } ?>
            <?php if ($customer['action'] == 1) { ?>
                <?php if ($userhotspot['0']['profile'] == 'EXPIRED') {
                    $livetrafic = 0;
                } elseif (count($hotspotactive) > 0) {
                    $livetrafic = 1;
                } elseif (count($hotspotactive) <= 0) {
                    $livetrafic = 0;
                }
                ?>
            <?php } ?>
        <?php } ?>
        <?php if ($customer['mode_user'] == 'PPPOE') { ?>
            <?php if ($customer['action'] == 0) { ?>
                <?php if ($userpppoe['0']['disabled'] == 'true') {
                    $livetrafic = 0;
                } elseif (count($pppoeactive) > 0) {
                    $livetrafic = 1;
                } elseif (count($pppoeactive) <= 0) {
                    $livetrafic = 0;
                }
                ?>
            <?php } ?>
            <?php if ($customer['action'] == 1) { ?>
                <?php if ($userpppoe['0']['profile'] == 'EXPIRED') {
                    $livetrafic = 0;
                } elseif (count($pppoeactive) > 0) {
                    $livetrafic = 1;
                } elseif (count($pppoeactive) <= 0) {
                    $livetrafic = 0;
                }
                ?>
            <?php } ?>
        <?php } ?>
        <?php if ($customer['mode_user'] == 'Static') { ?>
            <?php if ($customer['action'] == 0) { ?>
                <?php if (count($getfirewall) > 0) {
                    $livetrafic = 0;
                } elseif (count($getarp) > 0) {
                    $livetrafic = 1;
                } elseif (count($getarp) <= 0) {
                    $livetrafic = 0;
                }
                ?>
            <?php } ?>
            <?php if ($customer['action'] > 0) { ?>
                <?php if (count($getaddresslist) > 0) {
                    $livetrafic = 0;
                } elseif (count($getarp) > 0) {
                    $livetrafic = 1;
                } elseif (count($getarp) <= 0) {
                    $livetrafic = 0;
                }
                ?>
            <?php } ?>

        <?php } ?>
        <?php if ($customer['mode_user'] == 'Standalone') { ?>
            <?php if ($resource['0']['uptime'] > 0) {
                $livetrafic = 1;
            } elseif (count($getarp) <= 0) {
                $livetrafic = 0;
            }
            ?>
        <?php } ?>

        <?php if ($livetrafic == 1) { ?>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Live Traffic</h6>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr style="text-align: center;">
                                        <th>TX + RX</th>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <input type="hidden" id="interface" value="<?= $customer['no_services'] ?>">
                                        <td>
                                            <div id="tabletxrx"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="graph"></div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/backend/') ?>highchart/js/highcharts.js"></script>
    <?php if ($livetrafic == 1) { ?>
        <script>
            $('#select').on('change', function(e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.clear();
                $("#interface").val(valueSelected);
            });
            var chart;

            function requestDatta(interface) {
                var interface = $('#interface').val()
                var newStr = interface.replace(/%20/g, " ");
                $.ajax({
                    url: '<?= site_url('mikrotik/trafficclient/') ?>' + newStr,
                    datatype: "json",
                    success: function(data) {
                        var midata = JSON.parse(data);
                        // console.log(midata);
                        if (midata.length > 0) {
                            var TX = parseInt(midata[0].data);
                            var RX = parseInt(midata[1].data);
                            var TXRX = (TX + RX);
                            var x = (new Date()).getTime();
                            shift = chart.series[0].data.length > 19;
                            chart.series[0].addPoint([x, TX], true, shift);
                            chart.series[1].addPoint([x, RX], true, shift);
                            // document.getElementById("tabletx").innerHTML = convert(TX);
                            // document.getElementById("tablerx").innerHTML = convert(RX);
                            document.getElementById("tabletxrx").innerHTML = convert(TXRX);
                        } else {
                            // document.getElementById("tabletx").innerHTML = "0";
                            // document.getElementById("tablerx").innerHTML = "0";
                            document.getElementById("tabletxrx").innerHTML = "0";
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
                        console.error("Error: " + errorThrown);
                    }
                });
            }

            $(document).ready(function() {
                Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'graph',
                        animation: Highcharts.svg,
                        type: 'spline',
                        events: {
                            load: function() {
                                setInterval(function() {
                                    requestDatta(document.getElementById("interface").value);
                                }, 1000);
                            }
                        }
                    },
                    title: {
                        text: 'Monitoring'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150,
                        maxZoom: 20 * 1000
                    },

                    yAxis: {
                        minPadding: 0.2,
                        maxPadding: 0.2,
                        title: {
                            text: 'Traffic'
                        },
                        labels: {
                            formatter: function() {
                                var bytes = this.value;
                                var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                                if (bytes == 0) return '0 bps';
                                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                                return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                            },
                        },
                    },
                    series: [{
                        name: 'TX',
                        data: []
                    }, {
                        name: 'RX',
                        data: []
                    }],
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br/>',
                        pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y}'
                    },


                });
            });

            function convert(bytes) {

                var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                if (bytes == 0) return '0 bps';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
            }
        </script>
    <?php } ?>