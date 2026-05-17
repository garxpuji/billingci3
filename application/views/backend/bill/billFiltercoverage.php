<?php $this->view('messages') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Data Tagihan </h6>
    </div>
    <div class="card-body">
        <a href="#" id="#filterbyModal" data-toggle="modal" data-target="#filterbyModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cube fa-sm text-white-50"></i> Filter by</a>
        <div class="row mb-2 mt-2">
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" class="btn btn-outline-secondary" id="btn-cetak"><i class="fa fa-print"></i> A4 Yang Dipilih</button>
            </div>
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" class="btn btn-outline-secondary" id="btn-cetak-thermal"><i class="fa fa-print"></i> Thermal Yang Dipilih</button>
            </div>
            <div class="col-lg-3 col-sm-6 mb-2 col-md-4 text-left">
                <button href="" class="btn btn-outline-danger" id="btn-del-selected"><i class="fa fa-trash"></i> Hapus Yang Dipilih</button>
            </div>
            <?php $wa = $this->db->get('whatsapp')->row_array() ?>
            <?php if ($wa['is_active'] == 1) { ?>
                <?php if ($this->input->post('status') == 'BELUM BAYAR') { ?>
                    <div class="col-lg-2 col-sm-6 mb-2 col-md-4 text-left">
                        <button href="" class="btn btn-outline-success" id="btn-wa-selected"><i class="fab fa-whatsapp"></i> Kirim Tagihan Yang Dipilih</button>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="table-responsive">
            <form method="post" action="<?php echo base_url('bill/printinvoiceselected') ?>" id="submit-cetak">
                <form method="post" action="<?php echo base_url('bill/printinvoiceselected') ?>" id="submit-cetak-thermal">
                    <!-- <input type="hidden" name='invoice[]' id="result" size="60"> -->
                    <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th style="text-align: center; width:20px">No</th>
                                <th>
                                </th>
                                <th>No Layanan</th>
                                <th>Nama Pelanggan</th>
                                <th>No. Telp.</th>
                                <th>Periode</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Alamat</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1;
                            foreach ($bill as $r => $data) { ?>
                                <!-- JATUH TEMPO -->
                                <?php if (strlen($data->due_date) == 1) { ?>
                                    <?php $due_date = '0' . $data->due_date ?>
                                <?php } ?>
                                <?php if (strlen($data->due_date) != 1) { ?>
                                    <?php $due_date = $data->due_date ?>
                                <?php } ?>

                                <?php $cekduedate = $data->year . '-' . $data->month . '-' . $due_date ?>
                                <?php if (date('Y-m-d') >= $cekduedate) {
                                    $bg = 'yellow';
                                    $text = 'black';
                                } else {
                                    $bg = '';
                                    $text = '';
                                } ?>
                                <tr style="background-color: <?php if ($data->status == 'BELUM BAYAR') { ?>
                                <?= $bg ?>; color:<?= $text ?>
                                <?php } ?>
                                ">
                                    <td style="text-align: center"><?= $no++ ?>.</td>
                                    <td>
                                        <input type='checkbox' class='check-item' id="ceklis" name='invoice[]' value='<?= $data->invoice ?>'>
                                    </td>
                                    <td style="text-align: center"><?= $data->no_services ?> <br>
                                        <?php if ($data->status == 'BELUM BAYAR') { ?>
                                            <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#selectpaper<?= $data->invoice_id ?>" title="Print Invoice" style="font-size: smaller"> <i class="fa fa-print"> Invoice</i> </a>
                                        <?php } ?>
                                        <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                            <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#selectpaper<?= $data->invoice_id ?>" title="Print Invoice" style="font-size: smaller"> <i class="fa fa-print"> Invoice</i> </a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $data->name ?></td>
                                    <td><?= $data->no_wa ?></td>
                                    <td>
                                        <?= indo_month($data->month) ?>
                                        <?= $data->year ?></td>


                                    <?php if ($title == 'Belum Bayar') { ?>
                                        <td><?= $due_date; ?> <?= indo_month($data->month) ?>
                                            <?= $data->year ?></td>
                                    <?php } ?>
                                    <!-- KODE UNIK -->
                                    <?php if ($data->codeunique == 1) { ?>
                                        <?php $code_unique = $data->code_unique ?>
                                    <?php } ?>
                                    <?php if ($data->codeunique == 0) { ?>
                                        <?php $code_unique = 0 ?>
                                    <?php } ?>
                                    <!-- END KODE UNIK -->
                                    <!-- PPN -->
                                    <?php if ($data->i_ppn > 0) { ?>
                                        <?php $ppn = $data->amount * ($data->i_ppn / 100) ?>
                                    <?php } ?>
                                    <?php if ($data->i_ppn == 0) { ?>
                                        <?php $ppn = 0 ?>
                                    <?php } ?>
                                    <!-- END PPN -->
                                    <td style="font-weight: bold;text-align: center">
                                        <?php if ($data->amount == 0) { ?>
                                            Tagihan Ini Versi Lama
                                        <?php } ?>
                                        <?php if ($data->amount != 0) { ?>
                                            <?= indo_currency($data->amount + $code_unique); ?>
                                        <?php } ?>
                                    </td>
                                    <?php $totaltagihan = $data->amount + $code_unique; ?>
                                    <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                        <td style="text-align: center; font-weight:bold; color:green; font-size:small"> <?= $data->status  ?></td>
                                    <?php } ?>
                                    <?php if ($data->status == 'BELUM BAYAR') { ?>
                                        <td style="text-align: center; font-weight:bold; color:red; font-size:small"> <?= $data->status  ?></td>
                                    <?php } ?>
                                    <td><?= $data->address ?></td>
                                    <?php $query = "SELECT *
                                    FROM `bank`";
                                    $bank = $this->db->query($query)->result(); ?>


                                    <td style="text-align: center">
                                        <?php if ($data->status == 'BELUM BAYAR') { ?>
                                            <a href="" data-toggle="modal" data-target="#BayarModal<?= $data->invoice_id ?>"><i class="fas fa-money-bill-alt" title="Bayar" style="font-size:25px;"> </i></a>
                                        <?php } ?>
                                        <a href="<?= site_url('bill/detail/' . $data->invoice) ?>" title="Lihat"><i class="fa fa-eye" style="font-size:25px; color:<?= $text ?>"></i></a>
                                        <?php
                                        $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                                        $replace = array($data->name, $data->no_services, $data->month, $data->year, indo_month($data->month) . ' ' . $data->year, $company['due_date'], $totaltagihan, $company['company_name'], $company['sub_name'], base_url(), '%0A');
                                        $subject = $other['thanks_wa'];
                                        $subjectunpaid = $other['say_wa'];
                                        $messagepaid = str_replace($search, $replace, $subject);
                                        $messageunpaid = str_replace($search, $replace, $subjectunpaid);

                                        ?>
                                        <?php if ($wa['is_active'] == 1) { ?>
                                            <?php if ($data->status == 'BELUM BAYAR') { ?>
                                                <a href="<?= site_url('whatsapp/sendbillunpaid/' . $data->invoice) ?>" title="Kirim Notifikasi"><i class="fab fa-whatsapp" style="font-size:25px; color:green"></i></a>
                                            <?php } ?>
                                            <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                                <a href="<?= site_url('whatsapp/sendbillpaid/' . $data->invoice) ?>" title="Kirim Terimakasih"><i class="fab fa-whatsapp" style="font-size:25px; color:green"></i></a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($wa['is_active'] == 0) { ?>
                                            <?php if ($data->status == 'BELUM BAYAR') { ?>
                                                <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($data->no_wa) ?>&text=<?= $messageunpaid ?>" target="blank" title="Kirim Notifikasi"><i class="fab fa-whatsapp" style="font-size:25px; color:green"></i></a>
                                            <?php } ?>
                                            <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                                <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($data->no_wa) ?>&text=<?= $messagepaid ?>" target="blank" title="Kirim Terimakasih"><i class="fab fa-whatsapp" style="font-size:25px; color:green"></i></a>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                                            <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->invoice_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                    </td>
                                <?php } ?>
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
<?php
foreach ($bill as $r => $data) { ?>
    <div class="modal fade" id="BayarModal<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <!-- KODE UNIK -->
                    <?php if ($data->codeunique == 1) { ?>
                        <?php $code_unique = $data->code_unique ?>
                    <?php } ?>
                    <?php if ($data->codeunique == 0) { ?>
                        <?php $code_unique = 0 ?>
                    <?php } ?>
                    <!-- END KODE UNIK -->
                    <!-- PPN -->
                    <?php if ($data->i_ppn > 0) { ?>
                        <?php $ppn = $data->amount * ($data->i_ppn / 100) ?>
                    <?php } ?>
                    <?php if ($data->i_ppn == 0) { ?>
                        <?php $ppn = 0 ?>
                    <?php } ?>
                    <!-- END PPN -->

                    <?php $totaltagihan = $data->amount; ?>
                    <input type="hidden" name="invoice_id" value="<?= $data->invoice_id ?>" class="form-control">
                    <input type="hidden" name="invoice" value="<?= $data->invoice ?>" class="form-control">
                    <input type="hidden" name="month" value="<?= indo_month($data->month) ?>" class="form-control">
                    <input type="hidden" name="name" value="<?= $data->name ?>" class="form-control">
                    <input type="hidden" name="email_customer" value="<?= $data->email ?>" class="form-control">
                    <input type="hidden" name="periode" value="<?= indo_month($data->month) ?> <?= $data->year ?>" class="form-control">
                    <input type="hidden" name="agen" value="<?= $user['name'] ?>" class="form-control">
                    <input type="hidden" name="email_agen" value="<?= $this->session->userdata('email') ?>" class="form-control">
                    <input type="hidden" name="to_email" value="<?= $company['email'] ?>" class="form-control">
                    <input type="hidden" name="year" value="<?= $data->year ?>" class="form-control">
                    <input type="hidden" name="date_payment" value="<?= date('Y-m-d') ?>" class="form-control">

                    <input type="hidden" name="nominal" value="<?= $totaltagihan ?>" class="form-control">

                    <input type="hidden" name="no_services" value="<?= $data->no_services ?>" class="form-control">
                    Apakah yakin tagihan dengan no layanan <?= $data->no_services ?> a/n <b><?= $data->name ?></b> Periode <?= indo_month($data->month) ?> <?= $data->year ?> sudah terbayarkan ?,
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Lanjutkan</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
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
                                <?php
                                for ($i = date('Y'); $i >= date('Y') - 2; $i -= 1) {
                                ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
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

<!-- Modal Hapus -->
<?php
foreach ($bill as $r => $data) { ?>
    <div class="modal fade" id="DeleteModal<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="invoice_id" value="<?= $data->invoice_id ?>" class="form-control">
                    <input type="hidden" name="invoice" value="<?= $data->invoice ?>" class="form-control">
                    Apakah yakin akan hapus Tagihan <?= $data->no_services ?> A/N <?= $data->name ?> ?
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php foreach ($bill as $r => $data) { ?>
    <div class="modal fade" id="selectpaper<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row container mb-3">No layanan <?= $data->no_services ?> a/n <b> &nbsp;<?= $data->name ?></b>
                        <br>
                        Pilih Ukuran Kertas
                    </div>
                    <div class="row text-center">
                        <?php if ($data->status == 'BELUM BAYAR') { ?>
                            <div class="col">
                                <a href="<?= site_url('bill/printinvoice/' . $data->invoice) ?>" target="blank" class="btn btn-outline-danger" style="font-size: smaller"><i class="fa fa-print"> A4</i></a>
                            </div>
                            <div class="col">
                                <a href="<?= site_url('bill/printinvoicethermal/' . $data->invoice) ?>" target="blank" class="btn btn-outline-danger" style="font-size: smaller"><i class="fa fa-print"> Thermal</i></a>
                            </div>
                        <?php } ?>
                        <?php if ($data->status == 'SUDAH BAYAR') { ?>
                            <div class="col">
                                <a href="<?= site_url('bill/printinvoice/' . $data->invoice) ?>" target="blank" class="btn btn-outline-success" style="font-size: smaller"><i class="fa fa-print"> A4</i></a>
                            </div>
                            <div class="col">
                                <a href="<?= site_url('bill/printinvoicethermal/' . $data->invoice) ?>" target="blank" class="btn btn-outline-success" style="font-size: smaller"><i class="fa fa-print"> Thermal</i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
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
        $('#btn-del-selected').click(function() {
            $('#submit-cetak').attr('action', '<?php echo base_url('bill/delselected') ?>');
            var confirm = window.confirm("Apakah Anda yakin ingin hapus tagihan yang terpilih ?");
            if (confirm)
                $("#submit-cetak").submit();
        });
        $('#btn-wa-selected').click(function() {
            $('#submit-cetak').attr('action', '<?php echo base_url('bill/sendwaselected') ?>');
            var confirm = window.confirm("Apakah Anda yakin akan kirim tagihan yang terpilih ?");
            if (confirm) {
                $("#submit-cetak").submit();
                $("#popup").modal("show");
            } else {

            }

        });
    });
</script>