<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/backend/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/backend/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>



    <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>


</div>

<?php $this->view('messages') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Modem</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th style="text-align: center; width:100px">Aksi</th>
                        <th>Nama Modem / Alias</th>
                        <th>Nama Pelanggan - Status Tampil</th>
                        <th>IP Address</th>
                        <th>Akses Login</th>
                        <th>Wifi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $no = 1;
                    foreach ($modem as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td style="text-align: center">
                                <?php if ($this->session->userdata('role_id') == 1 or $role['edit_modem'] == 1) { ?>
                                    <a href="<?= site_url('modem/edit/' . $data->id) ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                <?php } ?>
                                <?php if ($this->session->userdata('role_id') == 1 or $role['del_modem'] == 1) { ?>
                                    <a href="" id="delete" data-id="<?= $data->id ?>" data-name="<?= $data->name ?>" data-toggle="modal" data-target="#Modaldelete" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                <?php } ?>
                            </td>
                            <td>
                                <?= $data->name ?>
                            </td>
                            <td>
                                <?php if ($data->customer_id != 0) { ?>
                                    <?php $customer = $this->db->get_where('customer', ['customer_id' => $data->customer_id])->row_array() ?>
                                    <?= $customer['name']; ?> - <?= $data->show_customer == 1 ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i>' ?>
                                <?php } ?>
                            </td>
                            <td>
                                IP Lokal : <a href="http://<?= $data->ip_local ?>" target="blank"><?= $data->ip_local ?></a> <br>
                                <?php if ($data->ip_public != '') { ?>
                                    IP Public : <a href="http://<?= $data->ip_public ?>" target="blank"><?= $data->ip_public ?></a>
                                <?php } ?>
                            </td>
                            <td>
                                Username : <?= $data->login_user ?> <br>
                                Password : <?= $data->login_password ?>
                            </td>
                            <td>
                                SSID : <?= $data->ssid_name ?> <br>
                                Password : <?= $data->ssid_password ?>
                            </td>

                            <td><?= $data->remark; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('modem/add') ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Nama Modem / Alias</label>
                        <input type="text" name="name" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="typemodem" id="typemodem"> <label for="">Modem Pelanggan</label>
                    </div>
                    <input type="hidden" name="type" id="type" value="0" class="form-control">
                    <div class="form-group" id="formcustomer" style="display: none;">
                        <label for="name">No Layanan - Nama Pelanggan</label>
                        <?php $customer = $this->db->get('customer')->result() ?>
                        <select class="form-control select2" name="customer_id" id="customer_id" style="width: 100%;">
                            <option value="">-Pilih-</option>
                            <?php
                            foreach ($customer as $r => $data) { ?>
                                <option value="<?= $data->customer_id ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" id="formshowcustomer" style="display: none;">
                        <label for="show_customer">Tampil di halaman Pelanggan</label>
                        <select name="show_customer" class="form-control">
                            <option value="0">Non-Aktif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="ip_local">IP Lokal</label>
                                <input type="text" name="ip_local" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ip_public">IP Public</label>
                                <input type="text" name="ip_public" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="login_user">Username Modem</label>
                                <input type="text" name="login_user" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="login_password">Password Modem</label>
                                <input type="text" name="login_password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="ssid_name">Nama SSID / Wifi</label>
                                <input type="text" name="ssid_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ssid_password">Password SSID / Wifi</label>
                                <input type="text" name="ssid_password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea name="remark" class="form-control"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit -->


<!-- Modal Edit -->
<div class="modal fade" id="Modaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Modem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('modem/delete') ?>" method="POST">
                    <input type="hidden" name="id" id="deleteid">
                    Apakah anda yakin hapus modem <span id="deletename"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/backend') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/backend') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/backend') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/backend') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $(document).ready(function() {
        $('#example1').DataTable({

            "paging": true,
            "lengthChange": true,
            "searching": true,

            "info": true,
            "autoWidth": true,
            "responsive": true,



        });
    });
</script>
<script>
    $(document).on('click', '#edit', function() {

        $('#id').val($(this).data('id'))
        $('#name').val($(this).data('name'))
        $('#ipaddress').val($(this).data('ipaddress'))
        $('#username').val($(this).data('username'))
        $('#port').val($(this).data('port'))


    })
    $(document).on('click', '#delete', function() {
        $('#deleteid').val($(this).data('id'))
        $('#deletename').html($(this).data('name'))
    })
    $(function() {
        $("#typemodem").click(function() {
            if ($(this).is(":checked")) {
                $("#formcustomer").show();
                $("#formshowcustomer").show();
                $("#type").val('1');
            } else {
                $("#formcustomer").hide();
                $("#formshowcustomer").hide();
                $("#type").val('0');
            }
        });
    });
</script>