<div class="card mb-4 py-3 border-left-primary">
    <div class="card-body">
        <h3>Backup Database</h3>
        *Setelah melakukan backup database, harap file backup-nya disimpan ditempat yang aman.
        <br>
        <br>
        <a href="<?= site_url('setting/backupdatabase') ?>" class="btn btn-info" onclick="return confirm('Apakah anda yakin backup database ?')">Get Backup</a>
    </div>
</div>
<div class="card mb-4 py-3 border-left-primary">
    <style>
        textarea {
            width: 100%;
        }

        .textwrapper {
            border: 1px solid #999999;
            margin: 5px 0;
            padding: 3px;
        }
    </style>
    <div class="card-body">
        <h3>Backup Database Otomatis Ke Telegram</h3>
        Jalankan script dibawah di Terminal Mikrotik Anda.
        <br>
        <br>
        <input type="text" class="form-control" value="system scheduler add name=BACKUP-MY-WIFI start-time=00:
05:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/backupdb') ?>&#34; keep-result=no}" readonly>
        <br>
        <br><?php if ($this->session->userdata('email') == 'ginginabdulgoni@gmail.com') { ?>
            <input type="text" class="form-control" value="system scheduler add name=BACKUP-MY-WIFI start-time=00:
05:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/backupadmin') ?>&#34; keep-result=no}" readonly>
        <?php } ?>
    </div>
</div>