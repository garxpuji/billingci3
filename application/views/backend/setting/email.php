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
<link href="<?= base_url('assets/backend/') ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Server Email</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('setting/editEmail') ?>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $email['id'] ?>">
                        <label for="name">Nama Pengirim</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= $email['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?= $email['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?= $email['password'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="protocol">Protocol</label>
                        <input type="text" id="protocol" name="protocol" class="form-control" value="<?= $email['protocol'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="host">Host</label>
                        <input type="text" id="host" name="host" class="form-control" value="<?= $email['host'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="text" id="port" name="port" class="form-control" value="<?= $email['port'] ?>">
                    </div>
                    <!-- <div class="form-group">
                        <label>Kirim Email Ketika Pembayaran </label><code> (Owner, Admin. Pelanggan)</code>
                        <div class="row">
                            <label for="chsend_payment" class="switch ml-3">
                                <input type="checkbox" <?= $email['send_payment'] == 1 ? 'checked' : ''; ?> id="chsend_payment" />
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <input type="hidden" id="send_payment" name="send_payment" value="<?= $email['send_payment'] == 1 ? '1' : '0'; ?>">
                    </div> -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="form-group">
                        <label for="send_verify">Kirim Email Verifikasi Ketika Pelanggan Daftar</label>
                        <select class="form-control" id="send_verify" name="send_verify" required>
                            <option value="<?= $email['send_verify']; ?>"><?= $email['send_verify'] == 1 ? 'Yes' : 'No' ?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="forgot_password">Kirim Email Ketika Lupa Password</label>
                        <select class="form-control" id="forgot_password" name="forgot_password" required>
                            <option value="<?= $email['forgot_password'] ?>"><?= $email['forgot_password'] == 1 ? 'Yes' : 'No' ?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <div class=" form-group">
                    <label for="bayar">Cara Integrasi Email Server</label>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/SCKzN3gEt-s" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<!-- <div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Kirim Email</h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-customer-tab" data-toggle="pill" href="#pills-customer" role="tab" aria-controls="pills-customer" aria-selected="true">Pelanggan</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-public-tab" data-toggle="pill" href="#pills-public" role="tab" aria-controls="pills-profile" aria-selected="false">Umum</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                            <?php echo form_open_multipart('setting/sendemail') ?>
                            <div class="form-group">
                                <label for="name">Nama Pengirim</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?= $email['name'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Email Tujuan</label>
                                <select class="form-control select2" name="to_email" style="width: 100%;" required>
                                    <?php
                                    foreach ($customer as $r => $data) { ?>
                                        <option value="<?= $data->email ?>"><?= $data->email ?> - <?= $data->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subjek</label>
                                <input type="text" name="subject" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>Pesan</label>
                                <textarea id="editor1" name="message" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                            <?php echo form_close() ?>
                        </div>

                        <div class="tab-pane fade" id="pills-public" role="tabpanel" aria-labelledby="pills-public-tab">
                            <?php echo form_open_multipart('setting/sendemail') ?>
                            <div class="form-group">
                                <label for="name">Nama Pengirim</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?= $email['name'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Email Tujuan</label> <span style="font-size: xx-small;">Gunakan tanda koma (,) untuk email blast</span>
                                <input type="text" name="to_email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Subjek</label>
                                <input type="text" name="subject" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>Pesan</label>
                                <textarea id="editor2" name="message" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> -->

<script>
    $(function() {
        $('.select2').select2()
        $("#chsend_payment").click(function() {
            if ($(this).is(":checked")) {

                $("#send_payment").val('1');
            } else {
                $("#send_payment").val('0');
            }
        });
    });
</script>

<script src="<?= base_url('assets/backend/') ?>css/ckeditor/ckeditor.js"></script>
<script src="<?= base_url('assets/backend/') ?>js/bootstrap3-wysihtml5.all.min.js"></script>
<script>
    $(function() {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1')
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5()
        CKEDITOR.replace('editor2')
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5()
    })
</script>