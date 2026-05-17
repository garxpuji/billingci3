<div class="row">

    <div class="col-md-12">

        <div class="card shadow mb-2">

            <div class="card-header py-1">

                <h6 class="m-0 font-weight-bold">Log Activity</h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="box box-widget">

                            <div class="box-body table-responsive">

                                <table class="table " id="tablebt">

                                    <thead>

                                        <tr style="text-align: center">

                                            <th>No</th>

                                            <th>Waktu</th>
                                            <th>Kategori</th>
                                            <th>Keterangan</th>
                                        </tr>

                                    </thead>

                                    <tbody id="dataTables">

                                        <?php $no = 1;
                                        foreach ($logs as $log) { ?>




                                            <tr style="text-align: center">

                                                <td><?= $no++ ?></td>

                                                <td><?= date('d', $log->datetime) ?> <?= indo_month('m', $log->datetime); ?> <?= date('Y', $log->datetime) ?> - <?= date('h:i:s a', $log->datetime) ?></td>
                                                <td><?= $log->category ?></td>
                                                <td><?= $log->remark ?></td>

                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                    </tfoot>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>

</div>