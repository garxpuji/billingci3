<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= $data['invoice'] ?> a/n <?= $data['name'] ?> Periode <?= indo_month($data->month) ?> <?= $data->year ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/libraries/bootstrap/css/bootstrap.css">
</head>

<body onload="window.print()">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 24cm;

            height: 14.90 cm;
            padding: 1cm;
            margin: 10mm auto;
            margin-left: 10cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            /* padding: 1cm; */
            /* border: 1px solid; */
            min-height: 190mm;
            outline: 0cm #FFEAEA solid;
        }

        .invoice {
            margin-left: -60px;
            margin-top: 10px;
        }

        .invoice h3 {
            /* margin-top: -40px; */
            font-weight: bold;
            font-size: 25px;
            letter-spacing: 2px;
        }

        .invoice h6 {
            /* font-weight: bold; */
            font-size: 14px;
            letter-spacing: 2px;
        }

        .invoice span {
            margin-top: -55px;
            font-size: 14px;
            letter-spacing: 2px;
        }

        .invoice img {


            max-height: 60px;
        }

        .invoice-title h3 {
            /* margin-top: -15px; */
            font-size: 20px;
            letter-spacing: 2px;
            font-weight: bold;
            color: darkblue;
        }


        .fromto h5 {
            font-weight: bold;
            font-size: 20px;
            letter-spacing: 2px;
        }

        .lunas {
            text-align: center;
            font-weight: bold;
            color: green;
            border-width: 2px;
            border-style: dashed solid;
            position: relative;
            margin: 1em 0;
            transform: rotate(-20deg);
            -ms-transform: rotate(-20deg);
            -webkit-transform: rotate(-20deg);
        }

        @page {
            /* size: A4; */
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                /* page-break-after: always; */
            }
        }

        .table {
            font-size: 14x;
            letter-spacing: 2px;
            /* color: #D3D3D3; */
        }
    </style>
    <?php
    foreach ($bill as $r => $data) { ?>
        <div class="book">
            <div class="page">
                <div class="subpage">
                    <div class="row invoice">
                        <div class="col-5 text-center">
                            <img src="<?= base_url('assets/images/' . $company['logo']) ?>" alt="logo">
                            <h4><?= $company['company_name']; ?></h4>
                            <span><?= $company['address']; ?></span><br>
                            <span><?= $company['whatsapp']; ?></span>
                        </div>

                        <div class="col-4 text-right">
                            <br>
                            <h6>No Invoice :</h6>
                            <h6>Tanggal :</h6>
                            <h6>Jatuh Tempo :</h6>
                            <h6>No. Pel :</h6>
                            <h6>Nama :</h6>
                            <h6>Alamat :</h6>
                        </div>

                        <div class="col-3 text-left" style="margin-left:15">
                            <br>
                            <h6><?= $data->invoice ?></h6>
                            <h6> <?= date('d-m-Y', $data->created_invoice) ?></h6>
                            <h6><?= indo_date($data->inv_due_date) ?></h6>
                            <h6><?= $data->no_services ?></h6>
                            <h6><?= $data->name ?></h6>
                            <h6><?= $data->address ?></h6>
                        </div>
                    </div>
                    <div class="row justify-content-between mt-2" style="letter-spacing: 2px;">
                        <div class="col-6">Periode <?= indo_month($data->month) ?> <?= $data->year ?></div>
                        <div class="invoice-title">
                            <h3>INVOICE</h3>
                        </div>

                    </div>
                    <table class="table">
                        <thead>
                            <tr style="font-size: 14;letter-spacing: 2px;">
                                <th style="text-align: center; width:10px">No</th>
                                <th>Item</th>
                                <th style="text-align: center">Qty</th>
                                <th style="text-align: right">Harga</th>
                                <th style="text-align: center">Disc</th>
                                <th style="text-align: right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $month =  $data->month;
                            $year = $data->year;
                            $no_services = $data->no_services;
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
                            <tr>
                                <?php
                                $month =  $data->month;
                                $year = $data->year;
                                $no_services = $data->no_services;
                                $query = "SELECT *, `invoice_detail`.`price` as `detail_price`
                                    FROM `invoice_detail`  JOIN `package_item` 
                                                                ON `invoice_detail`.`item_id` = `package_item`.`p_item_id`
                                                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
                                $querying = $this->db->query($query)->result(); ?>
                                <?php $subtotal = 0;
                                foreach ($querying as  $dataa)
                                    $subtotal += (int) $dataa->total;
                                ?>
                                <?php $no = 1;
                                foreach ($querying as  $dataa) {
                                ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= $dataa->name ?> <br> <span style="font-size:12px"><?= $dataa->description ?></td>
                                <td style="text-align: center;"><?= $dataa->qty ?></td>
                                <td style="text-align: right;"><?= indo_currency($dataa->detail_price) ?></td>
                                <td style="text-align: right;"> <?php if ($dataa->disc <= 0) { ?>
                                        -
                                    <?php } ?>
                                    <?php if ($dataa->disc > 0) { ?>
                                        <?= indo_currency($dataa->disc)  ?>
                                    <?php } ?></td>

                                <td style="text-align: right;"><?= indo_currency($dataa->total) ?></td>
                            </tr>
                        <?php } ?>
                        </tr>

                        <?php if ($subtotal <= 0) { ?>
                            <?php $no = 1;
                            foreach ($queryTot as  $dataa) { ?>
                                <tr>
                                    <td style="text-align: center;"><?= $no++ ?>.</td>
                                    <td><?= $dataa->name ?> </td>
                                    <td style="text-align: center"><?= $dataa->qty ?></td>
                                    <td style="text-align: right"><?= indo_currency($dataa->price) ?></td>
                                    <td style="text-align: right">
                                        <?php if ($dataa->disc <= 0) { ?>
                                            -
                                        <?php } ?>
                                        <?php if ($dataa->disc > 0) { ?>
                                            <?= indo_currency($dataa->disc)  ?>
                                        <?php } ?>
                                    </td>
                                    <td style="text-align: right"><?= indo_currency($dataa->total) ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <!-- KODE UNIK -->
                            <?php if ($data->codeunique == 1) { ?>
                                <?php $code_unique = $data->code_unique ?>
                            <?php } ?>
                            <?php if ($data->codeunique == 0) { ?>
                                <?php $code_unique = 0 ?>
                            <?php } ?>
                            <!-- END KODE UNIK -->

                            <?php if ($subtotal > 0) { ?>
                                <?php $ppn = $subtotal * ($data->i_ppn / 100) ?>
                            <?php } ?>
                            <?php if ($subtotal <= 0) { ?>
                                <?php $ppn = $subTotaldetail * ($data->i_ppn / 100) ?>

                            <?php } ?>
                            <?php if ($data->i_ppn > 0) { ?>
                                <tr class="text-right" style="font-size: small;">
                                    <th colspan="5">PPN (<?= $data->i_ppn ?>%)</th>
                                    <th><?= indo_currency($ppn) ?></th>
                                </tr>
                            <?php } ?>
                            <?php $discount = $data->disc_coupon ?>
                            <?php if ($data->disc_coupon > 0) { ?>
                                <tr class="text-right" style="font-size: small;">
                                    <th colspan="5">Diskon</th>
                                    <th><?= indo_currency($discount) ?></th>
                                </tr>
                            <?php } ?>
                            <?php if ($data->codeunique == 1) { ?>
                                <tr class="text-right" style="font-size: small;">
                                    <th colspan="5">Kode Unik</th>
                                    <th><?= $code_unique ?></th>
                                </tr>
                            <?php } ?>
                            <tr style="text-align: right">
                                <th colspan="5">Total Tagihan</th>
                                <?php if ($subtotal > 0) { ?>
                                    <th><?= indo_currency($subtotal + $code_unique + $ppn - $discount)  ?></th>
                                <?php } ?>
                                <?php if ($subtotal <= 0) { ?>
                                    <th><?= indo_currency($subTotaldetail + $code_unique + $ppn - $discount)  ?></th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-left" style="font-size: 12; letter-spacing: 2px; margin-top:-20px">
                        <?php if ($other['remark_invoice'] != null) { ?>
                            Keterangan : <?= $other['remark_invoice']; ?>
                        <?php } ?>
                    </div>
                    <div class="row mt-4" style="font-size: 14px;letter-spacing: 2px;">
                        <div class="col"></div>
                        <div class="col text-center">
                            <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                <h6 style="font-weight: bold; color:green">LUNAS</h6>
                                <span>Pembayaran : <?= $data->metode_payment ?></span>
                                <br>
                                <span> <?= date('d M Y h:i:s', $data->date_payment); ?></span>
                                <br>
                                <?php $create_by = $data->create_by;
                                $query = "SELECT *
                                    FROM `user`
                                        WHERE `user`.`id` = $create_by";
                                $create = $this->db->query($query)->row_array();
                                ?>
                                <?php if ($data->create_by > 0) { ?>
                                    <span><?= $create['name'] ?></span>
                                <?php } ?>

                                <br>
                            <?php } ?>
                        </div>
                        <div class="col text-center">
                            <?= $company['company_name']; ?>
                            <br><br><br><br>
                            <?= $user['name']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- end page -->
    <script src="<?= base_url('assets/') ?>frontend/libraries/jquery/jquery-3.4.1.min.js"></script>
    <script src="<?= base_url('assets/') ?>frontend/libraries/bootstrap/js/bootstrap.js"></script>
</body>

</html>