<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vpn extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $curl = curl_init();
        $signature = hash_hmac('sha256', 'tunnel_list', '5tFuc-5xqyB-I5RNk-8kkuB4f');

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://konekter.us/reseller-api/tunnellist',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',

            CURLOPT_POSTFIELDS => 'signature=' . $signature . "&request_mode=tunnel_list",
            CURLOPT_HTTPHEADER => array(
                'Authorization: 3aHzQbO6m6cjkiOfSAeP8emd9'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    public function update()
    {
        $curl = curl_init();
        $signature = hash_hmac('sha256', 'update_tunnel', '5tFuc-5xqyB-I5RNk-8kkuB4f');
        $data = [
            'user_tunnel' => 'gingin',
            'password_tunnel' => 'gingin',
            'port_winbox' => '8291',
            'port_api' => '8728',
            'port_webfig' => '80',
            'comment' => 'domain',
        ];
        // var_dump(json_encode($data));
        // die;
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://konekter.us/reseller-api/updatetunnel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'signature=' . $signature . "&request_mode=update_tunnel&data=" . json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 3aHzQbO6m6cjkiOfSAeP8emd9'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function kick()
    {
        $curl = curl_init();
        $signature = hash_hmac('sha256', 'kick_tunnel', '5tFuc-5xqyB-I5RNk-8kkuB4f');
        $data = [
            'user_tunnel' => 'gingin',
            'comment' => 'domaasin',

        ];
        // var_dump(json_encode($data));
        // die;
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://konekter.us/reseller-api/kicktunnel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'signature=' . $signature . "&request_mode=kick_tunnel&data=" . json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 3aHzQbO6m6cjkiOfSAeP8emd9'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function saldo()
    {
        $curl = curl_init();
        $signature = hash_hmac('sha256', 'saldo', '5tFuc-5xqyB-I5RNk-8kkuB4f');

        // var_dump(json_encode($data));
        // die;
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://konekter.us/reseller-api/saldo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'signature=' . $signature . "&request_mode=saldo",
            CURLOPT_HTTPHEADER => array(
                'Authorization: 3aHzQbO6m6cjkiOfSAeP8emd9'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
