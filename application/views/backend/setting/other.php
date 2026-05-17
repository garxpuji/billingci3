<style>
    .switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;

    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: gray;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: blue;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Pengaturan Lainnya</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('setting/editOther') ?>
                    <?php $whatsapp = $this->db->get('whatsapp')->row_array() ?>
                    <?php if ($whatsapp['is_active'] == 0) { ?>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $other['id'] ?>">
                            <label for="body_wa">Kirim Notif</label>
                            <textarea id="body_wa" name="say_wa" style="height: 400px;" class="form-control"><?= $other['say_wa'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="thanks_wa">Send Terimakasih</label>
                            <textarea id="thanks_wa" name="thanks_wa" style="height: 150px;" class="form-control"><?= $other['thanks_wa'] ?></textarea>
                        </div>
                    <?php } ?>

                    <div class="form-group row mt-2">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="createhelp">Invoice Thermal</label>
                                <select class="form-control" id="inv_thermal" name="inv_thermal" required>
                                    <option value="<?= $other['inv_thermal']; ?>"><?= $other['inv_thermal'] == 1 ? 'Pdf 88mm' : 'Auto Print (Versi Lama)' ?></option>
                                    <option value="1">Pdf 88mm</option>
                                    <option value="0">Auto Print (Versi Lama)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">

                    <div class="form-group">
                        <label>Keterangan Invoice Dot Matrix</label>
                        <textarea name="remark_invoice" class="form-control"><?= $other['remark_invoice'] ?></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#chcode_unique").click(function() {
            if ($(this).is(":checked")) {
                $("#text_code_unique").show();
                $("#code_unique").val('1');
            } else {
                $("#code_unique").val('0');
                $("#text_code_unique").hide();
            }
        });
    });
</script>