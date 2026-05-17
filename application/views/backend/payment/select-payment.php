<?php foreach ($paymentChannel as $pc) { ?>
    <?php if ($pc['channel_category'] == $selectPayment and $pc['is_enabled'] == 'true') { ?>
        <button type="button" class="btn btn-outline-primary" id="select" data-select="<?= $pc['channel_code']; ?>"><?= $pc['channel_code']; ?></button>
    <?php } ?>
<?php } ?>