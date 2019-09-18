<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_content extends MX_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_support');
        $this->lang->load('basic', get_Langauge());
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    //show dashboard
    public function index() {
        $this->authenticate->check_admin();
        redirect('admin-dashboard');
    }

    //logout
    public function logout() {
        $this->session->unset_userdata('ADMIN_ID');
        $this->session->unset_userdata('ADMIN_TYPE');
        $this->session->unset_userdata('DefaultPassword');
        $this->session->set_flashdata('msg', $this->lang->line('Logout_success'));
        $this->session->set_flashdata('msg_class ', 'success');
        redirect('admin-login');
    }

    //show login form
    public function login() {
        if (!$this->session->userdata('ADMIN_ID')) {
            $data['title'] = $this->lang->line('Login');
            $company_data = $this->model_support->getData("app_site_setting", "*");
            $data['company_data'] = $company_data[0];
            $this->load->view('login', $data);
        } else {
            redirect('admin-dashboard');
        }
    }

    //check login email or password
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
                redirect("admin-login");
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Login_success'));
                $this->session->set_flashdata('msg_class', 'success');
                redirect("admin-dashboard");
            }
        }
    }

    //show forgot password form
    public function forgot_password() {
        if (!$this->session->userdata('ADMIN_ID')) {
            $company_data = $this->model_support->getData("app_site_setting", "*");
            $data['title'] = $this->lang->line('Forgot_Password');
            $data['company_data'] = $company_data[0];
            $this->load->view('forgot_password', $data);
        } else {
            redirect(base_url("admin-dashboard"));
        }
    }

    //check email and forgot password mail send
    public function forgot_password_action() {
        $postvar = $this->input->post("email", true);
        $admin_data = $this->model_support->check_username($postvar);
        $this->load->helper('string');
        if ($admin_data['errorCode'] == 1) {
            $code = random_string('numeric', 6);
            $updata = array(
                'reset_password_check' => $code,
                'reset_password_requested_on' => date("Y-m-d H:i:s")
            );
            $define_param['to_name'] = ucfirst($admin_data['first_name']) . " " . ucfirst($admin_data['last_name']);
            $define_param['to_email'] = $admin_data['email'];
            $userid = $admin_data['id'];
            $hidenuseremail = $admin_data['email'];
            $hidenusername = ucfirst($admin_data['first_name']) . " " . ucfirst($admin_data['last_name']);
            //Encryprt data
            $encid = $this->general->encryptData($userid);
            $encemail = $this->general->encryptData($hidenuseremail);
            $url = $this->config->item("site_url") . "admin-reset-password-admin/" . $encid . "/" . $encemail;
            $update['reset_password_check'] = 0;
            $update['reset_password_requested_on'] = date("Y-m-d H:i:S");
            $this->model_support->update("app_admin", $update, "id='" . $userid . "'");
            // Header
            $html .='<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
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
            $html .='<table cellspacing = "0" cellpadding = "0" style = "width: 100%;" bgcolor = "#ffffff" >
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
                                                    <a href = "' . $url . '" style = "background-color:#f5774e;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:220px;-webkit-text-size-adjust:none;">' . $this->lang->line('Reset_Password') . '</a>
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
            $send = $this->sendmail->send($define_param, $subject, $html);
            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'success');
            redirect('admin-login');
        } else {
            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'failure');
            $this->forgot_password();
        }
    }

    //show reset password 
    public function reset_password_admin($id_ency = '', $email_ency = '') {
        $id_ency = $this->uri->segment(2);
        $email_ency = $this->uri->segment(3);

        $id = (int) $this->general->decryptData($id_ency);
        $email = $this->general->decryptData($email_ency);
        $admin_data = $this->model_support->getData("app_admin", "*", "", "id='" . $id . "' AND email='" . $email . "'");
        if (isset($admin_data) && count($admin_data) > 0 && !empty($admin_data)) {
            $h_id = $admin_data[0]['id'];
            $add_min = date("Y-m-d H:i:s", strtotime($admin_data[0]['reset_password_requested_on'] . "+1 hour"));
            if ($add_min > date("Y-m-d H:i:s")) {
                if ($admin_data[0]['reset_password_check'] != 1) {
                    $data['title'] = $this->lang->line('Reset_Password');
                    $data['id'] = $id;
                    $this->load->view('reset_password', $data);
                } else {
                    $this->session->set_flashdata('failure', $this->lang->line('Reset_failure'));
                    redirect('forgot_password');
                }
            } else {
                $this->session->set_flashdata('failure', $this->lang->line('Reset_failure'));
                redirect('admin-forgot-password');
            }
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            show_404();
        }
    }

    //edit password
    public function reset_password_admin_action() {
        $password = $this->input->post('password');
        $id = $this->input->post('id');

        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('cpassword', $this->lang->line('confirm') . " " . $this->lang->line('password'), 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->reset_password_admin();
        } else {
            $update['reset_password_check'] = 1;
            $update['reset_password_requested_on'] = "0000-00-00 00:00:00";
            $update['password'] = md5($password);
            $this->model_support->update("app_admin", $update, "id='" . $id . "'");
            $this->session->set_flashdata('msg', $this->lang->line('Reset_success'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('admin-login');
        }
    }

    //show update password form
    public function update_password() {
        $this->authenticate->check_admin();
        $data['title'] = $this->lang->line('Update_Password');
        $this->load->view('update_password', $data);
    }

    //edit password
    public function update_password_action() {
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        $this->authenticate->check_admin();
        $this->form_validation->set_rules('old_password', $this->lang->line('current') . " " . $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('confirm_password', $this->lang->line('confirm') . " " . $this->lang->line('password'), 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->update_password();
        } else {
            $old_password = $this->input->post('old_password', true);
            $new_password = $this->input->post('password', true);
            $admin_data = $this->model_support->getData("app_admin", "*", "", "id='" . $admin_id . "'");
            if (isset($admin_data) && count($admin_data) > 0 && !empty($admin_data)) {
                $admin_password = $admin_data[0]['password'];
                if (isset($old_password) && $admin_password == md5($old_password)) {
                    $update['default_password_changed'] = 1;
                    $update['password'] = md5($new_password);
                    $result = $this->model_support->update("app_admin", $update, "id='" . $admin_id . "'");
                    $this->session->set_userdata("DefaultPassword", 1);
                    $this->session->set_flashdata('msg', $this->lang->line('Reset_success'));
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('admin-update-password');
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line('Current_password_failure'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('admin-update-password');
                }
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                show_404();
            }
        }
    }

    //show edit profile form
    public function profile() {
        $this->authenticate->check_admin();
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        if (isset($admin_id) && $admin_id > 0) {
            $admin_data = $this->model_support->getData("app_admin", "*", "", "id=" . $admin_id);
            if (isset($admin_data) && count($admin_data) > 0 && !empty($admin_data)) {
                $data['title'] = $this->lang->line('Profile');
                $data['admin_data'] = $admin_data[0];
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

    //edit profile
    public function profile_save() {
        $this->authenticate->check_admin();
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        $this->form_validation->set_rules('first_name', $this->lang->line('first') . " " . $this->lang->line('name'), 'required|max_length[50]');
        $this->form_validation->set_rules('last_name', $this->lang->line('last') . " " . $this->lang->line('name'), 'required|max_length[50]');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'required|min_length[10]|is_unique[app_admin.phone.id.' . $admin_id . '] ');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->profile();
        } else {
            $update = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'updated_on' => date("Y-m-d H:i:s")
            );
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {

                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/profiles';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $update['profile_image'] = $newfilename;
            }
            $this->model_support->update("app_admin", $update, "id='" . $admin_id . "'");
            $this->session->set_flashdata('msg', $this->lang->line('Profile_success'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('admin-profile');
        }
    }

}
