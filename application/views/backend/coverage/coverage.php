<!-- Page Heading -->
<?php $roleoperator = $this->db->get_where('role_management', ['role_id' => 3])->row_array() ?>
<?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
<?php if ($this->session->userdata('role_id') == 1 or $role['add_coverage'] == 1) { ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="<?= site_url('coverage/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    </div>
<?php } ?>
<?php $this->view('messages') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Coverage</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th style="text-align: center; width:100px">Aksi</th>
                        <td>Kode Area</td>


                        <th>Nama Area</th>
                        <th>Total Pelanggan</th>
                        <th>Alamat</th>
                        <th>Keterangan</th>


                        <th>Radius</th>
                        <th>Titik Koordinat</th>


                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>






<!-- Modal Edit -->
<?php foreach ($coverage as $r => $data) { ?>
    <div class="modal fade" id="delete<?= $data->coverage_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Coverage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('coverage/deletecoverage') ?>" method="POST">
                        <input type="hidden" name="coverage_id" value="<?= $data->coverage_id ?>">
                        Apakah anda yakin akan hapus data coverage <?= $data->c_name ?> ?
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
<!-- bootstrap datepicker -->
<script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    //Date picker
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    })
</script>



<script>
    $(document).ready(function() {

        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('coverage/servercoverage'); ?>",
                "type": "POST"
            },
            "lengthMenu": [
                [10, 25, 50, 100, 250, 500, 1000, ],
                [10, 25, 50, 100, 250, 500, 1000, ]
            ],
            dom: 'lBfrtip',

            // ajax: '<?= base_url('bill/getduedate'); ?>',
            columns: [{
                    data: 'no',
                    name: 'no',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'code_area',
                    name: 'code_area',
                    orderable: true,
                    searchable: true
                },


                <?php if ($package['coverage_package'] == 1) { ?> {
                        data: 'paket',
                        name: 'paket',
                        orderable: true,
                        searchable: true
                    },
                <?php }  ?> {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'customer',
                    name: 'customer',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'address',
                    name: 'address',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'comment',
                    name: 'comment',
                    orderable: true,
                    searchable: true
                },

                {
                    data: 'radius',
                    name: 'radius',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'maps',
                    name: 'maps',
                    orderable: true,
                    searchable: true
                },

            ],

            initComplete: function() {
                // Apply the search
                this.api().columns().every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function() {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                });
            }
        });

    });
</script>