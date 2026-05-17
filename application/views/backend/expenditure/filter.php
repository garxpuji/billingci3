<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    <?php $subtotal = 0;
    foreach ($expenditure as $c => $data) {
        $subtotal += $data->nominal;
    } ?>
</div>
<?php $this->view('messages') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Cetak Laporan</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <form action="<?= base_url('expenditure/printexpenditure'); ?>" target="blank" method="post">
                            <div class="box">
                                <div class="box-body">
                                    <div class="form-group row">
                                        <div class="col-md-0 mt-2">
                                            <label class="col-sm-12 col-form-label">Tanggal</label>
                                        </div>
                                        <div class="col-sm-3 mt-2 ">
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-0 mt-2">
                                            <label class="col-sm-12 col-form-label">s/d</label>
                                        </div>
                                        <div class="col-sm-3  mt-2">
                                            <input type="text" id="tanggal2" name="tanggal2" autocomplete="off" class="form-control">
                                        </div>

                                        <div class="col-md-0 mt-2">
                                            <label class="col-sm-12 col-form-label">Kategori</label>
                                        </div>
                                        <div class="col-sm-3  mt-2">
                                            <select name="category" id="" class="form-control">
                                                <option value="">-Semua-</option>
                                                <?php foreach ($category as $key => $data) { ?>
                                                    <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <button type="reset" name="reset" class="btn btn-info">Reset</button>
                                            <button type="submit" name="filter" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Filter Pemasukan </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('expenditure/filter'); ?>" method="post">
            <div class="form-group row">
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Bulan</label>
                </div>
                <div class="col-sm-3 mt-2 ">
                    <select id="month" name="month" class="form-control" required>
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
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Tahun</label>
                </div>
                <div class="col-sm-3  mt-2">
                    <select class="form-control " style="width: 100%;" type="text" id="year" name="year" autocomplete="off" required>
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
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Kategori</label>
                </div>
                <div class="col-sm-3  mt-2">
                    <select name="category" id="" class="form-control">
                        <option value="">-Semua-</option>
                        <?php foreach ($category as $key => $data) { ?>
                            <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-3 mt-2">
                    <button class="btn btn-primary mb-2 my-2 my-sm-0" type="submit">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pemasukan</h6>

    </div>
    <div class="col-lg-3 col-sm-6 mb-2 col-md-4 mt-2 text-left">
        <button href="" class="btn btn-outline-danger" id="btn-del-selected"><i class="fa fa-trash"></i> Hapus Yang Dipilih</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form method="post" action="" id="submit-cetak">
                <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th></th>
                            <th style="text-align: center; width:120px">Tanggal</th>
                            <th style="text-align: center; width:100px">Nominal</th>
                            <th style="text-align: center; width:100px">Kategori</th>
                            <th>Keterangan</th>

                            <th style="text-align: center; width:50px">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>

                    </tfoot>
                    <tbody>
                        <?php $no = 1;
                        foreach ($expenditure as $r => $data) { ?>
                            <tr>
                                <td style="text-align: center"><?= $no++ ?>.</td>
                                <td><input type='checkbox' class='check-item' id="ceklis" name='expenditure_id[]' value='<?= $data->expenditure_id ?>'></td>
                                <td><?= indo_date($data->date_payment)  ?> <br>
                                <td style="text-align: right"><?= indo_currency($data->nominal)  ?></td>
                                <?php if ($data->category != 0) { ?>
                                    <?php $getcategory = $this->db->get_where('cat_expenditure', ['category_id' => $data->category])->row_array() ?>
                                    <td><?= $getcategory['name'] ?></td>
                                <?php } ?>
                                <?php if ($data->category == 0) { ?>

                                    <td></td>
                                <?php } ?>
                                <td><?= $data->remark ?></td>
                                </td>
                                <td style="text-align: center"><a href="#" data-toggle="modal" data-target="#edit<?= $data->expenditure_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a> <a href="" data-toggle="modal" data-target="#delete<?= $data->expenditure_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a></td>
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
                <form action="<?= site_url('expenditure/add') ?>" method="POST">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" id="nominal" name="nominal" min="0" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                        <input type="text" name="date_payment" autocomplete="off" id="datepicker" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category" id="" class="form-control" required>
                            <option value="">-Pilih-</option>
                            <?php foreach ($category as $key => $data) { ?>
                                <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                            <?php } ?>
                        </select>
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
<?php foreach ($expenditure as $r => $data) { ?>
    <div class="modal fade" id="edit<?= $data->expenditure_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('expenditure/edit') ?>" method="POST">
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" id="nominal" name="nominal" value="<?= $data->nominal ?>" min="0" class="form-control" required>
                            <input type="hidden" id="expenditure_id" name="expenditure_id" value="<?= $data->expenditure_id ?>" class="form-control" required>
                            <input type="hidden" id="created" name="created" value="<?= $data->created ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                            <input type="text" name="date_payment" id="datepicker" onclick="$(this).datepicker({format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true,}).datepicker('show')" value="<?= $data->date_payment ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori *</label>
                            <select name="category" id="" class="form-control" required>
                                <?php if ($data->category != 0) { ?>
                                    <?php $getcategory = $this->db->get_where('cat_expenditure', ['category_id' => $data->category])->row_array() ?>
                                    <option value="<?= $data->category ?>"><?= $getcategory['name'] ?></option>

                                <?php } ?>
                                <?php if ($data->category == 0) { ?>
                                    <option value="">-Pilih-</option>
                                <?php } ?>
                                <?php foreach ($category as $key => $data) { ?>
                                    <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                                <?php } ?>
                            </select>
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
<?php foreach ($expenditure as $r => $data) { ?>
    <div class="modal fade" id="delete<?= $data->expenditure_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('expenditure/delete') ?>" method="POST">
                        <input type="hidden" name="expenditure_id" value="<?= $data->expenditure_id ?>">
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
        $('#submit-cetak').attr('action', '<?php echo base_url('expenditure/delselected') ?>');
        var confirm = window.confirm("Apakah Anda yakin ingin hapus pemasukan yang terpilih ?");
        if (confirm)
            $("#submit-cetak").submit();
    });
</script>