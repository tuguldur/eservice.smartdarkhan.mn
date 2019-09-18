<?php include APPPATH . '/modules/views/header.php'; ?>

<!-- start dashboard -->
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
                        <div id="main_notification">
                        </div>
                        <div class="header bg-color-base">
                            <div class="d-flex justify-content-center">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3"><?php echo $this->lang->line('Manage'); ?> <?php echo $this->lang->line('Post'); ?></h3>
                                </span>  
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <a  href='<?php echo base_url('community-post'); ?>' class="btn-floating btn-sm btn-success"><i class="fa fa-plus-circle"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class=" card mytablerecord">  
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table mdl-data-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center font-bold dark-grey-text">#</th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Title'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Topic'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Post'); ?> <?php echo $this->lang->line('Status'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Total'); ?> <?php echo $this->lang->line('Vote'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Status'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Created'); ?> <?php echo $this->lang->line('Date'); ?></th>
                                                    <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $post_status = '';
                                                if (isset($all_post_data) && count($all_post_data) > 0) {
                                                    foreach ($all_post_data as $row) {
                                                        ?>
                                                        <?php
                                                        if ($row['post_status'] == 'NS') {
                                                            $post_status = 'No Status';
                                                        } elseif ($row['post_status'] == 'P') {
                                                            $post_status = 'Planned';
                                                        } elseif ($row['post_status'] == 'NP') {
                                                            $post_status = 'Not Planned';
                                                        } elseif ($row['post_status'] == 'C') {
                                                            $post_status = 'Completed';
                                                        } elseif ($row['post_status'] == 'A') {
                                                            $post_status = 'Answered';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i; ?></td>
                                                            <td class="text-center"><?php echo $row['title']; ?></td>
                                                            <td class="text-center"><?php echo $row['topic_title']; ?></td>
                                                            <td class="text-center"><label class="badge badge-info py-2 px-3" style="cursor: inherit;"><?php echo $post_status; ?></label></td>
                                                            <td class="text-center"><label class="badge badge-secondary py-2 px-3" style="cursor: inherit;"><?php echo $row['total_vote']; ?></label></td>
                                                            <td class="text-center"> 
                                                                <div class="switch">
                                                                    <label class="alert alert-<?php echo isset($row['status']) && $row['status'] == 'A' ? "success" : "danger" ?>" style="padding: 5px;"><?php echo isset($row['status']) && $row['status'] == 'A' ? "Active" : "Inactive" ?></label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center"><?php echo date("m/d/Y", strtotime($row['created_on'])); ?></td>
                                                            <td class="td-actions text-center">
                                                                <a href="<?php echo base_url('post-edit') . "/" . $row['id']; ?>" type="button" rel="tooltip" class="btn-floating btn-sm blue-gradient"> <i class="fa fa-pencil-square-o"></i> </a>
                                                                <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm" title="Post"><i class="fa fa-close"></i></a>
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
                        <!-- /.card -->
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
                    <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo $this->lang->line('Delete'); ?> <?php echo $this->lang->line('Confirmation'); ?></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id='confirm_msg' style="font-size: 15px;"></p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo $this->lang->line('Close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="RecordDelete" ><?php echo $this->lang->line('Confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="<?php echo $this->config->item('js_url'); ?>customer_post.js" type="text/javascript"></script>
<?php include APPPATH . '/modules/views/footer.php'; ?>
