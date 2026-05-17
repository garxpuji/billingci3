<?php $this->view('messages') ?>

<?php $cekbillisolir = $this->customer_m->getrecheckisolir($customer['router'], $customer['no_services'])->row_array();
if ($cekbillisolir > 0) {
    isolir($customer['no_services'], $customer['router']);
}
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h6 class="m-0 font-weight-bold">Data Pelanggan</h6>

                </div>
            </div>
            <div class="card-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col">Nama</div>
                            <div class="col">: <?= $customer['name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">No Layanan</div>
                            <div class="col">: <?= $customer['no_services']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">Tanggal Daftar </div>
                            <div class="col">: <?= indo_date($customer['register_date']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col">Area</div>
                            <?php $coverage = $this->db->get_where('coverage', ['coverage_id' => $customer['coverage']])->row_array() ?>
                            <div class="col">: <?= $coverage['c_name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">Router</div>
                            <?php $router = $this->db->get_where('router', ['id' => $customer['router']])->row_array() ?>
                            <div class="col">: <?= $router['alias']; ?></div>
                        </div>


                        <div class="row">
                            <div class="col">Mode</div>
                            <div class="col">: <?= $customer['mode_user']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col">User <?= $customer['mode_user']; ?></div>
                            <div class="col">: <?= $customer['user_mikrotik']; ?></div>
                        </div>

                        <?php $usage = $this->mikrotik_m->usagethismonth($customer['no_services'])->result();

                        $totalusage = 0;
                        foreach ($usage as $c => $usage) {
                            $totalusage += $usage->count_usage;
                        }
                        ?>
                        <div class="row">
                            <div class="col">Auto Isolir</div>

                            <div class="col">: <?= $customer['auto_isolir'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></div>
                        </div>

                        <?php if ($totalusage > 0) { ?>
                            <div class="row">
                                <div class="col">Pemakaian Bulan Ini </div>


                                <div class="col">: <?= formatBites($totalusage, 2); ?></div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col">ODC</div>
                            <?php $odc = $this->db->get_where('m_odc', ['id_odc' => $customer['id_odc']])->row_array() ?>
                            <div class="col">: <?= $odc['code_odc'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col">ODP</div>
                            <?php $odp = $this->db->get_where('m_odp', ['id_odp' => $customer['id_odp']])->row_array() ?>
                            <div class="col">: <?= $odp['code_odp'] ?> </div>
                        </div>
                        <div class="row">
                            <div class="col">Port ODP</div>

                            <div class="col">: <?= $customer['no_port_odp']; ?> </div>
                        </div>
                        <div class="row">
                            <div class="col">Keterangan</div>

                            <div class="col">: <?= $customer['cust_description']; ?> </div>
                        </div>


                        <div class="card-body">
                            <a href="<?= base_url('customer/add') ?>" class="btn btn-outline-success">Tambah Pelanggan</a>
                            <a href="<?= base_url('customer/edit/' . $customer['customer_id']) ?>" class="btn btn-outline-primary">Edit Pelanggan</a>
                            <a href="<?= base_url('customer/print/' . $customer['no_services']) ?>" class="btn btn-outline-secondary" target="blank">Cetak</a>
                            <a href="<?= base_url('services/detail/' . $customer['no_services']) ?>" class="btn btn-outline-danger">Detail Paket</a>
                            <a href="<?= base_url('mikrotik/client/' . $customer['no_services']) ?>" class="btn btn-outline-warning" target="blank">Koneksi</a>


                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($bill) > 0) { ?>





                <div class="" id="databillunpaid">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between ">
                            <h6 class="m-0 font-weight-bold">TAGIHAN BELUM DIBAYAR</h6>
                            <?php
                            $total = 0;
                            $totalcodeunique = 0;
                            foreach ($bill as $r => $data) {
                                $total += $data->amount;
                                $totalcodeunique += $data->code_unique;

                                if ($data->codeunique == 1) {
                                    $totalbill = $total + $totalcodeunique;
                                } else {
                                    $totalbill = $total;
                                };
                            }
                            ?>
                            <input type="hidden" id="amount" value="<?= $totalbill ?>">
                            <button class="btn btn-outline-danger"><?= indo_currency($totalbill); ?></button>

                        </div>
                        <span><?= number_to_words($totalbill) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="box box-primary">
                            <div class="box-body">
                                <h4>Rincian Tagihan</h4>
                                <?php
                                foreach ($bill as $r => $data) { ?>
                                    <div class="row">
                                        <div class="col">Periode </div>
                                        <div class="col">: <b> <?= indo_month($data->month); ?> <?= $data->year; ?></b></div>
                                    </div>
                                    <?php if ($data->codeunique == 1) {
                                        $codeunique = $data->code_unique;
                                    } else {
                                        $codeunique = 0;
                                    }; ?>
                                    <div class="row">
                                        <div class="col">Total Tagihan</div>
                                        <div class="col">: <?= indo_currency($data->amount + $codeunique); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Terhitung</div>
                                        <div class="col">: <?= number_to_words($data->amount + $codeunique); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col">Jatuh Tempo</div>
                                        <div class="col">: <?= indo_date($data->inv_due_date); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Tanggal Isolir</div>
                                        <div class="col">: <?= indo_date($data->date_isolir); ?></div>
                                    </div>
                                    <div class="row mt-1  align-items-center" style="text-align: center;">

                                        <div class="col">
                                            <a target="blnak" href="<?= base_url('bill/detail/' . $data->invoice) ?>" class="btn btn-outline-primary">Detail Invoice</a>
                                            <a data-toggle="modal" data-target="#ModalBayar<?= $data->invoice_id ?>" href="#" class="btn btn-outline-success">Bayar Tagihan</a>
                                        </div>

                                    </div>
                                    <hr>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>
    <?php
    foreach ($bill as $r => $data) { ?>

        <div class="modal fade" id="ModalBayar<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                        <input type="hidden" name="no_services" value="<?= $customer['no_services'] ?>" class="form-control">
                        <input type="hidden" name="invoice_id" value="<?= $data->invoice_id ?>" class="form-control">
                        <input type="hidden" name="invoice" value="<?= $data->invoice ?>" class="form-control">
                        <input type="hidden" name="month" value="<?= indo_month($data->month) ?>" class="form-control">
                        <input type="hidden" name="name" value="<?= $customer['name'] ?>" class="form-control">
                        <input type="hidden" name="email_customer" value="<?= $customer['email'] ?>" class="form-control">
                        <input type="hidden" name="periode" value="<?= indo_month($data->month) ?> <?= $data->year ?>" class="form-control">
                        <input type="hidden" name="agen" value="<?= $user['name'] ?>" class="form-control">

                        <input type="hidden" name="year" value="<?= $data->year ?>" class="form-control">
                        <input type="hidden" name="date_payment" value="<?= date('Y-m-d') ?>" class="form-control">
                        <!-- PPN -->



                        Apakah yakin tagihan dengan no layanan <?= $customer['no_services'] ?> a/n <?= $customer['name'] ?> Periode <span id="peri"></span> sudah terbayarkan ?,


                        <div class="form-group mt-2">
                            <label for="">Nominal</label>
                            <input type="hidden" name="nominal" value="<?= $data->amount ?>" class="form-control">
                            <input type="text" id="shownominal" value="<?= $data->amount ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Metode Pembayaran</label>
                            <select name="metode_payment" id="" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Cash"> Cash </option>
                                <option value="Transfer">Transfer</option>
                                <option value="Payment Gateway">Payment Gateway</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="category" id="" class="form-control" required>
                                <?php $category = $this->db->get('cat_income')->result() ?>
                                <?php foreach ($category as $data) { ?>
                                    <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <div class="form-group">
                                <label for="">Diterima Oleh</label>
                                <select name="create_by" class="form-control select2" style="width: 100%;" required>
                                    <option value="<?= $this->session->userdata('id') ?>"><?= $this->session->userdata('name') ?></option>
                                    <?php $receipt = $this->bill_m->getreceipt()->result() ?>
                                    <?php foreach ($receipt as $data) { ?>
                                        <option value="<?= $data->id ?>"><?= $data->name ?> -
                                            <?= $data->role_id == 1 ? 'Admin' : '' ?>
                                            <?= $data->role_id == 2 ? 'Pelanggan' : '' ?>
                                            <?= $data->role_id == 3 ? 'Operator' : '' ?>
                                            <?= $data->role_id == 4 ? 'Mitra' : '' ?>
                                            <?= $data->role_id == 5 ? 'Teknisi' : '' ?>
                                            <?= $data->role_id == 6 ? 'Outlet' : '' ?>
                                            <?= $data->role_id == 7 ? 'Kolektor' : '' ?>
                                            <?= $data->role_id == 8 ? 'Finance' : '' ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->userdata('role_id') != 1) { ?>
                            <input type="hidden" name="create_by" value="<?= $this->session->userdata('id') ?>">
                        <?php } ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" id="click-me" class="btn btn-success">Ya, Lanjutkan</button>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

    <div class="col-lg-6" id="databillhistory">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Riwayat Tagihan <span id="year"><?= date('Y'); ?></span></h6>
            </div>
            <input type="hidden" id="no_services" value="<?= $customer['no_services'] ?>">
            <div class="row ml-4">
                <div class="col-md-0 mt-2">
                    <label class="col-sm-12 col-form-label">Tahun</label>
                </div>
                <div class="col-sm-3  mt-3">
                    <select class="form-control" style="width: 100%;" name="year" id="selectyear" onchange="selectyear()">
                        <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                        <?php
                        for ($i = date('Y'); $i >= 2018; $i -= 1) {
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="card-body">
                <div class="container" id="loading1">
                    <div class="text-center">
                        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="" id="datahistory"></div>

            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $(document).ready(function() {
        getbillhistory();

        function getbillhistory() {
            var no_services = $("#no_services").val();
            var year = $("#selectyear").val();

            $.ajax({
                type: 'POST',
                data: "&no_services=" + no_services + "&year=" + year,
                url: '<?= site_url('bill/gethistorybill') ?>',
                cache: false,
                success: function(data) {
                    $("#loading1").hide();
                    $("#datahistory").html(data);

                }
            });
        }
        return false;
    })

    function selectyear() {
        var no_services = $("#no_services").val();
        var year = $("#selectyear").val();
        $.ajax({
            type: 'POST',
            data: "&no_services=" + no_services + "&year=" + year,
            url: '<?= site_url('bill/gethistorybill') ?>',
            cache: false,
            beforeSend: function() {
                $("#loading1").html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
            },
            success: function(data) {
                $("#loading1").hide();
                $("#year").html(year);
                $("#datahistory").html(data);
            }
        });
        return false;
    }
</script>