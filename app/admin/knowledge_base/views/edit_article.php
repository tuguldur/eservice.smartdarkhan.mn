<?php
include APPPATH . '/modules/views/admin_header.php';
$title = (set_value("title")) ? set_value("title") : $article_data['title'];
$description = (set_value("description")) ? set_value("description") : $article_data['description'];
$group = (set_value("group")) ? set_value("group") : $article_data['group_id'];
$seo_keyword = (set_value("seo_keyword")) ? set_value("seo_keyword") : $article_data['seo_keyword'];
$seo_description = (set_value("seo_description")) ? set_value("seo_description") : $article_data['seo_description'];
$status = (set_value("status")) ? set_value("status") : $article_data['status'];
$comment_box = (set_value("open_comment")) ? set_value("open_comment") : $article_data['open_comment'];
$id = (set_value("id")) ? set_value("id") : $article_data['id'];
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
                                <h3 class="white-text mb-3 font-bold">Мэдээлэл засварлах</h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                echo form_open('save-article', array('name' => 'article_form', 'id' => 'article_form'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                ?>
                                <div class="form-group">
                                    <p class="grey-text">Байгууллага сонгох <small class="required">*</small></p>
                                    <?php
                                    $options[''] = $this->lang->line('Байгууллага').' '.$this->lang->line('Сонгох');
                                    if (isset($group_list) && !empty($group_list)) {
                                        foreach ($group_list as $row) {
                                            $options[$row['id']] = $row['title'];
                                        }
                                    }
                                    $attributes = array('class' => 'kb-select initialized', 'id' => 'group', '');
                                    echo form_dropdown('group', $options, $group, $attributes);
                                    echo form_error('group');
                                    ?>
                                </div>
                                <div id="group_validate"></div>
                                <div class="form-group">
                                    <label for="title"> Мэдээлэлийн нэр <small class="required">*</small></label>
                                    <input type="text" placeholder="Мэдээлэлийн нэр " id="title" name="title" value="<?php echo $title; ?>" class="form-control">                                    
                                    <?php echo form_error('title'); ?>
                                </div>
                                <div id="title_validate"></div>
                                <div class="form-group">
                                    <label for="description"> Мэдээлэлийн тайлбар <small class="required">*</small></label>
                                    <br>
                                    <br>
                                    <textarea  id="description" name="description" class="md-textarea ckeditor"><?php echo htmlspecialchars($description); ?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                                <div id="description_validate"></div>
                                <div class="form-group">
                                    <label for="seo_keyword"> Хайлтын түлхүүр үг <small class="required">*</small></label>
                                    <input type="text" name='seo_keyword' id="seo_keyword" placeholder="Хайлтын түлхүүр үг" value="<?php echo $seo_keyword; ?>" class="form-control">                                    
                                    <?php echo form_error('seo_keyword'); ?>
                                </div>
                                <div id="seo_keyword_validate"></div>
                                <div class="form-group">
                                    <label for="seo_description">Хайлтын тайлбар <small class="required">*</small></label>
                                    <input type="text" name='seo_description' placeholder="Хайлтын тайлбар" id="seo_description" value="<?php echo $seo_description; ?>" class="form-control">                                    
                                    <?php echo form_error('seo_description'); ?>
                                </div>
                                <div id="seo_description_validate"></div>
                                
                                <label style="color: #757575;">Сэтгэгдэл бичих<small class="required">*</small></label>
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
                                        <label for="open_comment">Боломжтой</label>
                                    </div>
                                    <div class="form-group">
                                        <input name='open_comment' value='0' type='radio' id='open_comment1'  <?php echo $Hide; ?>>
                                        <label for='open_comment1'>Боломжгүй</label>
                                    </div>
                                </div>
                                
                                
                                <label style="color: #757575;" >  <?php echo $this->lang->line('Status'); ?> <small class="required">*</small></label>
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
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;">Хадгалах</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!--/Form with header-->
                        </div>
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
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/knowledge_article.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>