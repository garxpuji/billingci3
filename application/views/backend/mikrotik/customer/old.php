<!-- Page Heading -->
<style>
    #map-canvas {
        width: 100%;
        height: 400px;
        border: solid #999 1px;
    }

    select {
        width: 240px;
    }
</style>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>No Layanan</th>
                        <th>Nama</th>
                        <th>Mode</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>DL/UL</th>
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <th style="text-align: center">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($customer as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $data->no_services ?>
                            </td>
                            <td><?= $data->name ?>
                            </td>
                            <td style="text-align: center"><?= $data->mode_user ?></td>
                            <td style="text-align: center"><?= $data->user_mikrotik ?></td>
                            <?php
                            $router = $this->db->get_where('router', ['id' => $data->router])->row_array();
                            $ip = $router['ip_address'];
                            $user = $router['username'];
                            $pass = $router['password'];
                            $port = $router['port'];
                            $API = new Mikweb();
                            $usermikrotik = $data->user_mikrotik;
                            $API->connect($ip, $user, $pass, $port);
                            $hotspotactive = $API->comm("/ip/hotspot/active/print", array("?user" => $usermikrotik));
                            $pppoeactive = $API->comm("/ppp/active/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
                            $userhotspot = $API->comm("/ip/hotspot/user/print", array("?name" => $usermikrotik));
                            $userpppoe = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
                            $simplequeue = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
                            $ipqueue = substr($simplequeue['0']['target'], 0, -3);
                            $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
                            $getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $data->no_services . ''));
                            // var_dump($userhotspot['0']['disabled']);
                            // echo $hotspotactive;
                            ?>

                            <?php if ($data->mode_user == "Hotspot") { ?>
                                <!-- HOTSPOT -->
                                <td style="text-align: center">
                                    <?php if ($userhotspot['0']['disabled'] == 'true') {
                                        echo '<div class="badge badge-warning">Isolir</div>';
                                    } elseif (count($hotspotactive) > 0) {
                                        echo '<div class="badge badge-success">Active</div>';
                                    } elseif (count($hotspotactive) <= 0) {
                                        echo '<div class="badge badge-danger">Non-Active</div>';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <i class="fa fa-download" style="color: green;" aria-hidden="true"></i> <?= formatBites($userhotspot['0']['bytes-out'], 2); ?> <br>
                                    <i class="fa fa-upload" style="color: aqua;" aria-hidden="true"></i> <?= formatBites($userhotspot['0']['bytes-in'], 2); ?> <br>
                                    Total : <?= formatBites($userhotspot['0']['bytes-out'] + $userhotspot['0']['bytes-in'], 2); ?>
                                </td>
                            <?php } ?>
                            <?php if ($data->mode_user == "PPPOE") { ?>
                                <!-- PPPOE -->
                                <td style="text-align: center">
                                    <?php if ($userpppoe['0']['disabled'] == 'true') {
                                        echo '<div class="badge badge-warning">Isolir</div>';
                                    } elseif (count($pppoeactive) > 0) {
                                        echo '<div class="badge badge-success">Active</div>';
                                    } elseif (count($pppoeactive) <= 0) {
                                        echo '<div class="badge badge-danger">Non-Active</div>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    Total : <?= formatBites($userpppoe['0']['comment']); ?>
                                </td>
                            <?php } ?>
                            <?php if ($data->mode_user == "Static") { ?>
                                <!-- PPPOE -->
                                <td style="text-align: center">
                                    <?php if (count($getfirewall) > 0) {
                                        echo '<div class="badge badge-warning">Isolir</div>';
                                    } elseif (count($getarp) > 0) {
                                        echo '<div class="badge badge-success">Active</div>';
                                    } elseif (count($getarp) <= 0) {
                                        echo '<div class="badge badge-danger">Non-Active</div>';
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    $byte = $simplequeue['0']['bytes'];
                                    $updl = explode("/", $byte);
                                    $up = $updl['0'];
                                    $dl = $updl['1'];
                                    ?>
                                    <i class="fa fa-download" style="color: green;" aria-hidden="true"></i> <?= formatBites($dl, 2); ?> <br>
                                    <i class="fa fa-upload" style="color: aqua;" aria-hidden="true"></i> <?= formatBites($up, 2); ?> <br>
                                    Total : <?= formatBites($up + $dl, 2); ?>
                                </td>
                            <?php } ?>
                            <?php if ($data->mode_user == "") { ?>
                                <td></td>
                                <td></td>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1) { ?>
                                <td style="text-align: center">
                                    <?php $id = str_replace('*', '', $userhotspot['0']['.id']) ?>
                                    <a href="" data-toggle="modal" data-target="#EditModal<?= $data->customer_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                    <?php if ($data->mode_user == "Hotspot") { ?>
                                        <a href="<?= site_url('mikrotik/resethotspot/' . $id) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user <?= $data->user_mikrotik ?> ?')"><i class="fa fa-undo fa-1x" style="color:red"></i></a>
                                    <?php } ?>
                                    <?php if ($data->mode_user == "Static") { ?>
                                        <a href="<?= site_url('mikrotik/resetstatic/' . str_replace('*', '', $simplequeue['0']['.id'])) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user <?= $data->user_mikrotik ?> ?')"><i class="fa fa-undo fa-1x" style="color:red"></i></a>
                                    <?php } ?>
                                    <?php if ($data->mode_user == "PPPOE") { ?>
                                        <a href="<?= site_url('mikrotik/resetpppoe/' . str_replace('*', '', $userpppoe['0']['.id'])) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user <?= $data->user_mikrotik ?> ?')"><i class="fa fa-undo fa-1x" style="color:red"></i></a>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<?php
foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="EditModal<?= $data->customer_id ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('mikrotik/editcustomer') ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <div class="form-group">
                        <label for="name">Customer Nmae</label>
                        <input type="text" id="name" autocomplete="off" name="name" class="form-control" value="<?= $data->name ?>" readonly>
                        <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="no_services">Customer Name</label>
                        <input type="text" id="no_services" autocomplete="off" name="no_services" class="form-control" value="<?= $data->no_services ?>" readonly>
                        <?= form_error('no_services', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="mode_user">Mode User</label>
                        <select name="mode_user" id="mode_user" class="form-control" onchange="usermikrotik(this.value)">
                            <option value="<?= $data->mode_user ?>"><?= $data->mode_user ?></option>
                            <option value="Hotspot">Hotspot</option>
                            <option value="PPPOE">PPPOE</option>
                            <option value="Static">Static</option>
                        </select>
                    </div>

                    <div class="loading"></div>

                    <div class="form-group" id="user_box">
                        <label for="user_mikrotik">User Hotspot / PPPOE / Static</label>
                        <select class="select2 form-control view_data" name="user_mikrotik" id="user_mikrotik" style="width: 100%;" required>
                            <option value="<?= $data->user_mikrotik ?>"><?= $data->user_mikrotik ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="auto_isolir">Auto Isolir</label>
                        <select name="auto_isolir" id="auto_isolir" class="form-control">
                            <option value="<?= $data->auto_isolir ?>"><?= $data->auto_isolir == '1' ? 'Yes' : 'No' ?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="number" id="due_date" min="1" max="28" name="due_date" class="form-control" value="<?= $data->due_date ?>">
                        <?= form_error('due_date', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
<script>
    $(function() {
        $('.select2').select2()
    });

    function usermikrotik(mode) {
        var url = "<?= site_url('mikrotik/getUserMikrotik/') ?>" + mode + "/" + Math.random();

        $.ajax({
            type: 'POST',
            url: url,
            cache: false,

            beforeSend: function() {

                $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
            },
            success: function(data) {
                $('.loading').html('');
                $('#user_box').show();

                $('.view_data').html(data);
            }

        });
        return false;
    }
</script>