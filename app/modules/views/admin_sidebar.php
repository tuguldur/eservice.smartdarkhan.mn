<?php
$this->db->select('*', false);
$this->db->from('app_site_setting');
$company_data = $this->db->get()->row();
$root_dir = dirname(BASEPATH) . "/" . uploads_path . '/sitesetting/';
if (isset($company_data->company_logo) && $company_data->company_logo != "") {
    if (file_exists($root_dir . $company_data->company_logo)) {
        $logo_image = ROOT_LOCATION . uploads_path . '/sitesetting/' . $company_data->company_logo;
    } else {
        $logo_image = ROOT_LOCATION . img_path . "/no-image.png";
    }
} else {
    $logo_image = ROOT_LOCATION . img_path . "/no-image.png";
}
////////////////////////////////////////////////////////////
$url_segment = trim($this->uri->segment(1));
$dashboard_active = "";
$group_knowledge_active = "";
$article_knowledge_active = "";
$topics_active = "";
$post_active = "";
$sitesetting_active = "";
$sitesetting_email_active = "";
$submit_request_active = "";
$customer_active = "";

$sitesetting_open = "";
$report_open = "";
$knowledge_open = "";
$community_forum = "";
$assign_active = "";
$submit_request_open = "";
$agent_active = "";
$faq_active = "";
$community_report_active = "";
$category_active = "";
$report_active = "";

$group_knowledge_Arr = array("manage-group", "insert-group", "edit-group");
$article_knowledge_Arr = array("manage-article", "insert-article", "edit-article");

$topics_Arr = array("manage-topic", "insert-topic", "edit-topic", "delete-topic");
$post_Arr = array("manage-post", "insert-post", "edit-post", "delete-post");

$sitesetting_active_Arr = array("sitesetting", "save-sitesetting",);
$sitesetting_email_Arr = array("email-setting", "save-email-setting",);
$agent_Arr = array("agent", "add-agent", 'update-agent', 'save-agent', 'delete-agent');
$faq_Arr = array("faq", "add-faq", 'update-faq', 'save-faq', 'delete-faq');

$submit_requestArr = array("admin-request", "admin-submit-request-reply", "admin-request-reply-send");
$customer_requestArr = array("customer");
$report_Arr = array("report");
$community_reportArr = array("community-report");
$assignArr = array("assign-request", "assign-action");
$categoryArr = array("category", "add_category", "update_category", "save_category");


if (empty($url_segment) || in_array($url_segment, array('admin-dashboard'))) {
    $dashboard_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $agent_Arr)) {
    $agent_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $faq_Arr)) {
    $faq_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $report_Arr)) {
    $report_active = "active";
    $report_open = "open";
} elseif (isset($url_segment) && in_array($url_segment, $community_reportArr)) {
    $community_report_active = "active";
    $report_open = "open";
} elseif (isset($url_segment) && in_array($url_segment, $group_knowledge_Arr)) {
    $group_knowledge_active = "active";
    $knowledge_open = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $article_knowledge_Arr)) {
    $article_knowledge_active = "active";
    $knowledge_open = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $topics_Arr)) {
    $topics_active = "active";
    $community_forum = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $post_Arr)) {
    $post_active = "active";
    $community_forum = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $sitesetting_active_Arr)) {
    $sitesetting_active = "active";
    $sitesetting_open = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $sitesetting_email_Arr)) {
    $sitesetting_email_active = "active";
    $sitesetting_open = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $submit_requestArr)) {
    $submit_request_active = "active";
    $submit_request_open = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $customer_requestArr)) {
    $customer_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $categoryArr)) {
    $category_active = "active";
    $submit_request_open = 'open';
} elseif (isset($url_segment) && in_array($url_segment, $assignArr)) {
    $assign_active = "active";
    $submit_request_open = 'open';
}
?>

