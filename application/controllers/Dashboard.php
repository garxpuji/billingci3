<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['income_m', 'expenditure_m', 'bill_m', 'logs_m', 'customer_m', 'package_m', 'help_m', 'coverage_m', 'services_m', 'mikrotik_m']);
    }
    private function _menu()
    {
        $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();

        return $menu;
    }
    private function _role()
    {

        $role_id = $this->session->userdata('role_id');
        $role = $this->db->get_where('role_management', ['role_id' => $role_id])->row_array();
        if ($role == 0) {
            $params = [
                'role_id' => $this->session->userdata('role_id'),
            ];
            $this->db->insert('role_management', $params);
        }
        return $role;
    }
    private function _coverage()
    {
        $role = $this->_role();
        if ($role['role_id'] != 1 && $role['coverage_operator'] == 1) {
            $operator = $this->db->get_where('cover_operator', ['operator' => $this->session->userdata('id'), 'role_id' => $this->session->userdata('role_id')])->result();
            if ($this->session->userdata('role_id') != 1 && count($operator) == 0) {
                $this->session->set_flashdata('error', 'Tidak ada coverage untuk akun anda');

                $row[] = '';
            }
            foreach ($operator as $roww) {
                $row[] = $roww->coverage_id;
            };
        } else {
            $row = '';
        }

        return $row;
    }
    public function index()
    {



        $role = $this->_role();
        // var_dump($role);
        // die;

        $cover = $this->_coverage();
        if ($role['role_id'] != 1 && $role['coverage_operator'] == 1) {
            $data['coverage'] = $this->coverage_m->getCoverage($cover)->num_rows();
            $data['customer'] = $this->customer_m->getCustomerAll($cover)->result();
        } else {
            $data['coverage'] = $this->coverage_m->getCoverage()->num_rows();
            $data['customer'] = $this->customer_m->getCustomerAll()->result();
        }
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['logs'] = $this->logs_m->getdashboard()->result();
        $data['incomeJan'] = $this->income_m->getIncomeJan()->result();
        $data['incomeFeb'] = $this->income_m->getIncomeFeb()->result();
        $data['incomeMar'] = $this->income_m->getIncomeMar()->result();
        $data['incomeApr'] = $this->income_m->getIncomeApr()->result();
        $data['incomeMay'] = $this->income_m->getIncomeMay()->result();
        $data['incomeJun'] = $this->income_m->getIncomeJun()->result();
        $data['incomeJul'] = $this->income_m->getIncomeJul()->result();
        $data['incomeAug'] = $this->income_m->getIncomeAug()->result();
        $data['incomeSep'] = $this->income_m->getIncomeSep()->result();
        $data['incomeOct'] = $this->income_m->getIncomeOct()->result();
        $data['incomeNov'] = $this->income_m->getIncomeNov()->result();
        $data['incomeDec'] = $this->income_m->getIncomeDec()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/dashboard', $data);
    }
    public function getcustomer()
    {
        $role = $this->_role();
        $cover = $this->_coverage();
        if ($role['role_id'] != 1 && $role['coverage_operator'] == 1) {
            $data = [
                'customeractive' => indo_currency($this->customer_m->getCustomerActive($cover)->num_rows()),
                'customernonactive' => indo_currency($this->customer_m->getCustomerNonActive($cover)->num_rows()),
                'customerwaiting' => indo_currency($this->customer_m->getCustomerWait($cover)->num_rows()),
                'customerfree' => indo_currency($this->customer_m->getCustomerFree($cover)->num_rows()),
                'customerisolir' => indo_currency($this->customer_m->getCustomerIso($cover)->num_rows()),
                'customerduedate' => indo_currency($this->bill_m->getInvoiceduedate($cover)->num_rows()),
            ];
        } else {
            $data = [
                'customeractive' => indo_currency($this->customer_m->getCustomerActive()->num_rows()),
                'customernonactive' => indo_currency($this->customer_m->getCustomerNonActive()->num_rows()),
                'customerwaiting' => indo_currency($this->customer_m->getCustomerWait()->num_rows()),
                'customerfree' => indo_currency($this->customer_m->getCustomerFree()->num_rows()),
                'customerisolir' => indo_currency($this->customer_m->getCustomerIso()->num_rows()),
                'customerduedate' => indo_currency($this->bill_m->getInvoiceduedate()->num_rows()),
            ];
        }

        echo json_encode($data);
    }
    public function getincome()
    {
        $incomethismonth =  $this->income_m->getIncomeThisMonth()->result();
        $IncomeTotalThisMonth = 0;
        foreach ($incomethismonth as $c => $data) {
            $IncomeTotalThisMonth += $data->nominal;
        }
        // Today
        $today = $this->income_m->gettoday()->result();
        $incometoday = 0;
        foreach ($today as $c => $data) {
            $incometoday += $data->nominal;
        }
        // Yesterday
        $yesterday = $this->income_m->getyesterday()->result();
        $incomeyesterday = 0;
        foreach ($yesterday as $c => $data) {
            $incomeyesterday += $data->nominal;
        }

        // Lastmont
        $lastmonth = $this->income_m->getIncomeLastMonth()->result();
        $incomelastmonth = 0;
        foreach ($lastmonth as $c => $data) {
            $incomelastmonth += $data->nominal;
        }

        $expenditurethismonth =  $this->expenditure_m->getexpenditureThisMonth()->result();
        $expenditureTotalThisMonth = 0;
        foreach ($expenditurethismonth as $c => $data) {
            $expenditureTotalThisMonth += $data->nominal;
        }

        $data = [
            'incomethismonth' => indo_currency($IncomeTotalThisMonth),
            'incomelastmonth' => indo_currency($incomelastmonth),
            'incometoday' => indo_currency($incometoday),
            'incomeyesterday' => indo_currency($incomeyesterday),
            'difference' => indo_currency($IncomeTotalThisMonth - $expenditureTotalThisMonth),

        ];
        echo json_encode($data);
    }
    public function getexpenditure()
    {
        $expenditurethismonth =  $this->expenditure_m->getexpenditureThisMonth()->result();
        $expenditureTotalThisMonth = 0;
        foreach ($expenditurethismonth as $c => $data) {
            $expenditureTotalThisMonth += $data->nominal;
        }
        // Today
        $today = $this->expenditure_m->gettoday()->result();
        $expendituretoday = 0;
        foreach ($today as $c => $data) {
            $expendituretoday += $data->nominal;
        }
        // Yesterday
        $yesterday = $this->expenditure_m->getyesterday()->result();
        $expenditureyesterday = 0;
        foreach ($yesterday as $c => $data) {
            $expenditureyesterday += $data->nominal;
        }

        // Lastmont
        $lastmonth = $this->expenditure_m->getLastMonth()->result();
        $expenditurelastmonth = 0;
        foreach ($lastmonth as $c => $data) {
            $expenditurelastmonth += $data->nominal;
        }
        $data = [
            'expenditurethismonth' => indo_currency($expenditureTotalThisMonth),
            'expenditurelastmonth' => indo_currency($expenditurelastmonth),
            'expendituretoday' => indo_currency($expendituretoday),
            'expenditureyesterday' => indo_currency($expenditureyesterday),

        ];
        echo json_encode($data);
    }

    public function getbill()
    {

        $role = $this->_role();
        $cover = $this->_coverage();
        if ($role['role_id'] != 1 && $role['coverage_operator'] == 1) {
            $unpaid = $this->bill_m->getInvoiceUp($cover)->num_rows();
            if ($unpaid < 12000) {
                $billunpaid =  $this->bill_m->getInvoiceUp($cover)->result();
                $totalamount = 0;
                foreach ($billunpaid  as  $data) {
                    $totalamount += $data->amount;
                }
                $totaldisc = 0;
                foreach ($billunpaid  as  $data) {
                    $totaldisc += $data->disc_coupon;
                }
            }
        } else {
            $unpaid = $this->db->get_where('invoice', ['status' => 'BELUM BAYAR'])->num_rows();
            if ($unpaid < 12000) {
                $billunpaid =  $this->bill_m->getInvoiceUp()->result();
                $totalamount = 0;
                foreach ($billunpaid  as  $data) {
                    $totalamount += $data->amount;
                }
                $totaldisc = 0;
                foreach ($billunpaid  as  $data) {
                    $totaldisc += $data->disc_coupon;
                }
            }
        }
        if ($unpaid >= 12000) {
            $grandtotal = '∞';
        } else {
            $grandtotal = indo_currency($totalamount - $totaldisc);
        }
        $data = [
            'pendingpayment' => indo_currency($unpaid),
            'amountpendingpayment' => $grandtotal,
        ];
        echo json_encode($data);
    }

    public function fixbill()
    {

        $month = date('m');
        $year = date('Y');
        $bill =  $this->bill_m->getInvoicemonthyear($month, $year)->result();
        foreach ($bill as $r => $data) {
            $inv = $this->db->get_where('invoice', ['invoice' => $data->invoice])->row_array();

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
                            'invoice_id' => $data->invoice,
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
            echo $data->name;
        }
    }
    public function fixbillamount()
    {


        $bill =  $this->bill_m->getInvoiceamount()->result();
        foreach ($bill as $r => $data) {
            $inv = $this->db->get_where('invoice', ['invoice' => $data->invoice])->row_array();
            $month =  $inv['month'];
            $year = $inv['year'];
            $no_services = $inv['no_services'];
            $query = "SELECT *, `invoice_detail`.`price` as `detail_price`
                    FROM `invoice_detail`
                                  WHERE `invoice_detail`.`d_month` =  $month and
                       `invoice_detail`.`d_year` =  $year and
                       `invoice_detail`.`d_no_services` =  $no_services";
            $detailinvoice = $this->db->query($query)->result();
            $amountt = 0;
            foreach ($detailinvoice as $detail) {
                $amountt += (int) $detail->total;
            }
            if ($inv['i_ppn'] > 0) {
                $ppn = $amountt * ($inv['i_ppn'] / 100);
                $amount =  $amountt + $ppn;
            } else {
                $amount =  $amountt;
            }
            $this->db->set('amount', $amount);
            $this->db->where('invoice', $inv['invoice']);
            $this->db->update('invoice');
        }
    }
    public function duedate()
    {
        $bill = $this->bill_m->getInvoiceduedate();
        $no = 1;
        foreach ($bill->result() as $data) {
            if (strlen($data->due_date) == 1) {
                $due_date = $data->due_date;
            } else {
                $due_date = $data->due_date;
            }
            $cekduedate = $data->year . '-' . $data->month . '-' . $due_date;
            if (date('Y-m-d') >= $cekduedate) {

                $row = $no++;
            }
        }

        $data = [
            'countduedate' => $row,
        ];
        echo json_encode($data);
    }

    public function getpendingincome()
    {
        $query = "SELECT  `invoice`.`status`, 
        `invoice`.`no_services`,
        `invoice`.`month`,
        `invoice`.`year`,
        `invoice_detail`.`d_no_services`,
        `invoice_detail`.`d_month`,
        `invoice_detail`.`d_year`,
        `invoice_detail`.`invoice_id`,
        `invoice_detail`.`total`
                                FROM `invoice` 
                                JOIN `invoice_detail` ON `invoice`.`no_services`=`invoice_detail`.`d_no_services`
                                and `invoice`.`month`=`invoice_detail`.`d_month`
                                and `invoice`.`year`=`invoice_detail`.`d_year`
                                    WHERE   `invoice`.`status_income` = 'pending'";
        $TotalpendingPayment = $this->db->query($query)->result();

        $Totalpending = 0;
        foreach ($TotalpendingPayment as $c => $data) {
            $Totalpending += $data->total;
        }


        $data = [
            'countpendingincome' => $this->db->get_where('invoice', ['status_income' => 'pending'])->num_rows(),
            'amountpendingincome' => indo_currency($Totalpending),
        ];
        echo json_encode($data);
    }

    public function createbill()
    {
        $other = $this->db->get('other')->row_array();
        $month = date('m');
        $year = date('Y');
        // createbill
        if ($other['sch_createbill'] == 1) {
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


                            $other = $this->db->get('other')->row_array();
                            $company = $this->db->get('company')->row_array();
                            $no = 1;
                            foreach ($no_services as $wa) {
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
                            }
                        }
                    }
                }
            }
        }
    }
}
