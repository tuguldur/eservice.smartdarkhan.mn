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
////////////////////////////////////////////////////////////
$url_segment = trim($this->uri->segment(1));
$knowledge_active = "";
$faq_active = "";
$community_active = "";
$submit_request_active = "";
$register_active = "";
$knowledge_Arr = array("group_details", "article_details",);
$submit_requestArr = array("submit_request");
$community_activeArr = array("community");
$register_requestArr = array("register");
$faqArr = array("faqs");
if (isset($url_segment) && in_array($url_segment, $knowledge_Arr)) {
    $knowledge_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $submit_requestArr)) {
    $submit_request_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $community_activeArr)) {
    $community_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $register_requestArr)) {
    $register_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $faqArr)) {
    $faq_active = "active";
} else {
    $knowledge_active = "active";
}
$ID = (int) $this->session->userdata('UserID');
$this->db->select('*', false);
$this->db->where('ID=' . $ID);
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
$root_dir = FCPATH . uploads_path . '/sitesetting/';
if (isset($company_data->banner_image) && $company_data->banner_image != "") {
    if (file_exists($root_dir . $company_data->banner_image)) {
        $banner_image = base_url() . uploads_path . '/sitesetting/' . $company_data->banner_image;
    } else {
        $banner_image = base_url() . img_path . "/banner.png";
    }
} else {
    $banner_image = base_url() . img_path . "/banner.png";
}
$search = $this->input->get("search");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="<?php echo $this->config->item('images_url'); ?>favicon.png" type="image/x-icon" />
        <?php if (isset($meta_description) && $meta_description != '') { ?>
            <meta name="description" content="<?php echo $meta_description; ?>"/>
        <?php }if (isset($meta_keyword) && $meta_keyword != '') { ?>
            <meta name="keywords" content="<?php echo $meta_keyword; ?>"/>
        <?php } ?>   
        <title><?php
            echo get_CompanyName();
            if (!empty($title))
                echo " | " . $title;
            ?></title>
        <link href="<?php echo $this->config->item('css_url'); ?>font-awesome.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>knowledgebase.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>admin_panel.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>custom.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>homepage.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>style.css" rel="stylesheet" type="text/css">
        <script src="<?php echo $this->config->item('js_url'); ?>jquery-3.2.1.min.js"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>index.js" type="text/javascript"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
        <script>
            var base_url = '<?php echo base_url() ?>';
            var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!--loader-->
        <link href="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
        <script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
        <link href="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.css" rel="stylesheet"/>
        <script src="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="loadingmessage" class="loadingmessage"></div>
        <nav class="nav navbar">
            <div class="container">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">
                    <img src="<?php echo $logo_image; ?>" width="100%" height="60" alt="">
                </a> 
                <ul class="nav navbar-nav nav-flex-icons ml-auto sidbar_ulnav top_navbar">
                    

                    <li class="nav-item">
                        <a href="<?php echo base_url('') ?>" class="nav-link text-muted <?php echo $community_active; ?>">
                            <i class="fa fa-home"></i>
                            <span class="clearfix d-none d-sm-inline-block"><b>НҮҮР ХУУДАС</b></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo base_url('') ?>" class="nav-link text-muted <?php echo $community_active; ?>">
                            <i class="fa fa-user"></i>
                            <span class="clearfix d-none d-sm-inline-block"><b>ТУСЛАМЖ</b></span>
                        </a>
                    </li>

                    <?php if ($this->session->userdata('ADMIN_ID')) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url('admin/admin-dashboard') ?>" class="nav-link text-muted">
                                <i class="fa fa-dashboard"></i>
                                <?php
                                if ($this->session->userdata('ADMIN_TYPE') == 'A') {
                                    $name = 'Admin';
                                } else {
                                    $name = 'Agent';
                                }
                                ?>
                                <span class="clearfix d-none d-sm-inline-block"><b><?php echo $this->lang->line($name); ?> <?php echo $this->lang->line('Dashboard'); ?></b></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('admin/admin-logout') ?>" class="nav-link text-muted">
                                <i class="fa fa-sign-out"></i>
                                <span class="clearfix d-none d-sm-inline-block"><b><?php echo $this->lang->line('Log_Out'); ?></b></span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <?php if ($this->session->userdata('UserID')) { ?>
                                <a class="<?php echo $submit_request_active; ?> nav-link text-muted" href="<?php echo base_url('submit_request') ?>"><i class="fa fa-comments-o"></i> <span class="clearfix d-none d-sm-inline-block"><b class="<?php echo $submit_request_active; ?>">ЗӨВШӨӨРӨЛ</b></span></a>
                            <?php } else { ?>
                                <a class="<?php echo $submit_request_active; ?>   nav-link text-muted" data-toggle="modal" data-target="#myModal" ><i class="fa fa-comments-o"></i> <span class="clearfix d-none d-sm-inline-block"><b class="<?php echo $submit_request_active; ?>">ЗӨВШӨӨРӨЛ АВАХ</b></span></a>
                            <?php } ?>
                        </li>
                        <?php if (!$this->session->userdata('UserID')) { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('login') ?>" class="nav-link text-muted">
                                    <i class="fa fa-lock"></i>
                                    <span class="clearfix d-none d-sm-inline-block"><b><?php echo $this->lang->line('Login'); ?></b></span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a class="<?php echo $register_active; ?>  nav-link text-muted" href="<?php echo base_url('register') ?>"><i class="fa fa-user"></i> <span class="clearfix d-none d-sm-inline-block"><b class="<?php echo $register_active; ?>"><?php echo $this->lang->line('Register'); ?></b></span></a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('dashboard') ?>" class="nav-link text-muted">
                                    <img style='border-radius: 50%;' class='img-circle' src="<?php echo $ProfileImage; ?>" width="25" height="25" alt="">
                                    <span class="clearfix d-none d-sm-inline-block"><b><?php echo ucwords("Welcome" . ' ' . $profile_data->first_name); ?></b></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('logout') ?>" class="nav-link text-muted">
                                    <i class="fa fa-sign-out"></i>
                                    <span class="clearfix d-none d-sm-inline-block"><b><?php echo $this->lang->line('Log_Out'); ?></b></span>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </nav>
        <!--model-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo $this->lang->line('Submit'); ?> <?php echo $this->lang->line('Request'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p id='confirm_msg' style="font-size: 15px;"><?php echo $this->lang->line('Request_error'); ?></p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default pull-right" href="<?php echo base_url('login') ?>" ><?php echo $this->lang->line('Login'); ?></a>
                        <a class="btn btn-primary pull-right" href="<?php echo base_url('register') ?>" ><?php echo $this->lang->line('Register'); ?></a>
                    </div>
                </div>
            </div>
        </div>