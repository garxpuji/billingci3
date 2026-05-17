<style>
    .switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;

    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: gray;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: blue;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php $this->view('messages') ?>


<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan <?= $title; ?></h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <?php echo form_open_multipart('payment/editXendit') ?>
                        <input type="hidden" name="payment_id" value="<?= $xendit['id'] ?>">
                        <div class="form-group">
                            <label for="chis_active" class="switch ml-3">
                                <input type="checkbox" <?= $xendit['is_active'] == 1 ? 'checked' : ''; ?> id="chis_active">
                                <div class="slider round"></div>
                            </label>
                            <input type="hidden" name="is_active" id="is_active" value="<?= $xendit['is_active'] ?>">
                        </div>
                        <!-- <div class="form-group">
                            <label for="mode">Mode</label>
                            <select name="mode" id="mode" class="form-control">
                                <option value="<?= $xendit['mode']; ?>"><?= $xendit['mode'] == 1 ? 'Production' : 'Sanbox' ?></option>
                                <option value="0">Sanbox</option>
                                <option value="1">Production</option>
                            </select>

                        </div> -->
                        <div class=" form-group">
                            <label for="server_key">Api Key</label>
                            <input type="text" name="server_key" class="form-control" autocomplete="off" value="<?= $xendit['server_key'] ?>">

                        </div>

                        <div class=" form-group">
                            <label for="admin_fee">Biaya Admin</label> <span style="font-size: smaller; color:red">Isi jika dibebankan kepada pelanggan</span>
                            <input type="number" name="admin_fee" class="form-control" autocomplete="off" value="<?= $xendit['admin_fee'] ?>">
                        </div>


                        <div class=" form-group row">
                            <div class="col-md-0 mt-2">
                                <label class="col-sm-12 col-form-label">Expired</label>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="number" name="expired" min="1" max="28" class="form-control" autocomplete="off" value="<?= $xendit['expired'] ?>">
                            </div>
                            <div class="col-sm-3 mt-2">
                                <label class="col-sm-12 col-form-label">Hari</label>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Mode Pemabayaran</h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">Virtual Account</div>
                            <div class="col"> <label for="chva" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['va'] == 1 ? 'checked' : ''; ?> id="chva" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="va" id="va" value="<?= $xendit['va'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">E-Wallet</div>
                            <div class="col"> <label for="chewallet" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['ewallet'] == 1 ? 'checked' : ''; ?> id="chewallet" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="ewallet" id="ewallet" value="<?= $xendit['ewallet'] ?>">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">Retail</div>
                            <div class="col"> <label for="chretail" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['retail'] == 1 ? 'checked' : ''; ?> id="chretail" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="retail" id="retail" value="<?= $xendit['retail'] ?>">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">Qr Code (QRIS)</div>
                            <div class="col"> <label for="chqrcode" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['qrcode'] == 1 ? 'checked' : ''; ?> id="chqrcode" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="qrcode" id="qrcode" value="<?= $xendit['qrcode'] ?>">
                        </div>
                        <br>
                        <span>* Catatan : Untuk melihat metode pembayaran yang aktif silahkan cek Akun Xendit anda atau Klik <a href="https://dashboard.xendit.co/settings/payment-methods">di Sini</a></span>
                        <!-- <div class="row">
                            <div class="col">Retail Outlet</div>
                            <div class="col"> <label for="chbni_va" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['bni_va'] == 1 ? 'checked' : ''; ?> id="chbni_va" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="bni_va" id="bni_va" value="<?= $xendit['bni_va'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">BRI VA</div>
                            <div class="col"> <label for="chbri_va" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['bri_va'] == 1 ? 'checked' : ''; ?> id="chbri_va" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="bri_va" id="bri_va" value="<?= $xendit['bri_va'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">Alfamart</div>
                            <div class="col"> <label for="chalfamart" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['alfamart'] == 1 ? 'checked' : ''; ?> id="chalfamart" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="alfamart" id="alfamart" value="<?= $xendit['alfamart'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">Indomaret</div>
                            <div class="col"> <label for="chindomaret" class="switch ml-3">
                                    <input type="checkbox" <?= $xendit['indomaret'] == 1 ? 'checked' : ''; ?> id="chindomaret" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="indomaret" id="indomaret" value="<?= $xendit['indomaret'] ?>">
                        </div>
                    </div> -->

                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?= site_url('payment/xendit') ?>" class="btn btn-success">Dashboard Xendit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan Callback Di Akun Xendit <a href="https://dashboard.xendit.co/settings/developers#callbacks" target="blank">Klik Disini</a></h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">

                        <div class=" form-group">
                            <label for="bayar">FVA terbayarkan</label> <span style="font-size: smaller; color:red">ketika sudah pembayaran</span>
                            <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>xendit/pay" disabled>
                        </div>
                        <div class=" form-group">
                            <label for="bayar">FVA dibuat dan diperbaharui</label> <span style="font-size: smaller; color:red">ketika pelanggan checkout</span>
                            <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>xendit/create" disabled>
                        </div>
                        <div class=" form-group">
                            <label for="bayar">Retail outlet terbayarkan</label> <span style="font-size: smaller; color:red">ketika pelanggan melakukan pembayaran ke retail</span>
                            <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>xendit/payretail" disabled>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Tutorial </h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <?php $link = base_url(); ?>
                        <div class=" form-group">
                            <label for="bayar">Konfigurasi & Mode Test Xendit</label>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/m-It2--hp7c" allowfullscreen></iframe>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#chis_active").click(function() {
                if ($(this).is(":checked")) {
                    $("#is_active").val('1');
                } else {
                    $("#is_active").val('0');
                }
            });
        });

        $(function() {
            $("#chva").click(function() {
                if ($(this).is(":checked")) {
                    $("#va").val('1');
                } else {
                    $("#va").val('0');
                }
            });
        });
        $(function() {
            $("#chewallet").click(function() {
                if ($(this).is(":checked")) {
                    $("#ewallet").val('1');
                } else {
                    $("#ewallet").val('0');
                }
            });
        });
        $(function() {
            $("#chretail").click(function() {
                if ($(this).is(":checked")) {
                    $("#retail").val('1');
                } else {
                    $("#retail").val('0');
                }
            });
        });
        $(function() {
            $("#chqrcode").click(function() {
                if ($(this).is(":checked")) {
                    $("#qrcode").val('1');
                } else {
                    $("#qrcode").val('0');
                }
            });
        });
    </script>