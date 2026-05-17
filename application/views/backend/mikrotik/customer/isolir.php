<?php
$routerlist = $this->db->get('router')->result(); ?>
<?php foreach ($routerlist as $list) { ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Data Pelanggan Router <?= $list->alias; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center; width:20px">No</th>
                            <th>No Layanan</th>
                            <th>Nama</th>

                            <th>Mode</th>
                            <th>User</th>
                            <th>Status</th>

                            <?php if ($this->session->userdata('role_id') == 1) { ?>
                                <th style="text-align: center">Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tfoot>

                    </tfoot>
                    <tbody>
                        <?php $customer = $this->db->get_where('customer', ['router' => $list->id])->result(); ?>
                        <?php $no = 1;
                        foreach ($customer as $data) { ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $data->no_services ?></td>
                                <td><?= $data->name ?></td>
                                <td><?= $data->mode_user ?></td>
                                <td><?= $data->user_mikrotik ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php } ?>