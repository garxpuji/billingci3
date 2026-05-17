<?php $whatsapp = $this->db->get('whatsapp')->row_array(); ?>
<?php
$today = date('Y-m-d');
$query = "SELECT *
                            FROM `invoice`
                            Join `customer` ON `invoice`.`no_services` = `customer`.`no_services`
                                WHERE `invoice`.`inv_due_date` =  '$today' and `invoice`.`send_due` ='' and  `invoice`.`status` =  'BELUM BAYAR'";
$bill = $this->db->query($query)->result();

?>
<h2>Daftar Pelanggan yang jatuh tempo hari ini </h2>
<?php if (count($bill) > 0) { ?>
    <?php if ($whatsapp['is_active'] == 1) { ?>
        <?php if ($whatsapp['duedateinvoice'] == 1) { ?>
            <?php $no = 1;
            foreach ($bill as $data) { ?>
                <?= $no++; ?>. <?= $data->name ?> - <?= $data->no_services ?> <br>
                <?php
                $range = $no++ * $whatsapp['interval_message'];
                if ($whatsapp['vendor'] == 'WAblas') {
                    $timeex = time() + (1 * 60 * $range);
                    $timeex = date('Y-m-d H:i:s', $timeex);
                    $timenow = time() + (1 * 60 * $range);
                    $time = $timenow;
                } elseif ($whatsapp['vendor'] == 'Starsender') {
                    $jadwall = time() + (1  * $range);
                    $time = date('Y-m-d H:i:s', $jadwall);
                }

                $month = $data->month;
                $year = $data->year;
                $amount = $data->amount;
                if ($data->codeunique > 0) {
                    $codeunique = $data->code_unique;
                } else {
                    $codeunique = 0;
                }

                $other = $this->db->get('other')->row_array();
                $company = $this->db->get('company')->row_array();
                $username = $whatsapp['username'];

                $target = indo_tlp($data->no_wa);

                $nominalWA = indo_currency($amount - $data->disc_coupon + $codeunique);
                $search  = array('{name}', '{noservices}', '{email}', '{invoice}',  '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                $replace = array($data->name, $data->no_services, $data->email, $data->invoice, indo_month($month), $year, indo_month($month) . ' ' . $year, indo_date($data->inv_due_date), $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                $subject = $other['body_wa'];
                $message = str_replace($search, $replace, $subject);

                sendmsgschduedate($target, $message, $time, $data->invoice);
                ?>

            <?php }  ?>
        <?php } else {
            echo 'Auto Reminder Non Active';
        } ?>
    <?php } else {
        echo 'Whatsapp Gateway Non Active';
    }  ?>
<?php } else {
    'Tidak ada tagihan jatuh tempo hari ini';
} ?>