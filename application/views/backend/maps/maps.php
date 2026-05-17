<div class="row">


    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Maps Location</h6>
            </div>
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<?php if (count($customer) > 0) { ?>
    <div class="container row mt-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Data Pelanggan yang belum ditandai maps</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th style="text-align: center; width:20px">No</th>
                                <th>No Layanan</th>
                                <th>Nama</th>
                                <th>No Telp.</th>
                                <th>Status</th>

                                <th>Alamat</th>

                                <th style="text-align: center">Aksi</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1;
                            foreach ($customer as $r => $data) { ?>
                                <tr>
                                    <td style="text-align: center"><?= $no++ ?>.</td>
                                    <td><?= $data->no_services ?> </td>
                                    <td><?= $data->name ?></td>
                                    <td><?= indo_tlp($data->no_wa) ?></td>
                                    <td><?= $data->c_status ?></td>

                                    <td><?= $data->address ?></td>
                                    <td style="text-align: center">
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['edit_customer'] == 1) { ?>
                                            <a href="<?= site_url('customer/edit/') ?><?= $data->customer_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row" style="width:15%">No Layanan</th>
                            <td><span id="no_services"></span></td>
                        </tr>
                        <tr>

                            <th scope="row" style="width:15%">Nama</th>
                            <td><span id="name"></span></td>
                        </tr>
                        <tr>

                            <th scope="row" style="width:15%">Phone</th>
                            <td><span id="phone"></span></td>
                        </tr>
                        <?php $router = $this->db->get('router')->row_array() ?>
                        <?php if ($router['is_active'] == 1) { ?>
                            <tr>
                                <th scope="row" style="width:15%">Mode</th>
                                <td><span id="mode"></span></td>
                            </tr>
                            <tr>
                                <th scope="row" style="width:15%">User</th>
                                <td><span id="user_mikrotik"></span></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row" style="width:15%">Alamat</th>
                            <td><span id="address"></span></td>
                        </tr>
                    </tbody>
                </table>

                <div style="text-align: center;">
                    <a href="#" target="blank" id="direction" class="btn btn-outline-primary">Rute Google Maps</a>
                    <a href="#" target="blank" id="whatsapp" class="btn btn-outline-success">WhatsApp</a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    var company = "<?= $company['company_name'] ?>";
    var lat = "<?= $company['latitude'] ?>";
    var long = "<?= $company['longitude'] ?>";

    var cities = L.layerGroup();

    // var mLittleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities);
    // var mDenver = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities);
    // var mAurora = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities);
    // var mGolden = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);

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
        // 'Cities': cities
    };

    var layerControl = L.control.layers(baseLayers, overlays).addTo(mymap);
    var crownHill = L.marker([39.75, -105.09]).bindPopup('This is Crown Hill Park.');
    var rubyHill = L.marker([39.68, -105.00]).bindPopup('This is Ruby Hill Park.');

    var parks = L.layerGroup([crownHill, rubyHill]);

    var satellite = L.tileLayer(mbUrl, {
        id: 'mapbox/satellite-v9',
        tileSize: 512,
        zoomOffset: -1,
        attribution: mbAttr
    });
    layerControl.addBaseLayer(satellite, 'Satellite');
    // layerControl.addOverlay(parks, 'Parks');






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
    var markersLayer = new L.LayerGroup()
    //layer contain searched elements

    mymap.addLayer(markersLayer, {
        Icon: greenIcon
    });
    L.control.locate({
        position: 'topleft',
        showCompass: true,
        showPopup: false,
    }).addTo(mymap);

    mymap.locate({
        setView: true,
        maxZoom: 16
    });
    var search = new L.control.search({
            position: 'topright',
            hideMarkerOnCollapse: true,
            textPlaceholder: 'No Layanan',
            layer: markersLayer,
            initial: false,
            propertyName: 'no_services' // Specify which property is searched into.
        })
        .addTo(mymap);

    var url = "<?= base_url('') ?>maps/getmaps/";
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                var LeafIcon = L.Icon.extend({
                    options: {
                        iconSize: [32, 41],
                        iconAnchor: [15, 41],
                        popupAnchor: [0, -41]
                    }
                });
                if (data[i].c_status == 'Aktif' || data[i].c_status == 'Active') {
                    iconmaps = L.icon({
                        iconUrl: '<?= base_url() ?>assets/images/maps/marker_green.png',
                        iconSize: [32, 41],
                        iconAnchor: [15, 41],
                        popupAnchor: [0, -41]
                    });
                }
                if (data[i].c_status == 'Non-Aktif' || data[i].c_status == 'Non-Active') {
                    iconmaps = L.icon({
                        iconUrl: '<?= base_url() ?>assets/images/maps/marker_red.png',
                        iconSize: [32, 41],
                        iconAnchor: [15, 41],
                        popupAnchor: [0, -41]
                    });
                }
                if (data[i].c_status == 'Menunggu' || data[i].c_status == 'Waiting') {
                    iconmaps = L.icon({
                        iconUrl: '<?= base_url() ?>assets/images/maps/marker_gray.png',
                        iconSize: [32, 41],
                        iconAnchor: [15, 41],
                        popupAnchor: [0, -41]
                    });
                }

                marker = new L.Marker(new L.latLng(parseFloat([data[i].latitude]), parseFloat([data[i].longitude])), {
                        icon: iconmaps,
                        no_services: data[i].no_services + ' - ' + data[i].name,

                    }).addTo(mymap)
                    .bindPopup('<h5 class="mb-0 mt-0 pb-0" style="text-align:center;">Data Pelanggan </h5><br>' +


                        `<table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th >No Layanan</th>
                            <td>` + data[i].no_services + `</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>` + data[i].name + `</td>
                        </tr>
                        <tr>
                            <th>Status Pelanggan</th>
                            <td>` + data[i].c_status + `</td>
                        </tr>
                        <tr>

                            <th>Phone</th>
                            <td>` + data[i].no_wa + `</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>` + data[i].address + `</td>
                        </tr>               
                            <tr>
                                <th>Mode</th>
                                <td>` + data[i].mode_user + `</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>` + data[i].user_mikrotik + `</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <td>` + data[i].coverage + `</td>
                            </tr>
                            <tr>
                                <th>ODC</th>
                                <td>` + data[i].odc + `</td>
                            </tr>
                            <tr>
                                <th>ODP | Port ODP </th>
                                <td>` + data[i].odp + `</td>
                            </tr>
                           
                      
                    
                    </tbody>
                </table>
                <div style="text-align: center;">
                    <a href="http://www.google.com/maps/place/` + data[i].latitude + `,` + data[i].longitude + `" target="blank"  class="btn btn-outline-primary">Rute</a>
                    <a href="http://wa.me/` + data[i].no_wa + `" target="blank"  class="btn btn-outline-success">WhatsApp</a>
                    <a href="<?= base_url('customer/edit/') ?>` + data[i].customer_id + `" target="blank"  class="btn btn-outline-primary">Edit</a>
                </div>`, {
                            maxWidth: "auto"
                        }

                    );


                markersLayer.addLayer(marker);



            }

        },
        error: function(data) {}
    });
</script>