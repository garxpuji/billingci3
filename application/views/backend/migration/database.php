<div class="row">
    <!-- Earnings (Monthly) Card Example -->

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Table</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totaltable ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-table fa-2x text-gray-300"></i>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
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
                        <th>Nama Table</th>
                        <th>Total Field</th>
                        <th>Detail</th>


                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($tables as $table) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $table ?></td>
                            <?php $fields = $this->db->field_data($table); ?>
                            <td><?= count($fields) ?></td>
                            <td style="text-align: center;"><a href="<?= site_url('migration/fields?table=' . $table) ?>" title="Detail"><i class="fa fa-eye" style="font-size:25px"></i></a></td>


                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>