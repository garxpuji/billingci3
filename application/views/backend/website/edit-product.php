<link href="<?= base_url('assets/backend/') ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Produk</h6>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <form method="post" action="<?= base_url('product/edit_product') ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $product->id ?>">
                                <input type="hidden" class="form-control" id="post_by" name="post_by" value="<?= $user['name'] ?>">
                                <label for="name">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $product->name ?>" onKeyPress="return kodeScript(event,' :abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',this)">
                                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label for="picture">Picture</label>
                                <input type="file" name="picture" id="picture">
                            </div>
                            <div class="form-group">
                                <label for="remark">Deskripsi Singkat</label>
                                <textarea type="text" class="form-control" id="remark" name="remark"><?= $product->remark ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="editor1" cols="30" rows="10"><?= $product->description ?></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="Reset" class="btn btn-info">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
                </section>
                <script src="<?= base_url('assets/backend/css/') ?>ckeditor/ckeditor.js"></script>
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