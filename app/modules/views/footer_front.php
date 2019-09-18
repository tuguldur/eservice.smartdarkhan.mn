                                                                                                                                                                                                    <?php
$this->db->select('*', false);
$this->db->from('app_site_setting');
$company_data = $this->db->get()->row();
?>
<footer class="page-footer pt-0 lr-page">
    <div class="container">    
        <!-- Copyright -->
        <div class="footer-copyright d-inline">
            <div class="pt-0 float-left" style="padding: 0px 0 0 0px;">
                <strong>&copy;</strong> ESERVICE DARKHAN | Developed by ERD SYSTEM Co.,ltd
            </div>
        </div>
        <ul class="ml-auto inline-ul d-inline">
            <?php if (isset($company_data->fb_link) && $company_data->fb_link != '') { ?>
                <li>
                    <a href="<?php echo $company_data->fb_link ?>"><i class="fa fa-facebook white-text"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($company_data->google_link) && $company_data->google_link != '') { ?>
                <li>
                    <a href="<?php echo $company_data->google_link ?>"><i class="fa fa-google-plus white-text"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($company_data->twitter_link) && $company_data->twitter_link != '') { ?>
                <li>
                    <a href="<?php echo $company_data->twitter_link ?>"><i class="fa fa-twitter white-text"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($company_data->linkdin_link) && $company_data->linkdin_link != '') { ?>
                <li>
                    <a href="<?php echo $company_data->linkdin_link ?>"><i class="fa fa-linkedin  white-text"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($company_data->insta_link) && $company_data->insta_link != '') { ?>
                <li>
                    <a href="<?php echo $company_data->insta_link ?>"><i class="fa fa-instagram white-text"></i></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- Copyright -->
</footer>

<!-- Back to Top -->
<a id="toTop" class="animated lightSpeedIn" title="<?php echo $this->lang->line('Back_Top'); ?>">
    <i class="fa fa-angle-up"></i>
</a>
<!-- /Back to Top -->
<!--model-->
<div class="modal fade" id="PostModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo $this->lang->line('New'); ?> <?php echo $this->lang->line('Post'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id='confirm_msg' style="font-size: 15px;"><?php echo $this->lang->line('New_post_error'); ?></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default pull-right" href="<?php echo base_url('login') ?>" ><?php echo $this->lang->line('Login'); ?></a>
                <a class="btn btn-primary pull-right" href="<?php echo base_url('register') ?>" ><?php echo $this->lang->line('Register'); ?></a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->config->item('js_url'); ?>popper.min.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>knowledge_base.min.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>admin_panel.js"></script>
</body>
</html>