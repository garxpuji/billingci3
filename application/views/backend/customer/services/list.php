<div class="col-lg-12">
    <div class="card shadow mb-2">
        <div class="card-header py-1">
            <h6 class="m-0 font-weight-bold">Rincian Layanan <?= $customer->name ?></h6> #<?= $customer->no_services ?>
        </div>
        <?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
        <?php if ($rt['is_active'] == 1) { ?>
            <?php if ($customer->user_mikrotik != '' && $customer->mode_user != '') { ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Router</label>
                                    <?php $router = $this->db->get_where('router', ['id' => $customer->router])->row_array() ?>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?= $router['alias'] ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Mode</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?= $customer->mode_user ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">User <?= $customer->mode_user; ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?= $customer->user_mikrotik ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        $ip = $router['ip_address'];
                        $user = $router['username'];
                        $pass = $router['password'];
                        $port = $router['port'];
                        $API = new Mikweb();
                        $usermikrotik = $customer->user_mikrotik;
                        $API->connect($ip, $user, $pass, $port);
                        if ($customer->mode_user == 'PPPOE') {
                            $userprofile = $API->comm('/ppp/profile/print');
                            $getuser = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $usermikrotik));
                        };
                        if ($customer->mode_user == 'Hotspot') {
                            $userprofile = $API->comm('/ip/hotspot/user/profile/print');
                            $getuser = $API->comm("/ip/hotspot/user/print", array('?name' => $usermikrotik));
                        };
                        if ($customer->mode_user == 'Static') {

                            $getuser = $API->comm("/queue/simple/print", array('?name' => $usermikrotik,));
                        };
                        ?>
                        <?php if ($customer->mode_user == 'PPPOE'  or $customer->mode_user == 'Hotspot') { ?>
                            <div class="col-md-3">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Profile </label>
                                        <div class="col-sm-8">
                                            <select name="userprofile" id="userprofile" class="form-control" onchange="">
                                                <?php if ($customer->user_profile == '' or $customer->user_profile == 'EXPIRED') { ?>
                                                    <option value="">-Pilih-</option>
                                                    <?php
                                                    foreach ($userprofile as $key => $data) { ?>
                                                        <option value="<?= $data['name']; ?>"><?= $data['name']; ?></option>

                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($customer->user_profile != '') { ?>
                                                    <option value="<?= $customer->user_profile ?>"><?= $customer->user_profile; ?></option>
                                                    <?= $userprofile; ?>
                                                    <?php
                                                    foreach ($userprofile as $key => $data) { ?>
                                                        <option value="<?= $data['name']; ?>"><?= $data['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        <?php } ?>

    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <a href="#" data-toggle="modal" data-target="#addModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Layanan</a>
                    <?php $subtotal = 0;
                    foreach ($services->result() as $c => $data) {
                        $subtotal += (int) $data->total;
                    } ?>

                    <h3 style="font-weight:bold"> <?= indo_currency($customer->cust_amount) ?> /bln</h3>

                </div>
            </div>
            <br>
            <div class="container">
                <?php $this->view('messages') ?>
            </div>
            <div class="card-body py-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-widget">
                            <div class="box-body table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="text-align: center; width:20px">No</th>
                                            <th>Item Layanan</th>
                                            <th>Kategori</th>
                                            <th style="text-align: center">Jumlah</th>
                                            <th style="text-align: center">Harga</th>
                                            <th style="text-align: center">Diskon</th>
                                            <th style="text-align: center">Total</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTables">
                                        <?php $this->view('backend/customer/services/detail_services'); ?>
                                    <tfoot>
                                        <?php if ($customer->ppn == 1) { ?>
                                            <tr style="text-align: right">
                                                <th colspan="6">PPN</th>
                                                <th><?= indo_currency($subtotal * ($company['ppn'] / 100)) ?></th>
                                            </tr>
                                        <?php } ?>
                                        <tr style="text-align: right">
                                            <th colspan="6"><b> Total</b></th>
                                            <th><?= indo_currency($customer->cust_amount) ?></th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($rt['is_active'] == 1) { ?>
        <?php if ($customer->user_mikrotik != '' && $customer->mode_user != '') { ?>
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h3>Detail User On Mikrotik</h3>
                    </div>
                    <br>

                    <div class="card-body py-0">

                        <?php
                        foreach ($getuser[0] as $key => $item) {   ?>
                            <div class="row">
                                <div class="col"><?= $key; ?></div>
                                <div class="col">: <?= $item; ?></div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width:20px">No</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Kategori</th>

                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th style="text-align: center">No</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Kategori</th>

                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1;
                            foreach ($p_item as $r => $data) { ?>
                                <tr>
                                    <td style="text-align: center"><?= $no++ ?>.</td>
                                    <td><?= $data->nameItem ?></td>
                                    <td><?= indo_currency($data->price) ?></td>
                                    <td><?= $data->category_name ?></td>
                                    <form action="<?= site_url('services/add/' . $customer->no_services) ?>" method="post">

                                        <input type="hidden" name="qty" class="form-control input-number" value="1" min="1" max="100">

                                        <td style="text-align: center">
                                            <input type="hidden" value="<?= $customer->no_services ?>" name="no_services">
                                            <input type="hidden" value="<?= $data->p_item_id ?>" name="item_id">
                                            <input type="hidden" value="<?= $data->p_category_id ?>" name="category_id">
                                            <input type="hidden" value="<?= $data->price ?>" name="price">
                                            <button class="btn btn-success" type="submit" title="Add"><i class="fa fa-plus"> Tambahkan</i></button>
                                    </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // on modal edit
    $(document).on('click', '#update', function() {
        $('#services_id').val($(this).data('services_id'))
        $('#no_services').val($(this).data('no_services'))
        $('#item_name').val($(this).data('item_name'))
        $('#category_name').val($(this).data('category_name'))
        $('#price').val($(this).data('price'))
        $('#paket').val($(this).data('paket'))
        $('#qty').val($(this).data('qty'))
        $('#category').val($(this).data('category'))
        $('#disc').val($(this).data('disc'))
        $('#total').val($(this).data('total'))
        $('#remark').val($(this).data('remark'))
    })


    function count() {
        var price = $('#price').val()
        var qty = $('#qty').val()
        var disc = $('#disc').val()
        total = (price * qty) - disc
        $('#total').val(total)
    }

    $(document).on('keyup mouseup', '#disc, #qty, #price', function() {
        count()
    })
    $('#userprofile').on('change', function() {
        //   alert(this.value);
        var userprofile = this.value;
        var no_services = "<?= $customer->no_services ?>";
        if (userprofile == 'EXPIRED') {
            Swal.fire({
                icon: 'error',
                html: 'User Profile ini dilarang',
                showConfirmButton: true,
            })
        } else {
            $.ajax({
                type: 'POST',
                data: "&userprofile=" + userprofile + "&no_services=" + no_services,
                cache: false,
                url: '<?= site_url('customer/updateuserprofile') ?>',
                cache: false,

                success: function(data) {
                    var c = jQuery.parseJSON(data);
                    if (c['status'] == 1) {
                        Swal.fire({
                            icon: 'success',
                            html: 'User Profile berhasil diperbaharui',
                            showConfirmButton: true,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            html: 'User Profile gagal diperbaharui',
                            showConfirmButton: true,
                        })
                    }

                }

            });
        }

    });
</script>