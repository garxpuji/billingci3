<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Perhitungan Sharing Profit</h6> <span> <?= indo_month(date($this->input->post('month'))); ?> <?= date($this->input->post('year')); ?></span>
    </div>

    <div class="card-body">
        <?php if ($this->session->userdata('role_id') == 1) { ?>
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
                                                    <?= $mitra_id =  $this->input->post('mitra'); ?>
                                                    <?php $mitra_id = $mitra_id;
                                                    $query = "SELECT *
                                    FROM `user` where `id` = $mitra_id";
                                                    $mitraa = $this->db->query($query)->row_array(); ?>
                                                    <option value="<?= $this->input->post('mitra') ?>"><?= $mitraa['name'] ?></option>
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
                                                    <option value="<?= $this->input->post('month') ?>"><?= indo_month($this->input->post('month')) ?></option>
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
                                                    <option value="<?= $this->input->post('year') ?>"><?= $this->input->post('year') ?></option>
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
        <?php } ?>
        <?php $no = 1;
        foreach ($mitrafilter as $r => $data) { ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="font-size: 24px;"> <?= $data->name; ?> </th>
                            <th></th>
                            <th style="font-size: 20px;"><?= $data->ppn + $data->pph + $data->bhp + $data->uso + $data->admin; ?>%</th>
                        </tr>
                    </thead>
                </table>
                <table>

                    <?php $query = "SELECT *
                                    FROM `customer` where `mitra` = $data->id";
                    $customer = $this->db->query($query)->result(); ?>


                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th style="text-align: center; width:20px">No</th>
                                <th>No Layanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Harga Jual</th>
                                <th>PPN <br><span style="color:red"> <?= $data->ppn; ?>%</span></th>
                                <th>PPH Final<br> <span style="color:red"><?= $data->pph; ?>%</span></th>
                                <th>BHP<br> <span style="color:red"><?= $data->bhp; ?>%</span></th>
                                <th>USO<br> <span style="color:red"><?= $data->uso; ?>%</span></th>
                                <th>Admin<br> <span style="color:red"><?= $data->admin; ?>%</span></th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1;
                            foreach ($customer as $r => $customer) { ?>
                                <?php
                                $month = $this->input->post('month');
                                $year =  $this->input->post('year');
                                $query = "SELECT *
                                    FROM `invoice` where `no_services` = $customer->no_services and `month` = $month and `year`= $year";
                                $invoice = $this->db->query($query)->row_array();

                                $no_services = $customer->no_services;
                                $query = "SELECT * , `invoice_detail`.`price` as `detail_price`
                            FROM `invoice_detail`
                            Join `package_item` ON `package_item`.`p_item_id` = `invoice_detail`.`item_id`
                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
                                $queryTot = $this->db->query($query)->result(); ?>


                                <?php $tagihan = 0;
                                foreach ($queryTot as  $dataa)
                                    $tagihan += (int) $dataa->total;

                                ?>

                                <?php if ($tagihan != $invoice['amount']) { ?>
                                    <?php
                                    $this->db->set('amount', $tagihan);
                                    $this->db->where('invoice', $invoice['invoice']);
                                    $this->db->update('invoice');
                                    ?>
                                <?php } ?>
                                <tr>
                                    <td style="text-align: center"><?= $no++ ?>.</td>
                                    <td><?= $customer->no_services; ?></td>
                                    <td><?= $customer->name; ?></td>
                                    <?php if ($invoice > 0) { ?>
                                        <td style="text-align: right;"><?= indo_currency($invoice['amount']); ?></td>
                                        <td style="text-align: right;"><?= indo_currency(($data->ppn / 100) * $invoice['amount']); ?></td>
                                        <td style="text-align: right;"><?= indo_currency(($data->pph / 100) * $invoice['amount']); ?></td>
                                        <td style="text-align: right;"><?= indo_currency(($data->bhp / 100) * $invoice['amount']); ?></td>
                                        <td style="text-align: right;"><?= indo_currency(($data->uso / 100) * $invoice['amount']); ?></td>
                                        <td style="text-align: right; color:red"><?= indo_currency(($data->admin / 100) * $invoice['amount']); ?></td>

                                        <?php
                                        $ppn = ($data->ppn / 100) * $invoice['amount'];
                                        $pph = ($data->pph / 100) * $invoice['amount'];
                                        $bhp = ($data->bhp / 100) * $invoice['amount'];
                                        $uso = ($data->uso / 100) * $invoice['amount'];
                                        $admin = ($data->admin / 100) * $invoice['amount'];
                                        ?>
                                        <td style="text-align: right;"><?= indo_currency($ppn + $pph + $bhp + $uso + $admin); ?></td>
                                    <?php } ?>
                                    <?php if ($invoice <= 0) { ?>
                                        <td style="text-align: center;">Belum tersedia</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">-</td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr style="text-align: center; font-weight:bold">
                                <?php
                                $month = $this->input->post('month');
                                $year =  $this->input->post('year');
                                $query = "SELECT *
                                    FROM `invoice` JOIN `customer` on `invoice`.`no_services` = `customer`.`no_services` where `month` = $month and `year`= $year and
                                    `mitra` = $data->id";
                                $total = $this->db->query($query)->result(); ?>
                                <?php $totalamount = 0;
                                foreach ($total as $total) {
                                    $totalamount += (int) $total->amount;
                                } ?>
                                <th colspan="3">Total</th>
                                <th style="text-align: right;"><?= indo_currency($totalamount); ?></th>
                                <th style="text-align: right;"><?= indo_currency(($data->ppn / 100) * $totalamount) ?></th>
                                <th style="text-align: right;"><?= indo_currency(($data->pph / 100) * $totalamount) ?></th>
                                <th style="text-align: right;"><?= indo_currency(($data->bhp / 100) * $totalamount) ?></th>
                                <th style="text-align: right;"><?= indo_currency(($data->uso / 100) * $totalamount) ?></th>
                                <th style="text-align: right; color:red"><?= indo_currency(($data->admin / 100) * $totalamount) ?></th>
                                <?php
                                $ppn = ($data->ppn / 100) * $totalamount;
                                $pph = ($data->pph / 100) * $totalamount;
                                $bhp = ($data->bhp / 100) * $totalamount;
                                $uso = ($data->uso / 100) * $totalamount;
                                $admin = ($data->admin / 100) * $totalamount;
                                ?>
                                <td style="text-align: right;"><?= indo_currency($ppn + $pph + $bhp + $uso + $admin); ?></td>


                            </tr>
                        </tfoot>
                    </table>
                    <br>
            </div>

        <?php } ?>
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