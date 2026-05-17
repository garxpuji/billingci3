<link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/libraries/bootstrap/css/bootstrap.css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

<body onload="window.print()">
    <?php if ($other['inv_thermal'] == 1) { ?>
        <style>
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }

            @page {
                margin: 0;
            }

            .title {
                text-align: center;
                padding-bottom: 5px;
                border-bottom: 0.5px dashed;
            }

            .title img {
                margin-top: 10px;
                max-height: 35px;
            }

            .header {
                margin-left: 10px;
                margin-top: 5px;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid;
            }


            .thanks {
                /* margin-top: 5px; */
                padding-top: 5px;
                text-align: center;
                border-top: 1px dashed;
            }

            table {

                font-size: 14px;
            }
        </style>
    <?php } ?>
    <?php if ($other['inv_thermal'] == 0) { ?>
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
                font-family: "Verdana, Arial";
            }

            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }

            .page {
                width: 80mm;
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
                margin: 0.3cm auto;
                border: 1px #D3D3D3 solid;
                border-radius: 5px;
                background: white;
            }

            @page {
                margin: 0;
            }

            @media print {
                .page {
                    margin-top: 5px;
                    margin-left: 2px;
                    font-weight: bold;
                    border: initial;

                }
            }


            .title {
                text-align: center;
                padding-bottom: 5px;
                border-bottom: 0.5px dashed;
            }

            .title img {
                margin-top: 10px;
                max-height: 35px;
            }

            .header {
                margin-left: 10px;
                margin-top: 5px;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid;
            }

            .left-content {
                margin-left: -30px;
            }

            .thanks {
                /* margin-top: 5px; */
                padding-top: 5px;
                text-align: center;
                border-top: 1px dashed;
            }

            table {
                /* width: 55mm; */
                margin-left: 5px;
                font-weight: 900;
                font-size: 12px;
            }
        </style>
    <?php } ?>
    <title><?= $title ?> - <?= $bill['invoice'] ?> a/n <?= $bill['name'] ?> Periode <?= indo_month($bill['month']) ?> <?= $bill['year'] ?></title>
    <div class="page">
        <div class="title">
            <img src="<?= base_url('assets/images/' . $company['logo']) ?>" alt="">
            <br>
            <?= $company['company_name']; ?>
            <br>
            <i> <?= $company['address'] ?></i>
        </div>
        <div class="header">
            <?php if ($other['inv_thermal'] == 1) { ?>
                <div class="row">
                    <div class="col-12">No Invoice : <?= $bill['invoice'] ?> </div>

                </div>
                <div class="row">
                    <div class="col-12">No Layanan : <?= $bill['no_services'] ?> </div>

                </div>
                <div class="row">
                    <div class="col-12">Nama : <?= $bill['name'] ?></div>

                </div>
                <div class="row">
                    <div class="col-12">Alamat : <?= $bill['address'] ?></div>

                </div>
                <div class="row">
                    <div class="col-12">Periode : <?= indo_month($bill['month']) ?> <?= $bill['year'] ?></div>

                </div>
                <?php if ($bill['status'] == 'BELUM BAYAR') {   ?>
                    <!-- JATUH TEMPO -->

                    <div class="row">
                        <div class="col-12">Jatuh Tempo : <?= indo_date($bill['inv_due_date'])  ?></div>

                    </div>
                    <div class="row">
                        <div class="col-12">Status : Belum Bayar</div>

                    </div>
                <?php } ?>
                <?php if ($bill['status'] == 'SUDAH BAYAR') {   ?>
                    <div class="row">
                        <div class="col-12">Status : Lunas</div>

                    </div>
                    <div class="row">
                        <div class="col-12">Tanggal Bayar : <?= date('d M Y H:i:s', $bill['date_payment']) ?></div>

                    </div>
                    <div class="row">
                        <div class="col-12">Tanggal Cetak : <?= date('d M Y H:i:s') ?></div>

                    </div>
                    <?php if ($bill['create_by'] != 0) { ?>
                        <?php
                        $user_id =  $bill['create_by'];
                        $query = "SELECT *
                            FROM `user` WHERE `user`.`id` =  $user_id";
                        $kolektor = $this->db->query($query)->row_array(); ?>
                        <div class="row">
                            <div class="col-12">Diterima Oleh : <?= $kolektor['name'] ?></div>

                        </div>

                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if ($other['inv_thermal'] == 0) { ?>
                <?php if ($bill['status'] == 'SUDAH BAYAR') {   ?>
                    <div class="row container">
                        <p>Struk Pembayaran Tagihan <?= $company['company_name'] ?></p>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-6">No Invoice</div>
                    <div class="col-6 left-content">: <?= $bill['invoice'] ?></div>
                </div>
                <div class="row">
                    <div class="col-6">No Layanan</div>
                    <div class="col-6 left-content">: <?= $bill['no_services'] ?></div>
                </div>
                <div class="row">
                    <div class="col-6">Nama</div>
                    <div class="col-6 left-content">: <?= $bill['name'] ?> </div>
                </div>
                <div class="row">
                    <div class="col-6">Alamat</div>
                    <div class="col-6 left-content">: <?= $bill['address'] ?> </div>
                </div>
                <div class="row">
                    <div class="col-6">Periode</div>
                    <div class="col-6 left-content">: <?= indo_month($bill['month']) ?> <?= $bill['year'] ?></div>
                </div>
                <?php if ($bill['status'] == 'BELUM BAYAR') {   ?>
                    <!-- JATUH TEMPO -->
                    <?php if ($bill['due_date'] != 0) { ?>
                        <?php $due_date = $bill['due_date'] ?>
                    <?php } ?>
                    <?php if ($bill['due_date'] == 0) { ?>
                        <?php $due_date = $company['due_date'] ?>
                    <?php } ?>
                    <div class="row">
                        <div class="col-6">Jatuh Tempo</div>
                        <div class="col-6 left-content">: <?= $due_date ?> <?= indo_month($bill['month']) ?> <?= $bill['year'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Status</div>
                        <div class="col-6 left-content" style="color: red;">: Belum Bayar</div>
                    </div>
                <?php } ?>
                <?php if ($bill['status'] == 'SUDAH BAYAR') {   ?>
                    <div class="row">
                        <div class="col-6">Status</div>
                        <div class="col-6 left-content" style="color: green;">: Lunas</div>
                    </div>
                    <div class="row">
                        <div class="col-6">Tanggal Bayar</div>
                        <div class="col-6 left-content">: <?= date('d M Y H:i:s', $bill['date_payment']) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Tanggal Cetak</div>
                        <div class="col-6 left-content">: <?= date('d M Y H:i:s') ?></div>
                    </div>
                    <?php if ($bill['create_by'] != 0) { ?>
                        <?php
                        $user_id =  $bill['create_by'];
                        $query = "SELECT *
                            FROM `user` WHERE `user`.`id` =  $user_id";
                        $kolektor = $this->db->query($query)->row_array(); ?>
                        <div class="row">
                            <div class="col-6">Diterima Oleh</div>
                            <div class="col-6 left-content">: <?= $kolektor['name'] ?></div>
                        </div>

                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
        <table class="table" style="border: 1;">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: center">Qty</th>
                    <th style="text-align: right">Harga</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $month =  $bill['month'];
                $year = $bill['year'];
                $no_services = $bill['no_services'];
                $query = "SELECT *, `invoice_detail`.`price` as `detail_price`
                            FROM `invoice_detail`
                            Join `package_item` ON `package_item`.`p_item_id` = `invoice_detail`.`item_id`
                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
                $queryTot = $this->db->query($query)->result(); ?>
                <?php $subTotaldetail = 0;
                foreach ($queryTot as  $dataa)
                    $subTotaldetail += (int) $dataa->total;
                ?>

                <?php if ($subtotal > 0) { ?>
                    <?php $no = 1;
                    foreach ($invoice_detail->result() as $c => $data) { ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++ ?>.</td>
                            <td><?= $data->item_name ?> </td>
                            <td style="text-align: center"><?= $data->qty ?></td>
                            <td style="text-align: right"><?= indo_currency($data->detail_price) ?></td>
                            <td style="text-align: right">
                                <?php if ($data->disc <= 0) { ?>
                                    -
                                <?php } ?>
                                <?php if ($data->disc > 0) { ?>
                                    <?= indo_currency($data->disc)  ?>
                                <?php } ?>
                            </td>
                            <td style="text-align: right"><?= indo_currency($data->total) ?></td>
                            <td><?= $data->remark ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                <?php } ?>
                <?php if ($subtotal <= 0) { ?>
                    <?php
                    foreach ($queryTot as  $dataaa) { ?>
                        <tr>
                            <td><?= $dataaa->name ?> </td>
                            <td style="text-align: center"><?= $dataaa->qty ?></td>
                            <td style="text-align: right"><?= indo_currency($dataaa->detail_price) ?></td>
                            <td style="text-align: right"><?= indo_currency($dataaa->total) ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                <?php } ?>
            </tbody>
            <tfoot>
                <!-- KODE UNIK -->
                <?php if ($bill['codeunique'] == 1) { ?>
                    <?php $code_unique = $bill['code_unique'] ?>
                <?php } ?>
                <?php if ($bill['codeunique'] == 0) { ?>
                    <?php $code_unique = 0 ?>
                <?php } ?>
                <!-- END KODE UNIK -->

                <?php if ($subtotal > 0) { ?>
                    <?php $ppn = $subtotal * ($bill['i_ppn'] / 100) ?>
                <?php } ?>
                <?php if ($subtotal <= 0) { ?>
                    <?php $ppn = $subTotaldetail * ($bill['i_ppn'] / 100) ?>

                <?php } ?>
                <?php if ($bill['i_ppn'] > 0) { ?>
                    <tr class="text-right" style="font-size: small;">
                        <td colspan="3" style="font-size: 12px;">PPN (<?= $bill['i_ppn'] ?>%)</td>
                        <td style="font-size: 12px;"><?= indo_currency($ppn) ?></td>
                    </tr>
                <?php } ?>
                <?php $discount = $bill['disc_coupon'] ?>
                <?php if ($bill['disc_coupon'] > 0) { ?>
                    <tr class="text-right" style="font-size: small;">
                        <th colspan="3">Diskon</th>
                        <th><?= indo_currency($discount) ?></th>
                    </tr>
                <?php } ?>
                <?php if ($bill['codeunique'] == 1) { ?>
                    <tr class="text-right" style="font-size: small;">
                        <td colspan="3" style="font-size: 12px;">Kode Unik</td>
                        <td style="font-size: 12px;"><?= $code_unique ?></td>
                    </tr>
                <?php } ?>
                <tr style="text-align: right">
                    <th colspan="3">Total Tagihan</th>
                    <th>

                        <?php if ($subtotal > 0) { ?>
                            <?= indo_currency($subtotal + $code_unique + $ppn - $discount)  ?>
                        <?php } ?>
                        <?php if ($subtotal == 0) { ?>
                            <?= indo_currency($subTotaldetail + $code_unique + $ppn - $discount)  ?>
                        <?php } ?>

                    </th>

                </tr>
                <tr>
                    <td colspan="4" style="font-size: 12px;">Terbilang :
                        <?php if ($subtotal > 0) { ?>
                            <?= number_to_words($subtotal + $code_unique + $ppn - $discount) ?>
                        <?php } ?>
                        <?php if ($subtotal == 0) { ?>
                            <?= number_to_words($subTotaldetail + $code_unique + $ppn - $discount) ?>
                        <?php } ?>
                        Rupiah</td>
                </tr>
                <?php if ($bill['status'] == 'SUDAH BAYAR') {   ?>
                    <tr>
                        <td colspan="4" style="font-size: 10px;">
                            Tanda Terima ini adalah sah dan harap disimpan sebagai bukti pembayaran
                        </td>
                    </tr>
                <?php } ?>
            </tfoot>

        </table>

        <div class="thanks">
            ~~~ Terima Kasih ~~~
            <br>

        </div>
    </div>
</body>

</html>