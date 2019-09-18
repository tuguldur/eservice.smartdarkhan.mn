<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->authenticate->check_admin();
        $this->load->model('model_dashboard');
        $this->lang->load('basic', get_Langauge());
    }

    //show admin dashboard
    public function index() {
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        if ($this->session->userdata('ADMIN_TYPE') == 'A') {
            $name = 'Admin';
        } else {
            $name = 'Agent';
        }
        $data['title'] = $this->lang->line($name) . " " . $this->lang->line('Dashboard');
        $data['total_article'] = $this->model_dashboard->Totalcount("app_article");
        $data['total_group'] = $this->model_dashboard->Totalcount("app_article_groups");
        $data['total_customer'] = $this->model_dashboard->Totalcount("app_customer");
        if ($this->session->userdata('ADMIN_TYPE') == 'A') {
            $condtion = "user_type='U' AND parent_id='0'";
        } else {
            $condtion = "user_type='U' AND parent_id='0' AND FIND_IN_SET('$admin_id',assign_id) !=''";
        }
        $data['total_request'] = $this->model_dashboard->Totalcount("app_submit_request", $condtion);
        $data['total_agent'] = $this->model_dashboard->Totalcount("app_admin", "user_type='E'");
        $data['total_faq'] = $this->model_dashboard->Totalcount("app_faq");
        $data['total_topic'] = $this->model_dashboard->Totalcount("app_community_forum");
        $data['total_post'] = $this->model_dashboard->Totalcount("app_post");
        $this->load->view('dashboard', $data);
    }

}

?>