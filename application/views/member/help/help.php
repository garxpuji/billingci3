<?php $this->view('messages') ?>
<div class="row">
    <div class="col-lg-4 col-sm-6 col-md-6">
        <a href="<?= site_url('help') ?>">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="fw-700 text-red">Lapor Gangguan</h3>
                            <h6 class="mb-25">Solusi menyelesaikan kendala anda</h6>
                            <a href="<?= site_url('help/history') ?>" class="btn btn-secondary"><i class="ik ik-clock"></i>Riwayat Gangguan</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wrench bg-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-sm-6 col-md-6">
        <a href="<?= site_url('help') ?>">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="fw-700 text-red">Kontak Kami</h3>
                            <h6 class="mb-25">Chat kami untuk mengetahui informasi seputar layanan</h6>
                            <a href="https://api.whatsapp.com/send?phone=<?= $company['phonecode'] . $company['whatsapp'] ?>" class="btn btn-success">Whatsapp</a>
                            <?php $bot = $this->db->get('bot_telegram')->row_array() ?>
                            <a href="https://t.me/<?= $bot['username_owner'] ?>" class="btn btn-primary">Telegram</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment bg-default"></i>

                        </div>

                    </div>
                </div>
            </div>
        </a>
    </div>
</div>