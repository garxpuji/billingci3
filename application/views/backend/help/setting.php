<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Jenis Bantuan</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
                <?php if ($this->session->userdata('role_id') == 1 or $role['add_help'] == 1) { ?>
                    <button type="button" class="btn btn-primary ml-2 mt-2 mb-1" data-toggle="modal" data-target="#exampleModal">
                        Tambah
                    </button>
                <?php } ?>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Jenis Bantuan</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($type as $r => $data) { ?>
                                <tr>
                                    <th><?= $no++; ?></th>
                                    <td><?= $data->help_type; ?></td>
                                    <td><?= $data->help_remark; ?></td>
                                    <td>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['edit_help'] == 1) { ?>
                                            <a href="" data-toggle="modal" data-target="#EditModal" id="edittype" data-typeid=<?= $data->help_id ?> data-typename=<?= $data->help_type ?> data-typeremark=<?= $data->help_remark ?>><i class="fa fa-edit"> </i></a>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['del_help'] == 1) { ?>
                                            <a href="<?= site_url('help/deltype/' . $data->help_id) ?>" onclick="return confirm('apakah anda yakin ?')"><i class="fa fa-trash" style="color: red;"> </i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-lg-6">

                <div class="card-body">


                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Solusi</h6>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <?php if ($this->session->userdata('role_id') == 1 or $role['add_help'] == 1) { ?>
                    <a href="<?= site_url('help/addsolution') ?>" class="btn btn-primary ml-2 mt-2 mb-1">
                        Tambah
                    </a>
                <?php } ?>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Bantuan</th>
                                <th scope="col">Jenis Bantuan</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($solution as $r => $data) { ?>
                                <tr>
                                    <th><?= $no++; ?></th>
                                    <?php $ht = $this->db->get_where('help_type', ['help_id' => $data->hs_help_id])->row_array() ?>
                                    <td><?= $data->hs_name; ?></td>
                                    <td><?= $ht['help_type']; ?></td>
                                    <td><a href="<?= site_url('help/showsolution/' . $data->hs_id) ?>" class="badge badge-primary">Show Solution</a></td>

                                    <td>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['edit_help'] == 1) { ?>
                                            <a href="<?= site_url('help/editsolution/' . $data->hs_id) ?>"><i class="fa fa-edit"> </i></a>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('role_id') == 1 or $role['del_help'] == 1) { ?>
                                            <a href="<?= site_url('help/delsolution/' . $data->hs_id) ?>" onclick="return confirm('apakah anda yakin ?')"><i class="fa fa-trash" style="color: red;"> </i></a>
                                        <?php } ?>
                                    </td>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('help/addtype') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">

                        <label for="name">Jenis Bantuan</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">

                        <label for="remark">Keterangan</label>
                        <textarea name="remark" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('help/edittype') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="typeid" name="type_id">
                        <label for="name">Jenis Bantuan</label>
                        <input type="text" id="typename" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">

                        <label for="remark">Keterangan</label>
                        <textarea id="remark" name="remark" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#edittype', function() {

        $('#typeid').val($(this).data('typeid'))
        $('#typename').val($(this).data('typename'))
        $('#remark').val($(this).data('typeremark'))


    })
    $(document).on('click', '#delete', function() {

        $('#deleteincome_id').val($(this).data('income_id'))
        $('#deletenominal').html($(this).data('nominal'))
        $('#deletedate_payment').html($(this).data('date_payment'))


    })
</script>