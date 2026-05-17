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
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

<!-- Page Heading -->

<?php $this->view('messages') ?>



<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data <?= $title; ?></h6>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form method="post" action="" id="submit-cetak">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th>No Layanan</th>
                            <th>Nama </th>
                            <th>Mode User</th>
                            <th>User di Mikrotik</th>
                            <th>Auto Isolir</th>
                            <th>Jatuh Tempo</th>
                            <th style="text-align: center; width:50px">Aksi</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($customer as $r => $data) { ?>
                            <tr>
                                <td style="text-align: center"><?= $no++ ?>.</td>
                                <td><a href="<?= site_url('router/client/' . $data->no_services) ?>" class="badge badge-success"><?= $data->no_services; ?></a> <br>
                                <td><?= $data->name; ?></td>
                                <td><?= $data->mode_user ?> </td>
                                <td><?= $data->user_mikrotik ?>

                                </td>
                                <td style="text-align: center"><?= $data->auto_isolir == 1 ? 'Yes' : 'No' ?></td>
                                <td style="text-align: center"><?= $data->due_date ?></td>
                                </td>
                                <td style="text-align: center"><a href="#" data-toggle="modal" data-target="#EditModal<?= $data->customer_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

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


<!-- Modal Edit -->
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
                    <?php echo form_open_multipart('router/editcustomer') ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <div class="form-group">
                        <label for="name">Customer Name</label>
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
                    <input type="hidden" name="userprofilesinkron" id="userprofilesinkron">
                    <div class="form-group" id="user_box">
                        <label for="user_mikrotik">User Hotspot / PPPOE / Static</label>
                        <select class="select2 form-control view_data" name="user_mikrotik" id="user_mikrotik" style="width: 100%;" onChange="selectuser(this);" required>
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
<!-- bootstrap datepicker -->
<script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
    //Date picker
    $('#tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#tanggal2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#btn-del-selected').click(function() {
        $('#submit-cetak').attr('action', '<?php echo base_url('customer/delselected') ?>');
        var confirm = window.confirm("Apakah Anda yakin ingin hapus pemasukan yang terpilih ?");
        if (confirm)
            $("#submit-cetak").submit();
    });
    $(function() {
        $('.select2').select2()
    });

    function usermikrotik(mode) {

        var url = "<?= site_url('router/getUserMikrotik/') ?>" + mode + "/" + Math.random();

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
<script>
    function selectuser(sel) {
        var user = $('#user_mikrotik').val();

        var url = "<?= site_url('router/getUserProfileByName') ?>" + "/" + Math.random();
        $.ajax({
            type: 'POST',
            url: url,
            data: "&user=" + user,
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
                $('#userprofilesinkron').val(data);
            }
        });
        return false;

    }
</script>
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