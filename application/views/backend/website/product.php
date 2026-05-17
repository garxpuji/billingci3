<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<?php if ($this->session->userdata('role_id') == 1 or $role['show_product'] == 1) { ?>
    <?php if ($this->session->userdata('role_id') == 1 or $role['add_product'] == 1) { ?>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="<?= site_url('product/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk</a>
        </div>
    <?php } ?>
    <?php $this->view('messages') ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Data Product</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Picture</th>
                            <th>Deskripsi Singkat</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($product as $r => $data) { ?>
                            <tr>
                                <td width="35px"><?= $no++ ?>.</td>
                                <td><?= $data->name ?></td>
                                <td class="text-center"><img src="<?= base_url() ?>assets/images/product/<?= $data->picture ?>" alt="" style="width:350px; "></td>
                                <td> <?= $data->remark ?>
                                <td class="text-center" width="160px">
                                    <form>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['edit_product'] == 1) { ?>
                                            <a class="btn btn-xs btn-primary" href="<?= site_url('product/edit/') ?><?= $data->id ?>"><i class="fa fa-edit"> </i> Edit </a>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['del_product'] == 1) { ?>
                                            <a class="btn btn-xs btn-danger" href="#ModalHapus<?= $data->id ?>" data-toggle="modal" title="Hapus"><i class="fa fa-close"></i> Hapus</a>
                                        <?php } ?>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL Hapus -->
        <?php foreach ($product as $data) { ?>
            <div class="modal fade" id="ModalHapus<?= $data->id ?>" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="formModalLabel">Hapus Produk</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= base_url('product/del') ?>" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $data->id ?>" class="form-control">
                                Apakah anda yakin akan hapus Product <?= $data->name ?> ?
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
    <?php } ?>
    <!--END MODAL Hapus-->