<?php foreach ($bill->result() as $data) { ?>
    <?php if (strlen($data->due_date) == 1) { ?>
        <?php $dateisolir = '0' . $data->due_date ?>
    <?php } ?>
    <?php if (strlen($data->due_date) != 1) { ?>
        <?php $dateisolir = $data->due_date ?>
    <?php } ?>
    <?php $fulldateisolir = $data->year . '-' . $data->month . '-' . $dateisolir; ?>
    <?php $isolirinteger = strtotime($fulldateisolir); ?>
    <?php $other = $this->db->get('other')->row_array(); ?>
    <?php $range = $other['date_reminder'] * 24 ?>
    <?php $remind = $isolirinteger - (60 * 60 * $range)   ?>
    <?php $datenow = strtotime(date('Y-m-d'))   ?>

    <?php if ($datenow == $remind) { ?>
        <?= $data->name; ?> - <?= $data->no_services; ?><br>
        <?php $invoice = $this->db->get_where('invoice', ['invoice' => $data->invoice])->row_array();
        $customer = $this->db->get_where('customer', ['no_services' => $data->no_services])->row_array();
        ?>

        <?php
        // WA GATEWAY
        // get database wa gateway
        $whatsapp = $this->db->get('whatsapp')->row_array();
        // get database other 
        $other = $this->db->get('other')->row_array();
        // get database company
        $company = $this->db->get('company')->row_array();

        if ($whatsapp['is_active'] == 1) {
            if ($whatsapp['reminderinvoice'] == 1) {

                $range = $no++ * $whatsapp['interval_message'];
                $timeex = time() + (1 * 60 * $range);
                echo $timeex;
                $timeex = date('Y-m-d H:i:s', $timeex);

                $timenow = time() + (1 * 60 * $range);
                $wadateex = date('Y-m-d', $timenow);
                $watimeex = date('H:i', $timenow);
                // echo  $timeex;
                if ($whatsapp['createinvoice'] == 1) {

                    $company = $this->db->get('company')->row_array();
                    $username = $whatsapp['username'];
                    $APIkey = $whatsapp['api_key'];
                    $no = 1;
                    $nominalWA = indo_currency($invoice['amount']);
                    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                    $replace = array($customer['name'], $customer['no_services'], indo_month($invoice['month']), $invoice['year'], indo_month($invoice['month']) . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                    $subject = $other['footer_wa'];
                    $message = str_replace($search, $replace, $subject);
                    $apikey = $whatsapp['api_key'];
                    $sender = $whatsapp['sender'];
                    $target = indo_tlp($customer['no_wa']);
                    // var_dump($message);
                    // die;
                    $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS
                    if ($whatsapp['vendor'] == 'Autonotif') {
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
                        // echo $result;
                    }
                    if ($whatsapp['vendor'] == 'WAblas') {
                        $curl = curl_init();
                        $token = $whatsapp['token'];
                        $data = [
                            'phone' => $target,
                            'message' => $message,
                            'date' => $wadateex,
                            'time' => $watimeex,
                        ];

                        curl_setopt(
                            $curl,
                            CURLOPT_HTTPHEADER,
                            array(
                                "Authorization: $token",
                            )
                        );
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                        curl_setopt($curl, CURLOPT_URL, "$whatsapp[domain_api]/api/schedule");
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                        $result = curl_exec($curl);
                        curl_close($curl);

                        // echo "<pre>";
                        // print_r($result);
                    }
                }
            }
        } ?>
    <?php } ?>




<?php } ?>