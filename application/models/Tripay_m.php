<?php defined('BASEPATH') or exit('No direct script access allowed');
class Tripay_m extends CI_Model
{


    public function updatebill($invoice)
    {
        $updateinvoice = [
            'status' => 'SUDAH BAYAR',
        ];
        $this->db->where('x_external_id', $invoice['x_external_id']);
        $this->db->update('invoice', $updateinvoice);
    }
}
