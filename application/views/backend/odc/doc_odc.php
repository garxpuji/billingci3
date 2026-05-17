<!-- Page
 Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>


    <a href="#" data-toggle="modal" data-target="#addModal" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>

</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Document <?= $odc->code_odc ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center; width:20px">No</th>
                        <th style="text-align: center">Aksi</th>

                        <th>Document</th>

                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $doc = $this->db->get_where('odc_doc', ['odc_id' => $odc->id_odc])->result() ?>
                    <?php $no = 1;
                    foreach ($doc as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td style="text-align: center">
                                <a href="" id="edit" data-toggle="modal" data-target="#EditModal" data-id="<?= $data->id ?>" data-remark="<?= $data->remark ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                <a href="" id="delete" data-toggle="modal" data-target="#DeleteModal" data-id="<?= $data->id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                            </td>


                            <td>
                                <a href="#imagemodal" data-toggle="modal" data-target="#myModal1">
                                    <img class="getSrc" src="<?= base_url('assets/images/document/' . $data->document) ?>" alt="" width="250px">
                                </a>
                            </td>
                            <td><?= $data->remark ?></td>


                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.getSrc').click(function() {
        var src = $(this).attr('src');

        $('.showPic').attr('src', src);
    });
</script>

<!-- MODAL -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myModal1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="col-md-12">

                <img src="" style="width: 100%;" class="showPic">
            </div>
        </div>
    </div>
</div>
<!-- modal image -->
<div class="modal fade " id="imagemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <img class="modal-content" src="" width="100px" height="100px" />
        </div>
    </div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('odc/adddoc') ?>
                <div class="form-group">
                    <label for="name">Code ODC</label>
                    <input type="hidden" name="odc_id" value="<?= $odc->id_odc ?>" class="form-control" required>
                    <input type="text" id="name" name="name" value="<?= $odc->code_odc ?>" class="form-control" required readonly>
                </div>
                <div class="form-group">
                    <label for="document">Dokumen </label>

                    <input type="file" name="picture" class="form-control">
                </div>
                <div class="form-group">
                    <label for="remark">Keterangan</label>
                    <textarea name="remark" class="form-control"> </textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->


<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Document <?= $odc->code_odc; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <?php echo form_open_multipart('odc/editdoc') ?>
                    <div class="form-group">
                        <label for="name">Nama odc</label>
                        <input type="hidden" name="odc_id" value="<?= $odc->id_odc ?>" class="form-control" required>
                        <input type="hidden" id="id" name="id" class="form-control" required>
                        <input type="text" id="name" name="name" value="<?= $odc->code_odc ?>" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="doc">Dokumen </label> <span>Kosongkan jika tidak diganti</span>

                        <input type="file" id="picture" name="picture" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea id="remark" name="remark" class="form-control"> </textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->


<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Document <?= $odc->name; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('odc/deletedoc') ?>
                <input type="hidden" id="id-delete" name="id" value="<?= $data->id_odc ?>" class="form-control">
                <input type="hidden" name="odc_id" value="<?= $odc->id_odc ?>" class="form-control">
                Apakah yakin akan hapus document odc <?= $odc->code_odc; ?></span> ?
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#edit', function() {
        $('#remark').val($(this).data('remark'))
        $('#id').val($(this).data('id'))
    })
    $(document).on('click', '#delete', function() {
        $('#id-delete').val($(this).data('id'))
        $('#vendorname').html($(this).data('name'))

    })
    $(function() {
        $("#image img").on("click", function() {
            var src = $(this).attr("src");
            $(".modal-img").prop("src", src);
        })
    })
</script>