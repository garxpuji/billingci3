<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Laporan Keuangan <?= $date; ?> <?= indo_month($month); ?> <?= $year; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tablerep" width="100%" cellspacing="0">
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
<script src="<?= base_url('assets/backend/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
<script src="<?= base_url('assets/backend/') ?>js/select2.full.min.js"></script>
<script src="<?= base_url('assets/backend/') ?>moment.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablerep').DataTable({
            "lengthMenu": false,
            "lengthChange": false,
            dom: 'lBfrtip',
            "paging": false,
            "ordering": false,
            buttons: [{
                    extend: ['copy'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['csv'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['excel'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['pdf'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['print'],
                    footer: true,
                    title: 'Laporan Keuangan  <?= $date ?> <?= indo_month($month) ?> <?= $year ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }],

        });
    });
</script>