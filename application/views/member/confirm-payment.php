<!-- KODE UNIK -->
<?php if ($bill['codeunique'] == 1) { ?>
    <?php $code_unique = $bill['code_unique']  ?>
<?php } ?>
<?php if ($bill['codeunique'] == 0) { ?>
    <?php $code_unique = 0 ?>
<?php } ?>
<!-- END KODE UNIK -->

<?php $tagihan = indo_currency($bill['amount'] - $bill['disc_coupon'] + $code_unique) ?>

<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><?= $title ?></h6>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg">
                    <?php $this->view('messages') ?>
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <?= form_open_multipart('bill/confirmPayment'); ?>
                            <div class="form-group">
                                <label for="no_invoice">No invoice</label>
                                <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="<?= $bill['invoice'] ?>" readonly>
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
                                        <label for="nominal">Total Tagihan</label>
                                        <input type="text" class="form-control" id="nominal" name="nominal" value="<?= $tagihan ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="periode">Periode</label>
                                        <input type="text" class="form-control" id="periode" value="<?= indo_month($bill['month']) ?> <?= $bill['year'] ?>" readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date_payment">Tanggal Pembayaran *</label>
                                <input type="text" class="form-control" id="datepickerdisablefuture" autocomplete="off" name="date_payment" required>

                            </div>
                            <div class="form-group">
                                <label for="metode_payment">Cara Pembayaran *</label>
                                <select class="form-control" name="metode_payment" id="metode_payment" required>
                                    <option value="">-Pilih-</option>
                                    <option value="Cash"> Cash </option>
                                    <option value="Transfer">Transfer</option>
                                    <!-- <option value="Payment Gateway">Payment Gateway</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="picture">Bukti Pembayaran *</label>
                                <input type="file" class="form-control" id="picture" name="picture" required>
                                <?= form_error('bukti', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea type="text" class="form-control" id="remark" name="remark" placeholder="Isi informasi lain, nama pengirim transfer, dan lain - lain."></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Kirim</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>