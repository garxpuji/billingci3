<?php //==============================START=========================================//
/*
     *  Base Code   : Gingin Abdul Goni | Rosita Wulandari, S.Kom,.MTA
     *  Email       : ginginabdulgoni@gmail.com
     *  Instagram   : @ginginabdulgoni
     *
     *  Name        : My-Wifi
     *  Function    : Manage Client and Billing
     *  Manufacture : April 2020 
     *  Last Edited : 25 Desember 2020 | V1.5 
     *
     *  Please do not change this code
     *  All damage caused by editing we will not be responsible please think carefully,
     *
     */
//==============================START CODE=========================================// 
?>
<?php $this->view('messages') ?>


<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Hapus Tagihan Masal </h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                        <form action="<?= site_url('bill/dellbill') ?>" method="POST">
                            <div class="row">
                                <div class="col-4">

                                    <div class="form-group">
                                        <label for="name">Status</label>

                                        <select class="form-control select2" style="width: 100%;" id="status" name="status" required onChange="selectstatus(this);">
                                            <option value="">-Pilih-</option>
                                            <option value="SUDAH BAYAR">SUDAH BAYAR</option>
                                            <option value="BELUM BAYAR">BELUM BAYAR</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">

                                    <div class="form-group">
                                        <label for="name">Bulan</label>

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
                                <div class="col-4">
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
                            <div id="formdelincome" style="display: none">
                                <input type="checkbox" id="clickdelincome"> <label for="">Hapus Data Pemasukan </label>
                                <br>
                                <span style="color: red;">Penghapusan data pemasukan ini akan mempengaruhi Saldo Kas dan Pemasukan</span>
                                <input type="hidden" name="delincome" id="delincome">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <h5>Keterangan</h5>
                    <li>Pastikan database di <a href="<?= site_url('setting/backupdatabase') ?>" class="btn btn-info" onclick="return confirm('Apakah anda yakin backup database ?')">Backup</a> dulu untuk, agar bisa dipulihkan jika terjadi hal yang tidak diinginkan</li>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Hapus Data Tagihan Tahunan </h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                        <form action="<?= site_url('bill/dellbillyear') ?>" method="POST">
                            <div class="row">

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">Tahun</label>
                                        <select class="form-control select2" style="width: 100%;" name="year" required>


                                            <?php
                                            for ($i = date('Y') - 1; $i >= date('Y') - 2; $i -= 1) {
                                            ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="formdelincome" style="display: none">
                                <input type="checkbox" id="clickdelincome"> <label for="">Hapus Data Pemasukan </label>
                                <br>
                                <span style="color: red;">Penghapusan data pemasukan ini akan mempengaruhi Saldo Kas dan Pemasukan</span>
                                <input type="hidden" name="delincome" id="delincome">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <h5>Keterangan</h5>
                    <li>Pastikan database di <a href="<?= site_url('setting/backupdatabase') ?>" class="btn btn-info" onclick="return confirm('Apakah anda yakin backup database ?')">Backup</a> dulu untuk, agar bisa dipulihkan jika terjadi hal yang tidak diinginkan</li>
                </div>

            </div>
        </div>
    </div>
</div>
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
    $("#clickdelincome").click(function() {
        if ($(this).is(":checked")) {
            $("#delincome").val('1');
        } else {
            $("#delincome").val('0');
        }
    });
</script>

<script>
    function selectstatus(sel) {

        var status = $('#status').val();

        if (status == 'SUDAH BAYAR') {
            $("#formdelincome").show();
            $("#delincome").val('0');
            document.getElementById("clickdelincome").checked = false;
        } else {
            $("#formdelincome").hide();
            $("#delincome").val('0');
            document.getElementById("clickdelincome").checked = false;
        };

    }

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