<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php if ($this->session->userdata('role_id') == 1) { ?>
        <a href="" id="#addModal" data-toggle="modal" data-target="#addModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
        <a href="" id="#billGenerate" data-toggle="modal" data-target="#billGenerate" class="d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-gear fa-sm text-white-50"></i> Generate</a>
    <?php } ?>
</div>
<?php $this->view('messages') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Filter Tagihan </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('bill/filter'); ?>" method="post">
            <div class="form-group row">
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Bulan</label>
                </div>
                <div class="col-sm-3 mt-2 ">
                    <select id="month" name="month" class="form-control" required>
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
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Tahun</label>
                </div>
                <div class="col-sm-3  mt-2">
                    <select class="form-control " style="width: 100%;" type="text" id="year" name="year" autocomplete="off" required>
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
                <div class="col-sm-3 mt-2">
                    <button class="btn btn-primary mb-2 my-2 my-sm-0" type="submit">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Data Tagihan </h6>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" class="btn btn-outline-secondary" id="btn-cetak"><i class="fa fa-print"></i> A4 Yang Dipilih</button>
            </div>
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" class="btn btn-outline-secondary" id="btn-cetak-thermal"><i class="fa fa-print"></i> Thermal Yang Dipilih</button>
            </div>
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <a href="" data-toggle="modal" data-target="#cetakblmbayar" target="blank" class="btn btn-outline-danger"><i class="fa fa-print"></i> Semua Belum Bayar</a>
            </div>
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <a href="" data-toggle="modal" data-target="#cetaksdhbayar" target="blank" class="btn btn-outline-success"><i class="fa fa-print"></i> Semua Sudah Bayar</a>
            </div>
        </div>
        <div class="table-responsive">
            <form method="post" action="<?php echo base_url('bill/printinvoiceselected') ?>" target="blank" id="submit-cetak">
                <form method="post" action="<?php echo base_url('bill/printinvoiceselected') ?>" target="blank" id="submit-cetak-thermal">
                    <input type="hidden" name='invoice[]' id="result" size="60">
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th style="text-align: center; width:20px">No</th>
                                <th></th>
                                <th>Print</th>
                                <th>No Invoice</th>
                                <th>No Layanan</th>
                                <th>Nama Pelanggan</th>
                                <th>No. Telp.</th>
                                <th>Periode</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>


                        </tbody>
                    </table>
                </form>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/addBill') ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Bulan</label>
                            <input type="hidden" name="invoice" value="<?= $invoice ?>">
                            <select class="form-control select2" style="width: 100%;" name="month" required>
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
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tahun</label>
                            <select class="form-control select2" style="width: 100%;" name="year" required>
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
                <div class="form-group">
                    <label for="name">No Layanan - Nama Pelanggan</label>
                    <select class="form-control select2" name="no_services" id="no_services" onchange="cek_data()" style="width: 100%;" required>
                        <option value="">-Pilih-</option>
                        <?php
                        foreach ($customer as $r => $data) { ?>
                            <option value="<?= $data->no_services ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nominal">Rincian Tagihan</label>
                    <div class="loading"></div>
                    <div class="view_data"></div>
                </div>
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
<div class="modal fade" id="ModalBayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bayar Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/billpaid') ?>

                <input type="hidden" id="no_servicess" name="no_services" class="form-control">
                <input type="hidden" id="invoice_id" name="invoice_id" class="form-control">
                <input type="hidden" id="invoice" name="invoice" class="form-control">
                <input type="hidden" id="monthh" name="month" class="form-control">
                <input type="hidden" id="name" name="name" class="form-control">
                <input type="hidden" id="email_customer" name="email_customer" class="form-control">
                <input type="hidden" id="periode" name="periode" class="form-control">
                <input type="hidden" id="agen" name="agen" value="<?= $user['name'] ?>" class="form-control">
                <input type="hidden" id="email_agen" name="email_agen" value="<?= $this->session->userdata('email') ?>" class="form-control">
                <input type="hidden" id="to_email" name="to_email" value="<?= $company['email'] ?>" class="form-control">
                <input type="hidden" id="yearr" name="year" class="form-control">
                <input type="hidden" id="date_payment" name="date_payment" value="<?= date('Y-m-d') ?>" class="form-control">
                <!-- PPN -->

                <input type="hidden" id="nominal" name="nominal" class="form-control">

                Apakah yakin tagihan dengan no layanan <span id="servic"></span> a/n <span id="nam"></span> Periode <span id="peri"></span> sudah terbayarkan ?,

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Lanjutkan</button>
                </div>
                <?php echo form_close() ?>
            </div>

        </div>
    </div>
</div>
<!-- Modal Hapus -->


<div class="modal fade" id="cetakblmbayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row container mb-3">
                    Pilih Ukuran Kertas
                </div>
                <div class="row text-center">
                    <div class="col">
                        <a href="<?= site_url('bill/printinvoiceunpaid') ?>" target="blank" class="btn btn-outline-danger" style="font-size: smaller"><i class="fa fa-print"> A4</i></a>
                    </div>
                    <div class="col">
                        <a href="<?= site_url('bill/printinvoiceunpaidthermal') ?>" target="blank" class="btn btn-outline-danger" style="font-size: smaller"><i class="fa fa-print"> Thermal</i></a>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cetaksdhbayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row container mb-3">
                    Pilih Ukuran Kertas
                </div>
                <div class="row text-center">
                    <div class="col">
                        <a href="<?= site_url('bill/printinvoicepaid') ?>" target="blank" class="btn btn-outline-success" style="font-size: smaller"><i class="fa fa-print"> A4</i></a>
                    </div>
                    <div class="col">
                        <a href="<?= site_url('bill/printinvoicepaidthermal') ?>" target="blank" class="btn btn-outline-success" style="font-size: smaller"><i class="fa fa-print"> Thermal</i></a>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="billGenerate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/generateBill') ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Bulan</label>
                            <input type="hidden" name="invoice" value="<?= $invoice ?>">
                            <select class="form-control select2" style="width: 100%;" name="month" required>
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
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tahun</label>
                            <select class="form-control select2" style="width: 100%;" name="year" required>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Lanjutkan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/delete') ?>
                <input type="hidden" id="invoice_idd" name="invoice_id" class="form-control">
                <input type="hidden" id="invoicee" name="invoice" class="form-control">
                <input type="hidden" id="monthhh" name="month" class="form-control">
                <input type="hidden" id="yearrr" name="year" class="form-control">
                <input type="hidden" id="no_servicesss" name="no_services" class="form-control">
                Apakah yakin akan hapus tagihan <span id="noservices"></span> <span id="periodee"> </span> Periode <span id="period"></span> A/N <span id="namee"></span> ?
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });

    function cek_data() {
        no_services = $('[name="no_services"]');
        $.ajax({
            type: 'POST',
            data: "cek_data=" + 1 + "&no_services=" + no_services.val(),
            url: '<?= site_url('bill/view_data') ?>',
            cache: false,

            beforeSend: function() {
                no_services.attr('disabled', true);
                $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
            },
            success: function(data) {
                no_services.attr('disabled', false);
                $('.loading').html('');
                $('.view_data').html(data);
            }

        });
        return false;
    }
