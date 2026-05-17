<?php defined('BASEPATH') or exit('No direct script access allowed');

class Setting_m extends CI_Model
{
    public function getCompany($id = null)
    {
        $this->db->select('*');
        $this->db->from('company');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function getBank($id = null)
    {
        $this->db->select('*');
        $this->db->from('bank');
        if ($id != null) {
            $this->db->where('bank_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function addBank($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'no_rek' => $post['no_rek'],
            'owner' => htmlspecialchars($post['owner']),
        ];
        $this->db->insert('bank', $params);
    }
    public function editBank($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'no_rek' => $post['no_rek'],
            'owner' => htmlspecialchars($post['owner']),
        ];
        $this->db->where('bank_id',  $post['bank_id']);
        $this->db->update('bank', $params);
    }
    public function deleteBank($bank_id)
    {
        $this->db->where('bank_id', $bank_id);
        $this->db->delete('bank');
    }
    public function editCompany($post)
    {

        $params = [
            'company_name' => htmlspecialchars($post['company_name']),
            'sub_name' => htmlspecialchars($post['sub_name']),
            'email' => $post['email'],
            'watermark' => $post['watermark'],
            'apps_name' => $post['apps_name'],
            'facebook' => $post['fb'],
            'instagram' => $post['ig'],
            'whatsapp' => $post['hp'],
            'address' => $post['address'],
            'admin_fee' => $post['admin_fee'],

            'ppn' => $post['ppn'],
            'owner' => $post['owner'],
            'longitude' => $post['long'],
            'latitude' => $post['lat'],
            'phonecode' => $post['phonecode'],
            'speedtest' => $post['speedtest'],
            'tawk' => $post['tawk'],
            'timezone' => $post['timezone'],
        ];

        if (!empty($_FILES['logo']['name'])) {
            $params['logo'] = $post['logo'];
        }
        $this->db->where('id', $post['id']);
        $this->db->update('company', $params);
    }

    public function editEmail($post)
    {
        $params = [
            'name' => htmlspecialchars($post['name']),
            'port' => $post['port'],
            'protocol' => htmlspecialchars($post['protocol']),
            'email' => htmlspecialchars($post['email']),
            'password' => htmlspecialchars($post['password']),
            'host' => htmlspecialchars($post['host']),
            // 'send_payment' => htmlspecialchars($post['send_payment']),
            'send_verify' => htmlspecialchars($post['send_verify']),
            'forgot_password' => htmlspecialchars($post['forgot_password']),
        ];
        $this->db->where('id',  $post['id']);
        $this->db->update('email', $params);
    }
    public function editOther($post)
    {
        $params = [
            'say_wa' => htmlspecialchars($post['say_wa']),
            'body_wa' => htmlspecialchars($post['body_wa']),
            'thanks_wa' => htmlspecialchars($post['thanks_wa']),
            'code_unique' => $post['code_unique'],
            'text_code_unique' => $post['text_code_unique'],
            'remark_invoice' => $post['remark_invoice'],
        ];
        $this->db->where('id',  $post['id']);
        $this->db->update('other', $params);
    }

    public function editsmsgateway($post)
    {
        $params = [
            'sms_name' => htmlspecialchars($post['name']),
            'sms_token' => htmlspecialchars($post['token']),
            'sms_user' => htmlspecialchars($post['user']),
            'sms_password' => htmlspecialchars($post['password']),
        ];
        $this->db->where('sms_id',  $post['sms_id']);
        $this->db->update('sms_gateway', $params);
    }

    public function editRouter($post)
    {
        $params = [
            'ip_address' => htmlspecialchars($post['ip_address']),
            'username' => htmlspecialchars($post['username']),
            'password' => htmlspecialchars($post['password']),
            'port' => htmlspecialchars($post['port']),
        ];
        $this->db->where('id',  $post['id']);
        $this->db->update('router', $params);
    }
    public function editbottelegram($post)

    {

        $params = [
            'token' => htmlspecialchars($post['token']),
            'username_bot' => htmlspecialchars($post['username_bot']),
            'username_owner' => htmlspecialchars($post['username_owner']),
            'id_group_teknisi' => htmlspecialchars($post['id_group_teknisi']),
            'id_telegram_owner' => htmlspecialchars($post['id_telegram_owner']),
        ];
        $this->db->where('id',  $post['id']);
        $this->db->update('bot_telegram', $params);
    }
}
