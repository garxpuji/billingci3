<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bcava extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $options = array(
            'curl_options'  => array(
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSLVERSION => 6,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 60
            ),
            'scheme'        => 'https',
            'port'          => 9443,
            'host'          => 'devapi.klikbca.com',
            'timezone'      => 'Asia/Jakarta',
            'timeout'       => 30,
            'debug'         => true,
            'development'   => true
        );

        // Setting default timezone Anda
        \Bca\BcaHttp::setTimeZone('Asia/Jakarta');

        // ATAU

        // \Bca\BcaHttp::setTimeZone('Asia/Singapore');

        $corp_id = "uatcorp001";
        $client_key = "e305a76a-78d3-4f92-b734-c23ae58c97d8";
        $client_secret = "04031743-9645-4bc7-84e5-c8943618c2c8";
        $apikey = "a16c5bb4-49d1-4a12-9194-db3df367d893";
        $secret = "2ad77de8-7f0e-4379-bce5-71d70529a611";

        $bca = new \Bca\BcaHttp($corp_id, $client_key, $client_secret, $apikey, $secret, $options);
        $response = $bca->httpAuth();

        // Cek hasil response berhasil atau tidak
        // echo json_encode($response);

        $response = json_encode($response, true);
        $response = json_decode($response, true);
        if ($response['code'] == 200) {
            // echo  $response['code'];
            $token = $response['body']['access_token'];
            // echo $token;
            // get account
            // $arrayAccNumber = array('0611104625', '613106704', '1111111111');

            // $respons = $bca->getBalanceInfo($token, $arrayAccNumber);

            // // Cek hasil response berhasil atau tidak
            // echo json_encode($respons);

            // get atm 

            $respons = $bca->getAtmLocation($token, 6.1900718, 106.797190, 11, 500);

            // Cek hasil response berhasil atau tidak
            echo json_encode($respons);
        } else {
            echo 'Gagal Login <br>';
            echo  $response['body']['ErrorMessage']['Indonesian'];
        }
    }
}
