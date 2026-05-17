<?php $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array('') ?>
<?php $pg = $this->db->get('payment_gateway')->row_array() ?>
<?php

$apiKey = $pg['api_key'];

if ($pg['mode'] == 1) {
    $url = "https://tripay.co.id/api/merchant/payment-channel"; // Production
} else {
    $url = 'https://tripay.co.id/api-sandbox/merchant/payment-channel'; // Sandbox
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_FRESH_CONNECT     => true,
    CURLOPT_URL               => $url,
    CURLOPT_RETURNTRANSFER    => true,
    CURLOPT_HEADER            => false,
    CURLOPT_HTTPHEADER        => array(
        "Authorization: Bearer " . $apiKey
    ),
    CURLOPT_FAILONERROR       => false
));

$response = curl_exec($curl);
$err = curl_error($curl);
$response = json_decode($response, true);
// curl_close($curl);
// var_dump($response['data'][0]['group']);
// echo !empty($err) ? $err : $response;

?>
<?php $this->view('messages') ?>
<div class="row">


    <div class="col-lg-4 col-sm-6 col-md-6">
        <a href="#" data-toggle="modal" data-target="#Modalgd">
            <div class="card proj-t-card">
                <div class="card-body">
                    <div class="row align-items-center mb-20">
                        <div class="col-auto">
                            <i class="ik ik-shopping-cart text-red f-30"></i>
                        </div>
                        <div class="col pl-0">
                            <h6 class="mb-5">Metode Pembayaran</h6>

                        </div>
                        <div class="container mt-3">

                            <?php foreach ($response['data'] as $data) { ?>
                                <?= $data['name']; ?> <br>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            </div>
        </a>

    </div>




</div>