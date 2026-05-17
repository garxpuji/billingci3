<?php $this->view('messages') ?>
<?php echo form_open_multipart('maps/set') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Pengaturan <?= $title; ?></h6>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">


                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="form-control" required onChange="selectvendor(this);">
                                <?php if ($maps['vendor'] == '') { ?>
                                    <option value="">-Pilih-</option>
                                <?php } ?>
                                <?php if ($maps['vendor'] != '') { ?>
                                    <option value="<?= $maps['vendor'] ?>"><?= $maps['vendor'] ?></option>
                                <?php } ?>
                                <option value="Mapbox">Mapbox</option>


                            </select>
                        </div>



                        <div class=" form-group">
                            <label for="token">Token / Api Key</label>
                            <input type="text" name="token" id="token" class="form-control" autocomplete="off" value="<?= $maps['token'] ?>">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo form_close() ?>