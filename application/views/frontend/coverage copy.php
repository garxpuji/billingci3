<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<!-- Leaflet Locate Control CSS Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.css" />
<!-- Leaflet CSS Library -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
<script src="<?= base_url('assets/backend/') ?>js/select2.full.min.js"></script>
<link href="<?= base_url('assets/backend/') ?>css/select2.min.css" rel="stylesheet">
<!-- Font-awesome CSS Library -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Leaflet Locate Control Library -->
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

<style>
    #mapid {
        height: 500px;
    }

    #map {
        /* width: 600px; */
        height: 500px;
    }
</style>
<style>
    #mapselect {
        height: 500px;
    }

    #map {
        /* width: 600px; */
        height: 500px;
    }
</style>
<?php $other = $this->db->get('other')->row_array() ?>
<?php $maps = $this->db->get_where('maps_indo', ['nid' => $other['view_maps']])->row_array() ?>
<input type="text" id="maps_lat" value="<?= $maps['latitude'] ?>">
<input type="text" id="maps_longitude" value="<?= $maps['longitude'] ?>">
<div class="container">
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Set View : </label>
                <select name="maps_selected" id="maps_selected" style="width: 50%;" class="select2 form-control" required onChange="selectmaps(this);">
                    <?php foreach ($maps_indo as $key => $data) { ?>
                        <option value="<?= $data->nid ?>"><?= $data->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="loading"></div>
            <!-- <div id="mapid"></div> -->
            <div id="mapselect"></div>
        </div>

    </div>
</div>



<script>
    $(function() {
        $('.select2').select2()
    });

    function selectmaps(sel) {
        var maps_id = $('#maps_selected').val();
        var url = "<?= site_url('coverage/getmapsindo') ?>";
        $.ajax({
            type: 'POST',
            url: url,
            data: "&nid=" + maps_id,
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
                const obj = JSON.parse(data);
                console.log(obj.nid);
                console.log(obj.latitude);
                console.log(obj.longitude);
                $("#maps_lat").val(obj.latitude);
                $("#maps_longitude").val(obj.longitude);
                $("#mapid").hide();
                // $("#mapselect").show();


                var company = "<?= $company['company_name'] ?>";


                // var mymapselect = L.map('mapselect').setView([obj.latitude, obj.longitude], 8);
                var mymapselect = L.map('mapselect').setView([obj.latitude, obj.longitude], 8);




                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    maxZoom: 18,
                    // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                    //     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1
                }).addTo(mymapselect);
                var url = "<?= base_url('') ?>coverage/getcoverage/";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        data.forEach(function(data, index) {
                            var markernow = L.marker([data['latitude'], data['longitude']]).addTo(mymapselect)
                                .bindPopup('<h5 class="mb-0 mt-0 pb-0" style="text-align:center;">' + data['c_name'] + ' </h5><hr class=" mb-2 mt-2" color="blue" style="height:3px;box-shadow:2px 2px 2px black;" />' +

                                    '<p class="mt-1"> Alamat : ' + data['address'] + '<br> ');
                            var popup = L.popup();
                            var radius = data['radius'];
                            L.circle([data['latitude'], data['longitude']], {
                                radius: radius,
                                color: 'blue',
                                fillColor: 'green',
                                fillOpacity: '0.1',
                            }).addTo(mymapselect);
                        });

                    },
                    error: function(data) {}
                });

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
                                locationMarker = L.marker(e.latlng);
                                locationMarker.addTo(mymapselect);
                                locationMarker.bindPopup("<p class='text-center'>Lokasi Anda Saat Ini<br>Silahkan klik marker coverage area untuk mengetahui jarak anda ke coverage area<br>Akurasi GPS " + radius + " meter.</p>");
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
                                // polyline.addTo(mymapselect);
                                var markernow = L.marker([data['latitude'], data['longitude']]).addTo(mymapselect)
                                    .bindPopup('<h5 class="mb-0 mt-0 pb-0" style="text-align:center;">' + data['c_name'] + ' </h5><hr class=" mb-2 mt-2" color="blue" style="height:3px;box-shadow:2px 2px 2px black;" />' +
                                        '<span class="text-center  mb-0 mt-2"> Berjarak ' + distance + ' Km dari lokasi anda</span>' +
                                        '<p class="mt-1"> Alamat : ' + data['address'] + '<br> <a href="https://www.google.com/maps/dir/' + latt + ',' + lonn + '/' + data['latitude'] + ',' + data['longitude'] + '/" target="blank">Directions </a> ');
                                var popup = L.popup();
                                var radius = data['radius'];
                                L.circle([data['latitude'], data['longitude']], {
                                    radius: radius,
                                    color: 'blue',
                                    fillColor: 'green',
                                    fillOpacity: '0.1',
                                }).addTo(mymapselect);
                            });

                        },
                        error: function(data) {
                            // do something
                        }
                    });


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
                        mymapselect.removeLayer(theMarker);
                        mymapselect.removeLayer(markernow);
                    };

                    //Add a marker to show where you clicked.
                    theMarker = L.marker([latt, lonn]).addTo(mymapselect)
                        .bindPopup("Latitude : " + latt + " <br> Longitude : " + lonn + "")
                        .openPopup();


                }
                mymapselect.on('locationfound', onLocationFound);
                mymapselect.on('locationerror', onLocationError);


                L.control.locate({
                    position: 'topleft',
                    showCompass: true,
                    showPopup: false,
                }).addTo(mymapselect);
                var markernow = L.marker([<?= $company['latitude'] ?>, <?= $company['longitude'] ?>]).addTo(mymapselect)
                    .bindPopup("Office " + company).openPopup();
                $("#mapselected").show();

            }
        });
        return false;
    }
</script>