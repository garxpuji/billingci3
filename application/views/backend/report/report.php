  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">

      <?php
        $subtotal = 0;
        foreach ($report as $c => $data) {
            $subtotal += $data->income;
        }
        $subtotal2 = 0;
        foreach ($report as $c => $data) {
            $subtotal2 += $data->expenditure;
        }
        $subtotal3 = 0;
        foreach ($report as $c => $data) {
            $subtotal3 += $data->income - $data->expenditure;
        }
        ?>

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
                          <form action="<?= base_url('report/printreport'); ?>" target="blank" method="post">
                              <div class="box">
                                  <div class="box-body">
                                      <form>
                                          <div class="form-group row">
                                              <div class="col-md-0">
                                                  <label class="col-sm-12 col-form-label">Tanggal</label>
                                              </div>
                                              <div class="col-sm-3">
                                                  <input type="text" id="tanggal" name="tanggal" class="form-control" autocomplete="off">
                                              </div>
                                              <div class="col-md-0">
                                                  <label class="col-sm-12 col-form-label">s/d</label>
                                              </div>
                                              <div class="col-sm-3">
                                                  <input type="text" id="tanggal2" name="tanggal2" autocomplete="off" class="form-control">
                                              </div>
                                              <div class="col-sm-3">
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
          <h6 class="m-0 font-weight-bold">Laporan Keuangan</h6>

      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered table-striped w-auto small" id="tablebt" width="100%" cellspacing="0">
                  <thead>
                      <tr style="text-align: center">
                          <th style="text-align: center; width:15px">No</th>
                          <th style="width:100px">Tanggal</th>
                          <th>Keterangan</th>
                          <th style="width:100px">Debit</th>
                          <th style="width:100px">Kredit</th>
                          <th style="width:100px">Saldo</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr style="text-align: center">
                          <th style="text-align: right; font-weight:bold" colspan="3"><b>Total</b></th>
                          <th style="text-align: right"><?= indo_currency($subtotal) ?> </th>
                          <th style="text-align: right"><?= indo_currency($subtotal2) ?></th>
                          <th style="text-align: right"><?= indo_currency($subtotal3) ?></th>
                      </tr>

                  </tfoot>
                  <tbody>

                      <?php $no = 1;
                        $date = '';
                        $saldo = 0;
                        $debit = $this->report_m->debit($date);
                        $kredit = $this->report_m->kredit($date);
                        $saldo = $debit - $kredit;
                        foreach ($report as $r => $data) {
                            $saldo = $saldo + $data->income - $data->expenditure;
                        ?>
                          <tr>
                              <td style="text-align: center"><?= $no++ ?>.</td>
                              <td><?= indo_date($data->date)  ?> </td>
                              <td><?= $data->remark ?></td>
                              <td style="text-align: right"><?= indo_currency($data->income)  ?></td>
                              <td style="text-align: right"><?= indo_currency($data->expenditure)  ?></td>
                              <td style="text-align: right"><?= indo_currency($saldo)  ?></td>
                              </td>
                          </tr>
                      <?php } ?>
                  </tbody>
              </table>


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
  </script>