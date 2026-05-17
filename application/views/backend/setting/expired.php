<style>
    @import url("https://fonts.googleapis.com/css?family=Share+Tech+Mono|Montserrat:700");

    * {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
        box-sizing: border-box;
        color: inherit;
    }

    body {
        background-image: linear-gradient(120deg, #4f0088 0%, #000000 100%);
        height: 100vh;
    }

    h1 {
        font-size: 45vw;
        text-align: center;
        position: fixed;
        width: 100vw;
        z-index: 1;
        color: #ffffff26;
        text-shadow: 0 0 50px rgba(0, 0, 0, 0.07);
        top: 50%;
        transform: translateY(-50%);
        font-family: "Montserrat", monospace;
    }

    div {
        background: rgba(0, 0, 0, 0);
        width: 70vw;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 auto;
        padding: 30px 30px 10px;
        box-shadow: 0 0 150px -20px rgba(0, 0, 0, 0.5);
        z-index: 3;
    }

    P {
        font-family: "Share Tech Mono", monospace;
        color: #f5f5f5;
        margin: 0 0 20px;
        font-size: 17px;
        line-height: 1.2;
    }

    span {
        color: #f0c674;
    }

    i {
        color: #8abeb7;
    }

    div a {
        text-decoration: none;
    }

    b {
        color: #81a2be;
    }

    a.avatar {
        position: fixed;
        bottom: 15px;
        right: -100px;
        animation: slide 0.5s 4.5s forwards;
        display: block;
        z-index: 4
    }

    a.avatar img {
        border-radius: 100%;
        width: 44px;
        border: 2px solid white;
    }

    @keyframes slide {
        from {
            right: -100px;
            transform: rotate(360deg);
            opacity: 0;
        }

        to {
            right: 15px;
            transform: rotate(0deg);
            opacity: 1;
        }
    }
</style>
<title><?= $title ?> | <?= $company['company_name'] ?></title>
<link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">

<body onload="JavaScript:AutoRefresh(60000);">
    <?php $company = $this->db->get('company')->row_array() ?>
    <?php if ($company['isolir'] == 1) { ?>
        <?php if ($user['email'] != 'ginginabdulgoni@gmail.com') { ?>
            <?php if (date('Y-m-d') < $company['expired']) {
                redirect('dashboard');
            } ?>
        <?php } ?>
    <?php } ?>
    <h1>403</h1>
    <div>
        <p>> <span>KODE ERROR</span>: "<i>HTTP 403 Forbidden</i>"</p>
        <p> <span>Pelanggan My-Wifi yang terhormat,</span> </p>
        <p>Kami informasikan bahwa layanan My-Wifi Anda saat ini terisolir. </p>
        <p>Mohon maaf atas ketidaknyamanannya. Agar dapat digunakan kembali, mohon untuk segera melakukan pembayaran Tagihan.</p>
        <p></p>
        <p>Untuk menghindari terulangnya kembali ketidaknyamanan ini, disarankan untuk melakukan pembayaran tepat waktu.</p>
        <p>> <span>Have a nice day mr/mrs <?= $company['owner']; ?> :-)</span></p>
        <?php $link = "https://$_SERVER[HTTP_HOST]"; ?>
        <p>> Untuk pemabayaran bisa melakukan transfer, <a href="site_url('front/rek')" title="Daftar Rekening"><span>Klik disini</span> ini</a> dibawah ini </p>
        <p>> Untuk informasi lebih lanjut silahkan hubungi kami di tombol <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp('085283935826') ?>&text=Perpanjangan Billing My-Wifi untuk <?= $link ?>" title="Kontak Kami"><span>WA</span> ini</a> dibawah ini </p>
        <p>> <span>Terimakasih</span></p>
        <p>This page will refresh every 60 seconds.</p>
    </div>
</body>

<a class="avatar" href="https://api.whatsapp.com/send?phone=<?= indo_tlp('085283935826') ?>&text=Perpanjangan Billing My-Wifi untuk <?= $link ?>" title="Kontak Kami"><img src="<?= base_url('assets/images/medsos/whatsapp.jpg') ?>" /></a>

<script>
    var str = document.getElementsByTagName('div')[0].innerHTML.toString();
    var i = 0;
    document.getElementsByTagName('div')[0].innerHTML = "";

    setTimeout(function() {
        var se = setInterval(function() {
            i++;
            document.getElementsByTagName('div')[0].innerHTML = str.slice(0, i) + "|";
            if (i == str.length) {
                clearInterval(se);
                document.getElementsByTagName('div')[0].innerHTML = str;
            }
        }, 10);
    }, 0);
</script>
<script type="text/JavaScript">

    function AutoRefresh( t ) {
               setTimeout("location.reload(true);", t);
            }
      
</script>