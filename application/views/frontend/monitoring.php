<div class="container mt-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="form-group">
            <label for="">Router</label>
            <select class="form-control select2" name="id" id="id" onchange="cek_data()" required>
                <option value="">-Pilih-</option>
                <?php $router = $this->db->get('router')->result() ?>
                <?php
                foreach ($router as $r => $data) { ?>
                    <option value="<?= $data->id ?>"><?= $data->alias ?> - <?= $data->ip_address ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            Auto refesh setiap 5 <input type="hidden" value="5" id="second" style="width: 50px;"> Menit
        </div>
    </div>
    <div class="" id="load_data" style="display: none;">
        <h5>Monitoring PPPOE</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <h1 class="card-text text-center "><span id="totalpppoe"></span></h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Aktif</h5>
                        <h1 class="card-text text-center"><span id="activepppoe"></span></h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Tidak Aktif</h5>
                        <h1 class="card-text text-center"><span id="nonactivepppoe"></span></h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Isolir</h5>
                        <h1 class="card-text text-center"><span id="isolirpppoe"></span></h1>
                        <div class="row">
                            <div class="col">Disable : <span id="disablepppoe"></span></div>
                            <div class="col">Expired : <span id="expiredpppoe"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hotspot -->
        <!-- <h5>Monitoring Hotspot</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <h1 class="card-text text-center ">700</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Aktif</h5>
                        <p class="card-text text-center"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Tidak Aktif</h5>
                        <p class="card-text text-center"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Isolir</h5>
                        <p class="card-text text-center"></p>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Static -->
        <!-- <h5>Monitoring Static</h5>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <h1 class="card-text text-center ">700</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Aktif</h5>
                        <p class="card-text text-center"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Tidak Aktif</h5>
                        <p class="card-text text-center"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Isolir</h5>
                        <p class="card-text text-center"></p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<script>
    function cek_data() {
        var id = $("#id").val();
        if (id == '') {
            alert('Router belum dipilih');
            $('#id').focus();
        } else {

            $.ajax({
                type: 'POST',
                data: "&id=" + id,
                cache: false,
                url: '<?= site_url('front/getmonitoring') ?>',
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
                    var c = jQuery.parseJSON(data);
                    $('#load_data').show();
                    $('#totalpppoe').html(c['totalpppoe']);
                    $('#activepppoe').html(c['activepppoe']);
                    $('#nonactivepppoe').html(c['nonactivepppoe']);
                    $('#disablepppoe').html(c['disablepppoe']);
                    $('#isolirpppoe').html(c['isolirpppoe']);
                    $('#expiredpppoe').html(c['expiredpppoe']);
                }

            });
        }
        return false;
    }
</script>
<script>
    var second = $("#second").val();
    var time = second * 60000;
    setInterval("refresh();", time);


    function refresh() {
        console.log('refresh ' + time + ' Menit')
        var id = $("#id").val();
        if (id == '') {
            // alert('Router belum dipilih');
            // $('#id').focus();
        } else {

            $.ajax({
                type: 'POST',
                data: "&id=" + id,
                cache: false,
                url: '<?= site_url('front/getmonitoring') ?>',
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
                    var c = jQuery.parseJSON(data);
                    $('#load_data').show();
                    $('#totalpppoe').html(c['totalpppoe']);
                    $('#activepppoe').html(c['activepppoe']);
                    $('#nonactivepppoe').html(c['nonactivepppoe']);
                    $('#disablepppoe').html(c['disablepppoe']);
                    $('#isolirpppoe').html(c['isolirpppoe']);
                    $('#expiredpppoe').html(c['expiredpppoe']);
                }

            });
        }
        return false;
    }
</script>