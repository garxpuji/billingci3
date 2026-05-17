<?php
ob_start();
if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Snap extends CI_Controller
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
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('checkout_snap');
	}

	public function token()
	{
		$api = $this->db->get('payment_gateway')->row_array();
		$tagihan = floor($this->input->post('tagihan'));
		$namapelanggan = $this->input->post('namapelanggan');
		$no_services = $this->input->post('no_services');
		$periode = $this->input->post('periode');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$biayaadmin = $this->input->post('biayaadmin');
		$invoice = $this->input->post('invoice');
		$orderid =  substr(intval(rand()), 0, 3) . '-' . $invoice;
		// Required
		$transaction_details = array(
			'order_id' => $orderid,
			'gross_amount' => $tagihan + $biayaadmin, // no decimal allowed for creditcard

		);

		// Optional
		$item1_details = array(
			'price' => $tagihan,
			'quantity' => 1,
			'name' => 'Tagihan ' . $no_services . ' Periode ' . $periode
		);
		$item2_details = array(
			'price' => $biayaadmin,
			'quantity' => 1,
			'name' => 'Biaya Admin'
		);

		// Optional
		$item_details = array($item1_details, $item2_details);

		// Optional
		$shipping_address = array(

			'address'       => $address,

		);
		// Optional
		$customer_details = array(
			'first_name'    => $namapelanggan,
			'email'         => $email,
			'phone'         => $phone,
			'shipping_address' => $shipping_address
		);

		$credit_card['secure'] = true;
		$time = time();
		$api = $this->db->get('payment_gateway')->row_array();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'day',
			'duration'  => $api['expired']
		);

		$row = array();
		if ($api['mandiri_va'] == 1) {
			$row[] = "echannel";
		}
		if ($api['bca_va'] == 1) {
			$row[] = "bca_va";
		}
		if ($api['bri_va'] == 1) {
			$row[] = "bri_va";
		}
		if ($api['bni_va'] == 1) {
			$row[] = "bni_va";
		}
		if ($api['permata_va'] == 1) {
			$row[] = "permata_va";
		}

		if ($api['indomaret'] == 1) {
			$row[] = "indomaret";
		}
		if ($api['alfamart'] == 1) {
			$row[] = "alfamart";
		}
		if ($api['gopay'] == 1) {
			$row[] = "gopay";
		}
		if ($api['shopeepay'] == 1) {
			$row[] = "shopeepay";
		}
		$enable_payments = $row;

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			// 'enabled_payments' 	=> $enable_payments,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		// print_r($snapToken);

		// var_dump($result);
		error_log($snapToken);
		echo $snapToken;

		$data = [
			'order_id' => $orderid,
			'token' => $snapToken,
			'transaction_time' => date('Y-m-d H:i:s'),
			'expired' => $api['expired'],
		];
		$this->db->where('invoice', $invoice);
		$this->db->update('invoice', $data);
	}
	public function finish()
	{
		$result = json_decode($this->input->post('result_data'), true);
		$invoice = $this->db->get_where('invoice', ['invoice' => $this->input->post('invoice')])->row_array();
		$api = $this->db->get('payment_gateway')->row_array();
		if ($api['mode'] == 1) {
			$link = 'https://app.midtrans.com/snap/v2/vtweb/';
		} else {
			$link = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';
		}
		$data = [
			'order_id' => $result['order_id'],
			'status_code' => $result['status_code'],

			'bank' => $result['va_numbers']['0']['bank'],
			'pdf_url' => $result['pdf_url'],
			'admin_fee' => $api['admin_fee'],

			'va_number' => $result['va_numbers']['0']['va_number'],
		];
		$this->db->where('invoice', $invoice);
		$this->db->update('invoice', $data);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success-sweet', '<h3>Checkout berhasil, silahkan lakukan pembayaran</h3> <a class="btn btn-success" target="blank" href="' . $link .  $invoice['token'] . '">Cara Pembayaran</a>');
		}
		echo "<script>window.location='" . site_url('member') . "'; </script>";
	}
}
