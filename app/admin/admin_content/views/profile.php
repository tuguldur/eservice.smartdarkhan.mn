<?php include APPPATH . '/modules/views/admin_header.php'; ?>
<?php
$first_name = (set_value("first_name")) ? set_value("first_name") : $admin_data['first_name'];
$last_name = (set_value("last_name")) ? set_value("last_name") : $admin_data['last_name'];
$email = (set_value("email")) ? set_value("email") : $admin_data['email'];
$phone = (set_value("phone")) ? set_value("phone") : $admin_data['phone'];
$profile_image = set_value("profile_image") ? set_value("profile_image") : $admin_data['profile_image'];
?>
<!-- Additional method Script -->
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold"> <?php echo $this->lang->line('Profile'); ?> <?php echo $this->lang->line('Update'); ?></h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                $attributes = array('id' => 'Profile', 'name' => 'Profile', 'method' => "post");
                                echo form_open_multipart('admin-profile-save', $attributes);
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name"> <?php echo $this->lang->line('First'); ?> <?php echo $this->lang->line('Name'); ?> <small class="required">*</small></label>
                                            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="<?php echo $this->lang->line('First'); ?><?php echo $this->lang->line('Name'); ?>">                                            
                                            <?php echo form_error('first_name'); ?>

                                        </div>
                                        <div class="error" id="first_name_validate"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name"> <?php echo $this->lang->line('Last'); ?> <?php echo $this->lang->line('Name'); ?> <small class="required">*</small></label>
                                            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="<?php echo $this->lang->line('Last'); ?><?php echo $this->lang->line('Name'); ?>">                                            
                                            <?php echo form_error('last_name'); ?>
                                        </div>
                                        <div class="error" id="last_name_validate"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email"> <?php echo $this->lang->line('Email'); ?> <small class="required">*</small></label>
                                            <input type="email" placeholder="<?php echo $this->lang->line('Email'); ?>" id="email" name="email" value="<?php echo $email; ?>" class="form-control">                                            
                                            <?php echo form_error('email'); ?>

                                        </div>
                                        <div class="error" id="email_validate"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone"> <?php echo $this->lang->line('Phone'); ?> <small class="required">*</small></label>
                                            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" class="form-control" placeholder="<?php echo $this->lang->line('Phone'); ?>">                                            
                                            <?php echo form_error('phone'); ?>
                                        </div>
                                        <div class="error" id="phone_validate"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 style="font-size: .8rem; color: #757575; margin-bottom: 2.5rem;"><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Image'); ?> </h5>
                                        <div class="file-field">
                                            <div class="btn btn-primary btn-sm">
                                                <span><?php echo $this->lang->line('Choose'); ?> <?php echo $this->lang->line('File'); ?></span>
                                                <input onchange="readURL(this)" id="imageurl"  type="file" name="profile_image"/>
                                            </div>
                                            <div class="file-path-wrapper" style="padding-top: 4px;">
                                                <input class="file-path validate form-control readonly" readonly type="text" placeholder="<?php echo $this->lang->line('Upload'); ?> <?php echo $this->lang->line('your'); ?> <?php echo $this->lang->line('file'); ?>" >
                                            </div>
                                            <?php echo form_error('profile_image'); ?>
                                        </div>
                                        <div class="error" id="Pro_img_validate"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        if (file_exists(dirname(BASEPATH) . "/" . uploads_path . "/profiles/" . $admin_data['profile_image']) && $admin_data['profile_image'] != '') {
                                            $img_src = ROOT_LOCATION . uploads_path . "/profiles/" . $admin_data['profile_image'];
                                        } else {
                                            $img_src = ROOT_LOCATION . img_path . "/user.png";
                                        }
                                        ?> 
                                        <h5 style="font-size: .8rem; color: #757575"><?php echo $this->lang->line('Profile'); ?> <?php echo $this->lang->line('Image'); ?> </h5>
                                        <img id="imageurl"  class="img"  style="border-radius:50%;" src="<?php echo $img_src; ?>" alt="<?php echo $this->lang->line('Profile'); ?> <?php echo $this->lang->line('Image'); ?>" width="100" height="100">
                                    </div>
                                </div>
                                <div class="md-form ">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo $this->lang->line('Update'); ?></button>
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
            <!-- End Login-->
        </div>
    </div>
</div>
<!-- Custom Script -->
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?> 