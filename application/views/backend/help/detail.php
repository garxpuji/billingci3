<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<style>
    #map-canvas {
        width: 100%;
        height: 400px;
        border: solid #999 1px;
    }

    select {
        width: 240px;
    }

    #kab_box,
    #kec_box,
    #kel_box,

    #lat_box,
    #lng_box {
        display: none;
    }

    #mapid {
        height: 500px;
    }

    #map {
        /* width: 600px; */
        height: 500px;
    }
</style>
<style>
    .tracking-detail {
        padding: 3rem 0
    }

    #tracking {
        margin-bottom: 1rem
    }

    [class*=tracking-status-] p {
        margin: 0;
        font-size: 1.1rem;
        color: #fff;
        text-transform: uppercase;
        text-align: center
    }

    [class*=tracking-status-] {
        padding: 1.6rem 0
    }

    .tracking-status-intransit {
        background-color: #65aee0
    }

    .tracking-status-outfordelivery {
        background-color: #f5a551
    }

    .tracking-status-deliveryoffice {
        background-color: #f7dc6f
    }

    .tracking-status-delivered {
        background-color: #4cbb87
    }

    .tracking-status-attemptfail {
        background-color: #b789c7
    }

    .tracking-status-error,
    .tracking-status-exception {
        background-color: #d26759
    }

    .tracking-status-expired {
        background-color: #616e7d
    }

    .tracking-status-pending {
        background-color: #ccc
    }

    .tracking-status-inforeceived {
        background-color: #214977
    }



    .tracking-item {
        border-left: 1px solid #e5e5e5;
        position: relative;
        padding: 2rem 1.5rem .5rem 2.5rem;
        font-size: .9rem;
        margin-left: 3rem;
        min-height: 5rem
    }

    .tracking-item:last-child {
        padding-bottom: 4rem
    }

    .tracking-item .tracking-date {
        margin-bottom: .5rem
    }

    .tracking-item .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: .4rem
    }

    .tracking-item .tracking-content {
        padding: .5rem .8rem;
        background-color: #f4f4f4;
        border-radius: .5rem
    }

    .tracking-item .tracking-content span {
        display: block;
        color: #888;
        font-size: 85%
    }

    .tracking-item .tracking-icon {
        line-height: 2.6rem;
        position: absolute;
        left: -1.3rem;
        width: 2.6rem;
        height: 2.6rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        background-color: #fff;
        color: #fff
    }

    .tracking-item .tracking-icon.status-sponsored {
        background-color: #f68
    }

    .tracking-item .tracking-icon.status-delivered {
        background-color: #4cbb87
    }

    .tracking-item .tracking-icon.status-outfordelivery {
        background-color: #f5a551
    }

    .tracking-item .tracking-icon.status-deliveryoffice {
        background-color: #f7dc6f
    }

    .tracking-item .tracking-icon.status-attemptfail {
        background-color: #b789c7
    }

    .tracking-item .tracking-icon.status-exception {
        background-color: #d26759
    }

    .tracking-item .tracking-icon.status-inforeceived {
        background-color: #214977
    }

    .tracking-item .tracking-icon.status-intransit {
        color: #e5e5e5;
        border: 1px solid #e5e5e5;
        font-size: .6rem
    }

    @media(min-width:992px) {
        .tracking-item {
            margin-left: 10rem
        }

        .tracking-item .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right
        }

        .tracking-item .tracking-date span {
            display: block
        }

        .tracking-item .tracking-content {
            padding: 0;
            background-color: transparent
        }
    }
