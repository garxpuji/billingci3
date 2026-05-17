  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
      <?php if ($this->session->userdata('role_id') == 1 or $role['add_help'] == 1) { ?>
          <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
      <?php } ?>
  </div>
  <?php $this->view('messages') ?>
  <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
  <?php if ($this->session->userdata('role_id') == 1 or $role['show_help'] == 1) { ?>
      <?php if ($title == 'Data Help') { ?>
          <div class="row">
              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-danger shadow h-100 py-2">
                      <a href="<?= site_url('help/pending') ?>" style="text-decoration: none;">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tiket Pending</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->db->get_where('help', ['status' => 'pending'])->num_rows(); ?></div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-question fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-danger shadow h-100 py-2">
                      <a href="<?= site_url('help/proses') ?>" style="text-decoration: none;">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tiket Proces</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->help_m->getprocess()->num_rows(); ?></div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-question fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-success shadow h-100 py-2">
                      <a href="<?= site_url('help/done') ?>" style="text-decoration: none;">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tiket Done</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->help_m->getdone()->num_rows(); ?></div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-question fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
          </div>
      <?php } ?>
  <?php } ?>
  <!-- DataTales Example -->

  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">Data Tiket Gangguan</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                  <thead>
                      <tr style="text-align: center">
                          <th style="text-align: center; width:20px">No</th>
                          <th style="text-align: center; width:100px">Aksi</th>
                          <th style="text-align: center;">Tanggal </th>
                          <th>No Tiket</th>
                          <th>Nama Pelanggan</th>
                          <th>No Layanan</th>
                          <th>Laporan</th>
                          <th>Status</th>
                      </tr>
                  </thead>

                  <tbody>
                      <?php if ($title != 'Data Help') { ?>
                          <?php $no = 1;
                            foreach ($help as $r => $data) { ?>
                              <tr>
                                  <td style="text-align: center"><?= $no++ ?>.</td>
                                  <td style="text-align: center">
                                      <?php if ($this->session->userdata('role_id') == 1 or $role['del_help'] == 1) { ?>
                                          <a href="" data-toggle="modal" id="deletehelp" data-idhelp=<?= $data->id ?> data-tiket="<?= $data->no_ticket ?>" data-target="#delete" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                                      <?php } ?>
                                  </td>
                                  <td style="text-align: center"> <?= date('d', $data->date_created); ?> <?= indo_month(date('m', $data->date_created)); ?> <?= date('Y', $data->date_created); ?> <br><?= date('H:i:s', $data->date_created); ?> </td>
                                  <td style="text-align: center">T-<?= $data->no_ticket ?> <br>
                                      <a href="<?= site_url('help/detail/' . $data->id) ?>" class="btn btn-outline-primary">Detail</a>
                                  </td>
                                  <?php $customer = $this->db->get_where('customer', ['no_services' => $data->no_services])->row_array() ?>
                                  <td style="text-align: center"><?= $customer['name'] ?></td>
                                  <td style="text-align: center"><?= $data->no_services ?></td>
                                  <?php $type = $this->db->get_where('help_type', ['help_id' => $data->help_type])->row_array() ?>
                                  <?php $solution = $this->db->get_where('help_solution', ['hs_id' => $data->help_solution])->row_array() ?>
                                  <td><?= $type['help_type'] ?> <br> <?= $solution['hs_name'] ?> </td>
                                  <td style="text-align: center"> <?= ucwords(strtolower($data->status)); ?></td>

                              </tr>
                          <?php } ?>
                      <?php } ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  <!-- Modal Add -->
  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Tiket Gangguan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <?php echo form_open_multipart('help/addhelp') ?>
                  <div class="form-group">
                      <label for="name">No Layanan - Nama Pelanggan</label>
                      <select class="form-control select2" name="no_services" id="no_services" style="width: 100%;" required onChange="selectcs(this);">
                          <option value="">-Pilih-</option>
                          <?php
                            foreach ($customertiket as $r => $cs) { ?>
                              <option value="<?= $cs->no_services ?>"><?= $cs->no_services ?> - <?= $cs->name ?> - <?= $cs->c_status; ?></option>
                          <?php } ?>
                      </select>
                  </div>
                  <div id="helptype" style="display: none">
                      <div class="form-group">
                          <label>Topik Gangguan *</label>
                          <select name="type" id="type" class="form-control" required onChange="selecttype(this);">
                              <option value="">- Pilih -</option>
                              <?php $typehelp = $this->db->get('help_type')->result() ?>
                              <?php foreach ($typehelp as $key => $data) { ?>
                                  <option value="<?= $data->help_id ?>"><?= $data->help_type ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>

                  <div id="helpsolution" style="display: none">
                      <div class="form-group">
                          <label for="solution">Masalah Umum</label>

                          <select name="solution" id="solution" class="form-control" onChange="selectsolution(this);">

                          </select>
                      </div>
                  </div>
                  <div id="remark" style="display: none">
                      <div class="form-group">
                          <label for="description">Keterangan</label>
                          <textarea id="remark" name="remark" class="form-control"> </textarea>
                      </div>
                  </div>
                  <div class="container">
                      <div class="loading"></div>
                  </div>
                  <div class="modal-footer" id="clicklapor" style="display: none">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" id="click-me" class="btn btn-primary">Simpan</button>
                  </div>
                  <?php echo form_close() ?>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Hapus Laporan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="<?= site_url('help/del') ?>" method="POST">
                      <input type="hidden" name="id" id="modalidhelp">
                      Apakah anda yakin akan hapus tiket T-<span id="modaltiket"></span> ?
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

      function selectcs(sel) {
          var type = $("#no_services").val();


          $('#helptype').show();
          //   $('#helptype').html('');

          $('#helpsolution').hide();
          $('#clicklapor').hide();
          $('#remark').hide();

      }

      function selecttype(sel) {
          var type = $("#type").val();
          $('#helpsolution').hide();

          $('#clicklapor').hide();
          $('#remark').hide();
          if (type != '') {
              var url = "<?= site_url('help/getsolution') ?>" + "/" + Math.random();
              $.ajax({
                  type: 'POST',
                  url: url,
                  data: "&type=" + type,
                  cache: false,
                  beforeSend: function() {
                      $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                  },
                  success: function(data) {
                      $('.loading').html('');
                      $('#solution').html(data);
                      $('#helpsolution').show();
                  }
              });
              return false;
          }
      }

      function selectsolution(sel) {
          var idsolution = $("#solution").val();


          $('#clicklapor').hide();

          if (idsolution != '') {
              var url = "<?= site_url('help/getsolutiondetail') ?>" + "/" + Math.random();
              $.ajax({
                  type: 'POST',
                  url: url,
                  data: "&solution=" + idsolution,
                  cache: false,
                  beforeSend: function() {
                      $('.loading').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                  },
                  success: function(data) {
                      $('.loading').html('');
                      $('#remark').show();
                      $('#clicklapor').show();
                  }
              });
              return false;
          }
      }
  </script>
  <script>
      $(document).on('click', '#deletehelp', function() {
          $('#modalidhelp').val($(this).data('idhelp'))
          $('#modaltiket').html($(this).data('tiket'))

      })
  </script>
  <?php if ($title == 'Data Help') { ?>
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
                      "url": "<?= base_url('help/serverhelp'); ?>",
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
                          searchable: true
                      },
                      {
                          data: 'action',
                          name: 'action',
                          orderable: false,
                          searchable: true
                      },



                      {
                          data: 'date_created',
                          name: 'date_created',
                          orderable: true,
                          searchable: true
                      },
                      {
                          data: 'no_ticket',
                          name: 'no_ticket',
                          orderable: true,
                          searchable: true
                      },
                      {
                          data: 'name',
                          name: 'name',
                          orderable: true,
                          searchable: true
                      },
                      {
                          data: 'no_services',
                          name: 'no_services',
                          orderable: true,
                          searchable: true
                      },
                      {
                          data: 'report',
                          name: 'report',
                          orderable: true,
                          searchable: true
                      },
                      {
                          data: 'status',
                          name: 'status',
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
  <?php } ?>