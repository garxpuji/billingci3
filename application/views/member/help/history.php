<?php $this->view('messages') ?>
<div class="row">
    <?php
    foreach ($help as $r => $data) { ?>
        <div class="col-lg-4 col-sm-6 col-md-6">
            <a href="#" data-toggle="modal" data-target="#Modal<?= $data->id ?>">
                <div class="card proj-t-card">
                    <div class="card-body">
                        <div class="row align-items-center mb-20">
                            <div class="col-auto">
                                <i class="far fa-calendar-check text-red f-30"></i>
                            </div>
                            <div class="col pl-0">
                                <h6 class="mb-5">No Tiket #T-<?= $data->no_ticket ?></h6>
                                <?php $type = $this->db->get_where('help_type', ['help_id' => $data->help_type])->row_array(); ?>
                                <?php $solution = $this->db->get_where('help_solution', ['hs_id' => $data->help_solution])->row_array(); ?>
                                <h6 class="mb-0 text-red"><?= $type['help_type']; ?></h6>
                                <small><?= $solution['hs_name']; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <span class="mb-0">Tanggal Order : <?= date('d', $data->date_created); ?> <?= indo_month(date('m', $data->date_created)); ?> <?= date('Y', $data->date_created); ?> <?= date('H:i:s', $data->date_created); ?></span>

                        </div>
                        <?php if ($data->status == 'close') { ?>
                            <h6 class="pt-badge bg-success">
                                <?= ucwords(strtolower($data->status)); ?>
                            </h6>
                        <?php } ?>
                        <?php if ($data->status == 'process') { ?>
                            <h6 class="pt-badge bg-warning">
                                <?= ucwords(strtolower($data->status)); ?>
                            </h6>
                        <?php } ?>
                        <?php if ($data->status == 'pending') { ?>
                            <h6 class="pt-badge bg-red">
                                <?= ucwords(strtolower($data->status)); ?>
                            </h6>
                        <?php } ?>
                    </div>
                </div>
            </a>

        </div>


    <?php } ?>

</div>
<?php
foreach ($help as $r => $data) { ?>


    <div class="modal fade" id="Modal<?= $data->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="card" style="margin-top: -40px;">
                    <div class="card-header">
                        <h3>Timeline</h3>
                    </div>
                    <div class="card-body timeline">
                        <div class="card proj-t-card">
                            <div class="card-body">
                                <div class="row align-items-center mb-20">
                                    <div class="col-auto">
                                        <i class="far fa-calendar-check text-red f-30"></i>
                                    </div>
                                    <div class="col pl-0">
                                        <h6 class="mb-5">No Tiket #T-<?= $data->no_ticket ?></h6>
                                        <?php $type = $this->db->get_where('help_type', ['help_id' => $data->help_type])->row_array(); ?>
                                        <?php $solution = $this->db->get_where('help_solution', ['hs_id' => $data->help_solution])->row_array(); ?>
                                        <h6 class="mb-0 text-red"><?= $type['help_type']; ?></h6>
                                        <small><?= $solution['hs_name']; ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <span class="mb-0">Tanggal Order : <?= date('d', $data->date_created); ?> <?= indo_month(date('m', $data->date_created)); ?> <?= date('Y', $data->date_created); ?> <?= date('H:i:s', $data->date_created); ?></span>

                                </div>
                                <?php if ($data->status == 'close') { ?>
                                    <h6 class="pt-badge bg-success">
                                        <?= ucwords(strtolower($data->status)); ?>
                                    </h6>
                                <?php } ?>
                                <?php if ($data->status == 'process') { ?>
                                    <h6 class="pt-badge bg-warning">
                                        <?= ucwords(strtolower($data->status)); ?>
                                    </h6>
                                <?php } ?>
                                <?php if ($data->status == 'pending') { ?>
                                    <h6 class="pt-badge bg-red">
                                        <?= ucwords(strtolower($data->status)); ?>
                                    </h6>
                                <?php } ?>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div class="bullet bg-red"></div>
                                <div class="time"><?= date('H:i:s', $data->date_created); ?> <br><?= date('d-m-Y', $data->date_created); ?></div>
                                <?php $createby = $this->db->get_where('user', ['id' => $data->create_by])->row_array(); ?>
                                <?php if ($createby['role_id'] == 1) {
                                    $level = 'Administrator';
                                } elseif ($createby['role_id'] == 2) {
                                    $level = 'Pelanggan';
                                } elseif ($createby['role_id'] == 3) {
                                    $level = 'Operator';
                                } ?>
                                <div class="desc">
                                    <h3>Tiket dibuat </h3>
                                    <h4>Status : Pending</h4>
                                    <h4>Create by : <?= $createby['name']; ?> (<?= $level; ?>) </h4>
                                    <img src="<?= base_url('assets/images/help/' . $data->picture) ?>" alt="" style="width: 250px;">
                                </div>
                            </li>
                            <?php
                            $id = $data->id;
                            $query = "SELECT *
                             FROM `help_timeline`
                                 WHERE `help_timeline`.`help_id` = $id order by date_update asc";
                            $timeline = $this->db->query($query)->result(); ?>

                            <?php
                            foreach ($timeline as $r => $dataa) { ?>
                                <?php $users = $this->db->get_where('user', ['id' => $dataa->teknisi])->row_array() ?>
                                <?php if ($users['role_id'] == 1) {
                                    $roleid = "Administrator";
                                } elseif ($users['role_id'] == 2) {
                                    $roleid = "Pelanggan";
                                } elseif ($users['role_id'] == 3) {
                                    $roleid = "Operator";
                                } elseif ($users['role_id'] == 5) {
                                    $roleid = "Teknisi";
                                } ?>
                                <li>
                                    <?php if ($dataa->status == 'process') { ?>
                                        <div class="bullet bg-default"></div>
                                    <?php } ?>
                                    <?php if ($dataa->status == 'close') { ?>
                                        <div class="bullet bg-green"></div>
                                    <?php } ?>
                                    <div class="time"><?= date('H:i:s', $dataa->date_update); ?> <br><?= date('d-m-Y', $dataa->date_update); ?></div>
                                    <div class="desc">
                                        <?php if ($dataa->status == 'process') { ?>
                                            <h3>Tiket sedang diproses</h3>
                                        <?php } ?>
                                        <?php if ($dataa->status == 'close') { ?>
                                            <h3>Tiket Selesai</h3>
                                        <?php } ?>
                                        <h4>Update by <?= $users['name']; ?> (<?= $roleid; ?>) - <?= $users['phone']; ?></h4>
                                        <h4><?= $dataa->remark; ?></h4>
                                    </div>
                                </li>
                            <?php } ?>

                        </ul>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <?php if ($data->status != 'close') { ?>
                            <a href="#" data-toggle="modal" id="donetiket" data-target="#Modaldonetiket" data-iddone="<?= $data->id ?>" data-tiket="<?= $data->no_ticket ?>">Selesai</a>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<div class="modal fade" id="Modaldonetiket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Laporan Selesai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('help/donecustomer') ?>" method="POST">
                    <input type="hidden" name="id" id="modalidhelp">
                    Apakah anda yakin akan menyelesaikan tiket T-<span id="modaltiket"></span> ?

                    <div class="form-group mt-2">
                        <label for="description">Keterangan</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Update terkait tiket, contoh : sudah kembali normal"></textarea>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Lanjutkan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#donetiket', function() {
        $('#modalidhelp').val($(this).data('iddone'))
        $('#modaltiket').html($(this).data('tiket'))

    })
</script>