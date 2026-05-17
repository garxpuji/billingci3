<?php if (strlen($other['date_reset']) == 1) { ?>
    <?php $datereset = '0' . $router['date_reset'] ?>
<?php } ?>
<?php if (strlen($other['date_reset']) != 1) { ?>
    <?php $datereset = $other['date_reset'] ?>
<?php } ?>

<?php if (date('d') == $datereset) { ?> 

<?php $customer = $this->db->get_where('customer', ['mode_user' => 'Hotspot']); ?>
<?php foreach ($customer->result() as $data) { ?>
<?php $router = $this->db->get_where('router', ['id' => $data->router])->row_array(); ?>
    <?php

        $ip = $router['ip_address'];
        $user = $router['username'];
        $pass = $router['password'];
        $port = $router['port'];
        $userclient = $data->user_mikrotik;
        $API = new Mikweb();
        $API->connect($ip, $user, $pass, $port);
        // RESET HOTSPOT
        $getuser = $API->comm("/ip/hotspot/user/print", array(
            "?name" => $userclient,
        ));
        $id = $getuser[0]['.id'];
        $API->comm("/ip/hotspot/user/reset-counters", array(
            ".id" => $id,
        ));


    ?>



<?php } ?>
<?php } ?>