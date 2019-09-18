<?php
include APPPATH . '/modules/views/admin_header.php';
?>
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
                    <?php if ($this->session->userdata('ADMIN_TYPE') == 'A') { ?>
                        <!--Grid column-->
                        <div class="col-xl-3 col-md-3">
                            <!--Card-->
                            <div class="card">
                                <!--Card Data-->
                                <div class="row mt-3">
                                    <div class="col-md-5 col-5 text-left pl-3">
                                        <a href='<?php echo base_url('customer'); ?>' type="button" class="btn-floating mt-0 btn-lg warning-color ml-3 waves-effect waves-light"><i class="fa fa-user" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-md-7 col-7 text-right pr-30">
                                        <h5 class="ml-4 mb-2 font-bold"><?php echo $total_customer; ?></h5>
                                        <p class="font-small grey-text">БҮХ ХЭРЭГЛЭГЧ</p>
                                    </div>
                                </div>
                                <!--/.Card Data-->
                                <!--Card content-->
                                <div class="row mx-1 my-2 pb-10">
                                    <div class="col-md-12 col-12 text-left">
                                        <a href='<?php echo base_url('customer'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue">ХЭРЭГЛЭГЧ ХЯНАХ</span></p></a>
                                    </div>
                                </div>
                                <!--/.Card content-->
                            </div>
                            <!--/.Card-->
                        </div>
                        <!--Grid column-->
                        <!--Grid column-->
                        <div class="col-xl-3 col-md-3">
                            <!--Card-->
                            <div class="card">
                                <!--Card Data-->
                                <div class="row mt-3">
                                    <div class="col-md-5 col-5 text-left pl-3">
                                        <a type="button" href='<?php echo base_url('agent'); ?>' class="btn-floating mt-0 btn-lg blue-gradient ml-3 waves-effect waves-light"><i class="fa fa-user-secret" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-md-7 col-7 text-right pr-30">
                                        <h5 class="ml-4 mb-2 font-bold"><?php echo $total_agent; ?></h5>
                                        <p class="font-small grey-text">БҮХ АЖИЛТАН</p>
                                    </div>
                                </div>
                                <!--/.Card Data-->
                                <!--Card content-->
                                <div class="row mx-1 my-2">
                                    <div class="col-md-7 col-7 text-left pr-0">
                                        <a href='<?php echo base_url('agent'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue">АЖИЛТАН</span></p></a>
                                    </div>
                                    <div class="col-md-5 col-5 text-right">
                                        <a href='<?php echo base_url('add-agent'); ?>'><p class="font-small grey-text"><span class="badge green"><?php echo $this->lang->line('Add'); ?></span> </p></a>
                                    </div>
                                </div>
                                <!--/.Card content-->
                            </div>
                            <!--/.Card-->
                        </div>
                        <!--Grid column-->
                    <?php } ?>

                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='<?php echo base_url('manage-group'); ?>' class="btn-floating mt-0 btn-lg grey ml-3 waves-effect waves-light"><i class="fa fa-group" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_group; ?></h5>
                                    <p class="font-small grey-text">БҮХ БАЙГУУЛЛАГА</p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-7 col-7 text-left pr-0">
                                    <a href='<?php echo base_url('manage-group'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue">БАЙГУУЛЛАГА</span></p></a>
                                </div>
                                <div class="col-md-5 col-5 text-right">
                                    <a href='<?php echo base_url('insert-group'); ?>'><p class="font-small grey-text"><span class="badge green"><?php echo $this->lang->line('Add'); ?></span> </p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='<?php echo base_url('manage-article'); ?>' class="btn-floating mt-0 deep-orange btn-lg dark-blue lighten-1 ml-3 waves-effect waves-light"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_article; ?></h5>
                                    <p class="font-small grey-text">БҮХ МЭДЭЭЛЭЛ</p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2">
                                <div class="col-md-7 col-7 text-left pr-0">
                                    <a href='<?php echo base_url('manage-article'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue">МЭДЭЭЛЭЛ</span></p></a>
                                </div>
                                <div class="col-md-5 col-5 text-right">
                                    <a href='<?php echo base_url('insert-article'); ?>'><p class="font-small grey-text"><span class="badge green"><?php echo $this->lang->line('Add'); ?></span> </p></a>
                                </div>
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                    <div class="col-xl-3 col-md-3">
                        <!--Card-->
                        <div class="card">
                            <!--Card Data-->
                            <div class="row mt-3">
                                <div class="col-md-5 col-5 text-left pl-3">
                                    <a type="button" href='<?php echo base_url('admin-request'); ?>' class="btn-floating mt-0 btn-lg success-color ml-3 waves-effect waves-light"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-md-7 col-7 text-right pr-30">
                                    <h5 class="ml-4 mb-2 font-bold"><?php echo $total_request; ?></h5>
                                    <p class="font-small grey-text">БҮХ ЗӨВШӨӨРӨЛ</p>
                                </div>
                            </div>
                            <!--/.Card Data-->
                            <!--Card content-->
                            <div class="row mx-1 my-2 pb-10">
                                <div class="col-md-9 col-9 text-left pr-0">
                                    <a href='<?php echo base_url('admin-request'); ?>'><p class="font-small dark-grey-text font-up font-bold"><span class="badge badge-blue">ЗӨВШӨӨРӨЛ ХЯНАХ</span></p></a>
                                </div>
                                <!--<div class="col-md-5 col-5 text-right">-->
                                    <!--<a href='<?php echo base_url(''); ?>'><p class="font-small grey-text"><span class="badge green"><?php echo $this->lang->line('Add'); ?></span> </p></a>-->
                                <!--</div>-->
                            </div>
                            <!--/.Card content-->
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                    <?php if ($this->session->userdata('ADMIN_TYPE') == 'A') { ?>
                        <!--Grid column-->
                        
                                </div>
                                <!--/.Card content-->
                            </div>
                            <!--/.Card-->
                        </div>
                        <!--Grid column-->
                        <!--Grid column-->
                        
                            <!--/.Card-->
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        
                            <!--/.Card-->
                        </div>
                        <!--Grid column-->
                    <?php } ?>
                </div>
            </section>
            <!-- Card Color Section -->
        </div>
        <!-- End Container -->
    </div> 
    <!-- End Content -->
</div> 
<!-- End dashboard -->
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>
