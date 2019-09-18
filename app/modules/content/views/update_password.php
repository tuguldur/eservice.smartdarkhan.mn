<?php include APPPATH . '/modules/views/header.php'; ?>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <!--Section-->
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <!-- Col -->
                    <div class="col-md-8 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="d-block"><b> <?php echo $this->lang->line('Info'); ?> - </b></span>
                            <span class="d-block">- <?php echo $this->lang->line('Password_length'); ?></span>
                            <span class="d-block">- <?php echo $this->lang->line('Password_lowercase'); ?></span>
                            <span class="d-block">- <?php echo $this->lang->line('Password_uppercase'); ?></span>
                            <span class="d-block">- <?php echo $this->lang->line('Password_numeric'); ?></span>
                        </div>
                        <!--Form with header-->
                        <div class="card">
                            <!--Header-->
                            <div class="header pt-3 bg-color-base">
                                <div class="d-flex">
                                    <h3 class="white-text mb-3 font-bold"><?php echo $this->lang->line('Change'); ?> <?php echo $this->lang->line('Password'); ?></h3>
                                </div>
                            </div>
                            <!--Header-->
                            <div class="card-body mx-4 mt-4">
                                <?php
                                $hidden = array("ID" => $ID);
                                $attributes = array('id' => 'Update_password', 'name' => 'Update_password', 'method' => "post");
                                echo form_open('update-password-action', $attributes);
                                ?>
                                <div class="form-group">
                                    <label for="old_password"> <?php echo $this->lang->line('Current'); ?> <?php echo $this->lang->line('Password'); ?> <small class="required">*</small></label>
                                    <input type="password" id="old_password" name="old_password" class="form-control" placeholder="<?php echo $this->lang->line('Current'); ?> <?php echo $this->lang->line('Password'); ?>">                                    
                                    <?php echo form_error('old_password'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="password"> <?php echo $this->lang->line('Password'); ?> <small class="required">*</small></label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo $this->lang->line('Password'); ?>">                                    
                                    <?php echo form_error('password'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password"> <?php echo $this->lang->line('Confirm'); ?> <?php echo $this->lang->line('Password'); ?> <small class="required">*</small></label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="<?php echo $this->lang->line('Confirm'); ?> <?php echo $this->lang->line('Password'); ?>">                                    
                                    <?php echo form_error('confirm_password'); ?>
                                </div>
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo $this->lang->line('Update'); ?></button>
                                </div>
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
        </div>
    </div>
</div>
<!-- Custom Script --><script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/footer.php'; ?>      
