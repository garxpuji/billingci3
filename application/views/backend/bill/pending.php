<!-- Page Heading -->
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>


<?php $this->view('messages') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Data Pending Payment </h6>
    </div>
    <div class="card-body">
        <a href="#" id="#filterbyModal" data-toggle="modal" data-target="#filterbyModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cube fa-sm text-white-50"></i> Filter by</a>
        <div class="row mb-2 mt-2">
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" class="btn btn-outline-secondary" id="btn-cetak"><i class="fa fa-dollar-sign"></i> Terima Pemabayaran</button>
            </div>

        </div>
        <div class="table-responsive mt-2">
            <form method="post" action="<?php echo base_url('bill/movependingselected') ?>" id="submit-cetak">

                <!-- <input type="hidden" name='invoice[]' id="result" size="60"> -->
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th><input type='checkbox' id="selectAll">
                            <th>No Invoice</th>
                            <th>No Layanan - Paket</th>
                            <th>Nama Pelanggan</th>
                            <th>No. Telp.</th>
                            <th>Periode</th>
                            <th>Tagihan</th>
                            <th>Tanggal Bayar</th>
                            <th>Operator</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($bill as $r => $data) { ?>
                            <tr>
                                <td style="text-align: center"><?= $no++ ?>.</td>
                                <td>
                                    <input type='checkbox' class='check-item' id="ceklis" name='invoice[]' value='<?= $data->invoice ?>'>
                                </td>
                                <td><?= $data->invoice ?></td>
                                <td>
                                    <?= $data->no_services ?>
                                    <hr>
                                    <?php $query = "SELECT *
                                    FROM `services`
                                        WHERE `services`.`no_services` = $data->no_services";
                                    $querying = $this->db->query($query)->result(); ?>
                                    <?php $nomor = 1;
                                    foreach ($querying as  $dataa) { ?>
                                        <?php $item = $this->db->get_where('package_item', ['p_item_id' => $dataa->item_id])->row_array(); ?>
                                        <?= $nomor++; ?>. <?= $item['name']; ?> - <?= indo_currency($item['price']); ?> <br>
                                    <?php } ?>
                                </td>
                                <td><?= $data->name ?></td>
                                <td><?= indo_tlp($data->no_wa) ?></td>
                                <td><?= indo_month($data->month); ?> <?= $data->year; ?></td>
                                <td><?= $data->amount; ?></td>
                                <td><?= date('d M Y h:i:s a', $data->date_payment); ?></td>
                                <td>
                                    <?php $getuser = $this->db->get_where('user', ['id' => $data->create_by])->row_array() ?>
                                    <?= $getuser['name']; ?>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
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
                <?php echo form_open_multipart('bill/filter') ?>
                <div class="form-group">
                    <label for="month">Bulan</label>
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

                <div class="form-group">
                    <label for="year">Tahun</label>
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
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control " style="width: 100%;" type="text" id="status" name="status" autocomplete="off">
                        <option value="">-Pilih-</option>
                        <option value="BELUM BAYAR">BELUM BAYAR</option>
                        <option value="SUDAH BAYAR">SUDAH BAYAR</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="coverage">Coverage Area</label>
                    <select name="coverage" id="coverage" class="form-control">
                        <option value="0">-Semua-</option>
                        <?php foreach ($coverage as $data) { ?>
                            <option value="<?= $data->coverage_id ?>"><?= $data->c_name ?></option>
                        <?php } ?>
                    </select>
                </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Filter</button>
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
<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);

            else // Jika checkbox all tidak diceklis
                $(".check-item").prop("checked", false);
        });

        $("#btn-cetak").click(function() {
            $('#submit-cetak').attr('action', '<?php echo base_url('bill/movependingselected') ?>');
            var confirm = window.confirm("Apakah Anda yakin akan memindahkan ke data pemasukan ?");
            if (confirm)
                $("#submit-cetak").submit();
        });


    });
</script>