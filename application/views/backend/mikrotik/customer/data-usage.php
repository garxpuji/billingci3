<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php
$jumHari = jumlah_hari($month, $year);
?>
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Pemakaian Internet Harian Bulan <?= indo_month($month); ?> <?= $year; ?></h6>
        <?php $customer = $this->db->get_where('customer', ['no_services' => $no_services])->row_array() ?>
        <?= $customer['name']; ?> - <?= $no_services; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; ">Tanggal</th>
                        <th>Pemakaian</th>
                        <th>Last Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($x = 1; $x <= $jumHari;) { ?>
                        <tr>
                            <?php $usage = $this->mikrotik_m->usagethisdate($no_services, $x, $month, $year)->row_array() ?>
                            <td style="text-align: center"><?= $x++ ?></td>
                            <?php if ($usage['count_usage'] > 0) { ?>
                                <td style="text-align: center"><?= formatBites($usage['count_usage'], 2) ?></td>
                                <td style="text-align: center"><?= date('d M Y - H:i:s', $usage['last_update']) ?></td>
                            <?php } ?>
                            <?php if ($usage['count_usage'] == 0) { ?>
                                <td style="text-align: center">Not Recorded</td>
                                <td style="text-align: center"></td>
                            <?php } ?>
                            <?php $tanggal = date('Y') . '-' . date('m') . '-' . ($x - 1) ?>
                            <td style="text-align: center;"> <a href="#" id="editUsage" data-toggle="modal" data-target="#exampleModal" data-dateb="<?= $tanggal ?>" data-bytes="<?= $usage['count_usage'] ?>" data-noservices="<?= $no_services ?>"><i class="fa fa-edit"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pamakaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('mikrotik/editUsage') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="dateUsage">Tanggal</label>
                        <input type="text" id="dateUsage" name="dateUsage" class="form-control" readonly>
                        <input type="hidden" id="noservices" name="no_services" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="usage">Pemakaian</label> *<span style="font-size: smaller;">bytes</span>
                        <input type="number" id="bytes" name="usage" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.js"></script>
<!-- Page level plugins -->
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
<!-- bootstrap datepicker -->
<script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).on('click', '#editUsage', function() {

        $('#dateUsage').val($(this).data('dateb'))
        $('#bytes').val($(this).data('bytes'))
        $('#noservices').val($(this).data('noservices'))

    });
    $(document).ready(function() {
        $('#tablebt').DataTable({
            "lengthMenu": [
                [31],
                [31]
            ],
            dom: 'lBfrtip',
            buttons: [{
                    extend: ['copy'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['csv'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['excel'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['pdf'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: ['print'],
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],

        });

    });
</script>