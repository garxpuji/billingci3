<?php $whatsapp = $this->db->get('whatsapp')->row_array(); ?>
<?php if ($whatsapp['is_active'] == 1) { ?>
    <?php if ($whatsapp['duedateinvoice'] == 1) { ?>
        <?php $no = 1;
        foreach ($invoice->result() as $data) { ?>

            <?php if (strlen($data->due_date) == 1) { ?>
                <?php $dateisolir = '0' . $data->due_date ?>
            <?php } ?>
            <?php if (strlen($data->due_date) != 1) { ?>
                <?php $dateisolir = $data->due_date ?>
            <?php } ?>
            <?php if ($dateisolir == date('d')) { ?>
                <?= $data->name ?> - <?php $range = $no++ *  $whatsapp['interval_message'];
                                        $timenow = date('H:i:s');
                                        $timeex = time() + (1 * 60 * $range);
                                        $timeex = date('Y-m-d H:i:s', $timeex);
                                        echo  $timeex; ?> <br>
                <?php
                // MAKE SURE PHONE NUMBER USING REGION CODE

                $textWA = $this->db->get('other')->row_array();
                $company = $this->db->get('company')->row_array();
                $username = $whatsapp['username'];
                $APIkey = $whatsapp['api_key'];
                $target = indo_tlp($data->no_wa);
                if ($textWA['code_unique'] > 0) {
                    $codeunique = $data->code_unique;
                } else {
                    $codeunique = 0;
                }
                if ($data->due_date > 0) {
                    $duedate = $data->due_date;
                } else {
                    $duedate = $company['due_date'];
                }
                if ($data->amount != 0) {
                    $nominal = indo_currency($data->amount + $codeunique);
                } else {
                    $query = "SELECT * FROM `invoice_detail` WHERE `invoice_detail`.`invoice_id` =  $data->invoice";
                    $querying = $this->db->query($query)->result();
                    $subTotal = 0;
                    foreach ($querying as  $dataa)
                        $subTotal += (int) $dataa->total;
                    if ($subTotal != 0) {
                        $ppn = $subTotal * ($data->i_ppn / 100);
                        $nominal = indo_currency($subTotal + $ppn + $codeunique);
                    } else {
                        $query = "SELECT * FROM `invoice_detail` WHERE `invoice_detail`.`d_month` =  $data->month and
                       `invoice_detail`.`d_year` =  $data->year and
                       `invoice_detail`.`d_no_services` =  $data->no_services";
                        $queryTot = $this->db->query($query)->result();
                        $subTotaldetail = 0;
                        foreach ($queryTot as  $dataa)
                            $subTotaldetail += (int) $dataa->total;
                        $ppn = $subTotaldetail * ($data->i_ppn / 100);
                        $nominal = indo_currency($subTotaldetail + $ppn + $codeunique);
                    }
                }
                $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                $replace = array($data->name, $data->no_services, $data->month, $data->year, indo_month($data->month) . ' ' . $data->year, $duedate, $nominal, $company['company_name'], $company['sub_name'], base_url(), '');
                $subject = $textWA['body_wa'];

                $message = str_replace($search, $replace, $subject);

                $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS


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
                ?> <?php } ?>
        <?php }  ?>
    <?php } else {
        echo 'Auto Reminder Non Active';
    } ?>
<?php } else {
    echo 'Whatsapp Gateway Non Active';
}  ?>