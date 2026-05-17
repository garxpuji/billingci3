<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<!-- Leaflet Locate Control CSS Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.css" />
<!-- Leaflet CSS Library -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">

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
<div class="row">

    <div class="col-lg-12">
        <div id="mapid"></div>
    </div>

</div>


<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<script>
    var company = "<?= $company['company_name'] ?>";


    var mymap = L.map('mapid', {
        fullscreenControl: true,
        // OR
        fullscreenControl: {
            pseudoFullscreen: false // if true, fullscreen to page width and height
        }
    }).setView([-3.469557, 117.026367], 5);



    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        //     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);
    var url = "<?= base_url('') ?>coverage/getcoverage/";
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function(data) {
            data.forEach(function(data, index) {
                var LeafIcon = L.Icon.extend({
                    options: {

                        iconSize: [32, 41],
                        iconAnchor: [15, 41],
                        popupAnchor: [0, -41]
                    }
                });
                var greenIcon = new LeafIcon({
                        iconUrl: '<?= base_url() ?>assets/images/maps/marker_green.png'
                    }),
                    redIcon = new LeafIcon({
                        iconUrl: '<?= base_url() ?>assets/images/maps/marker_red.png'
                    }),
                    blueIcon = new LeafIcon({
                        iconUrl: '<?= base_url() ?>assets/images/maps/marker_blue.png'
                    });
                var markernow = L.marker([data['latitude'], data['longitude']], {
                        icon: greenIcon
                    }).addTo(mymap)
                    .bindPopup('<h5 class="mb-0 mt-0 pb-0" style="text-align:center;">' + data['c_name'] + ' </h5><hr class=" mb-2 mt-2" color="blue" style="height:3px;box-shadow:2px 2px 2px black;" />' +

                        '<p class="mt-1"> Alamat : ' + data['address'] + '<br> ');
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
                    locationMarker.addTo(mymap);
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
                    // polyline.addTo(mymap);
                    var markernow = L.marker([data['latitude'], data['longitude']]).addTo(mymap)
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
                    }).addTo(mymap);
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
            mymap.removeLayer(theMarker);
            mymap.removeLayer(markernow);
        };

        //Add a marker to show where you clicked.
        theMarker = L.marker([latt, lonn]).addTo(mymap)
            .bindPopup("Latitude : " + latt + " <br> Longitude : " + lonn + "")
            .openPopup();


    }
    mymap.on('locationfound', onLocationFound);
    mymap.on('locationerror', onLocationError);


    L.control.locate({
        position: 'topleft',
        showCompass: true,
        showPopup: false,
    }).addTo(mymap);
    var markernow = L.marker([<?= $company['latitude'] ?>, <?= $company['longitude'] ?>]).addTo(mymap)
        .bindPopup("Office " + company).openPopup();
</script>