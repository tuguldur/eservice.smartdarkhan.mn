<?php include 'header.php'; ?>
<!-- Start Content -->

<!--Banner Section-->
<div class="breadcrumb_banner">
    <div class="img-overlay">
        <div class="container">
            <div class="banner_content">
                <nav aria-label="breadcrumb" class="breadcrumb_grey">
                    <ol class="breadcrumb px-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('theme'); ?>"><?php echo $this->lang->line('Home'); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $this->lang->line('Submit') ?> <?php echo $this->lang->line('Request') ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--End Banner Section-->

<div class="my-5">
    <div class="container">
        <section class="mt-3 form-light sm-margin-b-20 ">
            <!-- Row -->
            <div class="row submit_row mb-5">
                <div class="col-md-12 m-auto">
                    <div>
                        <div class="header">
                            <h3 class="mb-3 red-text"><?php echo $this->lang->line('Submit'); ?> <?php echo $this->lang->line('Request'); ?></h3>
                            <p class="list_text">
                                <?php echo $this->lang->line('Request_title'); ?>
                            </p>

                            <p>
                                <?php echo $this->lang->line('Request_description'); ?>
                            </p>
                        </div>
                        <div class="contact_info">
                            <h4><?php echo $this->lang->line('Way_Touch'); ?></h4>
                            <div class="row">
                                <?php // if ($company_data->company_email1 != '') { ?>
                                    <div class="col-md-6">
                                        <ul class="list-inline">
                                            <?php // if ($company_data->company_email1 != '') { ?>
                                                <li>
                                                    <p><i class="fa fa-envelope-o"><span class="pl-3"><?php // echo $company_data->company_email1; ?> info@knowledgebase.com</span></i></p>
                                                </li>
                                            <?php // } if ($company_data->company_phone1 != '') { ?>
                                                <li>
                                                    <p><i class="fa fa-whatsapp"><span class="pl-3"><?php // echo $company_data->company_phone1; ?> 1234567890</span></i></p>
                                                </li>
                                            <?php // } ?>
                                        </ul>
                                    </div>
                                <?php // } ?>
                            </div>
                        </div>
                         </div>
                        <hr>
                        <div class="form_support">
                            <h4><?php echo $this->lang->line('Contact_Support'); ?></h4>
                            <div class="card-body p-0">
                                <?php
                                $attributes = array('id' => 'submit_request', 'name' => 'submit_request', 'method' => "post");
                                echo form_open_multipart('submit_request_action', $attributes);
                                ?>
                                <div class="row submit_row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <?php echo form_label($this->lang->line('Subject') . ' : <small class ="required">*</small>', 'subject', array('class' => 'control-label')); ?>
                                            <?php echo form_input(array('id' => 'subject', 'class' => 'form-control', 'name' => 'subject', 'onblur' => 'check_article(this.value);')); ?>
                                            <?php echo form_error('subject'); ?> 
                                        </div>
                                        <div id="subject_validate"></div>
                                        <div class="form-group" id="feature_request" style="display: none;">
                                            <div class="alert alert-info">
                                                <?php echo $this->lang->line('Already_exists_article'); ?>!
                                                <ul style="list-style: square;" id="request_content">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <?php echo form_label($this->lang->line('Description') . ' : <small class ="required">*</small>', 'description', array('class' => 'control-label')); ?>
                                            <?php echo form_textarea(array('id' => 'description', 'class' => 'form-control', 'name' => 'description', 'rows' => 3)); ?>
                                            <p>* <?php echo $this->lang->line('Request_possible'); ?></p>
                                            <?php echo form_error('description'); ?>
                                        </div>
                                        <div id="description_validate"></div>
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('Select_Category'); ?> <small class="required">*</small></label>
                                            <select class="kb-select initialized" name="category_id" id="category_id" required="">
                                                <option value=""><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Category'); ?></option>
                                                <?php
                                                if (isset($category_data) && count($category_data)) {
                                                    foreach ($category_data as $value) {
                                                        ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>    
                                            <?php echo form_error('category_id'); ?>
                                        </div>
                                        <div id="category_id_validate"></div>
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('Select_Priority'); ?> <small class="required">*</small></label>
                                            <select class="kb-select initialized" name="request_priority" id="request_priority" required="">
                                                <option value="" ><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Priority'); ?></option>
                                                <option value="H"><?php echo $this->lang->line('High'); ?></option>
                                                <option value="M"><?php echo $this->lang->line('Medium'); ?></option>
                                                <option value="L"><?php echo $this->lang->line('Low'); ?></option>
                                            </select>    
                                            <?php echo form_error('request_priority'); ?>

                                            <div id="request_priority_validate"></div>
                                        </div>
                                    </div> 
                                    <div class="col-md-12">
                                        <?php echo form_label($this->lang->line('Attchment') . ' : ', 'attachment_img', array('class' => 'control-label, attachment')); ?>
                                        <div class="file-field">
                                            <div class="btn btn-primary btn-sm">
                                                <span><?php echo $this->lang->line('Choose'); ?> <?php echo $this->lang->line('File'); ?></span>
                                                <input onchange="readURL(this)" id="imageurl"  type="file" name="attachment_img"/>
                                            </div>
                                            <div class="file-path-wrapper" style="padding-top: 3px;">
                                                <input class="file-path validate form-control readonly" readonly type="text" placeholder="<?php echo $this->lang->line('Attchment'); ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row submit_row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn red waves-effect" style="margin-top: 25px;"><?php echo $this->lang->line('Submit'); ?></button>
                                        </div> 
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>                   
                </div>
                <!--col-md-12-->
            </div>
            <!--Row-->
        </section>
    </div>
</div>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/submit_request.js" type="text/javascript"></script>
<?php include 'footer.php'; ?>