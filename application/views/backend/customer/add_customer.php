<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Tambah Pelanggan</h6>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart('customer/add') ?>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="coverage">Coverage Area</label>
                            <select name="coverage" id="coverage" class="form-control" onchange="selectcoverage(this);">
                                <option value="">-Pilih-</option>
                                <?php if ($customer->coverage != 0) { ?>
                                    <?php $datacoverage = $this->db->get_where('coverage', ['coverage_id' => $customer->coverage])->row_array(); ?>
                                    <option value="<?= $customer->coverage ?>"><?= $datacoverage['code_area'] ?> - <?= $datacoverage['c_name'] ?></option>
                                <?php } ?>
                                <?php foreach ($coverage as $data) { ?>
                                    <option value="<?= $data->coverage_id ?>"><?= $data->code_area ?> - <?= $data->c_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">

                        <div class="form-group">

                            <div class="form-group">

                                <label for="id_odc">ODC</label>

                                <select name="id_odc" id="id_odc" class="form-control select2" style="width: 100%;" onchange="selectodc(this);">

                                    <option value="">-Pilih-</option>

                                </select>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-sm-6 mb-3 mb-sm-0">

                        <div class="form-group">

                            <label for="id_odp">ODP</label>

                            <select name="id_odp" id="id_odp" class="form-control select2" style="width: 100%;" onchange="selectodp(this);">

                                <option value="">-Pilih-</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-sm-6">


                        <div class="form-group">

                            <label for="no_port_odp">No Port ODP</label>

                            <select name="no_port_odp" id="port_odp" class="form-control" style="width: 100%;">

                                <option value="">-Pilih-</option>

                            </select>

                        </div>
                    </div>

                </div>
                <div class="form-group row">

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="no_services">No Layanan</label>
                            <div class="input-group mb-3">
                                <input type="text" id="no_services" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" name="no_services" class="form-control" value="<?= set_value('no_services') ?>" onchange="NoServices()">
                                <div class="input-group-append">
                                    <span id="generatenoservices" class="input-group-text">Generate</span>
                                </div>
                            </div>
                            <?= form_error('no_services', '<small class="text-danger pl-3 ">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="name">Nama Pelanggan</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name') ?>">
                            <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                        </div>
                    </div>
                </div>


                <?php if ($package['coverage_package'] == 1) { ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col"><label for="paket">Paket Langganan</label></div>
                            <div class="col"> <input type="checkbox" name="getallpackage" id="getallpackage"> <label for="">Tampil Semua Paket</label></div>
                        </div>
                        <select name="paket" id="datapackage" class="form-control datapackage" required onChange="selectpackage(this);">
                        </select>
                    </div>
                <?php } ?>
                <?php if ($package['coverage_package'] == 0) { ?>
                    <div class="form-group">
                        <label for="paket">Paket Langganan</label>
                        <?php $item = $this->db->get_where('package_item', ['is_active' => 1])->result() ?>
                        <select name="paket" id="paket" class="form-control" required>
                            <option value="">-Pilih-</option>
                            <?php foreach ($item as $item) { ?>
                                <option value="<?= $item->p_item_id ?>"><?= $item->name ?> - Rp. <?= indo_currency($item->price); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="register_date">Tanggal Daftar</label>
                    <input type="text" id="datepicker" name="register_date" autocomplete="off" class="form-control" value="<?= set_value('register_date') ?>">
                    <?= form_error('register_date', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>
                <div class="form-group row">

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="email">Email</label> *
                            <input type="text" id="email" name="email" class="form-control" value="<?= set_value('email') ?>">
                            <?= form_error('email', '<small class="text-danger pl-3 ">', '</small>') ?>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="password">Password</label> <span>default : 1234</span>
                        <input type="password" class="form-control form-control-user" id="Password1" name="password1" placeholder="Password" value="1234">
                        <?= form_error('password1', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>

                </div>
                <?php $wa = $this->db->get('whatsapp')->row_array() ?>
                <?php if ($wa['is_active'] == 1) { ?>
                    <input type="checkbox" name="sendwa" id="sendwa"> <label for="">Kirim Data Email & Password ke WA Pelanggan</label>
                <?php } ?>

                <div class="form-group">
                    <label id="statuswa" style="display: none">Status Whatsapp Gateway : </label>
                    <div class="connectionwa"></div>
                </div>
                <div class="loadingwa"></div>

                <input type="hidden" name="sendwapelanggan" id="sendwapelanggan">
                <input type="hidden" name="vendor" id="vendor" value="<?= $wa['vendor'] ?>">
                <label for="no_ktp">ID Card</label>
                <div class="form-group row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <select name="type_id" id="type_id" class="form-control" required>
                            <option value="">-Pilih-</option>
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="NPWP">NPWP</option>
                            <option value="Pasport">Pasport</option>
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" id="no_ktp" name="no_ktp" class="form-control" value="<?= set_value('no_ktp') ?>">
                        <?= form_error('no_ktp', '<small class="text-danger pl-3 ">', '</small>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_wa">No Telp.</label> awali angka 0
                    <input type="number" id="no_wa" name="no_wa" class="form-control" value="<?= set_value('no_wa') ?>">
                    <?= form_error('no_wa', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="status">Status Berlangganan</label>
                            <select name="status" id="" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Free">Free</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ppn">Status PPN</label>
                            <select class="form-control" id="ppn" name="ppn" required>
                                <option value="">-Pilih-</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <textarea name="cust_description" class="form-control" id="" placeholder="info yg berkaitan dengan pelanggan"></textarea>
                </div>
                <div class="row">
                    <div class="col"> <input type="checkbox" name="createbill" id="createbill"> <label for="">Buat Tagihan </label></div>
                </div>
                <div id="formcreatebill" style="display: none">
                    Periode
                    <div class="row">
                        <div class="col"> <input type="checkbox" name="thismonth" id="thismonth"> <label for="">Bulan Ini</label></div>
                        <div class="col"> <input type="checkbox" name="nextmonth" id="nextmonth"> <label for="">Bulan Depan</label></div>
                    </div>
                    <div class="row">
                        <div class="col"> <input type="checkbox" name="fullbill" id="fullbill"> <label for="">Full</label></div>
                        <div class="col"> <input type="checkbox" name="proratabill" id="proratabill"> <label for="">Prorata</label></div>
                    </div>
                </div>
                <div class="" id="remarkfullbill" style="display: none">
                    <li> Fitur ini akan membuat tagihan penuh dari paket pelanggan yang dipilih</li>
                </div>
                <div class="form-group row" id="dateprorata" style="display: none">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="">Total Hari Pemakaian</label>
                            <input type="number" name="countdate" class="form-control" min="1" max="31">
                        </div>
                    </div>

                </div>
                <div class="" id="remarkproratabill" style="display: none">
                    <li> Fitur ini akan membuat tagihan prorata (sesuai hari dipakai) dari paket pelanggan yang dipilih, Harga paket dibagi 30 hari</li>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="form-group row mt-2">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="type_payment">Jenis Pembayaran</label>
                            <select name="type_payment" id="type_payment" class="form-control" required onChange="selectisolir(this);">
                                <option value="0">Pasca Bayar</option>
                                <option value="1">Prabayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="due_date">Jatuh Tempo</label> * 1 - 28
                            <input type="number" id="due_date" name="due_date" autocomplete="off" class="form-control" min="0" max="28" value="<?= set_value('due_date') ?>" required>
                        </div>

                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="form-group">
                            <label for="month_due_date">Bulan Jatuh Tempo</label>
                            <select name="month_due_date" id="month_due_date" class="form-control" required>
                                <option value="0">Sesuai Periode Tagihan</option>
                                <option value="1">1 bulan dari periode</option>
                            </select>
                        </div>

                    </div>

                </div>
                <?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
                <?php if ($rt['is_active'] == 1) { ?>
                    <?php $listrouter = $this->db->get('router')->result() ?>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="auto_isolir">Auto Isolir</label>
                                <select name="auto_isolir" id="autoisolir" class="form-control" required onChange="selectisolir(this);">
                                    <option value="">-Pilih-</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0" id="maxdueisolir" style="display: none">
                            <div class="form-group">
                                <label for="max_due_isolir">Max Isolir</label> <span> tambah hari dari jatuh tempo</span>
                                <input type="number" name="max_due_isolir" min="0" value="0" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div id="selectactionisolir" class="form-group" style="display: none">
                        <div class="row">
                            <div class="col"> <input type="checkbox" name="disableuser" id="disableuser"> <label for="">Disable User</label></div>
                            <div class="col"> <input type="checkbox" name="changeprofile" id="changeprofile"> <label for="">Ganti Profile</label></div>
                        </div>
                    </div>
                    <div class="row container" id="remarkchangeprofile" style="display: none">
                        <li> Action Ganti Profile ini khusus untuk mode PPPOE & Hotspot dan yang sudah menerapkan halaman isolir dengan webproxy </li>
                        <li>Jika anda menggunakan PPPOE dengan IP Static, silahkan pilih Type IP menjadi Static setelah pilih mode user dibawah ini menjadi PPPOE</li>
                        <li> Pastikan nama profile PPPOE / Hotspot nya <span style="color: red; font-weight:bold"> EXPIRED</span> </li>
                        <li> Untuk Mode Static & PPPOE Static, IP Target nya otomatis masuk ke address-list IP -> Firewall -> Address List </li>
                        <li> Untuk Mode Standalone akan otomatis disable Interface router pelanggan</li>
                        <br>
                    </div>
                    <div class="row container" id="remarkdisableuser" style="display: none">
                        <li> Disable user hanya untuk mode PPPOE & Hotspot </li>
                        <li> Untuk Mode Static, IP Target nya otomatis di <span style="color:red">DROP </span> ke IP -> Firewall -> Filter Rules </li>
                        <li> Untuk Mode Standalone akan otomatis disable Interface router pelanggan</li>
                        <br>
                    </div>
                    <input type="hidden" name="action" id="actionisolir" placeholder="Action Isolir" class="form-control">

                    <div class="form-group">
                        <label for="router">Router</label>
                        <select name="router" id="router" class="form-control" onChange="selectrouter(this);">
                            <option value="">-Pilih-</option>
                            <?php foreach ($listrouter as $router) { ?>
                                <option value="<?= $router->id ?>"><?= $router->alias; ?> - <?= $router->ip_address; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Status Router">Router Status : </label>
                        <div class="connection"></div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col"> <input type="checkbox" name="createusermikrotik" id="createusermikrotik"> <label for="">Create New</label></div>
                            <div class="col"> <input type="checkbox" name="sinkronisasi" id="sinkronisasi"> <label for="">Sinkronisasi</label></div>
                        </div>
                    </div>
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
                    <div class="form-group">
                        <div id="type_ip" style="display: none">
                            <label for="type_ip">Type IP</label>
                            <select name="type_ip" id="typeip" class="form-control" onChange="selecttypeip(this);">
                                <option value="0">DHCP</option>
                                <option value="1">Static</option> <span style="font-size: small;">From remote address</span>
                            </select>
                        </div>
                    </div>
                    <div class="loading"></div>
                    <div class="form-group">
                        <div id="userprofile" style="display: none">
                            <label>User Profile</label>
                            <select name="profile" id="profile" style="width: 100%;" class="form-control view_data select2" onChange="selectprofile();">

                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <div id="usersinkron" style="display: none">
                            <label>User <span id="users"></span></label>
                            <select name="user_sinkron" id="user_sinkron" style="width: 100%;" class="form-control view_data_sinkron select2" onChange="selectuser(this);">
                            </select>
                        </div>
                        <div id="formprofile" style="display: none">
                            <div class="form-group">
                                <label>User Profile</label>
                                <input type="text" name="userprofilesinkron" readonly id="userprofilesinkron" value="" placeholder="User Profile Untuk Open Isolir" class="form-control">
                            </div>
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
                            <div id="localaddress" style="display: none">
                                <label>Local Address</label>
                                <input type="text" name="localaddress" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div id="remoteaddress" style="display: none">
                                <label>Remote Address</label>
                                <input type="text" name="remoteaddress" class="form-control">
                            </div>
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
                        <div id="parent" style="display: none">
                            <label>Parent</label>
                            <select name="parent" id="parent" style="width: 100%;" class="form-control view_data_parent select2">
                            </select>
                        </div>
                    </div>

                <?php } ?>
                <?php if ($rt['is_active'] != 1) { ?>
                    <input type="hidden" name="auto_isolir" value="0">
                    <input type="hidden" name="max_due_isolir" value="0">
                    <input type="hidden" name="action" value="0">

                <?php } ?>

                <div class="form-group">
                    <label for="codeunique">Code Unique</label> <span style="font-size: smaller;">Hanya recehan </span>
                    <select name="codeunique" id="autoisolir" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <option value="1">Active</option>
                        <option value="0">Non-Active</option>
                    </select>
                </div>


                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">

                        <div class="form-group">
                            <label for="lat">Latitude</label>
                            <input type="text" id="lat" name="lat" class="form-control" value="">
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="long">Longitude</label>
                            <input type="text" id="long" name="long" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="mapid"></div>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
    $("#createbill").click(function() {
        if ($(this).is(":checked")) {
            $("#formcreatebill").show();
            document.getElementById("fullbill").checked = false;
            document.getElementById("proratabill").checked = false;
            $("#dateprorata").hide();
        } else {
            $("#formcreatebill").hide();
            $("#dateprorata").hide();
            document.getElementById("fullbill").checked = false;
            document.getElementById("proratabill").checked = false;
        }
    });
    $("#fullbill").click(function() {
        if ($(this).is(":checked")) {
            $("#remarkfullbill").show();
            $("#remarkproratabill").hide();
            $("#dateprorata").hide();
            document.getElementById("proratabill").checked = false;
        } else {

            $("#remarkfullbill").hide();
            $("#remarkproratabill").hide();
        }
    });
    $("#proratabill").click(function() {
        if ($(this).is(":checked")) {
            $("#remarkfullbill").hide();
            $("#dateprorata").show();
            $("#remarkproratabill").show();
            document.getElementById("fullbill").checked = false;
        } else {

            $("#remarkfullbill").hide();
            $("#remarkproratabill").hide();
        }
    });
    $("#nextmonth").click(function() {
        if ($(this).is(":checked")) {
            document.getElementById("thismonth").checked = false;
        } else {
            document.getElementById("nextmonth").checked = false;

        }
    });
    $("#thismonth").click(function() {
        if ($(this).is(":checked")) {
            document.getElementById("nextmonth").checked = false;
        } else {
            document.getElementById("thismonth").checked = false;

        }
    });

    $("#changeprofile").click(function() {
        if ($(this).is(":checked")) {
            $("#actionisolir").val('1');
            $("#remarkchangeprofile").show();
            document.getElementById("disableuser").checked = false;
        } else {
            $("#actionisolir").val('0');
            $("#remarkchangeprofile").hide();
            $("#remarkdisableuser").hide();
        }
    });
    $("#disableuser").click(function() {
        if ($(this).is(":checked")) {
            $("#remarkchangeprofile").hide();
            $("#remarkdisableuser").show();
            $("#actionisolir").val('0');
            document.getElementById("changeprofile").checked = false;
        } else {
            $("#remarkdisableuser").hide();
            $("#remarkchangeprofile").hide();
        }
    });

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
    $(function() {
        $("#generatenoservices").click(function() {
            var m = new Date();
            var th = m.getFullYear().toString().substr(-2);
            var dateString =
                th +
                ("0" + (m.getMonth() + 1)).slice(-2) +
                ("0" + m.getDate()).slice(-2) +
                ("0" + m.getHours()).slice(-2) +
                ("0" + m.getMinutes()).slice(-2) +
                ("0" + m.getSeconds()).slice(-2);

            console.log(dateString);
            $("#no_services").val(dateString);
            $("#user_mikrotik").val(dateString);
        });
    });
</script>
<script>
    function selectuser(sel) {
        var user = $('#user_sinkron').val();
        var usermode = $('#mode_user').val();
        var router = $("#router").val();
        $('#formprofile').hide();
        if (usermode == 'PPPOE' || usermode == 'PPPOE') {
            var url = "<?= site_url('mikrotik/getuserprofile') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&user=" + user + "&router=" + router + "&mode=" + usermode,
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
                    var c = jQuery.parseJSON(data);
                    $('.loading').html('');
                    if (c['profile'] != '') {
                        $('#formprofile').show();
                        $('#userprofilesinkron').show();
                        $('#userprofilesinkron').val(c['profile']);
                    }
                }
            });
            return false;
        }
    }

    function selectrouter(sel) {

        var router = $("#router").val();
        $("#sinkron").val('');
        $("#createnew").val('');
        $("#userprofile").hide();
        $("#userprofilesinkron").hide();
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
        var url = "<?= site_url('router/cekconnection') ?>" + "/" + Math.random();
        $.ajax({
            type: 'POST',
            url: url,
            data: "&router=" + router,
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


    }

    function selectisolir(sel) {
        var action = $('#autoisolir').val();
        var type = $('#type_payment').val();
        if (action == 1) {
            $("#selectactionisolir").show();
            $("#maxdueisolir").show();
        } else {
            $("#selectactionisolir").hide();
            $("#actionisolir").val('0');
            $("#maxdueisolir").hide();
        }
    }


    function selectactionisolir(sel) {
        var action = $('#autoisolir').val();
        if (action == 1) {
            $("#actionisolir").val('1');
        } else {
            $("#actionisolir").val('0');

        }
    }

    function selectprofile() {
        $('#usermikrotik').focus();
    }

    function selecttypeip(sel) {
        var typeip = $('#typeip').val();
        var createnew = $("#createnew").val();
        if (typeip == 1 && createnew == '1') {
            $("#target").show();
            $("#uploadlimit").show();
            $("#downloadlimit").show();
        } else {
            $("#target").hide();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
        }
    }

    function selectmode(sel) {
        var usermode = $('#mode_user').val();
        var router = $("#router").val();
        var createnew = $("#createnew").val();
        var sinkron = $("#sinkron").val();
        $('#formprofile').hide();
        $("#userm").html(usermode);
        $("#users").html(usermode);
        if (usermode == 'PPPOE' && createnew == '1') {

            $("#userprofile").show();
            $("#type_ip").show();
            $("#usermikrotik").show();
            $("#user_mikrotik").focus();
            $("#user_mikrotik").val($('#no_services').val());
            $("#passwordmikrotik").show();
            $("#localaddress").show();
            $("#remoteaddress").show();
            $("#usersinkron").hide();
            $("#target").hide();
            $("#parent").hide();
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
            $("#type_ip").show();
            $("#usersinkron").show();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#parent").hide();
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
                    $('#userprofilesinkron').val('');
                }
            });
            return false;

        }
        if (usermode == 'Standalone' && createnew == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").show();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#parent").hide();
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
                    $('#userprofilesinkron').val('');
                    $("#profile").focus();
                }
            });
            return false;

        }
        if (usermode == 'Standalone' && sinkron == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").hide();
            $("#type_ip").hide();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#parent").hide();
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
                    $('#userprofilesinkron').val('');
                    $("#user_sinkron").focus();
                }
            });
            return false;

        }
        if (usermode == 'Hotspot' && createnew == '1') {
            $("#userprofile").show();
            $("#usermikrotik").show();
            $("#user_mikrotik").focus();
            $("#user_mikrotik").val($('#no_services').val());
            $("#passwordmikrotik").show();
            $("#localaddress").hide();
            $("#parent").hide();
            $("#remoteaddress").hide();
            $("#usersinkron").hide();
            $("#target").hide();
            $("#type_ip").hide();
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
                    $('#userprofilesinkron').val('');
                    $("#profile").focus();
                }
            });
            return false;


        }
        if (usermode == 'Hotspot' && sinkron == '1') {
            $("#userprofile").hide();
            $("#usermikrotik").hide();
            $("#type_ip").hide();
            $("#usersinkron").show();
            $("#passwordmikrotik").hide();
            $("#localaddress").hide();
            $("#remoteaddress").hide();
            $("#target").hide();
            $("#parent").hide();
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
                    $('#userprofilesinkron').val('');
                    $("#user_sinkkron").focus();
                }
            });
            return false;


        }
        if (usermode == 'Static' && createnew == '1') {
            $("#target").show();
            $("#usermikrotik").show();
            $("#user_mikrotik").focus();
            $("#user_mikrotik").val($('#no_services').val());
            $("#uploadlimit").show();
            $("#downloadlimit").show();
            $("#userprofile").hide();
            $("#type_ip").hide();
            $("#usersinkron").hide();
            $("#parent").show();
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
                    $('.view_data_parent').html(data);
                    $('#userprofilesinkron').val('');
                    $("#user_mikrotik").focus();
                }
            });
            return false;
        }
        if (usermode == 'Static' && sinkron == '1') {
            $("#target").hide();
            $("#usermikrotik").hide();
            $("#usersinkron").show();
            $("#user_sinkron").focus();
            $("#uploadlimit").hide();
            $("#downloadlimit").hide();
            $("#parent").hide();
            $("#userprofile").hide();
            $("#passwordmikrotik").hide();
            $("#type_ip").hide();
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
                    $('#userprofilesinkron').val('');
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

    function selectcoverage() {
        var coverage = $("#coverage").val();
        var url = "<?= site_url('coverage/getcode') ?>" + "/" + Math.random();
        $.ajax({
            type: 'POST',
            url: url,
            data: "&coverage_id=" + coverage,
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
                $("#no_services").val(data);
                $("#no_services").focus();
                // document.getElementById("getallpackage").checked = false;
                var url = "<?= site_url('coverage/getpackagebycoverage') ?>" + "/" + Math.random();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: "&coverage=" + coverage,
                    cache: false,

                    success: function(data) {
                        $('#datapackage').html(data);
                    }
                });

                var urlodc = "<?= site_url('odc/getodc') ?>" + "/" + Math.random();

                $.ajax({

                    type: 'POST',

                    url: urlodc,

                    data: "&coverage_id=" + coverage,

                    cache: false,

                    success: function(data) {

                        $("#id_odc").html(data);

                    }

                });
            }
        });
        return false;

    }

    function selectodc() {

        var id_odc = $("#id_odc").val();

        var url = "<?= site_url('odp/getodp') ?>" + "/" + Math.random();

        $.ajax({

            type: 'POST',

            url: url,

            data: "&id_odc=" + id_odc,

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

                $("#id_odp").html(data);

                $("#id_odp").focus();

            }

        });

        return false;



    }



    function selectodp() {

        var id_odp = $("#id_odp").val();

        // alert(id_odp);

        var url = "<?= site_url('odp/getportodp') ?>" + "/" + Math.random();

        $.ajax({

            type: 'POST',

            url: url,

            data: "&id_odp=" + id_odp,

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

                $("#port_odp").html(data);



            }

        });

        return false;



    }


    $(function() {
        $("#createusermikrotik").click(function() {
            var router = $("#router").val();
            if (router == '') {
                Swal.fire({
                    icon: 'error',
                    html: 'Router belum dipilih',
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
                    html: 'Router belum dipilih',
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
    });
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>
<script>
    $("#createuserlogin").click(function() {
        if ($(this).is(":checked")) {
            $("#createuser").val('1');
            $("#formpassword").show();
            $("#formsendwa").show();
            $("#sendwapelanggan").val('0');
        } else {
            $("#createuser").val('0');
            $("#sendwapelanggan").val('0');
            $("#formpassword").hide();
            $("#formsendwa").hide();
        }
    });
    $("#getallpackage").click(function() {
        if ($(this).is(":checked")) {
            var url = "<?= site_url('coverage/getallpackage') ?>" + "/" + Math.random();
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
                    $('#datapackage').html(data);
                }
            });
        } else {
            var coverage = $("#coverage").val();
            var url = "<?= site_url('coverage/getpackagebycoverage') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&coverage=" + coverage,
                cache: false,

                success: function(data) {
                    $('#datapackage').html(data);
                }
            });
        }
    });
