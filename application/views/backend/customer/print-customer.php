<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> </title>
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/libraries/bootstrap/css/bootstrap.css">
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>

<body onload="window.print()">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            /* font: 12pt "Tahoma"; */
        }

        .invoice h3 {
            margin-top: -40px;
            font-weight: bold;
            font-size: 25px;
        }

        .invoice h6 {
            margin-top: -10px;
            font-size: 16px;
        }

        .invoice span {
            margin-top: -70px;
            font-size: 12px;
        }

        .invoice img {
            margin-top: -40px;
            max-height: 60px;
        }

        .invoice-title h3 {
            margin-top: -15px;
            font-size: 40px;
            font-weight: bold;
            color: darkblue;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }





        @page {
            size: A4;
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
                page-break-after: always;
            }
        }
    </style>
    <div class="book">
        <div class="page">

            <!--INFORMASI DATA DIRI-->
            <div class="row invoice">
                <div class="col-8">
                    <h3><?= $company['company_name'] ?></h3>

                    <h6>
                        <?= $company['sub_name'] ?>
                    </h6>
                    <span style="font-style: italic;">Alamat : <?= $company['address'] ?></span> <br>
                    <span>No HP : <?= $company['whatsapp'] ?> email : <?= $company['email'] ?></span>
                </div>
                <div class="col-4 text-right">
                    <img src="<?= base_url('assets/images/' . $company['logo']) ?>" alt="logo" align="right" width="104" height="">

                </div>
            </div>
            <hr>
            <b>DATA PELANGGAN</b>
            <hr>
            <table style="width:50%">
                <!--FOTO-->
                <!-- <img src="<?= base_url('assets/images/' . $company['logo']) ?>" align="right" width="104" height="142"> -->

                <tr>
                    <td>Nama </td>
                    <td> : <?= $customer['name']; ?> </td>
                </tr>
                <tr>
                    <td>No Layanan </td>
                    <td> : <?= $customer['no_services']; ?> </td>
                </tr>

                <tr>
                    <td>No HP</td>
                    <td>: <?= $customer['no_wa']; ?></td>
                </tr>
                <tr>
                    <td>ID Card</td>
                    <td>: <?= $customer['type_id']; ?> - <?= $customer['no_ktp']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: <?= $customer['email']; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : <?= $customer['address']; ?></td>
                </tr>
                <tr>
                    <td>Area</td>
                    <?php $coverage = $this->db->get_where('coverage', ['coverage_id' => $customer['coverage']])->row_array() ?>
                    <td> : <?= $coverage['c_name']; ?></td>
                </tr>

                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>Router </td>
                    <?php $router = $this->db->get_where('router', ['id' => $customer['router']])->row_array() ?>

                    <td> : <?= $router['alias']; ?> </td>
                </tr>
                <tr>
                    <td>Mode </td>
                    <td> : <?= $customer['mode_user']; ?> </td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>: <?= $customer['user_mikrotik']; ?></td>
                </tr>
                <tr>
                    <td>ODC</td>
                    <?php $odc = $this->db->get_where('m_odc', ['id_odc' => $customer['id_odc']])->row_array() ?>
                    <td>: <?= $odc['code_odc']; ?> </td>
                </tr>
                <tr>
                    <td>ODP</td>
                    <?php $odp = $this->db->get_where('m_odp', ['id_odp' => $customer['id_odp']])->row_array() ?>

                    <td>: <?= $odp['code_odp']; ?> Port <?= $customer['no_port_odp']; ?></td>
                </tr>
            </table>
            <hr>
            <b>DATA PAKET</b>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>Item</th>
                        <th>Kategori</th>
                        <th style="text-align: center">Jumlah</th>
                        <th style="text-align: center">Harga</th>
                        <th style="text-align: center">Diskon</th>
                        <th style="text-align: center">Total</th>
                        <th>Keterangan</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $subtotal = 0;
                    foreach ($services->result() as $c => $data) {
                        $subtotal += (int) $data->total;
                    } ?>

                    <?php $no = 1;
                    if ($services->num_rows() > 0) {
                        foreach ($services->result() as $c => $data) { ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $data->item_name ?> <br> <i><?= $data->descriptionItem; ?></i></td>
                                <td><?= $data->category_name ?></td>
                                <td style="text-align: center"><?= $data->qty ?></td>
                                <td style="text-align: right"><?= indo_currency($data->services_price) ?></td>
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
                    } else {
                        echo '<tr>
        <td colspan="9" class="text-center">Belum ada layanan</td>
    </tr>';
                    } ?>
                <tfoot>
                    <?php if ($customer['ppn'] == 1) { ?>
                        <tr style="text-align: right">
                            <th colspan="6">PPN</th>
                            <th><?= indo_currency($subtotal * ($company['ppn'] / 100)) ?></th>
                        </tr>
                    <?php } ?>
                    <tr style="text-align: right">
                        <th colspan="6"><b> Total</b></th>
                        <th><?= indo_currency($customer['cust_amount']) ?></th>
                    </tr>
                </tfoot>
                </tbody>
            </table>

            <hr>


        </div>

    </div>
    <!-- end page -->
    <script src="<?= base_url('assets/') ?>frontend/libraries/jquery/jquery-3.4.1.min.js"></script>
    <script src="<?= base_url('assets/') ?>frontend/libraries/bootstrap/js/bootstrap.js"></script>
</body>

</html>