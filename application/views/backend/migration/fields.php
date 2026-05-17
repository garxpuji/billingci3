<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Daftar Kolom / Fields Table <?= $table; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>Nama Field</th>
                        <th>Type</th>
                        <th>Max Length</th>
                        <th>Primary Key</th>
                        <?php if ($user['email'] == 'ginginabdulgoni@gmail.com') { ?>
                            <th>Action</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($fields as $fields) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $fields->name ?></td>
                            <td><?= $fields->type ?></td>
                            <td><?= $fields->max_length ?></td>
                            <td><?= $fields->primary_key ?></td>
                            <?php if ($user['email'] == 'ginginabdulgoni@gmail.com') { ?>
                                <td>
                                    <a class="btn btn-danger" href="<?= site_url('migration/delfield?column=' . $fields->name . '&table=' . $table) ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>