<?php $this->view('messages') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan <?= $title; ?></h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        Is Active <br>
                        <?php echo form_open_multipart('payment/edit') ?>
                        <input type="hidden" name="payment_id" value="<?= $pg['id'] ?>">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="chis_active" class="switch ml-3">
                                        <input type="checkbox" <?= $pg['is_active'] == 1 ? 'checked' : ''; ?> id="chis_active">
                                        <div class="slider round"></div>
                                    </label>
                                    <input type="hidden" name="is_active" id="is_active" value="<?= $pg['is_active'] ?>">
                                </div>
                            </div>
                            <div class="col" id="reftripay" style="display:  <?= $pg['vendor'] == 'Tripay'  ? 'block' : 'none'; ?>;">
                                <a href="https://tripay.co.id/?ref=TP2108" target="blank" class="btn btn-success">Daftar Tripay</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="form-control" required onChange="selectvendor(this);">
                                <?php if ($pg['vendor'] == '') { ?>
                                    <option value="">-Pilih-</option>
                                <?php } ?>
                                <?php if ($pg['vendor'] != '') { ?>
                                    <option value="<?= $pg['vendor'] ?>"><?= $pg['vendor'] ?></option>
                                <?php } ?>
                                <option value="Midtrans">Midtrans</option>
                                <option value="Xendit">Xendit</option>
                                <option value="Duitku">Duitku</option>
                                <option value="Tripay">Tripay</option>
                            </select>
                        </div>
                        <div class="" id="key_duitku" style="display: <?= $pg['vendor'] == 'Duitku'  ? 'block' : 'none'; ?>">
                            <div class="form-group">
                                <label for="mode">Mode</label>
                                <select name="modeduitku" id="mode" class="form-control">
                                    <option value="<?= $pg['mode']; ?>"><?= $pg['mode'] == 1 ? 'Production' : 'Sandbox' ?></option>
                                    <option value="0">Sandbox</option>
                                    <option value="1">Production</option>
                                </select>
                            </div>
                        </div>
                        <div class="" id="key_tripay" style="display: <?= $pg['vendor'] == 'Tripay'  ? 'block' : 'none'; ?>">
                            <div class="form-group">
                                <label for="mode">Mode</label>
                                <select name="modetripay" id="mode" class="form-control">
                                    <option value="<?= $pg['mode']; ?>"><?= $pg['mode'] == 1 ? 'Production' : 'Sandbox' ?></option>
                                    <option value="0">Sandbox</option>
                                    <option value="1">Production</option>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label for="code_merchant">Kode Merchant</label>
                                <input type="text" name="code_merchanttripay" id="code_merchant" class="form-control" autocomplete="off" value="<?= $pg['kodemerchant'] ?>">
                            </div>
                            <div class=" form-group">
                                <label for="api_key">Api Key</label>
                                <input type="text" name="api_keytripay" id="api_key" class="form-control" autocomplete="off" value="<?= $pg['api_key'] ?>">
                            </div>
                            <div class=" form-group">
                                <label for="server_key">Private Key</label>
                                <input type="text" name="server_keytripay" id="server_key" class="form-control" autocomplete="off" value="<?= $pg['server_key'] ?>">

                            </div>
                        </div>

                        <div class="" id="kodemerchant" style="display: <?= $pg['vendor'] == 'Duitku' | $pg['vendor'] == 'Xendit'  ? 'block' : 'none'; ?>">
                            <div class=" form-group">
                                <label for="code_merchant">Kode Merchant / Nama Merchant (Xendit)</label>
                                <input type="text" name="code_merchant" id="code_merchant" class="form-control" autocomplete="off" value="<?= $pg['kodemerchant'] ?>">
                            </div>
                        </div>
                        <div class="" id="key_xendit" style="display: <?= $pg['vendor'] == 'Xendit' |  $pg['vendor'] == 'Duitku' ? 'block' : 'none'; ?>">
                            <div class=" form-group">
                                <label for="api_key">Api Key</label>
                                <input type="text" name="api_key" id="api_key" class="form-control" autocomplete="off" value="<?= $pg['api_key'] ?>">
                            </div>
                        </div>

                        <div class="" id="key_midtrans" style="display: <?= $pg['vendor'] == 'Midtrans'  ? 'block' : 'none'; ?>">
                            <div class="form-group">
                                <label for="mode">Mode</label>
                                <select name="mode" id="mode" class="form-control">
                                    <option value="<?= $pg['mode']; ?>"><?= $pg['mode'] == 1 ? 'Production' : 'Sandbox' ?></option>
                                    <option value="0">Sandbox</option>
                                    <option value="1">Production</option>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label for="server_key">Server Key</label>
                                <input type="text" name="server_key" id="server_key" class="form-control" autocomplete="off" value="<?= $pg['server_key'] ?>">

                            </div>
                            <div class=" form-group">
                                <label for="client_key">Client Key</label>
                                <input type="text" name="client_key" class="form-control" autocomplete="off" value="<?= $pg['client_key'] ?>">
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="admin_fee">Biaya Admin</label>
                            <input type="number" name="admin_fee" class="form-control" autocomplete="off" value="<?= $pg['admin_fee'] ?>">
                        </div>
                        <div class=" form-group row">
                            <div class="col-md-0 mt-2">
                                <label class="col-sm-12 col-form-label">Expired</label>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="number" name="expired" id="expired" min="1" class="form-control" autocomplete="off" value="<?= $pg['expired'] ?>">
                            </div>
                            <div class="col-sm-3 mt-2">
                                <label class="col-sm-12 col-form-label"><span id="expiredtime"><?= $pg['vendor'] == 'Duitku' ? 'Menit' : ''; ?><?= $pg['vendor'] == 'Tripay' ? 'Jam' : 'Hari'; ?></span></label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Mode Pemabayaran</h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="" id="xendit" style="display: <?= $pg['vendor'] == 'Xendit' ? 'block' : 'none'; ?>">


                            <span>* Catatan : Untuk melihat metode pembayaran yang aktif silahkan cek Akun Xendit anda atau Klik <a href="https://dashboard.xendit.co/settings/payment-methods">di Sini</a></span>
                        </div>
                        <div class="" id="midtrans" style="display: <?= $pg['vendor'] == 'Midtrans' ? 'block' : 'none'; ?>">

                            * Catatan : Untuk melihat metode pembayaran yang aktif silahkan cek Akun Midtrans Anda.
                        </div>
                        <div class="" id="duitku" style="display: <?= $pg['vendor'] == 'Duitku' ? 'block' : 'none'; ?>">


                            <?php if ($pg['vendor'] == 'Duitku') { ?>
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
                            <?php } ?>
                            <?php

                            foreach ($response['paymentFee'] as $data) {   ?>
                                <div class="row">
                                    <div class="col"><?= $data['paymentMethod']; ?></div>
                                    <div class="col">: <?= $data['paymentName']; ?></div>
                                </div>

                            <?php } ?>
                            <br>
                            * Catatan : Untuk melihat metode pembayaran yang aktif silahkan cek Akun Duitku Anda.
                        </div>
                        <div class="" id="tripay" style="display: <?= $pg['vendor'] == 'Tripay' ? 'block' : 'none'; ?>">
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
                            $responser = curl_exec($curl);
                            $err = curl_error($curl);
                            $response = json_decode($response, true);
                            curl_close($curl);
                            if ($response['success'] == 'true') {

                                
                            }else {
                                echo  $responser;
                            }

                            ?>
                            <?php

                            foreach ($response['data'] as $item) {   ?>
                                <div class="row">
                                    <div class="col"><?= $item['group']; ?></div>
                                    <div class="col">: <?= $item['name']; ?> (<?= $item['code']; ?>)</div>
                                </div>

                            <?php } ?>
                            <br>
                            * Catatan : Untuk melihat metode pembayaran yang aktif silahkan cek di Merchant Tripay Anda.
                        </div>



                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <div class="" id="dashboard-xendit" style="display: <?= $pg['vendor'] == 'Xendit' ? 'block' : 'none'; ?>">
                        <div class="modal-footer">
                            <a href="<?= site_url('payment/xendit') ?>" class="btn btn-success">Dashboard Xendit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="" id="set-xendit" style="display: <?= $pg['vendor'] == 'Xendit' ? 'block' : 'none'; ?>">
    <div class=" row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Pengaturan Callback Di Akun Xendit <a href="https://dashboard.xendit.co/settings/developers#callbacks" target="blank">Klik Disini</a></h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class=" form-group">
                                <label for="bayar">Invoices terbayarkan</label> <span style="font-size: smaller; color:red">ketika sudah pembayaran</span>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>xendit/payinvoice" disabled>
                            </div>
                            <!-- <div class=" form-group">
                                <label for="bayar">FVA dibuat dan diperbaharui</label> <span style="font-size: smaller; color:red">ketika pelanggan checkout</span>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>xendit/create" disabled>
                            </div>
                            <div class=" form-group">
                                <label for="bayar">Retail outlet terbayarkan</label> <span style="font-size: smaller; color:red">ketika pelanggan melakukan pembayaran ke retail</span>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>xendit/payretail" disabled>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Tutorial </h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <?php $link = base_url(); ?>
                            <div class=" form-group">
                                <label for="bayar">Konfigurasi & Mode Test Xendit</label>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/yKzy6HAVMxg" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="" id="set-midtrans" style="display: <?= $pg['vendor'] == 'Midtrans' ? 'block' : 'none'; ?>">
    <div class=" row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Pengaturan Callback Di Akun Midtrans
                        <?php if ($pg['mode'] == 1) { ?>
                            <a href="https://dashboard.midtrans.com/settings/vtweb_configuration" target="blank">Klik Disini</a>
                        <?php } ?>
                        <?php if ($pg['mode'] == 0) { ?>
                            <a href="https://dashboard.midtrans.com/settings/vtweb_configuration" target="blank">Klik Disini</a>
                        <?php } ?>
                    </h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class=" form-group">
                                <label for="bayar">Payment Notification URL*</label> <span style="font-size: smaller; color:red">ketika sudah pembayaran</span>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>notification" disabled>
                            </div>
                            <div class=" form-group">
                                <label for="bayar">Finish Redirect URL*</label> <span style="font-size: smaller; color:red">ketika pelanggan checkout</span>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>member" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Tutorial </h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <?php $link = base_url(); ?>
                            <div class=" form-group">
                                <label for="bayar">Konfigurasi & Mode Test Midtrans</label>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/N1pMW2Zs2ms" allowfullscreen></iframe>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="" id="set-duitku" style="display: <?= $pg['vendor'] == 'Duitku' ? 'block' : 'none'; ?>">
    <div class=" row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Pengaturan Callback Di Akun Duitku
                        <?php if ($pg['mode'] == 1) { ?>
                            <a href="https://passport.duitku.com/merchant/Project" target="blank">Klik Disini</a>
                        <?php } ?>
                        <?php if ($pg['mode'] == 0) { ?>
                            <a href="https://sandbox.duitku.com/merchant/Project" target="blank">Klik Disini</a>
                        <?php } ?>
                    </h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">

                            <div class=" form-group">
                                <label for="bayar">Website Proyek*</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>" disabled>
                            </div>
                            <div class=" form-group">
                                <label for="bayar">Url Callback Proyek*</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url('duitku') ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Tutorial </h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">

                            <div class=" form-group">
                                <label for="bayar">Konfigurasi & Mode Test Duitku</label>
                                <h1 style="color: red;">Comingsoon</h1>
                                <!-- <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/N1pMW2Zs2ms" allowfullscreen></iframe>
                                </div> -->
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="" id="set-tripay" style="display: <?= $pg['vendor'] == 'Tripay' ? 'block' : 'none'; ?>">
    <div class=" row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Pengaturan Merchant Tripay</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">

                            <div class=" form-group">
                                <label for="bayar">Url Website *</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url() ?>" disabled>
                            </div>
                            <div class=" form-group">
                                <label for="bayar">Whitelist IP *</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= gethostbyname("$_SERVER[HTTP_HOST]") ?>" disabled>
                            </div>
                            <div class=" form-group">
                                <label for="bayar">Url Callback *</label>
                                <input type="text" class="form-control" autocomplete="off" value="<?= base_url('tripay') ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Tutorial </h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">

                            <div class=" form-group">
                                <label for="bayar">Konfigurasi & Mode Test Tripay</label>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/b7bR53PryyM" allowfullscreen></iframe>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(function() {
        $("#chis_active").click(function() {
            if ($(this).is(":checked")) {
                $("#is_active").val('1');
            } else {
                $("#is_active").val('0');
            }
        });
    });

    // XENDIT
    $(function() {
        $("#chva").click(function() {
            if ($(this).is(":checked")) {
                $("#va").val('1');
            } else {
                $("#va").val('0');
            }
        });
    });
    $(function() {
        $("#chewallet").click(function() {
            if ($(this).is(":checked")) {
                $("#ewallet").val('1');
            } else {
                $("#ewallet").val('0');
            }
        });
    });
    $(function() {
        $("#chretail").click(function() {
            if ($(this).is(":checked")) {
                $("#retail").val('1');
            } else {
                $("#retail").val('0');
            }
        });
    });
    $(function() {
        $("#chqrcode").click(function() {
            if ($(this).is(":checked")) {
                $("#qrcode").val('1');
            } else {
                $("#qrcode").val('0');
            }
        });
    });

    // MIDTRANS
    $(function() {
        $("#chbni_va").click(function() {
            if ($(this).is(":checked")) {
                $("#bni_va").val('1');
            } else {
                $("#bni_va").val('0');
            }
        });
    });
    $(function() {
        $("#chbca_va").click(function() {
            if ($(this).is(":checked")) {
                $("#bca_va").val('1');
            } else {
                $("#bca_va").val('0');
            }
        });
    });
    $(function() {
        $("#chbri_va").click(function() {
            if ($(this).is(":checked")) {
                $("#bri_va").val('1');
            } else {
                $("#bri_va").val('0');
            }
        });
    });
    $(function() {
        $("#chpermata_va").click(function() {
            if ($(this).is(":checked")) {
                $("#permata_va").val('1');
            } else {
                $("#permata_va").val('0');
            }
        });
    });
    $(function() {
        $("#chmandiri_va").click(function() {
            if ($(this).is(":checked")) {
                $("#mandiri_va").val('1');
            } else {
                $("#mandiri_va").val('0');
            }
        });
    });
    $(function() {
        $("#chgopay").click(function() {
            if ($(this).is(":checked")) {
                $("#gopay").val('1');
            } else {
                $("#gopay").val('0');
            }
        });
    });
    $(function() {
        $("#chshopeepay").click(function() {
            if ($(this).is(":checked")) {
                $("#shopeepay").val('1');
            } else {
                $("#shopeepay").val('0');
            }
        });
    });
    $(function() {
        $("#chalfamart").click(function() {
            if ($(this).is(":checked")) {
                $("#alfamart").val('1');
            } else {
                $("#alfamart").val('0');
            }
        });
    });
    $(function() {
        $("#chindomaret").click(function() {
            if ($(this).is(":checked")) {
                $("#indomaret").val('1');
            } else {
                $("#indomaret").val('0');
            }
        });
    });

    function selectvendor(sel) {
        var vendor = $('#vendor').val();

        if (vendor == 'Midtrans') {
            $("#kodemerchant").hide();
            $("#midtrans").show();
            $("#set-midtrans").show();
            $("#key_midtrans").show();
            $("#dashboard-xendit").hide();
            $("#key_xendit").hide();
            $("#duitku").hide();
            $("#set-xendit").hide();
            $("#set-duitku").hide();
            $("#server_key").focus();
            $("#xendit").hide();
            $("#expiredtime").html('Hari');
            $("#expired").val('1');
            $("#tripay").hide();
            $("#key_tripay").hide();
            $("#set-tripay").hide();
        }
        if (vendor == 'Duitku') {
            $("#kodemerchant").show();
            $("#duitku").show();
            $("#key_midtrans").hide();
            $("#key_duitku").show();
            $("#dashboard-xendit").hide();
            $("#key_xendit").show();
            $("#set-xendit").hide();
            $("#set-duitku").show();
            $("#xendit").hide();
            $("#midtrans").hide();
            $("#api_key").show();
            $("#code_merchant").focus();
            $("#expiredtime").html('Menit');
            $("#expired").val('10');
            $("#tripay").hide();
            $("#key_tripay").hide();
            $("#set-tripay").hide();
        }
        if (vendor == 'Tripay') {
            $("#kodemerchant").hide();
            $("#tripay").show();
            $("#reftripay").show();
            $("#key_midtrans").hide();
            $("#key_duitku").hide();
            $("#key_tripay").show();
            $("#dashboard-xendit").hide();
            $("#key_xendit").hide();
            $("#set-xendit").hide();
            $("#set-midtrans").hide();
            $("#set-duitku").hide();
            $("#set-tripay").show();
            $("#xendit").hide();
            $("#midtrans").hide();
            $("#duitku").hide();
            $("#code_merchant").focus();
            $("#expiredtime").html('Jam');
            $("#expired").val('1');
        }
        if (vendor == 'Xendit') {
            $("#kodemerchant").show();
            $("#tripay").hide();
            $("#key_tripay").hide();
            $("#set-tripay").hide();
            $("#xendit").show();
            $("#set-xendit").show();
            $("#set-duitku").hide();
            $("#key_xendit").show();
            $("#dashboard-xendit").show();
            $("#midtrans").hide();
            $("#duitku").hide();
            $("#set-midtrans").hide();
            $("#api_key").show();
            $("#api_key").focus();
            $("#key_midtrans").hide();
            $("#expiredtime").html('Hari');
            $("#expired").val('1');
        }
    }

    // METHOD DUITKU
    $(function() {
        $("#chretailduitku").click(function() {
            if ($(this).is(":checked")) {
                $("#retailduitku").val('1');
            } else {
                $("#retailduitku").val('0');
            }
        });
    });
    $(function() {
        $("#chdanaduitku").click(function() {
            if ($(this).is(":checked")) {
                $("#danaduitku").val('1');
            } else {
                $("#danaduitku").val('0');
            }
        });
    });
    $(function() {
        $("#chlinkajaduitku").click(function() {
            if ($(this).is(":checked")) {
                $("#linkajaduitku").val('1');
            } else {
                $("#linkajaduitku").val('0');
            }
        });
    });
    $(function() {
        $("#chshopeepayduitku").click(function() {
            if ($(this).is(":checked")) {
                $("#shopeepayduitku").val('1');
            } else {
                $("#shopeepayduitku").val('0');
            }
        });
    });
    $(function() {
        $("#chbniva").click(function() {
            if ($(this).is(":checked")) {
                $("#bniva").val('1');
            } else {
                $("#bniva").val('0');
            }
        });
    });
    $(function() {
        $("#chpermatava").click(function() {
            if ($(this).is(":checked")) {
                $("#permatava").val('1');
            } else {
                $("#permatava").val('0');
            }
        });
    });
    $(function() {
        $("#chmandiriva").click(function() {
            if ($(this).is(":checked")) {
                $("#mandiriva").val('1');
            } else {
                $("#mandiriva").val('0');
            }
        });
    });
    $(function() {
        $("#chcimbva").click(function() {
            if ($(this).is(":checked")) {
                $("#cimbva").val('1');
            } else {
                $("#cimbva").val('0');
            }
        });
    });
    $(function() {
        $("#chmybank").click(function() {
            if ($(this).is(":checked")) {
                $("#mybankva").val('1');
            } else {
                $("#mybankva").val('0');
            }
        });
    });
    $(function() {
        $("#chovo").click(function() {
            if ($(this).is(":checked")) {
                $("#ovo").val('1');
            } else {
                $("#ovo").val('0');
            }
        });
    });


    // METHOD TRIPAY
    $(function() {
        $("#chalfamarttripay").click(function() {
            if ($(this).is(":checked")) {
                $("#alfamarttripay").val('1');
            } else {
                $("#alfamarttripay").val('0');
            }
        });
    });
    $(function() {
        $("#chalfamiditripay").click(function() {
            if ($(this).is(":checked")) {
                $("#alfamiditripay").val('1');
            } else {
                $("#alfamiditripay").val('0');
            }
        });
    });
    $(function() {
        $("#chqristripay").click(function() {
            if ($(this).is(":checked")) {
                $("#qristripay").val('1');
            } else {
                $("#qristripay").val('0');
            }
        });
    });
    $(function() {
        $("#chbrivatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#brivatripay").val('1');
            } else {
                $("#brivatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chbnivatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#bnivatripay").val('1');
            } else {
                $("#bnivatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chbcavatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#bcavatripay").val('1');
            } else {
                $("#bcavatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chmandirivatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#mandirivatripay").val('1');
            } else {
                $("#mandirivatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chcimbvatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#cimbvatripay").val('1');
            } else {
                $("#cimbvatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chmybanktripay").click(function() {
            if ($(this).is(":checked")) {
                $("#mybankvatripay").val('1');
            } else {
                $("#mybankvatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chpermatavatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#permatavatripay").val('1');
            } else {
                $("#permatavatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chmuamalatvatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#muamalatvatripay").val('1');
            } else {
                $("#muamalatvatripay").val('0');
            }
        });
    });
    $(function() {
        $("#chsinarmasvatripay").click(function() {
            if ($(this).is(":checked")) {
                $("#sinarmasvatripay").val('1');
            } else {
                $("#sinarmasvatripay").val('0');
            }
        });
    });
</script>