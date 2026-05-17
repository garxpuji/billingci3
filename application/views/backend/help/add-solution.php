<link href="<?= base_url('assets/backend/') ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Tambah Solusi</h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <form method="post" action="<?= base_url('help/adds') ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Nama Bantuan</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>

                            <div class="form-group">
                                <label for="type">Jenis Bantuan</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    <?php foreach ($type as $data) { ?>
                                        <option value="<?= $data->help_id ?>"><?= $data->help_type ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="solution">Solusi</label>
                                <textarea name="solution" id="editor1" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="Reset" class="btn btn-info">Reset</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/backend/') ?>css/ckeditor/ckeditor.js"></script>
    <script src="<?= base_url('assets/backend/') ?>js/bootstrap3-wysihtml5.all.min.js"></script>
    <script language="javascript">
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }

        function kodeScript(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null) return true;

            keychar = String.fromCharCode(key);
            keychar = keychar.toLowerCase();
            goods = goods.toLowerCase();

            // check goodkeys
            if (goods.indexOf(keychar) != -1)
                return true;
            // control keys
            if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
                return true;

            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            };
            // else return false
            return false;
        }
    </script>
    <script type="text/javascript">
        $(function() {
            CKEDITOR.replace('editor1');
            $('.textarea').wysihtml5()
        });
    </script>