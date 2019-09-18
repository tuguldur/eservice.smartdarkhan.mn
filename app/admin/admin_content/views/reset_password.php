<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <!-- SITE META -->
        <title ><?php
            echo get_CompanyName();
            if (!empty($title))
                echo " | " . $title;
            ?></title>
        <!-- Font Awesome -->           <link href="<?php echo $this->config->item('css_url'); ?>font-awesome.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap core CSS -->     <link href="<?php echo $this->config->item('css_url'); ?>bootstrap.css" rel="stylesheet" type="text/css"/>
        <!--Material Design Bootstrap--><link href="<?php echo $this->config->item('css_url'); ?>knowledgebase.css" rel="stylesheet" type="text/css"/>
        <!-- Your custom styles -->     <link href="<?php echo $this->config->item('css_url'); ?>admin_panel.css" rel="stylesheet" type="text/css"/>
        <!-- Your custom styles -->     <link href="<?php echo $this->config->item('css_url'); ?>custom.css" rel="stylesheet" type="text/css"/>

        <!-- J-Query -->      <script src="<?php echo $this->config->item('js_url'); ?>jquery-3.2.1.min.js" type="text/javascript"></script>
        <!-- Validation JS --><script src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js"></script>

        <!-- Loader -->  <script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
        <!-- Loader -->  <link href ="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
    </head>
    <?php include APPPATH . '/modules/views/notification_message.php'; ?>
    <body class="gray-bg">
        <!--Section-->
        <section class="form-light content-sm px-2 sm-margin-b-20 ">
            <!-- Row -->
            <div class="row">
                <!-- Col -->
                <div class="col-md-5 m-auto">
                    <!--Form with header-->
                    <div class="alert alert-info alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span class="d-block"><b> <?php echo $this->lang->line('Info'); ?> - </b></span>
                        <span class="d-block">- <?php echo $this->lang->line('Password_length'); ?></span>
                        <span class="d-block">- <?php echo $this->lang->line('Password_lowercase'); ?></span>
                        <span class="d-block">- <?php echo $this->lang->line('Password_uppercase'); ?></span>
                        <span class="d-block">- <?php echo $this->lang->line('Password_numeric'); ?></span>
                    </div>
                    <div class="card">
                        <?php $this->load->view('message'); ?>
                        <!--Header-->
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex justify-content-center">
                                <h3 class="white-text mb-3 font-bold"><?php echo $this->lang->line('Reset_Password'); ?></h3>
                            </div>
                        </div>
                        <!--Header-->
                        <div class="card-body mx-4 mt-4 resp_mx-0">
                            <?php
                            $hidden = array("id" => $id);
                            $attributes = array('id' => 'Reset_password', 'name' => 'Reset_password', 'method' => "post");
                            echo form_open('admin-reset-password-admin-action', $attributes, $hidden);
                            ?>
                            <div class="form-group">
                                <label for="password"> <?php echo $this->lang->line('Password'); ?> <small class="required">*</small></label>
                                <input type="password" required="" id="password" name="password" value="" class="form-control" placeholder="<?php echo $this->lang->line('Password'); ?>">                                
                                <?php echo form_error('password'); ?>
                            </div>
                            <div class="form-group">
                                <label for="cpassword"> <?php echo $this->lang->line('Confirm') . " " . $this->lang->line('password'); ?> <small class="required">*</small></label>
                                <input type="password" required="" id="cpassword" name="cpassword" value="" class="form-control" placeholder="<?php echo $this->lang->line('Confirm') . " " . $this->lang->line('password'); ?>">
                                <?php echo form_error('cpassword'); ?>
                            </div>
                            <!--Grid row-->
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-md-1 col-md-5 d-flex align-items-start">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-grey btn-rounded z-depth-1a bg-color-base"><?php echo $this->lang->line('Submit'); ?></button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <p class="font-small grey-text d-flex justify-content-end mt-3"> <?php echo $this->lang->line('Now'); ?> <a href="<?php echo base_url("admin-login"); ?>" class="dark-grey-text ml-1 font-bold"> <?php echo $this->lang->line('Login'); ?></a></p>
                                </div>
                            </div>
                            <!--Grid row-->
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <!--/Form with header-->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </section>
        <!-- End Section-->
        <!-- SCRIPTS -->
        <!-- knowledge base core JS -->      <script src="<?php echo $this->config->item('js_url'); ?>knowledge_base.min.js" type="text/javascript"></script>
        <!-- Bootstrap Tooltips--><script src="<?php echo $this->config->item('js_url'); ?>popper.min.js" type="text/javascript"></script>
        <!-- Bootstrap core JS --><script src="<?php echo $this->config->item('js_url'); ?>bootstrap.min.js" type="text/javascript"></script>
        <!-- Bootstrap core JS --><script src="<?php echo $this->config->item('js_url'); ?>sidebar.js" type="text/javascript"></script>
        <!-- Custom Script -->    <script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
    </body>
</html>



