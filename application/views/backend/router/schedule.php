<?php
//==============================START=========================================//
/*
     *  Base Code   : Gingin Abdul Goni | Rosita Wulandari, S.Kom,.MTA
     *  Email       : ginginabdulgoni@gmail.com
     *  Instagram   : @ginginabdulgoni
     *  Telegram    : @ginginabdulgoni
     *
     *  Name        : My-Wifi
     *  Function    : Manage Client and Billing

     *
     *  Please do not change this code
     *  All damage caused by editing we will not be responsible please think carefully,
     *
     */
//==============================START CODE=========================================//
?>
<?php $this->view('messages') ?>
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
        <h3>Untuk menjalankan fitur Otomatis</h3>
        jalankan script ini di terminal mikrotik anda.
        <br>

        <div class="row">
            <div class="col-lg-10"> <br>
                <?php $other = $this->db->get('other')->row_array() ?>
                <label for="">Auto Create Invoice every Month</label>
                <input type="text" class="form-control" value="system scheduler add name=Billing-Create-Invoice start-time=00:
30:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/createbill/' . $other['key_apps']) ?>&#34; keep-result=no}" readonly>
                <br>
                <label for="">Auto Reminder</label>
                <input type="text" class="form-control" value="system scheduler add name=Billing-Isolir start-time=08:
00:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/reminder/' . $other['key_apps']) ?>&#34; keep-result=no}" readonly>
                <br>
                <label for="">Auto Isolir</label>
                <input type="text" class="form-control" value="system scheduler add name=Billing-Isolir start-time=00:
05:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/isolir/' . $other['key_apps']) ?>&#34; keep-result=no}" readonly>
                <br>
                <label for="">Auto Hitung Pemakaian PPPOE</label>
                <input type="text" class="form-control" value="system scheduler add name=Billing-Count-Pemakaian-PPPOE start-time=02:
00:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/countpppoe/' . $other['key_apps']) ?>&#34; keep-result=no}" readonly>
                <br>
                <label for="">Auto Reset Pemakaian</label>
                <input type="text" class="form-control" value="system scheduler add name=Billing-Reset-Pemakaian start-time=00:
50:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/resetusage/' . $other['key_apps']) ?>&#34; keep-result=no}" readonly>
                <br>
                <span style="color: red;">Catatan :</span> Key Apps untuk authentication ketika ada action dari schedule, melindungi schedule dari orang yang eksekusi url schedule, jika key Apps Bocor atau diganti silahkan diganti kembali schedule di mikrotiknya dengan yang baru.
            </div>
            <div class="col">

                <form action="<?= site_url('router/setschedule') ?>" method="post">
                    <label for="">Tanggal Create Bill</label>
                    <input type="number" min="1" max="28" name="date_create" class="form-control" value="<?= $other['date_create'] ?>">
                    <br>
                    <label for="">Tanggal Reset Pemakaian</label>
                    <input type="number" min="1" max="28" name="date_reset" class="form-control" value="<?= $other['date_reset'] ?>">
                    <br>
                    <label for="">Key Apps</label> <a href="#" id="generatekeyapps" style="text-decoration: none;">Generate</a>
                    <input type="text" name="key_apps" id="key_apps" class="form-control" value="<?= $other['key_apps'] ?>">
                    <button type="submit" class="btn btn-primary mt-1">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#generatekeyapps").click(function() {
            var keyapps = makeid(16)
            $("#key_apps").val(keyapps);
        });
    });

    function makeid(length) {
        var result = [];
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result.push(characters.charAt(Math.floor(Math.random() *
                charactersLength)));
        }
        return result.join('');
    }
</script>