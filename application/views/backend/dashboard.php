<?php $this->view('messages') ?>
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<?php $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<!-- Content Row -->

<?php if ($this->session->userdata('role_id') == 1 or $menu['customer_menu'] == 1) { ?>
    <div class="col-lg-3 col-sm-12 col-md-6">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_menu'] == 1) { ?>
                <?php if (count($customer) > 0) { ?>
                    <div class="form-group">
                        <select class="form-control select2" name="no_services" id="no_services" onchange="getdetailcustomer()" required>
                            <option value="">Pilih No Layanan - Nama Pelanggan - Status </option>
                            <?php
                            foreach ($customer as $r => $data) { ?>
                                <option value="<?= $data->no_services ?>"><?= $data->no_services ?> - <?= $data->name ?> - <?= $data->c_status; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>
    </div>
<?php } ?>
<div class="loading"></div>

<div class="getdatacustomer"></div>

<div class="" id="contents">
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <?php if ($role['role_id'] == 1 or $menu['customer_menu'] == 1) { ?>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">

                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Pelanggan</div>
                                    </div>
                                    <div class="col-2"><i id="showcustomer" class="fa fa-eye-slash"></i><i id="hidecustomer" class="fa fa-eye" style="display: none;"></i></div>

                                </div>
                                <div class="container" id="loading1">

                                </div>
                                <div class="" id="cardcustomer">
                                    <a href="<?= site_url('customer/active') ?>" style="text-decoration: none;">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Aktif : <span id="customeractive">xxx</span></div>
                                    </a>
                                    <a href="<?= site_url('customer/nonactive') ?>" style="text-decoration: none;">
                                        <span style="font-size: smaller; color:black">Non-Aktif : <span id="customernonactive">xxx</span></span> <br>
                                    </a>
                                    <a href="<?= site_url('customer/wait') ?>" style="text-decoration: none;">
                                        <span style="font-size: smaller; color:black">Menunggu : <span id="customerwaiting">xxx</span></span> <br>
                                    </a>
                                    <a href="<?= site_url('customer/free') ?>" style="text-decoration: none;">
                                        <span style="font-size: smaller; color:black">Free : <span id="customerfree">xxx</span> </span> <br>
                                    </a>
                                    <a href="<?= site_url('bill/duedate') ?>" style="text-decoration: none;">
                                        <span style="font-size: smaller; color:black">Jatuh Tempo : <span id="customerduedate">xxx</span> <br>
                                    </a>
                                    <a href="<?= site_url('customer/isolir') ?>" style="text-decoration: none;">
                                        <span style="font-size: smaller; color:red">ISOLIR : <span id="customerisolir">xxx</span> </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wallet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
        <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">

                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pemasukan Bulan ini</div>
                                    </div>
                                    <div class="col-2">
                                        <i id="showincome" class="fa fa-eye-slash"></i><i id="hideincome" class="fa fa-eye" style="display: none;"></i>
                                    </div>
                                </div>

                                <div class="container" id="loading2">

                                </div>
                                <div class="" id="cardincome">
                                    <a href="<?= site_url('income') ?>" style="text-decoration: none;">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="incomethismonth">xxx</span></div>
                                        <span style="font-size: smaller; color:black">Bulan Kemarin : <span id="incomelastmonth">xxx</span></span> <br>
                                        <span style="font-size: smaller; color:black">Hari Ini : <span id="incometoday">xxx</span></span> <br>
                                        <span style="font-size: smaller; color:black">Kemarin : <span id="incomeyesterday">xxx</span></span> <br>
                                        <span style="font-size: smaller; color:black">Selisih Pemasukan & Pengeluaran Bulan Ini : <br>
                                            <span id="difference">xxx</span></span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>

        <!-- Earnings (Monthly) Card Example -->
        <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">

                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengeluaran Bulan Ini</div>
                                    </div>
                                    <div class="col-2">
                                        <i id="showexpenditure" class="fa fa-eye-slash"></i><i id="hideexpenditure" class="fa fa-eye" style="display: none;"></i>
                                    </div>
                                </div>

                                <div class="row no-gutters align-items-center">
                                    <div class="container" id="loading3">

                                    </div>
                                    <div class="">
                                        <a href="<?= site_url('expenditure') ?>" style="text-decoration: none; color:black">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="expenditurethismonth">xxx</span></div>
                                            <span style="font-size: smaller; color:black">Bulan Kemarin : <span id="expenditurelastmonth">xxx</span></span> <br>
                                            <span style="font-size: smaller; color:black">Hari Ini : <span id="expendituretoday">xxx</span></span> <br>
                                            <span style="font-size: smaller; color:black">Kemarin : <span id="expenditureyesterday">xxx</span></span> <br>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
        <!-- Pending Requests Card Example -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">

                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Pembayaran</div>
                                    </div>
                                    <div class="col-2">
                                        <i id="showbill" class="fa fa-eye-slash"></i><i id="hidebill" class="fa fa-eye" style="display: none;"></i>
                                    </div>
                                </div>
                                <div class="container" id="loading4">
                                </div>
                                <div class="">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: small">
                                        <a href="<?= site_url('bill/unpaid') ?>" style="text-decoration: none; color:black">
                                            <span id="pendingpayment">xxx</span> Tagihan
                                            <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
                                                (<span style="color:red;" id="amountpendingpayment">xxx</span>)
                                                <br>
                                            <?php } ?>
                                        </a>

                                    </div>
                                </div>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['coverage_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <a href="<?= site_url('coverage') ?>" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Coverage Area</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $coverage; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if ($this->session->userdata('role_id') == 1 or $menu['help_menu'] == 1) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <a href="<?= site_url('help/pending') ?>" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tiket Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->db->get_where('help', ['status' => 'pending'])->num_rows(); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <a href="<?= site_url('help/proses') ?>" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tiket Proces</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->help_m->getprocess()->num_rows(); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <a href="<?= site_url('help/done') ?>" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tiket Done</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->help_m->getdone()->num_rows(); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <?php if ($this->session->userdata('role_id') == 1 or $role['show_saldo'] == 1) { ?>
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Pemasukan Tahun ini</h6>

                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="myAreaChart" style="display: block; height: 320px; width: 560px;" width="1120" height="640" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Pie Chart -->
        <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_logs'] == 1) { ?>
            <div class="col-xl-6 col-lg-6 d-none d-sm-block d-md-block">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>

                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center; width:20px">No</th>
                                    <th>Name</th>
                                    <th>Level</th>
                                    <th>Time</th>
                                    <th>Remark</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($logs as $log) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $log->name; ?></td>
                                        <td>
                                            <?= $log->role_id == 0 ? 'System' : '' ?>
                                            <?= $log->role_id == 1 ? 'Admin' : '' ?>
                                            <?= $log->role_id == 2 ? 'Pelanggan' : '' ?>
                                            <?= $log->role_id == 3 ? 'Operator' : '' ?>
                                            <?= $log->role_id == 5 ? 'Teknisi' : '' ?>
                                        </td>
                                        <td><?= date('d-M-Y', $log->datetime) ?> - <?= date('H:i:s', $log->datetime) ?></td>

                                        <td><?= $log->remark ?></td>


                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="modal-footer">

                            <a href="<?= site_url('logs') ?>" class="btn btn-primary">Show All</a>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>

</div>



<?php $Jan = 0;
foreach ($incomeJan as $c => $data) {
    $Jan += $data->nominal;
} ?>
<?php $Feb = 0;
foreach ($incomeFeb as $c => $data) {
    $Feb += $data->nominal;
} ?>
<?php $Mar = 0;
foreach ($incomeMar as $c => $data) {
    $Mar += $data->nominal;
} ?>
<?php $Apr = 0;
foreach ($incomeApr as $c => $data) {
    $Apr += $data->nominal;
} ?>
<?php $May = 0;
foreach ($incomeMay as $c => $data) {
    $May += $data->nominal;
} ?>
<?php $Jun = 0;
foreach ($incomeJun as $c => $data) {
    $Jun += $data->nominal;
} ?>
<?php $Jul = 0;
foreach ($incomeJul as $c => $data) {
    $Jul += $data->nominal;
} ?>
<?php $Aug = 0;
foreach ($incomeAug as $c => $data) {
    $Aug += $data->nominal;
} ?>
<?php $Sep = 0;
foreach ($incomeSep as $c => $data) {
    $Sep += $data->nominal;
} ?>
<?php $Oct = 0;
foreach ($incomeOct as $c => $data) {
    $Oct += $data->nominal;
} ?>
<?php $Nov = 0;
foreach ($incomeNov as $c => $data) {
    $Nov += $data->nominal;
} ?>
<?php $Dec = 0;
foreach ($incomeDec as $c => $data) {
    $Dec += $data->nominal;
} ?>
<script src="<?= base_url('assets/backend/') ?>js/Chart.min.js"></script>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Income",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [<?php echo "$Jan"; ?>, <?php echo "$Feb"; ?>, <?php echo "$Mar"; ?>, <?php echo "$Apr"; ?>, <?php echo "$May"; ?>, <?php echo "$Jun"; ?>, <?php echo "$Jul"; ?>, <?php echo "$Aug"; ?>, <?php echo "$Sep"; ?>, <?php echo "$Oct"; ?>, <?php echo "$Nov"; ?>, <?php echo "$Dec"; ?>],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return 'Rp.' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#showcustomer').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getcustomer') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading1').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                },
                success: function(data) {
                    $('#hidecustomer').show();
                    $('#showcustomer').hide();
                    var c = jQuery.parseJSON(data);
                    $("#cardcustomer").show();
                    $("#loading1").hide();
                    $('#customeractive').html(c['customeractive']);
                    $('#customernonactive').html(c['customernonactive']);
                    $('#customerwaiting').html(c['customerwaiting']);
                    $('#customerfree').html(c['customerfree']);
                    $('#customerisolir').html(c['customerisolir']);
                    $('#customerduedate').html(c['customerduedate']);

                }
            });
        });
        $('#hidecustomer').click(function() {

            $('#hidecustomer').hide();
            $('#showcustomer').show();
            $('#customeractive').html('xxx');
            $('#customernonactive').html('xxx');
            $('#customerwaiting').html('xxx');
            $('#customerfree').html('xxx');
            $('#customerisolir').html('xxx');
            $('#customerduedate').html('xxx');
        });

        $('#showincome').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getincome') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading2').html(` <div class="container">
<div class="text-center">
<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
</div>`);
                },
                success: function(data) {
                    $('#hideincome').show();
                    $('#showincome').hide();
                    $('#loading2').hide();
                    var c = jQuery.parseJSON(data);

                    $('#incomethismonth').html(c['incomethismonth']);
                    $('#incomelastmonth').html(c['incomelastmonth']);
                    $('#incometoday').html(c['incometoday']);
                    $('#incomeyesterday').html(c['incomeyesterday']);
                    $('#difference').html(c['difference']);

                }
            });
        });
        $('#hideincome').click(function() {

            $('#hideincome').hide();
            $('#showincome').show();
            $('#incomethismonth').html('xxx');
            $('#incomelastmonth').html('xxx');
            $('#incometoday').html('xxx');
            $('#incomeyesterday').html('xxx');
            $('#difference').html('xxx');
        });

        $('#showexpenditure').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getexpenditure') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading3').html(` <div class="container">
<div class="text-center">
<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
</div>`);
                },
                success: function(data) {
                    var c = jQuery.parseJSON(data);
                    $('#hideexpenditure').show();
                    $('#showexpenditure').hide();

                    $("#loading3").hide();
                    $('#expenditurethismonth').html(c['expenditurethismonth']);
                    $('#expenditurelastmonth').html(c['expenditurelastmonth']);
                    $('#expendituretoday').html(c['expendituretoday']);
                    $('#expenditureyesterday').html(c['expenditureyesterday']);

                }
            });
        });
        $('#hideexpenditure').click(function() {

            $('#hideexpenditure').hide();
            $('#showexpenditure').show();
            $("#loading3").hide();
            $('#expenditurethismonth').html('xxx');
            $('#expenditurelastmonth').html('xxx');
            $('#expendituretoday').html('xxx');
            $('#expenditureyesterday').html('xxx');
        });


        $('#showbill').click(function() {
            $.ajax({
                type: 'get',
                url: '<?= site_url('dashboard/getbill') ?>',
                cache: false,
                beforeSend: function() {

                    $('#loading4').html(` <div class="container">
<div class="text-center">
<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
</div>`);
                },
                success: function(data) {
                    var c = jQuery.parseJSON(data);
                    $('#hidebill').show();
                    $('#showbill').hide();
                    $("#loading4").hide();
                    $('#pendingpayment').html(c['pendingpayment']);
                    $('#amountpendingpayment').html(c['amountpendingpayment']);

                }
            });
        });
        $('#hidebill').click(function() {

            $('#hidebill').hide();
            $('#showbill').show();
            $("#loading4").hide();
            $('#pendingpayment').html('xxx');
            $('#amountpendingpayment').html('xxx');
        });




        return false;
    })
