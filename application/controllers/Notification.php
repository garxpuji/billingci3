<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$api = $this->db->get('payment_gateway')->row_array();
		if ($api['mode'] == 1) {
			$mode = true;
		} else {
			$mode = false;
		}
		$params = array('server_key' => $api['server_key'], 'production' => $mode);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		$this->load->model(['customer_m', 'package_m', 'services_m', 'setting_m', 'bill_m', 'income_m', 'report_m']);
	}

	public function index()
	{
		// echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result, true);
		$order_id = $result['order_id'];
		$data = [
			'status_code' => $result['status_code'],
			'status' => 'SUDAH BAYAR',
			'metode_payment' => 'Payment Gateway',
		];
		if ($result['status_code'] == 200) {
			$this->db->update('invoice', $data, array('order_id' => $order_id));
			$this->income_m->addbymidtrans($result);
			$invoice = $this->db->get_where('invoice', ['order_id' => $order_id])->row_array();
			$customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
			$rt = $this->db->get_where('router', ['id' => 1])->row_array();
			if ($rt['is_active'] == 1) {
				if ($customer['auto_isolir'] == 1) {
					if ($customer['user_mikrotik'] != '') {
						openisolir($customer['no_services'], $customer['router']);
					}
				}
			}
			$whatsapp = $this->db->get('whatsapp')->row_array();
			if ($whatsapp['is_active'] == 1) {
				$other = $this->db->get('other')->row_array();
				$company = $this->db->get('company')->row_array();
				$no = 1;
				$range = $no++ * $whatsapp['interval_message'];
				$timeex = time() + (1 * 60 * $range);
				$timeex = date('Y-m-d H:i:s', $timeex);

				$timenow = time() + (1 * 60 * $range);
				$wadateex = date('Y-m-d', $timenow);
				$watimeex = date('H:i', $timenow);
				// echo  $timeex;
				if ($whatsapp['paymentinvoice'] == 1) {
					$other = $this->db->get('other')->row_array();
					$company = $this->db->get('company')->row_array();
					$username = $whatsapp['username'];
					$APIkey = $whatsapp['api_key'];
					$target = indo_tlp($customer['no_wa']);
					echo $target, $timeex;
					$nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);
					$search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
					$replace = array($customer['name'], $customer['no_services'],  $customer['email'], $invoice['invoice'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $invoice['inv_due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
					$subject = $other['thanks_wa'];
					$message = str_replace($search, $replace, $subject);
					$target = indo_tlp($customer['no_wa']);
					sendmsgbill($target, $message,  $invoice['invoice']);
				}
			}
		}

		error_log(print_r($result, TRUE));
	}
}
