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
        <div class="col-lg-6">

            <form action="<?= site_url('setting/setschedule') ?>" method="post">
                <label for="">Auto Generate Tagihan</label>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="">Status</label>
                        <select class="form-control" id="sch_createbill" name="sch_createbill">
                            <option value="<?= $other['sch_createbill']; ?>"><?= $other['sch_createbill'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="">Setiap Tanggal</label>
                        <input type="number" min="1" max="28" name="date_create" class="form-control" value="<?= $other['date_create'] ?>">
                    </div>
                </div>



                <button type="submit" class="btn btn-primary mt-1">Simpan</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <h3>Untuk menjalankan fitur Otomatis</h3>
        jalankan script ini di terminal mikrotik anda.
        <br>

        <div class="row">
            <div class="col-lg-12"> <br>
                <?php $other = $this->db->get('other')->row_array() ?>
                <label for="">Auto Generate Tagihan</label>
                <input type="text" class="form-control" value="system scheduler add name=GENERATE-BILL start-time=07:
30:00 interval=1d on-event={/tool fetch url=&#34;<?= base_url('front/createbill/' . $other['key_apps']) ?>&#34; keep-result=no}" readonly>
                <br>
                <span style="color: red;">Catatan :</span> Key Apps untuk authentication ketika ada action dari schedule, melindungi schedule dari orang yang eksekusi url schedule, jika key Apps Bocor atau diganti silahkan diganti kembali schedule di mikrotiknya dengan yang baru.
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