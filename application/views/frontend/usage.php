<div class="container">
    <div class="section-services">
        <div class="row mt-4">
            <div class="col-lg-6 mb-2">
                <div class="card border-danger">
                    <div class="card-body">
                        <h5 class="card-title">Cek Pemakaian Internet</h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <input class="form-control mb-2 mr-sm-2" id="no_services" name="no_services" type="number" placeholder="No Layanan" required>
                            </div>

                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary mb-2 my-2 my-sm-0" type="submit" onclick="cek_usage()">Cek</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-2 mt-1">

                <div class="loading"></div>
                <div class="view_data"></div>


            </div>

        </div>
    </div>
</div>
<script>
    function cek_usage() {
        var no = $('#no_services').val()

        no_services = $('[name="no_services"]');

        if (no == '') {
            $('#no_services').focus()
        } else {
            $.ajax({
                type: 'POST',
                data: "&no_services=" + no_services.val(),
                url: '<?= site_url('front/cekUsage') ?>',
                cache: false,
                beforeSend: function() {
                    no_services.attr('disabled', true);
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
                    $('.loading').html('');
                    $('.view_data').html(data);
                }
            });

        }
        return false;
    }
</script>