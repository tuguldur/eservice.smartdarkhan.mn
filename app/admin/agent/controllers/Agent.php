<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agent extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_agent');
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
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Agent');
        $order = "created_on  DESC";
        $agent = $this->model_agent->getData("app_admin", "*", "user_type='E'", "", $order);
        $data['agent_data'] = $agent;
        $this->load->view('index', $data);
    }

    //show add agent form
    public function add_agent() {
        $data['title'] = $this->lang->line('Add') . " " . $this->lang->line('Agent');
        $this->load->view('manage', $data);
    }

    //show edit agent form
    public function update_agent($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $agent = $this->model_agent->getData("app_admin", "*", "id='$id'");
        if (isset($agent[0]) && !empty($agent[0])) {
            $data['agent_data'] = $agent[0];
            $data['title'] = $this->lang->line('Update') . " " . $this->lang->line('Agent');
            $this->load->view('manage', $data);
        } else {
            show_404();
        }
    }

    //add/edit an agent
    public function save_agent() {
        $admin_id = $this->session->userdata("ADMIN_ID");
        $agent_id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('first_name', $this->lang->line('first') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('last') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required|is_unique[app_admin.email.id.' . $agent_id . ']');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'required|is_unique[app_admin.phone.id.' . $agent_id . ']');
        if ($agent_id == 0) {
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'required');
            $this->form_validation->set_rules('confirm_password', $this->lang->line('confirm') . " " . $this->lang->line('password'), 'required');
        }
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($agent_id > 0) {
                $this->update_agent();
            } else {
                $this->add_agent();
            }
        } else {
            $data['first_name'] = $this->input->post('first_name', true);
            $data['last_name'] = $this->input->post('last_name', true);
            $data['email'] = $this->input->post('email', true);
            $data['phone'] = $this->input->post('phone', true);
            $data['status'] = $this->input->post('status', true);

            if ($agent_id > 0) {
                $data['updated_on'] = date("Y-m-d H:i:s");
                $this->model_agent->update('app_admin', $data, "id=$agent_id");
                $message = "updated";
            } else {
                $data['password'] = md5($this->input->post('password', true));
                $data['user_type'] = "E";
                $data['created_by'] = $admin_id;
                $data['created_on'] = date("Y-m-d H:i:s");
                $this->model_agent->insert('app_admin', $data);
                $message = "created";
                $agent_fullname = ucfirst($this->input->post('first_name', true)) . " " . ucfirst($this->input->post('last_name'));
                $agent_email = $this->input->post('email', true);
                // Header
                $html = '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                             ' . $this->lang->line('Your') . ' ' . $this->lang->line('Account') . ' ' . $this->lang->line('Created') . '
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>';

                $html .='<table cellspacing = "0" cellpadding = "0" style = "width: 100%;" bgcolor = "#ffffff" >
                        <tr>
                            <td style = "background-color:#ffffff; padding-top: 15px;">
                        <center>
                            <table style = "margin: 0 auto;width: 90%;" cellspacing = "0" cellpadding = "0">
                                <tbody>
                                    <tr>
                                        <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                            <br>
                                           ' . $this->lang->line('New_account_mail') . ' 
                                            <br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style = "margin:0 auto;" cellspacing = "0" cellpadding = "10" width = "100%">
                                <tbody>
                                    <tr>
                                        <td style = "text-align:center; margin:0 auto;">
                                            <table width="100%" border="1" cellpadding="10">
                                                <tr>
                                                    <td>Email</td>
                                                    <td>' . $agent_email . '</td>
                                                </tr>
                                                <tr>
                                                    <td>Password</td>
                                                    <td>' . $this->input->post('password', true) . '</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                            </tr>
                    </table>';

                $subject = $this->lang->line('Agent') . " " . $this->lang->line('Registartion');
                $define_param['to_name'] = $agent_fullname;
                $define_param['to_email'] = $agent_email;
                $this->sendmail->send($define_param, $subject, $html);
            }
            $this->session->set_flashdata('msg', $this->lang->line('Agent') . " " . $this->lang->line('has') . " " . $this->lang->line('been') . $message . " " . $this->lang->line('succesfully') . ".");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('agent', 'redirect');
        }
    }

    //delete an agent
    public function delete_agent($id = null) {
        if ($id == null) {
            $id = (int) $this->uri->segment(2);
        }
        $this->model_agent->delete('app_admin', 'id=' . $id);
        $this->model_agent->delete('app_comment', 'user_type=        "A" AND customer_id=' . $id);
        $this->model_agent->delete('app_submit_request', 'user_type=        "A" AND customer_id=' . $id);
        $this->session->set_flashdata('msg', $this->lang->line('Agent') . " " . $this->lang->line('has') . " " . $this->lang->line('been') . " " . $this->lang->line('deleted') . " " . $this->lang->line('succesfully') . ".");
        $this->session->set_flashdata('msg_class', 'success');
        redirect('customer', 'redirect');
    }

}

?>