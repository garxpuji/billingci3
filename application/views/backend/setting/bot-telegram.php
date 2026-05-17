<?php $this->view('messages') ?>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Bot Telegram</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <?php echo form_open_multipart('setting/editbottelegram') ?>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $bot['id'] ?>">
                        <label for="token">Token Bot</label>
                        <input type="text" id="token" name="token" class="form-control" value="<?= $bot['token'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username_bot">Username Bot</label>
                        <input type="text" id="username_bot" name="username_bot" class="form-control" value="<?= $bot['username_bot'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="username_owner">Username Telegram Owner / CS</label>
                        <input type="text" id="username_owner" name="username_owner" class="form-control" value="<?= $bot['username_owner'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="id_telegram_owner">ID telegram Owner / CS</label>
                        <input type="text" id="id_telegram_owner" name="id_telegram_owner" class="form-control" value="<?= $bot['id_telegram_owner'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="id_group_teknisi">ID telegram Group Teknisi</label>
                        <input type="text" id="id_group_teknisi" name="id_group_teknisi" class="form-control" value="<?= $bot['id_group_teknisi'] ?>">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <?php echo form_close() ?>


            <div class=" form-group">
                <label for="bayar">Cara Integrasi Bot Telegram</label>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/RdUgwCgzApw" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- https://api.telegram.org/bot1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4/sendlocation?chat_id=965476866&latitude=-7.205516294225202&longitude=107.82041430473329 -->