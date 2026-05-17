<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<?php if ($this->session->userdata('role_id') == 1 or $role['show_user'] == 1) { ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"> <?= $title ?>
                <small>Pengguna</small>
            </h6>

        </div>
        <div class="card-body">

            <!-- Content Header (Page header) -->
            <section class="content">
                <div class="box">
                    <div class="box-header">

                        <div class="pull-right mb-2">
                            <?php if ($this->session->userdata('role_id') == 1 or $role['add_user'] == 1) { ?>
                                <a href="<?= site_url('user/register') ?>" class="btn btn-flat btn-primary">
                                    <i class="fa fa-plus"></i> Tambah Pengguna
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php $this->view('messages') ?>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center; width:20px">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Picture</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Level</th>
                                    <th style="text-align: center; width:50px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($row as $r => $data) { ?>
                                    <tr>
                                        <td width="35px"><?= $no++ ?>.</td>
                                        <td><?= $data->name ?></td>
                                        <td><?= $data->email ?></td>
                                        <td class="text-center"><img src="<?= base_url('assets/') ?>images/profile/<?= $data->image ?>" alt="" style="width:200px; "></td>
                                        <td><?= $data->phone ?></td>
                                        <td><?= $data->address ?></td>
                                        <td><?= $data->gender ?></td>
                                        <td><?= $data->is_active == 1 ? 'Active' : 'Non-Active' ?></td>
                                        <td>
                                            <?= $data->role_id == 1 ? 'Admin' : '' ?>
                                            <?= $data->role_id == 2 ? 'Pelanggan' : '' ?>
                                            <?= $data->role_id == 3 ? 'Operator' : '' ?>
                                            <?= $data->role_id == 4 ? 'Mitra' : '' ?>
                                            <?= $data->role_id == 5 ? 'Teknisi' : '' ?>
                                        </td>
                                        <td class="text-center" width="160px">
                                            <form>
                                                <div class="row">
                                                    <div class="col-6 text-center">
                                                        <?php if ($this->session->userdata('role_id') == 1 or $role['edit_user'] == 1) { ?>

                                                            <a class="btn btn-xs btn-primary" href="<?= site_url('user/edit_user/') ?><?= $data->id ?>" title="Edit"><i class="fa fa-edit"> </i></a>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <?php if ($this->session->userdata('role_id') == 1 or $role['del_user'] == 1) { ?>

                                                            <?php if ($data->id != $this->session->userdata('id')) { ?>
                                                                <a class="btn btn-xs btn-danger" href="#ModalHapus<?= $data->id ?>" data-toggle="modal" title="Hapus"><i class="fa fa-trash"></i></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- MODAL eDIT -->

            <!--END MODAL eDIT-->
            <!-- MODAL Hapus -->
            <?php foreach ($row as $data) { ?>
                <div class="modal fade" id="ModalHapus<?= $data->id ?>" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="formModalLabel">Delete User</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?= base_url('user/del') ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $data->id ?>" class="form-control">
                                    Apakah anda yakin akan hapus user <?= $data->name ?> ?

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
        </div>
    </div>
<?php } ?>