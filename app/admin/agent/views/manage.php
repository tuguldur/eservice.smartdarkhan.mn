<?php
include APPPATH . '/modules/views/admin_header.php';
$first_name = (set_value("first_name")) ? set_value("first_name") : (!empty($agent_data) ? $agent_data['first_name'] : '');
$last_name = (set_value("last_name")) ? set_value("last_name") : (!empty($agent_data) ? $agent_data['last_name'] : '');
$email = (set_value("email")) ? set_value("email") : (!empty($agent_data) ? $agent_data['email'] : '');
$phone = (set_value("phone")) ? set_value("phone") : (!empty($agent_data) ? $agent_data['phone'] : '');
$status = (set_value("status")) ? set_value("status") : (!empty($agent_data) ? $agent_data['status'] : '');
$id = (set_value("id")) ? set_value("id") : (!empty($agent_data) ? $agent_data['id'] : 0);
?>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-8 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold">
                                Ажилтан нэмэх | засварлах</h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                echo form_open('save-agent', array('name' => 'AgentForm', 'id' => 'AgentForm'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                ?>
                                <div class="form-group">
                                    <label for="first_name"> Овог <small class="required">*</small></label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="<?php echo $this->lang->line('First'); ?> <?php echo $this->lang->line('Name'); ?>">                                    
                                    <?php echo form_error('first_name'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="last_name"> Нэр <small class="required">*</small></label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="<?php echo $this->lang->line('Last'); ?> <?php echo $this->lang->line('Name'); ?>">                                    
                                    <?php echo form_error('last_name'); ?>
                                </div>
                                <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                    <label for="email"> <?php echo $this->lang->line('Email'); ?> <small class="required">*</small></label>
                                    <input type="email" placeholder="<?php echo $this->lang->line('Email'); ?>" id="email" name="email" value="<?php echo $email; ?>" class="form-control <?php isset($id) && $id > 0 ? "readonly" : ""; ?>" <?php isset($id) && $id > 0 ? "readonly" : ""; ?>>                                    
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="phone"> <?php echo $this->lang->line('Phone'); ?> <small class="required">*</small></label>
                                    <input type="text" id="phone" name="phone" placeholder="<?php echo $this->lang->line('Phone'); ?>" value="<?php echo $phone; ?>" class="form-control">                                    
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <?php if ($id == 0) { ?>
                                    <div class="form-group">
                                        <label for="password"> <?php echo $this->lang->line('Password'); ?> <small class="required">*</small></label>
                                        <input type="password" id="password" placeholder="<?php echo $this->lang->line('Password'); ?>" name="password" class="form-control" <?php echo isset($id) && $id == 0 ? "required" : ''; ?>>                                        
                                        <?php echo form_error('password'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password"> Нууц үг давтах <small class="required">*</small></label>
                                        <input type="password" placeholder="<?php echo $this->lang->line('Confirm'); ?> <?php echo $this->lang->line('Password'); ?>" id="confirm_password" name="confirm_password" class="form-control" <?php echo isset($id) && $id == 0 ? "required" : ''; ?>>                                        
                                        <?php echo form_error('confirm_password'); ?>
                                    </div>
                                <?php } ?>
                                <label style="color: #757575;" > <?php echo $this->lang->line('Status'); ?> <small class="required">*</small></label>
                                <div class="form-group form-inline">
                                    <?php
                                    $active = $inactive = '';
                                    if ($status == "I") {
                                        $inactive = "checked";
                                    } else {
                                        $active = "checked";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input name='status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                        <label for="active"><?php echo $this->lang->line('Active'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
                                        <label for='inactive'><?php echo $this->lang->line('Inactive'); ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;">Хадгалах</button>
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
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/agent.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>