<?php

function get_default_theme() {
    return "theme1";
}

function get_CompanyName() {
    $CI = & get_instance();
    $CI->db->select('company_name');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return $user_data[0]['company_name'];
}

function get_comment($AID) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_comment');
    $where = "artical_id='$AID' AND perent_id='0'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return $user_data;
}

function community_banner() {
    $CI = & get_instance();
    $CI->db->select('community_banner');
    $CI->db->from('app_site_setting');
    $CI->db->where("id", "1");
    $user_data = $CI->db->get()->result_array();
    return $user_data[0]['community_banner'];
}

function get_comment_user($TYPE, $ID) {
    $CI = & get_instance();
    if ($TYPE == 'A') {
        $CI->db->select('*');
        $CI->db->from('app_admin');
        $CI->db->where("id", $ID);
        $user_data = $CI->db->get()->result_array();
    } else {
        $CI->db->select('*');
        $CI->db->from('app_customer');
        $CI->db->where("id", $ID);
        $user_data = $CI->db->get()->result_array();
    }
    return $user_data[0];
}

function get_sub_comment($SID) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_comment');
    $CI->db->where("perent_id", $SID);
    $user_data = $CI->db->get()->result_array();
    return $user_data;
}

function postsub_comment($SID) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_post_comment');
    $CI->db->where("perent_id", $SID);
    $user_data = $CI->db->get()->result_array();
    return $user_data;
}

function get_unread_requst($RID) {
    $CI = & get_instance();
    $USERID = $CI->session->userdata('UserID');
    $CI->db->select('*');
    $CI->db->from('app_submit_request');
    $where = "parent_id='$RID' AND request_read='U' AND user_type='A'";
    $CI->db->where($where);
    $query = $CI->db->get();
    $user_data = $query->num_rows();
    return $user_data;
}

function get_unread_requst_admin($RID) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_submit_request');
    $where = "parent_id='$RID' AND request_read='U' AND user_type='U'";
    $CI->db->where($where);
    $query = $CI->db->get();
    $user_data = $query->num_rows();
    return $user_data;
}

function get_request_user($TYPE, $ID) {
    $CI = & get_instance();
    if ($TYPE == 'A') {
        $CI->db->select('*');
        $CI->db->from('app_admin');
        $CI->db->where("id", $ID);
        $user_data = $CI->db->get()->result_array();
    } else {
        $CI->db->select('*');
        $CI->db->from('app_customer');
        $CI->db->where("id", $ID);
        $user_data = $CI->db->get()->result_array();
    }
    return $user_data[0];
}

function article_view($ID, $IP) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_article_view');
    $where = "ip_address='$IP' AND article_id='$ID'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    if (count($user_data) == 0) {
        $data = array(
            'article_id' => $ID,
            'ip_address' => $IP,
            'created_on' => date("Y-m-d H:i:s")
        );
        $CI->db->insert('app_article_view', $data);
        $id = $CI->db->insert_ID();
    }
    return "success";
}

function post_view($ID, $IP) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('app_post_view');
    $where = "ip_address='$IP' AND post_id='$ID'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    if (count($user_data) == 0) {
        $data = array(
            'post_id' => $ID,
            'ip_address' => $IP,
            'created_on' => date("Y-m-d H:i:s")
        );
        $CI->db->insert('app_post_view', $data);
        $CI->db->insert_ID();
        $CI->db->where('id', $ID);
        $CI->db->set('total_views', 'total_views+1', FALSE);
        $CI->db->update('app_post');
    }
    return "success";
}

function get_breadcrumb($TABLE, $WHERE) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from($TABLE);
    $CI->db->where($WHERE);
    $user_data = $CI->db->get()->result_array();
    return $user_data[0];
}

function get_helpful($AID) {
    $CI = & get_instance();
    $CI->db->select('COUNT(is_helpful) AS total');
    $CI->db->from("app_article_helpful");
    $CI->db->where('article_id', $AID);
    $CI->db->group_by("is_helpful");
    $user_data = $CI->db->get()->result_array();
    $Y = $N = 0;
    foreach ($user_data as $value) {
        if ($value['is_helpful'] == "Y") {
            $Y = $value['total'];
        } else {
            $N = $value['total'];
        }
    }
    
    return $Y . " / " . $N;
}

