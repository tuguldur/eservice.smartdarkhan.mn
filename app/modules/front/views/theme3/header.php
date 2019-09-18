<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <title><?php echo isset($title) ? $title : "KnowledgeBase"; ?></title>

        <!--Css-->
        <link href="<?php echo $this->config->item('css_url'); ?>font-awesome.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $this->config->item('css_url'); ?>bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $this->config->item('css_url'); ?>knowledgebase.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $this->config->item('css_url'); ?>theme3.css" rel="stylesheet" type="text/css">

        <!--Js-->
        <script src="<?php echo $this->config->item('js_url'); ?>jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>popper.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>knowledge_base.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>theme/custom.js" type="text/javascript"></script>

        <script>
            var base_url = '<?php echo base_url() ?>';
            var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>

        <!--Ckeditor-->
        <link href="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.css" rel="stylesheet"/>
        <script src="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.js"></script>
    </head>
    <body>

        <!--Loader-->
        <div class="container">
            <div class="loader">
                <div class="loader_box">
                    <div class="loader-inner"></div>
                    <div class="loader-inner"></div>
                    <div class="loader-inner"></div>
                    <div class="loader-inner"></div>
                </div>
            </div>
        </div>
        <!--End Loader-->

        <!--Header-->
        <nav class="navbar navbar-expand-lg navbar-dark theme-three_menu">
            <div class="container">
                <a class="navbar-brand" href="<?php echo base_url('Theme'); ?>">
                    <img src="<?php echo base_url() . img_path; ?>/theme/logo2.png" alt="logo" class="img-fluid" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#NavbarMenu" aria-controls="NavbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="NavbarMenu">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url('Theme'); ?>"><?php echo $this->lang->line('Home'); ?><span></span><span></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('theme_community'); ?>"><?php echo $this->lang->line('community'); ?><span></span><span></span></a>
                        </li>                 
                        <li class="nav-item">
                            <?php if ($this->session->userdata('UserID')) { ?>
                                <a class="<?php echo $submit_request_active; ?> nav-link" href="<?php echo base_url('Theme/theme_submit_request') ?>"><?php echo $this->lang->line('Submit'); ?> <?php echo $this->lang->line('Request'); ?><span></span><span></span></a>
                            <?php } else { ?>
                                <a class="<?php echo $submit_request_active; ?> nav-link" data-toggle="modal" data-target="#myModal"><?php echo $this->lang->line('Submit'); ?> <?php echo $this->lang->line('Request'); ?><span></span><span></span></a>
                            <?php } ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('login'); ?>"><?php echo $this->lang->line('Login'); ?><span></span><span></span></a>
                        </li>                 
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('register'); ?>"><?php echo $this->lang->line('Register'); ?><span></span><span></span></a>
                        </li>                 
                    </ul>
                </div>
            </div>
        </nav>
        <!--End Header-->        