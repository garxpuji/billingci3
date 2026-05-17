<?php
// $jumHari = cal_days_in_month(CAL_GREGORIAN, 2, 2022);
// echo "Ada " . $jumHari . " hari dalam bulan Pebruari tahun 1804";
$date = date('d');
?>
<div class="col-lg-12">
    <div class="card shadow mb-2">
        <div class="card-header py-1">
            <h6 class="m-0 font-weight-bold">Pemakaian Internet </h6>
            <span>Hanya menampilkan data 2 bulan terakhir</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Nama Pelanggan</label>
                            <div class="col-sm-12">
                                <select class="form-control select2" name="no_services" id="no_services" style="width: 100%;" onchange="cek_data()" required>
                                    <option value="">-Pilih-</option>
                                    <?php
                                    foreach ($customer as $r => $data) { ?>
                                        <option value="<?= $data->no_services ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Bulan </label>
                            <div class="col-sm-9">
                                <select class="form-control select2" style="width: 100%;" name="month" id="month" onchange="cek_data()" required>
                                    <option value="<?= date('m') ?>"><?= indo_month(date('m')) ?></option>
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
                <div class="col-md-3">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tahun </label>
                            <div class="col-sm-9">
                                <select class="form-control select2" style="width: 100%;" name="year" id="year" onchange="cek_data()" required>
                                    <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                    <?php
                                    for ($i = date('Y'); $i >=  date('Y') - 1; $i -= 1) {
                                    ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
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
<div class="loading"></div>
<div class="view_data"></div>
<?php if ($no_services != '') { ?>
    <div class="card shadow mb-4 mt-3" id="self-usage">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Pemakaian Internet Harian Bulan <?= indo_month(date('m')); ?> <?= date('Y'); ?></h6> <br>
            <?php $customer = $this->db->get_where('customer', ['no_services' => $no_services])->row_array() ?>
            <?= $customer['name']; ?> - <?= $no_services; ?>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="tablebtt" width="100%" cellspacing="0">
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
                        for ($x = 1; $x <= $date;) { ?>
                            <tr>
                                <?php $usage = $this->mikrotik_m->usagethisdate($no_services, $x, date('m'), date('Y'))->row_array() ?>
                                <td style="text-align: center"><?= $x++ ?></td>
                                <?php if ($usage['count_usage'] > 0) { ?>
                                    <td style="text-align: center"><?= formatBites($usage['count_usage'], 2) ?> </td>
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
<?php } ?>
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
<script>
    $(document).on('click', '#editUsage', function() {

        $('#dateUsage').val($(this).data('dateb'))
        $('#bytes').val($(this).data('bytes'))
        $('#noservices').val($(this).data('noservices'))

    });

    function cek_data() {
        var no_services = $("#no_services").val();
        var month = $("#month").val();
        var year = $("#year").val();

        if (no_services == '') {
            alert('No Layanan Pelanggan belum dipilih');
            $('#no_services').focus();
        } else {

            $.ajax({
                type: 'POST',
                data: "&no_services=" + no_services + "&month=" + month + "&year=" + year,
                cache: false,
                url: '<?= site_url('mikrotik/getusage') ?>',
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
                    $('#self-usage').hide();

                }

            });
        }
        return false;
    }
</script>

<script>
    $(document).ready(function() {
        $('#tablebtt').DataTable({
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