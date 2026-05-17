<?php $this->view('messages') ?>
<?php

use Xendit\Xendit; ?>
<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
<div class="col-lg-12">
    <div class="page-header-title">
        <img src="<?= base_url('assets/images/') ?><?= $company['logo'] ?>" width="150"> <br><br>
        <?php if ($invoice['x_method'] == 'VIRTUAL_ACCOUNT') { ?>
            <div class="d-inline">
                <h5><?= $company['company_name']; ?></h5>
                Mohon selesaikan pembayaran Anda sebelum tanggal <?= date('Y-m-d H:i:s', strtotime($invoice['x_expired'])); ?> dengan rincian sebagai berikut;
            </div>
            <div class="row mt-2">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">Kode Pembayaran</h6>
                        </div>
                        <div class="row ml-1">
                            <?php if ($invoice['x_bank_code'] == 'BCA') { ?>
                                <div class="col mt-2">
                                    BCA Virtual Account <br> <br>

                                    <span style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                    <br>
                                    <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                </div>
                                <div class="col">
                                    <img src="<?= base_url('assets/images/pg/bca.png') ?>" width="150"> <br><br>
                                </div>
                            <?php } ?>
                            <?php if ($invoice['x_bank_code'] == 'BRI') { ?>
                                <div class="col mt-2">
                                    BRI Virtual Account <br> <br>
                                    <span id="copy" style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                    <br> <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                </div>
                                <div class="col">
                                    <img src="<?= base_url('assets/images/pg/bri.png') ?>" width="150"> <br><br>
                                </div>
                            <?php } ?>
                            <?php if ($invoice['x_bank_code'] == 'MANDIRI') { ?>
                                <div class="col mt-2">
                                    Mandiri Virtual Account <br> <br>
                                    <span id="copy" style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                    <br> <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                </div>
                                <div class="col">
                                    <img src="<?= base_url('assets/images/pg/mandiri.png') ?>" width="150"> <br><br>
                                </div>
                            <?php } ?>
                            <?php if ($invoice['x_bank_code'] == 'BNI') { ?>
                                <div class="col mt-2">
                                    BNI Virtual Account <br> <br>
                                    <span id="copy" style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                    <br> <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                </div>
                                <div class="col">
                                    <img src="<?= base_url('assets/images/pg/bni.png') ?>" width="150"> <br><br>
                                </div>
                            <?php } ?>
                            <?php if ($invoice['x_bank_code'] == 'PERMATA') { ?>
                                <div class="col mt-2">
                                    PERMATA Virtual Account <br> <br>
                                    <span id="copy" style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                    <br> <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                </div>
                                <div class="col">
                                    <img src="<?= base_url('assets/images/pg/permata.png') ?>" width="150"> <br><br>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="container">
                            <span>Jumlah yang harus dibayar</span>
                            <h3 style="color:red; font-weight:bolder">Rp <?= indo_currency($invoice['x_amount']); ?></h3>
                            Terbilang : <?= number_to_words($invoice['x_amount']); ?>
                        </div>
                        <br>
                        <br>

                    </div>
                </div>

            </div>
        <?php } ?>
        <?php if ($invoice['x_method'] == 'EWALLET') { ?>
            <?php if ($invoice['x_bank_code'] == 'DANA') { ?>
                <div class="d-inline">
                    <h5><?= $company['company_name']; ?></h5>
                    Mohon selesaikan pembayaran Anda sebelum tanggal <?= date('Y-m-d H:i:s', strtotime($invoice['x_expired'])); ?> dengan rincian sebagai berikut;
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold">Metode Pembayaran <?= $invoice['x_method']; ?> - <?= $invoice['x_bank_code']; ?></h6>
                            </div>
                            <div class="container">
                                <span>Jumlah yang harus dibayar</span>
                                <h3 style="color:red; font-weight:bolder">Rp <?= indo_currency($invoice['x_amount']); ?></h3>
                                Terbilang : <?= number_to_words($invoice['x_amount']); ?>
                                <?php
                                $xendit = $this->db->get('payment_gateway')->row_array();
                                Xendit::setApiKey($xendit['api_key']);
                                $getDana = \Xendit\EWallets::getPaymentStatus('16647-210330001', 'DANA');
                                // var_dump($getDana); 
                                ?>
                                <br>
                                <br> Status : <?= $getDana['status']; ?>
                                <br><br>
                                Link Pemabayaran : <a href="<?= $getDana['checkout_url']; ?>" class="btn btn-success">Checkout</a>
                                <br><br><span style="color: red;">Catatan :</span> <span>Jika sudah melakukan pembayaran, silahkan tunggu hingga status menjadi completed / sudah bayar. jika masih gagal hubungi kami.</span>
                            </div>
                            <br>
                            <br>

                        </div>
                    </div>

                </div>
            <?php } ?>

        <?php } ?>
        <?php if ($invoice['x_method'] == 'RETAIL_OUTLET') { ?>
            <?php if ($invoice['x_bank_code'] == 'ALFAMART') { ?>
                <div class="d-inline">
                    <h5><?= $company['company_name']; ?></h5>
                    Mohon selesaikan pembayaran Anda sebelum tanggal <?= date('Y-m-d H:i:s', strtotime($invoice['x_expired'])); ?> dengan rincian sebagai berikut;
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold">Kode Pembayaran</h6>
                            </div>
                            <div class="container">
                                <?php if ($invoice['x_bank_code'] == 'ALFAMART') { ?>
                                    <div class="col mt-2">
                                        <span id="copy" style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                        <br> <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                    </div>
                                    <div class="col">
                                        <img src="<?= base_url('assets/images/pg/alfa.png') ?>" width="150"> <br><br>
                                    </div>
                                <?php } ?>

                                <span>Jumlah yang harus dibayar</span>
                                <h3 style="color:red; font-weight:bolder">Rp <?= indo_currency($invoice['x_amount']); ?></h3>
                                Terbilang : <?= number_to_words($invoice['x_amount']); ?>
                                <br><br>
                                <span style="color: black; font-size:16px">Berikut adalah cara melakukan pembayaran melalui gerai Alfamart:</span>

                                <li> Datang ke salah satu gerai Alfa group terdekat</li>
                                <li> Beritahu kasir untuk melakukan pembayaran ke <?= $pg['kodemerchant']; ?></li>
                                <li> Tunjukkan kode pembayaran tagihan <span style="color: red;"><?= $invoice['x_account_number']; ?></span></li>
                                <li> Lakukan pembayaran sesuai dengan nominal tagihan</li>
                                <li> Terima tanda terima sebagai bukti pembayaran.</li>
                                <!-- <br><br><span style="color: red;">Catatan :</span> <span>Jika sudah melakukan pembayaran, silahkan tunggu hingga status menjadi completed / sudah bayar. jika masih gagal hubungi kami.</span> -->
                            </div>
                            <br>
                            <br>

                        </div>
                    </div>

                </div>
            <?php } ?>
            <?php if ($invoice['x_bank_code'] == 'INDOMARET') { ?>
                <div class="d-inline">
                    <h5><?= $company['company_name']; ?></h5>
                    Mohon selesaikan pembayaran Anda sebelum tanggal <?= date('Y-m-d H:i:s', strtotime($invoice['x_expired'])); ?> dengan rincian sebagai berikut;
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold">Kode Pembayaran</h6>
                            </div>
                            <div class="container">
                                <?php if ($invoice['x_bank_code'] == 'INDOMARET') { ?>
                                    <div class="col mt-2">
                                        <span id="copy" style="color: black; font-size:xx-large"> <?= $invoice['x_account_number']; ?></span>
                                        <br> <a href="javascript:void(0)" class="btn btn-outline-success" onclick="CopyToClipboard('va')">Copy</a>
                                    </div>
                                    <div class="col">
                                        <img src="<?= base_url('assets/images/pg/indo.png') ?>" width="150"> <br><br>
                                    </div>
                                <?php } ?>

                                <span>Jumlah yang harus dibayar</span>
                                <h3 style="color:red; font-weight:bolder">Rp <?= indo_currency($invoice['x_amount']); ?></h3>
                                Terbilang : <?= number_to_words($invoice['x_amount']); ?>
                                <br><br>
                                <span style="color: black; font-size:16px">Berikut adalah cara melakukan pembayaran melalui gerai Indomaret:</span>

                                <li> Datang ke salah satu gerai Indomaret terdekat</li>
                                <li> Beritahu kasir untuk melakukan pembayaran ke Xendit</li>
                                <li> Tunjukkan kode pembayaran tagihan <span style="color: red;"><?= $invoice['x_account_number']; ?></span></li>
                                <li> Lakukan pembayaran sesuai dengan nominal tagihan</li>
                                <li> Terima tanda terima sebagai bukti pembayaran.</li>
                                <!-- <br><br><span style="color: red;">Catatan :</span> <span>Jika sudah melakukan pembayaran, silahkan tunggu hingga status menjadi completed / sudah bayar. jika masih gagal hubungi kami.</span> -->
                            </div>
                            <br>
                            <br>

                        </div>
                    </div>

                </div>
            <?php } ?>

        <?php } ?>
        <?php if ($invoice['x_method'] == 'qrcode') { ?>

            <div class="d-inline">
                <h5><?= $company['company_name']; ?></h5>
                <!-- Mohon selesaikan pembayaran Anda sebelum tanggal <?= date('Y-m-d H:i:s', strtotime($invoice['x_expired'])); ?> dengan rincian sebagai berikut; -->
            </div>
            <div class="row mt-2">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">QR-Code Pembayaran</h6>
                        </div>
                        <div class="container">

                            <div class="col mt-2">
                                <img src="<?= base_url('assets/images/pg/' . $invoice['invoice'] . '.png') ?>" width="250"> <br><br>
                            </div>


                            <span>Jumlah yang harus dibayar</span>
                            <h3 style="color:red; font-weight:bolder">Rp <?= indo_currency($invoice['x_amount']); ?></h3>
                            Terbilang : <?= number_to_words($invoice['x_amount']); ?>
                            <br><br>
                            <span style="color: black; font-size:16px">Berikut adalah cara melakukan pembayaran melalui QRIS:</span>

                            <li> Buka Aplikasi E-Wallet yang mendukung QRIS</li>
                            <li> Cek nilai transaksi, scan Qr-Code</li>

                            <li> Masukkan PIN untuk melanjutkan transaksi</li>
                            <li> Selesai. Transaksi anda telah berhasil.</li>
                            <!-- <br><br><span style="color: red;">Catatan :</span> <span>Jika sudah melakukan pembayaran, silahkan tunggu hingga status menjadi completed / sudah bayar. jika masih gagal hubungi kami.</span> -->
                        </div>
                        <br>
                        <br>

                    </div>
                </div>

            </div>



        <?php } ?>
    </div>
</div>
<div id="va" style="display:none">
    <?= $invoice['x_account_number'] ?>
</div>

<script>
    function CopyToClipboard(containerid) {
        document.getElementById(containerid).style.display = 'block';
        document.getElementById(containerid).focus();
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select().createTextRange();
            document.execCommand("Copy");
            alert("Copy berhasil");
        } else if (window.getSelection) {
            window.getSelection().removeAllRanges();
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().addRange(range);
            document.execCommand("Copy");
            alert("Copy berhasil");
        }
        document.getElementById(containerid).style.display = 'none';
    }
</script>