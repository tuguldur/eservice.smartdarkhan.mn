<?php
include APPPATH . '/modules/views/header.php';

$title = (set_value("title")) ? set_value("title") : $post_data['title'];
$description = (set_value("description")) ? set_value("description") : $post_data['description'];
$topic = (set_value("topic")) ? set_value("topic") : $post_data['topic_id'];
$seo_keyword = (set_value("seo_keyword")) ? set_value("seo_keyword") : $post_data['seo_keyword'];
$seo_description = (set_value("seo_description")) ? set_value("seo_description") : $post_data['seo_description'];
$post_status = (set_value("post_status")) ? set_value("post_status") : $post_data['post_status'];
$comment_box = (set_value("open_comment")) ? set_value("open_comment") : $post_data['open_comment'];
$status = (set_value("status")) ? set_value("status") : $post_data['status'];
$id = (set_value("id")) ? set_value("id") : $post_data['id'];
?>

<link href="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.css" rel="stylesheet"/>
<script src="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.js"></script>
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
                            <div class="d-flex ">
                                <h3 class="white-text mb-3 font-bold"><?php echo $this->lang->line('Update'); ?> <?php echo $this->lang->line('Post'); ?></h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php echo form_open('post-save', array('name' => 'customer_post', 'id' => 'customer_post')); ?>
                                <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id)); ?>
                                <div class="form-group">
                                    <p class="grey-text"><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Topic'); ?> <small class="required">*</small></p>
                                    <?php
                                    $options[''] = $this->lang->line('Select') . ' ' . $this->lang->line('Topic');
                                    if (isset($topic_list) && !empty($topic_list)) {
                                        foreach ($topic_list as $row) {
                                            $options[$row['id']] = $row['title'];
                                        }
                                    }
                                    $attributes = array('class' => 'kb-select initialized', 'id' => 'topic');
                                    echo form_dropdown('topic', $options, $topic, $attributes);
                                    echo form_error('topic');
                                    ?>
                                </div>
                                <div id="topic_validate"></div>

                                <div class="form-group">
                                    <label for="title"> <?php echo $this->lang->line('Title'); ?><small class="required">*</small></label>
                                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?php echo $this->lang->line('Title'); ?>">                                    
                                    <?php echo form_error('title'); ?>
                                </div>
                                <div id="title_validate"></div>
                                
                                <div class="form-group">
                                    <label for="description"> <?php echo $this->lang->line('Description'); ?> <small class="required">*</small></label>
                                    <br>
                                    <br>
                                    <textarea  id="description" name="description" class="md-textarea ckeditor" placeholder="<?php echo $this->lang->line('Description'); ?>"><?php echo htmlspecialchars($description); ?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                                <div id="description_validate"></div>
                                
                                <div class="form-group">
                                    <label for="seo_keyword"> <?php echo $this->lang->line('SEO'); ?> <?php echo $this->lang->line('Keyword'); ?><small class="required">*</small></label>
                                    <input type="text" name='seo_keyword' id="seo_keyword" value="<?php echo $seo_keyword; ?>" class="form-control" placeholder="<?php echo $this->lang->line('SEO'); ?> <?php echo $this->lang->line('Keyword'); ?>">                                    
                                    <?php echo form_error('seo_keyword'); ?>
                                </div>
                                <div id="seo_keyword_validate"></div>

                                <div class="form-group">
                                    <label for="seo_description"> <?php echo $this->lang->line('SEO'); ?> <?php echo $this->lang->line('Description'); ?> <small class="required">*</small></label>
                                    <input type="text" name='seo_description' id="seo_description" value="<?php echo $seo_description; ?>" class="form-control" placeholder="<?php echo $this->lang->line('SEO'); ?> <?php echo $this->lang->line('Description'); ?>">                                    
                                    <?php echo form_error('seo_description'); ?>
                                </div>
                                <div id="seo_description_validate"></div>

                                <div class="form-group">
                                    <p class="grey-text"><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Post'); ?> <?php echo $this->lang->line('Status'); ?> <small class="required">*</small></p>
                                    <?php
                                    $options = array(
                                        'P' => 'Planned',
                                        'NP' => 'Not Planned',
                                        'C' => 'Completed',
                                        'A' => 'Answered',
                                        'NS' => 'No Status',
                                    );
                                    $attributes = array('id' => 'post_status','class' => 'kb-select initialized');
                                    echo form_dropdown('post_status', $options, $post_status, $attributes);
                                    echo form_error('post_status');
                                    ?>
                                </div>
                                <div id="post_status_validate"></div>

                                <label style="color: #757575;" >  <?php echo $this->lang->line('Comment_Box'); ?> <small class="required">*</small></label>
                                <div class="form-group form-inline">
                                    <?php
                                    $Show = $Hide = '';
                                    if ($comment_box == "1") {
                                        $Show = "checked";
                                    } else {
                                        $Hide = "checked";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input name='open_comment' value="1" type='radio' id='open_comment'   <?php echo $Show; ?>>
                                        <label for="open_comment"><?php echo $this->lang->line('Show'); ?> </label>
                                    </div>
                                    <div class="form-group">
                                        <input name='open_comment' value='0' type='radio' id='open_comment1'  <?php echo $Hide; ?>>
                                        <label for='open_comment1'><?php echo $this->lang->line('Hide'); ?></label>
                                    </div>
                                </div>

                                <label style="color: #757575;" > <?php echo $this->lang->line('Status'); ?> <small class="required">*</small></label>
                                <div class="form-group form-inline">
                                    <?php
                                    $active = $inactive = '';
                                    if ($status == "A") {
                                        $active = "checked";
                                    } else {
                                        $inactive = "checked";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input name='status' value="A" type='radio' id='status'   <?php echo $active; ?>>
                                        <label for="status"><?php echo $this->lang->line('Active'); ?> </label>
                                    </div>
                                    <div class="form-group">
                                        <input name='status' type='radio'  value='I' id='status1'  <?php echo $inactive; ?>>
                                        <label for='status1'><?php echo $this->lang->line('Inactive'); ?></label>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo $this->lang->line('Save'); ?></button>
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
<script src="<?php echo $this->config->item('js_url'); ?>ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('js_url'); ?>customer_post.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/footer.php'; ?>