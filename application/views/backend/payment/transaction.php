<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>
<?php $this->view('messages') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Reference</th>
                        <th>Merchant_ref</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($transaction as $r => $data) { ?>
                        <tr>
                            <!-- Update Invoice -->
                            <?php if ($data['status'] == 'PAID') { ?>
                                <?php $inv = explode("-", $data['merchant_ref']);
                                // echo $inv['1'];
                                $invoice = $this->db->get_where('invoice', ['invoice' => $inv[1], 'status' => 'BELUM BAYAR'])->row_array();
                                $Customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
                                if ($Customer['name'] == $data['customer_name']) {
                                    if ($invoice['status'] == 'BELUM BAYAR') {
                                        $updateinvoice = [
                                            'status' => 'SUDAH BAYAR',
                                            'date_payment' => $data['paid_at'],
                                            'metode_payment' => 'Payment Gateway',
                                        ];
                                        $this->db->where('invoice', $inv['1']);
                                        $this->db->update('invoice', $updateinvoice);
                                        $addincome = [
                                            'nominal' => $data['amount'],
                                            'date_payment' => date('Y-m-d', $data['paid_at']),
                                            'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice['no_services'] . ' ' . 'a/n' . ' ' .  $Customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice['month']) . ' ' . $invoice['year'] . ' by Tripay ' . $data['payment_method'],
                                            'invoice_id' => $inv['1'],
                                            'category' => 1,
                                            'create_by' => 0,
                                            'no_services' => $invoice['no_services'],
                                            'mode_payment' => 'Payment Gateway',
                                            'created' => time()
                                        ];
                                        $this->db->insert('income', $addincome);
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
                                            if ($whatsapp['paymentinvoice'] == 1) {
                                                $customer = $this->db->get_where('customer', ['no_services' => $invoice['no_services']])->row_array();
                                                $other = $this->db->get('other')->row_array();
                                                $company = $this->db->get('company')->row_array();
                                                if ($customer['codeunique'] == 1) {
                                                    $codeunique = $invoice['code_unique'];
                                                } else {
                                                    $codeunique = 0;
                                                }
                                                $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon'] + $codeunique);
                                                $search  = array('{name}', '{noservices}', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');
                                                $replace = array($customer['name'], $customer['no_services'], $customer['email'], $inv, indo_month($invoice['month']), $invoice['year'], indo_month($invoice['month']) . ' ' . $invoice['year'], indo_date($invoice['inv_due_date']), $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');
                                                $subject = $other['thanks_wa'];
                                                $target = indo_tlp($customer['no_wa']);
                                                $message = str_replace($search, $replace, $subject);
                                                sendmsgpaid($target, $message, $inv);
                                            }
                                        }
                                    }
                                }

                                ?>

                            <?php } ?>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $data['customer_name'] ?></td>
                            <td><?= $data['reference'] ?></td>
                            <td><?= $data['merchant_ref'] ?></td>
                            <td><?= indo_currency($data['amount']) ?></td>
                            <td><?= $data['status'] ?></td>
                            <td><?= $data['paid_at'] ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>