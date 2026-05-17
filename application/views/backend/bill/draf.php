<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Tagihan Bulan <?= indo_month(date('m')) ?> <?= date('Y') ?> <sup style="color: red;">Draf </sup> <a href="" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-info-circle" style="font-size: 24px"></i></a></h6>
    </div>

    <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left mt-2">
        <button href="" class="btn btn-outline-primary" id="btn-del-selected"><i class="fa fa-task"></i> Simpan Tagihan Yang Dipilih</button>
    </div>
    <div class="card-body">
        <?php $month = date('m');
        $year = date('Y');
        $query = "SELECT *
                                    FROM `invoice`
                                        WHERE  `invoice`.`month` = $month and `invoice`.`year` = $year";
        $cekbillthismonth = $this->db->query($query)->row_array();
        // var_dump($cekbillthismonth)
        ?>
        <?php if ($cekbillthismonth <= 0) { ?>
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" data-toggle="modal" data-target="#addModalGenerate" class="btn btn-outline-success"><i class="fa fa-save"></i> Simpan Semua</button>
            </div>
        <?php } ?>
        <a href="#" id="#filterbyModal" data-toggle="modal" data-target="#filterbyModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cube fa-sm text-white-50"></i> Filter by</a>
        <input type="hidden" name="coverage" id="coverage" value="<?= $this->input->post('coverage') ?>">
        <input type="hidden" name="router" id="router" value="<?= $this->input->post('router') ?>">
        <div class="table-responsive mt-3">
            <form method="post" action="" id="submit-cetak">
                <input type="hidden" name="invoice" value="<?= $invoice ?>">
                <input type="hidden" name="month" value="<?= date('m') ?>">
                <input type="hidden" name="year" value="<?= date('Y') ?>">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th><input type='checkbox' class='check-item' id="selectAll"></th>
                            <th>No Layanan</th>
                            <th>Nama</th>
                            <th style="text-align:center">Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <th data-order="true">Status</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addModalGenerate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/generateBill') ?>
                <input type="hidden" name="invoice" value="<?= $invoice ?>">
                <input type="hidden" name="month" value="<?= date('m') ?>">
                <input type="hidden" name="year" value="<?= date('Y') ?>">
                Apakah anda yakin akan simpan semua tagihan ?
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Lanjutkan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- Bill Save -->


<div class="modal fade" id="SaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Simpan Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/addBillDraf') ?>
                <input type="hidden" name="no_services" id="no_services" class="form-control">
                <input type="hidden" name="month" value="<?= date('m') ?>" class="form-control">
                <input type="hidden" name="invoice" value="<?= $invoice ?>">
                <input type="hidden" name="discount" value="0">
                <input type="hidden" name="year" value="<?= date('Y') ?>" class="form-control">
                Simpan Tagihan No Layanan <span id="no_servicess"></span> A/N <span id="name"></span> Periode <?= indo_month(date('m')) ?> <?= date('Y') ?> ?
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" style="font-size: 24px"></i> Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <li>Halaman ini adalah draf Tagihan semua pelanggan setiap pergantian bulan</li>
                <li>Jika status tagihan belum disimpan, maka pelanggan tidak akan bisa cek tagihan </li>
                <li>Tombol <button class="btn btn-outline-success" style="font-size: 10px;">Simpan Semua</button> akan berfungsi jika semua status tagihan belum disimpan</li>
                <li>Jika ada pelanggan baru setelah klik simpan semua / generate, maka cukup klik saja tombol save <i class="fa fa-save"></i></li>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filterbyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter By</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/filterdraf') ?>

                <div class="form-group">
                    <label for="coverage">Coverage Area</label>
                    <select name="coverage" id="coverage" class="form-control">
                        <option value="0">-Semua-</option>
                        <?php foreach ($coverage as $data) { ?>
                            <option value="<?= $data->coverage_id ?>"><?= $data->c_name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php if ($role['role_id'] == 1 or $role['coverage_operator'] == 0) { ?>
                    <div class="form-group">
                        <?php $listrouter = $this->db->get('router')->result() ?>
                        <label for="router">Router</label>
                        <select name="router" id="router" class="form-control">
                            <option value="0">-Semua-</option>
                            <?php foreach ($listrouter as $router) { ?>
                                <option value="<?= $router->id ?>"><?= $router->alias; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                <?php } ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
    $("#selectAll").click(function() {
        if ($(this).is(":checked"))
            $(".check-item").prop("checked", true);
        else // Jika checkbox all tidak diceklis
            $(".check-item").prop("checked", false);
    });
    $('#btn-del-selected').click(function() {
        $('#submit-cetak').attr('action', '<?php echo base_url('bill/generateselected') ?>');
        var confirm = window.confirm("Apakah Anda yakin akan menyimpan tagihan yang terpilih ?");
        if (confirm)
            $("#submit-cetak").submit();
    });
</script>
<?php if ($title == 'Bill Draf') { ?>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                // "bLengthChange": false,
                "lengthChange": true,
                "searching": false,
                "searching": {
                    "regex": true
                },
                "info": true,
                "autoWidth": true,
                "responsive": true,
                // "order": [],
                "ajax": {
                    "url": "<?= base_url('bill/getbilldraf'); ?>",
                    "type": "POST",
                    "dataType": "json",

                },
                // "columnDefs": table,
                "columnDefs": [{
                    "targets": [1, 4, 6],
                    "orderable": false
                }],
                "lengthMenu": [
                    [10, 25, 50, 100, 250, 500, 1000],
                    [10, 25, 50, 100, 250, 500, 1000]
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

                "language": {
                    "emptyTable": "No data available in table",
                    "zeroRecords": "No data available in table",
                    "info": "Showing <b>_START_</b> to <b>_END_ of _TOTAL_</b> entries",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    },
                    search: "_INPUT_",
                    searchPlaceholder: "No Layanan"
                },

            });
        });
        $(document).on('click', '#savebill', function() {
            $('#no_services').val($(this).data('no_services'))
            $('#no_servicess').html($(this).data('no_services'))

            $('#name').html($(this).data('name'))

        })
    </script>
<?php } ?>

<?php if ($title == 'Filter Draf') { ?>
    <script>
        $(document).ready(function() {
            var coverage = $("#coverage").val();
            var router = $("#router").val();
            console.log(router);
            $('#example').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, 250, 500, 1000],
                    [10, 25, 50, 100, 250, 500, 1000]
                ],
                "processing": true,
                "serverSide": true,
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                // "order": [],
                "ajax": {
                    "url": "<?= base_url('bill/getfilterbilldraf/') ?>" + "/" + Math.random(),
                    data: {
                        coverage: coverage,
                        router: router,
                    },
                    // "data": "&coverage=" + coverage + "&router=" + router,
                    "type": "POST",
                },
                "columnDefs": [{
                    "targets": [1, 4, 5, 6],
                    "orderable": false
                }]
            });
        });
        $(document).on('click', '#savebill', function() {
            $('#no_services').val($(this).data('no_services'))
            $('#no_servicess').html($(this).data('no_services'))

            $('#name').html($(this).data('name'))

        })
    </script>
<?php } ?>