<div id="dashboard-options-menu" class="side-bar dashboard left closed">
    <div class="svg-plus">
        <img src="<?php echo ROOT_LOCATION . img_path; ?>/sidebar/close-icon.png" alt="close"/>
    </div>
    <div class="side-bar-header">
        <div class="user-quickview text-center px-2">
            <div class="outer-ring">
                <a href="<?php echo ROOT_LOCATION; ?>">
                    <figure class="user-img">
                        <img src="<?php echo $logo_image; ?>" alt='side profile' class="img-fluid w-auto"/>
                    </figure>
                </a>
            </div>
            <p class="user-name"></p>
        </div>
    </div>
    <ul class="dropdown dark hover-effect interactive list-inline">
        <li class="<?php echo $dashboard_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('admin-dashboard'); ?>">
                <i class="fa fa-dashboard pr-2"></i>
                УДИРДЛАГЫН САМБАР
            </a>
        </li>
        <?php if ($this->session->userdata('ADMIN_TYPE') == 'A') { ?>
            <li class="<?php echo $agent_active; ?> dropdown-item p-0">
                <a href="<?php echo base_url('agent'); ?>">
                    <i class="fa fa-user-secret pr-2"></i>
                    ҮЙЛЧИЛГЭЭНИЙ АЖИЛЧИД
                </a>
            </li>
            <li class="<?php echo $customer_active; ?> dropdown-item p-0">
                <a href="<?php echo base_url('customer'); ?>">
                    <i class="fa fa-user pr-2"></i>
                    ХЭРЭГЛЭГЧИЙН БҮРТГЭЛ 
                </a>

            </li>
        <?php } ?>

        <li class="dropdown-item interactive p-0 <?php echo $group_knowledge_active . $article_knowledge_active; ?>">
            <a href="<?php echo base_url('manage-group'); ?>">
                <i class="fa fa-info-circle pr-2"></i>
                ҮЙЛЧИЛГЭЭНИЙ МЭДЭЭЛЭЛ
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $knowledge_open; ?> inner-dropdown ">
                <li class="<?php echo $group_knowledge_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('manage-group'); ?>">БАЙГУУЛЛАГУУД</a>
                </li>
                <li class="<?php echo $article_knowledge_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('manage-article'); ?>">МЭДЭЭЛЭЛҮҮД</a>
                </li>
            </ul>
            <!-- /INNER DROPDOWN -->
        </li> 

        <li class="dropdown-item interactive p-0 <?php echo $submit_request_active . $category_active . $assign_active; ?>">
            <a href="<?php echo base_url('admin-request'); ?>">
                <i class="fa fa-paper-plane pr-2"></i>
                ЦАХИМ ЗӨВШӨӨРӨЛ 
                <i class="fa fa-angle-down pl-3"></i>
            </a>
            <!-- INNER DROPDOWN -->
            <ul class="<?php echo $submit_request_open; ?> inner-dropdown ">
                <li class="<?php echo $submit_request_active; ?> inner-dropdown-item p-0">
                    <a href="<?php echo base_url('admin-request'); ?>">
                       БҮХ ЗӨВШӨӨРӨЛҮҮД
                    </a>
                </li>
                <?php if ($this->session->userdata('ADMIN_TYPE') == 'A') { ?>
                    <li class="<?php echo $category_active; ?> inner-dropdown-item p-0">
                        <a href="<?php echo base_url('category'); ?>">
                            ЗӨВШӨӨРӨЛИЙН ТӨРӨЛ
                        </a>
                    </li>
                    <li class="<?php echo $assign_active; ?> inner-dropdown-item p-0">
                        <a href="<?php echo base_url('assign-request'); ?>">
                            ҮЙЛЧИЛГЭЭНИЙ АЖИЛТАН
                        </a>
                    </li>
                    </ul>
                    <?php } ?>
                    
        <?php if ($this->session->userdata('ADMIN_TYPE') == 'A') { ?>
            
                


            <li class="dropdown-item interactive p-0 <?php echo $sitesetting_active . $sitesetting_email_active; ?>">
                <a href="<?php echo base_url('sitesetting'); ?>">
                    <i class="fa fa-cog pr-2"></i>
                    САЙТ ТОХИРГОО
                    <i class="fa fa-angle-down pl-3"></i>
                </a>
                <!-- INNER DROPDOWN -->
                <ul class="<?php echo $sitesetting_open; ?> inner-dropdown ">
                    <li class="<?php echo $sitesetting_active; ?> inner-dropdown-item p-0">
                        <a href="<?php echo base_url('sitesetting'); ?>">
                            <?php echo $this->lang->line('Site_Setting'); ?>
                        </a>
                    </li>
                    <li class="<?php echo $sitesetting_email_active; ?> inner-dropdown-item p-0">
                        <a href="<?php echo base_url('email-setting'); ?>">
                            <?php echo $this->lang->line('Email'); ?>  <?php echo $this->lang->line('Setting'); ?>
                        </a>
                    </li>
                </ul>
                <!-- /INNER DROPDOWN -->
            </li>  
        <?php } ?>
                
            </ul>
            <!-- /INNER DROPDOWN -->
        </li>  
    </ul>
</div>
<!-- End Sidebar -->