</script>
<script>
    var company = "<?= $company['company_name'] ?>";
    var lat = "-3.469557";
    var long = "117.026367";



    var latlngs = [
        // [
        //     [45.51, -122.68],
        //     [37.77, -122.43],
        //     [34.04, -118.2],
        //     [22.75, -109.7],
        //     [18.47, -104.99],
        //     [36.03, -88.67],
        //     [45.51, -122.68],
        // ],
        // [
        //     [40.78, -73.91],
        //     [41.83, -87.62],
        //     [32.76, -96.72]
        // ]
    ];


    var cities = L.layerGroup();


    var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
    var mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?= maps()['token'] ?>';

    var streets = L.tileLayer(mbUrl, {
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        // attribution: mbAttr
    });

    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    var mymap = L.map('mapid', {
        center: [lat, long],
        zoom: 5,

        layers: [osm, cities],
        fullscreenControl: true,
        // OR
        fullscreenControl: {
            pseudoFullscreen: false // if true, fullscreen to page width and height
        }
    });

    var baseLayers = {
        'OpenStreetMap': osm,
        'Streets': streets
    };
    var overlays = {
        // 'Cities': cities,
        // 'Cities': cities
    };

    var layerControl = L.control.layers(baseLayers, overlays).addTo(mymap);

    var satellite = L.tileLayer(mbUrl, {
        id: 'mapbox/satellite-v9',
        tileSize: 512,
        zoomOffset: -1,
        // attribution: mbAttr
    });
    layerControl.addBaseLayer(satellite, 'Satellite');

    function onLocationFound(e) {

        var url = "<?= base_url('') ?>coverage/getcoverage/";
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",

            success: function(data) {
                data.forEach(function(data, index) {
                    var yourlocation = [data['latitude'], data['longitude']];
                    /* Menghitung jarak antar 2 koordinat dengan satuan km
                        Untuk satuan meter tidak perlu dibagi 1000 */
                    var distance = (L.latLng(e.latlng).distanceTo(yourlocation) / 1000).toFixed(2);

                    var radius = (e.accuracy / 2).toFixed(1);

                    // Membuat marker sesuai koordinat lokasi
                    // locationMarker = L.marker(e.latlng);
                    locationMarker.addTo(mymap);
                    locationMarker.bindPopup("<p class='text-center'>Your location");
                    locationMarker.openPopup();

                    // Membuat garis antara koordinat lokasi dengan puncak merapi
                    var latlongline = [e.latlng, yourlocation];
                    var polyline = L.polyline(latlongline, {
                        color: 'blue',
                        weight: 5,
                        opacity: 0.7,
                    });
                    latt = e.latlng.lat;
                    lonn = e.latlng.lng;
                    // polyline.addTo(mymap);
                    var markernow = L.marker([data['latitude'], data['longitude']]).addTo(mymap)
                        .bindPopup('<h5 class="mb-0 mt-0 pb-0" style="text-align:center;">Area : ' + data['c_name'] + ' </h5><hr class=" mb-2 mt-2" color="blue" style="height:3px;box-shadow:2px 2px 2px black;" />' +
                            '<span class="text-center  mb-0 mt-2"> Berjarak ' + distance + ' Km dari lokasi anda</span>' +
                            '<p class="mt-1"> Alamat : ' + data['address'] + '<br> <a href="https://www.google.com/maps/dir/' + latt + ',' + lonn + '/' + data['latitude'] + ',' + data['longitude'] + '/" target="blank">Directions </a> ');
                    var popup = L.popup();
                    var radius = data['radius'];
                    L.circle([data['latitude'], data['longitude']], {
                        radius: radius,
                        color: 'blue',
                        fillColor: 'green',
                        fillOpacity: '0.1',
                    }).addTo(mymap);
                });

            },
            error: function(data) {
                // do something
            }
        });
        const locationMarker = L.marker(e.latlng).addTo(mymap)
            .bindPopup(`Your location`).openPopup();

        const locationCircle = L.circle(e.latlng).addTo(mymap);
    }

    var polyline = L.polyline(latlngs, {
        color: 'red'
    }).addTo(mymap);




    function onLocationError(e) {
        // alert(e.message);
    }

    mymap.on('locationfound', onLocationFound);
    // mymap.on('locationerror', onLocationError);
    L.control.locate({
        position: 'topleft',
        showCompass: true,
        showPopup: false,
    }).addTo(mymap);

    mymap.locate({
        setView: true,
        maxZoom: 16
    });

    function onMapClick(e) {

        latt = e.latlng.lat;
        lonn = e.latlng.lng;
        //Clear existing marker, a

        if (theMarker != undefined) {
            mymap.removeLayer(theMarker);
            // mymap.removeLayer(locationMarker);
        };

        //Add a marker to show where you clicked.
        theMarker = L.marker([latt, lonn]).addTo(mymap);

        $("#long").val(e.latlng.lng);
        $("#lat").val(e.latlng.lat);
    }
    var theMarker = {};
    mymap.on('click', onMapClick);
</script>