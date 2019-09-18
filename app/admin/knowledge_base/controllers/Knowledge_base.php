<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Knowledge_base extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_knowledge_base');
        $this->lang->load('basic', get_Langauge());
        $this->form_validation->CI = & $this;
        $this->authenticate->check_admin();
    }

    //show group list
    public function index() {
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Group');
        $join = array(
            array("table" => "app_article",
                "condition" => "app_article_groups.id=app_article.group_id",
                "jointype" => "LEFT")
        );
        $order = "app_article_groups.created_on  DESC";
        $group_by = "app_article_groups.id";
        $group = $this->model_knowledge_base->getData("app_article_groups", "app_article_groups.*, COUNT(app_article.id) as total", "", $join, $order, $group_by);
        $data['group_data'] = $group;
        $this->load->view('group_index', $data);
    }

    //show article list
    public function manage_knowledge_article($group_id = 0) {
        $data['title'] = $this->lang->line('Manage') . " " . $this->lang->line('Article');
        $group_id = (int) $this->uri->segment(2);
        $cond = '';
        if (isset($group_id) && $group_id > 0) {
            $cond = 'app_article.group_id = ' . $group_id;
        }
        $join = array(
            array(
                "table" => "app_article_groups",
                "condition" => "app_article_groups.id=app_article.group_id",
                "jointype" => "LEFT"),
        );
        $order = "app_article.created_on  DESC";
        $article = $this->model_knowledge_base->getData("app_article", "app_article.*,app_article_groups.title AS group_title", $cond, $join, $order);
        $data['article_data'] = $article;
        $this->load->view('article_index', $data);
    }

    //show add article form
    public function insert_knowledge_article() {
        $data['title'] = $this->lang->line('Insert') . " " . $this->lang->line('Article');
        $group = $this->model_knowledge_base->getData("app_article_groups", "*");
        $data['group_list'] = $group;
        $this->load->view('insert_article', $data);
    }

    //show edit article form
    public function edit_knowledge_article($id = null) {
        $data['title'] = $this->lang->line('Update') . " " . $this->lang->line('Article');
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $group = $this->model_knowledge_base->getData("app_article_groups", "*");
        $data['group_list'] = $group;
        $article = $this->model_knowledge_base->getData("app_article", "*", 'id=' . $id);
        if (isset($article[0]) && !empty($article[0])) {
            $data['article_data'] = $article[0];
            $this->load->view('edit_article', $data);
        } else {
            show_404();
        }
    }

    //add/edit article
    public function save_knowledge_article() {
        $id = (int) $this->input->post('id', true);
        $admin_id = $this->session->userdata('ADMIN_ID');
        $group_id = (int) $this->input->post('group', true);
        $this->form_validation->set_rules('group', $this->lang->line('group'), 'required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required|callback_check_title[' . $group_id . ',' . $id . ']');
        $this->form_validation->set_message('check_title', $this->lang->line('title_already'));
        $this->form_validation->set_rules('seo_keyword', $this->lang->line('SEO') . ' ' . $this->lang->line('keyword'), 'required');
        $this->form_validation->set_rules('seo_description', $this->lang->line('SEO') . ' ' . $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');

        if ($this->form_validation->run() == false) {
            $this->insert_knowledge_article();
        } else {
            $data = array(
                'group_id' => $this->input->post('group', true),
                'title' => $this->input->post('title', true),
                'seo_keyword' => $this->input->post('seo_keyword', true),
                'seo_description' => $this->input->post('seo_description', true),
                'slug' => slugify($this->input->post('title', true)),
                'status' => $this->input->post('status', true),
                'open_comment' => $this->input->post('open_comment', true),
                'created_by' => $admin_id,
                'description' => $_POST['description']
            );
            if ($id > 0) {
                $data['updated_on'] = date("Y-m-d H:i:s");
                $this->model_knowledge_base->update("app_article", $data, 'ID = ' . $id);
                $this->session->set_flashdata('msg', $this->lang->line('Article_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_on'] = date("Y-m-d H:i:s");
                $this->model_knowledge_base->insert('app_article', $data);
                $this->session->set_flashdata('msg', $this->lang->line('Article_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('manage-article', 'redirect');
        }
    }

    //show add group form
    public function insert_knowledge_group() {
        $data['title'] = $this->lang->line('Insert') . " " . $this->lang->line('Group');
        $this->load->view('insert_group', $data);
    }

    //show edit group form
    public function edit_knowledge_group($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $data['title'] = $this->lang->line('Update') . " " . $this->lang->line('Article');
        $group = $this->model_knowledge_base->getData("app_article_groups", "*", 'id = ' . $id);
        if (isset($group[0]) && !empty($group[0])) {
            $data['group_data'] = $group[0];
            $this->load->view('edit_group', $data);
        } else {
            show_404();
        }
    }

    //add/edit group
    public function save_knowledge_group() {
        $id = (int) $this->input->post('id', true);

        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required|is_unique[app_article_groups.title.id.' . $id . ']');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'required');
        $this->form_validation->set_rules('seo_keyword', $this->lang->line('SEO') . ' ' . $this->lang->line('keyword'), 'required');
        $this->form_validation->set_rules('seo_description ', $this->lang->line('SEO') . ' ' . $this->lang->line('description'), '  required');
        $this->form_validation->set_message('is_unique', '%s ' . $this->lang->line('already_exist'));
        $this->form_validation->set_rules('group-icon', $this->lang->line('group') . ' ' . $this->lang->line('icon'), 'required');
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->insert_knowledge_group();
        } else {
            $data = array(
                'title' => $this->input->post('title', true),
                'description' => $_POST['description'],
                'seo_keyword' => $this->input->post('seo_keyword', true),
                'seo_description' => $this->input->post('seo_description', true),
                'group_icon' => $this->input->post('group-icon', true),
                'slug' => slugify($this->input->post('title', true)),
                'created_by' => $this->session->userdata('ADMIN_ID', true),
            );
            if (isset($id) && $id > 0) {
                $data['updated_on'] = date("Y-m-d H:i:s");
                $status = $this->input->post('status', true);
                $group_article = $this->model_knowledge_base->getData("app_article", "*", 'group_id = ' . $id);
                if (count($group_article) > 0 && $status == "I") {
                    $this->session->set_flashdata('msg', $this->lang->line('group_status_error'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('edit-group/' . $id, 'redirect');
                } else {
                    $data['status'] = $this->input->post('status', true);
                }
                $this->model_knowledge_base->update("app_article_groups", $data, 'id = ' . $id);
                $this->session->set_flashdata('msg', $this->lang->line('Group_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_on'] = date("Y-m-d H:i:s");
                $data['status'] = $this->input->post('status', true);
                $this->model_knowledge_base->insert('app_article_groups', $data);
                $this->session->set_flashdata('msg', $this->lang->line('Group_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('manage-group', 'redirect');
        }
    }

    //delete article
    public function delete_knowledge_article($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $this->model_knowledge_base->delete('app_article', 'id = ' . $id);
        $this->session->set_flashdata('msg', $this->lang->line('Article_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        redirect('manage-article', 'redirect');
    }

    //show delete group
    public function delete_knowledge_group($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $this->model_knowledge_base->delete('app_article_groups', 'id = ' . $id);
        $this->session->set_flashdata('msg', $this->lang->line('Something_wrong'));
        $this->session->set_flashdata('msg_class', 'success');
        redirect('manage-group', 'redirect');
    }

    //show delete group & article both
    public function delete_group_article($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        if ($id > 0) {
            $this->model_knowledge_base->delete('app_article', 'group_id = ' . $id);
            $this->model_knowledge_base->delete('app_article_groups', 'id = ' . $id);
            $this->session->set_flashdata('msg', $this->lang->line('Article_group_delete'));
            $this->session->set_flashdata('msg_class', 'success');
        } else {
            $this->session->set_flashdata('msg', $this->lang->line('Something_wrong_group'));
            $this->session->set_flashdata('msg_class', 'failure');
        }
        redirect('manage-group', 'redirect');
    }

    //show article comments
    public function article_comments($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $data['title'] = $this->lang->line('Article') . " " . $this->lang->line('Comments');

        $join = array(
            array(
                "table" => "app_article",
                "condition" => "app_article.id=app_comment.artical_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_comment.customer_id",
                "jointype" => "LEFT")
        );

        $group_by = "app_comment.id";
        $fields = "app_article.title,app_comment.*, app_customer.first_name, app_customer.last_name";
        $order = "created_on  DESC";
        $article_comments = $this->model_knowledge_base->getData("app_comment", $fields, 'artical_id = ' . $id . ' AND perent_id = 0', $join, $order, $group_by);
        $data['article_comments_data'] = $article_comments;

        $this->load->view('article_comments', $data);
    }

    //show article comments details
    public function comments_details($id = null) {
        if ($id == null) {
            $comment_id = $this->uri->segment(2);
            $artical_id = $this->uri->segment(3);
            $id = $this->uri->segment(2);
        }
        $cond = "id ='$comment_id'";
        $cond_sub = "perent_id ='$comment_id' AND artical_id='$artical_id'";
        $main_comment = $this->model_knowledge_base->getData("app_comment", "*", $cond);
        $sub_comment = $this->model_knowledge_base->getData("app_comment", "*", $cond_sub);
        $data['comments_data'] = $main_comment[0];
        $data['sub_comments_data'] = $sub_comment;
        $data['title'] = $this->lang->line('Article') . " " . $this->lang->line('Comments') . " " . $this->lang->line('Details');
        $join = array(
            array(
                "table" => "app_article",
                "condition" => "app_article.id=app_comment.artical_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_comment.customer_id",
                "jointype" => "LEFT")
        );

        $group_by = "app_comment.id";
        $fields = "app_article.title,app_comment.*,app_customer.first_name, app_customer.last_name";
        $cond = "perent_id = ' . $id . '";
        $order = "created_on  DESC";
        $article_comments = $this->model_knowledge_base->getData("app_comment", $fields, $cond, $join, $order, $group_by);
        $data['article_comments_data'] = $article_comments;
        $this->load->view('comments_details', $data);
    }

    //send comments reply
    public function comment_reply_send() {
        $comment_id = (int) $this->input->post('comment_id', true);
        $artical_id = (int) $this->input->post('artical_id', true);
        $comment = $this->input->post('comment', true);
        $admin_id = (int) $this->session->userdata("ADMIN_ID");
        if (isset($admin_id) && $admin_id > 0) {
            $data = array(
                'customer_id' => $admin_id,
                'artical_id' => $artical_id,
                'perent_id' => $comment_id,
                'comment' => $comment,
                'user_type' => 'A',
                'created_on' => date("Y-m-d H:i:s"),
            );
            $this->model_knowledge_base->insert("app_comment", $data);
            redirect("comments-details/$comment_id/$artical_id", 'redirect');
        } else {
            $this->session->set_flashdata('msg', $this->lang->line('Something_wrong'));
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('dashboard', 'redirect');
        }
    }

    public function check_group_title() {
        $id = (int) $this->input->post('id');
        $title = $this->input->post('title');
        if (isset($id) && $id > 0) {
            $where = "title='$title' AND id!='$id'";
        } else {
            $where = "title='$title'";
        }
        $check_title = $this->model_knowledge_base->getData("app_article_groups", "title", $where);
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    public function check_article_title() {
        $id = (int) $this->input->post('id');
        $title = $this->input->post('title');
        $group_id = (int) $this->input->post('group');
        if (isset($id) && $id > 0) {
            $where = "title='$title' AND group_id='$group_id' AND id!='$id'";
        } else {
            $where = "title='$title' AND group_id='$group_id'";
        }
        $check_title = $this->model_knowledge_base->getData("app_article", "title", $where);
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    public function check_title($title, $param) {
        $param_array = explode(",", $param);
        $group_id = $param_array[0];
        $id = $param_array[1];
        if (isset($id) && $id > 0) {
            $where = "title='$title' AND group_id='$group_id' AND id!='$id'";
        } else {
            $where = "title='$title' AND group_id='$group_id'";
        }
        $check_title = $this->model_knowledge_base->getData("app_article", "title", $where);
        if (isset($check_title) && count($check_title) > 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>