<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Interace</th>
                        <th>TX</th>
                        <th>RX</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="interface" id="interface" value="<?= $interface[0]['name'] ?>">
                            <select name="select" id="select" class="form-control">

                                <?php
                                foreach ($interface as $key => $data) { ?>
                                    <option value="<?= $data['name']; ?>"><?= $data['name']; ?></option>

                                <?php } ?>

                            </select>
                        </td>
                        <td>
                            <div id="tabletx"></div>
                        </td>
                        <td>
                            <div id="tablerx"></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="graph"></div>
        </div>

    </div>

    </main>

</div>
<script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script> -->
<script type="text/javascript" src="<?= base_url('assets/backend/') ?>highchart/js/highcharts.js"></script>
<script type="text/javascript">
    setInterval("dashboardreload();", 1000);

    function dashboardreload() {
        $('#dashboardreload').load('<?= site_url('mikrotik/dashboardreload'); ?>');
    }
</script>
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
            url: '<?= site_url('mikrotik/traffic/') ?>' + newStr,
            datatype: "json",
            success: function(data) {
                var midata = JSON.parse(data);
                // console.log(midata);
                if (midata.length > 0) {
                    var TX = parseInt(midata[0].data);
                    var RX = parseInt(midata[1].data);
                    var x = (new Date()).getTime();
                    shift = chart.series[0].data.length > 19;
                    chart.series[0].addPoint([x, TX], true, shift);
                    chart.series[1].addPoint([x, RX], true, shift);
                    document.getElementById("tabletx").innerHTML = convert(TX);
                    document.getElementById("tablerx").innerHTML = convert(RX);
                } else {
                    document.getElementById("tabletx").innerHTML = "0";
                    document.getElementById("tablerx").innerHTML = "0";
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