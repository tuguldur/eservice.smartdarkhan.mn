<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_agent');
        $this->authenticate->check();
        $this->lang->load('basic', get_Langauge());
    }

    //show report page
    public function index() {
        $customer_id = $this->session->userdata('UserID');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $join = array(
            array(
                "table" => 'app_post',
                "condition" => 'app_post.id=app_post_view.post_id',
                "jointype" => 'left'
            )
        );
        if ($month != '' || $year != '') {
            if ($month != '' && $year != '') {
                $condition = "MONTH(app_post_view.created_on) = '$month' AND YEAR(app_post_view.created_on) = '$year' AND app_post.customer_id='$customer_id'";
            } elseif ($month != '') {
                $condition = "MONTH(app_post_view.created_on) = '$month' AND app_post.customer_id='$customer_id'";
            } elseif ($year != '') {
                $condition = "MONTH(app_post_view.created_on) = MONTH(CURRENT_DATE()) AND YEAR(app_post_view.created_on) = '$year' AND app_post.customer_id='$customer_id'";
            }
        } else {
            $condition = "MONTH(app_post_view.created_on) = (MONTH(CURRENT_DATE())) AND YEAR(app_post_view.created_on) AND app_post.customer_id='$customer_id'";
            $month = date("m");
            $year = date("Y");
        }
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('report');
        $data['month'] = $month;
        $data['year'] = $year;
        $yeardata = $this->model_agent->getData("app_post_view", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['year_data'] = $yeardata[0];
        $daily = $this->model_agent->getData("app_post_view", "DATE(app_post_view.created_on) as day,COUNT(app_post_view.created_on) AS total", $condition, $join, "", "DATE(app_post_view.created_on)");
        $data['daily_data'] = $daily;
        $this->load->view('index', $data);
    }

}

?>