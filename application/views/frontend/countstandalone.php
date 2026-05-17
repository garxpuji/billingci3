
<?php $customer = $this->db->get_where('customer', ['mode_user' => 'Standalone'])->result(); ?>

<?php foreach ($customer as $data) { ?>
<?php if ($data->router != null) { ?> 
    <?php
        $router = $this->db->get_where('router', ['id' => $data->router])->row_array();
        $ip = $router['ip_address'];
        $user = $router['username'];
        $pass = $router['password'];
        $port = $router['port'];
        $userclient = $data->user_mikrotik;
        $API = new Mikweb();
        $API->connect($ip, $user, $pass, $port);
        // RESET PPPOE
        $getusage = $API->comm("/interface/print", array(
            "?name" => "$userclient",
        ));
        $usage = $getusage['0']['tx-byte'] + $getusage['0']['rx-byte'];
        // $getuser = $API->comm("/interface/ethernet/print");

        $id = $getusage[0]['.id'];


        if ($getusage['0']['comment'] == '') {
            $API->comm("/interface/set", array(
                ".id" =>  $id,
                "comment" => $usage,
            ));
        } else {
            $API->comm("/interface/set", array(
                ".id" =>  $id,
                "comment" => $getusage['0']['comment'] + $usage,
            ));
        }

        $cekscript = $API->comm("/system/script/print", array('?name' => "reset-standalone-$userclient"));
        $id = $cekscript[0]['.id'];
        if (count($cekscript) == 0) {
            $API->comm("/system/script/add", array(
                "name" =>  "reset-standalone-$userclient",
                "source" => "/interface reset-counters $userclient",
            ));
        } else {
            $API->comm("/system/script/run", array(
                ".id" => $id,
            ));
        }


        // var_dump($getuser);
    ?>
 <?php } ?>
  
<?php } ?>
