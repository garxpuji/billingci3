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
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
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
                        <th>Router</th>
                        <th>Mode</th>
                        <th>User</th>
                        <th>Jatuh Tempo</th>
                        <th>Auto Isolir</th>
                        <th style="text-align: center">Aksi</th>

                    </tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($customer as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td>
                                <a href="<?= site_url('mikrotik/client/' . $data->no_services) ?>" class="badge badge-success"><?= $data->no_services ?></a>
                            </td>
                            <td><?= $data->name ?></td>
                            <?php $router = $this->db->get_where('router', ['id' => $data->router])->row_array() ?>
                            <td><?= $router['alias'] ?></td>
                            <td>
                                <?= $data->mode_user ?><br>
                                <?php if ($data->mode_user == 'PPPOE' or  $data->mode_user == 'Hotspot') { ?>
                                    <?php if ($data->action == 1) { ?>
                                        Profile : <?= $data->user_profile ?>
                                    <?php } ?>
                                <?php } ?>
                            <td style="text-align: center"><?= $data->user_mikrotik ?></td>
                            <td style="text-align: center"><?= $data->due_date ?></td>
                            <td style="text-align: center">
                                <?= $data->auto_isolir == 1 ? 'Yes' : 'No' ?>
                                <br>
                                Action : <?= $data->action == 1 ? 'Ganti Profile' : 'Disable User' ?>
                            </td>
                            <td style="text-align: center">
                                <?php if ($this->session->userdata('role_id') == 1 or $role['edit_customer'] == 1) { ?>
                                    <a href="<?= site_url('customer/edit/' . $data->customer_id) ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                <?php } ?>


                            </td>
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
                        <input type="text" autocomplete="off" name="name" class="form-control" value="<?= $data->name ?>" readonly>
                        <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="no_services">Customer Name</label>
                        <input type="text" autocomplete="off" name="no_services" class="form-control" value="<?= $data->no_services ?>" readonly>
                        <?= form_error('no_services', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="mode_user">Mode User</label>
                        <select name="mode_user" class="form-control" onchange="usermikrotik(this.value)">
                            <option value="<?= $data->mode_user ?>"><?= $data->mode_user ?></option>
                            <option value="Hotspot">Hotspot</option>
                            <option value="PPPOE">PPPOE</option>
                            <option value="Static">Static</option>
                            <option value="Standalone">Standalone</option>
                        </select>
                    </div>

                    <div class="loading"></div>

                    <div class="form-group">

                        <label>Router</label>
                        <select name="router" class="form-control">
                            <?php if ($data->router == '') { ?>
                                <option value="">-Pilih Router-</option>
                            <?php } ?>
                            <?php if ($data->router != '') { ?>
                                <?php $router = $this->db->get_where('router', ['id' => $data->router])->row_array() ?>
                                <option value="<?= $data->router ?>"> <?= $router['alias']; ?> </option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group" id="user_box">
                        <label for="user_mikrotik">User Hotspot / PPPOE / Static / Interface</label>
                        <select class="select2 form-control view_data" name="user_mikrotik" style="width: 100%;" required>
                            <option value="<?= $data->user_mikrotik ?>"><?= $data->user_mikrotik ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="auto_isolir">Auto Isolir</label>
                        <select name="auto_isolir" class="form-control">
                            <option value="<?= $data->auto_isolir ?>"><?= $data->auto_isolir == '1' ? 'Yes' : 'No' ?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="due_date">Jatuh Tempo</label> <span style="color: red;">Wajib diisi jika auto isolir yes</span>
                        <input type="number" min="1" max="28" name="due_date" class="form-control" value="<?= $data->due_date ?>">
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