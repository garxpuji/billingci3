<?php defined('BASEPATH') or exit('No direct script access allowed');

class Renew extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $json = file_get_contents("php://input");

        //convert the string of data to an array
        $data = json_decode($json, true);

        //output the array in the response of the curl request


        if ($data['token'] == 'mabdussalam') {
            $this->db->set('expired', $data['new_date']);
            $this->db->update('company');
        }
        if ($this->db->affected_rows() > 0) {
            $dataa = [
                'message' => 'success',
            ];
            echo json_encode($dataa);
        }
    }

    public function test()
    {
        // API URL
        $url = 'http://localhost/mywifi-c/renew';

        // Create a new cURL resource

        $data = array(
            "token" => "mabdussalam",
            "new_date" => "2021-08-21",
        );

        $postdata = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result);
    }
}
