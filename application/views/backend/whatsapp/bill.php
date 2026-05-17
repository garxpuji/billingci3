<?php //==============================START=========================================//
/*
     *  Base Code   : Gingin Abdul Goni | Rosita Wulandari, S.Kom,.MTA
     *  Email       : ginginabdulgoni@gmail.com
     *  Instagram   : @ginginabdulgoni
     *
     *  Name        : My-Wifi
     *  Function    : Manage Client and Billing
     *  Manufacture : April 2020 
     *  Last Edited : 25 Desember 2020 
     *
     *  Please do not change this code
     *  All damage caused by editing we will not be responsible please think carefully,
     *
     */
//==============================START CODE=========================================// 
?>
<?php $this->view('messages') ?>
<?php $whatsapp = $this->db->get('whatsapp')->row_array() ?>
<?php if ($whatsapp['is_active'] == 1) { ?>
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Kirim Pesan Whatsapp Gateway</h6>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                            <form action="<?= site_url('whatsapp/sendbill') ?>" method="POST">
                                <div class="form-group">
                                    <label for="vendor">Vendor</label>
                                    <input type="text" name="vendor" value="<?= $whatsapp['vendor'] ?>" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">No Tujuan</label>
                                    <select class="form-control select2" name="target" style="width: 100%;" required>
                                        <option value="customeractive">Pelanggan Aktif</option>
                                        <option value="customernonactive">Pelanggan Non-Aktif</option>
                                    </select>
                                </div>
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
                                    <label>Pesan</label>
                                    <textarea name="message" id="message" style="height: 400px;" class="form-control"><?= $other['say_wa']; ?></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                    <button type="submit" id="click-me" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body">
                        <h5>Variable</h5>
                        - {name} = Nama Pelanggan <br>
                        - {noservices} = No Layanan <br>
                        - {nominal} = Jumlah Tagihan <br>
                        - {month} = Bulan <br>
                        - {year} = Tahun <br>
                        - {period} = Periode <br>
                        - {duedate} = Tanggal Jatuh Tempo <br>
                        - {companyname} = Nama Perusahaan <br>
                        - {slogan} = Moto / Slogan Perusahaan <br>
                        - {link} = Alamat website <br>
                        - {e} = Enter / Baris Baru
                    </div>
                    <div class="card-body">
                        <h5>Keterangan</h5>
                        <li>Pastikan Whatsapp Gateway Aktif dan user atau token atau api key nya benar </code></li>
                        <li>Setting Whastapp Gateway <a href="<?= site_url('whatsapp') ?>" style="text-decoration: none;">Klik disini</a></li>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">





        <div class="spinner-grow text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-danger" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-warning" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark" role="status">
            <span class="sr-only">Loading...</span>
        </div>



    </div>
</div>


<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>

<script>
    $("#btn-sendWA").click(function() {
        var no_target = $('[name="no_target"]');
        var message = $('[name="message"]');
        var cno_target = $('#no_target').val();
        var cmessage = $('#message').val();
        if (cno_target == '') {
            $('#no_target').focus()
            $('#btn-sendWA').attr('href', "#");

        } else if (cmessage == '') {
            $('#message').focus()
            $('#btn-sendWA').attr('href', "#");
        } else {
            $('#btn-sendWA').attr('target', "blank");
            $('#btn-sendWA').attr('href', "https://api.whatsapp.com/send?phone=" + no_target.val() + "&text=" + message.val());
            $("#btn-sendWA").submit();
        }
    });

    $("#btn-sendWA2").click(function() {
        var no_target2 = $('[name="no_target2"]');
        var message2 = $('[name="message2"]');
        var cno_target2 = $('#no_target2').val();
        var cmessage2 = $('#message2').val();
        if (cno_target2 == '') {
            $('#no_target2').focus()
            $('#btn-sendWA2').attr('href', "#");
        } else if (cmessage2 == '') {
            $('#message2').focus()
            $('#btn-sendWA2').attr('href', "#");
        } else {
            $('#btn-sendWA2').attr('target', "blank");
            $('#btn-sendWA2').attr('href', "https://api.whatsapp.com/send?phone=" + no_target2.val() + "&text=" + message2.val());
            $("#btn-sendWA2").submit();
        }
    });

    $(document).ready(function() {
        $("#popup").modal({
            show: false,
            backdrop: 'static'
        });

        $("#click-me").click(function() {
            $("#popup").modal("show");
        });
    });
</script>