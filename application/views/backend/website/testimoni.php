<div class="d-sm-flex align-items-center justify-content-between mb-4">


</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data testimoni</h6>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Testimoni</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($testimoni as $r => $data) { ?>
                        <tr>
                            <td width="35px"><?= $no++ ?>.</td>
                            <td><?= $data->name ?></td>
                            <td><?= $data->description ?></td>
                            <td><?= date('d M Y', $data->createdTestimoni) ?></td>
                            <td><?= $data->status ?></td>
                            <td class="text-center" width="160px">
                                <form>
                                    <a class="btn btn-xs btn-primary" href="#ModalEdit<?= $data->testimoni_id ?>" data-toggle="modal" title="Edit"><i class="fa fa-close"></i> Edit</a>
                                    <a class="btn btn-xs btn-danger" href="#ModalHapus<?= $data->testimoni_id ?>" data-toggle="modal" title="Hapus"><i class="fa fa-close"></i> Hapus</a>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php foreach ($testimoni as $data) { ?>
        <div class="modal fade" id="ModalEdit<?= $data->testimoni_id ?>" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="formModalLabel">Edit Testimoni</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('master/editTestimoni') ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="testimoni_id" value="<?= $data->testimoni_id ?>" class="form-control">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="<?= $data->status ?>"><?= $data->status ?></option>
                                    <option value="Publish">Publish</option>
                                    <option value="No Publish">No Publish</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary"> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
</div>
<?php } ?>
<!-- MODAL Hapus -->
<?php foreach ($testimoni as $data) { ?>
    <div class="modal fade" id="ModalHapus<?= $data->testimoni_id ?>" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="formModalLabel">Hapus Testimoni</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('master/del_testimoni') ?>" enctype="multipart/form-data">
                        <input type="hidden" name="testimoni_id" value="<?= $data->testimoni_id ?>" class="form-control">
                        Apakah anda yakin akan hapus testimoni dari <?= $data->name ?> ?

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary"> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!--END MODAL Hapus-->