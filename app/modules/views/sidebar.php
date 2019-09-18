<?php
$this->db->select('*', false);
$this->db->from('app_site_setting');
$company_data = $this->db->get()->row();
$root_dir = FCPATH . uploads_path . '/sitesetting/';
if (isset($company_data->company_logo) && $company_data->company_logo != "") {
    if (file_exists($root_dir . $company_data->company_logo)) {
        $logo_image = base_url() . uploads_path . '/sitesetting/' . $company_data->company_logo;
    } else {
        $logo_image = base_url() . img_path . "/no-image.png";
    }
} else {
    $logo_image = base_url() . img_path . "/no-image.png";
}
$ID = (int) $this->session->userdata('UserID');
$this->db->select('*', false);
$this->db->where('id=' . $ID);
$this->db->from('app_customer');
$profile_data = $this->db->get()->row();
$root_dir = FCPATH . uploads_path . '/profiles/';
if (isset($profile_data->profile_image) && $profile_data->profile_image != "") {
    if (file_exists($root_dir . $profile_data->profile_image)) {
        $ProfileImage = base_url() . uploads_path . '/profiles/' . $profile_data->profile_image;
    } else {
        $ProfileImage = base_url() . img_path . "/user.png";
    }
} else {
    $ProfileImage = base_url() . img_path . "/user.png";
}

////////////////////////////////////////////////////////////

$url_segment = trim($this->uri->segment(1));
$dashboard_active = "";
$submit_request_active = "";
$manage_post_active = "";
$activity_active = "";
$reports_active = "";
$submit_request_Arr = array("request", "submit-request-reply", "request-reply-send");
$manage_post_Arr = array("post-manage", "post-insert", "post-edit", "post-delete");
$activityArr = array("activity");
$reportsArr = array("reports");

if (empty($url_segment) || in_array($url_segment, array('dashboard'))) {
    $dashboard_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $submit_request_Arr)) {
    $submit_request_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $manage_post_Arr)) {
    $manage_post_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $activityArr)) {
    $activity_active = "enable";
} elseif (isset($url_segment) && in_array($url_segment, $reportsArr)) {
    $reports_active = "active";
}
?>

<div id="dashboard-options-menu" class="side-bar dashboard left closed">
    <div class="svg-plus">
        <img src="<?php echo base_url() . img_path; ?>/sidebar/close-icon.png" alt="close"/>
    </div>
    <div class="side-bar-header">
        <div class="user-quickview text-center">
            <div class="outer-ring">
                <a href="<?php echo base_url(); ?>">
                    <figure class="user-img">
                        <img src="<?php echo $ProfileImage; ?>" alt='side profile'/>
                    </figure>
                </a>
            </div>
            <p class="user-name"><?php echo ucwords($profile_data->first_name . " " . $profile_data->last_name); ?></p>
        </div>
    </div>
    <ul class="dropdown dark hover-effect interactive list-inline">
        <li class="<?php echo $dashboard_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('dashboard'); ?>">
                <i class="fa fa-dashboard pr-2"></i>
                САМБАР
            </a>
        </li>
        
        </li>
        <li class="<?php echo $submit_request_active; ?> dropdown-item p-0">
            <a href="<?php echo base_url('request'); ?>">
                <i class="fa fa-paper-plane pr-2"></i>
                ЦАХИМ ЗӨВШӨӨРӨЛ
            </a>
        </li>
    </ul>
</div>
<!-- End Sidebar -->