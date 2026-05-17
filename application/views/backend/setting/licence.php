<?php $licence = verify_license();
$licence = json_decode($licence, true);


?>
<?php $company = $this->db->get('company')->row_array() ?>
<?php $this->view('messages') ?>
<?php if ($licence['code'] == true) { ?>
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold">About Licence</h6>
                        <?php if ($this->session->userdata('role_id') == 1 or $role['add_bill'] == 1) { ?>
                            <a href="" id="#renewModal" data-toggle="modal" data-target="#renewModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-refesh fa-sm text-white-50"></i> Update Licence</a>
                        <?php } ?>

                    </div>
                </div>
                <div class="card-body">

                    <p>Selamat! Domain telah terverifikasi dan semua menu sudah dapat diakses sebagaimana mestinya. </p>
                    <p>Halo,

                        Kami ucapkan terima kasih yang sebesar-besarnya kepada semua pelanggan yang telah menggunakan aplikasi ini. Tanpa dukungan dan kepercayaan Anda, kami tidak akan berhasil mencapai perkembangan sampai saat ini.
                    <p>
                        Kami sangat berterima kasih atas kepercayaan sebagai pelanggan, dan kami akan terus berupaya untuk memberikan pelayanan yang terbaik semampu kami. Kami berharap dapat terus memberikan layanan yang berkualitas dan memaksimalkan kebutuhan Anda.
                        Sekali lagi, terima kasih banyak atas kepercayaan dan dukungan Anda sebagai pelanggan kami.
                    </p>

                    Salam hangat,
                    <br><br>
                    <b>Teams My-Wifi</b><br>
                    <i style="font-size:small">1112-Project.com</i>
                    </p>


                </div>
            </div>
        </div>


        <!-- Modal -->

        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">License</h6>
                </div>
                <div class="card-body">

                    <div class=" form-group">
                        <label for="">Domain</label><br>
                        <?php
                        $no = 1;
                        foreach ($licence['data']['domain'] as $domain) {
                            $domain = str_replace('/', '', $domain);
                            echo $no++ . '. ' . $domain . '<br>';
                        }
                        ?>



                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class=" form-group">
                                <label for="">IP Address</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= gethostbyname("$_SERVER[HTTP_HOST]") ?>" disabled>
                            </div>

                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class=" form-group">
                                <label for="">Expired</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= $licence['expired'] ?>" disabled>
                            </div>
                        </div>
                        <br>
                        <span style="color: red;">WARNING</span>
                        <span style="color: red;"> Bagi yang mempunyai source code Aplikasi ini mohon untuk tidak diperjual belikan kembali, dengan mengambil keuntungan secara pribadi ataupun kelompok. Agar bisa kami support jika ada bugs atau update. </span>
                    </div>

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Payment</h6>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Bank Transfer
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middletable-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-Bank-BCA-1.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">BCA</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            4460 8037 60
                                                        </span>
                                                        <p>A/N Rosita Wulandari</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-Bank-BRI-1024x538.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">BRI</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            4179 0101 9831 536
                                                        </span>
                                                        <p>A/N : Gingin Abdul Goni</p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        E-Wallet
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 table-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">DANA</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            082337481227
                                                        </span>
                                                        <p>A/N Rosita Wulandari</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/2560px-Logo_ovo_purple.svg.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">OVO</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            082337481227
                                                        </span>
                                                        <p>A/N Gingin Abdul Goni</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/LinkAja.svg/2048px-LinkAja.svg.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">LinkAja</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            082337481227
                                                        </span>
                                                        <p>A/N Gingin Abdul Goni</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://antinomi.org/wp-content/uploads/2022/03/logo-gopay-vector.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">GOPAY</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            082337481227
                                                        </span>
                                                        <p>A/N Gingin Abdul Goni</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="https://1.bp.blogspot.com/-EmJLucvvYZw/X0Gm1J37spI/AAAAAAAAC0s/Dyq4-ko9Eecvg0ostmowa2RToXZITkbcQCLcBGAsYHQ/s400/Logo%2BShopeePay.png" title="product-img" height="35px">
                                                    </td>
                                                    <td class="text-center">
                                                        <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">ShopeePay</a></h5>
                                                        <p class="mb-0"></p><span class="fw-medium">
                                                            082337481227
                                                        </span>
                                                        <p>A/N Dedemit</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($licence['code'] != true) { ?>
    <?php if ($licence['status'] == 'expired') { ?>
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h6 class="m-0 font-weight-bold">Expired</h6>
                            <?php if ($this->session->userdata('role_id') == 1 or $role['add_bill'] == 1) { ?>
                                <a href="" id="#renewModal" data-toggle="modal" data-target="#renewModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-refesh fa-sm text-white-50"></i> Update Licence</a>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Halo,

                            Kami ingin menginformasikan bahwa layanan yang Anda gunakan saat ini telah expired atau berakhir masa aktifnya. Oleh karena itu, kami menyarankan untuk segera memperpanjang layanan Anda agar tetap dapat menggunakan layanan tersebut.

                            Untuk memperpanjang layanan Anda, silakan mengikuti instruksi dan prosedur yang telah disediakan oleh penyedia layanan. Pastikan Anda melakukan pembayaran sesuai dengan harga yang telah ditetapkan dan jangan lupa untuk memperhatikan masa aktif layanan agar tidak ketinggalan dalam memperpanjang kembali.

                            Dalam hal ini, kami ingin memberikan himbauan agar Anda segera memperpanjang layanan Anda sebelum masa aktifnya habis. Jangan sampai Anda kehilangan akses atau terganggu dalam melakukan aktivitas yang membutuhkan layanan tersebut.

                            Terima kasih dan semoga informasi ini bermanfaat bagi Anda. -->
                        <p> <span>Pelanggan My-Wifi yang terhormat,</span> </p>
                        <p>Kami informasikan bahwa layanan My-Wifi Anda saat ini terisolir. </p>
                        <p>Mohon maaf atas ketidaknyamanannya. Agar dapat digunakan kembali, mohon untuk segera melakukan pembayaran Tagihan.</p>
                        <p></p>
                        <p>Untuk menghindari terulangnya kembali ketidaknyamanan ini, disarankan untuk melakukan pembayaran tepat waktu.</p>
                        <?php $link = "https://$_SERVER[HTTP_HOST]"; ?>
                        <p>Silahkan melakukan pembayaran ke rekening / dompet digital yg terlampir, kemudian konfirmasi ke whatsapp <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp('085283935826') ?>&text=Perpanjangan Billing My-Wifi untuk <?= $link ?>" title="Kontak Kami"><span>085283935826</span></a> beserta lampirkan bukti transfer nya.</p>

                        <p> Untuk informasi lebih lanjut silahkan hubungi kami di whatsapp. </p>
                        <p> <span>Terimakasih</span></p>


                    </div>
                </div>
            </div>


            <!-- Modal -->

            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Licence</h6>
                    </div>
                    <div class="card-body">

                        <div class="form-group row">

                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class=" form-group">

                                    <label for="">Domain</label><br>
                                    <?php
                                    $no = 1;
                                    foreach ($licence['data']['domain'] as $domain) {
                                        $domain = str_replace('/', '', $domain);
                                        echo $no++ . '. ' . $domain . '<br>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class=" form-group">
                                    <label for="">Expired</label>
                                    <input type="text" class="form-control" autocomplete="off" value="<?= $licence['expired'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="">IP Address</label>
                            <input type="text" class="form-control" autocomplete="off" value="<?= gethostbyname("$_SERVER[HTTP_HOST]") ?>" disabled>
                        </div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">Payment</h6>
                        </div>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Bank Transfer
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middletable-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-Bank-BCA-1.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">BCA</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                4460 8037 60
                                                            </span>
                                                            <p>A/N Rosita Wulandari</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-Bank-BRI-1024x538.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">BRI</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                4179 0101 9831 536
                                                            </span>
                                                            <p>A/N : Gingin Abdul Goni</p>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            E-Wallet
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0 table-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">DANA</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                082337481227
                                                            </span>
                                                            <p>A/N Rosita Wulandari</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/2560px-Logo_ovo_purple.svg.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">OVO</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                082337481227
                                                            </span>
                                                            <p>A/N Gingin Abdul Goni</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/LinkAja.svg/2048px-LinkAja.svg.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">LinkAja</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                082337481227
                                                            </span>
                                                            <p>A/N Gingin Abdul Goni</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://antinomi.org/wp-content/uploads/2022/03/logo-gopay-vector.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">GOPAY</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                082337481227
                                                            </span>
                                                            <p>A/N Gingin Abdul Goni</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="https://1.bp.blogspot.com/-EmJLucvvYZw/X0Gm1J37spI/AAAAAAAAC0s/Dyq4-ko9Eecvg0ostmowa2RToXZITkbcQCLcBGAsYHQ/s400/Logo%2BShopeePay.png" title="product-img" height="35px">
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">ShopeePay</a></h5>
                                                            <p class="mb-0"></p><span class="fw-medium">
                                                                082337481227
                                                            </span>
                                                            <p>A/N Dedemit</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($licence['status'] == 'notmacth') { ?>
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h6 class="m-0 font-weight-bold">Domain Tidak Cocok</h6>
                            <?php if ($this->session->userdata('role_id') == 1 or $role['add_bill'] == 1) { ?>
                                <a href="" id="#renewModal" data-toggle="modal" data-target="#renewModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-refesh fa-sm text-white-50"></i> Update License</a>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="card-body">

                        <p> <span>Pelanggan My-Wifi yang terhormat,</span> </p>
                        <p>"Mohon maaf, kami menemukan bahwa domain yang Anda gunakan tidak terdaftar atau tidak cocok dengan data disistem kami. Untuk menggunakan layanan atau sistem kami, silakan pastikan bahwa domain yang Anda gunakan telah terdaftar dan sesuai dengan persyaratan yang berlaku."</p>

                        <p> Untuk informasi lebih lanjut silahkan hubungi kami di whatsapp.</p>
                        <p> <span>Terimakasih</span></p>


                    </div>
                </div>
            </div>




            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">License</h6>
                    </div>
                    <div class="card-body">
                        <div class=" form-group">
                            <label for="">Domain</label><br>
                            <?php
                            $no = 1;

                            foreach ($licence['data']['domain'] as $domain) {
                                $domain = str_replace('/', '', $domain);
                                echo $no++ . '. ' . $domain . '<br>';
                            }
                            ?>



                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class=" form-group">
                                    <label for="">IP Address</label>
                                    <input type="text" class="form-control" autocomplete="off" value="<?= gethostbyname("$_SERVER[HTTP_HOST]") ?>" disabled>
                                </div>

                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class=" form-group">
                                    <label for="">Expired</label>
                                    <input type="text" class="form-control" autocomplete="off" value="<?= $licence['expired'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
<?php } ?>

<div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update License</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('licence/update') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="domain">Domain / Subdomain</label>
                        <input type="text" id="domain" name="domain" value="<?= base_url() ?>" autocomplete="off" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="licence">License</label>
                        <input type="text" id="licence" name="licence" autocomplete="off" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>