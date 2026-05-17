<?php
$company = $this->db->get('company')->row_array();
$other = $this->db->get('other')->row_array();
$bill = $this->customer_m->getisolirthisdate()->result();
// var_dump($bill);
// die;
$no = 1;
foreach ($bill as $data) { ?>
    <?= $no++; ?>. <?= $data->name; ?> - <?= $data->no_services; ?> - <?= indo_date($data->inv_due_date); ?><br>
    <?php
    if ($data->codeunique == 1) {
        $codeunique = $data->code_unique;
    } else {
        $codeunique = 0;
    }
    $search  = array('{name}', '{noservices}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
    $replace = array($data->name, $customer['no_services'], indo_month($data->month), $data->year, indo_month($data->month) . ' ' . $data->year, indo_date($data->inv_due_date), indo_currency($data->amount - $data->disc_coupon + $codeunique), $company['company_name'], $company['sub_name'], base_url(), '');
    $subject = $other['body_wa'];
    $message = str_replace($search, $replace, $subject);

    $bot = $this->db->get('bot_telegram')->row_array();
    $tokens = $bot['token']; // token bot
    $owner = $bot['id_telegram_owner'];
    $tagihan = indo_currency($data->amount - $data->disc_coupon + $codeunique);
    $duedate = indo_date($data->inv_due_date);
    $wa = 'https://api.whatsapp.com/send?phone=' . indo_tlp($data->no_wa) . '&text=' . $message;
    $sendmessage = [
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => '📤 Kirim Tagihan', 'url' => $wa],
                    // ['text' => '👁 Buka Invoice', 'url' => base_url('bill/detail/' . $invoice['invoice'])],
                ]
            ]
        ]),
        'resize_keyboard' => true,
        'parse_mode' => 'html',
        'text' => "<b>Info Jatuh Tempo $duedate</b> \nNama Pelanggan : $data->name\nNo Layanan : $data->no_services\nTagihan : $tagihan",
        'chat_id' => $owner
    ];
    file_get_contents("https://api.telegram.org/bot$tokens/sendMessage?" . http_build_query($sendmessage));

    ?>
<?php } ?>