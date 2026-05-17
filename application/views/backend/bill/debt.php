<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Tunggakan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th style="text-align: center">Aksi</th>
                        <th>No Layanan</th>
                        <th>Nama</th>
                        <th>Tagihan</th>


                    </tr>
                </thead>
                <tfoot>



                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px"></th>
                        <th style="text-align: center"></th>
                        <th></th>
                        <th>Nama</th>
                        <th></th>


                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#example tfoot th').each(function() {
            var title = $(this).text();
            if (title) {
                $(this).html('<input type="text"  placeholder="' + title + '" />');
            }
        });

        var table = $('#example').DataTable({
            initComplete: function() {
                // Apply the search
                this.api().columns().every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function() {
                        if (table.search() !== this.value) {
                            table.search(this.value).draw();
                        }
                    });
                });
            },
            "processing": true,
            "scrollX": true,
            // "pagingType": "numbers",
            "serverSide": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            // "info": true,
            "autoWidth": true,
            "responsive": true,
            "order": [
                [2, "desc"]
            ],
            "ajax": {
                "url": "<?= base_url('bill/getdebt'); ?>",
                "type": "POST"
            },
            "lengthMenu": [
                [10, 25, 50, 100, 250, 500, 1000, ],
                [10, 25, 50, 100, 250, 500, 1000, ]
            ],
            dom: 'lBfrtip',


            columns: [{
                    data: 'no',
                    name: 'no',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'no_services',
                    name: 'no_services',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'countbill',
                    name: 'countbill',
                    orderable: false,
                    searchable: false
                },



            ],




        });


    });
</script>