<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>

<?php

foreach ($bill->result() as $c => $data) {
} ?>



<?php

if (count($customer) > 0) { ?>

    <?php

    if ($bill->num_rows() > 0) { ?>

        <?php $query = "SELECT *

                                    FROM `customer`

                                        WHERE `customer`.`no_services` = $data->no_services";

        $querying = $this->db->query($query);

        ?>

        <!-- // var_dump($querying);  -->

        <?php

        foreach ($querying->result() as  $dataa)

        ?>

        <?php if ($data->status == 'BELUM BAYAR') {

        # code...

        ?>

            <div class="info-tagihan">

                <div class="container">

                    <div class="card border-primary mb-2">

                        <div class="container mt-2">

                            <h5>Periode <?= indo_month($data->month) ?> <?= $data->year ?></h5>

                            <div class="row">

                                <div class="col-3">

                                    No Layanan

                                </div>

                                <div class="col-8">

                                    : <?= $data->no_services ?>



                                </div>

                            </div>

                            <div class="row">

                                <div class="col-3">

                                    Nama Pelanggan

                                </div>

                                <div class="col-8">

                                    : <?= $dataa->name ?>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-3">

                                    Jumlah Tagihan

                                </div>

                                <div class="col-8">

                                    <?php if ($data->invoice_id != 0) { ?>

                                        <?php $query = "SELECT *

                                    FROM `invoice_detail`

                                        WHERE `invoice_detail`.`invoice_id` =  $data->invoice";

                                        $querying = $this->db->query($query)->result();

                                        ?>



                                        <?php $subTotal = 0;

                                        foreach ($querying as  $dataa)

                                            $subTotal += (int) $dataa->total;

                                        ?>

                                        <?php

                                        $query = "SELECT *

                                    FROM `invoice_detail`

                                    WHERE `invoice_detail`.`d_month` =  $data->month and

                                       `invoice_detail`.`d_year` =  $data->year and

                                       `invoice_detail`.`d_no_services` =  $data->no_services";

                                        $queryTot = $this->db->query($query)->result();

                                        ?>

                                        <?php $subTotaldetail = 0;

                                        foreach ($queryTot as  $dataa)

                                            $subTotaldetail += (int) $dataa->total;

                                        ?>
                                        <!-- KODE UNIK -->
                                        <?php if ($customer['codeunique'] == 1) { ?>
                                            <?php $code_unique = $data->code_unique ?>
                                        <?php } ?>
                                        <?php if ($customer['codeunique'] == 0) { ?>
                                            <?php $code_unique = 0 ?>
                                        <?php } ?>
                                        <!-- END KODE UNIK -->

                                    <?php } ?>
                                    <!-- PPN -->
                                    <?php if ($subTotal != 0) { ?>
                                        <?php if ($data->i_ppn > 1) { ?>
                                            <?php $ppn =  $subTotal * ($data->i_ppn / 100) ?>
                                        <?php } ?>
                                        <?php if ($data->i_ppn == 0) { ?>
                                            <?php $ppn = 0 ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($subTotal == 0) { ?>
                                        <?php if ($data->i_ppn > 1) { ?>
                                            <?php $ppn =  $subTotaldetail * ($data->i_ppn / 100) ?>
                                        <?php } ?>
                                        <?php if ($data->i_ppn == 0) { ?>
                                            <?php $ppn = 0 ?>
                                        <?php } ?>
                                    <?php } ?>


                                    <?php if ($subTotal != 0) { ?>
                                        : <?= indo_currency($subTotal + $code_unique + $ppn) ?>
                                    <?php } ?>
                                    <?php if ($subTotal == 0) { ?>
                                        : <?= indo_currency($subTotaldetail + $code_unique + $ppn) ?>
                                    <?php } ?>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-3">

                                    Terbilang

                                </div>

                                <div class="col-8 mb-3">

                                    <?php if ($subTotal != 0) { ?>

                                        : <?= number_to_words($subTotal + $code_unique + $ppn) ?>

                                    <?php } ?>

                                    <?php if ($subTotal == 0) { ?>

                                        : <?= number_to_words($subTotaldetail + $code_unique + $ppn) ?>

                                    <?php } ?>

                                    </b>

                                </div>

                            </div>
                            <?php if ($pg['is_active'] == 1) { ?>

                                <?php if ($pg['vendor'] == 'Tripay') { ?>
                                    <div class="row mt-2 mb-2 justify-content-center">
                                        <a href="<?= site_url('front/checkout?invoice=' . $data->invoice) ?>" class="btn btn-primary" style="text-align:center">Checkout</a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($pg['is_active'] == 0) { ?>

                                <div class="row mt-2 mb-2 justify-content-center">
                                    <a href="" data-toggle="modal" data-target="#ModalBayar" class="btn btn-primary" style="text-align:center">Cara Pembayaran</a>
                                </div>
                            <?php } ?>
                        </div>

                    </div>

                </div>

            </div>

        <?php } else {

        echo ' <div class="text-center mb-3">

                <div class="container">

                    <div class="card border-success">

                        <div class="card-body">

                            <h4 class="card-title text-success">Data Tagihan Sudah Dibayar</h4>

                        </div>

                    </div>

                </div>

            </div>';
    } ?>



<?php

    } else {

        echo '<div class="text-center mb-3">

    <div class="container">

        <div class="card border-danger">

            <div class="card-body">

                <h4 class="card-title text-danger">Data Tagihan Belum Tersedia</h4>

            </div>

        </div>

    </div>

</div>';
    }
} else {

    echo '<div class="text-center mb-3">

        <div class="container">

            <div class="card border-warning">

                <div class="card-body">

                    <h4 class="card-title text-warning">No Layanan tidak Terdaftar, pastikan no layanan anda benar</h4>

                </div>

            </div>

        </div>

    </div>';
} ?>


<!-- Modal -->

<div class="modal fade" id="ModalBayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Cara Pembayaran</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                Silahkan lakukan pembayaran sesuai tagihan anda, pembayaran bisa via Transfer ke rekening berikut;

                <br> <br>

                <?php

                foreach ($bank as $r => $data) { ?>

                    <?= $data->name ?> : <?= $data->no_rek ?> A/N <?= $data->owner ?>

                    <br>

                <?php } ?>

                <br>

                <b>Konfirmasi Pembayaran :</b> <br>

                Email : <?= $company['email'] ?>

                <br>

                WA : <?= $company['whatsapp'] ?> <br>

                Untuk upload bukti pembayaran silahkan Login terlebih dahulu.
                <br>
                <div class="row justify-content-center">
                    <a href="<?= site_url('auth') ?>" class="btn btn-primary">Login</a>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <!-- <a href="<?= site_url('member/confirmpayment/' . $invoice->invoice) ?>" class="btn btn-success">Konfirmasi Pembayaran</a> -->

            </div>

        </div>

    </div>

</div>