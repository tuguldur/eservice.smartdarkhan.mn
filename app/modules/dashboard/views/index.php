<?php include APPPATH . '/modules/views/header.php'; ?>
<!-- start dashboard -->
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content pt-0">
        <!-- Start Container -->
        <div class="container-fluid">
            <!-- Start Section -->
            <div class="row">
                <div class="col-md-12 pt-2">
                    <?php $this->load->view('message'); ?>
                </div>
            </div>
            <!-- Card Color Section -->
            <section class="form-light content px-2 sm-margin-b-20 pt-0">
                <div class="row">
                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a href="<?php echo base_url('request'); ?>" type="button" class="btn-floating mt-0 btn-lg warning-color ml-3 waves-effect waves-light"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo isset($total_request) ? $total_request : 0; ?></h5>
                                    <p class="font-small grey-text">БҮХ ЗӨВШӨӨРӨЛ</p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-7 col-7 text-left pr-0">
                                    <a href="<?php echo base_url('request'); ?>"><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue">ЗӨВШӨӨРӨЛ</span></p></a>
                                </div>
                                <div class="col-md-5 col-5 text-right">
                                    <a href="<?php echo base_url('submit_request'); ?>"><p class="font-small grey-text"><span class="badge green"><?php echo $this->lang->line('Add'); ?></span> </p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                </div>
            </section>
            <!-- Card Color Section -->
        </div>
        <!-- End Container -->
    </div> 
    <!-- End Content -->
</div>
<!-- End dashboard -->
<?php include APPPATH . '/modules/views/footer.php'; ?>
