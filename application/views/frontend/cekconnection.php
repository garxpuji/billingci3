<?php

$query = "SELECT *
                            FROM `customer`
                          
                                WHERE 
                               `customer`.`user_mikrotik` !=  '' and  `customer`.`mode_user` !=  ''
                              ";
$customer = $this->db->query($query)->result();

?>
<?php foreach ($customer as $data) { ?>
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
        $getactive = $API->comm("/ip/hotspot/active/print", array(
            "?user" => $userclient,
        ));
        if (count($getactive) == 0) {
            $bot = $this->db->get('bot_telegram')->row_array();
            $tokens = $bot['token']; // token bot
            $owner = $bot['id_group_teknisi'];
            $sendmessage = [
                'reply_markup' => json_encode(['inline_keyboard' => [
                    [
                        // ['text' => '✅ Konfirmasi', 'url' => base_url('confirmdetail/' . $post['no_invoice'])],

                    ]
                ]]),
                'resize_keyboard' => true,
                'parse_mode' => 'html',
                'text' => "<b>DISCONNECT</b>\nNama : $data->name\nNo Layanan : $data->no_services\nRouter : $router[alias]\nMode : $data->mode_user\nUser :  $data->user_mikrotik\n",
                'chat_id' => $owner
            ];

            file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
        }
    }
    if ($data->mode_user == 'PPPOE') {
        $getactive = $API->comm("/ppp/active/print", array(
            '?name' => $userclient,
        ));
        if (count($getactive) == 0) {
            $bot = $this->db->get('bot_telegram')->row_array();
            $tokens = $bot['token']; // token bot
            $owner = $bot['id_group_teknisi'];
            $sendmessage = [
                'reply_markup' => json_encode(['inline_keyboard' => [
                    [
                        // ['text' => '✅ Konfirmasi', 'url' => base_url('confirmdetail/' . $post['no_invoice'])],

                    ]
                ]]),
                'resize_keyboard' => true,
                'parse_mode' => 'html',
                'text' => "<b>DISCONNECT</b>\nNama : $data->name\nNo Layanan : $data->no_services\nRouter : $router[alias]\nMode : $data->mode_user\nUser :  $data->user_mikrotik\n",
                'chat_id' => $owner
            ];

            file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
        }
    }
    if ($data->mode_user == 'Static') {
        $simplequeue = $API->comm("/queue/simple/print", array('?name' => $userclient,));
        $ipqueue = substr($simplequeue['0']['target'], 0, -3);
        $getarp = $API->comm("/ip/arp/print", array("?address" =>  $ipqueue));
        // echo $getarp;
        if (count($getarp) <= 0) {
            $bot = $this->db->get('bot_telegram')->row_array();
            $tokens = $bot['token']; // token bot
            $owner = $bot['id_group_teknisi'];
            $sendmessage = [
                'reply_markup' => json_encode(['inline_keyboard' => [
                    [
                        // ['text' => '✅ Konfirmasi', 'url' => base_url('confirmdetail/' . $post['no_invoice'])],

                    ]
                ]]),
                'resize_keyboard' => true,
                'parse_mode' => 'html',
                'text' => "<b>DISCONNECT</b>\nNama : $data->name\nNo Layanan : $data->no_services\nRouter : $router[alias]\nMode : $data->mode_user\nUser :  $data->user_mikrotik\n",
                'chat_id' => $owner
            ];

            file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
        }
    }
    ?>
 <?php } ?>