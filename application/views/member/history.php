<?php $this->view('messages') ?>
<div class="page-header-title">
    <div class="d-inline">
        <h5>Riwayat Tagihan <?= date('Y'); ?></h5>
    </div>
</div>
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<div class="row">
    <?php
    foreach ($invoice as $r => $data) { ?>
        <?php
        $month =   $data->month;
        $year = $data->year;
        $no_services = $data->no_services;
        $query = "SELECT *
                           FROM `invoice_detail`
                               WHERE `invoice_detail`.`d_month` =  $month and
                              `invoice_detail`.`d_year` =  $year and
                              `invoice_detail`.`d_no_services` =  $no_services";
        $querying = $this->db->query($query)->result();
        // var_dump($querying)
        ?>
        <?php $subtotal = 0;
        foreach ($querying as  $dataa)
            $subtotal += (int) $dataa->total;
        ?>
        <?php
        $month =   $data->month;
        $year = $data->year;
        $no_services = $data->no_services;
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

        <?php if ($subtotal != 0) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="widget">
                    <a href="" data-toggle="modal" data-target="#Modal<?= $data->invoice_id ?>">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6><?= indo_month($data->month) ?>
                                        <?= $data->year ?>
                                    </h6>
                                    <!-- KODE UNIK -->
                                    <?php if ($customer['codeunique'] == 1) { ?>
                                        <?php $code_unique = $data->code_unique ?>
                                    <?php } ?>
                                    <?php if ($customer['codeunique'] == 0) { ?>
                                        <?php $code_unique = 0 ?>
                                    <?php } ?>
                                    <!-- END KODE UNIK -->
                                    <?php $discount = $data->disc_coupon ?>
                                    <?php $ppn = $subtotal * ($data->i_ppn / 100) ?>

                                    <?php if ($data->status == 'SUDAH BAYAR') {  ?>
                                        <h3 class="fw-700 text-green"><?= indo_currency($subtotal + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                    <?php if ($data->status == 'BELUM BAYAR') {  ?>
                                        <h3 class="fw-700 text-red"><?= indo_currency($subtotal + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>


                                </div>
                                <div class="icon">
                                    <?php if ($data->status == 'SUDAH BAYAR') {  ?>
                                        <h6 class="mb-0 text-green">SUDAH BAYAR</h6>
                                    <?php } ?>
                                    <?php if ($data->status == 'BELUM BAYAR') {  ?>
                                        <h6 class="mb-0 text-red">BELUM BAYAR</h6>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row container">

                                <?= number_to_words($subtotal + $code_unique + $ppn - $discount) ?>


                            </div>
                        </div>
                    </a>

                </div>
            </div>

        <?php } ?>

        <?php if ($subtotal == 0) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="widget">
                    <a href="" data-toggle="modal" data-target="#Modal<?= $data->invoice_id ?>">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6><?= indo_month($data->month) ?>
                                        <?= $data->year ?>
                                    </h6>
                                    <?php $ppn = $subTotaldetail * ($data->i_ppn / 100) ?>
                                    <!-- KODE UNIK -->
                                    <?php if ($customer['codeunique'] == 1) { ?>
                                        <?php $code_unique = $data->code_unique ?>
                                    <?php } ?>
                                    <?php if ($customer['codeunique'] == 0) { ?>
                                        <?php $code_unique = 0 ?>
                                    <?php } ?>
                                    <!-- END KODE UNIK -->
                                    <?php if ($data->status == 'SUDAH BAYAR') {  ?>
                                        <h3 class="fw-700 text-green"><?= indo_currency($subTotaldetail + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                    <?php if ($data->status == 'BELUM BAYAR') {  ?>
                                        <h3 class="fw-700 text-red"><?= indo_currency($subTotaldetail + $code_unique + $ppn - $discount) ?></h3>
                                    <?php } ?>
                                </div>
                                <div class="icon">
                                    <?php if ($data->status == 'SUDAH BAYAR') {  ?>
                                        <h6 class="mb-0 text-green">SUDAH BAYAR</h6>
                                    <?php } ?>
                                    <?php if ($data->status == 'BELUM BAYAR') {  ?>
                                        <h6 class="mb-0 text-red">BELUM BAYAR</h6>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row container">
                                <?= number_to_words($subTotaldetail + $code_unique + $ppn - $discount) ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<?php
foreach ($invoice as $r => $data) { ?>

    <?php
    $month =   $data->month;
    $year = $data->year;
    $no_services = $data->no_services;
    $query = "SELECT *
                        FROM `invoice_detail`
                            WHERE `invoice_detail`.`d_month` =  $month and
                           `invoice_detail`.`d_year` =  $year and
                           `invoice_detail`.`d_no_services` =  $no_services";
    $querying = $this->db->query($query)->result(); ?>
    <?php $subtotal = 0;
    foreach ($querying as  $dataa)
        $subtotal += (int) $dataa->total;
    ?>
    <?php
    $month =   $data->month;
    $year = $data->year;
    $no_services = $data->no_services;
    $query = "SELECT *, `invoice_detail`.`price` as detail_price
                            FROM `invoice_detail`
                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
    $queryTot = $this->db->query($query)->result(); ?>
    <?php $subTotaldetail = 0;
    foreach ($queryTot as  $dataa)
        $subTotaldetail += (int) $dataa->total;
    ?>
    <?php $ppn = $subTotaldetail * ($data->i_ppn / 100) ?>
    <div class="modal fade" id="Modal<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= indo_month($data->month) ?> <?= $data->year ?></h5>
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
                                    <?php if ($data->status == 'BELUM BAYAR') { ?>
                                        <b class="text-red">Belum Dibayar</b>
                                    <?php } ?>
                                    <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                        <b class="text-green">Sudah Dibayar</b>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row mt-3">
                                    <div class="col text-center">
                                        <span>Total</span>
                                        <!-- KODE UNIK -->
                                        <?php if ($customer['codeunique'] == 1) { ?>
                                            <?php $code_unique = $data->code_unique ?>
                                        <?php } ?>
                                        <?php if ($customer['codeunique'] == 0) { ?>
                                            <?php $code_unique = 0 ?>
                                        <?php } ?>
                                        <!-- END KODE UNIK -->
                                        <?php if ($data->status == 'BELUM BAYAR') {  ?>
                                            <?php if ($subtotal <= 0) {  ?>
                                                <h3 class="fw-700 text-black"><?= indo_currency($subTotaldetail + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                            <?php if ($subtotal > 0) {  ?>
                                                <h3 class="fw-700 text-black"><?= indo_currency($subtotal + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($data->status == 'SUDAH BAYAR') {  ?>
                                            <?php if ($subtotal <= 0) {  ?>
                                                <h3 class="fw-700 text-green"><?= indo_currency($subTotaldetail + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                            <?php if ($subtotal > 0) {  ?>
                                                <h3 class="fw-700 text-green"><?= indo_currency($subtotal + $code_unique + $ppn - $discount) ?></h3>
                                            <?php } ?>
                                        <?php } ?>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <?php
                                        $month =   $data->month;
                                        $year = $data->year;
                                        $no_services = $data->no_services;
                                        $query = "SELECT *, `invoice_detail`.`price` as detail_price
                            FROM `invoice_detail` 
                            JOIN `package_item` ON `package_item`.`p_item_id` = `invoice_detail`.`item_id`
                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
                                        $queryDetail = $this->db->query($query)->result(); ?>
                                        <?php
                                        $month =   $data->month;
                                        $year = $data->year;
                                        $no_services = $data->no_services;
                                        $query = "SELECT *, `invoice_detail`.`price` as detail_price
                                                           FROM `invoice_detail`
                                                            
                            JOIN `package_item` ON `package_item`.`p_item_id` = `invoice_detail`.`item_id`
                            WHERE `invoice_detail`.`d_month` =  $month and
                                                              `invoice_detail`.`d_year` =  $year and
                                                              `invoice_detail`.`d_no_services` =  $no_services";
                                        $queryDet = $this->db->query($query)->result(); ?>
                                        Rincian Tagihan #<?= $data->invoice ?>
                                        <br><br>
                                        <?php if ($subtotal == 0) {  ?>
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
                                            <?php if ($customer['codeunique'] == 1) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Kode Unik
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($code_unique) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data->disc_coupon > 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Diskon
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($data->disc_coupon) ?>
                                                    </div>
                                                </div>


                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($subtotal != 0) {  ?>
                                            <?php foreach ($queryDet as $dataaaa) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <?= $dataaaa->name ?>
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($dataaaa->detail_price) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data->i_ppn > 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Ppn (<?= $data->i_ppn ?>) %
                                                    </div>
                                                    <div class="col text-right">
                                                        <?= indo_currency($ppn) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($data->disc_coupon != 0) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        Diskon
                                                    </div>

                                                    <div class="col text-right">
                                                        <?= indo_currency($data->disc_coupon) ?>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                            <?php if ($customer['codeunique'] == 1) { ?>
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
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    Terbilang : &nbsp;

                                    <?php if ($subtotal <= 0) {  ?>
                                        <span><em> <?= number_to_words($subTotaldetail + $code_unique + $ppn - $discount) ?></em></span>
                                    <?php } ?>

                                    <?php if ($subtotal > 0) {  ?>
                                        <span><em> <?= number_to_words($subtotal + $code_unique + $ppn - $discount) ?></em></span>
                                    <?php } ?>


                                </div>
                                <?php if ($data->status == 'BELUM BAYAR') { ?>
                                    <div class="row mt-1">
                                        <div class="col text-center">
                                            <?php $pg = $this->db->get('payment_gateway')->row_array(); ?>

                                            <?php if ($pg['is_active'] == 0) { ?>
                                                <a href="" data-toggle="modal" data-target="#ModalBayar" class="btn btn-danger">BAYAR</a>
                                            <?php } ?>
                                            <?php if ($pg['is_active'] == 1) { ?>
                                                <?php if ($pg['vendor'] == 'Xendit') { ?>

                                                    <a href="<?= site_url('member/pay/' . $data->invoice) ?>" class="btn btn-danger">Checkout</a>

                                                <?php } ?>
                                                <?php if ($pg['vendor'] == 'Midtrans') { ?>
                                                    <?php $dateint = strtotime($data->transaction_time)  ?>
                                                    <?php $hari = $data->expired * 24 ?>
                                                    <?php if ($pg['mode'] == 1) {
                                                        $link = 'https://app.midtrans.com/snap/v2/vtweb/';
                                                    } else {
                                                        $link = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';
                                                    } ?>
                                                    <?php if (time() - $dateint < (60 * 60 * $hari)) { ?>

                                                        <a href="<?= $link . $data->token ?>" class="btn btn-danger" target="blank">BAYAR</a>
                                                    <?php } ?>
                                                    <?php if (time() - $dateint > (60 * 60 * $hari)) { ?>
                                                        <?php if ($data->order_id != null) { ?>
                                                            <a href="<?= $link . $data->token ?>" class="btn btn-danger" target="blank">BAYAR</a>
                                                        <?php } ?>
                                                        <?php if ($data->order_id == null) { ?>

                                                            <a href="" id="pay-button" class="btn btn-danger">BAYAR</a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($pg['vendor'] == 'Duitku') { ?>
                                                    <?php $dateint = $data->transaction_time ?>
                                                    <!-- <?= date('Y-m-d h:i:s', $dateint); ?> -->
                                                    <?php $exp = $dateint + (1 * 60 * $data->expired)   ?>
                                                    <!-- <?= date('Y-m-d h:i:s', $exp); ?> -->
                                                    <?php if (time()  < $exp) { ?>
                                                        <a href="<?= $data->payment_url ?>" class="btn btn-primary">LANJUT BAYAR</a>
                                                    <?php } ?>
                                                    <?php if (time()  > $exp) { ?>

                                                        <a href="" data-toggle="modal" data-target="#duitku" class="btn btn-danger">BAYAR</a>

                                                    <?php } ?>

                                                <?php } ?>
                                                <?php if ($pg['vendor'] == 'Tripay') { ?>
                                                    <?php $hariini = 1637759592;
                                                    $hariexp = $hariini + (60 * 60 * 24) ?>
                                                    <!-- 1637586792 -->
                                                    <!-- <?= date('d-m-Y H:i:s', $hariini) ?> <br> -->
                                                    <!-- <?= date('d-m-Y H:i:s', $hariexp) ?> <br> -->

                                                    <!-- <?= date('d-m-Y H:i:s') ?> -->
                                                    <!-- <?= $hariexp; ?> -->

                                                    <?php $dateint = $data->transaction_time ?>
                                                    <?php $hari = $data->expired * 24 ?>
                                                    <?php $exp = $dateint + (60 * 60 * $hari)   ?>

                                                    <?php if (time() < $exp) { ?>
                                                        <a href="<?= $data->payment_url ?>" class="btn btn-primary">LANJUT BAYAR</a>
                                                    <?php } ?>
                                                    <?php if (time()  > $exp) { ?>
                                                        <a href="<?= site_url('member/pay/' . $data->invoice) ?>" class="btn btn-danger">BAYAR</a>

                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>

                                        </div>
                                        <?php $confirm = $this->db->get_where('confirm_payment', ['no_services' => $data->no_services, 'invoice_id' => $data->invoice])->row_array(); ?>

                                        <?php if ($confirm != null) { ?>
                                            <?php $Customer = $this->db->get_where('customer', ['no_services' => $data->no_services])->row_array(); ?>
                                            <?php $link = "https://$_SERVER[HTTP_HOST]"; ?>
                                            <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp']) ?>&text=*Konfirmasi Pembayaran*  %0ANama Pelanggan : <?= $Customer['name'] ?>  %0ANo Layanan : <?= $data->no_services ?>  %0ANo Invoice : <?= $data->invoice ?>  %0APeriode : <?= indo_month($data->month) ?> <?= $data->year ?>  %0A%0A%0A <?= $link ?>/confirmdetail/<?= $data->invoice ?>" target="blank" class="btn btn-success"><i class="fab fa-whatsapp" style="font-size:15px; color:green"></i>Hubungi Admin</a>
                                        <?php } ?>
                                        <?php if ($confirm == null) { ?>
                                            <div class="col text-center mb-1">
                                                <a href="<?= site_url('member/confirmpayment/' . $data->invoice) ?>" class="btn btn-warning">Konfirmasi Pembayaran</a>
                                            </div>
                                        <?php } ?>
                                        <?php if ($role['show_bill'] == 1) { ?>
                                            <div class="col text-center">
                                                <a class="btn btn-danger" href="<?= site_url('member/invoice/' . $data->invoice) ?>">Invoice</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($data->status == 'SUDAH BAYAR') { ?>
                                    <?php if ($role['show_bill'] == 1) { ?>
                                        <div class="row mt-1">
                                            <div class="col text-center">
                                                <div class="badge badge-success"><a href="<?= site_url('member/invoice/' . $data->invoice) ?>">Invoice</a> </div>
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
<?php } ?>
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
                WA : <?= $company['whatsapp'] ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success">Konfirmasi Pembayaran</button> -->
            </div>
        </div>
    </div>
</div>