<div class="row">



    <div class="col-lg-6">

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold"><?= $title; ?></h6>

            </div>

            <?php echo form_open_multipart('') ?>

            <div class="card-body">

                <div class="form-group">

                    <label for="">Kode ODC</label>

                    <select name="code_odc" class="form-control select2" style="width: 100%;" required>

                        <option value="">-Pilih-</option>

                        <?php foreach ($odc as $data) { ?>

                            <option value="<?= $data->id_odc ?>"><?= $data->code_odc ?> </option>

                        <?php } ?>

                    </select>

                </div>





                <div class="form-group">

                    <label for="">Nomor Port ODC</label>

                    <input type="number" class="form-control" name="no_port_odc" autocomplete="off">

                </div>

                <div class="form-group">

                    <label for="name">Kode ODP</label>

                    <input type="text" class="form-control" id="code_odp" name="code_odp" autocomplete="off">

                    <?= form_error('code_odp', '<small class="text-danger pl-3 ">', '</small>') ?>

                </div>

                <div class="form-group">

                    <label for="">Wilayah ODP</label>

                    <select name="coverage_odp" class="form-control select2" style="width: 100%;" required>

                        <option value="">-Pilih-</option>

                        <?php foreach ($coverage as $data) { ?>

                            <option value="<?= $data->coverage_id ?>"><?= $data->code_area ?> - <?= $data->c_name ?></option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="">Warna Tube FO</label>

                    <input type="text" class="form-control" name="color_tube_fo" autocomplete="off">

                </div>

                <div class="form-group">

                    <label for="">Nomor Tiang</label>

                    <input type="text" class="form-control" name="no_pole" autocomplete="off">

                </div>

                <div class="form-group">

                    <label for="">Jumlah Port</label>

                    <input type="number" class="form-control" name="total_port" autocomplete="off">

                </div>

                <div class="form-group">

                    <label for="picture">Document</label>

                    <input type="file" class="form-control" id="picture" name="picture" autocomplete="off">

                </div>



                <div class="form-group">

                    <label for="remark">Description</label>

                    <textarea type="text" class="form-control" id="remark" name="remark" autocomplete="off"> </textarea>

                </div>

                <div class="form-group">

                    <label for="lat">lat</label>

                    <input type="text" id="lat" name="lat" class="form-control">

                </div>

                <div class="form-group">

                    <label for="long">long</label>

                    <input type="text" id="long" name="long" class="form-control">

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