<?php $no = 1;
foreach ($bill as $r => $data) { ?>
    <?= $no++; ?>
    <?= $data->name ?> - <?= $data->no_services; ?> - <?= $data->invoice; ?><br>
    <?php
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
    } ?>
<?php } ?>