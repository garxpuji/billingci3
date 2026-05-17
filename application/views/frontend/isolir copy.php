<?php
$date = date('d');
$month = date('m');
$year = date('Y');
$query = "SELECT *
                            FROM `invoice`
                            Join `customer` ON `invoice`.`no_services` = `customer`.`no_services`
                                WHERE 
                               `customer`.`user_mikrotik` !=  '' and
                               `customer`.`auto_isolir` =  '1' and
                               `customer`.`due_date` =  $date and
                               `customer`.`type_payment` =  '0' and
                               `invoice`.`month` =  $month and
                               `invoice`.`year` =  $year and
                               `invoice`.`status` =  'BELUM BAYAR'";
$billpasca = $this->db->query($query)->result();

?>
<?php
$date = date('d');
$month = date('m') - 1;
$year = date('Y');
$query = "SELECT *
                            FROM `invoice`
                            Join `customer` ON `invoice`.`no_services` = `customer`.`no_services`
                                WHERE 
                               `customer`.`user_mikrotik` !=  '' and
                               `customer`.`auto_isolir` =  '1' and
                               `customer`.`due_date` =  '4' and
                               `customer`.`type_payment` =  '1' and
                               `invoice`.`month` =  $month and
                               `invoice`.`year` =  $year and
                               `invoice`.`status` =  'BELUM BAYAR'";
$billpra = $this->db->query($query)->result();

?>
<h2>Daftar Pelanggan pascabayar yang sudah jatuh tempo, dengan auto isolir yes</h2>
<?php $no = 1;
foreach ($billpasca as $data) { ?>
    <?php if (strlen($data->due_date) == 1) { ?>
        <?php $due_date = '0' . $data->due_date ?>
    <?php } ?>
    <?php if (strlen($data->due_date) != 1) { ?>
        <?php $due_date = $data->due_date ?>
    <?php } ?>
    <?php $cekduedate = $data->year . '-' . $data->month . '-' . $due_date ?>
    <?php if (date('Y-m-d') >= $cekduedate) { ?>
        <?= $no++; ?>. <?= $data->name ?> - <?= $data->no_services; ?> - <?= $cekduedate; ?> <br>
        <?php
        $router = $this->db->get_where('router', ['id' => $data->router])->row_array();
        $ip = $router['ip_address'];
        $user = $router['username'];
        $pass = $router['password'];
        $port = $router['port'];
        $userclient = $data->user_mikrotik;
        $API = new Mikweb();
        $API->connect($ip, $user, $pass, $port);
        // DISABLE HOTSPOT
        if ($data->mode_user == 'Hotspot') {
            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?name" => $userclient,
            ));
            $id = $getuser[0]['.id'];
            if ($data->action == 0) {
                // DISABLE Hotspot
                $API->comm("/ip/hotspot/user/disable", array(
                    ".id" => $id,
                ));
            } else {
                $API->comm("/ip/hotspot/user/set", array(
                    ".id" =>  $id,
                    "profile" => 'EXPIRED'
                ));
            }

            $getactive = $API->comm("/ip/hotspot/active/print", array(
                "?user" => $userclient,
            ));
            $idactive = $getactive[0]['.id'];
            $API->comm("/ip/hotspot/active/remove", array(
                ".id" => $idactive,
            ));
            // var_dump($getactive);
        }
        if ($data->mode_user == 'PPPOE') {
            $getuser = $API->comm("/ppp/secret/print", array(
                '?service' => 'pppoe',
                '?name' => $userclient,
            ));
            $id = $getuser[0]['.id'];
            if ($data->action == 0) {
                // DISABLE PPPOE
                $API->comm("/ppp/secret/disable", array(
                    ".id" =>  $id,
                ));
            } else {
                $API->comm("/ppp/secret/set", array(
                    ".id" =>  $id,
                    "profile" => 'EXPIRED'
                ));
            }
            $getactive = $API->comm("/ppp/active/print", array(
                '?name' => $userclient,
            ));
            $idactive = $getactive[0]['.id'];
            $API->comm("/ppp/active/remove", array(
                ".id" =>  $idactive,
            ));
        }
        // DISABLE STATIC
        if ($data->mode_user == 'Static') {
            $simplequeue = $API->comm("/queue/simple/print", array('?name' => $userclient,));
            $ipqueue = substr($simplequeue['0']['target'], 0, -3);
            $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
            $getfirewall = $API->comm("/ip/firewall/filter/print", array("?comment" => 'ISOLIR|' . $data->no_services . ''));
            // var_dump($getfirewall);
            if ($data->action == 0) {
                if (count($getfirewall) == 0) {
                    $API->comm("/ip/firewall/filter/add", array(
                        'chain' => 'forward',
                        'src-address' => $ipqueue,
                        'action' => 'drop',
                        'comment' => 'ISOLIR|' . $data->no_services . '',

                    ));
                }
            } else {
                $API->comm("/ip/firewall/address-list/add", array(
                    'list' => 'EXPIRED',
                    'address' => $ipqueue,
                    'comment' => 'ISOLIR|' . $data->no_services . '',
                ));
            }
        }
        $bot = $this->db->get('bot_telegram')->row_array();
        $tokens = $bot['token']; // token bot
        $owner = $bot['id_telegram_owner'];
        $sendmessage = [
            'reply_markup' => json_encode(['inline_keyboard' => [
                [
                    // ['text' => '✅ Konfirmasi', 'url' => base_url('confirmdetail/' . $post['no_invoice'])],

                ]
            ]]),
            'resize_keyboard' => true,
            'parse_mode' => 'html',
            'text' => "<b>ISOLIR PELANGGAN</b>\nNama : $data->name\nNo Layanan : $data->no_services\nRouter : $router[alias]\nMode : $data->mode_user\nUser :  $data->user_mikrotik\nJatuh Tempo :  $cekduedate\n",
            'chat_id' => $owner
        ];

        file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
        ?>
    <?php }  ?>
    <?php if (count($billpasca) < 0) { ?>
        <h5>Tidak ada pelanggan pascabayar yang jatuh tempo hari ini dengan auto isolir yes</h5>
    <?php } ?>



<?php } ?>