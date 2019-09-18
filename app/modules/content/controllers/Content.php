<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_support');
        $this->lang->load('basic', get_Langauge());
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    //show customer dashboard if authenticated
    public function index() {
        $this->authenticate->check();
        redirect('dashboard');
    }

    //cutomer login
    public function login() {
        $data['title'] = $this->lang->line('Login');
        if (!$this->session->userdata('UserID')) {
            $company_data = $this->model_support->getData("app_site_setting", "*");
            $data['company_data'] = $company_data[0];
            $this->load->view('login', $data);
        } else {
            redirect('dashboard');
        }
    }

    //check authentication of cutomer when login
    public function login_action() {
        $username = $this->db->escape($this->input->post("username", true));
        $password = $this->input->post("password", true);

        $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->login();
        } else {
            $users = $this->model_support->authenticate($username, $password);
            //Check for login
            if ($users['errorCode'] == 0) {
                $this->session->set_flashdata('msg', $users['errorMessage']);
                $this->session->set_flashdata('msg_class', 'failure');
                $this->login();
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Login_success'));
                $this->session->set_flashdata('msg_class', 'success');
                redirect("dashboard");
            }
        }
    }

    //customer forgot password 
    public function forgot_password() {
        if (!$this->session->userdata('UserID')) {
            $company_data = $this->model_support->getData("app_site_setting", "*");
            $data['title'] = $this->lang->line('Forgot_Password');
            $data['company_data'] = $company_data[0];
            $this->load->view('forgot_password', $data);
        } else {
            redirect(base_url("dashboard"));
        }
    }

    //authenticate email of customer and send mail
    public function forgot_password_action() {
        $email = $this->input->post("email", true);
        $rply = $this->model_support->check_username($email);

        $this->load->helper('string');

        if ($rply['errorCode'] == 1) {

            $define_param['to_name'] = ucfirst($rply['Firstname']) . " " . ucfirst($rply['Lastname']);
            $define_param['to_email'] = $rply['Email'];

            $userid = $rply['ID'];
            $hidenuseremail = $rply['Email'];
            $hidenusername = ucfirst($rply['Firstname']) . " " . ucfirst($rply['Lastname']);

            //Encryprt data
            $encid = $this->general->encryptData($userid);
            $encemail = $this->general->encryptData($hidenuseremail);
            $url = $this->config->item("site_url") . "reset-password-admin/" . $encid . "/" . $encemail;

            $update['reset_password_check'] = 0;
            $update['reset_password_requested_on'] = date("Y-m-d H:i:S");
            $result = $this->model_support->update("app_customer", $update, "ID='" . $userid . "'");

            // Header
            $html .= '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                              ' . $this->lang->line('Forgot_mail_message') . '
                                        <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>';

            $html .= '<table cellspacing = "0" cellpadding = "0" style = "width: 100%;" bgcolor = "#ffffff" >
                        <tr>
                            <td style = "background-color:#ffffff; padding-top: 15px;">
                                <center>
                                <table style = "margin: 0 auto;width: 90%;" cellspacing = "0" cellpadding = "0">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                                <br>
                                              ' . $this->lang->line('Forgot_mail_content') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table style = "margin:0 auto;" cellspacing = "0" cellpadding = "10" width = "100%">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:center; margin:0 auto;">
                                                <br>
                                                    <div>
                                                    <a  style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:220px;-webkit-text-size-adjust:none;" href = "' . $url . '">' . $this->lang->line('Reset_Password') . '</a>
                                                    </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>';

            $subject = $this->lang->line('Reset_Password');
            $define_param['to_name'] = $hidenusername;
            $define_param['to_email'] = $hidenuseremail;
            $this->sendmail->send($define_param, $subject, $html);

            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'success');
            redirect('login');
        } else {
            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('forgot-password');
        }
    }

    //show cutomer reset password form
    public function reset_password() {
        $id_ency = $this->uri->segment(2);
        $email_ency = $this->uri->segment(3);

        $id = (int) $this->general->decryptData($id_ency);
        $email = $this->general->decryptData($email_ency);
        $customer_data = $this->model_support->getData("app_customer", "*", "", "id='" . $id . "' AND email='" . $email . "'");

        if (count($customer_data) > 0) {
            $add_min = date("Y-m-d H:i:s", strtotime($customer_data[0]['reset_password_requested_on'] . "+1 hour"));
            if ($add_min > date("Y-m-d H:i:s")) {
                if ($customer_data[0]['reset_password_check'] != 1) {
                    $content_data['title'] = $this->lang->line('Reset_Password');
                    $content_data['id'] = $id;
                    $this->load->view('reset_password', $content_data);
                } else {
                    $this->session->set_flashdata('failure', $this->lang->line('Reset_failure'));
                    redirect('forgot_password');
                }
            } else {
                $this->session->set_flashdata('failure', $this->lang->line('Reset_failure'));
                redirect('forgot-password');
            }
        } else {
            $this->session->set_flashdata('failure', $this->lang->line('Invalid_request'));
            redirect('forgot-password');
        }
    }

    //reset password
    public function reset_password_action() {
        $password = $this->input->post('password');
        $id = $this->input->post('id');

        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('Cpassword', $this->lang->line('confirm'), 'trim|required');
        if ($this->form_validation->run() == false) {
            $content_data['id'] = $id;
            $this->load->view('reset_password', $content_data);
        } else {
            $update['reset_password_check'] = 1;
            $update['reset_password_requested_on'] = "0000-00-00 00:00:00";
            $update['password'] = md5($password);
            $this->model_support->update("app_customer", $update, "id='" . $id . "'");
            $this->session->set_flashdata('msg', $this->lang->line('Reset_success'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('login');
        }
    }

    //show customer change password form
    public function update_password() {
        $this->authenticate->check();
        $data['title'] = $this->lang->line('Update_Password');
        $this->load->view('update_password', $data);
    }

    //change password
    public function update_password_action() {
        $user_id = (int) $this->session->userdata('UserID');
        $this->authenticate->check();
        $this->form_validation->set_rules('old_password', $this->lang->line('current'), 'trim|required');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('confirm_password', $this->lang->line('confirm') . " " . $this->lang->line('password'), 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->update_password();
        } else {
            $password = $this->input->post('old_password');
            $new_password = $this->input->post('password');
            $id = (int) $this->session->userdata("UserID");
            $get_result = $this->model_support->getData("app_customer", "*", "", "id='" . $id . "'");
            if (count($get_result) > 0) {
                $old_password = $get_result[0]['password'];
                if (isset($password) && $old_password == md5($password)) {
                    $update['default_password_changed'] = 1;
                    $update['password'] = md5($new_password);
                    $this->model_support->update("app_customer", $update, "id='" . $id . "'");
                    $this->session->set_userdata("DefaultPassword", 1);
                    $this->session->set_flashdata('msg', $this->lang->line('Reset_success'));
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('update-password');
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line('Current_password_failure'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('update-password');
                }
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('login');
            }
        }
    }

    //show customer profile
    public function profile() {
        $data['title'] = 'user profile';
        $this->authenticate->check();
        $id = (int) $this->session->userdata('UserID');
        if ($id > 0) {
            $customer_data = $this->model_support->getData("app_customer", "*", "", "id=" . $id);
            if (isset($customer_data) && count($customer_data) > 0 && !empty($customer_data)) {
                $data['title'] = $this->lang->line('Profile');
                $data['customer_data'] = $customer_data[0];
                $this->load->view('profile', $data);
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                show_404();
            }
        } else {
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
    }

    //update profile
    public function profile_save() {
        $user_id = (int) $this->session->userdata('UserID');
        $this->authenticate->check();

        $this->form_validation->set_rules('first_name', $this->lang->line('first') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('last') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required|is_unique[app_customer.Email.ID.' . $user_id . ']');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'required|is_unique[app_customer.Phone.ID.' . $user_id . ']');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->profile();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'updated_on' => date("Y-m-d H:i:s")
            );
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {

                $uploadPath = uploads_path . '/profiles';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $data['profile_image'] = $newfilename;
            }

            $result = $this->model_support->update("app_customer", $data, "id='" . $user_id . "'");
            $this->session->set_flashdata('msg', $this->lang->line('Profile_success'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('profile');
        }
    }

    //show customer register form
    public function register() {
        $data['title'] = $this->lang->line('Register');
        $company_data = $this->model_support->getData("app_site_setting", "*");
        $data['company_data'] = $company_data[0];
        $this->load->view('register', $data);
    }

    //customer registration
    public function register_save() {
        $this->form_validation->set_rules('first_name', $this->lang->line('first') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('last') . " " . $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required|is_unique[app_customer.email]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'required');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->register();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'created_on' => date("Y-m-d H:i:s")
            );
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {

                $uploadPath = uploads_path . '/profiles';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $data['profile_image'] = $newfilename;
            }

            $result = $this->model_support->insert("app_customer", $data);
            $name = ucfirst($this->input->post('first_name')) . " " . ucfirst($this->input->post('last_name'));
            $hidenuseremail = $this->input->post('Email');
            // Header
            $html .= '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                             ' . $this->lang->line('Account') . ' ' . $this->lang->line('Registration') . '
                                        <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>';

            $html .= '<table cellspacing = "0" cellpadding = "0" style = "width: 100%;" bgcolor = "#ffffff" >
                        <tr>
                            <td style = "background-color:#ffffff; padding-top: 15px;">
                                <center>
                                <table style = "margin: 0 auto;width: 90%;" cellspacing = "0" cellpadding = "0">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                                <br>
                                               ' . $this->lang->line('Register_mail_message') . ' ' . $name . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                                <br>
                                               ' . $this->lang->line('Register_mail_message') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    </table>';
            $subject = $this->lang->line('Account') . ' ' . $this->lang->line('Register_success');
            $define_param['to_name'] = $name;
            $define_param['to_email'] = $hidenuseremail;
            $send = $this->sendmail->send($define_param, $subject, $html);
            $this->session->set_flashdata('msg', $this->lang->line('Register_success'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('login');
        }
    }

    //cutomer logout
    public function logout() {
        $this->session->unset_userdata('UserID');
        $this->session->unset_userdata('DefaultPassword');
        $this->session->set_flashdata('msg', $this->lang->line('Logout_success'));
        $this->session->set_flashdata('msg_class ', 'success');
        redirect(base_url());
    }

}
