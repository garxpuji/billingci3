<?php if (strlen($other['date_reset']) == 1) { ?>
    <?php $datereset = '0' . $router['date_reset'] ?>
<?php } ?>
<?php if (strlen($other['date_reset']) != 1) { ?>
    <?php $datereset = $other['date_reset'] ?>
<?php } ?>

<?php if (date('d') == $datereset) { ?>

    <?php $customer = $this->db->get('customer'); ?>
    <?php foreach ($customer->result() as $data) { ?>
        <?= $data->name; ?> - <?= $data->no_services; ?> <br>
        <?php
        $router = $this->db->get('router')->row_array();
        $ip = $router['ip_address'];
        $user = $router['username'];
        $pass = $router['password'];
        $port = $router['port'];
        $userclient = $data->user_mikrotik;
        $API = new Mikweb();
        $API->connect($ip, $user, $pass, $port);
        // RESET HOTSPOT
        if ($data->mode_user == 'Hotspot') {
            $getuser = $API->comm("/ip/hotspot/user/print", array(
                "?name" => $userclient,
            ));
            $id = $getuser[0]['.id'];
            $API->comm("/ip/hotspot/user/reset-counters", array(
                ".id" => $id,
            ));
        }
        if ($data->mode_user == 'PPPOE') {
            // RESET PPPOE
            $getuser = $API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?name' => $userclient,));
            $id = $getuser[0]['.id'];
            $API->comm("/ppp/secret/set", array(
                ".id" =>  $id,
                "comment" => 0,
            ));
        }
        if ($data->mode_user == 'Static') {
            // RESET STATIC
            $getuser = $API->comm("/queue/simple/print", array('?name' => $userclient,));
            $id = $getuser[0]['.id'];
            $API->comm("/queue/simple/reset-counters", array(
                ".id" =>  $id,
            ));
        }
        ?>



    <?php } ?>
<?php } ?>