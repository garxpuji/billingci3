<?php $this->view('messages') ?>
<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Modem <?= $modem['name']; ?></h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <?php echo form_open_multipart('modem/update') ?>
                    <div class="form-group">
                        <label for="name">Nama Modem / Alias</label>
                        <input type="text" name="name" autocomplete="off" value="<?= $modem['name'] ?>" class="form-control" required>
                        <input type="hidden" name="id" autocomplete="off" value="<?= $modem['id'] ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" <?= $modem['type'] == 1 ? 'checked' : '' ?> name="typemodem" id="typemodem"> <label for="">Modem Pelanggan</label>
                    </div>
                    <input type="hidden" name="type" id="type" value="<?= $modem['type'] ?>" class="form-control">
                    <div class="form-group" id="formcustomer" style="display: <?= $modem['type'] == 1 ? 'block' : 'none' ?>;">
                        <label for="name">No Layanan - Nama Pelanggan</label>
                        <?php $customer = $this->db->get('customer')->result() ?>
                        <select class="form-control select2" name="customer_id" id="customer_id" style="width: 100%;">
                            <?php if ($modem['customer_id'] != 0) { ?>
                                <?php $getcustomer = $this->db->get_where('customer', ['customer_id' => $modem['customer_id']])->row_array() ?>
                                <option value="<?= $modem['customer_id'] ?>"><?= $getcustomer['no_services']; ?> - <?= $getcustomer['name']; ?></option>
                            <?php } ?>
                            <?php if ($modem['customer_id'] == 0) { ?>

                                <option value="0">-Pilih-</option>
                            <?php } ?>
                            <?php
                            foreach ($customer as $r => $data) { ?>
                                <option value="<?= $data->customer_id ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" id="formshowcustomer" style="display: <?= $modem['type'] == 1 ? 'block' : 'none' ?>;">
                        <label for="show_customer">Tampil di halaman Pelanggan</label>
                        <select name="show_customer" class="form-control">
                            <option value="<?= $modem['show_customer'] ?>"><?= $modem['show_customer'] == 1 ? 'Aktif' : 'Non-Aktif' ?></option>
                            <option value="0">Non-Aktif</option>
                            <option value="1">Aktif</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="ip_local">IP Lokal</label>
                                <input type="text" name="ip_local" value="<?= $modem['ip_local'] ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ip_public">IP Public</label>
                                <input type="text" name="ip_public" value="<?= $modem['ip_public'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="login_user">Username Modem</label>
                                <input type="text" name="login_user" value="<?= $modem['login_user'] ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="login_password">Password Modem</label>
                                <input type="text" name="login_password" value="<?= $modem['login_password'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="ssid_name">Nama SSID / Wifi</label>
                                <input type="text" name="ssid_name" value="<?= $modem['ssid_name'] ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ssid_password">Password SSID / Wifi</label>
                                <input type="text" name="ssid_password" value="<?= $modem['ssid_password'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea name="remark" class="form-control"><?= $modem['remark'] ?></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <?php echo form_close() ?>

        </div>
    </div>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $(function() {
        $("#typemodem").click(function() {
            if ($(this).is(":checked")) {
                $("#formcustomer").show();
                $("#formshowcustomer").show();
                $("#type").val('1');
            } else {
                $("#formcustomer").hide();
                $("#formshowcustomer").hide();
                $("#type").val('0');
            }
        });
    });
</script>