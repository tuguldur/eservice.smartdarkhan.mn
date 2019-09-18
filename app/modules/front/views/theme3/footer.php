<!-- Footer -->
<footer class="page-footer theme_footer">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-6">
                <p>Copyright &copy; 2018 All Rights Reserved by <strong> Knowledgebase</strong></p>                
            </div>
            <div class="col-md-6">
                <ul class="social_icon list-inline inline-ul">
                    <span>Connect via Social :</span>
                    <li class="fb-icon">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li class="tw-icon">
                        <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li class="gp-icon">
                        <a href="#"><i class="fa fa-google-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <button type="button" class="footer__btn"><i class="fa fa-chevron-up"></i></button>
    </div>
    <!-- Footer Links -->
</footer>

<!--Modal (Post & Submit Request)-->
<!--model-->

<!--[1].Post Modal-->
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

<!--[2].Submit Request Modal-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo $this->lang->line('Submit'); ?> <?php echo $this->lang->line('Request'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id='confirm_msg' style="font-size: 15px;"><?php echo $this->lang->line('Request_error'); ?></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default pull-right" href="<?php echo base_url('login') ?>" ><?php echo $this->lang->line('Login'); ?></a>
                <a class="btn btn-primary pull-right" href="<?php echo base_url('register') ?>" ><?php echo $this->lang->line('Register'); ?></a>
            </div>
        </div>
    </div>
</div>
<!--End Modal (Post & Submit Request)-->

<!-- Back to Top -->
<!--<a id="toTop" class="animated lightSpeedIn" title="<?php echo $this->lang->line('Back_Top'); ?>">
    <i class="fa fa-angle-up"></i>
</a>-->
<!-- /Back to Top -->
<script>
    $('.footer__btn').on('click', function () {
        $('body,html').animate({
            scrollTop: 0,
        }, 700 // - duration of the top scrolling animation (in ms)
                );
    });
</script>
</body>
</html>
