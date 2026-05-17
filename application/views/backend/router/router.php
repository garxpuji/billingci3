<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/backend/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/backend/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Page Heading -->

<?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
    <?php if ($this->session->userdata('role_id') == 1 or $role['add_router'] == 1) { ?>
        <label for="chis_active" class="switch ml-3">
            <?php if ($rt['is_active'] == 1) { ?>
                <input type="checkbox" checked id="chis_active" onclick="javascript:window.location.href='<?= base_url('router/nonactive') ?>'">
            <?php } ?>
            <?php if ($rt['is_active'] == 0) { ?>
                <input type="checkbox" id="chis_active" onclick="javascript:window.location.href='<?= base_url('router/active') ?>'">
            <?php } ?>
            <div class="slider round"></div>
        </label>


        <?php if ($rt['is_active'] == 1) { ?>
            <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
        <?php } ?>
    <?php } ?>


</div>
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-bell"></i> Jika belum punya IP Public atau VPN Remote API bisa berlangganan VPN Remote di <a href="https://konekter.us" target="blnk"> konekter.us</a>, Gabung group <a href="https://t.me/joinchat/_UVV1A0b4qQ5ZDE1" target="blank">Telegram </a>. <br>
    <li>

        <a href="https://youtu.be/WjkIe-e60O8" target="blank">Cara membuat vpn remote konekterus</a>
    </li>
    <li>

        <a href="https://youtu.be/1fVkH_dupzk" target="blank">Cara Integrasi Billing dengan Mikrotik</a>
    </li>
</div>
<?php $this->view('messages') ?>
<?php if ($rt['is_active'] == 1) { ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Data Router</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th style="text-align: center; width:100px">Aksi</th>
                            <th>Nama Router / Alias</th>
                            <th>Total Pelanggan</th>
                            <th>IP Address / VPN</th>
                            <th>User</th>
                            <th>Port API</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($router as $r => $data) { ?>
                            <tr>
                                <td style="text-align: center"><?= $no++ ?>.</td>
                                <td style="text-align: center">
                                    <?php if ($this->session->userdata('role_id') == 1 or $role['edit_router'] == 1) { ?>

                                        <a id="edit" href="#" data-id="<?= $data->id ?>" data-name="<?= $data->alias ?>" data-ipaddress="<?= $data->ip_address ?>" data-username="<?= $data->username ?>" data-port="<?= $data->port ?>" data-toggle="modal" data-target="#Modaledit" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                    <?php } ?>
                                    <a id="reboot" href="<?= site_url('router/reboot/' . $data->id) ?>" onclick="return confirm('Apakah anda yakin akan reboot router <?= $data->alias ?> ?')" title="Reboot"><i class="fas fa-sync" style="font-size:25px; color:orange"></i></a>
                                    <?php if ($this->session->userdata('role_id') == 1 or $role['del_router'] == 1) { ?>

                                        <?php if ($data->id != 1) { ?>
                                            <a href="" id="delete" data-id="<?= $data->id ?>" data-name="<?= $data->alias ?>" data-toggle="modal" data-target="#Modaldelete" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?= $data->alias ?> <br>
                                    <div class="btn  btn-outline-success btn-sm"><a href="<?= site_url('mikrotik/dashboard/' . $data->id) ?>" style="text-decoration: none; color:black">Dashboard</a></div>
                                </td>
                                <td style="text-align: center"><?= $this->db->get_where('customer', ['router' => $data->id])->num_rows() ?></td>
                                <td><?= $data->ip_address ?></td>
                                <td><?= $data->username ?></td>
                                <td><?= $data->port ?></td>
                                <td style="text-align: center">

                                    <div class="btn btn-outline-success btn-sm"><a href="#" onclick="javascript:window.location.href='<?= base_url('') ?>router/testconnection/<?= $data->id ?>'" title="Test" style="text-decoration: none; color:black">Test Koneksi</a></div>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('router/add') ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Nama Router / Alias</label>
                        <input type="text" name="name" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ipaddress">IP Address / VPN</label>
                        <input type="text" name="ipaddress" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">User</label>
                        <input type="text" name="username" autocomplete="off" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" name="password" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="number" name="port" autocomplete="off" class="form-control">
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

<div class="modal fade" id="Modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Router</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('router/edit') ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Nama Router / Alias</label>
                        <input type="hidden" id="id" name="id">
                        <input type="text" id="name" name="name" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ipaddress">IP Address / VPN</label>
                        <input type="text" name="ipaddress" autocomplete="off" id="ipaddress" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">User</label>
                        <input type="text" name="username" autocomplete="off" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="changepassword" id="changepassword"> <label for="">Ganti Password</label>
                    </div>

                    <div class="form-group">
                        <div id="password" style="display: none">
                            <label for="password">Password</label>
                            <input type="text" name="password" autocomplete="off" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="number" name="port" autocomplete="off" id="port" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="Modaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Router</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('router/delete') ?>" method="POST">
                    <input type="hidden" name="id" id="deleteid">
                    Apakah anda yakin hapus router <span id="deletename"></span> ?
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
        $("#changepassword").click(function() {
            if ($(this).is(":checked")) {
                $("#password").show();
            } else {
                $("#password").hide();
            }
        });
    });
</script>