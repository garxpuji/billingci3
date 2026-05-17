  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
      <?php if ($this->session->userdata('role_id') == 1 or $role['add_income'] == 1) { ?>
          <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
      <?php } ?>
      <?php $subtotal = 0;
        foreach ($expenditure as $c => $data) {
            $subtotal += $data->nominal;
        } ?>
      <a href="<?= site_url('expenditure/category') ?>" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Kategori</a>

  </div>
  <?php $this->view('messages') ?>
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">Cetak Laporan</h6>
      </div>
      <div class="card-body">
          <div class="row">
              <div class="col-lg">
                  <div class="box box-primary">
                      <div class="box-body box-profile">
                          <form action="<?= base_url('expenditure/printexpenditure'); ?>" target="blank" method="post">
                              <div class="box">
                                  <div class="box-body">

                                      <div class="form-group row">
                                          <div class="col-md-0 mt-2">
                                              <label class="col-sm-12 col-form-label">Tanggal</label>
                                          </div>
                                          <div class="col-sm-3 mt-2 ">
                                              <input type="text" id="tanggal" name="tanggal" class="form-control" autocomplete="off">
                                          </div>
                                          <div class="col-md-0 mt-2">
                                              <label class="col-sm-12 col-form-label">s/d</label>
                                          </div>
                                          <div class="col-sm-3  mt-2">
                                              <input type="text" id="tanggal2" name="tanggal2" autocomplete="off" class="form-control">
                                          </div>
                                          <div class="col-sm-3 mt-2">
                                              <button type="reset" name="reset" class="btn btn-info">Reset</button>
                                              <button type="submit" name="filter" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                                          </div>
                                      </div>
                                  </div>
                          </form>
                      </div>

                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">Data Pengeluaran</h6>

      </div>
      <?php if ($this->session->userdata('role_id') == 1 or $role['del_income'] == 1) { ?>
          <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-2 m-2">

              <!-- <button href="" data-toggle="modal" data-target="#filter" class="btn btn-outline-primary"><i class="fa fa-cube"></i> Filter</button> -->
              <!-- <button href="" data-toggle="modal" data-target="#print" class="btn btn-outline-primary"><i class="fa fa-print"></i> Cetak</button> -->
              <button href="" class="btn btn-outline-danger" id="btn-del-selected"><i class="fa fa-trash"></i> Hapus Yang Dipilih</button>

          </div>

      <?php } ?>
      <div class="card-body">
          <div class="table-responsive">
              <form method="post" action="" id="submit-cetak">
                  <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                      <thead>
                          <tr style="text-align: center">
                              <th style="text-align: center; width:20px">No</th>
                              <th> <input type='checkbox' class='check-item' id="selectAll"></th>
                              <th style="text-align: center; width:120px">Tanggal</th>
                              <th style="text-align: center; width:100px">Nominal</th>
                              <th style="text-align: center; width:100px">Kategori</th>
                              <th>Keterangan</th>
                              <th style="text-align: center; width:50px">Aksi</th>
                          </tr>
                      </thead>

                      <tbody>

                      </tbody>
                  </table>
              </form>
          </div>
      </div>
  </div>

  <!-- Modal Add -->
  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Pengeluaran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="<?= site_url('expenditure/add') ?>" method="POST">
                      <div class="form-group">
                          <label for="nominal">Nominal</label>
                          <input type="number" id="nominal" name="nominal" min="0" autocomplete="off" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                          <input type="text" name="date_payment" autocomplete="off" id="datepicker" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Kategori *</label>
                          <select name="category" id="" class="form-control" required>
                              <option value="">-Pilih-</option>
                              <?php foreach ($category as $key => $data) { ?>
                                  <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="remark">Keterangan</label>
                          <textarea type="text" name="remark" id="remark" class="form-control"> </textarea>
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


  <!-- Modal Edit -->
  <div class="modal fade" id="Modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Pengeluaran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="<?= site_url('expenditure/edit') ?>" method="POST">
                      <div class="form-group">
                          <label for="nominal">Nominal</label>
                          <input type="number" id="editnominal" name="nominal" value="<?= $data->nominal ?>" min="0" class="form-control" autocomplete="off" required>
                          <input type="hidden" id="editexpenditure_id" name="expenditure_id" value="<?= $data->expenditure_id ?>" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label for="date">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                          <input type="text" name="date_payment" id="editdate_payment" onclick="$(this).datepicker({format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true,}).datepicker('show')" value="<?= $data->date_payment ?>" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Kategori *</label>
                          <select name="category" id="editcategory" class="form-control" required>
                              <?php foreach ($category as $key => $data) { ?>
                                  <option value="<?= $data->category_id ?>"><?= $data->name ?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="remark">Keterangan</label>
                          <textarea type="text" name="remark" id="editremark" class="form-control"><?= $data->remark ?></textarea>
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

  <!-- Modal Edit -->

  <div class="modal fade" id="Modaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Hapus Pengeluaran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="<?= site_url('expenditure/delete') ?>" method="POST">
                      <input type="hidden" name="expenditure_id" id="deleteexpenditure_id">

                      <?php $d = substr($data->date_payment, 8, 2);
                        $m = substr($data->date_payment, 5, 2);
                        $y = substr($data->date_payment, 0, 4); ?>
                      Apakah yakin akan hapus data pengeluaran pada tanggal <span id="deletedate_payment"> senilai <span id="deletenominal"> ?
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
              </form>
          </div>
      </div>
  </div>
  <!-- bootstrap datepicker -->
  <script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script>
      //Date picker
      $('#tanggal').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
      })
      $('#tanggal2').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
      })
      $('#datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
      })
      $('#btn-del-selected').click(function() {
          $('#submit-cetak').attr('action', '<?php echo base_url('expenditure/delselected') ?>');
          var confirm = window.confirm("Apakah Anda yakin ingin hapus pengeluaran yang terpilih ?");
          if (confirm) {
              $("#submit-cetak").submit();
              $("#popup").modal("show");
          } else {

          }
      });
  </script>
  <script>
      $(document).ready(function() {
          $("#selectAll").click(function() {
              if ($(this).is(":checked"))
                  $(".check-item").prop("checked", true);
              else // Jika checkbox all tidak diceklis
                  $(".check-item").prop("checked", false);
          });
          $('#example1').DataTable({
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
                  "url": "<?= base_url('expenditure/getDataExpend'); ?>",
                  "type": "POST"
              },
              "columnDefs": [{
                  "targets": 1,
                  "orderable": false
              }]
          });
      });
  </script>
  <script>
      $(document).on('click', '#edit', function() {

          $('#editexpenditure_id').val($(this).data('expenditure_id'))
          $('#editnominal').val($(this).data('nominal'))
          $('#editcategory').val($(this).data('category'))
          $('#editdate_payment').val($(this).data('date_payment'))
          $('#editremark').html($(this).data('remark'))

      })
      $(document).on('click', '#delete', function() {

          $('#deleteexpenditure_id').val($(this).data('expenditure_id'))
          $('#deletenominal').html($(this).data('nominal'))
          $('#deletedate_payment').html($(this).data('date_payment'))


      })
  </script>