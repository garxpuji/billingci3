<!-- Leaflet Locate Control Library -->
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets/backend/') ?>leaflet-search/leaflet-search.css" />
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="<?= base_url('assets/backend/') ?>leaflet-search/leaflet-search.js"></script>



<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
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
        <div id="map"></div>
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
                            <th scope="row" style="width:15%">Mode</th>
                            <td><span id="mode"></span></td>
                        </tr>
                        <tr>
                            <th scope="row" style="width:15%">User</th>
                            <td><span id="user_mikrotik"></span></td>
                        </tr>
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
    if (lat == '') {
        var mymap = L.map('map').setView([-3.469557, 117.026367], 5);

    } else {
        var mymap = L.map('map').setView([lat, long], 10);
    }



    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        //     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);

    var markersLayer = new L.LayerGroup(); //layer contain searched elements

    mymap.addLayer(markersLayer);

    var search = new L.control.search({
            textPlaceholder: 'No Layanan',
            layer: markersLayer,
            initial: false,
            propertyName: 'no_services' // Specify which property is searched into.
        })
        .addTo(mymap);


    var url = "<?= base_url('') ?>customer/getmaps/";
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function(data) {
            for (var i = 0; i < data.length; i++) {
                marker = new L.Marker(new L.latLng(parseFloat([data[i].latitude]), parseFloat([data[i].longitude])), {
                    no_services: data[i].no_services + ' - ' + data[i].name,
                });
                markersLayer.addLayer(marker);
                const latitude = parseFloat(data[i].latitude);
                const longitude = parseFloat(data[i].longitude);
                const user_mikrotik = data[i].user_mikrotik;
                const name = data[i].name;
                const address = data[i].address;
                const no_wa = data[i].no_wa;
                const no_services = data[i].no_services;
                const mode_user = data[i].mode_user;
                marker.on('click', function() {
                    $('#Modal').modal('show').on('shown.bs.modal', function() {
                        var modal = $(this)

                        $('#info').trigger("reset");

                        modal.find('#user_mikrotik').html(user_mikrotik);
                        modal.find('#address').html(address);
                        modal.find('#name').html(name);
                        modal.find('#no_services').html(no_services);
                        modal.find('#mode').html(mode_user);
                        document.getElementById('direction').href = 'http://www.google.com/maps/place/' + latitude + ',' + longitude;
                        document.getElementById('whatsapp').href = 'http://wa.me/62' + no_wa;
                    })
                });
            }

        },
        error: function(data) {}
    });
</script>