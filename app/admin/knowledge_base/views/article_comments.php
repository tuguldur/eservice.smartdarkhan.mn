<?php
include APPPATH . '/modules/views/admin_header.php';
?>
<!-- start dashboard -->
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div id="main_notification">
                        </div>
                        <div class="header bg-color-base">
                            <div class="d-flex">
                                <span class="text-left">
                                    <h3 class="white-text font-bold pt-3"><?php echo $this->lang->line('Article') . " " . $this->lang->line('Comments'); ?></h3>
                                </span>  
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mdl-data-table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center font-bold dark-grey-text">#</th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Article'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Customer'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Comments'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Created') . " " . $this->lang->line('Date'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if (isset($article_comments_data) && count($article_comments_data) > 0) {
                                                foreach ($article_comments_data as $row) {
                                                    $total_article = 0;
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $i; ?></td>
                                                        <td class="text-center"><?php echo $row['title']; ?></td>
                                                        <td class="text-center">  
                                                            <?php echo ucfirst($row['first_name']) . " " . $row['last_name']; ?>
                                                        </td>
                                                        <td class="text-center"><?php echo nl2br($row['comment']); ?></td>
                                                        <td class="text-center"><?php echo date("m/d/Y", strtotime($row['created_on'])); ?></td>
                                                        <td class="td-actions text-center">
                                                            <a href="<?php echo base_url('comments-details/' . $row['id'] . "/" . $row['artical_id']); ?>" type="button" rel="tooltip" class="btn-floating btn-sm blue-gradient">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            } 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.Card -->
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
            <!-- Issues Section -->
        </div>
    </div>   
</div>
<!-- Modal -->
<div class="modal fade" id="delete-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                <input type="hidden" id="record_id"/>
                <div class="modal-header">
                    <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo $this->lang->line('Delete'); ?> <?php echo $this->lang->line('Confirmation'); ?></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id='confirm_msg' style="font-size: 18px;"></p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo $this->lang->line('Close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="RecordDelete" ><?php echo $this->lang->line('Confirm'); ?></a>
                    <a style="display: none" class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="group_delete" ><?php echo $this->lang->line('Article'); ?> <?php echo $this->lang->line('List'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/knowledge_group.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>