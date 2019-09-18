<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$site_url = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
$site_url .= '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$site_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
if ($site_url == ADMIN_PATH) {
    $route['default_controller'] = "admin_content/login";
} else {
    $route['default_controller'] = "front";
}
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/*
 *  Frontend Routes
 */
$route['front'] = "front/index";
$route['v1'] = "front/index";
$route['v2'] = "front/index";
$route['v3'] = "front/index";
$route['v4'] = "front/index";
$route['faqs'] = "front/faqs";
$route['community'] = "front/community";
$route['community/topics/(:any)'] = "front/topics";
$route['community/topics/(:any)/(:any)'] = "front/topics";
$route['community/topics/(:any)/(:any)/(:any)'] = "front/topics";
$route['subscription/(:any)'] = "front/subscription";
$route['subscription/(:any)/(:any)'] = "front/subscription";
$route['community/posts/(:any)'] = "front/posts";
$route['post-vote/(:any)'] = "front/post_vote";
$route['community_post'] = "front/community_post";
$route['general-discussion'] = "front/general_discussion";
$route['groups/(:any)'] = "front/group_details";
$route['articles/(:any)'] = "front/article_details";
$route['submit_request'] = "front/submit_request";
$route['submit_request_action'] = "front/submit_request_action";
$route['search-article'] = "front/search_article";
$route['user_profile/(:num)'] = "front/user_profile/$1";
$route['post-comment'] = "front/post_comment";
$route['post-comment-action'] = "front/post_comment_action";
$route['add-article-helpful'] = "front/add_article_helpful";
$route['community-post'] = "front/community_post";
$route['post-action'] = "front/post_action";
$route['customer-profile/(:num)'] = "front/customer_profile/$1";
$route['post-subscription/(:any)'] = "front/post_subscription";
$route['post-unscription/(:any)'] = "front/post_unscription";


//content routes
$route['login'] = 'content/login';
$route['logout'] = 'content/logout';
$route['profile'] = 'content/profile';
$route['register'] = 'content/register';
$route['login-action'] = 'content/login_action';
$route['profile-save'] = 'content/profile_save';
$route['register-save'] = 'content/register_save';
$route['forgot-password'] = 'content/forgot_password';
$route['forgot-password-action'] = 'content/forgot_password_action';
$route['reset-password-admin/(:any)/(:any)'] = 'content/reset_password';
$route['reset-password-admin-action'] = 'content/reset_password_action';
$route['update-password'] = 'content/update_password';
$route['update-password-action'] = 'content/update_password_action';

// dashboard 
$route['dashboard'] = 'dashboard/index';

// User Login 
$route['request'] = 'request/index';
$route['submit-request-reply/(:num)'] = 'request/submit_request_reply/$1';
$route['request-reply-send'] = 'request/request_reply_send';
$route['request-seen-msg'] = 'request/request_seen_msg';
$route['change-request-status'] = 'request/change_request_status';

// Customer Manage Post
$route['post-manage'] = 'customer_post/index';
$route['post-insert'] = 'customer_post/insert_post';
$route['post-save'] = 'customer_post/save_post';
$route['post-manage/(:num)'] = 'customer_post/index/$1';
$route['post-edit/(:any)'] = 'customer_post/edit_post/$1';
$route['post-delete/(:any)'] = 'customer_post/delete_post/$1';

$route['post-title-check'] = 'customer_post/check_post_title';

// Customer Report
$route['reports'] = 'customer_report/index';




/* Admin routes start */

/* Admin Content */
$route['admin-login'] = 'admin_content/login';
$route['admin-logout'] = 'admin_content/logout';
$route['admin-profile'] = 'admin_content/profile';
$route['admin-login-action'] = 'admin_content/login_action';
$route['admin-profile-save'] = 'admin_content/profile_save';
$route['admin_forgot-password'] = 'admin_content/forgot_password';
$route['admin-forgot-password-action'] = 'admin_content/forgot_password_action';
$route['admin-reset-password-admin/(:any)/(:any)'] = 'admin_content/reset_password_admin';
$route['admin-reset-password-admin-action'] = 'admin_content/reset_password_admin_action';
$route['admin-update-password'] = 'admin_content/update_password';
$route['admin-update-password-action'] = 'admin_content/update_password_action';

/* Admin Dashboard Articles and Groups */
$route['admin-dashboard'] = 'admin_dashboard/index';

