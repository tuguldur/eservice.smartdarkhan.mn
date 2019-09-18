<?php include APPPATH . '/modules/views/admin_header.php'; ?>
<link href="<?php echo $this->config->item('admin_css_url'); ?>module/submit_request_chat.css" rel="stylesheet">
<style>
    .select-wrapper input.select-dropdown {
        color: #212529;
    }
    .select-wrapper span.caret {
        top: 18px;
        color: #212529;
    }
    tr{
        border-top: 1px solid #ddd;
    }
</style>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <div class="row">
                    <div class="col-md-8">
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <div style="width: 98%;">
                                    <h3 class="white-text mb-3 font-bold pull-left"> 
                                        <?php echo "№" . str_pad($request_main['id'], 4, "0", STR_PAD_LEFT); ?> &nbsp;<?php echo $request_main['subject']; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "frame ">
                                <?php
                                if ($request_main['status'] != "S") {
                                    echo form_open_multipart('admin-request-reply-send', array('name' => 'chat_form', 'id' => 'chat_form'));
                                    ?>
                                    <div class="macro w-100 pt-4 pl-20" style="margin-top: auto;">                        
                                        <div class="form-group w-100 text-r msg-type-box" style="background:whitesmoke !important;">
                                            <textarea class="mt-3 w-100 form-control" name='message' required='true' placeholder="Асуулт хариулт болон нэмэлт мэдээлэл бичих..." style="resize: none;height: 8rem;background:whitesmoke !important;"></textarea>
                                            <button type="button" id="attachment_btn" class="btn-floating btn-sm blue-gradient waves-light"><i class="fa fa-paperclip"></i></button>
                                            <input type="file" name="attachment" id="attachment" style="display: none;"/>
                                            <button type="submit" class="btn purple-gradient btn-rounded waves-light btn-md pull-right">Илгээх</button>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div id='messageContainer'   class="auto_scroll">
                                    <?php if ($request_main['status'] == "S") { ?>
                                        <p class="alert alert-warning mt-4"><i class="fa fa-warning">&nbsp;</i>Таны цахим зөвшөөрөл амжилттай олгогдлоо.</p>
                                    <?php } ?>
                                    <ul class="list-inline px-3">
                                        <?php
                                        if (isset($request_data) && count($request_data) > 0) {
                                            foreach ($request_data as $value) {
                                                $get_request_user = get_request_user($value['user_type'], $value['customer_id']);
                                                if (file_exists(dirname(BASEPATH) . "/" . uploads_path . "/profiles/" . $get_request_user['profile_image']) && $get_request_user['profile_image'] != '') {
                                                    $user_src = ROOT_LOCATION . uploads_path . "/profiles/" . $get_request_user['profile_image'];
                                                } else {
                                                    $user_src = ROOT_LOCATION . img_path . "/user.png";
                                                }
                                                if ($value['user_type'] == "A") {
                                                    if ($value['customer_id'] == $this->session->userdata('ADMIN_ID')) {
                                                        ?>
                                                        <li style="width:100%">
                                                            <div class="msj macro">
                                                                <div class="avatar">
                                                                    <img class="rounded-circle" style="width:50px; height: 50px; margin-top: 5px;" src="<?php echo $user_src; ?>" />
                                                                    <p class="profile-name"><?php echo $get_request_user['first_name']; ?></p>
                                                                    <p class="profile-name"><?php echo $get_request_user['last_name']; ?></p>
                                                                </div>
                                                                <div class="text text-l">
                                                                    <p><?php echo $value['description'] ?></p>
                                                                    <?php if ($value['attchment']) { ?>
                                                                        <p><a download href="<?php echo ROOT_LOCATION . uploads_path . "/request/" . $value['attchment']; ?>" style="text-decoration: none;"><i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('Attchment'); ?></a></p>
                                                                    <?php } ?>
                                                                    <p><small><?php echo date("F j, Y g:i a", strtotime($value['created_on'])); ?></small></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <li style="width:100%">
                                                            <div class="msj-rta macro">
                                                                <div class="text text-r avatar_text_left">
                                                                    <p><?php echo $value['description'] ?></p>
                                                                    <?php if ($value['attchment']) { ?>
                                                                        <p><a download href="<?php echo ROOT_LOCATION . uploads_path . "/request/" . $value['attchment']; ?>" style="text-decoration: none;"><i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('Attchment'); ?></a></p>
                                                                    <?php } ?>
                                                                    <p style="text-align: left;"><small><?php echo date("F j, Y g:i a", strtotime($value['created_on'])); ?></small></p>
                                                                </div>
                                                                <div class="avatar right_avatar" style="padding-right:0; padding-left: 10px;">
                                                                    <img class="rounded-circle" style="width:50px; height: 50px; margin-top: 5px;" src="<?php echo $user_src; ?>" />
                                                                    <p class="profile-name"><?php echo $get_request_user['first_name']; ?></p>
                                                                    <p class="profile-name"><?php echo $get_request_user['last_name']; ?></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <li style="width:100%">
                                                        <div class="msj-rta macro">
                                                            <div class="text text-r avatar_text_left">
                                                                <p><?php echo $value['description'] ?></p>
                                                                <?php if ($value['attchment']) { ?>
                                                                    <p><a download href="<?php echo ROOT_LOCATION . uploads_path . "/request/" . $value['attchment']; ?>" style="text-decoration: none;"><i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('Attchment'); ?></a></p>
                                                                <?php } ?>
                                                                <p style="text-align: left;"><small><?php echo date("F j, Y g:i a", strtotime($value['created_on'])); ?></small></p>
                                                            </div>
                                                            <div class="avatar right_avatar" style="padding-right:12px; padding-left: 10px;">
                                                                <img class="rounded-circle" style="width:50px; height: 50px; margin-top: 5px;" src="<?php echo $user_src; ?>" />
                                                                <p class="profile-name"><?php echo $get_request_user['first_name']; ?></p>
                                                                <p class="profile-name"><?php echo $get_request_user['last_name']; ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        if (file_exists(dirname(BASEPATH) . "/" . uploads_path . "/profiles/" . $request_main['profile_image']) && $request_main['profile_image'] != '') {
                                            $user_src = ROOT_LOCATION . uploads_path . "/profiles/" . $request_main['profile_image'];
                                        } else {
                                            $user_src = ROOT_LOCATION . img_path . "/user.png";
                                        }
                                        ?>
                                        <li style="width:100%">
                                            <div class="msj-rta macro">
                                                <div class="text text-r avatar_text_left">
                                                    <p><?php echo $request_main['description'] ?></p>
                                                    <?php if ($request_main['attchment']) { ?>
                                                        <p><a download href="<?php echo ROOT_LOCATION . uploads_path . "/request/" . $request_main['attchment']; ?>" style="text-decoration: none;"><i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('Attchment'); ?></a></p>
                                                    <?php } ?>
                                                    <p><small><?php echo date("F j, Y g:i a", strtotime($request_main['created_on'])); ?></small></p>
                                                </div>
                                                <div class="avatar right_avatar" style="padding-right:0; padding-left: 10px;">
                                                    <img class="rounded-circle" style="width:50px; height: 50px; margin-top: 5px;" src="<?php echo $user_src; ?>" />
                                                    <p class="profile-name"><?php echo $request_main['first_name']; ?></p>
                                                    <p class="profile-name"><?php echo $request_main['last_name']; ?></p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>   
                                <?php
                                if ($request_main['status'] != "S") {
                                    echo form_input(array('type' => 'hidden', 'name' => 'request_id', 'id' => 'request_id', 'value' => $request_main['id']));
                                    echo form_close();
                                }
                                ?>
                            </div>   
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">ЗӨВШӨӨРӨЛИЙН МЭДЭЭЛЭЛ</h4>
                                <table width="100%" cellpadding="12">
                                    <tr>
                                        <td>№</td>
                                        <td><?php echo str_pad($request_main['id'], 4, "0", STR_PAD_LEFT); ?></td>
                                    </tr>
                                    <tr>
                                        <td>text</td>
                                        <td><?php echo $request_main['subject']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Цахим завшөөрөл хүссэн газар</td>
                                        <td><?php echo $request_main['title']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Хугацаа</td>
                                        <td><?php echo isset($request_main['request_priority']) && $request_main['request_priority'] == 'H' ? '1 жил' : (($request_main['request_priority']) && $request_main['request_priority'] == 'M' ? '2 жил' : '3 жил'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Төлөв</td>
                                        <td>
                                            <?php
                                            echo form_open_multipart('admin-change-request-status', array('name' => 'chat_form', 'id' => 'chat_form'));
                                            echo form_input(array('type' => 'hidden', 'name' => 'request_id', 'id' => 'request_id', 'value' => $request_main['id']));
                                            ?>
                                            <select class="kb-select initialized" onchange="this.form.submit()" name="request-status" style="color: white !important;">
                                                <?php if ($request_main['status'] != "S" && $request_main['status'] != "RO") { ?>
                                                    <option value="O" <?php echo isset($request_main['status']) && $request_main['status'] == "O" ? "selected" : ""; ?>><?php echo $this->lang->line('Open'); ?></option>
                                                    <option value="P" <?php echo isset($request_main['status']) && $request_main['status'] == "P" ? "selected" : ""; ?>><?php echo $this->lang->line('Pending'); ?></option>
                                                <?php }if ($request_main['status'] != "O" && $request_main['status'] != "P") { ?>
                                                    <option value="RO" <?php echo isset($request_main['status']) && $request_main['status'] == "RO" ? "selected" : ""; ?>><?php echo $this->lang->line('Re-Open'); ?></option>
                                                <?php } ?>
                                                <option value="S" <?php echo isset($request_main['status']) && $request_main['status'] == "S" ? "selected" : ""; ?>><?php echo $this->lang->line('Solved'); ?></option>
                                            </select>    
                                            <?php echo form_close(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Үүссэн огноо</td>
                                        <td><?php echo $request_main['created_on']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Шинэчлэгдсэн огноо</td>
                                        <td><?php echo $request_main['updated_on']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Хэрэглэгч</td>
                                        <td><?php echo ucfirst($request_main['first_name']) . " " . ucfirst($request_main['last_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Емайл</td>
                                        <td><?php echo $request_main['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ажилтан</td>
                                        <td>
                                            <?php
                                            $assign_agent = get_assign_agent($request_main['assign_id']);
                                            if ($assign_agent != false) {
                                                foreach ($assign_agent as $value) {
                                                    if (file_exists(dirname(BASEPATH) . "/" . uploads_path . '/profiles/' . $value[0]['profile_image']) && $value[0]['profile_image'] != "") {
                                                        $logo_image = ROOT_LOCATION . uploads_path . '/profiles/' . $value[0]['profile_image'];
                                                    } else {
                                                        $logo_image = ROOT_LOCATION . img_path . "/no-image.png";
                                                    }
                                                    ?>
                                                    <div class="user-box-avatar">
                                                        <img src="<?php echo $logo_image; ?>" title="<?php echo ucfirst($value[0]['first_name']) . " " . ucfirst($value[0]['last_name']); ?>">
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                echo 'No Assigned';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> 
        <!-- End Container -->
    </div>
    <!-- End Content -->
</div> 
<!-- End Dashboard -->
<script>
    $('#attachment_btn').click(function () {
        $('#attachment').trigger('click');
    });
</script>
<link href="<?php echo $this->config->item('admin_js_url'); ?>module/submit_request_reply.js" rel="stylesheet">
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>