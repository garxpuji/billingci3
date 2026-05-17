<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Perhitungan Sharing Profit</h6> <span> <?= indo_month(date('m')); ?> <?= date('Y'); ?></span>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-lg">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <form action="<?= site_url('bill/filterrecapmitra') ?>" method="post">
                            <div class="box">
                                <div class="box-body">
                                    <div class="form-group row">
                                        <div class="col-md-0 mt-2">
                                            <label class="col-sm-12 col-form-label">Nama Mitra</label>
                                        </div>
                                        <div class="col-sm-3 mt-2 ">
                                            <select id="user_id" name="mitra" class="form-control" required>
                                                <option value="">-Pilih-</option>
                                                <?php foreach ($mitra as $key => $dataa) { ?>
                                                    <option value="<?= $dataa->id ?>"><?= $dataa->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-0 mt-2">
                                            <label class="col-sm-12 col-form-label">Bulan</label>
                                        </div>
                                        <div class="col-sm-3 mt-2 ">
                                            <select id="month" name="month" class="form-control" required>
                                                <option value="<?= date('m') ?>"><?= indo_month(date('m')) ?></option>
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
                                        <div class="col-sm-3 mt-2 ">
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

                                        <div class="col-sm-3 mt-2">
                                            <button type="reset" name="reset" class="btn btn-info">Reset</button>
                                            <button type="submit" name="filter" class="btn btn-primary"><i class="fa fa-refresh"></i> Filter</button>
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
</script>