</style>
<?php $this->view('messages') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Detail Tiket T-<?= $help['no_ticket']; ?></h6>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Pelanggan</label>
                    <?php $customer = $this->db->get_where('customer', ['no_services' => $help['no_services']])->row_array() ?>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $customer['name'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="no_services">No Layanan </label>
                    <input type="text" id="no_services" name="no_services" class="form-control" value="<?= $customer['no_services'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">No Telp. Pelanggan</label>
                    <input type="number" class="form-control" id="phone" name="phone" value="<?= $customer['no_wa']; ?>" placeholder="" readonly>

                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="4" readonly><?= $customer['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan Laporan</label>
                    <textarea class="form-control" id="description" name="description" rows="4" readonly><?= $help['description']; ?></textarea>
                </div>
                <?php if ($customer['latitude'] != '') { ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="mapid"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <?php if ($customer['latitude'] != '') { ?>
                    <a target="blank" href="http://www.google.com/maps/place/<?= $customer['latitude']; ?>,<?= $customer['longitude']; ?>" class="btn btn-outline-primary">Rute Google Maps</a>
                <?php } ?>
                <?php if ($help['status'] != 'close') { ?>
                    <a href="tel:<?= indo_tlp($customer['no_wa']) ?>" class="btn btn-outline-primary">Telp Pelanggan</a>
                    <a href="https://wa.me/<?= indo_tlp($customer['no_wa']) ?>" class="btn btn-outline-success">WA Pelanggan</a>

                <?php } ?>
                <?php if ($help['status'] == 'pending') { ?>
                    <a href="#" data-toggle="modal" data-target="#Modalgettiket" title="Ambil Tiket" class="btn btn-outline-danger">Ambil Tiket</a>
                <?php } ?>
                <?php if ($help['status'] == 'process') { ?>

                    <a href="#" data-toggle="modal" data-target="#Modalupdate" title="Proses Tiket" class="btn btn-outline-secondary">Update Tiket</a>

                <?php } ?>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-body">
                <h5>Timeline</h5>
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div id="tracking-pre"></div>
                        <div id="tracking">

                            <div class="tracking-list">
                                <div class="tracking-item">
                                    <div class="tracking-icon status-intransit">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                        </svg>
                                        <!-- <i class="fas fa-circle"></i> -->
                                    </div>
                                    <?php $createby = $this->db->get_where('user', ['id' => $help['create_by']])->row_array(); ?>
                                    <?php if ($createby['role_id'] == 1) {
                                        $level = 'Administrator';
                                    } elseif ($createby['role_id'] == 2) {
                                        $level = 'Pelanggan';
                                    } elseif ($createby['role_id'] == 3) {
                                        $level = 'Operator';
                                    } ?>
                                    <div class="tracking-date"> <?= date('d', $help['date_created']); ?> <?= indo_month(date('m', $help['date_created'])); ?> <?= date('Y', $help['date_created']); ?> <span><?= date('H:i:s', $help['date_created']); ?></span></div>
                                    <div class="tracking-content">Tiket dibuat oleh <?= $createby['name']; ?> (<?= $level; ?>)<span> </span></div>
                                    <img src="<?= base_url('assets/images/help/' . $help['picture']) ?>" alt="" style="width: 250px;">
                                </div>
                            </div>

                            <?php
                            $id = $help['id'];
                            $query = "SELECT *
                             FROM `help_timeline`
                                 WHERE `help_timeline`.`help_id` = $id order by date_update asc";
                            $timeline = $this->db->query($query)->result(); ?>

                            <?php
                            foreach ($timeline as $r => $data) { ?>
                                <div class="tracking-list">
                                    <div class="tracking-item">
                                        <div class="tracking-icon status-intransit">
                                            <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                            </svg>
                                            <!-- <i class="fas fa-circle"></i> -->
                                        </div>
                                        <?php $users = $this->db->get_where('user', ['id' => $data->teknisi])->row_array() ?>
                                        <?php if ($users['role_id'] == 1) {
                                            $roleid = "Administrator";
                                        } elseif ($users['role_id'] == 2) {
                                            $roleid = "Pelanggan";
                                        } elseif ($users['role_id'] == 3) {
                                            $roleid = "Operator";
                                        } elseif ($users['role_id'] == 5) {
                                            $roleid = "Teknisi";
                                        } ?>
                                        <div class="tracking-date"> <?= date('d', $data->date_update); ?> <?= indo_month(date('m', $data->date_update)); ?> <?= date('Y', $data->date_update); ?> <span><?= date('H:i:s', $data->date_update); ?></span></div>
                                        <div class="tracking-content">Update by <?= $users['name']; ?> (<?= $roleid; ?>) - <?= $users['phone']; ?><span><?= $data->remark; ?></span></div>
                                        <!-- <img src="<?= base_url('assets/images/help/' . $help['picture']) ?>" alt=""> -->
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="Modalgettiket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ambil Tiket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('help/gettiket') ?>

                <div class="form-group">

                    <input type="hidden" name="id" class="form-control" value="<?= $help['id'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Update terkait tiket, contoh : Perikiraan diperbaiki tgl sekian jam sekian"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <option value="process">Proses</option>
                        <option value="close">Close</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Modalupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Tiket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('help/updatetiket') ?>

                <div class="form-group">
                    <input type="hidden" name="id" class="form-control" value="<?= $help['id'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="keterangan terkait tiket, kabel fo putus atau modem rusak atau yg lainnya"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-Pilih-</option>
                        <option value="process">Proses</option>
                        <option value="close">Close</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
    var company = "<?= $customer['name'] ?>";
    var lat = "<?= $customer['latitude'] ?>";
    var long = "<?= $customer['longitude'] ?>";
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

            L.circle(e.latlng, {
                radius: '2500',
                color: 'navy',
                fillColor: 'black',
                fillOpacity: '0.1',
            }).addTo(mymap);
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