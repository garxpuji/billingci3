<div class="col-6">

    <?php $this->view('messages') ?>

</div>

<?php
$router = $this->db->get('router')->row_array();
$ip = $router['ip_address'];
$user = $router['username'];
$pass = $router['password'];
$port = $router['port'];
$API = new Mikweb();
$usermikrotik = $customer['user_mikrotik'];
$API->connect($ip, $user, $pass, $port);
$hotspotactive = $API->comm("/ip/hotspot/active/print", array("?user" => $usermikrotik));
$pppoeactive = $API->comm("/ppp/active/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
$userhotspot = $API->comm("/ip/hotspot/user/print", array("?name" => $usermikrotik));
$userpppoe = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik,));
$simplequeue = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
$simplequeuehotspot = $API->comm("/queue/simple/print", array('?name' => '<hotspot-' . $usermikrotik . '>',));
$ipqueue = substr($simplequeue['0']['target'], 0, -3);
$getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
$getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $customer['no_services'] . ''));
// var_dump($userhotspot['0']['disabled']);
// echo $hotspotactive;

?>

<?php if ($customer['mode_user'] == 'Hotspot') { ?>
    <?php
    $byte = $simplequeuehotspot['0']['bytes'];
    $updl = explode("/", $byte);
    $up = $updl['0'];
    $dl = $updl['1'];
    ?>
    <?php $usage = formatBites($userhotspot['0']['bytes-out'] + $userhotspot['0']['bytes-in'] + $up + $dl, 2); ?>
<?php } ?>

<?php if ($customer['mode_user'] == 'PPPOE') { ?>
    <?php $usage =  formatBites($userpppoe['0']['comment'], 2); ?>
<?php } ?>


<?php if ($customer['mode_user'] == 'Static') { ?>
    <?php
    $byte = $simplequeue['0']['bytes'];
    $updl = explode("/", $byte);
    $up = $updl['0'];
    $dl = $updl['1'];
    ?>
    <?php $usage =  formatBites($up + $dl, 2); ?>
<?php } ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Data Pelanggan</h6>
            </div>
            <div class="card-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col">Nama</div>
                            <div class="col">: <?= $customer['name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">No Layanan</div>
                            <div class="col">: <?= $customer['no_services']; ?></div>
                        </div>

                        <div class="row">
                            <div class="col">Mode</div>
                            <div class="col">: <?= $customer['mode_user']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">User </div>
                            <div class="col">: <?= $customer['user_mikrotik']; ?></div>
                        </div>


                        <div class="row">
                            <div class="col">Pemakaian</div>
                            <div class="col">: <?= $usage; ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">Status</div>
                            <div class="col">:
                                <?php if ($customer['mode_user'] == 'Hotspot') { ?>
                                    <?php if ($userhotspot['0']['disabled'] == 'true') {
                                        echo '<div class="badge badge-warning">Isolir</div>';
                                    } elseif (count($hotspotactive) > 0) {
                                        echo '<div class="badge badge-success">Active</div>';
                                    } elseif (count($hotspotactive) <= 0) {
                                        echo '<div class="badge badge-danger">Non-Active</div>';
                                    }
                                    ?>
                                    <?php if ($userhotspot['0']['disabled'] == 'true') { ?>
                                        <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                    <?php } ?>
                                    <?php if ($userhotspot['0']['disabled'] == 'false') { ?>
                                        <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($customer['mode_user'] == 'PPPOE') { ?>

                                    <td style="text-align: center">
                                        <?php if ($userpppoe['0']['disabled'] == 'true') {
                                            echo '<div class="badge badge-warning">Isolir</div>';
                                        } elseif (count($pppoeactive) > 0) {
                                            echo '<div class="badge badge-success">Active</div>';
                                        } elseif (count($pppoeactive) <= 0) {
                                            echo '<div class="badge badge-danger">Non-Active</div>';
                                        }
                                        ?>
                                        <?php if ($userpppoe['0']['disabled'] == 'true') { ?>
                                            <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                        <?php } ?>
                                        <?php if ($userpppoe['0']['disabled'] == 'false') { ?>
                                            <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user  <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($customer['mode_user'] == 'Static') { ?>
                                        <?php if (count($getfirewall) > 0) {
                                            echo '<div class="badge badge-warning">Isolir</div>';
                                        } elseif (count($getarp) > 0) {
                                            echo '<div class="badge badge-success">Active</div>';
                                        } elseif (count($getarp) <= 0) {
                                            echo '<div class="badge badge-danger">Non-Active</div>';
                                        }
                                        ?>
                                        <?php if (count($getfirewall) > 0) { ?>
                                            <a class="btn btn-success" href="<?= site_url('router/openisolir/' . $customer['no_services']) ?>" title="Open Isolir" onclick="return confirm('Apakah anda yakin akan open isolir user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Open Isolir</a>
                                        <?php } ?>
                                        <?php if (count($getfirewall) == 0) { ?>
                                            <a class="btn btn-danger" href="<?= site_url('router/isolir/' . $customer['no_services']) ?>" title="Isolir Pelanggan" onclick="return confirm('Apakah anda yakin akan isolir user Static <?= $customer['user_mikrotik'] ?> ?')"></i>Isolir</a>
                                        <?php } ?>
                                    <?php } ?>

                            </div>
                        </div>
                        <div class="row d-sm-flex align-items-center justify-content-between mt-3">
                            <div class="col mb-1">
                                <a href="" class="btn btn-primary"> Refresh</a>
                            </div>

                            <?php $id = str_replace('*', '', $userhotspot['0']['.id']) ?>

                            <a class="btn btn-warning" href="<?= site_url('router/resetusage/' .  $customer['no_services']) ?>" title="Reset Pemakaian" onclick="return confirm('Apakah anda yakin akan reset pemakaian user <?= $customer['user_mikrotik'] ?> ?')"></i>Reset Pemakaian</a>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
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
            url: '<?= site_url('mikrotik/trafficclient/') ?>' + newStr,
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