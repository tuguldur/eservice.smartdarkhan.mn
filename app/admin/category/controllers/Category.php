<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_category');
        $this->authenticate->check_admin();
        $this->lang->load('basic', get_Langauge());
        //only admin access permission
        if ($this->session->userdata('ADMIN_TYPE') != 'A') {
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
    }

    //show agent list
    public function index() {
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Category');
        $category = $this->model_category->getData("app_request_category", "*");
        $data['category_data'] = $category;
        $this->load->view('index', $data);
    }

    //show add agent form
    public function add_category() {
        $data['title'] = $this->lang->line('Add') . " " . $this->lang->line('Category');
        $this->load->view('manage', $data);
    }

    //show edit agent form
    public function update_category($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $category = $this->model_category->getData("app_request_category", "*", "id='$id'");
        if (isset($category[0]) && !empty($category[0])) {
            $data['category_data'] = $category[0];
            $data['title'] = $this->lang->line('Update') . " " . $this->lang->line('Category');
            $this->load->view('manage', $data);
        } else {
            show_404();
        }
    }

    //add/edit an agent
    public function save_category() {
        $admin_id = $this->session->userdata("ADMIN_ID");
        $category_id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required');
        $this->form_validation->set_rules('status', $this->lang->line('status'), 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($category_id > 0) {
                $this->update_category();
            } else {
                $this->add_category();
            }
        } else {
            $data['title'] = $this->input->post('title', true);
            if ($category_id > 0) {
                $data['updated_on'] = date("Y-m-d H:i:s");
                $status = $this->input->post('status', true);
                $category = $this->model_category->getData("app_submit_request", "*", 'category_id = ' . $category_id);
                if (count($category) > 0 && $status == "I") {
                    $this->session->set_flashdata('msg', $this->lang->line('Category_status_error'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('update-category/' . $category_id, 'redirect');
                } else {
                    $data['status'] = $this->input->post('status', true);
                    $this->model_category->update('app_request_category', $data, "id=$category_id");
                }
                $message = "updated";
            } else {
                $data['created_on'] = date("Y-m-d H:i:s");
                $data['status'] = $this->input->post('status', true);
                $this->model_category->insert('app_request_category', $data);
                $message = "created";
            }
            $this->session->set_flashdata('msg', $this->lang->line('Category') . " " . $this->lang->line('has') . " " . $this->lang->line('been') . " " . $message . " " . $this->lang->line('succesfully') . ".");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('category', 'redirect');
        }
    }

    //delete an agent
    public function delete_category(
    $id = null) {
        if ($id == null) {
            $id = (int) $this->uri->segment(2);
        }
        $this->model_category->delete('app_request_category', 'id=' . $id);
        $this->session->set_flashdata('msg', $this->lang->line('Category') . " " . $this->lang->line('has') . " " . $this->lang->line('been') . " " . $this->lang->line('deleted') . " " . $this->lang->line('succesfully') . ".");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('category', 'redirect');
    }

}

?>