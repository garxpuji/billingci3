<?php $this->view('messages') ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan Router</h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <?php echo form_open_multipart('setting/editrouter') ?>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $router['id'] ?>">
                            <label for="ip_address">IP Address</label>
                            <input id="ip_address" name="ip_address" class="form-control" value="<?= $router['ip_address'] ?>"></input>
                            <label for="username">Username</label>
                            <input id="username" name="username" class="form-control" value="<?= $router['username'] ?>"></input>
                        </div>
                        <div class="form-group">
                            <label for="footer">Password</label>
                            <input id="password" type="password" name="password" class="form-control" value="<?= $router['password'] ?>"></input>
                        </div>
                        <div class="form-group">
                            <label for="port">Port</label>
                            <input id="port" name="port" class="form-control" value="<?= $router['port'] ?>"></input>
                        </div>

                        <div class="form-group">
                            <?php
                            $ip = $router['ip_address'];
                            $user = $router['username'];
                            $pass = $router['password'];
                            $port = $router['port'];
                            $API = new Mikweb();
                            $API->connect($ip, $user, $pass, $port);
                            $resource = $API->comm("/system/resource/print");
                            // var_dump($resource);
                            ?>
                            <?php if ($resource['0']['uptime'] != null) { ?>
                                <span>Status : <div class="badge badge-success">Connected</div> </span>
                            <?php } ?>
                            <?php if ($resource['0']['uptime'] == null) { ?>
                                <span>Status : <div class="badge badge-danger">Disconnect</div> </span>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($resource['0']['uptime'] != null) { ?>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Tips and Trick
                        Mengamankan Router Mikrotik</h6> <span><code>From Mikbotam</code></span>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <li> Ganti Username dan Password Router Mikrotik secara berkala</li>
                            <li> Ubah atau Matikan Service yang Tidak Diperlukan</li>
                            <li> Non-Aktifkan Neighbors Discovery</li>
                            <li> Non-Aktifkan Neighbors Discover</li>
                            <li> Aktifkan Firewall Filter Untuk Akses Service Router (DNS dan Web Proxy)</li>
                            <li> Non-Aktifkan Btest Server</li>
                            <li> Ubah pin atau Non-Aktifkan Fitur LCD</li>
                            <li> Lakukan Backup secara berkala serta Enkripsi dan Ambil File backupnya</li>
                            <li> Other Klik <a href="http://www.mikrotik.co.id/artikel_lihat.php?id=263">Disini</a> </li>

                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
<?php } ?>
<?php ini_set('display_errors', 'off');  ?>