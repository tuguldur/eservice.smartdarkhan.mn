<?php include APPPATH . '/modules/views/header.php'; ?>
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
                        <div class="header bg-color-base">
                            <div class="d-flex justify-content-center">
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3">Цахим зөвшөөрөл</h3>
                                </span>  
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <a  href='<?php echo base_url('submit_request'); ?>' class="btn-floating btn-sm btn-success"><i class="fa fa-plus-circle"></i></a>
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
                                                <th class="text-center font-bold dark-grey-text">Нэр</th>
                                                <th class="font-bold dark-grey-text">Зурвас</th>
                                                <th class="text-center font-bold dark-grey-text">text</th>
                                                <th class="text-center font-bold dark-grey-text">Хугацаа</th>
                                                <th class="text-center font-bold dark-grey-text">Төлөв</th>
                                                <th class="text-center font-bold dark-grey-text">Зурвас</th>
                                                <th class="text-center font-bold dark-grey-text">Огноо</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($request_data) && count($request_data) > 0) {
                                                $i = 1;
                                                foreach ($request_data as $row) {
                                                    $Unread_reply = (int) get_unread_requst($row['id']);
                                                    ?>
                                                    <tr data-id="<?php echo (int) $row['id']; ?>" onclick="replay_redirect(this);" class="data-tr">
                                                        <td  class="text-center"><?php echo "№" . str_pad($row['id'], 4, "0", STR_PAD_LEFT); ?></td>
                                                        <td  class="text-center"><?php echo ucfirst($row['first_name']) . "&nbsp;" . ucfirst($row['last_name']); ?></td>
                                                        <td><?php if ($Unread_reply > 0) { ?><span class="badge red"><?php echo $Unread_reply ?></span></span><span>  <?php echo $this->lang->line('New'); ?> <?php echo $this->lang->line('Message'); ?></span><?php } ?></td>
                                                        <td  class="text-center"><?php echo ucfirst($row['subject']); ?></td>
                                                        <?php
                                                        if ($row['request_priority'] == 'H') {
                                                            $Priority = $this->lang->line('1 жил');
                                                            $Priority_alert = "success";
                                                        } elseif ($row['request_priority'] == 'M') {
                                                            $Priority = $this->lang->line('2 жил');
                                                            $Priority_alert = "success";
                                                        } else {
                                                            $Priority = $this->lang->line('3 жил');
                                                            $Priority_alert = "success";
                                                        }
                                                        ?>
                                                        <td  class="text-center"><span class="alert alert-<?php echo $Priority_alert; ?>"><?php echo $Priority; ?></span></td>
                                                        <?php
                                                        if ($row['status'] == 'O') {
                                                            $r_status = $this->lang->line('Open');
                                                            $alert = "success";
                                                        } elseif ($row['status'] == 'P') {
                                                            $r_status = $this->lang->line('Pending');
                                                            $alert = "danger";
                                                        } else {
                                                            $r_status = $this->lang->line('Solved');
                                                            $alert = "info";
                                                        }
                                                        ?>
                                                        <td  class="text-center"><span class="alert alert-<?php echo $alert; ?>"><?php echo $r_status; ?></span></td>
                                                        <td class="text-center">
                                                            <?php
                                                            $request_reply = get_reply_user($row['last_reply'], $row['reply_type']);
                                                            if ($request_reply != false) {
                                                                if (file_exists(dirname(BASEPATH) . "/" . uploads_path . '/profiles/' . $request_reply['profile_image']) && $request_reply['profile_image'] != "") {
                                                                    $logo_image = ROOT_LOCATION . uploads_path . '/profiles/' . $request_reply['profile_image'];
                                                                } else {
                                                                    $logo_image = ROOT_LOCATION . img_path . "/no-image.png";
                                                                }
                                                                ?>
                                                                
                                                                <?php echo date("M d, Y H:i", strtotime($row['updated_on'])); ?>
                                                                <?php
                                                            } else {
                                                                echo 'No Reply';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td  class="text-center"><?php echo date("M d, Y", strtotime($row['created_on'])); ?></td>
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
<script>
    function replay_redirect(e) {
        var id = $(e).data("id");
        window.location.href = base_url + "submit-request-reply/" + id;
    }
</script>
<?php include APPPATH . '/modules/views/footer.php'; ?>