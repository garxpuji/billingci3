<?php $wa = $this->db->get('whatsapp')->row_array() ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pelanggan Jatuh Tempo</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table mb-0 table-bordered" id="datatable">
                <thead>
                    <tr class="userDatatable-header">

                        <th>Nama Pelanggan</th>
                        <th>No Layanan</th>



                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="userDatatable-header">

                        <th>Nama Pelanggan</th>
                        <th>No Layanan</th>



                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- <script>
    $(function() {
        $('#datatable tfoot th').each(function() {
            var title = $(this).text();
            if (title) {
                $(this).html('<input type="text"  placeholder="' + title + '" />');
            }
        });
        $('#datatable').DataTable({
            // "processing": true,
            // "serverSide": true,
            // "paging": true,
            // "lengthChange": true,
            // "searching": true,
            // "info": true,
            // "autoWidth": true,
            // "responsive": true,
            "order": [],
            // "ajax": {
            //     "url": "<?= base_url('bill/getduedate'); ?>",
            //     // "type": "POST"
            // },
            "columDefs": [{
                "target": [-1],
                "orderable": false,
            }],
            processing: true,
            // serverSide: true,
            // order: [
            //     [0, "desc"]
            // ],
            ajax: "<?= base_url('bill/getduedate'); ?>",
            columns: [{
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
            ],
            initComplete: function() {
                var api = this.api();
                api.columns([0, 1]).every(function() {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function() {
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
</script> -->

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#datatable tfoot th').each(function() {
            var title = $('#datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        // DataTable
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            // order: [
            //     [0, "desc"]
            // ],
            ajax: "<?= base_url('bill/getduedate'); ?>",
            columns: [{
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
            ],
        });

        // Apply the search
        table.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change', function() {
                that
                    .search(this.value)
                    .draw();
            });
        });
    });
</script>