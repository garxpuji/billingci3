<?php //==============================START=========================================//
/*
     *  Base Code   : Gingin Abdul Goni | Rosita Wulandari, S.Kom,.MTA
     *  Email       : ginginabdulgoni@gmail.com
     *  Instagram   : @ginginabdulgoni
     *
     *  Name        : My-Wifi
     *  Function    : Manage Client and Billing
     *
     *  Please do not change this code
     *  All damage caused by editing we will not be responsible please think carefully,
     *
     */
//==============================START CODE=========================================// 
?>
<?php $this->view('messages') ?>
<?php $whatsapp = $this->db->get('whatsapp')->row_array() ?>
<?php $company = $this->db->get('company')->row_array() ?>
<?php if ($whatsapp['is_active'] == 1) { ?>
    <?php if ($whatsapp['vendor'] == 'WAblas') { ?>

        <?php if ($whatsapp['version'] == 0) { ?>
            <?php
            $curl = curl_init();
            $token = $whatsapp['token'];
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/device/info?token=$token");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            $result = json_decode($result, true);
            curl_close($curl);

            ?>
            <?php if ($result['status'] == 1) { ?>
                Status : <div class="badge badge-success"> <?= $result['data']['whatsapp']['status']; ?></div> <br> Sisa Kuota : <?= $result['data']['whatsapp']['quota']; ?> <br> Expired : <?= $result['data']['whatsapp']['expired']; ?>
            <?php } ?>
            <?php if ($result['status'] == 0) { ?>
                Status : <div class="badge badge-warning"> <?= $result['data']['whatsapp']['status']; ?></div>
            <?php } ?>
        <?php } ?>
        <?php if ($whatsapp['version'] == 1) { ?>
            <?php
            $curl = curl_init();
            $token = $whatsapp['token'];
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$whatsapp[domain_api]/api/device/info?token=$token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => "phone=$company[phonecode]$company[whatsapp]&message=test",
                CURLOPT_HTTPHEADER => array(),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            $result = json_decode($response, true);
            ?>
            <?php if ($result['status'] == 1) { ?> Status : <div class="badge badge-success"> <?= $result['data']['status']; ?></div> <br> Sisa Kuota : <?= $result['data']['quota']; ?> <br> Expired : <?= $result['data']['expired_date']; ?><?php } ?>
                <?php if ($result['status'] == 0) { ?> Status : <div class="badge badge-warning"> <?= $result['data']['status']; ?></div> <?php } ?>
            <?php } ?>
        <?php } ?>


        <?php if ($whatsapp['vendor'] == 'Starsender') { ?>
            <?php if ($whatsapp['api_key'] != '') { ?>
                <?php
                $apikey = $whatsapp['api_key'];

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://starsender.online/api/v1/getDevice',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => array(
                        'apikey: ' . $apikey
                    ),
                ));

                $result = curl_exec($curl);
                $result = json_decode($result, true);
                curl_close($curl);
                // echo $result['data']['0']['status'];
                // echo $response;
                if ($result['data']['0']['status'] == 'connected') {

                    echo 'Status WA Gateway : ' . "<div class='badge badge-success'>Connected</div>";
                } else {
                    echo "<div class='badge badge-danger'>Disconnect</div>";
                    echo '<br';
                }
                ?>



            <?php } ?>
            <?php if ($result['data']['0']['status'] != 'connected') { ?>
                <a href="<?= base_url('whatsapp/relog') ?>" class="btn btn-primary">Relog Device</a>
            <?php } ?>
        <?php } ?>
        <?php if ($whatsapp['vendor'] == 'Ruangwa') { ?>
            <?php if ($whatsapp['api_key'] != '') { ?>
                <?php
                $apikey = $whatsapp['api_key'];

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.ruangwa.id/api/device',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'token=MpS53kANrJ4GhtPH8r5sHzLwTHoBqHNyc6DA6QmjNpwsX4xWkF',
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
                // if ($result['data']['0']['status'] == 'connected') {

                //     echo 'Status WA Gateway : ' . "<div class='badge badge-success'>Connected</div>";
                // } else {
                //     echo "<div class='badge badge-danger'>Disconnect</div>";
                //     echo '<br';
                // }
                ?>



            <?php } ?>
            <?php if ($result['data']['0']['status'] != 'connected') { ?>

            <?php } ?>
        <?php } ?>

        <div class="col-lg-12 mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Kirim Pesan Whatsapp Satu Persatu</h6>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body">
                            <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                                <form action="<?= site_url('whatsapp/sendmessagecustomer') ?>" method="POST">
                                    <div class="form-group">
                                        <label for="vendor">Vendor</label>
                                        <input type="text" name="vendor" value="<?= $whatsapp['vendor'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Pelanggan Tujuan</label>
                                        <select class="form-control select2" name="target" style="width: 100%;" required>
                                            <option value="">-Pilih-</option>
                                            <?php
                                            foreach ($customer as $r => $data) { ?>
                                                <option value="<?= $data->customer_id ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pesan</label>
                                        <textarea name="message" class="form-control" style="height: 400px;"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                        <button type="submit" id="click-me-customer" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body">
                            <h5>Variable</h5>
                            - {name} = Nama Pelanggan <br>
                            - {noservices} = No Layanan <br>
                            - {email} = Email <br>
                            - {companyname} = Nama Perusahaan <br>
                            - {slogan} = Moto / Slogan Perusahaan <br>
                            - {link} = Alamat website
                        </div>
                        <div class="card-body">
                            <h5>Keterangan</h5>
                            <li>Pastikan Whatsapp Gateway Aktif dan user atau token atau api key nya benar </code></li>
                            <li>Setting Whastapp Gateway <a href="<?= site_url('whatsapp') ?>" style="text-decoration: none;">Klik disini</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Kirim Pesan Whatsapp by Status Pelanggan</h6>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body">
                            <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                                <form action="<?= site_url('whatsapp/sendmessage') ?>" method="POST">
                                    <div class="form-group">
                                        <label for="vendor">Vendor</label>
                                        <input type="text" name="vendor" value="<?= $whatsapp['vendor'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No Tujuan</label>
                                        <select class="form-control select2" name="target" style="width: 100%;" required>
                                            <option value="">-Pilih-</option>
                                            <option value="customeractive">Pelanggan Aktif</option>
                                            <option value="customernonactive">Pelanggan Non-Aktif</option>
                                            <option value="customerwaiting">Pelanggan Menunggu</option>
                                            <option value="allcustomer">Semua Pelanggan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pesan</label>
                                        <textarea name="message" class="form-control" style="height: 400px;"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                        <button type="submit" id="click-me-status" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body">
                            <h5>Variable</h5>
                            - {name} = Nama Pelanggan <br>
                            - {noservices} = No Layanan <br>
                            - {email} = Email <br>
                            - {companyname} = Nama Perusahaan <br>
                            - {slogan} = Moto / Slogan Perusahaan <br>
                            - {link} = Alamat website
                        </div>
                        <div class="card-body">
                            <h5>Keterangan</h5>
                            <li>Pastikan Whatsapp Gateway Aktif dan user atau token atau api key nya benar </code></li>
                            <li>Setting Whastapp Gateway <a href="<?= site_url('whatsapp') ?>" style="text-decoration: none;">Klik disini</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Kirim Pesan Whatsapp by Coverage Area</h6>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body">
                            <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                                <form action="<?= site_url('whatsapp/sendmessagecoverage') ?>" method="POST">
                                    <div class="form-group">
                                        <label for="vendor">Vendor</label>
                                        <input type="text" name="vendor" value="<?= $whatsapp['vendor'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Coverage Tujuan</label>
                                        <select class="form-control select2" name="target" style="width: 100%;" required>
                                            <option value="">-Pilih-</option>
                                            <?php
                                            foreach ($coverage as $r => $data) { ?>
                                                <option value="<?= $data->coverage_id ?>"><?= $data->c_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pesan</label>
                                        <textarea name="message" class="form-control" style="height: 400px;"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                        <button type="submit" id="click-me-coverage" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body">
                            <h5>Variable</h5>
                            - {name} = Nama Pelanggan <br>
                            - {noservices} = No Layanan <br>
                            - {email} = Email <br>
                            - {companyname} = Nama Perusahaan <br>
                            - {slogan} = Moto / Slogan Perusahaan <br>
                            - {link} = Alamat website
                        </div>
                        <div class="card-body">
                            <h5>Keterangan</h5>
                            <li>Pastikan Whatsapp Gateway Aktif dan user atau token atau api key nya benar </code></li>
                            <li>Setting Whastapp Gateway <a href="<?= site_url('whatsapp') ?>" style="text-decoration: none;">Klik disini</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-info" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-dark" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <?php if ($whatsapp['is_active'] == 0) { ?>
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Kirim Pesan Whatsapp Web Gratis</h6>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-customer-tab" data-toggle="pill" href="#pills-customer" role="tab" aria-controls="pills-customer" aria-selected="true">Pelanggan</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-public-tab" data-toggle="pill" href="#pills-public" role="tab" aria-controls="pills-profile" aria-selected="false">Umum</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-customer" role="tabpanel" aria-labelledby="pills-customer-tab">
                                    <form action="">
                                        <div class="form-group">
                                            <label for="name">No Tujuan</label>
                                            <select class="form-control select2" name="no_target" style="width: 100%;" required>
                                                <?php
                                                foreach ($customer as $r => $data) { ?>
                                                    <option value="<?= indo_tlp($data->no_wa) ?>"><?= $data->no_wa ?> - <?= $data->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Pesan</label>
                                            <textarea name="message" id="message" class="form-control"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                            <a href="" class="btn btn-primary" id="btn-sendWA">Kirim</a>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="pills-public" role="tabpanel" aria-labelledby="pills-public-tab">
                                    <form action="">
                                        <div class="form-group">
                                            <label for="name">No Tujuan</label>
                                            <input type="number" name="no_target2" id="no_target2" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Pesan</label>
                                            <textarea name="message2" id="message2" class="form-control"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                            <a href="" class="btn btn-primary" id="btn-sendWA2">Kirim</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body">
                            <h5>Keterangan</h5>
                            <li>Tambahkan tanda asterik (<code>*</code>) di antara text utuk menebalkan text <br>Contoh : <code>*text-tebal* </code></li>
                            <li>Tambahkan tanda underscore (<code>_</code>) di antara text utuk membuat text miring <br>Contoh : <code>_text-miring_</code> </li>
                            <li>Tambahkan tanda tilde (<code>~</code>) di antara text utuk membuat text dicoret <br>Contoh : <code>~text-coret~</code> </li>
                            <li>Tambahkan tanda (<code>%0A</code>) untuk membuat baris baru (Enter) </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') { ?>
        <!-- <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Kirim Pesan File Whatsapp Gateway</h6>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body">

                        <div class="tab-content">
                            <?php echo form_open_multipart('whatsapp/sendfile') ?>
                            <div class="form-group">
                                <label for="name">No Tujuan</label>
                                <select class="form-control select2" name="no_target" style="width: 100%;" required>
                                    <?php
                                    foreach ($customer as $r => $data) { ?>
                                        <option value="<?= indo_tlp($data->no_wa) ?>"><?= $data->no_wa ?> - <?= $data->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>File</label>
                                <input type="file" name="picture" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pesan</label>
                                <textarea name="message" id="message" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                                <button type="submit" class="btn btn-success">Kirim</button>
                            </div>
                            <?php echo form_close() ?>
                        </div>



                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <?php } ?>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>

    <script>
        $("#btn-sendWA").click(function() {
            var no_target = $('[name="no_target"]');
            var message = $('[name="message"]');
            var cno_target = $('#no_target').val();
            var cmessage = $('#message').val();
            if (cno_target == '') {
                $('#no_target').focus()
                $('#btn-sendWA').attr('href', "#");

            } else if (cmessage == '') {
                $('#message').focus()
                $('#btn-sendWA').attr('href', "#");
            } else {
                $('#btn-sendWA').attr('target', "blank");
                $('#btn-sendWA').attr('href', "https://api.whatsapp.com/send?phone=" + no_target.val() + "&text=" + message.val());
                $("#btn-sendWA").submit();
            }
        });

        $("#btn-sendWA2").click(function() {
            var no_target2 = $('[name="no_target2"]');
            var message2 = $('[name="message2"]');
            var cno_target2 = $('#no_target2').val();
            var cmessage2 = $('#message2').val();
            if (cno_target2 == '') {
                $('#no_target2').focus()
                $('#btn-sendWA2').attr('href', "#");
            } else if (cmessage2 == '') {
                $('#message2').focus()
                $('#btn-sendWA2').attr('href', "#");
            } else {
                $('#btn-sendWA2').attr('target', "blank");
                $('#btn-sendWA2').attr('href', "https://api.whatsapp.com/send?phone=" + no_target2.val() + "&text=" + message2.val());
                $("#btn-sendWA2").submit();
            }
        });

        $(document).ready(function() {
            $("#popup").modal({
                show: false,
                backdrop: 'static'
            });

            $("#click-me").click(function() {
                $("#popup").modal("show");
            });
            $("#click-me-customer").click(function() {
                $("#popup").modal("show");
            });
            $("#click-me-status").click(function() {
                $("#popup").modal("show");
            });
            $("#click-me-coverage").click(function() {
                $("#popup").modal("show");
            });
        });
    </script>