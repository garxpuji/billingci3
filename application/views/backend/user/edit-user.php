<div class="col-lg-6 col-sm-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"> <?= $title ?>
            </h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('user/editUser') ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id'] ?>" class="form-control">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $row['name']; ?>">
                    <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $row['email']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="<?= $row['gender']; ?>"><?= $row['gender']; ?></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <?= form_error('gender', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone" value="<?= $row['phone']; ?>" placeholder="">
                    <?= form_error('phone', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>
                <input type="hidden" class="form-control" id="image1" name="image1" value="<?= $row['image']; ?>" placeholder="">
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="4"><?= $row['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="name">Status</label>
                    <select name="is_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0" <?= $row['is_active'] == 0 ? 'selected' : null ?>>Non Active</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Level</label>
                    <select name="role_id" class="form-control">
                        <option value="<?= $row['role_id'] ?>"><?= $row['role_id'] == 2 ? 'Pelanggan' : null ?><?= $row['role_id'] == 1 ? 'Admin' : null ?><?= $row['role_id'] == 3 ? 'Operator' : null ?><?= $row['role_id'] == 5 ? 'Teknisi' : null ?></option>
                        <option value="1">Admin</option>
                        <option value="2">Pelanggan</option>
                        <option value="3">Operator</option>
                        <option value="5">Teknisi</option>
                    </select>
                </div>
                <input type="checkbox" name="clickchange" id="clickchange"> <label for="">Reset Password</label>
                <div class="" id="changepassword" style="display: none">

                    <div class="form-group">
                        <label for="password">New Password</label> * <span>kosongkan jika tidak diganti</span>
                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="">
                    </div>
                    <?php $wa = $this->db->get('whatsapp')->row_array() ?>
                    <div class="col" id="formsendwa">
                        <?php if ($wa['is_active'] == 1) { ?>
                            <input type="checkbox" name="sendwa" id="sendwa"> <label for="">Kirim Data Email & Password</label>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label id="statuswa" style="display: none">Status Whatsapp Gateway : </label>
                        <div class="connectionwa"></div>
                    </div>
                    <div class="loadingwa"></div>

                    <input type="hidden" name="sendwapelanggan" id="sendwapelanggan">
                    <input type="hidden" name="vendor" id="vendor" value="<?= $wa['vendor'] ?>">
                </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
            <button class="btn btn-primary" type="submit"> Update</button>
            </form>
        </div>
    </div>
</div>
<script>
    $("#sendwa").click(function() {
        if ($(this).is(":checked")) {
            var vendor = $("#vendor").val();
            var url = "<?= site_url('whatsapp/cekconnection') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&vendor=" + vendor,
                cache: false,
                beforeSend: function() {
                    $('.loadingwa').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                },
                success: function(data) {
                    $('.loadingwa').html('');
                    $("#statuswa").show();
                    $('.connectionwa').html(data);
                    $("#sendwapelanggan").val('1');
                    document.getElementById("sendwa").checked = true;
                }
            });
            return false;
        } else {
            $("#sendwapelanggan").val('0');

        }
    });

    $("#clickchange").click(function() {
        if ($(this).is(":checked")) {
            $("#changepassword").show();
        } else {
            $("#changepassword").hide();
            document.getElementById("sendwa").checked = false;
            $("#sendwapelanggan").val('0');
            $('.connectionwa').html('');
            $("#statuswa").hide();
        }
    });
</script>