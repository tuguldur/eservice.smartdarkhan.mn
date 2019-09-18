<?php include APPPATH . '/modules/views/admin_header.php'; ?>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header bg-color-base">
                            <div class="d-flex">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3">Зөвшөөрөлийн төрөл </h3>
                                </span>  
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <a  href='<?php echo base_url('add-category'); ?>' class="btn-floating btn-sm btn-success"><i class="fa fa-plus-circle"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mdl-data-table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center font-bold dark-grey-text">№</th>
                                                <th class="text-center font-bold dark-grey-text">Зөвшөөрөлийн нэр</th>
                                                <th class="text-center font-bold dark-grey-text">Төлөв</th>
                                                <th class="text-center font-bold dark-grey-text">Үүссэн огноо</th>
                                                <th class="text-center font-bold dark-grey-text">Үйлдэл</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if (isset($category_data) && count($category_data) > 0) {
                                                foreach ($category_data as $row) {
                                                    $status_string = "";
                                                    if ($row['status'] == "A") {
                                                        $status_string = '<span class="alert alert-success">' . $this->lang->line('Active') . '</span>';
                                                    } else {
                                                        $status_string = '<span class="alert alert-danger">' . $this->lang->line('Inactive') . '</span>';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $i; ?></td>
                                                        <td class="text-center"><?php echo $row['title']; ?></td>
                                                        <td class="text-center"><?php echo $status_string; ?></td>
                                                        <td class="text-center"><?php echo date("m/d/Y", strtotime($row['created_on'])); ?></td>
                                                        <td class="td-actions text-center">
                                                            <a href="<?php echo base_url('update-category/' . $row['id']); ?>" class="btn-danger btn-floating btn-sm blue-gradient" title="Edit"><i class="fa fa-pencil"></i></a>
                                                            <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm red-gradient" title="Delete"><i class="fa fa-close"></i></a>
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
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
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
                    <h4 id='some_name' class="modal-title" style="font-size: 18px;"></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id='confirm_msg' style="font-size: 15px;"></p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button" title="Edit"><?php echo $this->lang->line('Close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="RecordDelete" title="Category"><?php echo $this->lang->line('Confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/category.js" type='text/javascript'></script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>