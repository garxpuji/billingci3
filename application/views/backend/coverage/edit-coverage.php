<div class="row">

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold"><?= $title; ?></h6>
            </div>
            <?php echo form_open_multipart('') ?>
            <div class="card-body">
                <input type="hidden" name="coverage_id" id="coverage_id" class="form-control" autocapitalize="off" value="<?= $coverage['coverage_id'] ?>">
                <div class="form-group">
                    <label for="name">Kode Area</label>
                    <input type="number" name="code_area" id="code_area" class="form-control" autocapitalize="off" value="<?= $coverage['code_area'] ?>">
                </div>
                <?= form_error('code_area', '<small class="text-danger pl-3 ">', '</small>') ?>
                <div class="form-group">
                    <label for="name">Nama Area</label>
                    <input type="text" name="name" id="name" class="form-control" autocapitalize="off" value="<?= $coverage['c_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="public">Tampilkan di halaman Register</label>
                    <select name="public" class="form-control" id="public" required>
                        <option value="<?= $coverage['public']; ?>"><?= $coverage['public'] == 1 ? 'Yes' : 'No'; ?></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" name="address" id="address" class="form-control" autocapitalize="off" value="<?= $coverage['address'] ?>">
                </div>

                <div class="form-group">
                    <label for="comment">Keterangan</label>
                    <input type="text" name="comment" id="comment" class="form-control" autocapitalize="off" autocomplete="off" value="<?= $coverage['comment'] ?>">
                </div>


                <div class="form-group">

                    <label for="radius">Radius</label>

                    <div class="input-group mb-3">
                        <input type="number" id="radius" name="radius" class="form-control" value="<?= $coverage['radius'] ?>" onchange="NoServices()">
                        <div class="input-group-append">
                            <span class="input-group-text">Meter</span>
                        </div>
                    </div>


                </div>
                <div class="form-group">
                    <label for="lat">Latitude</label>
                    <input type="text" id="lat" name="lat" class="form-control" value="<?= $coverage['latitude'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="long">Longitude</label>
                    <input type="text" id="long" name="long" class="form-control" value="<?= $coverage['longitude'] ?>" readonly>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">

            <div class="col-lg-12">
                <div id="mapid"></div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    var ajaxku = buatajax();

    function ajaxkota(id) {
        var url = "<?= base_url('') ?>coverage/getKab/" + id + "/" + Math.random();
        ajaxku.onreadystatechange = stateChanged;
        ajaxku.open("GET", url, true);
        ajaxku.send(null);
    }

    function ajaxkec(id) {
        var url = "<?= base_url('') ?>coverage/getKec/" + id + "/" + Math.random();
        ajaxku.onreadystatechange = stateChangedKec;
        ajaxku.open("GET", url, true);
        ajaxku.send(null);
    }

    function ajaxkel(id) {
        var url = "<?= base_url('') ?>coverage/getKel/" + id + "/" + Math.random();
        ajaxku.onreadystatechange = stateChangedKel;
        ajaxku.open("GET", url, true);
        ajaxku.send(null);
    }

    function buatajax() {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        }
        if (window.ActiveXObject) {
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
        return null;
    }

    function stateChanged() {
        var data;
        if (ajaxku.readyState == 4) {
            data = ajaxku.responseText;
            if (data.length >= 0) {
                document.getElementById("kota").innerHTML = data
            } else {
                document.getElementById("kota").value = "<option selected>Pilih Kota/Kab</option>";
            }
            document.getElementById("kab_box").style.display = 'table-row';
            document.getElementById("kec_box").style.display = 'none';
            document.getElementById("kel_box").style.display = 'none';
        }
    }

    function stateChangedKec() {
        var data;
        if (ajaxku.readyState == 4) {
            data = ajaxku.responseText;
            if (data.length >= 0) {
                document.getElementById("kec").innerHTML = data
            } else {
                document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>";
            }
            document.getElementById("kec_box").style.display = 'table-row';
            document.getElementById("kel_box").style.display = 'none';
        }
    }

    function stateChangedKel() {
        var data;
        if (ajaxku.readyState == 4) {
            data = ajaxku.responseText;
            if (data.length >= 0) {
                document.getElementById("kel").innerHTML = data
            } else {
                document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>";
            }
            document.getElementById("kel_box").style.display = 'table-row';

        }
    }
</script>

<script>
    var company = "<?= $company['company_name'] ?>";
    var lat = "<?= $coverage['latitude'] ?>";
    var long = "<?= $coverage['longitude'] ?>";



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



    var polyline = L.polyline(latlngs, {
        color: 'red'
    }).addTo(mymap);




    // function onLocationError(e) {
    //     // alert(e.message);
    // }

    // mymap.on('locationfound', onLocationFound);
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
    var cov_name = "<?= $coverage['c_name'] ?>";
    var cov_address = "<?= $coverage['address'] ?>";
    var radius = "<?= $coverage['radius'] ?>";
    var markernow = L.marker([lat, long]).addTo(mymap)
        .bindPopup('<h5 class="mb-0 mt-0 pb-0" style="text-align:center;">' + cov_name + ' </h5><hr class=" mb-2 mt-2" color="blue" style="height:3px;box-shadow:2px 2px 2px black;" />' +

            '<p class="mt-1"> ' + cov_address + '<br> ').openPopup();
    var popup = L.popup();
    L.circle([lat, long], {
        radius: radius,
        color: 'blue',
        fillColor: 'green',
        fillOpacity: '0.1',
    }).addTo(mymap);
    var theMarker = {};
    mymap.on('click', onMapClick);
</script>