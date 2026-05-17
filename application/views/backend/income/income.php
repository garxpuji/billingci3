<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
    <?php if ($this->session->userdata('role_id') == 1 or $role['add_income'] == 1) { ?>
        <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    <?php } ?>
    <?php $subtotal = 0;
    foreach ($income as $c => $data) {
        $subtotal += $data->nominal;
    } ?>
    <a href="<?= site_url('income/category') ?>" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Kategori</a>

</div>

<?php $this->view('messages') ?>

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <?php $thisMonth = $this->income_m->getIncomeThisMonth()->result() ?>
    <?php $lastmonth = $this->income_m->getIncomeLastMonth()->result() ?>
    <?php $today = $this->income_m->gettoday()->result() ?>
    <?php $yesterday = $this->income_m->getyesterday()->result() ?>
    <?php $IncomethisMonth = 0;
    foreach ($thisMonth as $c => $data) {
        $IncomethisMonth += $data->nominal;
    } ?>
    <?php $incomelastmonth = 0;
    foreach ($lastmonth as $c => $data) {
        $incomelastmonth += $data->nominal;
    } ?>
    <?php $incometoday = 0;
    foreach ($today as $c => $data) {
        $incometoday += $data->nominal;
    } ?>
    <?php $incomeyesterday = 0;
    foreach ($yesterday as $c => $data) {
        $incomeyesterday += $data->nominal;
    } ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pemasukan Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($IncomethisMonth) ?></div>
                        <?php if ($IncomethisMonth > $incomelastmonth) { ?>
                            <span>Naik <?= indo_currency($IncomethisMonth - $incomelastmonth); ?></span>
                        <?php } ?>
                        <?php if ($IncomethisMonth < $incomelastmonth) { ?>
                            <span>Turun <?= indo_currency($IncomethisMonth - $incomelastmonth); ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Pemasukan Bulan Kemarin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($incomelastmonth) ?></div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Pemasukan Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($incometoday) ?></div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Pemasukan Kemarin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($incomeyesterday) ?></div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pemasukan</h6>

    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-2 m-2">

        <button href="" data-toggle="modal" data-target="#filter" class="btn btn-outline-primary"><i class="fa fa-cube"></i> Filter</button>
        <button href="" data-toggle="modal" data-target="#print" class="btn btn-outline-primary"><i class="fa fa-print"></i> Cetak</button>
        <button href="" data-toggle="modal" data-target="#export" class="btn btn-outline-secondary"><i class="fas fa-file-excel"></i> Export</button>
        <?php if ($this->session->userdata('role_id') == 1 or $role['del_income'] == 1) { ?>
            <button href="" class="btn btn-outline-danger" id="btn-del-selected"><i class="fa fa-trash"></i> Hapus Yang Dipilih</button>
        <?php } ?>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form method="post" action="" id="submit-cetak">
                <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th>
                                <input type='checkbox' class='check-item' id="selectAll">
                            </th>
                            <th style="text-align: center; width:120px">Tanggal</th>
                            <th style="text-align: center; width:100px">Nominal</th>
                            <th style="text-align: center; width:100px">Categori</th>
                            <th>Metode Pembayaran</th>
                            <th>Keterangan</th>

                            <th style="text-align: center; width:50px">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>

                    </tfoot>
                    <tbody>

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
                    <?php if ($this->session->userdata('role_id') == 1) { ?>
                        <div class="form-group">
                            <label>Penerima *</label>
                            <select name="create_by" class="form-control" style="width: 100%;" required>
                                <option value="<?= $user['id'] ?>"><?= $user['name']; ?> </option>
                                <?php $userlist = $this->income_m->getreceipt()->result() ?>
                                <?php foreach ($userlist as $key => $data) { ?>
                                    <option value="<?= $data->id ?>"><?= $data->name ?> -
                                        <?= $data->role_id == 1 ? 'Admin' : '' ?>
                                        <?= $data->role_id == 2 ? 'Pelanggan' : '' ?>
                                        <?= $data->role_id == 3 ? 'Operator' : '' ?>
                                        <?= $data->role_id == 4 ? 'Mitra' : '' ?>
                                        <?= $data->role_id == 5 ? 'Teknisi' : '' ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category" class="form-control" required>
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
<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('income/export'); ?>" method="post">
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
                <button type="submit" class="btn btn-primary">Export</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('income/printincome'); ?>" target="blank" method="post">
                    <div class="form-group">

                        <label>Dari Tanggal</label>

                        <input type="text" id="tanggal1" name="tanggal" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">

                        <label>Sampai Tanggal</label>
                        <input type="text" id="tanggal22" name="tanggal2" class="form-control" autocomplete="off">
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
                <button type="submit" class="btn btn-primary">Print</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('income/edit') ?>" method="POST">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" id="editnominal" name="nominal" value="<?= $data->nominal ?>" min="0" class="form-control" required>
                        <input type="hidden" id="editincome_id" name="income_id" value="<?= $data->income_id ?>" class="form-control" required>
                        <input type="hidden" id="created" name="created" value="<?= $data->created ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                        <input type="text" name="date_payment" id="editdate_payment" onclick="$(this).datepicker({format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true,}).datepicker('show')" value="<?= $data->date_payment ?>" class="form-control" required>
                    </div>
                    <?php if ($this->session->userdata('role_id') == 1) { ?>
                        <div class="form-group">
                            <label>Penerima *</label>
                            <select name="create_by" id="receipt" class="form-control">
                                <option value=""> -Pilih- </option>
                                <?php $userlist = $this->income_m->getreceipt()->result() ?>
                                <?php foreach ($userlist as $key => $data) { ?>
                                    <option value="<?= $data->id ?>"><?= $data->name ?> -
                                        <?= $data->role_id == 1 ? 'Admin' : '' ?>
                                        <?= $data->role_id == 2 ? 'Pelanggan' : '' ?>
                                        <?= $data->role_id == 3 ? 'Operator' : '' ?>
                                        <?= $data->role_id == 4 ? 'Mitra' : '' ?>
                                        <?= $data->role_id == 5 ? 'Teknisi' : '' ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Metode Pambayaran</label>
                        <select name="metode_payment" id="editmetode" class="form-control">
                            <option value="">-Pilih-</option>
                            <option value="Cash"> Cash </option>
                            <option value="Transfer">Transfer</option>
                            <option value="Payment Gateway">Payment Gateway</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category" id="editcategory" class="form-control" required>

                            <?php foreach ($category as $key => $data) { ?>
                                <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea type="text" name="remark" id="editremark" class="form-control"><?= $data->remark ?></textarea>
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
<div class="modal fade" id="Modaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" id="deleteincome_id" name="income_id">

                    <?php $d = substr($data->date_payment, 8, 2);
                    $m = substr($data->date_payment, 5, 2);
                    $y = substr($data->date_payment, 0, 4); ?>
                    Apakah yakin akan hapus data pendapatan pada tanggal <span id="deletedate_payment"></span> senilai <span id="deletenominal"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- bootstrap datepicker -->
<script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
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
<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else // Jika checkbox all tidak diceklis
                $(".check-item").prop("checked", false);
        });

        $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('income/getDataIncome'); ?>",
                "type": "POST"
            },
            "lengthMenu": [
                [10, 25, 50, 100, 250, 500, 1000],
                [10, 25, 50, 100, 250, 500, 1000]
            ],
            dom: 'lBfrtip',
            buttons: [{
                    extend: ['copy'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['csv'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['excel'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['pdf'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['print'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            "columnDefs": [{
                "targets": 1,
                "orderable": false
            }]
        });
    });
</script>
<script>
    $(document).on('click', '#edit', function() {

        $('#editincome_id').val($(this).data('income_id'))
        $('#editnominal').val($(this).data('nominal'))
        $('#editcategory').val($(this).data('category'))
        $('#editmetode').val($(this).data('mode_payment'))
        $('#receipt').val($(this).data('receipt'))
        $('#spancategory').val($(this).data('category'))
        $('#editdate_payment').val($(this).data('date_payment'))
        $('#editremark').html($(this).data('remark'))

    })
    $(document).on('click', '#delete', function() {

        $('#deleteincome_id').val($(this).data('income_id'))
        $('#deletenominal').html($(this).data('nominal'))
        $('#deletedate_payment').html($(this).data('date_payment'))
    })
</script>