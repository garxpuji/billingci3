<?php $this->view('messages') ?>
<form method="post" action="<?= base_url('help/addhelp') ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-4 col-sm-6 col-md-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-25">No Layanan</h6>
                            <h3 class="fw-700 text-red text-center"><?= $customer['no_services']; ?></h3>
                            <!-- <p class="mb-0">Item Layanan</p> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-md-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-25">Pilih Topik</h6>
                            <div class="form-group">
                                <select name="type" id="type" class="form-control" onChange="selecttype(this);">

                                    <option value="">-Pilih-</option>
                                    <?php foreach ($type as $data) { ?>
                                        <option value="<?= $data->help_id ?>"><?= $data->help_type ?></option>
                                    <?php } ?>


                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div id="helpsolution" style="display: none" class="col-lg-4 col-sm-6 col-md-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-25">Pilih Laporan</h6>
                            <div class="form-group">
                                <select name="solution" id="solution" class="form-control" onChange="selectsolution(this);">
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div id="helpsolutiondetail" style="display: none" class="col-12">
            <div class="card comp-card">
                <div class="box box-primary">
                    <div class="card-body">
                        <div class="" id="solutiondetail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="loading"></div>
    </div>
    <div class="row">
        <div id="buttonnext" style="display: none" class="col-lg-4 col-sm-6 col-md-6">

            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fw-700 text-red text-center">
                                <span id="clicknext" class="badge badge-danger">Lanjutkan</span>
                            </h2>
                            <!-- <p class="mb-0">Item Layanan</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="remark" style="display: none" class="col-12">
            <div class="card comp-card">
                <div class="box box-primary">
                    <div class="card-body">
                        <span>Kami mohon maaf atas kendala anda, laporkan permasalahannya sekarang. Tim kami akan segera menghubungi Anda.</span> <br>
                        <h6>Data Anda </h6>
                        Nama : <?= $customer['name']; ?> <br>
                        No Telp. : <?= $customer['no_wa']; ?> <br>
                        Alamat : <?= $customer['address']; ?> <br>
                        <h6 class="mb-25 mt-2">Keterangan :</h6>
                        <input type="hidden" name="no_services" value="<?= $customer['no_services'] ?>">
                        <textarea name="remark" class="form-control" placeholder="Detail Permasalahan anda dan data lain yang bisa dihubungi"></textarea>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-25 mt-2">Lampiran :</h6>
                        <input type="file" class="form-control" name="picture">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="clicklapor" style="display: none" class="col-lg-4 col-sm-6 col-md-6">

            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fw-700 text-red text-center">
                                <a href="<?= site_url('member') ?>"><span class="badge badge-secondary"> Batal</span></>
                            </h2>
                            <h2 class="fw-700 text-red text-center">
                                <button class="btn btn-danger" type="submit"> Lapor Gangguan</button>
                            </h2>
                            <!-- <p class="mb-0">Item Layanan</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->

<script>
    function selecttype(sel) {
        var type = $("#type").val();
        $('#helpsolutiondetail').hide();
        $('#helpsolution').hide();
        $('#buttonnext').hide();
        $('#clicklapor').hide();
        $('#remark').hide();
        if (type != '') {
            var url = "<?= site_url('help/getsolution') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&type=" + type,
                cache: false,
                beforeSend: function() {
                    $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                },
                success: function(data) {
                    $('.loading').html('');
                    $('#solution').html(data);
                    $('#helpsolution').show();
                }
            });
            return false;
        }
    }

    function selectsolution(sel) {
        var idsolution = $("#solution").val();
        $('#helpsolutiondetail').hide();
        $('#buttonnext').hide();
        $('#clicklapor').hide();
        $('#remark').hide();
        if (idsolution != '') {
            var url = "<?= site_url('help/getsolutiondetail') ?>" + "/" + Math.random();
            $.ajax({
                type: 'POST',
                url: url,
                data: "&solution=" + idsolution,
                cache: false,
                beforeSend: function() {
                    $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                },
                success: function(data) {
                    $('.loading').html('');
                    $('#solutiondetail').html(data);
                    $('#helpsolutiondetail').show();
                    $('#buttonnext').show();
                }
            });
            return false;
        }
    }

    $("#clicknext").click(function() {
        $('#remark').show();
        $('#helpsolutiondetail').hide();
        $('#clicklapor').show();
        $('#buttonnext').hide();
    });
</script>