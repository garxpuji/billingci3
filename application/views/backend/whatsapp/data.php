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

<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Whatsapp Gateway</h6>
        </div>
        <div class="container mt-2 alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-bell"></i> Ini adalah Whatsapp Non-Official <br> Silahkan gunakan dengan bijak <br>Interval Message berfungsi utk membuat jangka waktu kirim pesan agar tidak dianggap robot (meminimalisir ke blokir)
            <br>Kami tidak bertanggung jawab jika akun Whatsapp Anda ke blokir. Silahkan gunakan No Whatsapp Khusus.
        </div>
        <div class="row">

            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('whatsapp/edit') ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="chis_active" class="switch ml-3">
                                <input type="checkbox" <?= $whatsapp['is_active'] == 1 ? 'checked' : ''; ?> id="chis_active" />
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <input type="hidden" id="is_active" name="is_active" value="<?= $whatsapp['is_active'] == 1 ? '1' : '0'; ?>">
                    </div>
                    <input type="hidden" name="id" value="<?= $whatsapp['id'] ?>">
                    <div class="form-group">
                        <label for="vendor">Vendor</label>
                        <select name="vendor" id="vendor" class="form-control" required onChange="selectvendor(this);">
                            <?php if ($whatsapp['vendor'] == '') { ?>
                                <option value="">-Pilih-</option>
                            <?php } ?>
                            <?php if ($whatsapp['vendor'] != '') { ?>
                                <option value="<?= $whatsapp['vendor'] ?>"><?= $whatsapp['vendor'] ?></option>
                            <?php } ?>
                            <option value="Starsender">Starsender - startsender.online</option>
                            <option value="Ruangwa">Ruang WA - ruangwa.id</option>
                            <option value="WAblas">WAblas - wablas.com</option>
                            <option value="Other">Other</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <div id="username" style="display: <?= $whatsapp['vendor'] == 'Other' ? 'block' : 'none'; ?>">
                            <label for="username">Sender</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= $whatsapp['username'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="version" style="display: <?= $whatsapp['vendor'] == 'WAblas'  ? 'block' : 'none'; ?>">
                            <label for="version">Version</label>
                            <select name="version" class="form-control">
                                <?php if ($whatsapp['version'] != '') { ?>
                                    <option value="<?= $whatsapp['version'] ?>"><?= $whatsapp['version'] == 0 ? 'V1' : 'V2' ?></option>
                                <?php } ?>

                                <option value="1">V2</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tokenn" style="display: <?= $whatsapp['vendor'] == 'WAblas' | $whatsapp['vendor'] == 'Other' ? 'block' : 'none'; ?>">
                            <label for="token">Token API</label>
                            <input type="text" name="token" id="token" class="form-control" value="<?= $whatsapp['token'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="api_key" style="display: <?= $whatsapp['vendor'] == 'Starsender' | $whatsapp['vendor'] == 'Ruangwa' ? 'block' : 'none'; ?>">
                            <label for="api_key">API Key</label>
                            <input type="text" id="api_key" name="api_key" class="form-control" value="<?= $whatsapp['api_key'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="domain_api" style="display: <?= $whatsapp['vendor'] == 'WAblas' | $whatsapp['vendor'] == 'Other' ? 'block' : 'none'; ?>">
                            <label for="domain_api">Domain API</label>
                            <input type="text" name="domain_api" class="form-control" value="<?= $whatsapp['domain_api'] ?>">
                        </div>
                    </div>
                    <div class="form-group" id="forminterval" style="display:<?= $whatsapp['vendor'] == 'WAblas' | $whatsapp['vendor'] == 'Starsender' ? 'block' : 'none'; ?>">
                        <label for="interval_message">Interval Message</label> <input type="checkbox" <?= $whatsapp['period'] == 0 ? 'checked' : ''; ?> name="period" id="period">

                        <span><?= $whatsapp['period'] == 0 ? '' : '<span style="color:red">Kami tidak bertanggung jawab jika akun Whatsapp anda ke banned </span>'; ?></span>
                        <div class="input-group mb-3">
                            <input type="number" min="1" max="60" id="interval" name="interval_message" class="form-control" value="<?= $whatsapp['interval_message'] ?>">
                            <div class="input-group-append">
                                <span class="input-group-text" id="textinterval"><?= $whatsapp['vendor'] == 'WAblas' ? 'Menit' : 'Detik'; ?></span>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">

                                    <label>Kirim ketika tagihan dibuat</label>

                                    <div class="row">
                                        <label for="chcreateinvoice" class="switch ml-3">
                                            <input type="checkbox" <?= $whatsapp['createinvoice'] == 1 ? 'checked' : ''; ?> id="chcreateinvoice" />
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                    <input type="hidden" id="createinvoice" name="createinvoice" value="<?= $whatsapp['createinvoice'] == 1 ? '1' : '0'; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kirim Ulang Tagihan</label> <br>
                                    <span style="font-size: x-small; color:red">Khusus Tagihan Belum Bayar yg tgl pesan terkirim kosong</span>
                                    <div class="row">
                                        <label for="chsch_resend" class="switch ml-3">
                                            <input type="checkbox" <?= $other['sch_resend'] == 1 ? 'checked' : ''; ?> id="chsch_resend" />
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                    <input type="hidden" id="sch_resend" name="sch_resend" value="<?= $other['sch_resend'] == 1 ? '1' : '0'; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kirim ketika pembayaran diterima</label>
                                    <div class="row">
                                        <label for="chpaymentinvoice" class="switch ml-3">
                                            <input type="checkbox" <?= $whatsapp['paymentinvoice'] == 1 ? 'checked' : ''; ?> id="chpaymentinvoice" />
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                    <input type="hidden" id="paymentinvoice" name="paymentinvoice" value="<?= $whatsapp['paymentinvoice'] == 1 ? '1' : '0'; ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Kirim ketika jatuh tempo</label>
                                    <div class="row">
                                        <label for="chduedateinvoice" class="switch ml-3">
                                            <input type="checkbox" <?= $whatsapp['duedateinvoice'] == 1 ? 'checked' : ''; ?> id="chduedateinvoice" />
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                    <input type="hidden" id="duedateinvoice" name="duedateinvoice" value="<?= $whatsapp['duedateinvoice'] == 1 ? '1' : '0'; ?>">
                                </div>
                                <div class="form-group">

                                    <label>Pengingat sebelum jatuh tempo,</label> <span style="font-size:smaller"></span>

                                    <div class="row">
                                        <label for="chreminderinvoice" class="switch ml-3">
                                            <input type="checkbox" <?= $whatsapp['reminderinvoice'] == 1 ? 'checked' : ''; ?> id="chreminderinvoice" />
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                    <input type="hidden" id="reminderinvoice" name="reminderinvoice" value="<?= $whatsapp['reminderinvoice'] == 1 ? '1' : '0'; ?>">
                                    <div class="form-group">

                                        <div class="input-group mb-3">
                                            <input type="number" min="1" max="15" name="date_reminder" class="form-control" value="<?= $other['date_reminder'] ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Hari sebelum </span>
                                            </div>
                                        </div>
                                        <span>Pastikan schedule juga aktif</span>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="form-group">
                                    <label for="createhelp">Kirim ke Teknisi Ketika Tiket Dibuat</label>
                                    <select class="form-control" id="create_help" name="create_help" required>
                                        <option value="<?= $whatsapp['create_help']; ?>"><?= $whatsapp['create_help'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="createhelp">Kirim ke Admin Ketika Tiket Dibuat</label>
                                    <select class="form-control" id="create_help_admin" name="create_help_admin" required>
                                        <option value="<?= $whatsapp['create_help_admin']; ?>"><?= $whatsapp['create_help_admin'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?= site_url('whatsapp/template') ?>" class="btn btn-danger">Text WA</a>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <?php echo form_close() ?>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="row mt-2">
                    <h2>Test Kirim Pesan</h2>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('whatsapp/testsend') ?>" method="POST">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <input type="text" name="vendor" class="form-control" value="<?= $whatsapp['vendor'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="number">No Tujuan</label>
                            <input type="number" id="number" name="number" class="form-control" placeholder="no tujuan" required>
                        </div>
                        <div class=" form-group">
                            <label for="message">Isi Pesan</label>
                            <textarea name="message" class="form-control" id="" required cols="30" rows="3" placeholder="isi pesan"></textarea>
                        </div>
                        <div class="modal-footer">

                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/65ZpdGLJVxc" allowfullscreen></iframe>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    $(function() {
        $("#chcreateinvoice").click(function() {
            if ($(this).is(":checked")) {

                $("#createinvoice").val('1');
            } else {
                $("#createinvoice").val('0');

            }
        });
        $("#chsch_resend").click(function() {
            if ($(this).is(":checked")) {

                $("#sch_resend").val('1');
            } else {
                $("#sch_resend").val('0');

            }
        });
        $("#chpaymentinvoice").click(function() {
            if ($(this).is(":checked")) {

                $("#paymentinvoice").val('1');
            } else {
                $("#paymentinvoice").val('0');

            }
        });
        $("#chduedateinvoice").click(function() {
            if ($(this).is(":checked")) {

                $("#duedateinvoice").val('1');
            } else {
                $("#duedateinvoice").val('0');

            }
        });
        $("#chreminderinvoice").click(function() {
            if ($(this).is(":checked")) {

                $("#reminderinvoice").val('1');
            } else {
                $("#reminderinvoice").val('0');

            }
        });
        $("#chis_active").click(function() {
            if ($(this).is(":checked")) {
                $("#is_active").val('1');
            } else {
                $("#is_active").val('0');
            }
        });
    });

    function selectvendor(sel) {
        var vendor = $('#vendor').val();

        if (vendor == 'Starsender') {
            $("#user_name").hide();
            $("#username").hide();
            $("#api_key").show()
            $("#api_key").focus()
            $("#tokenn").hide();
            $("#version").hide();
            $("#domain_api").hide();
            $("#forminterval").show()
            $("#interval").val('10');
            $("#textinterval").html('Detik');


        }
        if (vendor == 'WAblas') {
            $("#tokenn").show();
            $("#version").show();
            $("#token").focus();
            $("#domain_api").show();
            $("#username").hide();
            $("#api_key").hide();
            $("#forminterval").show()
            $("#interval").val('10');
            $("#textinterval").html('Detik');
        }
        if (vendor == 'Other') {
            $("#tokenn").show();
            $("#username").focus();
            $("#domain_api").show();
            $("#username").show();
            $("#api_key").hide();
            $("#version").hide();
            $("#forminterval").hide()
            $("#interval").val('1');
            $("#textinterval").html('Menit');
        }
    }
</script>