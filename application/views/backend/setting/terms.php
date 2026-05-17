<link href="<?= base_url('assets/backend/') ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
<div class="container">
    <?php $this->view('messages') ?>
</div>
<div class="container mt-2">
    <div class="card">
        <div class="card-header">
            Syarat dan Ketentuan <?= $company['company_name'] ?>
        </div>
        <div class="card-body">
            <form action="<?= site_url('setting/editterms') ?>" method="POST">
                <textarea name="terms" id="editor1" class="form-control"><?= $company['terms'] ?></textarea>
                <div class="text-right mt-2">
                    <button class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/backend/') ?>css/ckeditor/ckeditor.js"></script>
<script src="<?= base_url('assets/backend/') ?>js/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor1');
        $('.textarea').wysihtml5()
    });
</script>