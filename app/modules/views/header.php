<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="<?php echo $this->config->item('images_url'); ?>favicon.png" type="image/x-icon" />
        <title>
            <?php
            echo get_CompanyName();
            if (!empty($title))
                echo " | " . $title;
            ?></title>        
        <link href="<?php echo $this->config->item('css_url'); ?>datatables.min.css" rel="stylesheet"/>
        <?php include APPPATH . '/modules/views/css.php'; ?>
        <script src="<?php echo $this->config->item('js_url'); ?>jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>datatables.min.js"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js" type="text/javascript"></script>
        <!--loader-->
        <link href="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
        <script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
        <script>
            var base_url = '<?php echo base_url() ?>';
            var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="loadingmessage" class="loadingmessage"></div>
        <?php
        include APPPATH . '/modules/views/sidebar.php';
        $url_segment = trim($this->uri->segment(1));
        $profile_active = "";
        $change_password_active = "";
        $profile_Arr = array("profile",);
        $change_passwordArr = array("update-password-action");
        if (isset($url_segment) && in_array($url_segment, $profile_Arr)) {
            $profile_active = "active";
        } elseif (isset($url_segment) && in_array($url_segment, $change_passwordArr)) {
            $change_password_active = "active";
        }
        $ID = (int) $this->session->userdata('UserID');
        ?>
        <!-- Start Topbar -->
        <nav class="nav navbar py-3 white">
            <div class="container-fluid pr-0">
                <a href="" class="db-close-button"></a>
                <a href="<?php echo base_url('admin-logout') ?>" class="db-options-button">
                    <img src="<?php echo ROOT_LOCATION . img_path; ?>/svg/back-icon.png" alt="db-list-right">
                </a>
                <div class="db-item">
                    <div class="db-side-bar-handler">
                        <img src="<?php echo ROOT_LOCATION . img_path; ?>/sidebar/db-list-left.png" alt="db-list-left">
                    </div>
                </div>
                <ul class="nav navbar-nav nav-flex-icons ml-auto sidbar_ulnav top_navbar">
                    <li class="nav-item">
                        <a  href="<?php echo base_url('profile') ?>" class="<?php echo $profile_active; ?>  nav-link waves-effect text-muted"><i class="fa fa-user"></i> <span class="clearfix d-none d-sm-inline-block">ХЭРЭГЛЭГЧИЙН ТОХИРГОО</span></a>
                    </li>
                    <li class="nav-item">
                        <a  href="<?php echo base_url('update-password-action') ?>" class="<?php echo $change_password_active; ?> nav-link waves-effect text-muted"><i class="fa fa-key"></i> <span class="clearfix d-none d-sm-inline-block">НУУЦ ҮГ СОЛИХ</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('logout') ?>" class="nav-link waves-effect text-muted">
                            <i class="fa fa-sign-out"></i>
                            <span class="clearfix d-none d-sm-inline-block"><?php echo $this->lang->line('Log_Out'); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>