/* knowledge base */
$route['manage-group'] = 'knowledge_base/index';
$route['manage-article'] = 'knowledge_base/manage_knowledge_article';
$route['manage-article/(:num)'] = 'knowledge_base/manage_knowledge_article/$1';
$route['insert-article'] = 'knowledge_base/insert_knowledge_article';
$route['edit-article/(:any)'] = 'knowledge_base/edit_knowledge_article/$1';
$route['insert-group'] = 'knowledge_base/insert_knowledge_group';
$route['edit-group/(:any)'] = 'knowledge_base/edit_knowledge_group/$1';
$route['save-article'] = 'knowledge_base/save_knowledge_article';
$route['save-group'] = 'knowledge_base/save_knowledge_group';
$route['article-knowledge-status'] = 'knowledge_base/article_knowledge_status';
$route['group-knowledge-status'] = 'knowledge_base/group_knowledge_status';
$route['delete-knowledge-article/(:any)'] = 'knowledge_base/delete_knowledge_article/$1';
$route['delete-knowledge-group/(:any)'] = 'knowledge_base/delete_knowledge_group/$1';
$route['delete-group-article'] = 'knowledge_base/delete_group_article';
$route['article-comments'] = 'knowledge_base/index';
$route['comments-details'] = 'knowledge_base/index';
$route['article-comments/(:any)'] = 'knowledge_base/article_comments';
$route['comments-details/(:any)/(:any)'] = 'knowledge_base/comments_details';
$route['comment-reply-send'] = 'knowledge_base/comment_reply_send';
$route['check-group-title'] = 'knowledge_base/check_group_title';
$route['check-article-title'] = 'knowledge_base/check_article_title';


// Community Forum
$route['manage-topic'] = 'community_forum/index';
$route['insert-topic'] = 'community_forum/insert_topic';
$route['save-topic'] = 'community_forum/save_topic';
$route['edit-topic/(:any)'] = 'community_forum/edit_topic/$1';
$route['delete-topic/(:any)'] = 'community_forum/delete_topic/$1';
$route['manage-post'] = 'community_forum/manage_post';
$route['insert-post'] = 'community_forum/insert_post';
$route['save-post'] = 'community_forum/save_post';
$route['manage-post/(:num)'] = 'community_forum/manage_post/$1';
$route['edit-post/(:any)'] = 'community_forum/edit_post/$1';
$route['delete-post/(:any)'] = 'community_forum/delete_post/$1';
$route['check-topic-title'] = 'community_forum/check_topic_title';
$route['check-post-title'] = 'community_forum/check_post_title';

$route['post-comments'] = 'community_forum/index';
$route['post-comments/(:any)'] = 'community_forum/post_comments';
$route['post-comments-details'] = 'community_forum/index';
$route['post-comments-details/(:any)/(:any)'] = 'community_forum/post_comments_details';
$route['post-comment-reply'] = 'community_forum/post_comment_reply';
$route['admin-post-comment/(:any)'] = 'community_forum/add_post_comment';
$route['action-post-comment'] = 'community_forum/action_post_comment';



//site setting
$route['sitesetting'] = 'sitesetting/index';
$route['save-sitesetting'] = 'sitesetting/save_sitesetting';
$route['email-setting'] = 'sitesetting/email_setting';
$route['save-email-setting'] = 'sitesetting/save_email_setting';

// admin response 
$route['admin-request'] = 'admin_request/index';
$route['admin-submit-request-reply/(:num)'] = 'admin_request/submit_request_reply/$1';
$route['admin-request-reply-send'] = 'admin_request/request_reply_send';
$route['admin-change-request-status'] = 'admin_request/admin_change_request_status';
$route['assign-request'] = 'admin_request/assign_request';
$route['assign-action'] = 'admin_request/assign_action';

//user module
$route['customer'] = 'customer/index';
$route['delete-customer/(:any)'] = 'customer/delete_customer/$1';
$route['change-customer-status/(:any)'] = 'customer/change_customer_tatus/$1';

//agent module
$route['add-agent'] = 'agent/add_agent';
$route['update-agent/(:any)'] = 'agent/update_agent/$1';
$route['save-agent'] = 'agent/save_agent';
$route['delete-agent/(:any)'] = 'agent/delete_agent/$1';

//category module
$route['add-category'] = 'category/add_category';
$route['update-category/(:any)'] = 'category/update_category/$1';
$route['save-category'] = 'category/save_category';
$route['delete-category/(:any)'] = 'category/delete_category/$1';

//faq module
$route['add-faq'] = 'faq/add_faq';
$route['update-faq/(:any)'] = 'faq/update_faq/$1';
$route['save-faq'] = 'faq/save_faq';
$route['delete-faq/(:any)'] = 'faq/delete_faq/$1';
$route['check-faq-title'] = 'faq/check_faq_title';

$route['report'] = 'report/index';
$route['community-report'] = 'report/community_report';

//Themes Selection
$route['theme'] = "theme/index";
$route['theme_articles'] = "theme/theme_articles";
$route['theme_community'] = "theme/theme_community";
$route['theme_community_post'] = "theme/theme_community_post";
$route['theme_customer_profile'] = "theme/theme_customer_profile";
$route['theme_faqs'] = "theme/theme_faqs";
$route['theme_groups'] = "theme/theme_groups";
$route['theme_posts'] = "theme/theme_posts";
$route['theme_submit_request'] = "theme/theme_submit_request";
$route['theme_topics'] = "theme/theme_topics";
$route['theme_user_profile'] = "theme/theme_user_profile";
$route['theme_login'] = "theme/theme_login";
$route['theme_register'] = "theme/theme_register";
$route['theme_forgot_password'] = "theme/theme_forgot_password";