<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Request extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->authenticate->check();
        $this->lang->load('basic', get_Langauge());
        $this->load->model('model_request');
    }

    //show submit request list
    public function index() {
        $customer_id = $this->session->userdata('UserID');
        $fields = "app_submit_request.*,app_customer.first_name,app_customer.last_name";
        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_submit_request.customer_id",
                "jointype" => "LEFT")
        );
        $condtion = "customer_id='$customer_id' AND user_type='U' AND parent_id='0'";
        $submit_request_data = $this->model_request->getData("", $fields, $condtion, $join, "id desc");
        $data['request_data'] = $submit_request_data;
        $data['title'] = $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Details');
        $this->load->view('index', $data);
    }

    //show reply form 
    public function submit_request_reply($request_id = null) {
        if ($request_id == null || $request_id == 0) {
            $request_id = (int) $this->uri->segment(2);
        }
        $customer_id = (int) $this->session->userdata('UserID');
        $data['request_read'] = "R";
        $this->model_request->update('', $data, "parent_id='$request_id' AND user_type='A'");
        $condtion = "parent_id='$request_id'";
        $submit_request = $this->model_request->getData("", "*", $condtion, "", "id desc");
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
        $data['request_data'] = $submit_request;
        $data['title'] = $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Reply');
        $this->load->view('request_reply', $data);
    }

    //send request reply
    public function request_reply_send() {
        $customer_id = (int) $this->session->userdata('UserID');
        $request_id = (int) $this->input->post('request_id');
        $message = $this->input->post('message');
        if (isset($_FILES['get_attachment']) && $_FILES['get_attachment']['name'] != '') {
            $uploadPath = uploads_path . '/request';
            $tmp_name = $_FILES["get_attachment"]["tmp_name"];
            $temp = explode(".", $_FILES["get_attachment"]["name"]);
            $newfilename = (uniqid()) . '.' . end($temp);
            move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
        }
        $data['customer_id'] = $customer_id;
        $data['description'] = $message;
        $data['attchment'] = isset($newfilename) && $newfilename != '' ? $newfilename : '';
        $data['parent_id'] = $request_id;
        $data['user_type'] = "U";
        $data['request_read'] = "U";
        $data['created_on'] = date("Y-m-d H:i:s");
        $insert_id = $this->model_request->insert('', $data);
        $update['updated_on'] = date("Y-m-d H:i:s");
        $update['last_reply'] = $customer_id;
        $update['reply_type'] = "U";
        $this->model_request->update('', $update, "id='$request_id'");
        if ($insert_id > 0) {
            $user_data = $this->model_request->getData("app_customer", "*", "id=" . $customer_id);
            $username = ucfirst($user_data[0]['first_name']) . " " . $user_data[0]['last_name'];
            $subject = $this->lang->line('Customer') . " " . $this->lang->line('Reply') . " " . $this->lang->line('Submit') . " " . $this->lang->line('Request');
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
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                 " . $this->lang->line('Customer') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px;'>
                                   " . $username . "
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
            $define_param['to_name'] = get_CompanyName();
            $define_param['to_email'] = ADMIN_EMAIL;
            $attachment = '';
            if (isset($newfilename) && $newfilename != '') {
                $attachment = uploads_path . '/request/' . $newfilename;
            }
            //send email
            $send = $this->sendmail->send($define_param, $subject, $html, $attachment);
        }
        redirect(base_url('submit-request-reply/' . $request_id));
    }

    //change request status
    public function change_request_status() {
        $request_id = $this->input->post('request_id');
        $data['status'] = $this->input->post('request-status');
        $this->model_request->update('', $data, "id='$request_id'");
        $this->model_request->update('', $data, "parent_id='$request_id'");
        $customer_id = $this->session->userdata("UserID");
        $user_data = $this->model_request->getData("app_customer", "*", "id=" . $customer_id);
        $USERNAME = ucfirst($user_data[0]['first_name']) . " " . $user_data[0]['last_name'];
        $get_status = $this->input->post('request-status');
        if ($get_status == 'O') {
            $status = 'Open';
        } else if ($get_status == 'P') {
            $status = 'Pending';
        } else if ($get_status == 'S') {
            $status = 'Solved';
        } else {
            $status = 'Re-Open';
        }
        $ticket_no = "#" . str_pad($request_id, 4, "0", STR_PAD_LEFT);
        $subject = $this->lang->line('Customer') . " " . $this->lang->line('Change') . " " . $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Status');
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
                                 " . $this->lang->line('Customer') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px;'>
                                   " . $USERNAME . "
                                </td>
                            </tr>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                " . $this->lang->line('Ticket') . " " . $this->lang->line('No') . ".:
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
        $define_param['to_name'] = get_CompanyName();
        $define_param['to_email'] = ADMIN_EMAIL;
        //send email
        $send = $this->sendmail->send($define_param, $subject, $html);
        redirect(base_url('submit-request-reply/' . $request_id));
    }

}

?>
