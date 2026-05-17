<!-- Page Heading -->
<?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <label for="chis_active" class="switch ml-3">
        Is Active
        <?php if ($rt['is_active'] == 1) { ?>
            <input type="checkbox" checked id="chis_active" onclick="javascript:window.location.href='<?= base_url('router/nonactive') ?>'">
        <?php } ?>
        <?php if ($rt['is_active'] == 0) { ?>
            <input type="checkbox" id="chis_active" onclick="javascript:window.location.href='<?= base_url('router/active') ?>'">
        <?php } ?>
        <div class="slider round"></div>
    </label>

</div>

<?php $this->view('messages') ?>
<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><?= $title; ?></h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <?php echo form_open_multipart('router/edit') ?>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $router['id'] ?>">
                        <label for="name">IP Address</label>
                        <input type="text" id="name" name="ip_address" class="form-control" value="<?= $router['ip_address'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Username</label>
                        <input type="text" id="email" name="username" class="form-control" value="<?= $router['username'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?= $router['password'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="number" id="port" name="port" class="form-control" value="<?= $router['port'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Status Router : </label>
                        <div class="loading"></div>
                        <div class="connection"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button id="cekkoneksi" class="btn btn-warning" data-dismiss="modal">Cek Koneksi</button>
                    </div>
                </div>
            </div>

            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script>
    $("#cekkoneksi").click(function() {
        var url = "<?= site_url('router/cekconnection') ?>" + "/" + Math.random();
        $.ajax({
            type: 'POST',
            url: url,

            cache: false,
            beforeSend: function() {
                $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
            },
            success: function(data) {
                $('.loading').html('');
                $('.connection').html(data);
            }
        });
        return false;
    });
</script>