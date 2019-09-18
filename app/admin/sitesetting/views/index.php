<?php
include APPPATH . '/modules/views/admin_header.php';
$company_name = isset($company_data->company_name) ? $company_data->company_name : set_value('company_name');
$company_email1 = isset($company_data->company_email1) ? $company_data->company_email1 : set_value('company_email1');
$company_email2 = isset($company_data->company_email2) ? $company_data->company_email2 : set_value('company_email2');
$company_phone1 = isset($company_data->company_phone1) ? $company_data->company_phone1 : set_value('company_phone1');
$company_phone2 = isset($company_data->company_phone2) ? $company_data->company_phone2 : set_value('company_phone2');
$company_address1 = isset($company_data->company_address1) ? $company_data->company_address1 : set_value('company_address1');
$company_address2 = isset($company_data->company_address2) ? $company_data->company_address2 : set_value('company_address2');
$language = isset($company_data->language) ? $company_data->language : set_value('language');
$home_page = isset($company_data->home_page) ? $company_data->home_page : set_value('home_page');
$company_logo = isset($company_data->company_logo) ? $company_data->company_logo : set_value('company_logo');
$fb_link = isset($company_data->fb_link) ? $company_data->fb_link : set_value('fb_link');
$google_link = isset($company_data->google_link) ? $company_data->google_link : set_value('google_link');
$twitter_link = isset($company_data->twitter_link) ? $company_data->twitter_link : set_value('twitter_link');
$insta_link = isset($company_data->insta_link) ? $company_data->insta_link : set_value('insta_link');
$linkdin_link = isset($company_data->linkdin_link) ? $company_data->linkdin_link : set_value('linkdin_link');
$root_dir = dirname(BASEPATH) . "/" . uploads_path . '/sitesetting/';
$logo_check = false;
$banner_check = false;
if (isset($company_data->company_logo) && $company_data->company_logo != "") {
    if (file_exists($root_dir . $company_data->company_logo)) {
        $logo_check = true;
        $logo_image = ROOT_LOCATION . uploads_path . '/sitesetting/' . $company_data->company_logo;
    } else {
        $logo_image = ROOT_LOCATION . img_path . "/no-image.png";
    }
} else {
    $logo_image = ROOT_LOCATION . img_path . "/no-image.png";
}
if (isset($company_data->banner_image) && $company_data->banner_image != "") {
    if (file_exists($root_dir . $company_data->banner_image)) {
        $banner_check = true;
        $banner_image = ROOT_LOCATION . uploads_path . '/sitesetting/' . $company_data->banner_image;
    } else {
        $banner_image = ROOT_LOCATION . img_path . "/banner.png";
    }
} else {
    $banner_image = ROOT_LOCATION . img_path . "/banner.png";
}
?>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <?php $this->load->view('message'); ?>
            <h2 class="text-center font-bold"><strong><?php echo $this->lang->line('Site_Setting'); ?></strong></h2>
            <div class="card">
                <div class="card-body">
                    <div class="steps-form-2">
                        <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                            <div class="steps-step-2">
                                <a href="#step-4" type="button" class="btn btn-amber waves-effect ml-0" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('Basic'); ?> <?php echo $this->lang->line('Information'); ?>">
                                    <?php echo $this->lang->line('Basic'); ?> <?php echo $this->lang->line('Information'); ?>
                                </a>
                            </div>
                            <div class="steps-step-2">
                                <a href="#step-5" type="button" class="btn btn-blue-grey waves-effect" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('Personal'); ?> <?php echo $this->lang->line('Data'); ?>">
                                    <?php echo $this->lang->line('Social'); ?> <?php echo $this->lang->line('Media'); ?>
                                </a>
                            </div>
                            <div class="steps-step-2">
                                <a href="#step-6" type="button" class="btn btn-blue-grey waves-effect" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('Terms_Conditions'); ?>">
                                    <?php echo $this->lang->line('Media'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart('save-sitesetting', array('name' => 'site_form', 'id' => 'site_form')); ?>
                    <div class="row setup-content-2" id="step-4">
                        <div class="col-md-12">
                            <h3 class="font-bold pl-0 my-4"><strong><?php echo $this->lang->line('Company'); ?> <?php echo $this->lang->line('Information'); ?></strong></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Site') . ' ' . $this->lang->line('Name') . ' : <small class ="required">*</small>', 'company_name', array('class' => 'control-label', 'data-error' => 'wrong', 'data-success' => 'right')); ?>
                                        <?php echo form_input(array('id' => 'company_name', 'class' => 'form-control validate', 'name' => 'company_name', 'value' => $company_name, 'required' => 'required', 'placeholder' => $this->lang->line('Site') . ' ' . $this->lang->line('Name'))); ?>
                                        <?php echo form_error('company_name'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Site') . ' ' . $this->lang->line('Email') . ' : <small class ="required">*</small>', 'company_email1', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'company_email1', 'class' => 'form-control validate', 'name' => 'company_email1', 'value' => $company_email1, 'required' => 'required', 'type' => 'email', 'placeholder' => $this->lang->line('Site') . ' ' . $this->lang->line('Email'))); ?>
                                        <?php echo form_error('company_email1'); ?> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Site') . ' ' . $this->lang->line('Phone') . '-1 :', 'company_phone1', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'company_phone1', 'class' => 'form-control validate', 'name' => 'company_phone1', 'value' => $company_phone1, 'placeholder' => $this->lang->line('Site') . ' ' . $this->lang->line('Phone'))); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Site') . ' ' . $this->lang->line('Phone') . '-2 : ', 'company_phone2', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'company_phone2', 'class' => 'form-control', 'name' => 'company_phone2', 'value' => $company_phone2, 'placeholder' => $this->lang->line('Site') . ' ' . $this->lang->line('Phone'))); ?>
                                        <?php echo form_error('company_phone2'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Address') . '-1 :', 'company_address1', array('class' => 'control-label')); ?>
                                        <?php echo form_textarea(array('id' => 'company_address1', 'class' => 'form-control validate', 'name' => 'company_address1', 'type' => 'text', 'rows' => 3, 'value' => $company_address1, 'placeholder' => $this->lang->line('Address'))); ?>
                                    </div>
                                </div> 
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Address') . '-2 : ', 'company_address2', array('class' => 'control-label')); ?>
                                        <?php echo form_textarea(array('id' => 'company_address2', 'class' => 'form-control', 'name' => 'company_address2', 'type' => 'text', 'rows' => 3, 'value' => $company_address2, 'placeholder' => $this->lang->line('Address'))); ?>
                                        <?php echo form_error('company_address2'); ?>
                                    </div>
                                </div> 
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <p class="black-text"><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Language'); ?><small class="required">*</small></p>
                                        <?php
                                        $options = array(
                                            '' => $this->lang->line('Select') . " " . $this->lang->line('Language'),
                                            'arabic' => 'Arabic',
                                            'english' => 'English',
                                            'french' => 'French',
                                            'gujarati' => 'Gujarati',
                                            'hindi' => 'Hindi',
                                            'spanish' => 'Spanish'
                                        );
                                        $attributes = array('class' => 'kb-select initialized', 'id' => 'language', 'required' => 'required');
                                        echo form_dropdown('language', $options, $language, $attributes);
                                        echo form_error('language');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <p class="black-text"><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Home'); ?> <?php echo $this->lang->line('Page'); ?><small class="required">*</small></p>
                                        <?php
                                        $options = array(
                                            '' => $this->lang->line('Select') . " " . $this->lang->line('Home') . " " . $this->lang->line('Page'),
                                            '1' => $this->lang->line('Home') . ' 1',
                                            '2' => $this->lang->line('Home') . ' 2',
                                            '3' => $this->lang->line('Home') . ' 3',
                                        );
                                        $attributes = array('id' => 'home_page', 'name' => 'home_page', 'class' => 'kb-select initialized', 'required' => 'required');
                                        echo form_dropdown('home_page', $options, $home_page, $attributes);
                                        echo form_error('home_page');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-kb-color btn-rounded nextBtn-2 float-right" type="button"><?php echo $this->lang->line('Next'); ?></button>
                        </div>
                    </div>
                    <div class="row setup-content-2" id="step-5">
                        <div class="col-md-12">
                            <h3 class="font-bold pl-0 my-4"><strong><?php echo $this->lang->line('Social'); ?> <?php echo $this->lang->line('Media'); ?></strong></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Facebook') . ' ' . $this->lang->line('Link') . ' : ', 'fb_link', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'fb_link', 'class' => 'form-control', 'name' => 'fb_link', 'value' => $fb_link, 'type' => 'url', 'placeholder' => $this->lang->line('Facebook') . ' ' . $this->lang->line('Link'))); ?>
                                        <?php echo form_error('fb_link'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Google+') . ' ' . $this->lang->line('Link') . ' : ', 'google_link', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'google_link', 'class' => 'form-control', 'name' => 'google_link', 'value' => $google_link, 'type' => 'url', 'placeholder' => $this->lang->line('Google+') . ' ' . $this->lang->line('Link'))); ?>
                                        <?php echo form_error('google_link'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Twitter') . ' ' . $this->lang->line('Link') . ' : ', 'twitter_link', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'twitter_link', 'class' => 'form-control', 'name' => 'twitter_link', 'value' => $twitter_link, 'type' => 'url', 'placeholder' => $this->lang->line('Twitter') . ' ' . $this->lang->line('Link'))); ?>
                                        <?php echo form_error('twitter_link'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Instagram') . ' ' . $this->lang->line('Link') . ' : ', 'insta_link', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'insta_link', 'class' => 'form-control', 'name' => 'insta_link', 'value' => $insta_link, 'type' => 'url', 'placeholder' => $this->lang->line('Instagram') . ' ' . $this->lang->line('Link'))); ?>
                                        <?php echo form_error('insta_link'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <?php echo form_label($this->lang->line('Linkdin') . ' ' . $this->lang->line('Link') . ' : ', 'linkdin_link', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('id' => 'linkdin_link', 'class' => 'form-control', 'name' => 'linkdin_link', 'value' => $linkdin_link, 'type' => 'url', 'placeholder' => $this->lang->line('Linkdin') . ' ' . $this->lang->line('Link'))); ?>
                                        <?php echo form_error('linkdin_link'); ?>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-kb-color btn-rounded prevBtn-2 float-left" type="button"><?php echo $this->lang->line('Previous'); ?></button>
                            <button class="btn btn-kb-color btn-rounded nextBtn-2 float-right" type="button"><?php echo $this->lang->line('Next'); ?></button>
                        </div>
                    </div>
                    <div class="row setup-content-2" id="step-6">
                        <div class="col-md-12">
                            <h3 class="font-bold pl-0 my-4"><strong><?php echo $this->lang->line('Media'); ?></strong></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 style="font-size: .8rem; color: #757575; margin-bottom: 1.5rem;"><?php echo $this->lang->line('Company'); ?> <?php echo $this->lang->line('Logo'); ?> <small class="required">*</small> <strong>(<?php echo $this->lang->line('Valid_logo_size'); ?>)</strong></h5>
                                        <div class="col-md-6">
                                            <img id="imageurl"  class="img-fluid"  src="<?php echo $logo_image; ?>" alt="Image" height="100">
                                        </div>
                                        <div class="file-field">
                                            <div class="btn btn-primary btn-sm">
                                                <span><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Image'); ?></span>
                                                <input onchange="readURL(this)" id="imageurl" <?php if ($logo_check == false) echo "required"; ?>  type="file" name="company_logo" accept="image/x-png,image/gif,image/jpeg,image/png"  extension="jpg|png|gif|jpeg" />
                                            </div>
                                            <div class="file-path-wrapper" >
                                                <input class="file-path form-control validate readonly" readonly type="text" placeholder="<?php echo $this->lang->line('Upload'); ?> <?php echo $this->lang->line('your'); ?> <?php echo $this->lang->line('file'); ?>" >
                                            </div>
                                        </div>
                                        <?php echo form_error('company_logo'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 style="font-size: .8rem; color: #757575; margin-bottom: 1.5rem;"><?php echo $this->lang->line('Home'); ?> <?php echo $this->lang->line('Banner'); ?> <?php echo $this->lang->line('Image'); ?> <small class="required">*</small> <strong>(<?php echo $this->lang->line('Valid_banner_size'); ?>)</strong></h5>
                                        <div class="col-md-6">
                                            <img id="banner_image"  class="img-fluid" src="<?php echo $banner_image; ?>" alt="Image" height="100">
                                        </div>
                                        <div class="file-field">
                                            <div class="btn btn-primary btn-sm">
                                                <span><?php echo $this->lang->line('Select'); ?> <?php echo $this->lang->line('Image'); ?></span>
                                                <input onchange="readURL(this)" id="banner_image"  type="file" name="banner_img" accept="image/*" extension="jpg|png|gif|jpeg"/>
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path form-control validate readonly" readonly type="text" placeholder="<?php echo $this->lang->line('Upload'); ?> <?php echo $this->lang->line('your'); ?> <?php echo $this->lang->line('file'); ?>" >
                                            </div>
                                        </div>
                                        <?php echo form_error('banner_img'); ?>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-kb-color btn-rounded prevBtn-2 float-left" type="button"><?php echo $this->lang->line('Previous'); ?></button>
                            <button class="btn btn-success btn-rounded float-right" type="submit"><?php echo $this->lang->line('Submit'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/sitesetting.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>