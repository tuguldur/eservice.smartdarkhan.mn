<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activity extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->authenticate->check();
        $this->lang->load('basic', get_Langauge());
        $this->load->model('model_activity');
    }

    //show submit request list
    public function index() {
        $customer_id = $this->session->userdata('UserID');
        $fields = "app_comment.comment,app_comment.created_on,app_article.title,app_article.slug";
        $join = array(
            array(
                "table" => "app_article",
                "condition" => "app_article.id=app_comment.artical_id",
                "jointype" => "LEFT")
        );
        $condtion = "customer_id='$customer_id' AND user_type='U'";
        $article_comment = $this->model_activity->getData("app_comment", $fields, $condtion, $join, "created_on desc");
        $fields_post = "app_post_comment.comment,app_post_comment.created_on,app_post.title,app_post.slug";
        $join_post = array(
            array(
                "table" => "app_post",
                "condition" => "app_post.id=app_post_comment.post_id",
                "jointype" => "LEFT")
        );
        $condtion_post = "app_post_comment.customer_id='$customer_id' AND user_type='U'";
        $post_comment = $this->model_activity->getData("app_post_comment", $fields_post, $condtion_post, $join_post, "created_on desc");
        $data['article_comment'] = $article_comment;
        $data['post_comment'] = $post_comment;
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Activity');
        $this->load->view('index', $data);
    }

}

?>
