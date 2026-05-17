<?php foreach ($invoice->result() as $data) { ?>
        <?php if (strlen($data->due_date) == 1) { ?>
    <?php $dateisolir = '0' . $data->due_date ?>
<?php } ?>
<?php if (strlen($data->due_date) != 1) { ?>
    <?php $dateisolir = $data->due_date ?>
<?php } ?>

     <?php if ($dateisolir == date('d')) { ?> 
     <?= $data->name ?>
     <?php header('Content-Type: application/json; charset=utf-8');
            // MAKE SURE PHONE NUMBER USING REGION CODE
            $range = 30;
            $datenow = date('Y-m-d');
            $timenow = date('H:i:s');
            $timeex = time() + (1 * 60 * $range);
            $timeex = date('H:i:s', $timeex);
            echo $datenow . ' ' . $timeex;
            var_dump($datenow, $timenow, $timeex);
            die;
            $username = 'btranscb';
            $APIkey = 'e4cb363657beb3fea241d21517a001bf';
            $target = '6282337481227';
            $message = 'TEST_MESSAGE TIME';
            // $send_on =  '2021-04-26 16:55:00'; //Format YYYY-MM-DD HH:MM:SS
            $send_on =  $datenow . '' . $timeex; //Format YYYY-MM-DD HH:MM:SS

            $url = 'http://api.autonotif.com/public/add_sm/?key=' . $APIkey . '&username=' . $username;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                'APIKey'     => $APIkey,
                'target'  => $target,
                'message' => $message,
                'send_on' => $send_on,
            ));

            // EXECUTE:
            $result = curl_exec($curl);
            if (!$result) {
                die("Connection Failure");
            }
            curl_close($curl);
            echo $result;
             ?>
        <?php } ?>
       



    <?php } ?>