function slugify($str) {
    $search = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
    $str = str_ireplace($search, $replace, strtolower(trim($str)));
    $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
    $str = str_replace(' ', '-', $str);
    return preg_replace('/\-{2,}/', '-', $str);
}

function get_Langauge() {
    $CI = & get_instance();
    $CI->db->select('language');
    $CI->db->from('app_site_setting');
    $where = "id='1'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    if (isset($user_data) && $user_data > 0) {
        $file = APPPATH . "/language/" . $user_data[0]['language'] . "/";
        if (is_dir($file)) {
            return strtolower($user_data[0]['language']);
        } else {
            return strtolower($CI->config->item('language'));
        }
    } else {
        return strtolower($CI->config->item('language'));
    }
}

function get_assign_agent($agent_id) {
    $CI = & get_instance();
    $agent_array = array_diff(explode(",", $agent_id), array(0));
    if (!empty($agent_array) && count($agent_array) > 0) {
        foreach ($agent_array as $value) {
            $CI->db->select('id,first_name,last_name,profile_image');
            $CI->db->from('app_admin');
            $where = "user_type='E' AND id='$value'";
            $CI->db->where($where);
            $user_data[] = $CI->db->get()->result_array();
        }
        if (!empty(array_filter($user_data)) && count(array_filter($user_data)) > 0) {
            return $user_data;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_reply_user($id, $type) {
    $CI = & get_instance();
    if ($id == '0') {
        return false;
    }
    if ($type == 'A') {
        $CI->db->select('first_name,last_name,profile_image');
        $CI->db->from('app_admin');
        $CI->db->where("id", $id);
        $user_data = $CI->db->get()->result_array();
    } else {
        $CI->db->select('first_name,last_name,profile_image');
        $CI->db->from('app_customer');
        $CI->db->where("id", $id);
        $user_data = $CI->db->get()->result_array();
    }
    return $user_data[0];
}

function get_group_articles($group_id) {
    $CI = & get_instance();
    if ($group_id == '0') {
        return false;
    }
    if ($group_id) {
        $CI->db->where("status", "A");
        $CI->db->where("group_id", $group_id);
        $CI->db->order_by("app_article.id", "DESC");
        $CI->db->limit(5);
        $article_data = $CI->db->get('app_article')->result_array();
        return $article_data;
    }
}

function get_table_record($tbl = '', $fields, $condition = '', $join_ary = array()) {
    $CI = & get_instance();
    $CI->db->select($fields, false);
    if (is_array($join_ary) && count($join_ary) > 0) {
        foreach ($join_ary as $ky => $vl) {
            $CI->db->join($vl['table'], $vl['condition'], $vl['jointype']);
        }
    }
    $CI->db->where($condition, false, false);
    $CI->db->from($tbl);
    $list_data = $CI->db->get()->result_array();
    return $list_data;
}

function check_code($str) {
    $string = remove_code($str);
    return $string;
}

function remove_code($str) {
    if (strpos($str, "<pre>") == true) {
        $str_start = substr($str, 0, strpos($str, "<pre>"));
        $str_end = substr($str, strpos($str, "</pre>") + 6);
        remove_code($str_start . $str_end);
    } else {
        echo $str;
    }
}

function GroupArticle($group_id) {
    $CI = & get_instance();
    $CI->db->select('id,title,created_on');
    $CI->db->from('app_article');
    $CI->db->where('group_id', $group_id);
    $CI->db->order_by('id desc');
    $CI->db->limit(9);
    $result = $CI->db->get()->result_array();
    return $result;
}

function ArticleComment($artical_id) {
    $CI = & get_instance();
    $CI->db->select('id');
    $CI->db->from('app_comment');
    $CI->db->where('artical_id', $artical_id);
    $CI->db->where('perent_id', 0);
    $result = $CI->db->get()->result_array();
    return count($result);
}

?>
