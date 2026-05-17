<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Pelanggan</h6>
        </div>
        <div class="card-body">
            <?php echo form_open_multipart('mikrotik/editcustomer') ?>
            <input type="hidden" name="customer_id" value="<?= $customer->customer_id ?>" class="form-control" readonly>

            <div class="form-group">
                <label for="name">No Layanan</label>

                <input type="text" class="form-control" value="<?= $customer->no_services ?>" readonly>
                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <label for="name">Customer Name</label>

                <input type="text" id="name" name="name" class="form-control" value="<?= $customer->name ?>" readonly>
                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col"> <input type="checkbox" name="changeconnection" id="changeconnection"> <label for="">Ganti Koneksi</label></div>
                </div>
            </div>
            <div class="form-group" id="formrouter" style="display: none">
                <?php $listrouter = $this->db->get('router')->result() ?>
                <?php $router = $this->db->get_where('router', ['id' => $customer->router])->row_array() ?>
                <label for="router">Router</label>
                <select name="router" id="router" class="form-control" onChange="selectrouter(this);">
                    <option value="<?= $customer->router ?>"><?= $router['alias']; ?></option>
                    <?php foreach ($listrouter as $router) { ?>
                        <option value="<?= $router->id ?>"><?= $router->alias; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group" id="btn-mikro" style="display: none">
                <div class="row">
                    <div class="col"> <input type="checkbox" name="createusermikrotik" id="createusermikrotik"> <label for="">Create New</label></div>
                    <div class="col"> <input type="checkbox" name="sinkronisasi" id="sinkronisasi"> <label for="">Ganti Sinkronisasi</label></div>
                </div>
            </div>
            <input type="hidden" name="changeconn" id="changeconn">
            <input type="hidden" name="createnew" id="createnew">
            <input type="hidden" name="sinkron" id="sinkron">
            <div class="form-group">
                <div id="modeuser" style="display: none">
                    <label for="mode_user">Mode User</label>
                    <select name="mode_user" id="mode_user" class="form-control" onChange="selectmode(this);">
                        <option value="">-Pilih-</option>
                        <option value="Hotspot">Hotspot</option>
                        <option value="PPPOE">PPPOE</option>
                        <option value="Static">Static</option>
                        <option value="Standalone">Standalone</option>
                    </select>
                </div>
            </div>
            <div class="loading"></div>
            <div class="form-group">
                <div id="userprofile">
                    <label>User Profile</label>
                    <select name="profile" id="profile" class="form-control view_data select2" onChange="selectprofile();">
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div id="usersinkron">
                    <label>User <span id="users"></span></label>
                    <select name="user_sinkron" id="user_sinkron" class="form-control view_data_sinkron select2">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <div id="usermikrotik" style="display: none">
                    <label>User <span id="userm"></span></label>
                    <input type="text" autocomplete="off" id="user_mikrotik" name="user_mikrotik" class="form-control" value="<?= set_value('user_mikrotik') ?>">
                </div>
            </div>
            <div class="form-group">
                <div id="passwordmikrotik" style="display: none">
                    <label>Password</label>
                    <input type="password" name="passwordmikrotik" class="form-control">
                </div>
            </div>


            <div class="form-group row">
                <div class="col">
                    <div id="target" style="display: none">
                        <label>Target IP</label>
                        <input type="text" name="target" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div id="uploadlimit" style="display: none">
                        <label>Limit Upload</label>
                        <div class="input-group mb-3">
                            <input type="number" min="1" name="uploadlimit" class="form-control">
                            <div class="input-group-append">
                                <select name="upload" id="upload" class="form-control">
                                    <option value="K">Kb</option>
                                    <option value="M">Mb</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div id="downloadlimit" style="display: none">
                        <label>Limit Download</label>
                        <div class="input-group mb-3">
                            <input type="number" min="1" name="downloadlimit" class="form-control">
                            <div class="input-group-append">
                                <select name="download" id="download" class="form-control">
                                    <option value="K">Kb</option>
                                    <option value="M">Mb</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="auto_isolir">Auto Isolir</label>
                <select name="auto_isolir" id="autoisolir" class="form-control" required>
                    <option value="<?= $customer->auto_isolir ?>"><?= $customer->auto_isolir == 1 ? 'Yes' : 'No' ?></option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>

                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Jatuh Tempo</label> <span style="color: red;">Wajib diisi jika auto isolir yes</span>
                <input type="number" id="due_date" min="1" max="28" name="due_date" class="form-control" value="<?= $customer->due_date ?>">
                <?= form_error('due_date', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
    function selectrouter(sel) {
        // $("#router").val(sel);
        var router = $('[name="router"]');
        $("#sinkron").val('');
        $("#createnew").val('');
        $("#userprofile").hide();
        $("#usersinkron").hide();
        $('#profile').val('');
        $("#modeuser").hide();
        $("#usersinkron").hide();
        $("#mode_user").val('');
        $("#localaddress").hide();
        $("#remoteaddress").hide();
        $("#target").hide();
        $("#uploadlimit").hide();
        $("#downloadlimit").hide();
        $("#passwordmikrotik").hide();
        document.getElementById("createusermikrotik").checked = false;
        document.getElementById("sinkronisasi").checked = false;
    }

    function selectprofile() {
        $('#usermikrotik').focus();
    }

    function selectmode(sel) {
        var usermode = $('#mode_user').val();
        var router = $("#router").val();
        var createnew = $("#createnew").val();
        var sinkron = $("#sinkron").val();
        $("#userm").html(usermode);
        $("#users").html(usermode);
        if (usermode == 'Standalone' && createnew == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").show();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#usersinkron").hide();
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            var url = "<?= site_url('mikrotik/getUserMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data').html(data);
                    $("#profile").focus();
                }
            });
            return false;

        }
        if (usermode == 'Standalone' && sinkron == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").hide();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#usersinkron").show();
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            var url = "<?= site_url('mikrotik/getUserMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data_sinkron').html(data);
                    $("#user_sinkron").focus();
                }
            });
            return false;

        }
        if (usermode == 'PPPOE' && createnew == '1') {
            $("#userprofile").show();
            $("#usermikrotik").show();
            $("#passwordmikrotik").show();
            $("#localaddress").show();
            $("#remoteaddress").show();
            $("#usersinkron").hide();
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            var url = "<?= site_url('mikrotik/getUserProfileMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data').html(data);
                    $("#profile").focus();
                }
            });
            return false;

        }
        if (usermode == 'PPPOE' && sinkron == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").hide();
            $("#usersinkron").show();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            var url = "<?= site_url('mikrotik/getUserMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data_sinkron').html(data);
                    $("#user_sinkron").focus();
                }
            });
            return false;

        }

        if (usermode == 'Hotspot' && createnew == '1') {
            $("#userprofile").show();
            $("#usermikrotik").show();
            $("#passwordmikrotik").show();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#usersinkron").hide();
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            var url = "<?= site_url('mikrotik/getUserProfileMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data').html(data);
                    $("#profile").focus();
                }
            });
            return false;


        }
        if (usermode == 'Hotspot' && sinkron == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").hide();
            $("#usersinkron").show();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            var url = "<?= site_url('mikrotik/getUserMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data_sinkron').html(data);
                    $("#user_sinkkron").focus();
                }
            });
            return false;


        }
        if (usermode == 'Static' && createnew == '1') {
            $("#target").show();
            $("#usermikrotik").show();
            $("#usermikrotik").focus();
            $("#uploadlimit").show();
            $("#downloadlimit").show();
            $("#userprofile").hide();
            $("#usersinkron").hide();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
        }
        if (usermode == 'Static' && sinkron == '1') {
            $("#target").hide();
            $("#usermikrotik").hide();
            $("#usersinkron").show();
            $("#user_sinkron").focus();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            $("#userprofile").hide();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            var url = "<?= site_url('mikrotik/getUserMikrotik/') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&mode=" + usermode + "&router=" + router,
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
                    $('.view_data_sinkron').html(data);
                    $("#user_sinkkron").focus();
                }
            });
            return false;
        }
        // $("#userprofile").hide();
        // $("#localaddress").hide();
        // $("#remoteaddress").hide();
        // $("#target").hide();
        // $("#uploadlimit").hide();
        // $("#downloadlimit").hide();
        // $("#passwordmikrotik").hide();


    }

    function NoServices() {
        var no_services = $('[name="no_services"]');
        $("#usermikrotik").val(no_services.val());
    }

    $(function() {
        $("#createusermikrotik").click(function() {
            var router = $("#router").val();
            if (router == '') {
                Swal.fire({
                    icon: 'error',
                    html: '<?= $this->lang->line('pleaseselectrouter') ?>',
                    showConfirmButton: true,
                })
                $('#router').focus()
                document.getElementById("createusermikrotik").checked = false;
            } else {
                $("#modeuser").show();
                var modeuser = $("#mode_user").val();
                if ($(this).is(":checked")) {
                    $("#createnew").val('1');
                    $("#sinkron").val('');
                    $("#mode_user").val('');
                    $("#mode_user").focus();
                    $("#usermikrotik").hide();
                    $("#user_mikrotik").val('');
                    $("#userprofile").hide();
                    $("#usersinkron").hide();
                    $("#localaddress").hide();
                    $("#remoteaddress").hide();
                    $("#target").hide();
                    $("#uploadlimit").hide();
                    $("#downloadlimit").hide();
                    $("#passwordmikrotik").hide();
                    document.getElementById("sinkronisasi").checked = false;
                } else {
                    $("#createnew").val('');
                    $("#modeuser").hide();
                    $("#userprofile").hide();
                    $("#usermikrotik").hide();
                    $("#localaddress").hide();
                    $("#remoteaddress").hide();
                    $("#target").hide();
                    $("#usersinkron").hide();
                    $("#uploadlimit").hide();
                    $("#downloadlimit").hide();
                    $("#passwordmikrotik").hide();
                }
            }

        });
        $("#sinkronisasi").click(function() {
            var router = $("#router").val();
            if (router == '') {
                Swal.fire({
                    icon: 'error',
                    html: '<?= $this->lang->line('pleaseselectrouter') ?>',
                    showConfirmButton: true,
                })
                $('#router').focus()
                document.getElementById("sinkronisasi").checked = false;
            } else {
                $("#modeuser").show();
                var modeuser = $("#mode_user").val();
                if ($(this).is(":checked")) {
                    $("#sinkron").val('1');
                    $("#createnew").val('');
                    $("#usermikrotik").hide();
                    $("#mode_user").val('');
                    $("#mode_user").focus();
                    $("#userprofile").hide();
                    $("#user_mikrotik").val('');
                    $("#localaddress").hide();
                    $("#usersinkron").hide();
                    $("#remoteaddress").hide();
                    $("#target").hide();
                    $("#uploadlimit").hide();
                    $("#downloadlimit").hide();
                    $("#passwordmikrotik").hide();
                    document.getElementById("createusermikrotik").checked = false;
                } else {
                    $("#sinkron").val('');
                    $("#modeuser").hide();
                    $("#userprofile").hide();
                    $("#localaddress").hide();
                    $("#remoteaddress").hide();
                    $("#target").hide();
                    $("#uploadlimit").hide();
                    $("#usersinkron").hide();
                    $("#downloadlimit").hide();
                    $("#passwordmikrotik").hide();
                }
            }

        });
        $("#changeconnection").click(function() {
            $("#formrouter").show();
            $("#btn-mikro").show();
            var modeuser = $("#mode_user").val();
            if ($(this).is(":checked")) {
                $("#changeconn").val('1');
                $("#sinkron").val('');
                $("#createnew").val('');
                $("#usermikrotik").hide();

                $("#mode_user").val('');
                $("#mode_user").focus();
                $("#userprofile").hide();
                $("#user_mikrotik").val('');
                $("#localaddress").hide();
                $("#usersinkron").hide();
                $("#remoteaddress").hide();
                $("#target").hide();
                $("#uploadlimit").hide();
                $("#downloadlimit").hide();
                $("#passwordmikrotik").hide();
                document.getElementById("createusermikrotik").checked = false;
            } else {
                $("#changeconn").val('');
                $("#sinkron").val('');
                $("#createnew").val('');
                $("#modeuser").hide();
                $("#userprofile").hide();
                $("#localaddress").hide();
                $("#remoteaddress").hide();
                $("#target").hide();
                $("#uploadlimit").hide();
                $("#usersinkron").hide();
                $("#downloadlimit").hide();
                $("#passwordmikrotik").hide();
            }


        });
    });
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>