<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<?php if ($this->session->userdata('role_id') == 1 or $role['add_income'] == 1) { ?>
    <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    <a href="" data-toggle="modal" data-target="#listbagan" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cube fa-sm text-white-50"></i> List Bagan</a>
<?php } ?>
<br>
<link rel="stylesheet" href="<?= base_url() ?>diagram.css">

<div id="diagram_container"></div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>diagram.js"></script>

<script>
    let diagram = new dhx.Diagram("diagram_container", {
        type: "org",
        defaultShapeType: "img-card",
        scale: 0.9
    });

    diagram.data.load('<?= base_url('customer/getchart') ?>');
</script>

<!-- Modal Add -->
<div class="modal fade" id="add" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Bagan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('customer/addchart') ?>" method="POST">
                    <div class="form-group">
                        <label for="id_line">Dari No Layanan - Nama Pelanggan</label>
                        <select class="form-control select2" name="id_line" id="id_line" style="width: 100%;">
                            <option value="1">Server</option>
                            <?php
                            foreach ($customer as $r => $data) { ?>
                                <option value="<?= $data->customer_id ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_chart">Ke No Layanan - Nama Pelanggan</label>
                        <select class="form-control select2" name="id_chart" id="id_chart" style="width: 100%;">
                            <?php
                            foreach ($customer as $r => $data) { ?>
                                <option value="<?= $data->customer_id ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dir">Garis Berikutnya</label>
                        <select name="dir" id="dir" class="form-control">
                            <option value="Horizontal">Horizontal</option>

                            <option value="Vertical">Vertical</option>

                        </select>
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
<!-- Modal Add -->
<div class="modal fade" id="listbagan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Bagan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <form method="post" action="" id="submit-cetak">
                        <table class="table table-bordered" id="tablebt" width="100%" cellspacing="0">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center; width:20px">No</th>
                                    <th>Bagan</th>
                                    <th style="text-align: center; width:50px">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>

                            </tfoot>
                            <tbody>
                                <?php $line = $this->db->get('customer_line')->result() ?>
                                <?php $no = 1;
                                foreach ($line as $r => $data) { ?>
                                    <tr>
                                        <td style="text-align: center"><?= $no++ ?>.</td>
                                        <?php $customer = $this->db->get_where('customer', ['customer_id' => $data->id_line])->row_array() ?>
                                        <?php $customertujuan = $this->db->get_where('customer', ['customer_id' => $data->customer_id])->row_array() ?>
                                        <td>Dari <?= $data->id_line == 1 ? 'Server' : $customer['name']; ?> ke <?= $customertujuan['name']; ?> </td>
                                        <td>
                                            <a href="<?= site_url('customer/delchart/' . $data->id) ?>" onclick="return confirm('Anda yakin ?')" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>

                                    <?php } ?>
                                    </tr>

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>