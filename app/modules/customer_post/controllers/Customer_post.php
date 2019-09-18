<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_post extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->authenticate->check();
        $this->lang->load('basic', get_Langauge());
        $this->load->model('model_customer_post');
    }

    //show post list
    public function index($topic_id = 0) {
        $customer_id = $this->session->userdata('UserID');
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Post');

        $cond = 'app_post.customer_id = ' . $customer_id;
        $join = array(
            array(
                "table" => "app_community_forum",
                "condition" => "app_community_forum.id=app_post.topic_id",
                "jointype" => "LEFT"),
        );
        $order = "app_post.created_on  DESC";
        $article = $this->model_customer_post->getData("app_post", "app_post.*,app_community_forum.title AS topic_title", $cond, $join, $order);
        $data['all_post_data'] = $article;
        $this->load->view('index', $data);
    }

    //show edit post form
    public function edit_post($id = null) {
        $data['title'] = $this->lang->line('Update') . " " . $this->lang->line('Post');
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $topic_list = $this->model_customer_post->getData("app_community_forum", "*");
        $data['topic_list'] = $topic_list;

        $post = $this->model_customer_post->getData("app_post", "*", 'id=' . $id);
        if (isset($post[0]) && !empty($post[0])) {
            $data['post_data'] = $post[0];
            $this->load->view('edit_post', $data);
        } else {
            show_404();
        }
    }

    //save post
    public function save_post() {

        $id = (int) $this->input->post('id', true);
        $customer_id = $this->session->userdata('UserID');
        $topic_id = (int) $this->input->post('topic', true);

        $this->form_validation->set_rules('topic', $this->lang->line('topic'), 'required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required');
        $this->form_validation->set_message('check_title', $this->lang->line('title_already'));
        $this->form_validation->set_rules('seo_keyword', $this->lang->line('SEO') . ' ' . $this->lang->line('keyword'), 'required');
        $this->form_validation->set_rules('seo_description', $this->lang->line('SEO') . ' ' . $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');

        if ($this->form_validation->run() == false) {
            $this->edit_post();
        } else {
            $data = array(
                'topic_id' => $this->input->post('topic', true),
                'title' => $this->input->post('title', true),
                'seo_keyword' => $this->input->post('seo_keyword', true),
                'seo_description' => $this->input->post('seo_description', true),
                'slug' => slugify($this->input->post('title', true)),
                'open_comment' => $this->input->post('open_comment', true),
                'post_status' => $this->input->post('post_status', true),
                'status' => $this->input->post('status', true),
                'customer_id' => $customer_id,
                'description' => $_POST['description']
            );
            $data['updated_on'] = date("Y-m-d H:i:s");
            $this->model_customer_post->update("app_post", $data, 'ID = ' . $id);

            $customer = $this->model_customer_post->getData("app_customer", "email,first_name,last_name", "id = '$customer_id'");
            $to_name = ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']);
            $to_email = $customer[0]['email'];

            $subject = "Update Post";
            $html = "<table cellspacing='0' cellpadding='0' style='background-color:#3bcdb0;width: 100%;'>
                        <tr>
                            <td style = 'background-color:#3bcdb0;'>
                                <table cellspacing = '0' cellpadding = '0' style = 'width: 100%;'>
                                    <tr>
                                        <td style = 'font-size:35px; padding: 20px 25px; color: #ffffff; text-align:center;' class = 'mobile-spacing'>
                                             " . $this->lang->line('Update') . " " . $this->lang->line('Community') . " " . $this->lang->line('Post') . "
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
                                        <td colspan='2' style = 'width:100%;font-size:22px; padding: 20px 25px; color: #5B515E; text-align:center;' class = 'mobile-spacing'>
                                             " . $this->lang->line('post_Updatemail_message2') . "
                                        <br>
                                        </td>
                                    </tr>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                 " . $this->lang->line('Post') . " " . $this->lang->line('Title') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px;'>
                                   " . $this->input->post('title') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    <tr>";
            $define_param['to_name'] = $to_name;
            $define_param['to_email'] = $to_email;
            //send email
            $this->sendmail->send($define_param, $subject, $html);


            $this->session->set_flashdata('msg', $this->lang->line('Post_update'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('post-manage', 'redirect');
        }
    }

    // delete post
    public function delete_post($id = null) {
        if ($id == null) {
            $id = (int) $this->uri->segment(2);
        }
        $this->model_customer_post->delete('app_post', 'id=' . $id);
        $this->session->set_flashdata('msg', $this->lang->line('Post_delete'));
        $this->session->set_flashdata('msg_class', 'failure');
        redirect('post-manage', 'redirect');
    }

    public function check_post_title() {
        $id = (int) $this->input->post('id');
        $title = $this->input->post('title');
        $topic_id = (int) $this->input->post('topic');
        if (isset($id) && $id > 0) {
            $where = "title='$title' AND topic_id='$topic_id' AND id!='$id'";
        } else {
            $where = "title='$title' AND topic_id='$topic_id'";
        }
        $check_title = $this->model_customer_post->getData("app_post", "title", $where);
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

}

?>