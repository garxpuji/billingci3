<?php $other = $this->db->get('other')->row_array(); ?>
<?php
$datenow = date('d-m-Y');
$before        = mktime(0, 0, 0, date("n"), date("j") + $other['date_reminder'], date("Y"));
?>
<!-- <?= $datenow; ?> tiga hari selanjutnya <?= date('d-m-Y', $before); ?> -->

<?php
$beforedue = date('Y-m-d', $before);
$query = "SELECT *
                            FROM `invoice`
                            Join `customer` ON `invoice`.`no_services` = `customer`.`no_services`
                                WHERE `invoice`.`inv_due_date` = '$beforedue'and `invoice`.`send_before_due` =''  and
                               `invoice`.`status` =  'BELUM BAYAR'";
$bill = $this->db->query($query)->result();
// var_dump($result);
?>
<h2>Daftar yang akan jatuh tempo <?= $other['date_reminder']; ?> hari kedepan tanggal <?= date('d-m-Y', $before); ?></h2>

<?php if (count($bill) > 0) {  ?>
    <?php
    $no = 1;
    foreach ($bill as $data) { ?>
        <?= $no++; ?>. <?= $data->name; ?> - <?= $data->no_services; ?> <br>
    <?php } ?>
    <?php

    $whatsapp = $this->db->get('whatsapp')->row_array();
    $bot = $this->db->get('bot_telegram')->row_array();
    $tokens = $bot['token']; // token bot
    $owner = $bot['id_telegram_owner'];
    if ($whatsapp['is_active'] == 1) {
        if ($whatsapp['reminderinvoice'] == 1) {
            foreach ($bill as $data) { ?>
    <?php
                $range = $no++ * $whatsapp['interval_message'];
                if ($whatsapp['vendor'] == 'WAblas') {
                    $timeex = time() + (1 * 60 * $range);
                    $timeex = date('Y-m-d H:i:s', $timeex);
                    $timenow = time() + (1 * 60 * $range);
                    $wadateex = date('Y-m-d H:i:s', $timenow);
                    $time = $wadateex;
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
                $APIkey = $whatsapp['api_key'];
                $target = indo_tlp($data->no_wa);
                // echo $target, $timeex;
                $nominalWA = indo_currency($amount - $data->disc_coupon + $codeunique);
                $search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                $replace = array($data->name, $data->no_services,  $data->email, $data->invoice, indo_month($month), $year, indo_month($month) . ' ' . $year, indo_date($data->inv_due_date), $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                $subject = $other['footer_wa'];
                $message = str_replace($search, $replace, $subject);
                // var_dump($message);
                // die;
                $send_on =  $timeex; //Format YYYY-MM-DD HH:MM:SS

                sendmsgschbeforedue($target, $message, $time, $data->invoice);
            }
        } else {
            $sendmessage = [
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            // ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser/' . $post['no_services'])],
                            // ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs/' . $post['no_services'])],
                        ]
                    ]
                ]),
                'resize_keyboard' => true,
                'parse_mode' => 'html',
                'text' => "<b>GAGAL KIRIM NOTIF Whatsapp $other[date_reminder] Hari sebelum jatuh tempo,</b> dikarenakan pengingat sebelum jatuh tempo tidak aktif, silahkan cek billing ke menu whatsapp",
                'chat_id' => $owner
            ];
            file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
        }
    } else {
        $sendmessage = [
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        // ['text' => '✅ Aktivasi Akun', 'url' => base_url('front/activationuser/' . $post['no_services'])],
                        // ['text' => '✅ Aktivasi Pelanggan', 'url' => base_url('front/activationcs/' . $post['no_services'])],
                    ]
                ]
            ]),
            'resize_keyboard' => true,
            'parse_mode' => 'html',
            'text' => "<b>GAGAL KIRIM NOTIF Whatsapp  $other[date_reminder]  Hari sebelum jatuh tempo,</b> dikarenakan Whatsapp gateway di billing tidak aktif",
            'chat_id' => $owner
        ];
        file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));
    };
    ?>
<?php } else {
    echo 'Tidak ada tagihan dalam waktu ' . $other['date_reminder'] . ' hari kedepan';
} ?>