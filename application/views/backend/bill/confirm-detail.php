<?php if ($bill['codeunique'] == 1) {
    $code_unique = $bill['code_unique'];
} ?>
<?php if ($bill['codeunique'] != 1) {
    $code_unique = 0;
} ?>

<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Konfirmasi Pembayaran #<?= $bill['invoice'] ?></h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('bill/confirmupdate') ?>
                    <div class="form-group">
                        <?php $Confirm = $this->db->get_where('confirm_payment', ['invoice_id' => $bill['invoice']])->row_array(); ?>
                        <label for="invoice">No invoice</label>
                        <input type="text" class="form-control" id="invoice" name="invoice" value="<?= $bill['invoice'] ?>" readonly>
                        <input type="hidden" class="form-control" id="confirm_id" name="confirm_id" value="<?= $Confirm['confirm_id'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $bill['name'] ?>" readonly>

                    </div>
                    <div class="form-group">
                        <label for="no_services">No Layanan</label>
                        <input type="text" class="form-control" id="no_services" name="no_services" value="<?= $bill['no_services'] ?>" readonly>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tagihan">Total Tagihan</label>
                                <input type="text" class="form-control" id="tagihan" name="tagihan" value="<?= indo_currency($bill['amount'] - $bill['disc_coupon']) ?>" readonly>
                                <input type="hidden" class="form-control" id="nominal" name="nominal" value="<?= $bill['amount'] - $bill['disc_coupon'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="periode">Periode</label>
                                <input type="text" class="form-control" id="periode" value="<?= indo_month($bill['month']) ?> <?= $bill['year'] ?>" readonly>
                                <input type="hidden" class="form-control" id="periode" name="month" value="<?= indo_month($bill['month']) ?>" readonly>
                                <input type="hidden" class="form-control" id="periode" name="year" value="<?= indo_month($bill['year']) ?>" readonly>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">

                        <label for="date_payment">Tanggal Pembayaran</label>
                        <input type="text" class="form-control" id="datepicker" value="<?= indo_date($Confirm['date_payment']) ?>" readonly>
                        <input type="hidden" class="form-control" id="datepicker" name="date_payment" value="<?= $Confirm['date_payment'] ?>" readonly>

                    </div>
                    <div class="form-group">

                        <label>Metode Pembayaran</label>
                        <input type="text" class="form-control" name="metode_payment" value="<?= $Confirm['metode_payment'] ?>" readonly>
                        <input type="hidden" name="category" value="1">
                        <input type="hidden" name="create_by" value="<?= $this->session->userdata('id') ?>">

                    </div>
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea id="remark" name="remark" class="form-control" readonly><?= $Confirm['remark'] ?></textarea>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="form-group">
                        <label for="bukti">Bukti Pembayaran</label>
                        <img src="<?= base_url('assets/images/confirm/') ?><?= $Confirm['picture'] ?>" style=" margin-top: 8px;
   width: 100%;
   padding: 10px;" alt="" alt="">
                    </div>
                </div>
                <?php if ($Confirm['status'] == 'Pending') { ?>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Verifikasi</button>
                    </div>
                <?php } ?>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>