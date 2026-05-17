<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mikhmon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['setting_m', 'customer_m', 'services_m', 'bill_m', 'mikrotik_m']);
    }

    private function conn()
    {
        $router = $this->db->get('router')->row_array();
        $user = $router['username'];
        $ip = $router['ip_address'];
        $pass = $router['password'];
        $port = $router['port'];
        $API = new Mikweb();
        $API->connect($ip, $user, $pass, $port);
        return $API;
    }
    public function index()
    {
    }
    public function report()
    {
        $conn = $this->conn();
        $thisD = date("d");
        $thisM = strtolower(date("M"));
        $thisY = date("Y");
        if (strlen($thisD) == 1) {
            $thisD = "0" . $thisD;
        } else {
            $thisD = $thisD;
        }

        $today = $thisM . "/" . $thisD . "/" . $thisY;
        $idbl = $thisM . $thisY;
        $result = $conn->comm("/system/script/print", array(
            "?owner" => "$idbl",
        ));
        $TotalVcrMonth = count($result);
        // var_dump($result);
        // die;
        foreach ($result as $row) {
            if ((explode("-|-", $row['name'])[0]) == $today) {
                $reportToday += explode("-|-", $row['name'])[3];
                $totalVcrToday += count($row['source']);
            }
            $reportMonth += explode("-|-", $row['name'])[3];
        }

        if ($totalVcrToday == '') {
            $totalVcrToday = 0;
        }
        if ($reportToday == '') {
            $reportToday = 0;
        }
        if ($TotalVcrMonth == '') {
            $TotalVcrMonth = 0;
        }
        if ($reportMonth == '') {
            $reportMonth = 0;
        }


        var_dump($reportToday);
        var_dump($reportMonth);
        var_dump($totalVcrToday);
        var_dump($TotalVcrMonth);
        // var_dump($);
        // echo (json_encode($result));
        // echo (json_encode($dincome));
    }
}
