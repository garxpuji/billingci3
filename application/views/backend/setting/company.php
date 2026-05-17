<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Data Perusahaan</h6>
            <div class="text-right">
                Expired : <?= indo_date($company['expired']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('setting/editCompany') ?>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $company['id'] ?>">
                        <label for="apps_name">Nama Aplikasi</label>
                        <input type="text" id="apps_name" name="apps_name" class="form-control" value="<?= $company['apps_name'] ?>" required>
                    </div>
                    <div class="form-group">

                        <label for="name">Nama Perusahaan</label>
                        <input type="text" id="company_name" name="company_name" class="form-control" value="<?= $company['company_name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sub">Slogan / Moto</label>
                        <input type="text" id="sub" name="sub_name" class="form-control" value="<?= $company['sub_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?= $company['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="country">Timezone</label>
                        <?php $gettime = $this->db->get_where('timezone', ['tz' => $company['timezone']])->row_array() ?>

                        <select name="timezone" id="timezone" class="form-control select2" required>
                            <?php if ($company['timezone'] != '') { ?>
                                <option value="<?= $company['timezone'] ?>"><?= $company['timezone'] ?></option>
                                <option value="Asia/Bangkok">(GMT +7) Bangkok, Hanoi, Jakarta (WIB)</option>
                                <option value="Asia/Hong_Kong">(GMT +8) Beijing, Singapore, Makasar (WITA)</option>
                                <option value="Asia/Tokyo">(GMT +9) Tokyo, Seoul, Papua (WIT)</option>

                            <?php } ?>
                            <?php if ($company['timezone'] == '') { ?>
                                <option value="Asia/Bangkok">(GMT +7) Bangkok, Hanoi, Jakarta (WIB)</option>
                                <option value="Asia/Hong_Kong">(GMT +8) Beijing, Singapore, Makasar (WITA)</option>
                                <option value="Asia/Tokyo">(GMT +9) Tokyo, Seoul, Papua (WIT)</option>

                            <?php } ?>
                        </select>
                    </div>
                    <label for="no_ktp">Phone</label>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <select name="phonecode" id="phonecode" class="form-control select2" required>
                                <?php if ($company['phonecode'] > 0) { ?>
                                    <option value="<?= $company['phonecode'] ?>"><?= $company['phonecode'] ?></option>
                                    <?php foreach ($country as $c) { ?>
                                        <option value="<?= $c->phonecode ?>"><?= $c->nicename; ?> +<?= $c->phonecode; ?></option>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($company['phonecode'] == 0) { ?>
                                    <option value="">-Select-</option>

                                    <?php foreach ($country as $c) { ?>
                                        <option value="<?= $c->phonecode ?>"><?= $c->nicename; ?> +<?= $c->phonecode; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="hp" name="hp" class="form-control" value="<?= $company['whatsapp'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fb">Facebook</label>
                        <input type="text" id="fb" name="fb" class="form-control" value="<?= $company['facebook'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="ig">Instagram</label>
                        <input type="text" id="ig" name="ig" class="form-control" value="<?= $company['instagram'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="speedtest">Speedtest</label>
                        <input type="text" id="speedtest" name="speedtest" class="form-control" value="<?= $company['speedtest'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tawk">Tawk</label>
                        <textarea id="tawk" name="tawk" class="form-control"><?= $company['tawk'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="form-group">
                        <label for="logo">Logo</label><br>
                        <img src="<?= base_url('assets/images/') ?><?= $company['logo'] ?>" style=" display: block;
  margin-left: auto;
  margin-right: auto;
  width: 100%;" alt=""> <br>
                        <input type="file" name="logo">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" class="form-control"><?= $company['address'] ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="ppn">Ppn (%)</label> <small>* Pelanggan yg aktif ppn</small>
                                <input type="number" name="ppn" id="ppn" class="form-control" min="0" max="100" value="<?= $company['ppn'] ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="admin_fee">Biaya Admin Invoice</label>
                                <input type="number" name="admin_fee" id="admin_fee" class="form-control" value="<?= $company['admin_fee'] ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="watermark">Watermark </label>
                                <select class="form-control" id="watermark" name="watermark">
                                    <option value="<?= $company['watermark'] ?>"><?= $company['watermark'] == 1 ? 'Aktif' : 'Non-Aktif' ?></option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="owner">Nama Pemilik</label>
                        <input type="text" id="owner" name="owner" class="form-control" value="<?= $company['owner'] ?>">
                    </div>



                    <div class="form-group">
                        <label for="lat">lat</label>
                        <input type="text" id="lat" name="lat" class="form-control" value="<?= $company['latitude'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="long">long</label>
                        <input type="text" id="long" name="long" class="form-control" value="<?= $company['longitude'] ?>">
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



<style>
    #mapid {
        height: 500px;
    }

    #map {
        /* width: 600px; */
        height: 500px;
    }
</style>
<div class="row">

    <div class="col-lg-12">
        <div id="mapid"></div>
    </div>

</div>


<script>
    var company = $("#company_name").val();
    var lat = $("#lat").val();
    var long = $("#long").val();
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
                .bindPopup("Lokasi Anda Saat Ini").openPopup();

            L.circle(e.latlng, radius).addTo(mymap);
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
            theMarker = L.marker([latt, lonn]).addTo(mymap);

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
            theMarker = L.marker([latt, lonn]).addTo(mymap)

            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(mymap);
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>