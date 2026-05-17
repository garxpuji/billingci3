<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
    <?php if ($this->session->userdata('role_id') == 1 or $role['add_income'] == 1) { ?>
        <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
        <button href="" data-toggle="modal" data-target="#filter" class="btn btn-outline-primary"><i class="fa fa-cube"></i> Filter</button>

    <?php } ?>
    <?php $subtotal = 0;
    foreach ($income as $c => $data) {
        $subtotal += $data->nominal;
    } ?>
</div>
<?php $this->view('messages') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pemasukan <?php if (!empty($this->input->post("filterbydate"))) { ?> <?= $this->input->post("tanggal"); ?> s/d <?= $this->input->post("tanggal2"); ?><?php } ?></h6>

    </div>
    <?php if ($this->session->userdata('role_id') == 1 or $role['del_income'] == 1) { ?>
        <div class="col-lg-3 col-sm-6 mb-2 col-md-4 mt-2 text-left">
            <button href="" class="btn btn-outline-danger" id="btn-del-selected"><i class="fa fa-trash"></i> Hapus Yang Dipilih</button>
        </div>
    <?php } ?>
    <div class="card-body">
        <div class="table-responsive">
            <form method="post" action="" id="submit-cetak">
                <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th> <input type='checkbox' id="selectAll"></th>
                            <th style="text-align: center; width:120px">Tanggal</th>
                            <th style="text-align: center; width:100px">Nominal</th>
                            <th>Kategori</th>
                            <th>Metode Pembayaran</th>
                            <th>Keterangan</th>
                            <th style="text-align: center; width:50px">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>

                    </tfoot>
                    <tbody>
                        <?php $no = 1;
                        foreach ($income as $r => $data) { ?>
                            <tr>
                                <td style="text-align: center"><?= $no++ ?>.</td>
                                <td><input type='checkbox' class='check-item' id="ceklis" name='income_id[]' value='<?= $data->income_id ?>'></td>
                                <td><?= indo_date($data->date_payment)  ?> <br>
                                <td style="text-align: right"><?= indo_currency($data->nominal)  ?></td>
                                <td>
                                    <?php $category = $this->db->get_where('cat_income', ['category_id' => $data->category])->row_array() ?>
                                    <?= $category['name']; ?>
                                </td>
                                <td><?= $data->mode_payment ?></td>
                                <td><?= $data->remark ?></td>
                                </td>
                                <td style="text-align: center">
                                    <?php if ($this->session->userdata('role_id') == 1 or $role['edit_income'] == 1) { ?>
                                        <!-- <a href="#" data-toggle="modal" data-target="#edit<?= $data->income_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a> -->
                                    <?php } ?>
                                    <?php if ($this->session->userdata('role_id') == 1 or $role['del_income'] == 1) { ?>
                                        <a href="" data-toggle="modal" data-target="#delete<?= $data->income_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('income/add') ?>" method="POST">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" id="nominal" name="nominal" min="0" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                        <input type="text" name="date_payment" autocomplete="off" id="datepicker" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea type="text" name="remark" id="remark" class="form-control"> </textarea>
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
<?php foreach ($income as $r => $data) { ?>
    <div class="modal fade" id="edit<?= $data->income_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('income/edit') ?>" method="POST">
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" id="nominal" name="nominal" value="<?= $data->nominal ?>" min="0" class="form-control" required>
                            <input type="hidden" id="income_id" name="income_id" value="<?= $data->income_id ?>" class="form-control" required>
                            <input type="hidden" id="created" name="created" value="<?= $data->created ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                            <input type="text" name="date_payment" id="datepicker" onclick="$(this).datepicker({format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true,}).datepicker('show')" value="<?= $data->date_payment ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="remark">Keterangan</label>
                            <textarea type="text" name="remark" id="remark" class="form-control"><?= $data->remark ?></textarea>
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
<?php } ?>
<!-- Modal Edit -->
<?php foreach ($income as $r => $data) { ?>
    <div class="modal fade" id="delete<?= $data->income_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('income/delete') ?>" method="POST">
                        <input type="hidden" name="income_id" value="<?= $data->income_id ?>">
                        <input type="hidden" name="created" value="<?= $data->created ?>">
                        <?php $d = substr($data->date_payment, 8, 2);
                        $m = substr($data->date_payment, 5, 2);
                        $y = substr($data->date_payment, 0, 4); ?>
                        Apakah yakin akan hapus data pendapatan pada tanggal <?= indo_date($data->date_payment) ?> senilai <?= indo_currency($data->nominal) ?> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('income/filter'); ?>" method="post">
                    <div class="row">
                        <div class="col"> <input type="checkbox" checked name="filterbymonth" id="filterbymonth"> <label for="">Filter Bulan</label></div>
                        <div class="col"> <input type="checkbox" name="filterbydate" id="filterbydate"> <label for="">Filter Tanggal</label></div>
                    </div>
                    <div class="" id="formfilterbymonth">
                        <div class="form-group">
                            <label for="">Bulan</label>
                            <select id="month" name="month" class="form-control">
                                <option value="">-Pilih-</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control " style="width: 100%;" type="text" id="year" name="year" autocomplete="off">
                                <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                <?php if (date('m') == 12) {  ?>
                                    <?php
                                    for ($i = date('Y') + 1; $i >= date('Y') - 2; $i -= 1) {
                                    ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (date('m') < 12) {  ?>
                                    <?php
                                    for ($i = date('Y'); $i >= date('Y') - 2; $i -= 1) {
                                    ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="" id="formfilterbydate" style="display: none;">
                        <div class="form-group">

                            <label>Dari Tanggal</label>

                            <input type="text" id="tanggal" name="tanggal" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">

                            <label>Sampai Tanggal</label>
                            <input type="text" id="tanggal2" name="tanggal2" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Penerima</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="">Semua</option>
                            <?php foreach ($kolektor as $key => $dataa) { ?>
                                <option value="<?= $dataa->id ?>"><?= $dataa->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Metode Pambayaran</label>
                        <select name="metode_payment" class="form-control">
                            <option value="">-Semua-</option>
                            <option value="Cash"> Cash </option>
                            <option value="Transfer">Transfer</option>
                            <option value="Payment Gateway">Payment Gateway</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category" class="form-control">
                            <option value="">-Semua-</option>
                            <?php foreach ($category as $key => $data) { ?>
                                <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            </form>
        </div>
    </div>
</div>
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
    $("#selectAll").click(function() {
        if ($(this).is(":checked"))
            $(".check-item").prop("checked", true);
        else // Jika checkbox all tidak diceklis
            $(".check-item").prop("checked", false);
    });
    $('#btn-del-selected').click(function() {
        $('#submit-cetak').attr('action', '<?php echo base_url('income/delselected') ?>');
        var confirm = window.confirm("Apakah Anda yakin ingin hapus pemasukan yang terpilih ?");
        if (confirm)
            $("#submit-cetak").submit();
    });
</script>
<script>
    $("#filterbydate").click(function() {
        if ($(this).is(":checked")) {
            $("#formfilterbydate").show();
            $("#formfilterbymonth").hide();
            document.getElementById("filterbymonth").checked = false;


        } else {
            $("#formfilterbydate").hide();
            $("#formfilterbymonth").show();

        }
    });
    $("#filterbymonth").click(function() {
        if ($(this).is(":checked")) {
            $("#formfilterbydate").hide();
            $("#formfilterbymonth").show();
            document.getElementById("filterbydate").checked = false;


        } else {
            $("#formfilterbydate").show();
            $("#formfilterbymonth").hide();

        }
    });
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
    $('#tanggal1').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#tanggal22').datepicker({
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
        $('#submit-cetak').attr('action', '<?php echo base_url('income/delselected') ?>');
        var confirm = window.confirm("Apakah Anda yakin ingin hapus pemasukan yang terpilih ?");
        if (confirm) {
            $("#submit-cetak").submit();
            $("#popup").modal("show");
        } else {

        }
    });
</script>