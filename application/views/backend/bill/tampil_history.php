<div class="table-responsive">
    <?php $query = "SELECT *
                                    FROM `customer`
                                        WHERE `customer`.`no_services` =  $no_services";
    $data = $this->db->query($query)->row_array(); ?>
    <?= $data['name'] ?> - <?= $no_services ?> - <?= $year ?>
    <p></p>
    <table style="font-size: 14px;" class="table table-bordered" id="dataTable" cellspacing="0">
        <thead>
            <tr style="text-align: center">
                <th>Bulan</th>
                <th>No Invoice</th>
                <th>Tagihan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td style="text-align: center"> Januari</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  01";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"> <?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center">
                        <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>

                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Februari</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  02";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Maret</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  03";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> April</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  04";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Mei</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  05";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Juni</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  06";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Juli</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  07";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Agustus</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  08";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> September</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  09";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Oktober</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  10";
                $invoice = $this->db->query($query)->row_array();   ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> November</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  11";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align: center"> Desember</td>
                <?php $query = "SELECT *
                                    FROM `invoice`
                                        WHERE `invoice`.`no_services` =  $no_services and
                                       `invoice`.`year` =  $year and
                                       `invoice`.`month` =  12";
                $invoice = $this->db->query($query)->row_array();
                // var_dump($invoice)
                ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <a href="<?= base_url('bill/detail/' . $invoice['invoice']) ?>"><?= $invoice['invoice'] ?></a></td>
                    <td style="text-align: center"><?= indo_currency($invoice['amount']); ?></td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center"> <?php if ($invoice['status'] == 'BELUM BAYAR') { ?>
                            <div class="badge badge-danger">Belum Bayar</div>
                        <?php } ?>
                        <?php if ($invoice['status'] == 'SUDAH BAYAR') { ?>
                            <div class="badge badge-success">Sudah Bayar</div>
                        <?php } ?>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
                <?php if ($invoice != 0) { ?>
                    <td style="text-align: center; width:200px">
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoice/' . $invoice['invoice']) ?>" title="Cetak Invoice A4"><i class="fa fa-print"> A4</i></a>
                        <a style="font-size: 10px;" class="btn btn-primary" target="blank" href="<?= site_url('bill/printinvoicethermal/' . $invoice['invoice']) ?>" title="Cetak Invoice Thermal"><i class="fa fa-print"> Thermal</i></a>
                    </td>
                <?php } ?>
                <?php if ($invoice == 0) { ?>
                    <td> </td>
                <?php } ?>
            </tr>

        </tbody>
    </table>

</div>