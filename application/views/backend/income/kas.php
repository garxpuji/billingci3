<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<?php $this->view('messages') ?>

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <?php
    $allincome =  $this->income_m->getIncome()->result();
    $totalincome = 0;
    foreach ($allincome as $c => $data) {
        $totalincome += $data->nominal;
    }

    $allexpend =  $this->expenditure_m->getexpenditure()->result();
    $totalexpend = 0;
    foreach ($allexpend as $c => $data) {
        $totalexpend += $data->nominal;
    } ?>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Saldo Kas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($totalincome - $totalexpend) ?></div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Pemasukan Global</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($totalincome) ?></div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Pengeluaran Global</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($totalexpend) ?></div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-default shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <button href="" id="filter" class="btn btn-outline-primary"><i class="fa fa-cube"></i> Filter</button>
                        <!-- <button href="" data-toggle="modal" data-target="#print" class="btn btn-outline-primary"><i class="fa fa-print"></i> Cetak</button> -->

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-sm-12 col-md-6" id="filterreport" style="display: none;">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Tanggal</label>
                            <div class="col-sm-9">
                                <select name="date" id="date" class="form-control" onchange="getreportfinance()">
                                    <option value="">-Semua-</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Bulan</label>
                            <div class="col-sm-9">
                                <select id="month" name="month" class="form-control" onchange="getreportfinance()">
                                    <option value="">-Pilih-</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Tahun</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <select class="form-control " style="width: 100%;" type="text" id="year" name="year" autocomplete="off" onchange="getreportfinance()">
                                        <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                        <?php if (date('m') == 12) {  ?>
                                            <?php
                                            for ($i = date('Y') + 1; $i >= date('Y') - 2; $i -= 1) {
                                            ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if (date('m') < 12) {  ?>
                                            <?php
                                            for ($i = date('Y'); $i >= date('Y') - 2; $i -= 1) {
                                            ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loading"></div>
<div class="view_data"></div>
<?php
$total = count(json_decode($report, true)); ?>
<div class="card shadow mb-4" id="reportglobal" style="display : <?= $total >= 3000 ? 'none' : '' ?>">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Laporan Keuangan Global</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tablereport" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="width:100px">Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th style="width:100px">Debit</th>
                        <th style="width:100px">Kredit</th>
                        <th style="width:100px">Saldo</th>
                    </tr>
                </thead>
                <tfoot>
                    <?php
                    $income = 0;
                    $expend = 0;
                    $in = json_decode($report, true);
                    foreach ($in as $key => $data) {
                        $income += $data['income'];
                        $expend += $data['expenditure'];
                    ?>

                    <?php } ?>
                    <tr style="text-align: center">
                        <th style="text-align: right; font-weight:bold" colspan="3"><b>Total</b></th>
                        <th style="text-align: right"><?= indo_currency($income) ?> </th>
                        <th style="text-align: right"><?= indo_currency($expend) ?></th>
                        <th style="text-align: right"><?= indo_currency($income - $expend) ?></th>
                    </tr>

                </tfoot>
                <tbody>

                    <?php
                    $saldo = 0;
                    $report = json_decode($report, true);
                    foreach ($report as $key => $data) {
                        $saldo = $saldo + $data['income'] - $data['expenditure'];
                    ?>
                        <tr>
                            <td><?= indo_date($data['date'])  ?> </td>
                            <td><?= $data['remark'] ?></td>
                            <td><?= $data['category'] ?></td>
                            <td style="text-align: right"><?= $data['income'] != 0 ? indo_currency($data['income']) : '-'   ?></td>
                            <td style="text-align: right"><?= $data['expenditure'] != 0 ? indo_currency($data['expenditure']) : '-'  ?></td>
                            <td style="text-align: right"><?= indo_currency($saldo)  ?></td>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $("#filter").click(function() {
            $('#filterreport').show()
            $('#month').focus()
        })
        $('#tablereport').DataTable({
            "lengthMenu": false,
            "lengthChange": false,
            dom: 'lBfrtip',
            "paging": false,
            "ordering": false,
            buttons: [{
                    extend: ['copy'],
                    footer: true,
                    title: 'Laporan Keuangan Global',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['csv'],
                    footer: true,
                    title: 'Laporan Keuangan Global',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['excel'],
                    footer: true,
                    title: 'Laporan Keuangan Global',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['pdf'],
                    footer: true,
                    title: 'Laporan Keuangan Global',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['print'],
                    footer: true,
                    title: 'Laporan Keuangan Global',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }]
        });


    });
</script>
<script>
    function getreportfinance() {

        var date = $("#date").val();
        var month = $("#month").val();
        var year = $("#year").val();

        if (month == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Bulan belum dipilih !',
            })
            $('#month').focus()
        } else {
            $.ajax({
                type: 'POST',
                data: "&month=" + month + "&year=" + year + "&date=" + date,
                cache: false,
                url: '<?= site_url('income/getreport') ?>',
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
                    $('.view_data').html(data);
                    $('#reportglobal').hide();
                }

            });

            return false;
        }
    }
</script>