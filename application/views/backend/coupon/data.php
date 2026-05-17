  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>

  </div>
  <?php $this->view('messages') ?>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">Data Kupon</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                      <tr style="text-align: center">
                          <th style="text-align: center; width:20px">No</th>
                          <th>Kode Kupon</th>
                          <th>Persen</th>
                          <th>Status</th>
                          <th>Sekali Pakai</th>
                          <th>Max Limit</th>
                          <th>Keterangan</th>
                          <th style="text-align: center; width:100px">Aksi</th>
                      </tr>
                  </thead>

                  <tbody>
                      <?php $no = 1;
                        foreach ($coupon as $r => $data) { ?>
                          <tr>
                              <td style="text-align: center"><?= $no++ ?>.</td>
                              <td><?= $data->code ?></td>
                              <td style="text-align: center"><?= $data->percent ?> <?= $data->percent > 0 ? '%' : '' ?></td>
                              <td style="text-align: center"><?= $data->is_active == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                              <td style="text-align: center"><?= $data->one_time == 1 ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i>' ?></td>
                              <td><?= $data->max_active == 1 ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i>' ?> <?php if ($data->max_limit > 0) { ?>
                                      <?= indo_currency($data->max_limit) ?> <?php } ?></td>
                              </td>
                              <td><?= $data->remark; ?></td>
                              <td style="text-align: center"><a href="#" data-toggle="modal" data-target="#edit<?= $data->coupon_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a> <a href="" data-toggle="modal" data-target="#delete<?= $data->coupon_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a></td>
                          </tr>
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
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Kode Kupon</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="<?= site_url('coupon/add') ?>" method="POST">
                      <div class="form-group">
                          <label for="name">Kode Kupon</label>
                          <input type="text" id="code" name="code" autocomplete="off" class="form-control" oninput="this.value = this.value.toUpperCase()" onKeyDown="if(event.keyCode === 32) return false;" required>
                      </div>
                      <div class="form-group">
                          <label for="no_rek">Persen</label>
                          <input type="number" name="percent" autocomplete="off" min="0" max="95" id="percent" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <input type="checkbox" name="maxlimit" id="maxlimit"> <label for="">Batasi Kupon</label>
                      </div>

                      <div class="form-group">
                          <div id="limit" style="display: none">
                              <label for="">Maksimal</label>
                              <input type="number" name="max_limit" id="max_limit" autocomplete="off" class="form-control mb-1">
                              <div class="row">
                                  <div class="col"> Contoh Tanpa Dibatasi : <br>
                                      Tagihan = 1.000.000 <br>
                                      Persen Kupon = 10 % <br>
                                      Total Tagihan = 900.000
                                  </div>
                                  <div class="col">
                                      Contoh Dibatasi : <br>
                                      Tagihan = 1.000.000 <br>
                                      Persen Kupon = 10 % <br>
                                      Maksimal = 20.000 <br>
                                      Total Tagihan = 980.000
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="owner">Sekali Pakai</label>
                          <select name="one_time" id="on_time" class="form-control" required>
                              <option value="">-Pilih-</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="owner">Status</label>
                          <select name="is_active" id="" class="form-control" required>
                              <option value="">-Pilih-</option>
                              <option value="1">Aktif</option>
                              <option value="0">Tidak Aktif</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="owner">Keterangan</label>
                          <textarea name="remark" id="remark" cols="30" rows="" class="form-control"></textarea>
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
  <?php foreach ($coupon as $r => $data) { ?>
      <div class="modal fade" id="edit<?= $data->coupon_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Kode Kupon</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="<?= site_url('coupon/edit') ?>" method="POST">
                          <div class="form-group">
                              <label for="name">Nama coupon</label>
                              <input type="text" name="code" id="name" value="<?= $data->code ?>" class="form-control" required autocomplete="off" oninput="this.value = this.value.toUpperCase()" onKeyDown="if(event.keyCode === 32) return false;" required>
                              <input type="hidden" id="coupon_id" name="coupon_id" value="<?= $data->coupon_id ?>" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label for="no_rek">Persen</label>
                              <input type="number" name="percent" autocomplete="off" id="percent" min="0" max="95" value="<?= $data->percent; ?>" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <input type="checkbox" name="maxlimit" id="maxlimitedit"> <label for="">Batasi Kupon</label>
                          </div>

                          <div class="form-group">
                              <div id="limitedit" style="display: none">
                                  <label for="">Maksimal</label> <span style="color: red;">Isi 0 jika tidak aktif</span>
                                  <input type="number" name="max_limit" id="max_limitedit" value="<?= $data->max_limit ?>" autocomplete="off" class="form-control mb-1">
                                  <div class="row">
                                      <div class="col"> Contoh Tanpa Dibatasi : <br>
                                          Tagihan = 1.000.000 <br>
                                          Persen Kupon = 10 % <br>
                                          Total Tagihan = 900.000
                                      </div>
                                      <div class="col">
                                          Contoh Dibatasi : <br>
                                          Tagihan = 1.000.000 <br>
                                          Persen Kupon = 10 % <br>
                                          Maksimal = 20.000 <br>
                                          Total Tagihan = 980.000
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="owner">Sekali Pakai</label>
                              <select name="one_time" id="on_time" class="form-control" required>
                                  <option value="<?= $data->one_time ?>"><?= $data->one_time == 1 ? 'Yes' : 'No'; ?></option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="owner">Status</label>
                              <select name="is_active" id="" class="form-control" required>
                                  <option value="<?= $data->is_active ?>"><?= $data->is_active == 1 ? 'Yes' : 'No'; ?></option>
                                  <option value="1">Aktif</option>
                                  <option value="0">Tidak Aktif</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="owner">Keterangan</label>
                              <textarea name="remark" id="remark" cols="30" rows="" class="form-control"><?= $data->remark; ?></textarea>
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
  <?php } ?>
  <!-- Modal Edit -->
  <?php foreach ($coupon as $r => $data) { ?>
      <div class="modal fade" id="delete<?= $data->coupon_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Hapus Kode Kupon</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="<?= site_url('coupon/del') ?>" method="POST">
                          <input type="hidden" name="coupon_id" value="<?= $data->coupon_id ?>">
                          <input type="hidden" name="code" value="<?= $data->code ?>">
                          Apakah anda yakin akan hapus kode kupon <?= $data->code ?> ?
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
      //Date picker
      $('#datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
      })

      $(function() {
          $("#maxlimit").click(function() {
              if ($(this).is(":checked")) {
                  $("#limit").show();
                  $("#max_limit").focus();
              } else {
                  $("#limit").hide();
              }
          });
      });
      $(function() {
          $("#maxlimitedit").click(function() {
              if ($(this).is(":checked")) {
                  $("#limitedit").show();
                  $("#max_limitedit").focus();
              } else {
                  $("#limitedit").hide();
              }
          });
      });
  </script>