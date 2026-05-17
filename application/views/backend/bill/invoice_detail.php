<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

<div class="col-lg-12">
    <div class="card shadow mb-2">
        <div class="card-header py-1">
            <h6 class="m-0 font-weight-bold">Rincian Tagihan</h6> #<?= $bill['no_services'] ?>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Nama Pelanggan</label>
                            <div class="col-sm-9">
                                <input type="text" name="date1" id="date1" value="<?= $bill['name'] ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Periode </label>
                            <div class="col-sm-9">
                                <input type="text" name="date1" id="date1" value="<?= indo_month($bill['month']) ?> <?= $bill['year'] ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($this->session->userdata('role_id') == 1) { ?>
                    <?php if ($bill['status'] == 'SUDAH BAYAR') { ?>
                        <div class="col-md-3">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <?php $getuser = $this->db->get_where('user', ['id' => $bill['create_by']])->row_array() ?>
                                    <label class="col-sm-12 control-label">Edit Penerima</label>
                                    <?php $income = $this->db->get_where('income', ['invoice_id' => $bill['invoice'], 'no_services' => $bill['no_services']])->row_array() ?>
                                    <?php if ($income['create_by'] == '0' && $income['mode_payment'] == 'Payment Gateway') { ?>
                                        <input type="text" value="Payment Gateway" class="form-control" readonly>
                                    <?php } ?>
                                    <?php if ($income['create_by'] != '0' && $income['mode_payment'] != 'Payment Gateway') { ?>
                                        <select name="create_by" id="createby" class="form-control select2" required>
                                            <option value="<?= $bill['create_by'] ?>"><?= $getuser['name']; ?></option>
                                            <?php $userlist = $this->bill_m->getreceipt()->result() ?>
                                            <?php foreach ($userlist as $key => $data) { ?>
                                                <option value="<?= $data->id ?>"><?= $data->name ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                    <?php if ($income['create_by'] == '0' && $income['mode_payment'] != 'Payment Gateway') { ?>
                                        <select name="create_by" id="createby" class="form-control select2" required>
                                            <option value="">-Pilih-</option>
                                            <?php $userlist = $this->bill_m->getreceipt()->result() ?>
                                            <?php foreach ($userlist as $key => $data) { ?>
                                                <option value="<?= $data->id ?>"><?= $data->name ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                <?php if ($bill['status'] == 'BELUM BAYAR') { ?>
                    <div class="col-md-3">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Jatuh Tempo</label>
                                <div class="col-sm-8">
                                    <input type="text" name="inv_due_date" id="inv_due_date" value="<?= $bill['inv_due_date'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Tanggal Isolir</label>
                                <div class="col-sm-8">
                                    <input type="text" name="date_isolir" id="date_isolir" value="<?= $bill['date_isolir'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php if ($bill['status'] == 'BELUM BAYAR') { ?>
    <?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
    <?php if ($pg['is_active'] == 1) { ?>
        <?php if ($pg['vendor'] == 'Xendit') { ?>
            <?php if ($bill['x_id'] != '') { ?>
                <div class="col-lg-12">
                    <div class="card shadow mb-2">
                        <div class="card-header py-1">
                            <h6 class="m-0 font-weight-bold">Data Payment Gateway
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">ID</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="date1" id="date1" value="<?= $bill['x_id'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">External ID</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="date1" id="date1" value="<?= $bill['x_external_id'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Expired</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="date1" id="date1" value="<?= $bill['x_expired'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">URL Checkout</label>
                                            <div class="row">
                                                <div class="col">
                                                    <a target="blank" href="<?= $bill['payment_url'] ?>" class="btn btn-primary">Checkout</a>
                                                </div>
                                                <div class="col"> <a href="<?= site_url('bill/resetpaymentgateway?invoice=' . $bill['invoice']) ?>" onclick="return confirm('Anda yakin akan reset data payment gateway tagihan ini ?')" class="btn btn-danger">Reset</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        <?php } ?>
        <?php if ($pg['vendor'] == 'Tripay') { ?>
            <?php if ($bill['x_external_id'] == '') { ?>
                <div class="container">
                    <h3 style="font-weight:bold; color:red"> <a href="#" data-toggle="modal" data-target="#chekout" class="btn btn-primary">Checkout Payment Gateway</a> </h3>
                </div>

                <div class="modal fade" id="chekout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pilih Metode Pembayaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('tripay/checkout'); ?>" method="post">
                                <div class="modal-body">

                                    <input type="hidden" name="invoice" value="<?= $bill['invoice'] ?>">
                                    <input type="hidden" name="no_services" value="<?= $bill['no_services'] ?>">
                                    <input type="hidden" name="amount" id="amounttripay" value="<?= $bill['amount'] + $pg['admin_fee'] ?>">
                                    <?php if ($pg['mode'] == 0) { ?>
                                        <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                                    <?php } ?>


                                    <div class="form-group">
                                        <label for="">Tagihan</label>
                                        <input type="text" class="form-control" value="<?= indo_currency($bill['amount']); ?>" readonly>

                                    </div>
                                    <?php if ($pg['admin_fee'] > 0) { ?>
                                        <div class="form-group">
                                            <label for="">Biaya Admin</label>
                                            <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                                        </div>
                                    <?php } ?>


                                    <?php

                                    $apiKey = $pg['api_key'];

                                    if ($pg['mode'] == 1) {
                                        $url = "https://tripay.co.id/api/merchant/payment-channel"; // Production
                                    } else {
                                        $url = 'https://tripay.co.id/api-sandbox/merchant/payment-channel'; // Sandbox
                                    }

                                    $curl = curl_init();

                                    curl_setopt_array($curl, array(
                                        CURLOPT_FRESH_CONNECT     => true,
                                        CURLOPT_URL               => $url,
                                        CURLOPT_RETURNTRANSFER    => true,
                                        CURLOPT_HEADER            => false,
                                        CURLOPT_HTTPHEADER        => array(
                                            "Authorization: Bearer " . $apiKey
                                        ),
                                        CURLOPT_FAILONERROR       => false
                                    ));

                                    $response = curl_exec($curl);
                                    $err = curl_error($curl);
                                    $response = json_decode($response, true);
                                    // curl_close($curl);
                                    // var_dump($response['data'][0]['group']);
                                    // echo !empty($err) ? $err : $response;

                                    ?>
                                    <div class="form-group">
                                        <label for=""><span style="color: red;">Metode Pembayaran</span></label>

                                        <select class="form-control" name="selectpaymenttripay" required>
                                            <option value="">-Pilih-</option>
                                            <?php foreach ($response['data'] as $data) { ?>
                                                <option value="<?= $data['code']; ?>"><?= $data['name']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tanggal Expired</label>
                                        <input type="text" class="form-control" name="expired" id="datepicker" value="<?= date('Y-m-' . jumlah_hari($month, $year)) ?>" required>
                                    </div>
                                    * Catatan : link checkout akan dikirim ke whatsapp pelanggan, pastikan wa gateway connected dan nomor pelanggan sudah terdaftar di whatsapp.
                                    <br>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <?php if ($bill['x_external_id'] != '') { ?>
                <div class="col-lg-12">
                    <div class="card shadow mb-2">
                        <div class="card-header py-1">
                            <h6 class="m-0 font-weight-bold">Data Payment Gateway
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">External ID</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="date1" id="date1" value="<?= $bill['x_external_id'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Channel Pembayaran</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="date1" id="date1" value="<?= $bill['x_method'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Kode Pembayaran</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="date1" id="date1" value="<?= $bill['x_account_number'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">URL Checkout</label>
                                            <div class="row">
                                                <div class="col">
                                                    <a target="blank" href="<?= $bill['payment_url'] ?>" class="btn btn-primary">Checkout</a>
                                                </div>
                                                <div class="col"> <a href="<?= site_url('bill/resetpaymentgateway?invoice=' . $bill['invoice']) ?>" onclick="return confirm('Anda yakin akan reset data payment gateway tagihan ini ?')" class="btn btn-danger">Reset</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } ?>
<div class="container">
    <?php $this->view('messages') ?>
</div>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <?php if ($bill['status'] == 'SUDAH BAYAR') { ?>

                    <h3 style="font-weight:bold; color:green"><?= $bill['status'] ?> </h3>
                    <?php if ($this->session->userdata('role_id') == 1 or $role['edit_bill'] == 1) { ?>
                        <a href="" data-toggle="modal" data-target="#editstatus" class="badge badge-danger">Edit Belum Bayar</a>
                    <?php } ?>
                <?php } ?>
                <?php if ($bill['status'] == 'BELUM BAYAR') { ?>
                    <h3 style="font-weight:bold; color:red"><?= $bill['status'] ?> </h3>
                <?php } ?>
                <?php $subtotal = 0;
                foreach ($invoice->result() as $c => $data) {
                    $subtotal += (int) $data->total;
                } ?>
                <?php $link = "https://$_SERVER[HTTP_HOST]"; ?>
                <?php $month = $bill['month'];
                $year = $bill['year'];
                $no_services = $bill['no_services'];
                $query = "SELECT * FROM `invoice_detail` WHERE `invoice_detail`.`d_month` =  $month and `invoice_detail`.`d_year` =  $year and `invoice_detail`.`d_no_services` =  $no_services";
                $queryTot = $this->db->query($query)->result(); ?><?php $subTotaldetail = 0;
                                                                    foreach ($queryTot as  $dataa) $subTotaldetail += (int) $dataa->total; ?>

                <?php $tagihan = $bill['amount'] - $bill['disc_coupon']  ?>

                <?php
                $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                $replace = array($bill['name'], $bill['no_services'], $bill['month'], $bill['year'], indo_month($bill['month']) . ' ' . $bill['year'], $bill['due_date'], indo_currency($tagihan  + $code_unique), $company['company_name'], $company['sub_name'], base_url(), '%0A');
                $subject = $other['thanks_wa'];
                $message = str_replace($search, $replace, $subject); ?>
                <?php if ($bill['status'] == 'SUDAH BAYAR') { ?>
                    <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($bill['no_wa']) ?>&text=<?= $message ?>" class="btn btn-success" target="blank"> <i class="fa fa-whatsapp"> Send Thank's</i></a>
                <?php } ?>
                <?php if ($bill['status'] == 'BELUM BAYAR') { ?>
                    <?php if ($this->session->userdata('role_id') == 1 or $role['edit_bill'] == 1) { ?>
                        <?php if ($bill['i_ppn'] > 0) { ?>
                            <span>PPN <input type="checkbox" checked onclick="javascript:window.location.href='<?= base_url('bill/setppn/' . $bill['invoice'] . '/0'); ?>'"></span>
                        <?php } ?>
                        <?php if ($bill['i_ppn'] == 0) { ?>
                            <span>PPN <input type="checkbox" onclick="javascript:window.location.href='<?= base_url('bill/setppn/' . $bill['invoice'] . '/' . $company['ppn']); ?>'"></span>
                        <?php } ?>

                        <h3 style=" font-weight:bold; color:red"> <a href="#" data-toggle="modal" data-target="#additem" class="btn btn-primary">Tambah Item</a> </h3>
                    <?php } ?>
                    <h3 style=" font-weight:bold; color:red"> <a href="#" data-toggle="modal" data-target="#bayar" class="btn btn-success">Bayar ?</a> </h3>
                <?php } ?>
            </div>
        </div>
        <br>
        <div class="card-body py-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-widget">
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr style="text-align: center">
                                        <th style="text-align: center; width:20px">No</th>
                                        <th>Item Layanan</th>
                                        <th>Kategori</th>
                                        <th style="text-align: center">Jumlah</th>
                                        <th style="text-align: center">Harga</th>
                                        <th style="text-align: center">Diskon</th>
                                        <th style="text-align: center">Total</th>
                                        <th>Keterangan</th>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['edit_bill'] == 1) { ?>
                                            <?php if ($bill['status'] == 'BELUM BAYAR') { ?>
                                                <th>Aksi</th>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id="dataTables">
                                    <?php if ($invoice->num_rows() > 0) { ?>
                                        <?php $no = 1;
                                        foreach ($invoice->result() as $c => $data) { ?>
                                            <tr>
                                                <td><?= $no++ ?>.</td>
                                                <td><?= $data->item_name ?></td>
                                                <td><?= $data->category_name ?></td>
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
                                                <?php if ($this->session->userdata('role_id') == 1 or $role['edit_bill'] == 1) { ?>
                                                    <?php if ($bill['status'] == 'BELUM BAYAR') { ?>
                                                        <td>
                                                            <a href="" class="btn" id="itemupdate" data-toggle="modal" data-target="#edititem" data-detail_id="<?= $data->detail_id ?>" data-invoice="<?= $data->invoice_id ?>" data-disc="<?= $data->disc ?>" data-total="<?= $data->total ?>" data-remark="<?= $data->remark ?>" data-item_name="<?= $data->item_name ?>" data-qty="<?= $data->qty ?>" data-detail_price="<?= $data->detail_price ?>"> <i class="fa fa-edit" style="color: blue;"></i></a>
                                                            <a href="<?= site_url('bill/deliteminv/' . $data->detail_id) ?>" class="btn "> <i class="fa fa-trash" style="color: red;" onclick="return confirm('Apakah anda yakin akan hapus layanan <?= $data->item_name ?> ?')"></i></a>
                                                        </td>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($invoice->num_rows() == 0) { ?>
                                        <?php
                                        $month =   $bill['month'];
                                        $year = $bill['year'];
                                        $no_services = $bill['no_services'];
                                        $query = "SELECT * ,invoice_detail.price as detail_price, package_item.name as item_name, package_category.name as category_name
                                    FROM `invoice_detail`
                                    JOIN `package_item` 
                                    ON `package_item`.`p_item_id` = `invoice_detail`.`item_id`
                                    JOIN `package_category` 
                                     ON `package_category`.`p_category_id` = `invoice_detail`.`category_id`
                                        WHERE `invoice_detail`.`d_month` = $month  and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $no_services";
                                        $queryInv = $this->db->query($query)->result();
                                        // var_dump($queryInv);
                                        // die;
                                        foreach ($queryInv as $value) {
                                            if ($value->invoice_id == null) {
                                                $this->db->set('invoice_id', $bill['invoice']);
                                                $this->db->where('d_no_services', $no_services);
                                                $this->db->where('d_month', $month);
                                                $this->db->where('d_year', $year);
                                                $this->db->where('detail_id', $value->detail_id);
                                                $this->db->update('invoice_detail');
                                            }
                                        }


                                        ?>
                                        <?php $no = 1;
                                        foreach ($queryInv as $data) : ?>
                                            <tr>
                                                <td><?= $no++ ?>.</td>
                                                <td><?= $data->item_name ?></td>
                                                <td><?= $data->category_name ?></td>
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
                                                <?php if ($this->session->userdata('role_id') == 1) { ?>
                                                    <?php if ($bill['status'] == 'BELUM BAYAR') { ?>
                                                        <td>
                                                            <a href="" class="btn" id="itemupdate" data-toggle="modal" data-target="#edititem" data-detail_id="<?= $data->detail_id ?>" data-invoice="<?= $bill['invoice'] ?>" data-disc="<?= $data->disc ?>" data-total="<?= $data->total ?>" data-remark="<?= $data->remark ?>" data-item_name="<?= $data->item_name ?>" data-qty="<?= $data->qty ?>" data-detail_price="<?= $data->detail_price ?>"> <i class="fa fa-edit" style="color: blue;"></i></a>
                                                            <a href="<?= site_url('bill/deliteminv/' . $data->detail_id) ?>" class="btn "> <i class="fa fa-trash" style="color: red;" onclick="return confirm('Apakah anda yakin akan hapus layanan <?= $data->item_name ?> ?')"></i></a>
                                                        </td>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php } ?>
                                <tfoot>
                                    <tr style="text-align: right">
                                        <th colspan="6">Total</th>
                                        <?php if ($subtotal != 0) { ?>
                                            <th><?= indo_currency($subtotal) ?></th>
                                        <?php } ?>
                                        <?php if ($subtotal == 0) { ?>
                                            <?php
                                            $month = $bill['month'];
                                            $year = $bill['year'];
                                            $no_services = $bill['no_services'];
                                            $query = "SELECT *
                                    FROM `invoice_detail`
                                        WHERE `invoice_detail`.`d_month` =  $month and
                                       `invoice_detail`.`d_year` =  $year and
                                       `invoice_detail`.`d_no_services` =  $no_services";
                                            $queryTot = $this->db->query($query)->result(); ?>
                                            <?php $subTotaldetail = 0;
                                            foreach ($queryTot as  $dataa)
                                                $subTotaldetail += (int) $dataa->total;
                                            ?>
                                            <th><?= indo_currency($subTotaldetail) ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php if ($bill['i_ppn'] > 0) { ?>
                                        <?php if ($subtotal != 0) { ?>
                                            <?php $ppn = $subtotal * ($bill['i_ppn'] / 100) ?>
                                        <?php } ?>
                                        <?php if ($subtotal == 0) { ?>
                                            <?php $ppn = $subTotaldetail * ($bill['i_ppn'] / 100) ?>
                                        <?php } ?>
                                        <tr style="text-align: right">
                                            <th colspan="6">Ppn (<?= $bill['i_ppn'] ?>%) </th>
                                            <th><?= indo_currency($ppn) ?></th>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($bill['codeunique'] == 1) {
                                        $codeunique = $bill['code_unique'];
                                    } else {
                                        $codeunique = 0;
                                    } ?>
                                    <?php if ($bill['codeunique'] == 1) { ?>

                                        <tr style="text-align: right">
                                            <th colspan="6">Kode Unik</th>
                                            <th><?= $bill['code_unique'] ?></th>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($bill['disc_coupon'] > 0) { ?>

                                        <tr style="text-align: right">
                                            <th colspan="6">Diskon </th>
                                            <th><?= indo_currency($bill['disc_coupon']) ?></th>
                                        </tr>
                                    <?php } ?>
                                    <tr style="text-align: right">
                                        <th colspan="6">Grand Total</th>
                                        <?php if ($subtotal != 0) { ?>
                                            <th><?= indo_currency($subtotal + $ppn + $codeunique - $bill['disc_coupon']) ?></th>
                                        <?php } ?>
                                        <?php if ($subtotal == 0) { ?>
                                            <th><?= indo_currency($subTotaldetail + $ppn + $codeunique - $bill['disc_coupon']) ?></th>
                                        <?php } ?>
                                    </tr>


                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editstatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Status Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/editstatus') ?>
                Apakah anda yakin akan edit status tagihan menjadi belum bayar ?,
                <input type="hidden" name="invoice" value="<?= $bill['invoice'] ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edititem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/updateitem') ?>
                <div class="form-group">
                    <label>Nama Layanan</label>
                    <input type="hidden" name="detail_id" id="detail_id">
                    <input type="hidden" name="invoice" id="invoice">
                    <input type="text" name="itemame" id="item_name" readonly class="form-control">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="detail_price" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="qty">Qty</label>
                            <input type="number" name="qty" id="qty" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="disc">Disc</label>
                            <input type="number" name="disc" id="disc" min="0" value="0" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="text" id="total" name="total_modal" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <input type="text" id="remark" name="remark" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('bill/additem') ?>" method="POST">

                    <div class="form-group">
                        <label for="item_id">Paket</label>
                        <select name="item_id" id="item_id" class="form-control">
                            <option value="">-Pilih-</option>

                            <?php foreach ($p_item as $data) { ?>
                                <option value="<?= $data->p_item_id ?>"><?= $data->nameItem ?> - <?= $data->price; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty" min="1" class="form-control" value="1">
                        <input type="hidden" name="invoice" class="form-control" value="<?= $bill['invoice'] ?>">
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="bayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('bill/payment') ?>" method="POST">
                    <input type="hidden" name="invoice" value="<?= $bill['invoice'] ?>">
                    <input type="hidden" name="no_services" value="<?= $bill['no_services'] ?>">
                    <input type="hidden" name="name" value="<?= $bill['name'] ?>">
                    <input type="hidden" name="nominal" value="<?= $tagihan   ?>">
                    <input type="hidden" name="to_email" value="<?= $company['email'] ?>">
                    <input type="hidden" name="agen" value="<?= $user['name'] ?>">
                    <input type="hidden" name="email_customer" value="<?= $bill['email'] ?>">
                    <input type="hidden" name="periode" value="<?= indo_month($bill['month']) ?> <?= $bill['year'] ?>">
                    <input type="hidden" name="email_agen" value="<?= $user['email'] ?>">
                    <input type="hidden" name="year" value="<?= $bill['year'] ?>">
                    <input type="hidden" name="month" value="<?= indo_month($bill['month']) ?>">
                    Apakah yakin Tagihan dengan no layanan <?= $bill['no_services'] ?> a/n <b><?= $bill['name'] ?></b> Periode <?= indo_month($bill['month']) ?> <?= $bill['year'] ?> sudah terbayarkan ?, jika sudah silahkan isi tanggal bayar iuran.
                    <br>
                    <br>
                    <?php if ($this->session->userdata('role_id') == 1) { ?>
                        <div class="form-group">
                            <label for="date_payment"><b> Tanggal Bayar</b></label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                            <input type="text" name="date_payment" autocomplete="off" id="datepickerdisablefuture" class="form-control" required>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->userdata('role_id') != 1) { ?>
                        <input type="hidden" name="date_payment" autocomplete="off" value="<?= date('Y-m-d') ?>" class="form-control">
                    <?php } ?>
                    <div class="form-group mt-2">
                        <label for="">Nominal</label>
                        <input type="text" value="<?= indo_currency($tagihan) ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="">Metode Pembayaran</label>
                        <select name="metode_payment" id="" class="form-control" required>
                            <option value="">-Pilih-</option>
                            <option value="Cash"> Cash </option>
                            <option value="Transfer">Transfer</option>
                            <option value="Payment Gateway">Payment Gateway</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="category" id="" class="form-control" required>
                            <?php $category = $this->db->get('cat_income')->result() ?>
                            <?php foreach ($category as $data) { ?>
                                <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if ($this->session->userdata('role_id') == 1) { ?>
                        <div class="form-group">
                            <label for="">Diterima Oleh</label>
                            <select name="create_by" class="form-control select2" style="width: 100%;" required>
                                <option value="<?= $this->session->userdata('id') ?>"><?= $this->session->userdata('name') ?></option>
                                <?php $receipt = $this->bill_m->getreceipt()->result() ?>
                                <?php foreach ($receipt as $data) { ?>
                                    <option value="<?= $data->id ?>"><?= $data->name ?> -
                                        <?= $data->role_id == 1 ? 'Admin' : '' ?>
                                        <?= $data->role_id == 2 ? 'Pelanggan' : '' ?>
                                        <?= $data->role_id == 3 ? 'Operator' : '' ?>
                                        <?= $data->role_id == 4 ? 'Mitra' : '' ?>
                                        <?= $data->role_id == 5 ? 'Teknisi' : '' ?>
                                        <?= $data->role_id == 6 ? 'Outlet' : '' ?>
                                        <?= $data->role_id == 7 ? 'Kolektor' : '' ?>
                                        <?= $data->role_id == 8 ? 'Finance' : '' ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->userdata('role_id') != 1) { ?>
                        <input type="hidden" name="create_by" value="<?= $this->session->userdata('id') ?>">
                    <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- bootstrap datepicker -->
<script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- <link href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet" type="text/css" />
  <script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<script>
    //Date picker
    $('#datepicker').datepicker({
        maxDate: '0',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#datepickerdisablefuture').datepicker({
        maxDate: '0',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        endDate: '+1d'
    });
    $(document).on('click', '#itemupdate', function() {

        $('#item_name').val($(this).data('item_name'))

        $('#detail_id').val($(this).data('detail_id'))
        $('#detail_price').val($(this).data('detail_price'))
        $('#invoice').val($(this).data('invoice'))
        $('#qty').val($(this).data('qty'))
        $('#disc').val($(this).data('disc'))
        $('#total').val($(this).data('total'))
        $('#remark').val($(this).data('remark'))
    })

    function count() {
        var price = $('#detail_price').val()
        var qty = $('#qty').val()
        var disc = $('#disc').val()
        total = (price * qty) - disc
        $('#total').val(total)
    }

    $(document).on('keyup mouseup', '#disc, #qty, #price', function() {
        count()
    })
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '<?= site_url('dashboard/fixbillamount') ?>',
            cache: false,
            success: function(data) {

            }
        });
        $.ajax({
            type: 'get',
            url: '<?= site_url('bill/fixduedate') ?>',
            cache: false,
            success: function(data) {

            }
        });

        return false;
    })
</script>
<script>
    //Date picker
    $('#inv_due_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#date_isolir').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
    $('#inv_due_date').on('change', function() {
        //   alert(this.value);
        var due_date = this.value;
        var invoice = "<?= $bill['invoice'] ?>";
        //   alert(due_date);
        $.ajax({
            type: 'POST',
            data: "&due_date=" + due_date + "&invoice=" + invoice,
            cache: false,
            url: '<?= site_url('bill/updateduedate') ?>',
            cache: false,

            success: function(data) {
                var c = jQuery.parseJSON(data);
                if (c['status'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        html: 'Jatuh tempo berhasil diperbaharui',
                        showConfirmButton: true,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        html: 'Jatuh tempo gagal diperbaharui',
                        showConfirmButton: true,
                    })
                }

            }

        });
    });
    $('#date_isolir').on('change', function() {
        var date_isolir = this.value;
        var invoice = "<?= $bill['invoice'] ?>";
        //   alert(date_isolir);
        $.ajax({
            type: 'POST',
            data: "&date_isolir=" + date_isolir + "&invoice=" + invoice,
            cache: false,
            url: '<?= site_url('bill/updatedateisolir') ?>',
            cache: false,

            success: function(data) {
                var c = jQuery.parseJSON(data);
                if (c['status'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        html: 'Tanggal Isolir berhasil diperbaharui',
                        showConfirmButton: true,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        html: 'Tanggal Isolir gagal diperbaharui',
                        showConfirmButton: true,
                    })
                }

            }

        });
    });
    $('#createby').on('change', function() {
        var create_by = this.value;
        var invoice = "<?= $bill['invoice'] ?>";
        //   alert(create_by);
        $.ajax({
            type: 'POST',
            data: "&create_by=" + create_by + "&invoice=" + invoice,
            cache: false,
            url: '<?= site_url('bill/updatecreateby') ?>',
            cache: false,

            success: function(data) {
                var c = jQuery.parseJSON(data);
                if (c['status'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        html: 'Penerima berhasil diperbaharui',
                        showConfirmButton: true,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        html: 'Penerima gagal diperbaharui',
                        showConfirmButton: true,
                    })
                }

            }

        });
    });
</script>