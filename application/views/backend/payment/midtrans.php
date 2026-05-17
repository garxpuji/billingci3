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
                        <?php echo form_open_multipart('payment/editmidtrans') ?>
                        <input type="hidden" name="payment_id" value="<?= $midtrans['id'] ?>">
                        <div class="form-group">
                            <label for="chis_active" class="switch ml-3">
                                <input type="checkbox" <?= $midtrans['is_active'] == 1 ? 'checked' : ''; ?> id="chis_active">
                                <div class="slider round"></div>
                            </label>
                            <input type="hidden" name="is_active" id="is_active" value="<?= $midtrans['is_active'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="mode">Mode</label>
                            <select name="mode" id="mode" class="form-control">
                                <option value="<?= $midtrans['mode']; ?>"><?= $midtrans['mode'] == 1 ? 'Production' : 'Sanbox' ?></option>
                                <option value="0">Sanbox</option>
                                <option value="1">Production</option>
                            </select>

                        </div>
                        <div class=" form-group">
                            <label for="server_key">Server Key</label>
                            <input type="text" name="server_key" class="form-control" autocomplete="off" value="<?= $midtrans['server_key'] ?>">

                        </div>
                        <div class=" form-group">
                            <label for="client_key">Client Key</label>
                            <input type="text" name="client_key" class="form-control" autocomplete="off" value="<?= $midtrans['client_key'] ?>">
                        </div>
                        <div class=" form-group">
                            <label for="admin_fee">Biaya Admin</label> <span style="font-size: smaller; color:red">Isi jika dibebankan kepada pelanggan</span>
                            <input type="number" name="admin_fee" class="form-control" autocomplete="off" value="<?= $midtrans['admin_fee'] ?>">
                        </div>


                        <div class=" form-group row">
                            <div class="col-md-0 mt-2">
                                <label class="col-sm-12 col-form-label">Expired</label>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="number" name="expired" min="1" max="28" class="form-control" autocomplete="off" value="<?= $midtrans['expired'] ?>">
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
                            <div class="col">BCA VA</div>
                            <div class="col"> <label for="chbca_va" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['bca_va'] == 1 ? 'checked' : ''; ?> id="chbca_va" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="bca_va" id="bca_va" value="<?= $midtrans['bca_va'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">BNI VA</div>
                            <div class="col"> <label for="chbni_va" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['bni_va'] == 1 ? 'checked' : ''; ?> id="chbni_va" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="bni_va" id="bni_va" value="<?= $midtrans['bni_va'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">BRI VA</div>
                            <div class="col"> <label for="chbri_va" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['bri_va'] == 1 ? 'checked' : ''; ?> id="chbri_va" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="bri_va" id="bri_va" value="<?= $midtrans['bri_va'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">GoPay</div>
                            <div class="col"> <label for="chgopay" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['gopay'] == 1 ? 'checked' : ''; ?> id="chgopay" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="gopay" id="gopay" value="<?= $midtrans['gopay'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">ShopeePay</div>
                            <div class="col"> <label for="chshopeepay" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['shopeepay'] == 1 ? 'checked' : ''; ?> id="chshopeepay" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="shopeepay" id="shopeepay" value="<?= $midtrans['shopeepay'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">Alfamart</div>
                            <div class="col"> <label for="chalfamart" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['alfamart'] == 1 ? 'checked' : ''; ?> id="chalfamart" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="alfamart" id="alfamart" value="<?= $midtrans['alfamart'] ?>">
                        </div>
                        <div class="row">
                            <div class="col">Indomaret</div>
                            <div class="col"> <label for="chindomaret" class="switch ml-3">
                                    <input type="checkbox" <?= $midtrans['indomaret'] == 1 ? 'checked' : ''; ?> id="chindomaret" />
                                    <div class="slider round"></div>
                                </label></div>
                            <input type="hidden" name="indomaret" id="indomaret" value="<?= $midtrans['indomaret'] ?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
        $("#chbni_va").click(function() {
            if ($(this).is(":checked")) {
                $("#bni_va").val('1');
            } else {
                $("#bni_va").val('0');
            }
        });
    });
    $(function() {
        $("#chbca_va").click(function() {
            if ($(this).is(":checked")) {
                $("#bca_va").val('1');
            } else {
                $("#bca_va").val('0');
            }
        });
    });
    $(function() {
        $("#chbri_va").click(function() {
            if ($(this).is(":checked")) {
                $("#bri_va").val('1');
            } else {
                $("#bri_va").val('0');
            }
        });
    });
    $(function() {
        $("#chalfamart").click(function() {
            if ($(this).is(":checked")) {
                $("#alfamart").val('1');
            } else {
                $("#alfamart").val('0');
            }
        });
    });
    $(function() {
        $("#chindomaret").click(function() {
            if ($(this).is(":checked")) {
                $("#indomaret").val('1');
            } else {
                $("#indomaret").val('0');
            }
        });
    });
</script>