</script>
<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);

            else // Jika checkbox all tidak diceklis
                $(".check-item").prop("checked", false);
        });

        $("#btn-cetak").click(function() {
            $('#submit-cetak').attr('action', '<?php echo base_url('bill/printinvoiceselected') ?>');
            var confirm = window.confirm("Apakah Anda yakin ingin cetak tagihan yang terpilih ?");
            if (confirm)
                $("#submit-cetak").submit();
        });

        $('#btn-cetak-thermal').click(function() {
            $('#submit-cetak').attr('action', '<?php echo base_url('bill/printinvoiceselectedthermal') ?>');
            var confirm = window.confirm("Apakah Anda yakin ingin cetak tagihan yang terpilih ?");
            if (confirm)
                $("#submit-cetak").submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('serverside/getDataInvoice'); ?>",
                "type": "POST"
            },

        });
    });
</script>
<script>
    $(document).on('click', '#bayar', function() {
        $('#no_servicess').val($(this).data('no_servicess'))
        $('#invoice_id').val($(this).data('invoice_id'))
        $('#invoice').val($(this).data('invoice'))
        $('#monthh').val($(this).data('month'))
        $('#name').val($(this).data('name'))
        $('#email_customer').val($(this).data('email_customer'))
        $('#periode').val($(this).data('periode'))
        $('#yearr').val($(this).data('yearr'))
        $('#nominal').val($(this).data('nominal'))
        $('#nam').html($(this).data('name'))
        $('#servic').html($(this).data('no_servicess'))
        $('#peri').html($(this).data('periode'))
    })
</script>
<script>
    $(document).on('click', '#hapusmodal', function() {
        $('#no_servicesss').val($(this).data('no_servicess'))
        $('#invoice_idd').val($(this).data('invoice_id'))
        $('#invoicee').val($(this).data('invoice'))
        $('#monthhh').val($(this).data('month'))
        $('#noservices').html($(this).data('no_servicess'))
        $('#namee').html($(this).data('name'))
        $('#period').html($(this).data('periode'))

        $('#yearrr').val($(this).data('yearr'))

    })
</script>