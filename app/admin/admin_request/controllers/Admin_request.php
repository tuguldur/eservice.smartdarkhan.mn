<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_request extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->authenticate->check_admin();
        $this->load->model('model_request');
        $this->lang->load('basic', get_Langauge());
    }

    //show submit request list
    public function index() {
        $admin_id = $this->session->userdata('ADMIN_ID');
        $fields = "app_submit_request.*,app_customer.first_name,app_customer.last_name";
        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_submit_request.customer_id",
                "jointype" => "LEFT")
        );
        if ($this->session->userdata('ADMIN_TYPE') == 'A') {
            $condtion = "user_type='U' AND parent_id='0'";
        } else {
            $condtion = "user_type='U' AND parent_id='0' AND FIND_IN_SET('$admin_id',assign_id) !=''";
        }
        $submit_request = $this->model_request->getData("", $fields, $condtion, $join, "app_submit_request.id desc");
        $data['request_data'] = $submit_request;
        $data['title'] = $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Details');
        $this->load->view('index', $data);
    }

    //show submit request details
    public function submit_request_reply($request_id = null) {
        $request_id = (int) $this->input->get_post('request_id');
        if ($request_id == 0 || $request_id == null) {
            $request_id = (int) $this->uri->segment(2);
        }
        $update['request_read'] = "R";
        $this->model_request->update('', $update, "parent_id='$request_id' AND user_type='U'");

        $condtion = "parent_id='$request_id'";
        $request = $this->model_request->getData("", "*", $condtion, "", "app_submit_request.id desc");
        $fields = "app_submit_request.*,app_customer.first_name,app_customer.last_name,app_customer.email,app_customer.profile_image,app_request_category.title";
        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_submit_request.customer_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_request_category",
                "condition" => "app_request_category.id=app_submit_request.category_id",
                "jointype" => "LEFT")
        );
        $condtion_main = "app_submit_request.id='$request_id'";
        $request_main = $this->model_request->getData("", $fields, $condtion_main, $join);
        $data['request_main'] = $request_main[0];
        $data['request_data'] = $request;
        $data['title'] = $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Reply');
        $this->load->view('request_reply', $data);
    }

    //reply submit request
    public function request_reply_send() {
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        $request_id = (int) $this->input->post('request_id', true);
        $message = $this->input->post('message', true);
        if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != '') {
            $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/request';
            $tmp_name = $_FILES["attachment"]["tmp_name"];
            $temp = explode(".", $_FILES["attachment"]["name"]);
            $newfilename = (uniqid()) . '.' . end($temp);
            move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
        }
        $insert['customer_id'] = $admin_id;
        $insert['description'] = $message;
        $insert['attchment'] = isset($newfilename) && $newfilename != '' ? $newfilename : '';
        $insert['parent_id'] = $request_id;
        $insert['user_type'] = "A";
        $insert['request_read'] = "U";
        $insert['created_on'] = date("Y-m-d H:i:s");
        $insert_id = $this->model_request->insert('', $insert);
        $update['updated_on'] = date("Y-m-d H:i:s");
        $update['last_reply'] = $admin_id;
        $update['reply_type'] = "A";
        $this->model_request->update('', $update, "id='$request_id'");
        if ($insert_id) {
            $request_data = $this->model_request->getData("app_submit_request", "*", "id=" . $request_id);
            $customer_id = $request_data[0]['customer_id'];
            $customer = $this->model_request->getData("app_customer", "*", "id=" . $customer_id);
            $customer_fullname = ucfirst($customer[0]['first_name']) . " " . $customer[0]['last_name'];
            $customer_email = $customer[0]['email'];

            $subject = $this->lang->line('Admin') . " " . $this->lang->line('Reply') . " " . $this->lang->line('Submit') . " " . $this->lang->line('Request');
            $html = "<table cellspacing='0' cellpadding='0' style='background-color:#3bcdb0;width: 100%;'>
                        <tr>
                            <td style = 'background-color:#3bcdb0;'>
                                <table cellspacing = '0' cellpadding = '0' style = 'width: 100%;'>
                                    <tr>
                                        <td style = 'font-size:35px; padding: 20px 25px; color: #ffffff; text-align:center;' class = 'mobile-spacing'>
                                            " . $this->lang->line('Request') . " " . $this->lang->line('Reply') . "
                                        <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
          
            
                    <tr>
                    <td style='padding: 30px 0px 20px 0px;'>
                        <table align='center' width=100%>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;' colspan='2'>
                                  " . $this->lang->line('Admin') . " " . $this->lang->line('Reply') . " " . $this->lang->line('Submit') . " " . $this->lang->line('Request') . "
                                </td>
                            </tr>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                " . $this->lang->line('Description') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding-top: 10px;'>
                                   " . $message . "
                                </td>
                            </tr>

                        </table>
                    </td>
                    </tr>
                    <tr>";

            $define_param['to_name'] = $customer_fullname;
            $define_param['to_email'] = $customer_email;
            $attachment = '';
            if (isset($newfilename) && $newfilename != '') {
                $attachment = dirname(BASEPATH) . "/" . uploads_path . '/request/' . $newfilename;
            }
            //send email
            $send = $this->sendmail->send($define_param, $subject, $html, $attachment);
        }
        redirect(base_url('admin-submit-request-reply/' . $request_id));
    }

    //sumit request status edit
    public function admin_change_request_status() {
        $request_id = $this->input->post('request_id', true);
        $data['status'] = $this->input->post('request-status', true);
        $this->model_request->update('', $data, "id='$request_id'");
        $this->model_request->update('', $data, "parent_id='$request_id'");
        $request_data = $this->model_request->getData("app_submit_request", "customer_id", "id='$request_id'");
        $customer_id = $request_data[0]['customer_id'];
        $customer = $this->model_request->getData("app_customer", "*", "id=" . $customer_id);
        $customer_fullname = ucfirst($customer[0]['first_name']) . " " . $customer[0]['last_name'];
        $customer_email = $customer[0]['email'];
        $request_status = $this->input->post('request-status', true);
        if ($request_status == 'O') {
            $status = 'Open';
        } else if ($request_status == 'P') {
            $status = 'Pending';
        } else if ($request_status == 'S'){
            $status = 'Solved';
        } else{
             $status = 'Re-Open';
        }
        $ticket_no = "#" . str_pad($request_id, 4, "0", STR_PAD_LEFT);
        $subject = $this->lang->line('Admin') . " " . $this->lang->line('Change') . " " . $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Status');
        $html = "<table cellspacing='0' cellpadding='0' style='background-color:#3bcdb0;width: 100%;'>
                        <tr>
                            <td style = 'background-color:#3bcdb0;'>
                                <table cellspacing = '0' cellpadding = '0' style = 'width: 100%;'>
                                    <tr>
                                        <td style = 'font-size:35px; padding: 20px 25px; color: #ffffff; text-align:center;' class = 'mobile-spacing'>
                                           " . $this->lang->line('Request') . " " . $this->lang->line('Details') . "
                                        <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
          
            
                    <tr>
                    <td style='padding: 30px 0px 20px 0px;'>
                        <table align='center' width=100%>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                " . $this->lang->line('Ticket') . " " . $this->lang->line('No') . ":
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding-top: 10px;'>
                                   " . $ticket_no . "
                                </td>
                            </tr>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                " . $this->lang->line('Status') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding-top: 10px;'>
                                   " . $status . "
                                </td>
                            </tr>

                        </table>
                    </td>
                    </tr>
                    <tr>";

        $define_param['to_name'] = $customer_fullname;
        $define_param['to_email'] = $customer_email;

        //send email
        $send = $this->sendmail->send($define_param, $subject, $html);

        redirect(base_url('admin-submit-request-reply/' . $request_id));
    }

    //show assign request form
    function assign_request() {
        //only admin access permission
        if ($this->session->userdata('ADMIN_TYPE') != 'A') {
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
        $data['title'] = $this->lang->line('Assign') . " " . $this->lang->line('Request');
        $request_data = $this->model_request->getData("app_submit_request", "id,subject", "parent_id='0'");
        $data['request_data'] = $request_data;
        $this->load->view('assign_request', $data);
    }

    //get agent list with assign request agent
    function get_agent() {
        $id = (int) $this->input->post('id');
        $html = "<option value = ''disabled selected>" . $this->lang->line('Select') . " " . $this->lang->line('Agent') . "</option>";
        if (isset($id) && $id > 0) {
            $agent_data = $this->model_request->getData("app_admin", "id,first_name,last_name", "user_type='E' AND status='A'");
            if (!empty($agent_data) && count($agent_data) > 0) {
                $assign_data = $this->model_request->getData("app_submit_request", "assign_id", "id='$id'");
                foreach ($agent_data as $value) {
                    $val = $value['id'];
                    $name = ucfirst($value['first_name']) . " " . ucfirst($value['last_name']);
                    $selected = '';
                    if (in_array($val, explode(",", $assign_data[0]['assign_id']))) {
                        $selected = 'selected';
                    }
                    $html .="<option value='$val' $selected>$name</option>";
                }
                echo $html;
                exit;
            } else {
                $html .="<option value=''>" . $this->lang->line('No') . " " . $this->lang->line('Agent') . " " . $this->lang->line('Found') . "</option>";
                echo $html;
                exit;
            }
            echo "<option value=''>" . $this->lang->line('Select') . " " . $this->lang->line('Request') . " " . $this->lang->line('First') . "</option>";
            exit;
        }
    }

    //uupdate request assign agent 
    function assign_action() {
        //only admin access permission
        if ($this->session->userdata('ADMIN_TYPE') != 'A') {
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
        $this->form_validation->set_rules('request', $this->lang->line('request'), 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            $this->assign_request();
        } else {
            $request_id = $this->input->post('request', true);
            $update['assign_id'] = implode(",", $this->input->post('agent', true));
            $this->model_request->update("app_submit_request", $update, "id='$request_id'");
            redirect('admin-request');
        }
    }

}

?>