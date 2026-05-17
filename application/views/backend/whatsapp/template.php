<?php $this->view('messages') ?>
<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Template Text Whatsapp</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('whatsapp/settemplate') ?>
                    <div class="form-group">
                        <label for="">Template</label>
                        <select name="selecttemplate" id="selecttemplate" class="form-control" onChange="select_template(this);">
                            <option value="1">Kirim Tagihan (Tambah / Generate)</option>
                            <option value="2">Pembayaran diterima / Terimakasih</option>
                            <option value="3">Pengingat <?= $other['date_reminder'] ?> Hari Sebelum Jatuh Tempo</option>
                            <option value="4">Info Jatuh Tempo</option>
                            <option value="5">Kirim User & Password Ketika Tambah Pelanggan</option>
                            <option value="6">Kirim User & Password Ketika Reset Password</option>
                            <option value="7">Kirim Kode OTP</option>
                            <?php if ($pg['is_active'] == 1) { ?>
                                <?php if ($pg['vendor'] == 'Tripay') { ?>
                                    <option value="8">Checkout Payment Gateway</option>
                                <?php } ?>
                            <?php } ?>
                            <option value="9">Kirim Tiket ke Teknisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div id="tem1" style="display: block">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">
                                <input type="hidden" name="id" value="<?= $other['id'] ?>">
                                <label for="body_wa">Kirim Tagihan (Tambah / Generate)</label>
                                <a href="#" id="resetwacreatebill" class="btn btn-secondary">Reset</a>
                            </div>
                            <textarea id="say_wa" name="say_wa" style="height: 400px;" class="form-control"><?= $other['say_wa'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="tem2" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">
                                <label for="thanks_wa">Pembayaran diterima / Terimakasih</label>
                                <a href="#" id="resetwapayment" class="btn btn-secondary">Reset</a>
                            </div>

                            <textarea id="thanks_wa" name="thanks_wa" style="height: 400px;" class="form-control"><?= $other['thanks_wa'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tem3" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">

                                <label for="footer_wa">Pengingat <?= $other['date_reminder']; ?> Hari Sebelum Jatuh Tempo</label>
                                <a href="#" id="resetwadatereminder" class="btn btn-secondary">Reset</a>
                            </div>
                            <textarea id="datereminder" name="footer_wa" style="height: 400px;" class="form-control"><?= $other['footer_wa'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tem4" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">

                                <label for="body_wa">Info Jatuh Tempo</label>
                                <a href="#" id="resetwareminderduedate" class="btn btn-secondary">Reset</a>
                            </div>
                            <textarea id="reminderduedate" name="body_wa" style="height: 400px;" class="form-control"><?= $other['body_wa'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tem5" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">

                                <label for="add_customer">Kirim User & Password Ketika Tambah Pelanggan by Admin / Operator</label>
                                <a href="#" id="resetwaaddcustomer" class="btn btn-secondary">Reset</a>
                            </div>
                            <textarea id="add_customer" name="add_customer" style="height: 400px;" class="form-control"><?= $other['add_customer'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tem6" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">

                                <label for="reset_password">Reset Password by Admin / Operator</label>
                                <a href="#" id="resetwaresetpassword" class="btn btn-secondary">Reset</a>
                            </div>
                            <textarea id="reset_password" name="reset_password" style="height: 400px;" class="form-control"><?= $other['reset_password'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tem7" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">
                                <label for="code_otp">Kirim Kode OTP</label>

                                <a href="#" id="resetwacodeotp" class="btn btn-secondary">Reset</a>
                            </div>
                            <textarea id="code_otp" name="code_otp" style="height: 400px;" class="form-control"><?= $other['code_otp'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">

                        <div id="tem8" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">

                                <label for="checkout">Chekout Payment Gateway</label>
                                <a href="#" id="resetwacheckout" class="btn btn-secondary">Reset</a>
                            </div>

                            <textarea id="checkout" name="checkout" style="height: 400px;" class="form-control"><?= $other['checkout'] ?></textarea>

                        </div>

                    </div>
                    <div class="form-group">

                        <div id="tem9" style="display: none">
                            <div class="d-sm-flex align-items-center justify-content-between mb-1">

                                <label for="create_help">Kirim Tiket Ke Teknisi</label>
                                <a href="#" id="resetwacreatehelp" class="btn btn-secondary">Reset</a>
                            </div>

                            <textarea id="create_help" name="create_help" style="height: 400px;" class="form-control"><?= $other['create_help'] ?></textarea>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <div class="form-group">
                        <h5>Variable</h5>
                        - {name} = Nama Pelanggan <br>
                        - {noservices} = No Layanan <br>
                        - {email} = Email (khusus utk tambah pelanggan)<br>
                        - {password} = Password (khusus utk tambah pelanggan) <br>
                        - {nominal} = Jumlah Tagihan <br>
                        - {invoice} = No Invoice <br>
                        - {month} = Bulan <br>
                        - {year} = Tahun <br>
                        - {period} = Periode (contoh <?= indo_month(date('m')); ?> <?= date('Y'); ?>)<br>
                        - {duedate} = Tanggal Jatuh Tempo (contoh <?= date('d'); ?> <?= indo_month(date('m')); ?> <?= date('Y'); ?>) <br>
                        - {receiver} = Penerima Tagihan (khusus utk saat ubah tagihan menjadi sudah bayar) <br>
                        - {companyname} = Nama Perusahaan <br>
                        - {slogan} = Moto / Slogan Perusahaan <br>
                        - {link} = Alamat website <br>
                        - {e} = Enter / Baris Baru <br>
                        <br>
                        <h5>Link</h5>
                        <li>Menampilkan semua invoice untuk no layanan</li>
                        <?= base_url('front/invoice?noservice='); ?>{noservices}
                        <li>Menampilkan invoice tunggal </li>
                        <?= base_url('front/bill?invoice='); ?>{invoice}

                        <?php if ($pg['vendor'] == 'Tripay') { ?>
                            <li>Checkout Payment Gateway </li>
                            <?= base_url('front/checkout?invoice='); ?>{invoice}
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
    <script>
        $("#resetwacreatebill").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika tambah / generate tagihan ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#say_wa").html(`Plg Yth, tagihan dengan no layanan {noservices} a/n _{name}_ Periode {period} sebesar *{nominal}*, Maks Tanggal {duedate}.
{e}Mohon untuk melakukan pembayaran langsung ke {companyname}.
{e}
{e}Abaikan jika sudah melakukan pembayaran. Tks
{e}
{e}*{companyname}*
{e}_{slogan}_
{e}{link}`);
                }
            })
        });
        $("#resetwapayment").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika pembayaran diterima ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#thanks_wa").html(`Plg Yth, Terima kasih Anda Telah membayar tagihan Internet periode {period} sebesar {nominal}.
{e}
{e}*{companyname}*
{e}_{slogan}_
{e}{link}`);
                }
            })
        });
        $("#resetwadatereminder").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp sebelum jatuh tempo ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#datereminder").html(`Plg Yth, tagihan dengan no layanan {noservices} a/n _{name}_ Periode {period} sebesar *{nominal}*, akan jatuh tempo pada tanggal {duedate}.
{e}
{e}Mohon untuk melakukan pembayaran langsung ke {companyname} 
{e}

{e}Abaikan jika sudah melakukan pembayaran. Tks
{e}
{e}*{companyname}*
{e}_{slogan}_
{e}{link}`);
                }
            })
        });
        $("#resetwareminderduedate").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika info jatuh tempo ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#reminderduedate").html(`Plg Yth, tagihan dengan no layanan {noservices} a/n _{name}_ Periode {period} sebesar *{nominal}*, sudah memasuki jatuh tempo dan akun anda akan terisolir.
{e}
{e}Mohon untuk melakukan pembayaran langsung ke {companyname}
{e}
{e}Abaikan jika sudah melakukan pembayaran. Tks
{e}
{e}*{companyname}*
{e}_{slogan}_
{e}{link}`);
                }
            })
        });
        $("#resetwaaddcustomer").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika tambah pelanggan ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#add_customer").html(`Terimaksih telah berlangganan {companyname}

Berikut adalah informasi akun anda

Nama : {name}
No Layanan : {noservices}
Tgl Pembayaran : {duedate}
Email : {email}
Password : {password}

Atau bisa juga menggunakan Nomor Whatsapp untuk masuk ke Website

Mohon segera ganti password anda, untuk menjaga keamanan. Terimakasih 

{e}
{e}*{companyname}*
{e}_{slogan}_
{e}{link}`);
                }
            })
        });
        $("#resetwaresetpassword").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika reset password ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#reset_password").html(`*Info Reset Password*

Berikut adalah informasi akun anda

Email : {email}
Password Baru : {password}

Mohon segera ganti password anda, untuk menjaga keamanan. Terimakasih 

{e}
{e}*{companyname}*
{e}_{slogan}_
{e}{link}`);
                }
            })
        });
        $("#resetwacodeotp").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika kirim kode OTP ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#code_otp").html(`kode OTP untuk reset password anda : {otp}`);
                }
            })
        });
        $("#resetwacheckout").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ketika pelanggan checkout ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#checkout").html(`Untuk melakukan pembayaran & Detail pembayaran beserta *KODE BAYAR* silahkan klik link ini :
{e}
{payment_url}

Kemudian Pilih Menu *Cara Pembayaran*

Terima kasih
*{companyname}*
_{slogan}_
{link}`);
                }
            })
        });
        $("#resetwacreatehelp").click(function() {

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Akan reset text Whatsapp ke teknisi ketika tiket dibuat ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#create_help").html(`TIKET GANGGUAN BARU
No Tiket : {noticket}
Nama : {name}
Email : {email}
No WA : {phone}
Alamat : {address}
Topik Gangguan : {topic}
Laporan : {report}
Keterangan : {remark}
Maps : {maps}`);
                }
            })
        });

        function select_template(sel) {
            var template = $("#selecttemplate").val();
            if (template == 1) {

                $("#tem1").show();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 2) {
                $("#tem1").hide();
                $("#tem2").show();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 3) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").show();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 4) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").show();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 5) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").show();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 6) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").show();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 7) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").show();
                $("#tem8").hide();
                $("#tem9").hide();
            }
            if (template == 8) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").show();
                $("#tem9").hide();
            }
            if (template == 9) {
                $("#tem1").hide();
                $("#tem2").hide();
                $("#tem3").hide();
                $("#tem4").hide();
                $("#tem5").hide();
                $("#tem6").hide();
                $("#tem7").hide();
                $("#tem8").hide();
                $("#tem9").show();
            }

        }
    </script>