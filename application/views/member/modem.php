<?php $this->view('messages') ?>
<div class="row">
    <?php
    foreach ($modem as $r => $data) { ?>
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <!-- <img src="<?= base_url(''); ?>assets/images/profile/<?= $user['image']; ?>" class="rounded-circle" width="150"> -->
                        <h4 class="card-title mt-10"><?= $data->name ?></h4>
                        <p><?= $data->remark; ?></p>
                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body center">
                    <p class="text-mute"><b>
                            <font>Detail Modem</font>
                        </b><br>
                        Nama SSID / Wifi : <?= $data->ssid_name; ?><br>
                        Password : <?= $data->ssid_password; ?><br>
                    </p>
                    <p class="text-mute"><b>
                            <font>Akses Modem</font>
                        </b><br>
                        Username : <?= $data->login_user; ?><br>
                        Password : <?= $data->login_password; ?> <br>
                    </p>
                    <a href="http://<?= $data->ip_local ?>" target="blank" class="mb-2 btn btn-sm btn-secondary"> <b>Akses Via Lokal</b></a>
                    <?php if ($data->ip_public != '') { ?>
                        <a href="http://<?= $data->ip_public ?>" target="blank" class="mb-2 btn btn-sm btn-secondary"> <b>Akses Jarak Jauh</b></a>
                    <?php } ?>

                </div>


            </div>
        </div>
    <?php } ?>
    <?php if (count($modem) == 0) { ?>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Permintaan Ganti Password Wifi</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <?php echo form_open_multipart('member/updatepassword') ?>

                            <div class="form-group">
                                <label for="name">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $customer['name'] ?>" readonly>

                            </div>
                            <div class="form-group">
                                <label for="no_services">No Layanan</label>
                                <input type="text" class="form-control" id="no_services" name="no_services" value="<?= $customer['no_services'] ?>" readonly>

                            </div>
                            <!-- <div class="form-group">
                                <label for="old_password">Password Lama</label>
                                <input type="text" class="form-control" id="old_password" name="old_password">
                            </div> -->
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="text" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="remark">Keterangan</label>
                                <input type="text" class="form-control" id="remark" name="remark">
                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary">Kirim</button>
                            </div>

                            Catatan : Jika dalam 1x24 jam belum ada update, anda bisa gunakan fitur open tiket.
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

    <?php } ?>
</div>