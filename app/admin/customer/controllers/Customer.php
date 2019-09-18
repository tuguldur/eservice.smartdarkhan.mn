<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_customer');
        $this->authenticate->check_admin();
        $this->lang->load('basic', get_Langauge());
        //only admin access permission
        if ($this->session->userdata('ADMIN_TYPE') != 'A') {
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
    }

    //show customer list
    public function index() {
        $data['title'] = $this->lang->line('Manage')." ".$this->lang->line('Customer');
        $order = "created_on DESC";
        $customer = $this->model_customer->getData("app_customer", "*", "", "", $order);
        $data['customer_data'] = $customer;
        $this->load->view('index', $data);
    }

    //delete customer
    public function delete_customer($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $this->model_customer->delete('app_customer', 'id=' . $id);
        $this->model_customer->delete('app_comment', 'user_type="U" AND customer_id=' . $id);
        $this->model_customer->delete('app_submit_request', 'user_type="U" AND customer_id=' . $id);
        $this->model_customer->delete('app_post', "customer_id='$id'");
        $this->session->set_flashdata('msg',  $this->lang->line('Customer') . " " . $this->lang->line('has') . " " . $this->lang->line('been') . " " . $this->lang->line('deleted') . " " . $this->lang->line('succesfully') . ".");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('customer', 'redirect');
    }

    //change status of customer
    public function change_customer_tatus($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $status = $this->input->post('status', true);
        $update = array(
            'status' => $status
        );
        $this->model_customer->update('app_customer', $update, 'id=' . $id);
        $msg = isset($status) && $status == "A" ? "Active" : "Inactive";
        $this->session->set_flashdata('msg', $this->lang->line('Customer') . " " . $this->lang->line('has') . " " . $this->lang->line('been') . $status . " " . $this->lang->line('succesfully') . ".");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('customer', 'redirect');
    }

}

?>