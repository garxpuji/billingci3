<?php $this->view('messages') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Data Area</h6>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col">Nama </div>
                    <div class="col">: <?= $coverage['c_name']; ?></div>
                </div>
                <div class="row">
                    <div class="col">Kode Area</div>
                    <div class="col">: <?= $coverage['code_area']; ?></div>
                </div>
                <div class="row">
                    <div class="col">Alamat</div>
                    <div class="col">: <?= $coverage['address']; ?></div>
                </div>
                <div class="row">
                    <div class="col">Keterangan</div>
                    <div class="col">: <?= $coverage['comment']; ?></div>
                </div>


                <?php $active = $this->db->get_where('customer', ['coverage' => $coverage['coverage_id'], 'c_status' => 'Aktif'])->num_rows(); ?>
                <?php $nonactive = $this->db->get_where('customer', ['coverage' => $coverage['coverage_id'], 'c_status' => 'Non-Aktif'])->num_rows(); ?>
                <?php $waiting = $this->db->get_where('customer', ['coverage' => $coverage['coverage_id'], 'c_status' => 'Menunggu'])->num_rows(); ?>
                <div class="row">
                    <div class="col">Pelanggan Aktif</div>
                    <div class="col">: <?= indo_currency($active) ?></div>
                </div>
                <div class="row">
                    <div class="col">Pelanggan Non-Aktif</div>
                    <div class="col">: <?= indo_currency($nonactive) ?></div>
                </div>
                <div class="row">
                    <div class="col">Pelanggan Menunggu</div>
                    <div class="col">: <?= indo_currency($waiting) ?></div>
                </div>


                <div class="row">
                    <div class="col">Raidus</div>
                    <div class="col">: <?= $coverage['radius']; ?></div>
                </div>
                <div class="row">
                    <div class="col">Latitude</div>
                    <div class="col">: <?= $coverage['latitude']; ?></div>
                </div>
                <div class="row">
                    <div class="col">Longitude</div>
                    <div class="col">: <?= $coverage['longitude']; ?></div>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="addoperator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Operator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('coverage/addoperator') ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Nama Area / Code Area</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $coverage['c_name'] ?>" autocapitalize="off" readonly>
                    </div>
                    <input type="hidden" name="coverage_id" value="<?= $coverage['coverage_id'] ?>">
                    <div class="form-group">
                        <label for="operator">Pengguna</label>
                        <select name="operator" id="operator" class="form-control select2" style="width: 100%;" required>
                            <?php $operator = $this->coverage_m->getusercoverage()->result() ?>
                            <option value="">Pilih Pengguna</option>
                            <?php
                            foreach ($operator as $data) {
                                if ($data->role_id == 3) {
                                    $role_id = 'Operator';
                                } elseif ($data->role_id == 4) {
                                    $role_id = 'Mitra';
                                } elseif ($data->role_id == 5) {
                                    $role_id = 'Teknisi';
                                } elseif ($data->role_id == 6) {
                                    # code...
                                } elseif ($data->role_id == 7) {
                                    # code...
                                } elseif ($data->role_id == 8) {
                                    # code...
                                };
                                echo '<option value="' . $data->id . '">' . $data->name . ' - ' . $role_id . '</option>';
                            }
                            ?>
                            <select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>