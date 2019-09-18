<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->authenticate->check();
        $this->load->model('model_dashboard');
        $this->lang->load('basic', get_Langauge());
    }

    //show dashboard
    public function index() {
        $customer_id = $this->session->userdata('UserID');
        $data['title'] = $this->lang->line('Dashboard');
        $data['total_request'] = $this->model_dashboard->Totalcount("app_submit_request", "customer_id='$customer_id' AND parent_id='0'");
        $data['total_post'] = $this->model_dashboard->Totalcount("app_post", "customer_id='$customer_id'");
        $this->load->view('index', $data);
    }

}
