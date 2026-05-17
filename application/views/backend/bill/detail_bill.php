<?php $subtotal = 0;
foreach ($services->result() as $c => $data) {
    $subtotal += (int) $data->total;
} ?>
<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr style="text-align: center;">
                <th style="text-align: center; width:20px">No</th>
                <th>Name</th>
                <th style="text-align: center; width:50px; margin: 40px auto;">Qty</th>
                <th>Price</th>
                <th>Disc</th>
                <th>Remark</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            <?php $no = 1;
            if ($services->num_rows() > 0) {
                foreach ($services->result() as $c => $data) { ?>
                    <tr>

                        <td><?= $no++ ?>.</td>
                        <td><?= $data->item_name ?> </td>
                        <td style="text-align: center"><?= $data->qty ?> </td>
                        <td style="text-align: right"><?= indo_currency($data->services_price) ?> </td>
                        <td style="text-align: right">
                            <?php if ($data->disc <= 0) { ?>
                                -
                            <?php } ?>
                            <?php if ($data->disc > 0) { ?>
                                <?= indo_currency($data->disc)  ?>
                            <?php } ?>
                        </td>
                        <td><?= $data->remark ?> </td>
                        <td style="text-align: right"><?= indo_currency($data->total) ?> </td>
                    </tr>

            <?php
                }
            } else {
                echo '<tr>
        <td colspan="9" class="text-center">Belum ada layanan yang aktif</td>
    </tr>';
            } ?>
        <tfoot>
            <?php $company = $this->db->get('company')->row_array() ?>
            <?php $customer = $this->db->get_where('customer', ['no_services' => $this->input->post('no_services')])->row_array() ?>
            <?php $discount = $this->input->post('discount') ?>

            <?php if ($customer['ppn'] == 1) { ?>
                <tr style="text-align: right">
                    <th colspan="6">Sub Total</th>
                    <th><?= indo_currency($subtotal) ?> <input type="hidden" value="<?= $subtotal ?>"></th>
                </tr>
                <tr style="text-align: right">
                    <th colspan="6">PPN <?= $company['ppn']; ?>%</th>
                    <?php $ppn =  $subtotal * ($company['ppn'] / 100) ?>
                    <th><?= indo_currency($ppn) ?> </th>
                </tr>

            <?php } ?>
            <tr style="text-align: right">
                <th colspan="6">Diskon</th>

                <th><?= indo_currency($discount) ?> </th>
            </tr>
            <tr style="text-align: right">
                <th colspan="6">Grand Total</th>
                <th><?= indo_currency($subtotal + $ppn - $discount) ?> <input type="hidden" name="grand_total" value="<?= $subtotal + $ppn - $discount ?>"></th>
            </tr>

        </tfoot>