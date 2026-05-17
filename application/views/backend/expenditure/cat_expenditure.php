<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
    <?php if ($this->session->userdata('role_id') == 1 or $role['add_income'] == 1) { ?>
        <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    <?php } ?>
</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Data Kategori</h6>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <form method="post" action="" id="submit-cetak">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center; width:20px">No</th>
                                    <th>Nama Kategori</th>

                                    <th>Keterangan</th>

                                    <th style="text-align: center; width:50px">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>

                            </tfoot>
                            <tbody>
                                <?php $no = 1;
                                foreach ($category as $r => $data) { ?>
                                    <tr>
                                        <td style="text-align: center"><?= $no++ ?>.</td>

                                        <td><?= $data->name ?></td>
                                        <td><?= $data->remark ?></td>
                                        </td>
                                        <td style="text-align: center"><a href="#" data-toggle="modal" data-target="#edit<?= $data->category_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>

                                            <a href="" data-toggle="modal" data-target="#delete<?= $data->category_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengeluaran Per-Kategori Bulan Ini</h6>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <form method="post" action="" id="submit-cetak">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center; width:20px">No</th>
                                    <th>Nama Kategori</th>

                                    <th>Nominal</th>


                                </tr>
                            </thead>
                            <tfoot>

                            </tfoot>
                            <tbody>
                                <?php $no = 1;
                                foreach ($category as $r => $data) { ?>
                                    <tr>
                                        <td style="text-align: center"><?= $no++ ?>.</td>
                                        <td><?= $data->name ?></td>
                                        <?php $expenditurecategory = $this->expenditure_m->getCategoryThisMonth($data->category_id)->result() ?>
                                        <?php $nominal = 0;
                                        foreach ($expenditurecategory as $c => $dataa) {
                                            $nominal += $dataa->nominal;
                                        } ?>
                                        <td style="text-align: right;">
                                            <?= indo_currency($nominal); ?>
                                        </td>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('expenditure/addcategory') ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" id="name" name="name" min="0" autocomplete="off" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea type="text" name="remark" id="remark" class="form-control"> </textarea>
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


<!-- Modal Edit -->
<?php foreach ($category as $r => $data) { ?>
    <div class="modal fade" id="edit<?= $data->category_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('expenditure/editcategory') ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" id="name" name="name" value="<?= $data->name ?>" min="0" class="form-control" required>
                            <input type="hidden" id="category_id" name="category_id" value="<?= $data->category_id ?>" class="form-control" required>

                        </div>

                        <div class="form-group">
                            <label for="remark">Keterangan</label>
                            <textarea type="text" name="remark" id="remark" class="form-control"><?= $data->remark ?></textarea>
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
<?php } ?>
<!-- Modal Edit -->
<?php foreach ($category as $r => $data) { ?>
    <div class="modal fade" id="delete<?= $data->category_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('expenditure/deletecategory') ?>" method="POST">
                        <input type="hidden" name="category_id" value="<?= $data->category_id ?>">
                        Apakah yakin akan hapus data kategori <?= $data->name ?> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>