<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> <?= $title ?>

        </h6>
    </div>
    <div class="card-body">

        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="box">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th>Name</th>
                            <th>Waktu</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Level</th>
                            <?php if ($user['email'] == 'ginginabdulgoni@gmail.com') { ?>
                                <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($logs as $log) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $log->name; ?></td>
                                <td><?= date('d-M-Y', $log->datetime) ?> - <?= date('H:i:s', $log->datetime) ?></td>
                                <td style="text-align: center"><?= $log->category ?></td>
                                <td><?= $log->remark ?></td>
                                <td>
                                    <?= $log->role_id == 0 ? 'System' : '' ?>
                                    <?= $log->role_id == 1 ? 'Admin' : '' ?>
                                    <?= $log->role_id == 2 ? 'Pelanggan' : '' ?>
                                    <?= $log->role_id == 3 ? 'Operator' : '' ?>
                                    <?= $log->role_id == 4 ? 'Mitra' : '' ?>
                                    <?= $log->role_id == 5 ? 'Teknisi' : '' ?>
                                    <?= $log->role_id == 6 ? 'Outlet' : '' ?>
                                    <?= $log->role_id == 7 ? 'Kolektor' : '' ?>
                                    <?= $log->role_id == 8 ? 'Finance' : '' ?>
                                </td>
                                <?php if ($user['email'] == 'ginginabdulgoni@gmail.com') { ?>
                                    <td>
                                        <a class="btn btn-danger" href="<?= site_url('logs/del/' . $log->log_id) ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
    </div>
    </section>
    <!-- MODAL eDIT -->

    <!--END MODAL eDIT-->

</div>