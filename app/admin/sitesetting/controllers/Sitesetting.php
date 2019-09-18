<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitesetting extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->authenticate->check_admin();
        $this->load->model('model_sitesetting');
        $this->lang->load('basic', get_Langauge());
        $this->form_validation->CI = & $this;
        //only admin access permission
        if ($this->session->userdata('ADMIN_TYPE') != 'A') {
            $this->session->set_flashdata('msg', "Invalid request try again.");
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
    }

    //show site setting form
    public function index() {
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Site_Setting');
        $company_data = $this->model_sitesetting->get();
        $data['company_data'] = $company_data[0];
        $this->load->view('index', $data);
    }

    //add/edit site setting
    public function save_sitesetting() {
        $id = $this->input->post('id', true);
        $this->form_validation->set_rules('company_logo', $this->lang->line('Site_settiing_update') . " " . $this->lang->line('image'), 'callback_check_logo_size');
        $this->form_validation->set_rules('banner_img', $this->lang->line('Home') . " " . $this->lang->line('banner') . " " . $this->lang->line('image'), 'callback_check_banner_size');
        $this->form_validation->set_rules('company_name', $this->lang->line('company') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('company_email1', $this->lang->line('company') . " " . $this->lang->line('email'), 'required');
        $this->form_validation->set_rules('company_email1', $this->lang->line('company') . " " . $this->lang->line('email'), 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $data['company_name'] = $this->input->post('company_name', true);
            $data['company_address1'] = $this->input->post('company_address1', true);
            $data['company_address2'] = $this->input->post('company_address2', true);
            $data['company_phone1'] = $this->input->post('company_phone1', true);
            $data['company_phone2'] = $this->input->post('company_phone2', true);
            $data['company_email1'] = $this->input->post('company_email1', true);
            $data['language'] = $this->input->post('language', true);
            $data['home_page'] = $this->input->post('home_page', true);

            $data['fb_link'] = $this->input->post('fb_link', true);
            $data['google_link'] = $this->input->post('google_link', true);
            $data['twitter_link'] = $this->input->post('twitter_link', true);
            $data['insta_link'] = $this->input->post('insta_link', true);
            $data['linkdin_link'] = $this->input->post('linkdin_link', true);



            if (isset($_FILES['company_logo']) && $_FILES['company_logo']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/sitesetting';
                $logo_tmp_name = $_FILES["company_logo"]["tmp_name"];
                $logo_temp = explode(".", $_FILES["company_logo"]["name"]);
                $logo_name = uniqid();
                $new_logo_name = $logo_name . '.' . end($logo_temp);
                move_uploaded_file($logo_tmp_name, "$uploadPath/$new_logo_name");
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploadPath . '/' . $new_logo_name;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 241;
                $config['height'] = 61;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if ($this->image_lib->resize()) {
                    $data['company_logo'] = $logo_name . "_thumb." . end($logo_temp);
                }
            }
            if (isset($_FILES['banner_img']) && $_FILES['banner_img']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/sitesetting';
                $banner_tmp_name = $_FILES["banner_img"]["tmp_name"];
                $banner_temp = explode(".", $_FILES["banner_img"]["name"]);
                $nanner_name = uniqid();
                $new_banner_name = $nanner_name . '.' . end($banner_temp);
                move_uploaded_file($banner_tmp_name, "$uploadPath/$new_banner_name");
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploadPath . '/' . $new_banner_name;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 1900;
                $config['height'] = 500;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if ($this->image_lib->resize()) {
                    $data['banner_image'] = $nanner_name . "_thumb." . end($banner_temp);
                }
            }

            $data['community_banner'] = 'test.png';

            $this->model_sitesetting->edit(1, $data);
            $this->session->set_flashdata('msg', $this->lang->line('Site_settiing_update'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('sitesetting', 'redirect');
        }
    }

    //show email form
    public function email_setting() {
        $company_data = $this->model_sitesetting->get_email();
        $data['title'] = $this->lang->line('Email') . " " . $this->lang->line('Details');
        $data['email_data'] = $company_data;
        $this->load->view('email_setting', $data);
    }

    //add/edit email data
    public function save_email_setting() {
        $this->form_validation->set_rules('smtp_host', $this->lang->line('smtp') . " " . $this->lang->line('host'), 'required');
        $this->form_validation->set_rules('smtp_username', $this->lang->line('username'), 'required');
        $this->form_validation->set_rules('smtp_password', $this->lang->line('password'), 'required');
        $this->form_validation->set_rules('smtp_port', $this->lang->line('smtp_port'), 'required');
        $this->form_validation->set_rules('smtp_secure', $this->lang->line('smtp_secure'), 'required');
        $this->form_validation->set_rules('email_from_name', $this->lang->line('from') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == false) {
            $this->email_setting();
        } else {
            $data['smtp_host'] = $this->input->post('smtp_host', true);
            $data['smtp_password'] = $this->input->post('smtp_password', true);
            $data['smtp_username'] = $this->input->post('smtp_username', true);
            $data['smtp_port'] = $this->input->post('smtp_port', true);
            $data['smtp_secure'] = $this->input->post('smtp_secure', true);
            $data['email_from_name'] = $this->input->post('email_from_name', true);

            $this->model_sitesetting->edit_email(1, $data);
            $this->session->set_flashdata('msg', $this->lang->line('Smtp_update'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('email-setting');
        }
    }

    public function check_logo_size() {
        if (isset($_FILES['banner_img']['tmp_name']) && $_FILES['banner_img']['tmp_name'] != "") {
            $ext = pathinfo($_FILES['banner_img']['name'], PATHINFO_EXTENSION);
            $valid_extension_arr = array('jpg', 'png', 'jpeg', 'gif');
            if (!in_array(strtolower($ext), $valid_extension_arr)) {
                $this->form_validation->set_message('check_logo_size', $this->lang->line('Valid_image'));
                return FALSE;
            } else {
                $data = getimagesize($_FILES['banner_img']['tmp_name']);
                $width = isset($data[0]) ? (int) $data[0] : 0;
                $height = isset($data[1]) ? (int) $data[1] : 0;
                if ($width >= 241 && $height >= 61) {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('check_logo_size', $this->lang->line('Valid_logo'));
                    return FALSE;
                }
            }
        }
    }

    public function check_banner_size() {
        if (isset($_FILES['banner_img']['tmp_name']) && $_FILES['banner_img']['tmp_name'] != "") {
            $ext = pathinfo($_FILES['banner_img']['name'], PATHINFO_EXTENSION);
            $valid_extension_arr = array('jpg', 'png', 'jpeg', 'gif');
            if (!in_array(strtolower($ext), $valid_extension_arr)) {
                $this->form_validation->set_message('check_banner_size', $this->lang->line('Valid_image'));
                return FALSE;
            } else {
                $data = getimagesize($_FILES['banner_img']['tmp_name']);
                $width = isset($data[0]) ? (int) $data[0] : 0;
                $height = isset($data[1]) ? (int) $data[1] : 0;
                if ($width >= 1900 && $height >= 500) {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('check_banner_size', $this->lang->line('Valid_banner'));
                    return FALSE;
                }
            }
        }
    }

}

?>