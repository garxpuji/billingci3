<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<style>
    #mapid {
        height: 250px;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?> | <?= $company['company_name'] ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <?php $role = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>

</head>

<body class="bg-gradient-primary">
    <div class="container">

        <?php if ($role['register_show'] != 1) {
            redirect('auth');
        } ?>
        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 mx-auto ">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <img class="mb-3" style=" display: block;margin-left: auto;margin-right: auto;width: 100%;" src="<?= base_url('assets/images/') ?><?= $company['logo'] ?>" alt="">
                                <h1 class="h4 text-gray-900 mb-4">Daftar <?= $company['company_name']; ?> </h1>
                            </div>
                            <?= $this->session->flashdata('message') ?>
                            <?php echo form_open_multipart('auth/register') ?>
                            <div class="form-group">
                                <input type="hidden" name="no_services" value="0">
                                <input type="hidden" class="form-control form-control-user" name="due_date" value="0">
                                <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama Lengkap" value="<?= set_value('name') ?>">
                                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="Email" name="email" placeholder="Alamat Email" value="<?= set_value('email') ?>">
                                <?= form_error('email', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="no_wa" name="no_wa" placeholder="No Whatsapp" value="<?= set_value('no_wa') ?>">
                                <?= form_error('no_wa', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>
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

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="Password1" name="password1" placeholder="Password">
                                    <?= form_error('password1', '<small class="text-danger pl-3 ">', '</small>') ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="Password2" name="password2" placeholder="Konfirmasi Password">
                                </div>
                            </div>
                            <?php if ($role['register_coverage'] == 1) { ?>
                                <div class="form-group">
                                    <label for="coverage">Coverage</label>
                                    <?php $coverage = $this->db->get_where('coverage', ['public' => 1])->result() ?>
                                    <select name="coverage" id="coverage" class="form-control" <?= $package['coverage_package'] == 1 ? ' onChange="selectcoverage(this);"' : ''; ?>>
                                        <option value="">-Pilih Coverage-</option>
                                        <?php foreach ($coverage as $coverage) { ?>
                                            <option value="<?= $coverage->coverage_id ?>"><?= $coverage->c_name ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($package['coverage_package'] == 1) { ?>
                                <div class="loading"></div>
                                <div class="form-group">
                                    <label for="paket">Paket Langganan</label>
                                    <?php $item = $this->db->get_where('package_item', ['public' => 1])->result() ?>
                                    <select name="paket" id="datapackage" class="form-control datapackage" required onChange="selectpackage(this);">

                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($package['coverage_package'] == 0) { ?>
                                <div class="form-group">
                                    <label for="paket">Paket Langganan</label>
                                    <?php $item = $this->db->get_where('package_item', ['public' => 1, 'is_active' => 1])->result() ?>
                                    <select name="paket" id="paket" class="form-control" required>
                                        <option value="">-Pilih Paket-</option>
                                        <?php foreach ($item as $item) { ?>
                                            <option value="<?= $item->p_item_id ?>"><?= $item->name ?> - Rp. <?= indo_currency($item->price); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>


                            <?php if ($role['register_coverage'] == 0) { ?>

                                <input type="hidden" name="coverage" value="0">
                            <?php } ?>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea id="address" autocomplete="off" name="address" class="form-control"> </textarea>
                            </div>




                            <?php if ($role['register_maps'] == 1) { ?>

                                <div class="form-group">
                                    <div id="mapid"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="lat">Latitude</label>
                                        <input type="text" id="lat" name="lat" class="form-control" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="long">Longitude</label>
                                        <input type="text" id="long" name="long" class="form-control" readonly>
                                    </div>

                                </div>
                            <?php } ?>
                            <?php if ($role['register_maps'] == 0) { ?>
                                <input type="hidden" id="long" name="long" value="" class="form-control" readonly>
                                <input type="hidden" id="lat" name="lat" value="" class="form-control" readonly>
                            <?php } ?>



                            <div class="row">
                                <div class="col-1">
                                    <input type="checkbox" required>
                                </div>
                                <div class="col-11">
                                    <label><span></span> Saya menyetujui <a href="<?= site_url('syarat-dan-ketentuan.html') ?>" style="text-decoration: none;">Syarat & Ketentuan</a> dan <a href="<?= site_url('kebijakan-privasi.html') ?>" style="text-decoration: none;">Kebijakan Privasi</a> yang berlaku</label>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Daftar
                            </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= site_url('auth/forgotpassword'); ?>">Lupa Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= site_url('auth') ?>">Sudah punya akun ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>
<script>
    function selectcoverage(sel) {
        var coverage = $('#coverage').val();
        if (coverage == '') {
            Swal.fire({
                icon: 'error',
                html: 'Area tidak boleh kosong',
                showConfirmButton: true,
            })

            $('#datapackage').html('');
        } else {
            var url = "<?= site_url('coverage/getpackagebycoverage') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&coverage=" + coverage,
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
            return false;
        }


    }
</script>

<script>
    var company = "";
    var lat = "";
    var long = "";
    if (lat == '') {
        var mymap = L.map('mapid').fitWorld();
    } else {
        var mymap = L.map('mapid').setView([lat, long], 16);
    }

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        //     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);


    if (lat == '') {
        function onLocationFound(e) {
            var radius = e.accuracy / 2;
            markernow = L.marker(e.latlng).addTo(mymap)
                .bindPopup("Lokasi Anda Saat Ini <br>Latitude : " + e.latlng.lat + " <br> Longitude : " + e.latlng.lng + "").openPopup();
            L.circle(e.latlng, radius).addTo(mymap);
            $("#long").val(e.latlng.lng);
            $("#lat").val(e.latlng.lat);
        }


        function onLocationError(e) {
            alert(e.message);
        }
        var theMarker = {};

        function onMapClick(e) {
            latt = e.latlng.lat;
            lonn = e.latlng.lng;
            //Clear existing marker, 

            if (theMarker != undefined) {
                mymap.removeLayer(theMarker);
                mymap.removeLayer(markernow);
            };

            //Add a marker to show where you clicked.
            theMarker = L.marker([latt, lonn]).addTo(mymap)
                .bindPopup("Latitude : " + latt + " <br> Longitude : " + lonn + "")
                .openPopup();;

            $("#long").val(e.latlng.lng);
            $("#lat").val(e.latlng.lat);
        }
        mymap.on('locationfound', onLocationFound);
        mymap.on('locationerror', onLocationError);

        mymap.locate({
            setView: true,
            maxZoom: 16
        });
    } else {
        var markernow = L.marker([lat, long]).addTo(mymap)
            .bindPopup(company).openPopup();
        var popup = L.popup();
        var theMarker = {};

        function onMapClick(e) {
            latt = e.latlng.lat;
            lonn = e.latlng.lng;
            //Clear existing marker, 

            if (theMarker != undefined) {
                mymap.removeLayer(theMarker);
                mymap.removeLayer(markernow);
            };

            //Add a marker to show where you clicked.
            theMarker = L.marker([latt, lonn]).addTo(mymap);
            // popup
            //     .setLatLng(e.latlng)
            //     .setContent("You clicked the map at " + e.latlng.toString())
            //     .openOn(mymap);
            $("#long").val(e.latlng.lng);
            $("#lat").val(e.latlng.lat);
        }
        // mymap.locate({
        //     setView: true,
        //     maxZoom: 16
        // });
    }

    mymap.on('click', onMapClick);
</script>