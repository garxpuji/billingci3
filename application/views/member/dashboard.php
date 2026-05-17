<head>
    <?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
    <?php if ($pg['vendor'] == 'Midtrans') { ?>
        <?php if ($pg['mode'] == 1) { ?>
            <?php $url = "https://app.midtrans.com/snap/snap.js" ?>
        <?php } ?>
        <?php if ($pg['mode'] == 0) { ?>
            <?php $url = "https://app.sandbox.midtrans.com/snap/snap.js" ?>
        <?php } ?>
        <script type="text/javascript" src="<?= $url ?>" data-client-key=<?= $pg['client_key'] ?>></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <?php } ?>



</head>

<?php $this->view('messages') ?>
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<div class="row">
    <div class="col-lg-4 col-sm-6 col-md-6">
        <a href="<?= site_url('member/status') ?>">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-25">Paket Anda</h6>
                            <h3 class="fw-700 text-blue"><?= $CountServices ?></h3>
                            <p class="mb-0">Item Layanan</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box bg-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php $discount = $invoice->disc_coupon ?>
    <?php $Customer = $this->db->get_where('customer', ['no_services' => $invoice->no_services])->row_array(); ?>
    <div class="col-lg-4 col-sm-6 col-md-6">
        <?php
        if ($totalBill > 0) { ?>
            <a href="" data-toggle="modal" data-target="#Modal">
            <?php } ?>
            <div class=" card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <?php
                            if ($totalBill <= 0) { ?>
                                <h6 class="mb-25">Tagihan <?= indo_month(date('m')) ?> <?= date('Y') ?></h6>
                                <h3 class="fw-700 text-red">-</h3>
                                <p class="mb-0">Belum Tersedia</p>
                            <?php } ?>
                            <?php
                            if ($totalBill > 0) { ?>
                                <?php $countBill = 0;
                                foreach ($CountBill as $c => $data) {
                                    $countBill += $data->total;
                                } ?>
                                <?php
                                $month =   date('m');
                                $year = date('Y');
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
                                <?php if ($countBill <= 0) {  ?>
                                    <?php $ppn = $subTotaldetail * ($invoice->i_ppn / 100) ?>
                                <?php } ?>
                                <?php if ($countBill > 0) {  ?>
                                    <?php $ppn = $countBill * ($invoice->i_ppn / 100) ?>

                                <?php } ?>
                                <!-- KODE UNIK -->
                                <?php if ($Customer['codeunique'] == 1) { ?>
                                    <?php $code_unique = $invoice->code_unique ?>
                                <?php } ?>
                                <?php if ($Customer['codeunique'] == 0) { ?>
                                    <?php $code_unique = 0 ?>
                                <?php } ?>
                                <!-- END KODE UNIK -->
                                <h6 class="mb-10">Tagihan Bulan Ini <?= indo_month(date('m')) ?> <?= date('Y') ?></h6>
                                <?php if ($invoice->status == 'BELUM BAYAR') {  ?>
                                    <?php if ($countBill <= 0) {  ?>
                                        <?php $ppn = $subTotaldetail * ($invoice->i_ppn / 100) ?>
                                        <h3 class="fw-700 text-red"><?= indo_currency($subTotaldetail  + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                    <?php if ($countBill > 0) {  ?>
                                        <?php $ppn = $countBill * ($invoice->i_ppn / 100) ?>
                                        <h3 class="fw-700 text-red"><?= indo_currency($countBill  + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                    <!-- JATUH TEMPO -->

                                    <?php if ($Customer['due_date'] != 0) { ?>
                                        <?php $due_date = $Customer['due_date'] ?>
                                    <?php } ?>
                                    <?php if ($Customer['due_date'] == 0) { ?>
                                        <?php $due_date = $company['due_date'] ?>
                                    <?php } ?>
                                    <p class="mb-0">Bayar tagihan sebelum tanggal <?= indo_date($invoice->inv_due_date); ?></p>
                                <?php } ?>
                                <?php if ($invoice->status == 'SUDAH BAYAR') {  ?>
                                    <?php if ($countBill <= 0) {  ?>
                                        <h3 class="fw-700 text-green"><?= indo_currency($subTotaldetail  + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                    <?php if ($countBill > 0) {  ?>
                                        <h3 class="fw-700 text-green"><?= indo_currency($countBill  + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                    <p class="mb-0">Sudah Dibayar</p>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign bg-red"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
    </div>
    <?php $billunpaid = $this->db->get_where('invoice', ['no_services' => $no_services, 'status' => 'BELUM BAYAR'])->result(); ?>
    <?php if (count($billunpaid) > 0) { ?>
        <div class="col-lg-4 col-sm-6 col-md-6">
            <a href="<?= site_url('member/history') ?>">
                <div class=" card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <?php
                                $totalunpaid = 0;
                                $totalcodeunique = 0;
                                foreach ($billunpaid as $inv) {
                                    $totalunpaid += $inv->amount;
                                    $totalcodeunique += $inv->code_unique;
                                }

                                ?>
                                <?php if ($Customer['codeunique'] == 1) {
                                    $totalcodeunique = $totalcodeunique;
                                } else {
                                    $totalcodeunique = 0;
                                }  ?>
                                <h6 class="mb-10">Tagihan Belum Dibayar</h6>
                                <h3 class="fw-700 text-red"><?= indo_currency($totalunpaid + $totalcodeunique); ?></h3>
                                <p class="mb-0"><?= count($billunpaid); ?> Tagihan</p>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wallet bg-orange"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if ($countBill <= 0) {  ?>
        <?php $tagihan =  $subTotaldetail  + $code_unique + $ppn - $discount ?>
    <?php } ?>
    <?php if ($countBill > 0) {  ?>
        <?php $tagihan =  $countBill  + $code_unique + $ppn - $discount ?>
    <?php } ?>
    <input type="hidden" name="tagihan" id="tagihan" value="<?= $tagihan; ?>">
    <input type="hidden" name="namapelanggan" id="namapelanggan" value="<?= $Customer['name'] ?>">
    <input type="hidden" name="no_services" id="no_services" value="<?= $Customer['no_services'] ?>">
    <input type="hidden" name="email" id="email" value="<?= $Customer['email'] ?>">
    <input type="hidden" name="phone" id="phone" value="<?= $Customer['no_wa'] ?>">
    <input type="hidden" name="address" id="address" value="<?= $Customer['address'] ?>">
    <input type="hidden" name="biayaadmin" id="biayaadmin" value="<?= $pg['admin_fee'] ?>">
    <input type="hidden" name="periode" id="periode" value="<?= indo_month($invoice->month) ?> <?= $invoice->year ?>">
    <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice->invoice ?>">

    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= indo_month(date('m')) ?> <?= date('Y') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="box box-widget">
                            <div class="row text-center">
                                <div class="col">No Layanan</div>
                                <div class="col">Status</div>
                            </div>
                            <div class="row text-center mt-1">
                                <div class="col"><b><?= $no_services ?></b></div>
                                <div class="col">
                                    <?php if ($invoice->status == 'BELUM BAYAR') { ?>
                                        <b class="text-red">Belum Dibayar</b>
                                    <?php } ?>
                                    <?php if ($invoice->status == 'SUDAH BAYAR') { ?>
                                        <b class="text-green">Sudah Dibayar</b>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row mt-3">
                                    <div class="col text-center">
                                        <span>Total</span>
                                        <?php if ($invoice->status == 'BELUM BAYAR') {  ?>
                                            <?php if ($countBill <= 0) {  ?>
                                                <h3 class="fw-700 text-black"><?= indo_currency($subTotaldetail  + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                            <?php if ($countBill > 0) {  ?>
                                                <h3 class="fw-700 text-black"><?= indo_currency($countBill  + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($invoice->status == 'SUDAH BAYAR') {  ?>
                                            <?php if ($countBill <= 0) {  ?>
                                                <h3 class="fw-700 text-green"><?= indo_currency($subTotaldetail  + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                            <?php if ($countBill > 0) {  ?>
                                                <h3 class="fw-700 text-green"><?= indo_currency($countBill  + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                $month =  date('m');
                                $year = date('Y');
                                $query = "SELECT *, `invoice_detail`.`price` as detail_price
                            FROM `invoice_detail` 
                            JOIN `package_item` ON `package_item`.`p_item_id` = `invoice_detail`.`item_id`
                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
                                $queryDetail = $this->db->query($query)->result(); ?>
                                <div class="row">
                                    <div class="col text-center">
                                        Rincian Tagihan #<?= $invoice->invoice ?>
                                        <br><br>
                                        <?php if ($countBill == 0) {  ?>
                                            <?php foreach ($queryDetail as $dataa) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <?= $dataa->name ?>
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($dataa->detail_price) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>



                                            <?php if ($invoice->i_ppn > 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        PPN (<?= $invoice->i_ppn ?>%)
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($ppn) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($invoice->disc_coupon > 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Diskon
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($invoice->disc_coupon) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($Customer['codeunique'] == 1) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Kode Unik
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($code_unique) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($countBill > 0) {  ?>
                                            <?php foreach ($CountBill as $data) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <?= $data->item_name ?>
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($data->detail_price) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>


                                            <?php if ($invoice->i_ppn > 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        PPN (<?= $invoice->i_ppn ?>%)
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($ppn) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($invoice->disc_coupon > 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Diskon
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($invoice->disc_coupon) ?>
                                                    </div>


                                                </div>
                                            <?php } ?>
                                            <?php if ($Customer['codeunique'] == 1) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Kode Unik
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($invoice->code_unique) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row mt-1">

                                    Terbilang : &nbsp;<?php if ($countBill <= 0) {  ?><span><em> <?= number_to_words($subTotaldetail  + $code_unique + $ppn - $discount) ?></em></span>
                                <?php } ?>
                                <?php if ($countBill > 0) {  ?>
                                    <span><em> <?= number_to_words($countBill  + $code_unique + $ppn - $discount) ?></em></span>
                                <?php } ?>
                                </div>
                                <?php if ($invoice->status == 'BELUM BAYAR') { ?>
                                    <div class="row mt-1">
                                        <div class="col text-center">
                                            <!-- MIDTRANS -->
                                            <form id="payment-form" method="post" action="<?= site_url() ?>/snap/finish">
                                                <input type="hidden" name="result_type" id="result-type" value="">
                                                <input type="hidden" name="result_data" id="result-data" value="">
                                                <input type="hidden" name="invoice" id="invoice" value="<?= $invoice->invoice ?>">
                                            </form>
                                            <!-- Xendit -->
                                            <?php if ($pg['is_active'] == 0) { ?>
                                                <a href="" data-toggle="modal" data-target="#ModalBayar" class="btn btn-danger">BAYAR</a>
                                            <?php } ?>
                                            <?php if ($pg['is_active'] == 1) { ?>
                                                <?php if ($pg['vendor'] == 'Xendit') { ?>

                                                    <?php if ($invoice->x_id == '') { ?>
                                                        <a href="" data-toggle="modal" data-target="#xendit" class="btn btn-danger">BAYAR</a>
                                                    <?php } ?>
                                                    <?php if ($invoice->x_id != '') { ?>
                                                        <?php if ($xendit['status'] == 'EXPIRED') { ?>
                                                            <a href="" data-toggle="modal" data-target="#xendit" class="btn btn-danger">BAYAR</a>
                                                        <?php } ?>
                                                        <?php if ($xendit['status'] != 'EXPIRED') { ?>
                                                            <a href="<?= $invoice->payment_url ?>" class="btn btn-primary">BAYAR</a>
                                                        <?php } ?>
                                                    <?php } ?>


                                                <?php } ?>
                                                <?php if ($pg['vendor'] == 'Midtrans') { ?>
                                                    <?php if ($invoice->transaction_time != '') { ?>
                                                        <?php $dateint = strtotime($invoice->transaction_time)  ?>
                                                        <?php $hari = $invoice->expired * 24 ?>
                                                        <?php if ($pg['mode'] == 1) {
                                                            $link = 'https://app.midtrans.com/snap/v2/vtweb/';
                                                        } else {
                                                            $link = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';
                                                        } ?>
                                                        <?php if ((time() - $dateint) > (60 * 60 * $hari)) { ?>
                                                            <a href="<?= $link . $invoice->token ?>" class="btn btn-danger" target="blank">LANJUT BAYAR</a>
                                                            <a href="<?= $invoice->pdf_url ?>" class="btn btn-secondary" target="blank">CARA BAYAR</a>

                                                        <?php } ?>
                                                        <?php if ((time() - $dateint) < (60 * 60 * $hari)) { ?>
                                                            <a href="" id="pay-button" class="btn btn-danger">BAYAR</a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if ($invoice->transaction_time == '') { ?>
                                                        <a href="" id="pay-button" class="btn btn-danger">BAYAR</a>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($pg['vendor'] == 'Duitku') { ?>
                                                    <?php $dateint = $invoice->transaction_time ?>
                                                    <!-- <?= date('Y-m-d h:i:s', $dateint); ?> -->
                                                    <?php $exp = $dateint + (1 * 60 * $invoice->expired)   ?>
                                                    <!-- <?= date('Y-m-d h:i:s', $exp); ?> -->
                                                    <?php if (time()  < $exp) { ?>
                                                        <a href="<?= $invoice->payment_url ?>" class="btn btn-primary">LANJUT BAYAR</a>
                                                    <?php } ?>
                                                    <?php if (time()  > $exp) { ?>

                                                        <a href="" data-toggle="modal" data-target="#duitku" class="btn btn-danger">BAYAR</a>

                                                    <?php } ?>

                                                <?php } ?>
                                                <?php if ($pg['vendor'] == 'Tripay') { ?>
                                                    <?php
                                                    $apiKey = $pg['api_key'];

                                                    $payload = ['reference'    => $invoice->reference];
                                                    // $payload = ['reference'    => 'T52301519724TJYYH'];

                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, [
                                                        CURLOPT_FRESH_CONNECT  => true,
                                                        CURLOPT_URL            => 'https://tripay.co.id/api/transaction/detail?' . http_build_query($payload),
                                                        CURLOPT_RETURNTRANSFER => true,
                                                        CURLOPT_HEADER         => false,
                                                        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
                                                        CURLOPT_FAILONERROR    => false,
                                                    ]);

                                                    $response = curl_exec($curl);
                                                    $error = curl_error($curl);

                                                    curl_close($curl);

                                                    $result = json_decode($response, true);

                                                    // var_dump($result['data']['status']);
                                                    // die;
                                                    ?>

                                                    <?php if ($invoice->reference != '') { ?>
                                                        <?php if ($result['data']['status'] == 'PAID') { ?>
                                                            <?php
                                                            $updateinvoice = [
                                                                'status' => 'SUDAH BAYAR',
                                                                'date_payment' => $result['data']['paid_at'],
                                                                'metode_payment' => 'Payment Gateway',
                                                            ];
                                                            $this->db->where('invoice', $invoice->invoice);
                                                            $this->db->update('invoice', $updateinvoice);
                                                            $addincome = [
                                                                'nominal' => $tagihan,
                                                                'date_payment' => date('Y-m-d', $result['data']['paid_at']),
                                                                'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice->no_services . ' ' . 'a/n' . ' ' .  $Customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice->month) . ' ' . $invoice->year . ' by Tripay ' . $result['data']['payment_method'],
                                                                'invoice_id' => $invoice->invoice,
                                                                'category' => 1,
                                                                'create_by' => 0,
                                                                'no_services' => $invoice->no_services,
                                                                'mode_payment' => 'Payment Gateway',
                                                                'created' => time()
                                                            ];
                                                            $this->db->insert('income', $addincome);
                                                            $whatsapp = $this->db->get('whatsapp')->row_array();
                                                            if ($whatsapp['is_active'] == 1) {


                                                                if ($whatsapp['paymentinvoice'] == 1) {

                                                                    redirect('whatsapp/sendbillpaid/' . $invoice->invoice);
                                                                }
                                                            }
                                                            ?>
                                                        <?php } ?>
                                                        <?php if ($result['data']['status'] != 'EXPIRED') { ?>
                                                            <a href="<?= $invoice->payment_url ?>" class="btn btn-primary">LANJUT BAYAR</a>
                                                        <?php } ?>
                                                        <?php if ($result['data']['status'] == 'EXPIRED') { ?>
                                                            <a href="" data-toggle="modal" data-target="#tripay" class="btn btn-danger">BAYAR</a>

                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if ($invoice->reference == '') { ?>


                                                        <a href="" data-toggle="modal" data-target="#tripay" class="btn btn-danger">BAYAR</a>


                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col">
                                            <?php $confirm = $this->db->get_where('confirm_payment', ['no_services' => $invoice->no_services, 'invoice_id' => $invoice->invoice])->row_array(); ?>

                                            <?php if ($confirm != null) { ?>
                                                <?php $Customer = $this->db->get_where('customer', ['no_services' => $invoice->no_services])->row_array(); ?>

                                                <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp']) ?>&text=*Konfirmasi Pembayaran*  %0ANama Pelanggan : <?= $Customer['name'] ?>  %0ANo Layanan : <?= $invoice->no_services ?>  %0ANo Invoice : <?= $invoice->invoice ?>  %0APeriode : <?= indo_month($invoice->month) ?> <?= $invoice->year ?>  %0A%0A%0A <?= base_url() ?>confirmdetail/<?= $invoice->invoice ?>" target="blank" class="btn btn-success"><i class="fab fa-whatsapp" style="font-size:15px; color:green"></i>Hubungi Admin</a>
                                            <?php } ?>
                                            <?php if ($confirm == null) { ?>
                                                <div class="col text-center mb-1">
                                                    <a href="<?= site_url('member/confirmpayment/' . $invoice->invoice) ?>" class="btn btn-warning">Konfirmasi Pembayaran</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php if ($role['show_bill'] == 1) { ?>
                                            <div class="col text-center">
                                                <a class="btn btn-danger" href="<?= site_url('member/invoice/' . $invoice->invoice) ?>">Invoice</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($invoice->status == 'SUDAH BAYAR') { ?>
                                    <?php if ($role['show_bill'] == 1) { ?>
                                        <div class="row mt-1">
                                            <div class="col text-center">
                                                <div class="badge badge-success"><a href="<?= site_url('member/invoice/' . $invoice->invoice) ?>">Invoice</a> </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

                    WA : <?= $company['whatsapp'] ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-success">Konfirmasi Pembayaran</button> -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ipaymu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cara Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('ipaymu/payment'); ?>" method="post">
                    <div class="modal-body">
                        <input type="text" name="invoice" value="<?= $invoice->invoice ?>">
                        <input type="text" name="amount" value="<?= $tagihan ?>">
                        <div class="form-group">
                            <label for="">Pilih Metode Pembayaran</label> <span style="color: red;">(Otomatis Verifikasi)</span>
                            <select class="form-control" name="paymethod" id="" required>
                                <option value="">-Pilih-</option>
                                <option value="qris">QRIS (OVO, DANA, LinkAja)</option>
                                <option value="alfamart">Alfamart</option>
                                <option value="indomaret">Indomaret</option>
                                <option value="va_cimb">VA Cimb Niaga</option>
                                <option value="va_bni">VA BNI</option>
                                <option value="va_mandiri">VA Mandiri</option>
                            </select>

                        </div>
                        <br>
                        <label for="">Verifikasi Manual</label>
                        <br>
                        <?php
                        foreach ($bank as $r => $data) { ?>
                            <?= $data->name ?> : <?= $data->no_rek ?> A/N <?= $data->owner ?>
                            <br>
                        <?php } ?>
                        <br>
                        <b>Konfirmasi Pembayaran :</b> <br>
                        Email : <?= $company['email'] ?>
                        <br>

                        WA : <?= $company['whatsapp'] ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="xendit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Checkout Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('payment/createinvoice'); ?>" method="post">
                    <div class="modal-body">
                        <?php $Customer = $this->db->get_where('customer', ['no_services' => $invoice->no_services])->row_array(); ?>


                        <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                        <input type="hidden" name="amount" value="<?= $tagihan + $pg['admin_fee'] ?>">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <div class="input-group mb-3">
                                <input type="text" value="<?= indo_month($invoice->month) ?> <?= $invoice->year ?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tagihan</label>
                            <div class="input-group mb-3">
                                <input type="text" value="<?= indo_currency($tagihan) ?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Biaya Admin</label>
                            <div class="input-group mb-3">
                                <input type="text" value="<?= indo_currency($pg['admin_fee']) ?>" class="form-control" readonly>
                            </div>
                        </div>


                        <div class="form-group">
                            <h4>Total yang harus dibayarkan : <span style="color: red;"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                        </div>
                        <br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="click-xendit" class="btn btn-primary">Checkout</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="duitku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Metode Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('duitku/checkout'); ?>" method="post">
                <div class="modal-body">
                    <?php $Customer = $this->db->get_where('customer', ['no_services' => $invoice->no_services])->row_array(); ?>

                    <!-- <input type="text" value="<?= $invoice->month ?><?= substr($invoice->year, 2) ?><?= $Customer['no_wa'] ?>" name="virtualaccount"> -->
                    <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                    <input type="hidden" name="no_services" value="<?= $invoice->no_services ?>">
                    <input type="hidden" name="amount" value="<?= $tagihan + $pg['admin_fee'] ?>">
                    <?php if ($pg['mode'] == 0) { ?>
                        <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran !</span> <br><br>
                    <?php } ?>
                    <?php

                    $apiKey = $pg['api_key'];



                    $merchantCode = $pg['kodemerchant'];
                    // Set your merchant key (Note: Server key for sandbox and production mode are different)
                    $merchantKey = $pg['api_key'];

                    $datetime = date('Y-m-d H:i:s');
                    $paymentAmount = '10000';
                    $signature = hash('sha256', $merchantCode . $paymentAmount . $datetime . $merchantKey);

                    $itemsParam = array(
                        'merchantcode' => $merchantCode,
                        'amount' => $paymentAmount,
                        'datetime' => $datetime,
                        'signature' => $signature
                    );

                    class emp
                    {
                    }

                    $params = array_merge((array)$result, $itemsParam);

                    $params_string = json_encode($params);

                    if ($pg['mode'] == 1) {
                        $url = "https://passport.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod"; // Production
                    } else {
                        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod'; // Sandbox
                    }

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($params_string)
                        )
                    );
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                    //execute post
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($httpCode == 200) {
                        $response = json_decode($response, true);
                    }
                    //  else {
                    //     $response = new emp();
                    //     $response->statusMessage = "Server Error . $httpCode ";
                    //     $response->error = $httpCode;
                    // }

                    ?>
                    <div class="form-group">
                        <label for=""><span style="color: red;">(Otomatis Verifikasi)</span></label> *Biaya Admin <?= indo_currency($pg['admin_fee']); ?>
                        <select class="form-control" name="selectpaymentduitku" required>
                            <option value="">-Pilih-</option>
                            <?php foreach ($response['paymentFee'] as $data) { ?>
                                <option value="<?= $data['paymentMethod']; ?>"><?= $data['paymentName']; ?></option>
                            <?php } ?>


                        </select>
                    </div>
                    <div class="form-group">
                        <div class="loading" style="display: none;">
                        </div>
                        <div class="view_data"></div>
                    </div>

                    <div class="form-group">
                        <h4>Total yang harus dibayarkan : <span style="color: red;"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                    </div>
                    <br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="click-duitku" class="btn btn-primary">Checkout</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="tripay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <?php $Customer = $this->db->get_where('customer', ['no_services' => $invoice->no_services])->row_array(); ?>

                    <!-- <input type="text" value="<?= $invoice->month ?><?= substr($invoice->year, 2) ?><?= $Customer['no_wa'] ?>" name="virtualaccount"> -->
                    <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                    <input type="hidden" name="no_services" value="<?= $invoice->no_services ?>">
                    <input type="hidden" name="amount" id="amounttripay" value="<?= $tagihan + $pg['admin_fee'] ?>">
                    <?php if ($pg['mode'] == 0) { ?>
                        <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                    <?php } ?>
                    <?php if ($invoice->disc_coupon == 0) { ?>
                        <?php $coupon = $this->db->get_where('coupon', ['is_active' => 1])->result() ?>
                        <?php if (count($coupon) > 0) { ?>
                            <div class="form-group" id="infocoupontripay">
                                Makin Hemat gunakan kode kupon, <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#kuponModal">Daftar Kupon</a> <br>
                                Copy kode ke form kode kupon dibawah <br>
                                Klik dulu Cek Kupon sebelum Checkout
                            </div>
                            <span id="notifrefreshtripay" style="display: none;">Silahkan refresh untuk menggunakan kode kupon yang lain <a href="" class="btn btn-outline-info">Refresh</a></span>
                            <div class="modal fade" id="kuponModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">Kode Kupon</h5>

                                        </div>
                                        <div class="modal-body">
                                            <?php foreach ($coupon as $coupon) { ?>
                                                <div class="card proj-t-card">
                                                    <div class="card-body">
                                                        <div class="row align-items-center ">
                                                            <div class="col-auto">
                                                                <!-- <i class="fas fa-paper-plane text-green f-30"></i> -->
                                                            </div>
                                                            <div class="col pl-0">
                                                                <span class="mb-5">Kode Kupon</span>
                                                                <h6 class="mb-0 text-green"><?= $coupon->code; ?></h6>
                                                                <?php if ($coupon->max_active == 1 && $coupon->max_limit > 0) { ?>
                                                                    <span>Maksimal <?= indo_currency($coupon->max_limit); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center text-left">
                                                            <div class="col">
                                                                <span class="mb-0"><?= $coupon->remark; ?></span>
                                                            </div>

                                                        </div>
                                                        <h6 class="pt-badge bg-green"><?= $coupon->percent; ?> %</h6>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <label for="">Kode Kupon</label>

                                <div class="input-group mb-3">
                                    <input type="text" id="codecoupontripay" name="codecoupontripay" oninput="this.value = this.value.toUpperCase()" onKeyDown="if(event.keyCode === 32) return false;" class="form-control">
                                    <div class="input-group-append">
                                        <a href="#" id="cekcoupontripay" class="input-group-text">Cek Kupon</a>
                                    </div>
                                </div>


                                <span id="notifcoupontripay"></span>


                            </div>
                            <div class="form-group">
                                <div class="loadingcekcoupontripay">
                                </div>

                            </div>

                        <?php } ?>
                    <?php } ?>
                    <div class="form-group">
                        <label for="">Tagihan</label>
                        <input type="text" class="form-control" value="<?= indo_currency($tagihan); ?>" readonly>

                    </div>
                    <?php if ($pg['admin_fee'] > 0) { ?>
                        <div class="form-group">
                            <label for="">Biaya Admin</label>
                            <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                        </div>
                    <?php } ?>

                    <div class="form-group" id="formdisctripay" style="display: none;">
                        <label for="">Diskon Kupon</label>
                        <input type="text" id="disccoupontripay" class="form-control" readonly>
                        <input type="hidden" name="disccoupontripay" id="amountdisccoupontripay" class="form-control" readonly>

                    </div>
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
                        <label for=""><span style="color: red;">(Otomatis Verifikasi)</span></label>

                        <select class="form-control" name="selectpaymenttripay" required>
                            <option value="">-Pilih-</option>
                            <?php foreach ($response['data'] as $data) { ?>
                                <option value="<?= $data['code']; ?>"><?= $data['name']; ?></option>
                            <?php } ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <h4>Total yang harus dibayarkan : <span style="color: red;" id="amountgrostripay"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                    </div>

                    <br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="click-tripay" class="btn btn-primary">Checkout</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<style>
    :root {
        --light-color: rgba(10, 10, 220, .2);
        --dark-color: rgba(10, 10, 220, 1);
        --radius: 64px;
        --ring-width: 4px;
    }

    /* reset */
    * {
        margin: 0;
        padding: 0;
    }

    /* ring position */

    /* loading element style */
    .loading {
        width: var(--radius);
        height: var(--radius);
        border-radius: 50%;
        border: var(--ring-width) solid var(--light-color);
    }

    .loading:before {
        display: block;
        position: relative;
        left: calc(var(--ring-width) * -1);
        top: calc(var(--ring-width) * -1);
        content: ' ';
        width: var(--radius);
        height: var(--radius);
        border-radius: 50%;
        border: var(--ring-width) solid;
        border-color: var(--dark-color) transparent transparent transparent;
        animation: loading-rotate .8s ease-out infinite;
    }

    @keyframes loading-rotate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="loading"></div>
    </div>
</div>

<script>
    $('#cekcoupontripay').click(function(event) {
        var code = $("#codecoupontripay").val();
        var no_services = $("#no_services").val();
        var amount = $("#amounttripay").val();
        var url = "<?= site_url('coupon/cekcoupon') ?>" + "/" + Math.random();
        if (code == '') {
            $("#notifcoupontripay").html('Silahkan masukkan dulu kode kupon !');
            $("#codecoupontripay").focus();
        } else {
            $.ajax({
                type: 'POST',
                url: url,
                data: "&code=" + code + "&no_services=" + no_services + "&amount=" + amount,
                cache: false,

                beforeSend: function() {

                    $('.loadingcekcoupontripay').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                },
                success: function(data) {
                    var c = jQuery.parseJSON(data);

                    $('.loadingcekcoupontripay').html('');
                    var disct = c['disc'];
                    var disc = disct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    var gros = amount - disct;
                    var gross = gros.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    $("#disccoupontripay").val(disc);
                    $("#amountdisccoupontripay").val(c['disc']);
                    $("#notifcoupontripay").html(c['remark']);

                    if (c['disc'] > 0) {
                        $("#formdisctripay").show();
                        $("#cekcoupontripay").hide();
                        $("#infocoupontripay").hide();
                        $("#notifrefreshtripay").show();
                        $("#amounttripay").val(amount - disct);
                        $("#amountgrostripay").html(gross);
                    }


                }
            });
        }
        return false;
    });
</script>

<script type="text/javascript">
    $('#pay-button').click(function(event) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");

        var tagihan = $("#tagihan").val();
        var namapelanggan = $("#namapelanggan").val();
        var no_services = $("#no_services").val();
        var periode = $("#periode").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var biayaadmin = $("#biayaadmin").val();
        var invoice_id = $("#invoice_id").val();
        var invoice = $("#invoice").val();

        $.ajax({
            type: 'POST',
            url: '<?= site_url() ?>snap/token',
            data: {
                tagihan: tagihan,
                namapelanggan: namapelanggan,
                no_services: no_services,
                periode: periode,
                email: email,
                phone: phone,
                address: address,
                biayaadmin: biayaadmin,
                invoice_id: invoice_id,
                invoice: invoice,
            },
            cache: false,

            success: function(data) {
                //location = data;

                console.log('token = ' + data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));

                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                    onSuccess: function(result) {
                        changeResult('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        $("#payment-form").submit();
                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    },
                    onError: function(result) {
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#popup").modal({
            show: false,
            backdrop: 'static'
        });
    });
    $("#click-tripay").click(function() {
        $("#popup").modal("show");
        $("#tripay").modal("hide");
    });
    $("#click-xendit").click(function() {
        $("#popup").modal("show");
        $("#xendit").modal("hide");
    });
    $("#click-duitku").click(function() {
        $("#popup").modal("show");
        $("#duitku").modal("hide");
    });
</script>
<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
<?php if ($pg['is_active'] == 1) { ?>
    <?php if ($pg['vendor'] == 'Tripay') { ?>
        <script>
            $(document).ready(function() {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('tripay/transaction') ?>',
                    cache: false,
                    success: function(data) {}
                });

                return false;
            })
        </script>
    <?php } ?>
<?php } ?>