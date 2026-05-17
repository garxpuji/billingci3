<?php if ($company['speedtest'] != '') { ?>

    <iframe width="100%" height="650px" frameborder="0" src="<?= $company['speedtest'] ?>"></iframe>
<?php } ?>
<!--OST Widget code start-->
<?php if ($company['speedtest'] == '') { ?>
    <div style="text-align:right;">
        <div style="min-height:360px;">
            <div style="width:100%;height:0;padding-bottom:50%;position:relative;"><iframe style="border:none;position:absolute;top:0;left:0;width:100%;height:100%;min-height:360px;border:none;overflow:hidden !important;" src="//openspeedtest.com/Get-widget.php"></iframe></div>
        </div>

    </div><!-- OST Widget code end -->
<?php } ?>