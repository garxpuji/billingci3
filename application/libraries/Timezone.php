
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timezone
{
    function __construct()
    {
        $ci = get_instance();
        $company = $ci->db->get('company')->row_array();
        date_default_timezone_set($company['timezone']);
    }
}
