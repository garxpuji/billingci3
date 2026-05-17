<?php defined('BASEPATH') or exit('No direct script access allowed');
class Payment_m extends CI_Model
{
    public function edit($post)
    {
        if ($post['vendor'] == 'Midtrans') {
            $params = [
                'is_active' => $post['is_active'],
                'mode' => $post['mode'],
                'vendor' => $post['vendor'],
                'server_key' => $post['server_key'],
                'client_key' => $post['client_key'],
                'expired' => $post['expired'],
                'admin_fee' => $post['admin_fee'],
                'bca_va' => $post['bca_va'],
                'bri_va' => $post['bri_va'],
                'bni_va' => $post['bni_va'],
                'permata_va' => $post['permata_va'],
                'mandiri_va' => $post['mandiri_va'],
                'gopay' => $post['gopay'],
                'shopeepay' => $post['shopeepay'],
                'indomaret' => $post['indomaret'],
                'alfamart' => $post['alfamart'],
            ];
        }
        if ($post['vendor'] == 'Xendit') {
            $params = [
                'is_active' => $post['is_active'],
                'vendor' => $post['vendor'],
                'api_key' => $post['api_key'],
                'expired' => $post['expired'],
                'admin_fee' => $post['admin_fee'],
                'va' => $post['va'],
                'kodemerchant' => $post['code_merchant'],
                'ewallet' => $post['ewallet'],
                'retail' => $post['retail'],
                'qrcode' => $post['qrcode'],
            ];
        }
        if ($post['vendor'] == 'Duitku') {
            $params = [
                'is_active' => $post['is_active'],
                'mode' => $post['modeduitku'],
                'vendor' => $post['vendor'],
                'api_key' => $post['api_key'],
                'kodemerchant' => $post['code_merchant'],
                'expired' => $post['expired'],
                'admin_fee' => $post['admin_fee'],
                'bni_va' => $post['bniva'],
                'permata_va' => $post['permatava'],
                'mandiri_va' => $post['mandiriva'],
                'cimb_va' => $post['cimbva'],
                'mybank_va' => $post['mybankva'],
                // 'ovo' => $post['ovo'],
                'retail' => $post['retailduitku'],
                'dana' => $post['danaduitku'],
                'shopeepay' => $post['shopeepayduitku'],
                'linkaja' => $post['linkajaduitku'],
            ];
        }
        if ($post['vendor'] == 'Tripay') {
            $params = [
                'is_active' => $post['is_active'],
                'mode' => $post['modetripay'],
                'vendor' => $post['vendor'],
                'api_key' => $post['api_keytripay'],
                'server_key' => $post['server_keytripay'],
                'kodemerchant' => $post['code_merchanttripay'],
                'expired' => $post['expired'],
                'admin_fee' => $post['admin_fee'],
                'bni_va' => $post['bnivatripay'],
                'bca_va' => $post['bcavatripay'],
                'permata_va' => $post['permatavatripay'],
                'mandiri_va' => $post['mandirivatripay'],
                'sinarmas_va' => $post['sinarmasvatripay'],
                'muamalat_va' => $post['muamalatvatripay'],
                'bri_va' => $post['brivatripay'],
                'qrcode' => $post['qrcodetripay'],
                'cimb_va' => $post['cimbvatripay'],
                'mybank_va' => $post['mybankvatripay'],
                'alfamart' => $post['alfamarttripay'],
                'alfamidi' => $post['alfamiditripay'],
            ];
        }

        $this->db->where('id', $post['payment_id']);
        $this->db->update('payment_gateway', $params);
    }
}
