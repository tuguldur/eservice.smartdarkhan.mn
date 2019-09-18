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
    <body>
        <!--Section-->
        <section class="form-light content-sm px-2 sm-margin-b-20" style="margin: 0 0 !important;">
            <!-- Row -->
            <div class="row">
                <!-- Col -->
                <div class="col-md-5 m-auto">
                    <a href="<?php echo ROOT_LOCATION; ?>">
                        <div class="text-center">
                            <?php
                            if (file_exists(dirname(BASEPATH) . "/" . uploads_path . "/sitesetting/" . $company_data['company_logo']) && $company_data['company_logo'] != '') {
                                $img_src = ROOT_LOCATION . uploads_path . "/sitesetting/" . $company_data['company_logo'];
                            } else {
                                $img_src = ROOT_LOCATION . img_path . "/no-image.png";
                            }
                            ?> 
                            <img id="imageurl" class="img-responsive" style="" src="<?php echo $img_src; ?>" alt="<?php echo $this->lang->line('Image'); ?>">
                        </div>
                    </a>
                    <!--Form with header-->
                    <div class="card mt-3">
                        <!--Header-->
                        <div class="header p-4 bg-color-base">

                            <div class="d-flex justify-content-center">
                                <h3 class="white-text mb-3 font-bold" style="margin-bottom: 0 !important;"><?php echo $this->lang->line('Forgot_Password'); ?></h3>
                            </div>
                        </div>
                        <!--Header-->
                        <div class="card-body mx-4 mt-4 resp_mx-0">
                            <?php $this->load->view('message'); ?>
                            <?php
                            $attributes = array('id' => 'Forgot_password', 'name' => 'Forgot_password', 'method' => "post");
                            echo form_open('admin-forgot-password-action', $attributes);
                            ?>
                            <div class="form-group">
                                <label for="email"> <?php echo $this->lang->line('Email'); ?> <small class="required">*</small></label>
                                <input type="email" placeholder="<?php echo $this->lang->line('Email'); ?>" id="email" name="email" value='<?php if (!empty($enter_email)) echo $enter_email; ?>' class="form-control">                                
                                <?php echo form_error('email'); ?>
                            </div>
                            <!--Grid row-->
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-md-1 col-md-5 d-flex align-items-start">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-grey btn-rounded z-depth-1a bg-color-base"><?php echo $this->lang->line('Submit'); ?></button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <p class="font-small grey-text d-flex justify-content-end mt-3"><?php echo $this->lang->line('Return'); ?> <a href="<?php echo base_url("admin-login"); ?>" class="dark-grey-text ml-1 font-bold"> <?php echo $this->lang->line('Login'); ?></a></p>
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
        <!-- Bootstrap tooltips--><script src="<?php echo $this->config->item('js_url'); ?>popper.min.js" type="text/javascript"></script>
        <!-- Bootstrap core JS --><script src="<?php echo $this->config->item('js_url'); ?>bootstrap.min.js" type="text/javascript"></script>
        <!-- Bootstrap core JS --><script src="<?php echo $this->config->item('js_url'); ?>sidebar.js" type="text/javascript"></script>
        <!-- Custom Script -->    <script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
    </body>
</html>
