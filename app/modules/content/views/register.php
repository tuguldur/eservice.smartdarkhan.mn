<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        <!-- SITE META -->
        <title ><?php
            echo get_CompanyName();
            if (!empty($title))
                echo " | " . $title;
            ?></title>
        <!-- Font Awesome -->       
        <link href="<?php echo $this->config->item('css_url'); ?>font-awesome.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap core CSS -->   
        <link href="<?php echo $this->config->item('css_url'); ?>bootstrap.css" rel="stylesheet" type="text/css"/>
        <!--Material Design Bootstrap-->
        <link href="<?php echo $this->config->item('css_url'); ?>knowledgebase.css" rel="stylesheet" type="text/css"/>
        <!-- Your custom styles -->   
        <link href="<?php echo $this->config->item('css_url'); ?>admin_panel.css" rel="stylesheet" type="text/css"/>
        <!-- Your custom styles -->   
        <link href="<?php echo $this->config->item('css_url'); ?>custom.css" rel="stylesheet" type="text/css"/>
        <!-- J-Query -->  
        <script src="<?php echo $this->config->item('js_url'); ?>jquery-3.2.1.min.js" type="text/javascript"></script>
        <!-- Validation JS -->
        <script src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js"></script>
        <!-- Loader -->
        <script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
        <!-- Loader --> 
        <link href ="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
        <script src="<?php echo $this->config->item('admin_js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
    </head>
    <body class="pb-0">
        <!-- Start Container -->
        <div class="container">
            <section class="form-light sm-margin-b-20 content-sm">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-5 m-auto">
                        <a href="<?php echo base_url(); ?>">
                            <div class="text-center">
                                <?php
                                if (file_exists(FCPATH . uploads_path . "/sitesetting/" . $company_data['company_logo']) && $company_data['company_logo'] != '') {
                                    $img_src = base_url() . uploads_path . "/sitesetting/" . $company_data['company_logo'];
                                } else {
                                    $img_src = base_url() . img_path . "/user.png";
                                }
                                ?> 
                                <img id="imageurl"  class="img-responsive img-fluid"  style="" src="<?php echo $img_src; ?>" alt="<?php echo $this->lang->line('Image'); ?>">
                            </div>
                        </a>

                        <div class="card mt-3 sm-mb-30">

                            <div class="header p-3 bg-color-base">
                                <div class="text-center">
                                    <h3 class="white-text mb-0 font-bold"><?php echo $this->lang->line('User'); ?> <?php echo $this->lang->line('Registration'); ?></h3>
                                </div>
                            </div>

                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php $this->load->view('message'); ?>
                                <?php
                                $attributes = array('id' => 'Register_user', 'name' => 'Register_user', 'method' => "post");
                                echo form_open_multipart('register-save', $attributes);
                                ?>
                                <div class="form-group">
                                    <label for="first_name"> <?php echo $this->lang->line('First'); ?> <?php echo $this->lang->line('Name'); ?> <small class="required">*</small></label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="<?php echo $this->lang->line('First'); ?> <?php echo $this->lang->line('Name'); ?>">                                        
                                    <?php echo form_error('first_name'); ?>
                                </div>
                                <div class="error" id="first_name_validate"></div>
                                <div class="form-group">
                                    <label for="last_name"> <?php echo $this->lang->line('Last'); ?> <?php echo $this->lang->line('Name'); ?><small class="required">*</small></label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="<?php echo $this->lang->line('Last'); ?> <?php echo $this->lang->line('Name'); ?>">                                        
                                    <?php echo form_error('last_name'); ?>
                                </div>
                                <div class="error" id="last_name_validate"></div>
                                <div class="form-group">
                                    <label for="email"> <?php echo $this->lang->line('Email'); ?> <small class="required">*</small></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo $this->lang->line('Email'); ?>">                                        
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="error" id="email_validate"></div>
                                <div class="form-group">
                                    <label for="password"> <?php echo $this->lang->line('Password'); ?> <small class="required">*</small> <i class="fa fa-info-circle" tabindex="0"
                                                                                                                                             data-html="true" 
                                                                                                                                             data-toggle="popover" 
                                                                                                                                             title="<b>Password</b> - Rules" 
                                                                                                                                             data-content='<span class="d-block"><b> <?php echo $this->lang->line('Info'); ?> - </b></span><span class="d-block">- <?php echo $this->lang->line('Password_length'); ?></span><span class="d-block">- <?php echo $this->lang->line('Password_lowercase'); ?></span><span class="d-block">- <?php echo $this->lang->line('Password_uppercase'); ?></span><span class="d-block">- <?php echo $this->lang->line('Password_numeric'); ?></span>'></i></label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo $this->lang->line('Password'); ?>">                                        
                                    <?php echo form_error('password'); ?>
                                </div>
                                <div class="error" id="password_validate"></div>
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"> <?php echo $this->lang->line('Register'); ?> </button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!--/Form with header-->
                        </div>
                        <!--Card-->
                    </div>
                    <!-- End Col -->
                </div>
                <!--Row-->
            </section>
        </div>

        <!-- SCRIPTS -->
        <!-- Register module --> <script src="<?php echo $this->config->item('admin_js_url'); ?>module/register.js" type="text/javascript"></script>
        <!-- knowledge base core JS --> <script src="<?php echo $this->config->item('js_url'); ?>knowledge_base.min.js" type="text/javascript"></script>
        <!-- Bootstrap tooltips--> <script src="<?php echo $this->config->item('js_url'); ?>popper.min.js" type="text/javascript"></script>
        <!-- Bootstrap core JS --> <script src="<?php echo $this->config->item('js_url'); ?>bootstrap.min.js" type="text/javascript"></script>
        <!-- Bootstrap core JS --> <script src="<?php echo $this->config->item('js_url'); ?>sidebar.js" type="text/javascript"></script>
        <!-- Custom Script --> <script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
    </body>
</html>