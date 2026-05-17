<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mootaa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->model(['customer_m', 'package_m', 'services_m', 'setting_m', 'bill_m', 'income_m', 'mikrotik_m']);
        $this->load->library('moota', ['token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdkZTRkODAxMjNmY2Q1ZmQwNDY1ZjE5MTkwNDhiZGRkOGNlYWFmMTA0YjU2MGU4MzE4YWE0YmExOTliNjIxN2NlMDU5YjU5NDQ3NGU3NDBjIiwiaWF0IjoxNjQ5MjY0MTI0LjIzMDg5NiwibmJmIjoxNjQ5MjY0MTI0LjIzMDg5OSwiZXhwIjoxNjgwODAwMTI0LjIyOTIzNiwic3ViIjoiMjMyODciLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.BDCDBqrSPW8buHRanJSOKKK0lpKT5PkPL4wNNKkSJO1TMfoetTGQ9M5s6PIkLzS4UjhNvDGHdbhDMoTYdQEvi4ljWpmzo52j6RK10vcIA-Uwi-mSZYofg8mctbSJrdTyXubX-EEmyNgqAsSExWYl55F878G3O-S408Gfaqb9gaSNn1OnsE3a1jlmv39ibUSFbawDsaAOjgK-p3b80-q61-NsUT9xF7CP8ihWENIyKB6u96r7gH3-QjFUgtZuJEMPYgfRjZ4PWQaG2rBj2IdZDqs5BDvhesZDWhiEaLBW9g5jpD4PQHd9kbXN4M7FbOehDyQPX-hoAwWKrSmdo93vjo6GCLn5-wd3kz4MAkhGUpI27vpQfrbAEGlzR1VERERnF7cNpLjG1sP4bsbYtuM6KXyeA2V72XkcNUR1tXzGGsOE8c_Wq03yc42l9vXVJG9u90uepuSrcH8kJbJB66p9AZd4pCeVf3FnFe0ehtR8-N_92vZYhpZJnmNPCG-cFQcxSkdcOHlDPFxvDXaYJhmsTVx3XoWXcqYA7QbnwgA0JfCTG5N6CnxOagj3sAySXi-rVFvNuL21OWUgiCyVhDPQmxBZcqJAjmj8kaKJH82csr-c_eoPbc0x7Sbj2Rdf8MPAM40yUcHdu7qw5aAZ5bBCXpIkSB3etQWjBxHgR8CdbuI']);
    }
    public function index()
    {
        is_logged_in();
        $data['title'] = 'Moota';
        $data['tes'] = json_encode($this->moota->get('bank'));
        $test = json_encode($this->moota->get('bank'));
        // var_dump($test);
        // die;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['company'] = $this->db->get('company')->row_array();

        // $this->template->load('backend', 'backend/moota/moota', $data);
        echo $test;
    }
}
