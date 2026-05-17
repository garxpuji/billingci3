<!-- Page Heading -->

<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php $coverage = $this->db->get_where('coverage', ['coverage_id' => $cov])->row_array() ?>
        <h6 class="m-0 font-weight-bold">Data Pelanggan Area <?= $coverage['c_name']; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>No Layanan</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>No Telp.</th>
                        <?php if ($this->session->userdata('role_id') == 1) { ?>
                            <th style="width: 100px">Tagihan / Bulan</th>
                        <?php } ?>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($customer as $r => $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $data->no_services ?> <br>
                                <a href="<?= site_url('services/detail/') ?><?= $data->no_services ?>" class="btn btn-success" style="font-size: smaller">Rincian Paket</a>
                            </td>
                            <td><a href="#" data-toggle="modal" data-target="#detail<?= $data->no_services ?>" title="Detail">
                                    <div class="badge badge-primary"><?= $data->name ?></div>
                                </a></td>
                            <td><?= $data->email ?></td>
                            <td><?= $data->c_status ?></td>
                            <td><?= $data->no_wa ?></td>
                            <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
                            <?php if ($this->session->userdata('role_id') == 1) { ?>
                                <td style="text-align:right; font-weight:bold ">
                                    <?php $query = "SELECT *
                                    FROM `services`
                                        WHERE `services`.`no_services` = $data->no_services";
                                    $querying = $this->db->query($query)->result(); ?>
                                    <?php $subtotal = 0;
                                    foreach ($querying as  $dataa)
                                        $subtotal += (int) $dataa->total;
                                    ?>
                                    <?= indo_currency($subtotal) ?>

                                </td>
                            <?php } ?>
                            <td style="text-align: center">
                                <?php if ($this->session->userdata('role_id') == 1 or $role['edit_customer'] == 1) { ?>
                                    <a href="<?= site_url('customer/edit/') ?><?= $data->customer_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a>
                                <?php } ?>
                                <?php if ($this->session->userdata('role_id') == 1 or $role['del_customer'] == 1) { ?>
                                    <a href="" id="delete" data-toggle="modal" data-target="#DeleteModal" title="Hapus" data-customer_id="<?= $data->customer_id ?>" data-no_services="<?= $data->no_services ?>" data-name="<?= $data->name ?>"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($customer as $r => $data) { ?>
    <div class="modal fade" id="detail<?= $data->no_services ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" value="<?= $data->name ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Email:</label>
                        <input type="text" class="form-control" value="<?= $data->email ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">No Telp:</label>
                        <input type="text" class="form-control" value="<?= $data->no_wa ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">No KTP:</label>
                        <input type="text" class="form-control" value="<?= $data->no_ktp ?>" readonly>
                        <img src="<?= base_url('assets/images/ktp/' . $data->ktp) ?>" alt="" style="width:400px;">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Alamat:</label>
                        <textarea class="form-control" id="message-text" readonly><?= $data->address; ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                </div>

            </div>
        </div>
    </div>
<?php } ?>
<!-- Modal Edit -->
<!-- Modal Hapus -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('customer/delete') ?>
                <input type="hidden" name="customer_id" id="customer_id" class="form-control">
                <input type="hidden" name="no_services" id="no_servicess" class="form-control">

                Apakah and yakin hapus pelanggan <span id="no_services"></span> <span id="name"></span> ?
                <br>
                <br>
                <input type="checkbox" id="clickdelincome"> <label for="">Hapus Data Pemasukan</label>
                <input type="hidden" name="delincome" id="delincome">
                <br>
                <div id="formdelincome" style="display: none">
                    <span style="color: blue;">Penghapusan data pemasukan akan mempengaruhi Saldo Kas dan Data Pemasukan</span>
                    <br>
                </div>
                <span style="color: red;">
                    Penghapusan ini akan menghapus semua data riwayat tagihan pelanggan tsb</span>
                <br> <input type="checkbox" id="agree" required> <label for="">* Saya Setuju</label>
                <input type="hidden" name="iagree" id="iagree">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="click-me" class="btn btn-danger">Hapus</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#delete', function() {

        $('#customer_id').val($(this).data('customer_id'))
        $('#no_services').html($(this).data('no_services'))
        $('#no_servicess').val($(this).data('no_services'))
        $('#name').html($(this).data('name'))


    })
</script>