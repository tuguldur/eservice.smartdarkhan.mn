<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('home_model');
        $this->lang->load('basic', get_Langauge());
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // 
        $this->load->model('model_request');
    }

    //show user profile
    public function user_profile($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        if ($id) {

            $join = array(
                array(
                    "table" => "app_admin",
                    "condition" => "app_admin.id=app_article.created_by",
                    "jointype" => "LEFT"),
            );
            $condtion = "app_article.created_by=  $id ";
            $fields = "app_article.*, app_admin.id AS AID, , app_admin.first_name, , app_admin.last_name, app_admin.profile_image, app_admin.created_on As AuthorCreatedOn";
            $order = "app_article.updated_on  DESC";
            $article = $this->home_model->getData('app_article', $fields, $join, $condtion, $order);

            if (count($article) > 0) {
                $data['title'] = $this->lang->line('User') . " " . $this->lang->line('Profile');
                $data['user_profile'] = $article;
                $this->load->view('user_profile', $data);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    //show home
    public function index() {
        $version = $this->uri->segment(1);

        // Article group data
        $group_cond = "status = 'A' AND (SELECT count(app_article.id) FROM app_article WHERE status = 'A')";
        $fields = 'app_article_groups.*, (SELECT count(app_article.id) FROM app_article WHERE status = "A" AND group_id = app_article_groups.id) AS tot_article';
        $group = $this->home_model->getData("app_article_groups", $fields, array(), $group_cond);
        $data['knowledge_group_name'] = $group;

        $search = $this->input->get("search");
        $join = array(
            array(
                "table" => "app_article_groups",
                "condition" => "app_article_groups.id=app_article.group_id",
                "jointype" => "LEFT"),
        );
        $condtion = " app_article.status='A' ";
        $fields = "app_article.*,app_article.id as Article_ID, app_article_groups.id, app_article_groups.title as name";
        $limit = 5;
        $like = array();

        if (!empty($search)) {
            $like = array(
                array(
                    "column" => "app_article.title",
                    "pattern" => $search,
                )
            );
            $limit = false;
        }

        // Recent Activity
        $order = "app_article.updated_on DESC";
        $article = $this->home_model->getData('app_article', $fields, $join, $condtion, $order, false, false, $limit, false, false, $like);
        $data['knowledge_recent_activity'] = $article;
        $company_data = $this->home_model->getData('app_site_setting', '*');
        $data['company_data'] = $company_data[0];
        $home_page = $company_data[0]['home_page'];

        // Popular Acctivity
        $fields_p = "COUNT(article_id) AS total ,article_id,app_article.title,app_article.slug,app_article.group_id";
        $join_p = array(
            array(
                "table" => "app_article",
                "condition" => "app_article.id=app_article_view.article_id",
                "jointype" => "INNER"),
        );
        $article_popular = $this->home_model->getData('app_article_view', $fields_p, $join_p, "", "total DESC", "article_id", false, $limit);
        $data['popular_activity'] = $article_popular;


        if (!isset($version) && $home_page == "") {
            $version = 'v1';
        } else {
            if ($version && $version != '') {
                $version = $version;
            } else {
                $version = "v" . $home_page;
            }
        }
        $this->load->view($version, $data);
    }

    //show group details
    public function group_details($slug = '') {
        if ($slug == '') {
            $slug = $this->uri->segment(2);
        }
        $id = 0;
        $data['title'] = $this->lang->line('Group') . " " . $this->lang->line('Details');
        $search = $this->input->get("search");

        $join = array(
            array(
                "table" => "app_article_groups",
                "condition" => "app_article_groups.id=app_article.group_id",
                "jointype" => "LEFT"),
        );
        $condtion = "app_article_groups.slug = '$slug' AND app_article.status='A'";
        $fields = "app_article.*, app_article_groups.id AS group_id, app_article_groups.title as group_title";
        $like = array();
        if ($search != '') {
            $like = array(
                array(
                    "column" => "app_article.title",
                    "pattern" => $search,
                )
            );
        }
        $article = $this->home_model->getData('app_article', $fields, $join, $condtion, '', '', '', '', '', '', $like);
        $group = $this->home_model->getData('app_article_groups', "title,seo_keyword,seo_description", "", "slug='$slug'");
        $data['group_name'] = $group[0]['title'];
        $data['meta_description'] = $group[0]['seo_description'];
        $data['meta_keyword'] = $group[0]['seo_keyword'];

        $data['knowledge_group_details'] = $article;
        $article_group = $this->home_model->getData('app_article_groups', "*", array(), "status = 'A'");
        $data['total_group'] = $article_group;
        // get request
        $fields_request = "app_submit_request.*,app_customer.first_name,app_customer.last_name";
        $join_request = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_submit_request.customer_id",
                "jointype" => "LEFT")
        );
        $submit_request = $this->model_request->getData("", $fields_request, '', $join_request, "app_submit_request.id ASC");
        $data['request_data'] = $submit_request;
        $data['title'] = $this->lang->line('Submit') . " " . $this->lang->line('Request') . " " . $this->lang->line('Details');
    
        $this->load->view('group_details', $data);
    }

    //show article details
    public function article_details($slug = '') {
        if ($slug == '') {
            $slug = $this->uri->segment(2);
        }
        $group_id = $article = $this->home_model->getData('app_article', "group_id,id", "", "slug='$slug'");

        $data['title'] = $this->lang->line('Article') . " " . $this->lang->line('Details');
        $article_id = (int) $group_id[0]['id'];
        $group_id = (int) $group_id[0]['group_id'];
        $customer_id = (int) $this->session->userdata('UserID');
        $search = $this->input->get("search");
        $this->load->library('location');
        $location = $this->location->map();
        $res = article_view($article_id, $location['ip']);
        $ip = $location['ip'];
        $join = array(
            array(
                "table" => "app_article_groups",
                "condition" => "app_article_groups.id=app_article.group_id",
                "jointype" => "LEFT"),
        );
        $condtion = "app_article_groups.id=$group_id ";
        $fields = "app_article.*,app_article.id as Article_ID, app_article_groups.id, app_article_groups.title";
        $article = $this->home_model->getData('app_article', $fields, $join, $condtion, '', '', '', 3);
        $data['knowledge_group'] = $article;

        $fields = "app_article.*,app_admin.first_name,app_admin.last_name,app_admin.profile_image";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_article.created_by",
                "jointype" => "LEFT"),
        );
        $condtion = "app_article.id= $article_id AND app_article.group_id= $group_id ";
        $like = array();
        if ($search != '') {
            $like = array(
                array(
                    "column" => "app_article_groups.title",
                    "pattern" => $search,
                )
            );
        }
        $article_main = $this->home_model->getData("app_article", $fields, $join, $condtion, '', '', '', '', '', '', $like);
        if (count($article_main) > 0) {
            $data['knowledge_article_details'] = $article_main[0];
            $data['meta_description'] = $article_main[0]['seo_description'];
            $data['meta_keyword'] = $article_main[0]['seo_keyword'];
            $sql = "SELECT * FROM app_article";
            $result = $this->db->query($sql);
            if ((int) $this->session->userdata('UserID') > 0) {
                $get_count = $this->home_model->getSingleRow('app_article_helpful', 'article_id = ' . $article_id . ' AND customer_id = ' . (int) $this->session->userdata('UserID'));
            } else {
                $get_count = $this->home_model->getSingleRow('app_article_helpful', "ip_address='$ip' AND article_id='$article_id' AND customer_id='$customer_id'");
            }
            if (isset($get_count) && !empty($get_count)) {
                $data['is_helpful'] = $get_count['is_helpful'];
            }
            $get_res = $this->home_model->getData('app_article_helpful', 'COUNT(CASE WHEN is_helpful = "Y" THEN 1 END) AS up_count, COUNT(CASE WHEN is_helpful = "N" THEN 1 END) AS down_count', array(), 'article_id = ' . $article_id);

            if (isset($get_res) && !empty($get_res)) {
                foreach ($get_res as $row) {
                    $data['up_count'] = $row['up_count'];
                    $data['down_count'] = $row['down_count'];
                }
            }
            $total_article = $this->home_model->getData('app_article', "*", "", "group_id='$group_id'");
            $data['total_article'] = $total_article;
            $data['article_id'] = $article_id;
            $data['group_id'] = $group_id;
            $this->load->view('article_details', $data);
        } else {
            redirect(base_url());
        }
    }

    //show submit request form
    public function submit_request() {
        $this->authenticate->check();
        $company_data = $this->home_model->getData('app_site_setting', "*");
        $data['company_data'] = $company_data[0];
        $category_data = $this->home_model->getData('app_request_category', "*", "", "status='A'");
        $data['category_data'] = $category_data;
        $data['title'] = $this->lang->line('Submit') . " " . $this->lang->line('Request');
        $this->load->view('submit_request', $data);
    }

    //add submit request
    public function submit_request_action() {
        $user_id = (int) $this->session->userdata('UserID');
        $this->form_validation->set_rules('request_priority', $this->lang->line('request') . " " . $this->lang->line('priority'), 'required');
        $this->form_validation->set_rules('subject', $this->lang->line('subject'), 'required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('category_id', $this->lang->line('category'), 'required');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->submit_request();
        } else {
            $user_data = $this->home_model->getData("app_customer", "*", "", "id=" . $user_id);
            $username = ucfirst($user_data[0]['first_name']) . " " . $user_data[0]['last_name'];
            if (isset($_FILES['attachment_img']) && $_FILES['attachment_img']['name'] != '') {
                $uploadPath = uploads_path . '/request';
                $tmp_name = $_FILES["attachment_img"]["tmp_name"];
                $temp = explode(".", $_FILES["attachment_img"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
            }
            $data['customer_id'] = $user_id;
            $data['subject'] = $this->input->post('subject');
            $data['description'] = $this->input->post('description');
            $data['attchment'] = isset($newfilename) && $newfilename != '' ? $newfilename : '';
            $data['user_type'] = "U";
            $data['request_read'] = "U";
            $data['request_priority'] = $this->input->post('request_priority');
            $data['category_id'] = $this->input->post('category_id');
            $data['created_on'] = date("Y-m-d H:i:s");
            $submit_request = $this->home_model->insert_data('app_submit_request', $data);
            if ($submit_request) {
                $subject = "Submit a request ";
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
                                " . $this->lang->line('Subject') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px;'>
                                   " . $this->input->post("subject", true) . "
                                </td>
                            </tr>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                " . $this->lang->line('Description') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding-top: 10px;'>
                                   " . $this->input->post("description", true) . "
                                </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    <tr>";
                $define_param['to_name'] = get_CompanyName();
                $define_param['to_email'] = ADMIN_EMAIL;
                $attachment = uploads_path . '/request/' . $newfilename;
                //send email
                $this->sendmail->send($define_param, $subject, $html, $attachment);
            }
            $this->session->set_flashdata('msg', $this->lang->line('request_success'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('submit_request');
        }
    }

    //add comment
    public function post_comment() {
        $data['customer_id'] = $this->session->userdata('UserID');
        $data['artical_id'] = $this->input->post('artical_id');
        $data['comment'] = $this->input->post('comment');
        $data['created_on'] = date("Y-m-d H:i:s");
        $this->home_model->insertData('app_comment', $data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    //add/edit article helpful
    public function add_article_helpful() {
        $data['article_id'] = $this->input->post('a_id');
        $data['is_helpful'] = $this->input->post('value');
        $data['customer_id'] = (int) $this->session->userdata('UserID');
        $this->load->library('location');
        $location = $this->location->map();
        $data['ip_address'] = $location['ip'];
        $ip = $location['ip'];
        $article_id = $this->input->post('a_id');
        $customer_id = (int) $this->session->userdata('UserID');
        if ((int) $this->session->userdata('UserID') > 0) {
            $get_count = $this->home_model->getSingleRow('app_article_helpful', "article_id='$article_id' AND customer_id='$customer_id'");
        } else {
            $get_count = $this->home_model->getSingleRow('app_article_helpful', "ip_address='$ip' AND article_id='$article_id' AND customer_id='$customer_id'");
        }
        if (isset($get_count) && !empty($get_count)) {
            $a_id = $get_count['id'];
            $this->home_model->update_data('app_article_helpful', 'id = ' . $a_id, $data);
        } else {
            $data['created_on'] = date("Y-m-d H:i:s");
            $this->home_model->insertData('app_article_helpful', $data);
        }
        $get_res = $this->home_model->getData('app_article_helpful', 'COUNT(CASE WHEN is_helpful = "Y" THEN 1 END) AS up_count, COUNT(CASE WHEN is_helpful = "N" THEN 1 END) AS down_count', array(), 'article_id = ' . $this->input->post('a_id'));
        if (isset($get_res) && !empty($get_res)) {
            foreach ($get_res as $row) {
                $up_count = $row['up_count'];
                $down_count = $row['down_count'];
            }
        }
        echo json_encode(array("a_id" => $result, "up_count" => isset($up_count) ? $up_count : 0, "down_count" => isset($down_count) ? $down_count : 0));
        exit;
    }

    //show faq    
    public function faqs() {
        $faqs = $this->home_model->getData('app_faq', "*", "", "status='A'");
        $data['faqs'] = $faqs;
        $data['title'] = $this->lang->line('FAQs');
        $this->load->view('faqs', $data);
    }

    //show community
    public function community() {
        $data['title'] = $this->lang->line('Community');
        $search = $this->input->get('search');
        $limit = 5;
        if (!empty($search)) {
            $like = array(
                array(
                    "column" => "app_post.title",
                    "pattern" => $search,
                )
            );
            $limit = false;
            $data['search'] = $search;
        }
        $topics_data = $this->home_model->getData('app_community_forum', '*', "", "status='A'");
        $featured_post = $this->home_model->getData('app_post', 'app_post.title,app_post.slug', "", "total_views >'0' AND status='A'", "total_views desc", "", "", $limit);
        $join = array(
            array(
                "table" => 'app_community_forum',
                "condition" => 'app_community_forum.id=app_post.topic_id',
                "jointype" => 'left'
            )
        );
        $recent_activity = $this->home_model->getData('app_post', 'app_post.title,app_post.slug,app_post.created_on,app_community_forum.slug as topic_slug,app_community_forum.title as topic_title', $join, "app_post.status='A'", "app_post.created_on desc", "", "", $limit, "", "", $like);
        $data['featured_post'] = $featured_post;
        $data['recent_activity'] = $recent_activity;
        $data['topics_data'] = $topics_data;
        $this->load->view('community', $data);
    }

    //show community topics
    public function topics() {
        $slug = $this->uri->segment(3);
        $sort = $this->uri->segment(4);
        $filter_by = $this->uri->segment(5);
        $search = $this->input->get("search");
        $user_id = (int) $this->session->userdata('UserID');
        $like = array();
        if (!empty($search)) {
            $like = array(
                array(
                    "column" => "app_post.title",
                    "pattern" => $search,
                )
            );
        }
        $order_by = 'app_post.created_on desc';
        if (isset($sort) && !empty($sort) && $sort != '') {
            if (isset($sort) && $sort == 'newest') {
                $order_by = 'app_post.created_on desc';
            } else if (isset($sort) && $sort == 'recent') {
                $order_by = 'app_post.created_on desc';
            } else if (isset($sort) && $sort == 'votes') {
                $order_by = 'app_post.total_vote desc';
            } else if (isset($sort) && $sort == 'comments') {
                $order_by = 'app_post.total_comment desc';
            }
        }
        $condition = "app_community_forum.slug='$slug' AND app_post.status='A'";
        if (isset($filter_by) && !empty($filter_by) && $filter_by != '') {
            if (isset($filter_by) && $filter_by == 'planned') {
                $condition = "app_community_forum.slug='$slug' AND app_post.status='A' AND app_post.post_status='P'";
            } else if (isset($filter_by) && $filter_by == 'not_planned') {
                $condition = "app_community_forum.slug='$slug' AND app_post.status='A' AND app_post.post_status='NP'";
            } else if (isset($filter_by) && $filter_by == 'completed') {
                $condition = "app_community_forum.slug='$slug' AND app_post.status='A' AND app_post.post_status='C'";
            } else if (isset($filter_by) && $filter_by == 'answered') {
                $condition = "app_community_forum.slug='$slug' AND app_post.status='A' AND app_post.post_status='A'";
            } else if (isset($filter_by) && $filter_by == 'no_status') {
                $condition = "app_community_forum.slug='$slug' AND app_post.status='A' AND app_post.post_status='NS'";
            }
        }
        $join = array(
            array(
                "table" => 'app_post',
                "condition" => 'app_post.topic_id=app_community_forum.id',
                "jointype" => 'left'
            ),
            array(
                "table" => 'app_customer',
                "condition" => 'app_customer.id=app_post.customer_id',
                "jointype" => 'left'
            )
        );
        $topics_data = $this->home_model->getData('app_community_forum', 'app_community_forum.*,app_post.topic_id,app_post.customer_id,app_post.title as post_title,app_post.created_on as post_date,app_post.total_vote,app_post.total_comment,app_post.slug as post_slug,app_customer.first_name,app_customer.last_name', $join, $condition, $order_by, "", "", "", "", "", $like);
        $data['topics_data'] = $topics_data;
        $data['topic_title'] = $topics_data[0]['title'];
        if (in_array($user_id, explode(",", $topics_data[0]['follwer_id']))) {
            $data['follwed'] = true;
        } else {
            $data['follwed'] = false;
        }
        if (in_array($user_id, explode(",", $topics_data[0]['children_id']))) {
            $data['child_follwed'] = true;
        } else {
            $data['child_follwed'] = false;
        }
        $data['total_follwer'] = $topics_data[0]['total_follwer'];
        $data['title'] = $this->lang->line("Community") . " " . $this->lang->line("Topics");
        $this->load->view('topics', $data);
    }

    //follow/unfollow topics
    public function subscription() {
        $this->authenticate->check();
        $user_id = (int) $this->session->userdata('UserID');
        $slug = $this->uri->segment(2);
        $subscription = $this->uri->segment(3);
        $follw_data = $this->home_model->getData('app_community_forum', "children_id,follwer_id,total_follwer", "", "slug='$slug'");
        $total_follwer = $follw_data[0]['total_follwer'];
        $childer_id = explode(",", $follw_data[0]['children_id']);
        $follwer_id = explode(",", $follw_data[0]['follwer_id']);
        if (isset($subscription) && $subscription == 'true') {
            if (!in_array($user_id, $childer_id)) {
                if (!in_array('0', $childer_id)) {
                    array_push($childer_id, $user_id);
                } else {
                    unset($childer_id[0]);
                    array_push($childer_id, $user_id);
                }
            }
            $childer_id = implode(",", $childer_id);
            if (!in_array($user_id, $follwer_id)) {
                if (!in_array('0', $follwer_id)) {
                    array_push($follwer_id, $user_id);
                } else {
                    unset($follwer_id[0]);
                    array_push($follwer_id, $user_id);
                }
                $total_follwer = $follw_data[0]['total_follwer'] + 1;
            }
            $follwer_id = implode(",", $follwer_id);
            $update = array(
                "children_id" => $childer_id,
                'follwer_id' => $follwer_id,
                'total_follwer' => $total_follwer
            );
            $this->home_model->update_data('app_community_forum', "slug='$slug'", $update);
        } else if (isset($subscription) && $subscription == 'false') {
            if (in_array($user_id, $childer_id)) {
                $key = array_search($user_id, $childer_id);
                unset($childer_id[$key]);
            }
            if (empty($childer_id) && count($childer_id) == 0) {
                array_push($childer_id, "0");
            }
            $childer_id = implode(",", $childer_id);
            if (!in_array($user_id, $follwer_id)) {
                if (!in_array('0', $follwer_id)) {
                    array_push($follwer_id, $user_id);
                } else {
                    unset($follwer_id[0]);
                    array_push($follwer_id, $user_id);
                }
                $total_follwer = $follw_data[0]['total_follwer'] + 1;
            }
            $follwer_id = implode(",", $follwer_id);
            $update = array(
                "children_id" => $childer_id,
                'follwer_id' => $follwer_id,
                'total_follwer' => $total_follwer
            );
            $this->home_model->update_data('app_community_forum', "slug='$slug'", $update);
        } else if (!isset($subscription)) {
            if (in_array($user_id, $childer_id)) {
                $key = array_search($user_id, $childer_id);
                unset($childer_id[$key]);
            }
            if (empty($childer_id) && count($childer_id) == 0) {
                array_push($childer_id, "0");
            }
            $childer_id = implode(",", $childer_id);
            if (in_array($user_id, $follwer_id)) {
                $key = array_search($user_id, $follwer_id);
                unset($follwer_id[$key]);
                $total_follwer = $follw_data[0]['total_follwer'] - 1;
            }
            if (empty($follwer_id) && count($follwer_id) == 0) {
                array_push($follwer_id, "0");
            }
            $follwer_id = implode(",", $follwer_id);
            $update = array(
                "children_id" => $childer_id,
                'follwer_id' => $follwer_id,
                'total_follwer' => $total_follwer
            );
            $this->home_model->update_data('app_community_forum', "slug='$slug'", $update);
        }
        redirect('community/topics/' . $slug);
    }

    //follow posts
    public function post_subscription() {
        $this->authenticate->check();
        $user_id = (int) $this->session->userdata('UserID');
        $slug = $this->uri->segment(2);
        $follw_data = $this->home_model->getData('app_post', "follwer_id,total_follwer", "", "slug='$slug'");
        $total_follwer = $follw_data[0]['total_follwer'];
        $follwer_id = explode(",", $follw_data[0]['follwer_id']);
        if (!in_array($user_id, $follwer_id)) {
            if (!in_array('0', $follwer_id)) {
                array_push($follwer_id, $user_id);
            } else {
                $key = array_search("0", $follwer_id);
                unset($follwer_id[$key]);
                array_push($follwer_id, $user_id);
            }
            $total_follwer = $follw_data[0]['total_follwer'] + 1;
        }
        $follwer_id = implode(",", $follwer_id);
        $update = array(
            'follwer_id' => $follwer_id,
            'total_follwer' => $total_follwer
        );
        $this->home_model->update_data('app_post', "slug='$slug'", $update);
        redirect('community/posts/' . $slug);
    }

    //unfollow posts
    public function post_unscription() {
        $this->authenticate->check();
        $user_id = (int) $this->session->userdata('UserID');
        $slug = $this->uri->segment(2);
        $follw_data = $this->home_model->getData('app_post', "follwer_id,total_follwer", "", "slug='$slug'");
        $total_follwer = $follw_data[0]['total_follwer'];
        $follwer_id = explode(",", $follw_data[0]['follwer_id']);
        if (in_array($user_id, $follwer_id)) {
            $key = array_search($user_id, $follwer_id);
            unset($follwer_id[$key]);
            $total_follwer = $follw_data[0]['total_follwer'] - 1;
        }
        if (empty($follwer_id) && count($follwer_id) == 0) {
            array_push($follwer_id, "0");
        }
        $follwer_id = implode(",", $follwer_id);
        $update = array(
            'follwer_id' => $follwer_id,
            'total_follwer' => $total_follwer
        );
        $this->home_model->update_data('app_post', "slug='$slug'", $update);
        redirect('community/posts/' . $slug);
    }

    //show community posts
    public function posts() {
        $user_id = (int) $this->session->userdata('UserID');
        $slug = $this->uri->segment(3);
        $join = array(
            array(
                "table" => 'app_customer',
                "condition" => 'app_customer.id=app_post.customer_id',
                "jointype" => 'left'
            )
        );
        $post_data = $this->home_model->getData('app_post', 'app_post.*,app_customer.id as customer_id,app_customer.first_name,app_customer.last_name,app_customer.profile_image', $join, "slug='$slug'");
        $post_id = $post_data[0]['id'];
        $comment_join = array(
            array(
                "table" => 'app_customer',
                "condition" => 'app_customer.id=app_post_comment.customer_id',
                "jointype" => 'left'
            )
        );
        $comment_data = $this->home_model->getData('app_post_comment', 'app_post_comment.*,app_customer.first_name,app_customer.last_name,app_customer.profile_image', $comment_join, "post_id='$post_id' AND  perent_id='0'");
        $data['post_data'] = $post_data[0];
        $data['comment_data'] = $comment_data;
        if (in_array($user_id, explode(",", $post_data[0]['follwer_id']))) {
            $data['follwed'] = true;
        } else {
            $data['follwed'] = false;
        }
        $data['total_follwer'] = $post_data[0]['total_follwer'];
        $data['title'] = $this->lang->line("Community") . " " . $this->lang->line("Posts");
        $this->load->library('location');
        $location = $this->location->map();
        $res = post_view($post_id, $location['ip']);
        $this->load->view('posts', $data);
    }

    //add/remove post votes
    public function post_vote() {
        $this->authenticate->check();
        $user_id = (int) $this->session->userdata('UserID');
        $id = (int) $this->uri->segment(2);
        $vote_add = $this->input->post('vote_add');
        $vote_class = $this->input->post('vote_class');
        $vote_name = $this->input->post('vote_name');
        $up_class = 'vote-up';
        $down_class = 'vote-down';
        if ($vote_name == "up") {
            $up_class = isset($vote_class) && $vote_class == 'add' ? 'vote-up vote-voted' : 'vote-up';
        } else {
            $down_class = isset($vote_class) && $vote_class == 'add' ? 'vote-down vote-voted' : 'vote-down';
        }
        $post_data = $this->home_model->getData('app_post', "total_vote,vote_id", "", "id='$id'");
        $final_vote = $post_data[0]['total_vote'] + $vote_add;
        $vote_id = explode(",", $post_data[0]['vote_id']);
        if ($vote_class == 'add') {
            if (!in_array($user_id, $vote_id)) {
                if (!in_array('0', $vote_id)) {
                    array_push($vote_id, $user_id);
                } else {
                    unset($vote_id[0]);
                    array_push($vote_id, $user_id);
                }
            }
        } else {
            $key = array_search($user_id, $vote_id);
            unset($vote_id[$key]);
            if (empty($vote_id) && count($vote_id) == 0) {
                array_push($vote_id, "0");
            }
        }
        $update = array(
            'total_vote' => $final_vote,
            "vote_id" => implode(",", $vote_id),
            "vote_type" => isset($vote_class) && $vote_class == 'add' ? $vote_name : ''
        );
        $this->home_model->update_data('app_post', "id='$id'", $update);
        $html = ' <div class="post-vote vote" role="radiogroup">
                                <a role="radio" class="' . $up_class . '" title="Yes" href="#" onclick="post_vote(this);" data-id="' . $id . '"></a>
                                <span class="vote-sum" data-helper="vote" data-item="post">' . $final_vote . '</span>
                                <a role="radio" class="' . $down_class . '" title="No" href="#" onclick="post_vote(this);" data-id="' . $id . '"></a>
                            </div>';
        echo $html;
        exit;
    }

    //add posts to comment
    public function post_comment_action() {
        $this->authenticate->check();
        $slug = $this->input->post('slug');
        $id = $this->input->post('id');
        $comment = $this->input->post('comment');
        $user_id = (int) $this->session->userdata('UserID');
        $insert = array(
            'customer_id' => $user_id,
            'post_id' => $id,
            'comment' => $comment,
            'created_on' => date("Y-m-d H:i:s")
        );
        $this->home_model->insertData('app_post_comment', $insert);
        $update = array(
            "total_comment" => "total_comment + 1"
        );
        $this->db->where('id', $id);
        $this->db->set('total_comment', 'total_comment+1', FALSE);
        $this->db->update('app_post');
        $customer = $this->home_model->getData('app_customer', "first_name,last_name,email", "", "id='$user_id'");
        $post_data = $this->home_model->getData('app_post', "title", "", "id='$id'");
        $to_name = ucfirst($customer[0]['firstname']) . " " . ucfirst($customer[0]['lastname']);
        $to_email = $customer[0]['email'];
        $subject = "New Post Comment";
        $post_title = $post_data[0]['title'];
        $post_comment_mail = $this->lang->line('post_comment_mail');
        $post_comment_mail = str_replace("{POSTNAME}", $post_title, $post_comment_mail);
        $html = "<table cellspacing='0' cellpadding='0' style='background-color:#3bcdb0;width: 100%;'>
                        <tr>
                            <td style = 'background-color:#3bcdb0;'>
                                <table cellspacing = '0' cellpadding = '0' style = 'width: 100%;'>
                                    <tr>
                                        <td style = 'font-size:35px; padding: 20px 25px; color: #ffffff; text-align:center;' class = 'mobile-spacing'>
                                             " . $this->lang->line('New') . " " . $this->lang->line('Comments') . "
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
                                             " . $post_comment_mail . "
                                        <br>
                                        </td>
                                    </tr>
                            <tr>
                                <td width=30%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px; padding: 10px 27px;'>
                                 " . $this->lang->line('Comments') . " :
                                </td>
                                <td width=70%  align='left' bgcolor='#ffffff' style=' color: #5B515E; font-family: GothamMedium; font-size: 18px; font-weight: medium; line-height: 20px;'>
                                   " . $comment . "
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
        redirect("community/posts/" . $slug);
    }

    //show community post form
    public function community_post() {
        $this->authenticate->check();
        $data['title'] = $this->lang->line("Community_Post");
        $data['topics_data'] = $this->home_model->getData('app_community_forum', '*', "", "status='A'");
        $this->load->view('community_post', $data);
    }

    //add posts
    public function post_action() {
        $user_id = (int) $this->session->userdata('UserID');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('topic_id', $this->lang->line('topic'), 'required');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->community_post();
        } else {
            $insert = array(
                'topic_id' => $this->input->post('topic_id'),
                'customer_id' => $user_id,
                'title' => $this->input->post('title'),
                'description' => $_POST['description'],
                'token' => time(),
                'seo_keyword' => $this->input->post('title'),
                'seo_description' => $this->general->add3dots($_POST['description'], "...", 100),
                'slug' => slugify($this->input->post('title')),
                'created_on' => date("Y-m-d H:i:s")
            );
            $inser_id = $this->home_model->insertData('app_post', $insert);
            if ($inser_id) {
                $customer = $this->home_model->getData('app_customer', "first_name,last_name,email", "", "id='$user_id'");
                $to_name = ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']);
                $to_email = $customer[0]['email'];
                $subject = "New Post Submit";
                $html = "<table cellspacing='0' cellpadding='0' style='background-color:#3bcdb0;width: 100%;'>
                        <tr>
                            <td style = 'background-color:#3bcdb0;'>
                                <table cellspacing = '0' cellpadding = '0' style = 'width: 100%;'>
                                    <tr>
                                        <td style = 'font-size:35px; padding: 20px 25px; color: #ffffff; text-align:center;' class = 'mobile-spacing'>
                                             " . $this->lang->line('New') . " " . $this->lang->line('Community') . " " . $this->lang->line('Post') . "
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
                                             " . $this->lang->line('post_mail_message') . "
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
                $this->session->set_flashdata('msg', $this->lang->line('Post_success'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('community');
        }
    }

    //show customer profile  page
    public function customer_profile() {
        $customer_id = $this->uri->segment(2);
        $total_post = $this->home_model->getData('app_post', "id,vote_id,follwer_id", "", "customer_id='$customer_id'");
        $customer = $this->home_model->getData('app_customer', "profile_image,first_name,last_name,created_on", "", "id='$customer_id'");
        $vote = array();
        $follwer = array();
        foreach ($total_post as $key => $value) {
            $vote_array = explode(",", $value['vote_id']);
            $vote = array_merge($vote, $vote_array);
        }
        foreach ($total_post as $key => $value) {
            $follwer_array = explode(",", $value['follwer_id']);
            $follwer = array_merge($follwer, $follwer_array);
        }
        $vote = array_unique($vote);
        $key = array_search("0", $vote);
        unset($vote[$key]);
        $follwer = array_unique($follwer);
        $key_follwer = array_search("0", $follwer);
        unset($follwer[$key_follwer]);
        $where = "FIND_IN_SET('" . $customer_id . "', follwer_id)";
        $total_following = $this->home_model->getData('app_post', "follwer_id", "", $where);
        $last_activity = $this->home_model->getData('app_post', "created_on", "", "customer_id='$customer_id'", "created_on desc", "", "", "1");
        $join = array(
            array(
                "table" => 'app_community_forum',
                "condition" => 'app_community_forum.id=app_post.topic_id',
                "jointype" => 'left'
            )
        );
        $last_post = $this->home_model->getData('app_post', "app_post.title,app_post.description,app_post.created_on,app_post.total_follwer,app_post.total_comment,app_post.total_vote,app_post.slug,app_community_forum.title as topic_title,app_community_forum.slug as topic_slug", $join, "customer_id='$customer_id' AND app_post.status='A'", "created_on desc", "", "", "5");
        $all_post = $this->home_model->getData('app_post', "app_post.title,app_post.description,app_post.created_on,app_post.total_comment,app_post.slug,app_community_forum.title as topic_title,app_community_forum.slug as topic_slug", $join, "customer_id='$customer_id' AND app_post.status='A'", "created_on desc");
        $join_comment = array(
            array(
                "table" => 'app_post',
                "condition" => 'app_post.id=app_post_comment.post_id',
                "jointype" => 'left'
            ),
            array(
                "table" => 'app_community_forum',
                "condition" => 'app_community_forum.id=app_post.topic_id',
                "jointype" => 'left'
            )
        );
        $all_comment = $this->home_model->getData('app_post_comment', "app_post_comment.comment,app_post_comment.created_on,app_post.title,app_post.total_comment,app_post.slug,app_community_forum.title as topic_title,app_community_forum.slug as topic_slug", $join_comment, "app_post_comment.customer_id='$customer_id' AND app_post.status='A'", "created_on desc");
        $data['total_post'] = count($total_post);
        $data['customer'] = $customer[0];
        $data['final_vote'] = count($vote);
        $data['final_follwer'] = count($follwer);
        $data['total_following'] = count($total_following);
        $data['last_activity'] = $last_activity[0]['created_on'];
        $data['last_post'] = $last_post;
        $data['all_post'] = $all_post;
        $data['all_comment'] = $all_comment;
        $data['title'] = $this->lang->line('Customer') . " " . $this->lang->line('Profile');
        $this->load->view('customer_profile', $data);
    }

    public function get_post() {
        $title = $this->input->post('t');
        $result = $this->db->select('title')->from('app_post')->where("title LIKE '%$title%'")->get()->result_array();
        if (isset($result) && count($result) > 0 && $title != '') {
            $html = '';
            foreach ($result as $value) {
                $html .= '<li><a href="community/posts/' . slugify($value['title']) . '" class="alert-link">' . $value['title'] . '</a></li>';
            }
            echo $html;
            exit;
        }
        echo false;
        exit;
    }

    public function get_request_article() {
        $subject = $this->input->post('s');
        $result = $this->db->select('title')->from('app_article')->like("title", $subject)->get()->result_array();
        if (isset($result) && count($result) > 0 && $subject != '') {
            $html = '';
            foreach ($result as $value) {
                $html .= '<li><a href="articles/' . slugify($value['title']) . '" class="alert-link">' . $value['title'] . '</a></li>';
            }
            echo $html;
            exit;
        }
        echo false;
        exit;
    }

}

?>