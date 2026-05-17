<div class="table-responsive">
    <p></p>
    <table class="table table-bordered" id="dataTable" cellspacing="0">
        <thead>
            <tr style="text-align: center">
                <th style="vertical-align : middle;text-align:center;" rowspan="2">No</th>
                <th style="vertical-align : middle;text-align:center" rowspan="2">Nama Pelanggan</th>
                <th style="vertical-align : middle;text-align:center;" rowspan="2">No Layanan</th>
                <th style="vertical-align : middle;text-align:center;" rowspan="2">Tanggal Daftar</th>
                <th colspan="12">Tagihan <?= $year ?></th>
            </tr>
            <tr>
                <td style="text-align: center">Januari</td>
                <td style="text-align: center">Februari</td>
                <td style="text-align: center">Maret</td>
                <td style="text-align: center">April</td>
                <td style="text-align: center">Mei</td>
                <td style="text-align: center">Juni</td>
                <td style="text-align: center">Juli</td>
                <td style="text-align: center">Agustus</td>
                <td style="text-align: center">September</td>
                <td style="text-align: center">Oktober</td>
                <td style="text-align: center">November</td>
                <td style="text-align: center">Desember</td>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($customer as $r => $data) { ?>
                <tr>
                    <td style="text-align: center"><?= $no++ ?>.</td>
                    <td style="width:200px"><?= $data->name ?></td>
                    <td style="text-align: center"><?= $data->no_services ?></td>
                    <td style="text-align: center"><?= indo_date($data->register_date) ?></td>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  01";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>

                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  01 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>

                    <?php } ?>


                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  02";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  02 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>


                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  03";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  03 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  04";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  04 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  05";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  05 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  06";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  06 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  07";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  07 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  08";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  08 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  09";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  09 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  10";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>

                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  10 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  11";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  11 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>

                    <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $data->no_services and  `invoice`.`year` =  $year and `invoice`.`month` =  12";
                    $invoice = $this->db->query($query)->row_array();  ?>
                    <?php if ($invoice == null) { ?>
                        <td style="background-color:skyblue"></td>
                    <?php } ?>
                    <?php if ($invoice != 0) { ?>
                        <?php $inv = $invoice['invoice'];
                        $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`invoice_id` =  $inv";
                        $querying = $this->db->query($query)->result(); ?>
                        <?php $subTotal = 0;
                        foreach ($querying as  $dataa)
                            $subTotal += (int) $dataa->total;
                        ?>
                        <?php if ($subTotal != 0) { ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotal * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"> <?= indo_currency($subTotal + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($subTotal == 0) { ?>
                            <?php $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  12 and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $data->no_services";
                            $queryTot = $this->db->query($query)->result(); ?>
                            <?php $subTotaldetail = 0;
                            foreach ($queryTot as  $dataa)
                                $subTotaldetail += (int) $dataa->total;
                            ?>
                            <td style="text-align: center">
                                <?php
                                if ($invoice['i_ppn'] > 0) {
                                    $ppn = $subTotaldetail * ($invoice['i_ppn'] / 100);
                                } else {
                                    $ppn = 0;
                                }
                                ?>
                                <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                                    <span style="color: red;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                                <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                                    <span style="color: green;"><?= indo_currency($subTotaldetail + $ppn) ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>


                </tr>
            <?php } ?>

        </tbody>
    </table>

</div>