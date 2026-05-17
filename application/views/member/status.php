<div class="row">

    <div class="col-md-6">

        <div class="card shadow mb-2">

            <div class="card-header py-1">

                <h6 class="m-0 font-weight-bold">Layanan Anda</h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="box box-widget">

                            <div class="box-body table-responsive">

                                <table class="table ">

                                    <thead>

                                        <tr style="text-align: center">

                                            <th>Item Layanan</th>

                                            <th>Kategori</th>

                                        </tr>

                                    </thead>

                                    <tbody id="dataTables">

                                        <?php if ($services == null) { ?>

                                            <td colspan="2" style="color: red;">

                                                <marquee behavior="scroll" direction="left">Anda belum memiliki paket Layanan yang aktif</marquee>

                                            </td>

                                        <?php } ?>

                                        <?php $no = 1;

                                        foreach ($services as $c => $data) { ?>

                                            <tr style="text-align: center">

                                                <td><?= $data->item_name ?></td>

                                                <td><?= $data->category_name ?></td>

                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                    </tfoot>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>



                <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
                <?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
                <?php if ($rolepelanggan['show_usage'] == 1) { ?>

                    <div class="row text-center">
                        <div class="col-12">
                            <h4>Penggunaan Internet</h4>
                        </div>

                        <div class="col-12">
                            <?php if ($rt['is_active'] == 1) { ?>
                                <?php if ($customer['mode_user'] != '' && $customer['user_mikrotik']) {
                                    countusage($customer['no_services'], $customer['router']);
                                } ?>
                            <?php } ?>
                            <?php $usage = $this->mikrotik_m->usagethismonth($customer['no_services'])->result();

                            $totalusage = 0;
                            foreach ($usage as $c => $usage) {
                                $totalusage += $usage->count_usage;
                            }
                            ?>
                            <?php $last = $this->mikrotik_m->lastusage($customer['no_services'])->row_array() ?>
                            <h1 style="color: red; font-weight:bold"><?= formatBites($totalusage, 2); ?> </h1>


                        </div>
                    </div>


                <?php } ?>

            </div>

        </div>



    </div>

    <div class="col-md-6">

        <div class="card shadow mb-2">

            <div class="card-header py-1">

                <h6 class="m-0 font-weight-bold">Informasi Layanan</h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="">No Layanan</label>

                            <input type="" class="form-control" value="<?= $customer['no_services'] ?>" readonly>

                        </div>


                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="" class="form-control" value="<?= $customer['name'] ?>" readonly>
                        </div>

                        <div class="form-group">

                            <label for="">Email</label>

                            <input type="" class="form-control" value="<?= $customer['email'] ?>" readonly>

                        </div>

                        <div class="form-group">

                            <label for="">No <?= $customer['type_id']; ?></label>

                            <input type="" class="form-control" value="<?= $customer['no_ktp'] ?>" readonly>

                        </div>

                        <div class="form-group">

                            <label for="">Alamat</label>

                            <textarea class="form-control" readonly><?= $customer['address'] ?></textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script> -->
<script type="text/javascript" src="<?= base_url('assets/backend/') ?>highchart/js/highcharts.js"></script>

<script>
    $('#select').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        console.clear();
        $("#interface").val(valueSelected);
    });
    var chart;

    function requestDatta(interface) {
        var interface = $('#interface').val()
        var newStr = interface.replace(/%20/g, " ");
        $.ajax({
            url: '<?= site_url('member/trafficpppoe/') ?>' + newStr,
            datatype: "json",
            success: function(data) {
                var midata = JSON.parse(data);
                // console.log(midata);
                if (midata.length > 0) {
                    var TX = parseInt(midata[0].data);
                    var RX = parseInt(midata[1].data);
                    var TXRX = (TX + RX);
                    var x = (new Date()).getTime();
                    shift = chart.series[0].data.length > 19;
                    chart.series[0].addPoint([x, TX], true, shift);
                    chart.series[1].addPoint([x, RX], true, shift);
                    // document.getElementById("tabletx").innerHTML = convert(TX);
                    // document.getElementById("tablerx").innerHTML = convert(RX);
                    document.getElementById("tabletxrx").innerHTML = convert(TXRX);
                } else {
                    // document.getElementById("tabletx").innerHTML = "0";
                    // document.getElementById("tablerx").innerHTML = "0";
                    document.getElementById("tabletxrx").innerHTML = "0";
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
                console.error("Error: " + errorThrown);
            }
        });
    }

    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'graph',
                animation: Highcharts.svg,
                type: 'spline',
                events: {
                    load: function() {
                        setInterval(function() {
                            requestDatta(document.getElementById("interface").value);
                        }, 1000);
                    }
                }
            },
            title: {
                text: 'Monitoring'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000
            },

            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Traffic'
                },
                labels: {
                    formatter: function() {
                        var bytes = this.value;
                        var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                        if (bytes == 0) return '0 bps';
                        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                        return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                    },
                },
            },
            series: [{
                name: 'TX',
                data: []
            }, {
                name: 'RX',
                data: []
            }],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br/>',
                pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y}'
            },


        });
    });

    function convert(bytes) {

        var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
        if (bytes == 0) return '0 bps';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>