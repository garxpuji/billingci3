<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Data Donasi </h6>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-0 mt-2">
                <label class="col-sm-12 col-form-label">Bulan</label>
            </div>
            <div class="col-sm-3 mt-2 ">
                <select id="month" name="month" class="form-control" required>
                    <option value="<?= date('m') ?>"><?= indo_month(date('m')) ?></option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="col-md-0 mt-2">
                <label class="col-sm-12 col-form-label">Tahun</label>
            </div>
            <div class="col-sm-3  mt-2">
                <select class="form-control " style="width: 100%;" type="text" id="year" name="year" autocomplete="off" required>
                    <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                    <?php
                    for ($i = date('Y'); $i >= date('Y') - 2; $i -= 1) {
                    ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-3 mt-2">
                <button class="btn btn-primary mb-2 my-2 my-sm-0" type="submit" onclick="cek_bill()">Cek Donasi</button>
            </div>
        </div>
        <div class="loading"></div>
        <div class="view_data"></div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="col-lg-12">
        <div class="card-header ">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-info-circle" style="font-size: 24px"> About Us</i></h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <img src="<?= base_url('assets/images/1112-project.jpg') ?>" style=" display: block;margin-left: auto;margin-right: auto;width: 100%;" alt="">
                </div>
                <div class="container">
                    No. Telp / WA / Telegram : <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp(6285283935826) ?>&text=Hallo, My-Wifi" target="blank">(+62)852-8393-5826</i></a>
                    <br>
                    Email : 11dubelasproject@gmail.com
                    <br>
                    Instagram : <a href=" https://www.instagram.com/1112.project/">1112.project </a> <br>
                    Website : <a href="https://1112-project.com/" target="blank" style="text-decoration: none;">www.1112-project.com</a>
                    <div class="row mt-1 mb-1 ml-2">
                        <script src="https://apis.google.com/js/platform.js" gapi_processed="true"></script>
                        <div id="___ytsubscribe_0" style="text-indent: 0px; margin: 0px; padding: 0px; background: transparent; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline; display: inline-block; width: 169px; height: 48px;"><iframe ng-non-bindable="" frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="position: static; top: 0px; width: 169px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 48px;" tabindex="0" vspace="0" width="100%" id="I0_1591374118028" name="I0_1591374118028" src="https://www.youtube.com/subscribe_embed?usegapi=1&amp;channelid=UCdszTqfUaxHDIrcn0YQnXNA&amp;layout=full&amp;count=default&amp;origin=https%3A%2F%2Fbillwifi.com&amp;gsrc=3p&amp;ic=1&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.id.9r5WlWXfDAM.O%2Fam%3DwQE%2Fd%3D1%2Fct%3Dzgms%2Frs%3DAGLTcCPMgYrADsPWYiIfT6-NpQi3u8Wdog%2Fm%3D__features__#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled%2Cdrefresh%2Cerefresh%2Conload&amp;id=I0_1591374118028&amp;_gfid=I0_1591374118028&amp;parent=https%3A%2F%2Fbillwifi.com&amp;pfname=&amp;rpctoken=46059152" data-gapiattached="true"></iframe></div>
                    </div>
                </div>
                <div class="container">
                    Bagi yang ingin donasi silahkan ke rekening atau dompet digital berikut. <br>
                    <div class="row mt-2">

                        <div class="col-4 d-none d-md-block">
                            <img src="<?= base_url('assets/images/bri.png') ?>" alt="" style="width: 100px"> <br>
                        </div>
                        <div class="col-8">
                            <h5 class="mt-3">BRI : 417901019831536</h5>
                            <h5>A/N : Gingin Abdul Goni</h5>
                        </div>
                        <div class="col-4 d-none d-md-block">
                            <img src="<?= base_url('assets/images/ovo.jpg') ?>" alt="" style="width: 100px"> <br>
                        </div>
                        <div class="col-8 mt-2">
                            <h5 class="mt-3">OVO atau DANA : 082337481227</h5>
                            <h5>A/N : Gingin Abdul Goni</h5>
                        </div>

                    </div>
                </div>
                <br>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <img src="<?= base_url('assets/images/we.jpg') ?>" style=" display: block;margin-left: auto;margin-right: auto;width: 100%;" alt="">
                </div>
                <div class="container">
                    <div class="row" style="text-align: center">
                        <div class="col-lg-5">
                            <h6>Gingin Abdul Goni</h6>
                        </div>
                        <div class="col-lg-7">
                            <h6>Rosita Wulandari, S.Kom., MTA</h6>
                        </div>
                    </div>
                    <br>
                    <h3 style="text-align: center">Terima Kasih</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function cek_bill() {
        month = $('[name="month"]');
        year = $('[name="year"]');
        $.ajax({
            type: 'POST',
            data: "cek_bill=" + 1 + "&month=" + month.val() + "&year=" + year.val(),
            url: '<?= site_url('bill/view_donation') ?>',
            cache: false,

            beforeSend: function() {
                month.attr('disabled', true);
                year.attr('disabled', true);
                $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
            },
            success: function(data) {
                month.attr('disabled', false);
                year.attr('disabled', false);
                $('.loading').html('');
                $('.view_data').html(data);
            }
        });
        return false;
    }
</script>