<?php $this->view('messages') ?>
<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">SMS Gateway</h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <?php echo form_open_multipart('setting/editsmsgateway') ?>
                    <div class="form-group">
                        <input type="hidden" name="sms_id" value="<?= $sms['sms_id'] ?>">
                        <label for="name">Nama Server</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= $sms['sms_name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="token">Token</label>
                        <input type="text" id="token" name="token" class="form-control" value="<?= $sms['sms_token'] ?>">
                    </div>

                    <!-- <div class="form-group">
                        <label for="user">User</label>
                        <input type="text" id="user" name="user" class="form-control" value="<?= $sms['sms_user'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?= $sms['sms_password'] ?>">
                    </div> -->

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
</script>