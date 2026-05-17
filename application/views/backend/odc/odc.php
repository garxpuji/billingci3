<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>



<section class="section">

    <?php $this->view('messages') ?>

</section>



<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <a href="<?= site_url('odc/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Odc</a>



</div>

<!-- DataTales Example -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold">Data odc</h6>



    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">

                <thead>

                    <tr>

                        <th>No</th>

                        <th style="text-align: center;">Aksi</th>

                        <th>Kode ODC</th>

                        <th>Total Pelanggan</th>

                        <th>Total ODP</th>

                        <th>Wilayah</th>

                        <th>Titik Koordinat</th>

                        <th>No Tiang</th>

                        <th>Jumlah Port</th>

                        <th>Port OLT</th>

                        <th>Warna Tube FO</th>

                        <th>Keterangan</th>

                        <th>Document</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $no = 1;

                    foreach ($odc as $r => $data) { ?>

                        <tr>

                            <td width="35px"><?= $no++ ?>.</td>

                            <td class="text-center" width="160px">

                                <form>

                                    <a class="btn btn-xs btn-primary" href="<?= site_url('odc/edit/' . $data->id_odc) ?>" title="Edit"><i class="fa fa-edit"> </i></a>

                                    <a class="btn btn-xs btn-danger" href="#ModalHapus<?= $data->id_odc ?>" data-toggle="modal" title="Hapus"><i class="fa fa-trash"></i></a>

                                    <!-- <a href="" data-toggle="modal" data-target="#preview<?= $data->id_odc ?>" title="Preview"><i class="fa fa-eye" style="font-size:25px; color:green"></i></a> -->

                                    <!-- <a href="<?= site_url('odc/doc/' . $data->id_odc) ?>" title="Document"><i class="fa fa-image" style="font-size:25px; color:grey"></i></a> -->

                                </form>

                            </td>

                            <td><?= $data->code_odc ?></td>

                            <td>

                                <?= $this->db->get_where('customer', ['id_odc' => $data->id_odc])->num_rows(); ?>

                            </td>

                            <td>

                                <?= $this->db->get_where('m_odp', ['code_odc' => $data->id_odc])->num_rows(); ?>

                            </td>

                            <td>

                                <?php $datacoverage = $this->db->get_where('coverage', ['coverage_id' => $data->coverage_odc])->row_array(); ?>

                                <?= $datacoverage['c_name'] ?>



                            </td>

                            <td>

                                Latitude : <?= $data->latitude ?><br>

                                Longitude : <?= $data->longitude ?><br>

                                <a target="blank" href="http://www.google.com/maps/place/<?= $data->latitude ?> , <?= $data->longitude ?>">

                                    <div class="badge badge-primary">Rute Maps</div>

                                </a>

                            </td>

                            <td><?= $data->no_pole ?></td>

                            <td><?= indo_currency($data->total_port) ?></td>

                            <td><?= $data->no_port_olt ?></td>

                            <td><?= $data->color_tube_fo ?></td>

                            <td><?= $data->remark ?></td>



                            <td>

                                <a href="#imagemodal" data-toggle="modal" data-target="#myModal1">

                                    <img class="getSrc" src="<?= base_url('assets/images/document/' . $data->document) ?>" alt="" width="250px">

                                </a>

                            </td>



                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>



    <script type="text/javascript">
        $('.getSrc').click(function() {

            var src = $(this).attr('src');



            $('.showPic').attr('src', src);

        });
    </script>

    <?php foreach ($odc as $r => $data) { ?>

        <div class="modal fade" id="preview<?= $data->id_odc ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Preview <?= $data->code_odc; ?></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>



                    <div class="card-body">

                        <div class="form-group">

                            <label for="name">Kode ODC</label>

                            <input type="text" name="code_odc" id="code_odc" class="form-control" autocapitalize="off" value="<?= $data->code_odc ?>" readonly>

                            <?= form_error('code_odc', '<small class="text-danger pl-3 ">', '</small>') ?>

                        </div>

                        <div class="form-group">

                            <label for="">Wilayah ODC</label>

                            <?php $datacoverage = $this->db->get_where('coverage', ['coverage_id' => $data->coverage_odc])->row_array(); ?>

                            <input type="text" name="code_odc" id="code_odc" class="form-control" autocapitalize="off" value=" <?= $datacoverage['c_name'] ?>" readonly>

                        </div>

                        <div class="form-group">

                            <label for="">Nomor Port OLT</label>

                            <input type="number" class="form-control" name="no_port_olt" autocomplete="off" value="<?= $data->no_port_olt ?>" readonly>

                        </div>

                        <div class="form-group">

                            <label for="">Warna Tube FO</label>

                            <input type="text" class="form-control" name="color_tube_fo" autocomplete="off" value="<?= $data->color_tube_fo ?>" readonly>

                        </div>

                        <div class="form-group">

                            <label for="">Nomor Tiang</label>

                            <input type="text" class="form-control" name="no_pole" value="<?= $data->no_pole ?>" autocomplete="off" readonly>

                        </div>

                        <div class="form-group">

                            <label for="">Jumlah Port</label>

                            <input type="number" class="form-control" name="total_port" value="<?= $data->total_port ?>" autocomplete="off" readonly>

                        </div>



                        <div class="form-group">

                            <label for="remark">Keterangan</label>

                            <input type="text" name="remark" id="remark" class="form-control" autocapitalize="off" autocomplete="off" value="<?= $data->remark ?>" readonly>

                        </div>





                        <div class="form-group">

                            <label for="lat">Latitude</label>

                            <input type="text" id="lat" name="lat" class="form-control" value="<?= $data->latitude ?>" readonly>

                        </div>

                        <div class="form-group">

                            <label for="long">Longitude</label>

                            <input type="text" id="long" name="long" class="form-control" value="<?= $data->longitude ?>" readonly>

                        </div>

                        <img class="getSrc" src="<?= base_url('assets/images/document/' . $data->document) ?>" alt="" width="100%">

                        <div class="modal-footer">

                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                            <a href="<?= site_url('odc/edit/' . $data->id_odc) ?>" class="btn btn-primary">Edit</a>

                        </div>

                        <?php echo form_close() ?>

                    </div>







                </div>

            </div>

        </div>

    <?php } ?>

    <!-- MODAL -->



    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" style="display: none;" id="myModal1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="col-md-12">



                    <img src="" width="100%" class="showPic">

                </div>

            </div>

        </div>

    </div>

    <!-- MODAL Hapus -->

    <?php foreach ($odc as $data) { ?>

        <div class="modal fade" id="ModalHapus<?= $data->id_odc ?>" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h3 class="modal-title" id="formModalLabel">Hapus odc</h3>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form method="post" action="<?= base_url('odc/delete') ?>" enctype="multipart/form-data">

                            <input type="hidden" name="id_odc" value="<?= $data->id_odc ?>" class="form-control">

                            Apakah anda yakin akan hapus odc <?= $data->code_odc ?> ?



                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button class="btn btn-danger"> Ya, lanjutkan</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    <?php } ?>

    <!--END MODAL Hapus-->

    <script>
        $(function() {

            //Initialize Select2 Elements

            $('.select2').select2()

        });
    </script>