</script>



<script type="text/javascript">
    setInterval("cekbill();", 300000);
    setInterval("fixdouble();", 780000);
    setInterval("fixbill();", 900000);
    setInterval("fixbillamount();", 180000);
    setInterval("deldouble();", 120000);
    var month = "<?= date('m') ?>";
    var year = "<?= date('Y') ?>";

    function deldouble() {
        console.log('menjalankan hapus double pemasukan');
        $.ajax({
            type: 'get',
            url: '<?= site_url('income/deldouble/') ?>' + month + '/' + year,
            cache: false,
            success: function(data) {}
        });
    }

    function cekbill() {
        console.log('menjalankan cek bill');
        $.ajax({
            type: 'get',
            url: '<?= site_url('customer/cekbill') ?>',
            cache: false,
            success: function(data) {}
        });
    }

    function fixdouble() {
        console.log('menjalankan fixdouble');
        $.ajax({
            type: 'get',
            url: '<?= site_url('bill/fixdouble') ?>',
            cache: false,
            success: function(data) {}
        });
    }

    function fixbill() {
        console.log('menjalankan fixbill');
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/fixbill') ?>',
            cache: false,
            success: function(data) {}
        });
    }

    function fixbillamount() {
        console.log('menjalankan fixbillamount');
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/fixbillamount') ?>',
            cache: false,
            success: function(data) {}
        });
    }
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/createbill') ?>',
            cache: false,
            success: function(data) {}
        });

        return false;
    })
</script>
<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
<?php if ($pg['is_active'] == 1) { ?>
    <?php if ($pg['vendor'] == 'Tripay') { ?>
        <script>
            $(document).ready(function() {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('tripay/transaction') ?>',
                    cache: false,
                    success: function(data) {}
                });

                return false;
            })
        </script>
    <?php } ?>
<?php } ?>