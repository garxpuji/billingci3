<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Data Riwayat Tagihan Pelanggan </h6>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-0 mt-2">
                <label class="col-sm-12 col-form-label">Nama - No Layanan</label>
            </div>
            <div class="col-sm-4 mt-2 ">
                <select class="form-control select2" name="no_services" id="no_services" style="width: 100%;" required>
                    <?php $countcustomer = $this->db->get('customer')->num_rows() ?>
                    <?php if ($countcustomer < 500) { ?>
                        <option value="">-Semua Pelanggan-</option>
                    <?php } ?>
                    <?php
                    foreach ($customer as $r => $data) { ?>
                        <option value="<?= $data->no_services ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-0 mt-2">
                <label class="col-sm-12 col-form-label">Tahun</label>
            </div>
            <div class="col-sm-3  mt-2">
                <select class="form-control select2" style="width: 100%;" name="year" required>
                    <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                    <?php
                    for ($i = date('Y'); $i >= 2018; $i -= 1) {
                    ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-2 mt-2">
                <button class="btn btn-primary mb-2 my-2 my-sm-0" type="submit" onclick="cek_bill()">Filter</button>
            </div>
        </div>
        <div class="loading"></div>
        <div class="view_data"></div>
    </div>
</div>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });

    function cek_bill() {
        no_services = $('[name="no_services"]');
        year = $('[name="year"]');
        $.ajax({
            type: 'POST',
            data: "cek_bill=" + 1 + "&no_services=" + no_services.val() + "&year=" + year.val(),
            url: '<?= site_url('bill/view_history') ?>',
            cache: false,

            beforeSend: function() {
                no_services.attr('disabled', true);
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
                no_services.attr('disabled', false);
                year.attr('disabled', false);
                $('.loading').html('');
                $('.view_data').html(data);
            }
        });
        return false;
    }
</script>