<?php $this->view('messages') ?>
<div class="row">

    <div class="col-lg-6">
        <div class="card shadow mb-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-2">
                        <div class="card-header ">
                            <h6 class="m-0 font-weight-bold"><i class="fa fa-info-circle" style="font-size: 24px"> Changelog</i></h6>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container mt-1">
                                    <br>
                                    <div class="d-sm-flex align-items-center justify-content-between ">
                                        <!-- <a href="#" onclick="return  confirm('Comingsoon')" class="btn btn-outline-success">Cek Versi</a> -->
                                        <a href="<?= site_url('migration/update') ?>" onclick="return  confirm('Apakah anda yakin akan update billing ? ')" class="btn btn-outline-success">Update Billing</a>
                                        <a href="<?= site_url('migration') ?>" onclick="return  confirm('Apakah anda yakin akan update database ? ')" class="btn btn-outline-primary">Update Database</a>
                                    </div>
                                    <br>
                                    <!-- <h5 style="color:red">Setelah Update Billing jangan lupa klik Update Database </h5> -->
                                    <br>
                                    Last Update : <?= date('d-M-Y H:i:s', $company['last_update']); ?>
                                    <br>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-2">
                        <div class="card-header ">
                            <h6 class="m-0 font-weight-bold"><i class="fa fa-info-circle" style="font-size: 24px"> </i> About My-Wifi</h6>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container mt-1">
                                    <br>
                                    <br>
                                    <b>My-Wifi</b> <span> adalah Aplikasi Billing atau Aplikasi Tagihan Internet berbasis web yang berfungsi untuk mengelola data pelanggan, mengatur layanan pelanggan, membuat tagihan / invoice, melihat report keuangan, riwayat tagihan pelanggan dan masih banyak fitur lainnya.</span>
                                    <br><br>

                                    <span style="color: red;"> Bagi yang mempunyai source code Aplikasi ini mohon untuk tidak diperjual belikan kembali, dengan mengambil keuntungan secara pribadi ataupun kelompok. Agar bisa kami support jika ada bugs atau update.
                                    </span>
                                    <br>
                                    <br>
                                    Terima kasih untuk semua yang telah mendukung pengembangan aplikasi ini,
                                    Jika ada kritik dan saran silahkan dilanjut ke Whatsapp atau Telegram. Terimakasih ☺️🙏

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5d0519ec36eab9721117a07a/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->