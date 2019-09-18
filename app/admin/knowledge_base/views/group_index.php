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
                            <div class="d-flex justify-content-center">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3">Үйлчилгээний байгууллага</h3>
                                </span>  
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <a href='<?php echo base_url('insert-group'); ?>'  class="btn-floating btn-sm btn-success pull-right"><i class="fa fa-plus-circle"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <!--<div id="colorSelector" class="card-header colorSelector white-text">Group Detail</div>-->
                                    <table class="table mdl-data-table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center font-bold dark-grey-text">№</th>
                                                <th class="text-center font-bold dark-grey-text">Нэр</th>
                                                <th class="text-center font-bold dark-grey-text">Бүх мэдээлэл</th>
                                                <th class="text-center font-bold dark-grey-text">Төлөв</th>
                                                <th class="text-center font-bold dark-grey-text">Үүссэн огноо</th>
                                                <th class="text-center font-bold dark-grey-text">Үйлдэл</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if (isset($group_data) && count($group_data) > 0) {
                                                foreach ($group_data as $row) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $i; ?></td>
                                                        <td class="text-center"><?php echo $row['title']; ?></td>
                                                        <td class="text-center"> <a href="<?php echo base_url('manage-article/') . $row['id']; ?>"><label class="badge badge-info py-2 px-3" style="cursor: inherit;"><?php echo $row['total']; ?></label></a></td>
                                                        <td class="text-center">  
                                                            <div class="switch">
                                                                <label class="alert alert-<?php echo isset($row['status']) && $row['status'] == 'A' ? "success" : "danger" ?>" style="padding: 5px;"><?php echo isset($row['status']) && $row['status'] == 'A' ? "Active" : "Inactive" ?></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?php echo date("m/d/Y", strtotime($row['created_on'])); ?></td>
                                                        <td class="td-actions text-center">
                                                            <a href="<?php echo base_url('edit-group') . "/" . $row['id']; ?>" type="button" rel="tooltip" class="btn-floating btn-sm blue-gradient">
                                                                <i class="fa fa-pencil-square-o"></i>
                                                            </a>
                                                            <a id="<?php echo $row['total']; ?>" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm red-gradient" title="<?php echo $this->lang->line('Group'); ?>"><i class="fa fa-close"></i></a>
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