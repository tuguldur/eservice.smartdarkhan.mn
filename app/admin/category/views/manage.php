<?php
include APPPATH . '/modules/views/admin_header.php';
$title = (set_value("title")) ? set_value("title") : (!empty($category_data) ? $category_data['title'] : '');
$status = (set_value("status")) ? set_value("status") : (!empty($category_data) ? $category_data['status'] : '');
$id = (set_value("id")) ? set_value("id") : (!empty($category_data) ? $category_data['id'] : 0);
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
                                    Зөвшөөрөлийн төрөл нэмэх | засварлах</h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                echo form_open('save-category', array('name' => 'CategoryForm', 'id' => 'CategoryForm'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                ?>
                                <div class="form-group">
                                    <label for="title"> Нэр<small class="required">*</small></label>
                                    <input type="text" id="title" name="title" placeholder="Зөвшөөрөлийн нэр " value="<?php echo $title; ?>" class="form-control">                                    
                                    <?php echo form_error('title'); ?>
                                </div>
                                <label style="color: #757575;" > <?php echo $this->lang->line('Status'); ?> <small class="required">*</small></label>
                                <div class="md-form form-inline">
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
                                <div class="md-form">
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
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/category.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>