<style>
    .switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;

    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: gray;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: blue;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php $this->view('messages') ?>


<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cash</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($saldocash['balance']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Holding</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($holding['balance']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tax</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= indo_currency($tax['balance']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- Earnings (Monthly) Card Example -->

</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Mode Pemabayaran</h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <h5>Virtual Account</h5> <br>

                        <?php foreach ($paymentChannel as $pc) { ?>
                            <?php if ($pc['channel_category'] == 'VIRTUAL_ACCOUNT') { ?>
                                <div class="row">
                                    <div class="col"><?= $pc['channel_code']; ?></div>
                                    <div class="col"> <label for="chbca_va" class="switch ml-3">
                                            <input type="checkbox" <?= $pc['is_enabled'] == 1 ? 'checked' : ''; ?> />
                                            <div class="slider round">
                                            </div>
                                        </label></div>
                                </div>
                            <?php } ?>

                        <?php } ?>



                        <!-- <h5>Credit Card</h5> <br>
                        <?php foreach ($paymentChannel as $pc) { ?>
                            <?php if ($pc['channel_category'] == 'CREDIT_CARD') { ?>
                                <div class="row">
                                    <div class="col"><?= $pc['channel_code']; ?></div>
                                    <div class="col"> <label for="chbca_va" class="switch ml-3">
                                            <input type="checkbox" <?= $pc['is_enabled'] == 1 ? 'checked' : ''; ?> />
                                            <div class="slider round">
                                            </div>
                                        </label></div>
                                </div>
                            <?php } ?>
                        <?php } ?> -->


                    </div>
                    <div class="card-body">
                        <h5>E-Wallet</h5> <br>
                        <?php foreach ($paymentChannel as $pc) { ?>
                            <?php if ($pc['channel_category'] == 'EWALLET') { ?>
                                <div class="row">
                                    <div class="col"><?= $pc['channel_code']; ?></div>
                                    <div class="col"> <label for="chbca_va" class="switch ml-3">
                                            <input type="checkbox" <?= $pc['is_enabled'] == 1 ? 'checked' : ''; ?> />
                                            <div class="slider round">
                                            </div>
                                        </label></div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <h5>RETAIL OUTLET</h5> <br>
                        <?php foreach ($paymentChannel as $pc) { ?>
                            <?php if ($pc['channel_category'] == 'RETAIL_OUTLET') { ?>
                                <div class="row">
                                    <div class="col"><?= $pc['channel_code']; ?></div>
                                    <div class="col"> <label for="chbca_va" class="switch ml-3">
                                            <input type="checkbox" <?= $pc['is_enabled'] == 1 ? 'checked' : ''; ?> />
                                            <div class="slider round">
                                            </div>
                                        </label></div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <hr>
                    </div>
                    <div class="container"> <br>
                        <span>* Catatan : Untuk melihat metode pembayaran yang aktif silahkan cek Akun Xendit anda atau Klik <a href="https://dashboard.xendit.co/settings/payment-methods">di Sini</a></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= site_url('payment') ?>" class="btn btn-primary">Setting Xendit</a>
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
</script>