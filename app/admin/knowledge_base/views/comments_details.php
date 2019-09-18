<?php
include APPPATH . '/modules/views/admin_header.php';
?>
<link href="<?php echo $this->config->item('admin_css_url'); ?>module/submit_request_chat.css" rel="stylesheet">
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 content sm-margin-b-20">
                <div class="row">
                    <?php if (!empty($comments_data) && count($comments_data) > 0) { ?>  
                        <div class="col-md-12 m-auto">
                            <div class="card">
                                <div class="frame ">
                                    <div id='messageContainer' class="auto_scroll" style="height: 300px;">
                                        <ul class="list-inline px-3">
                                            <?php
                                            if (isset($comments_data) && count($comments_data) > 0) {
                                                $get_comment_user = get_comment_user($comments_data['user_type'], $comments_data['customer_id']);
                                                if (file_exists(dirname(BASEPATH) . "/" . uploads_path . "/profiles/" . $get_comment_user['profile_image']) && $get_comment_user['profile_image'] != '') {
                                                    $user_src = ROOT_LOCATION . uploads_path . "/profiles/" . $get_comment_user['profile_image'];
                                                } else {
                                                    $user_src = ROOT_LOCATION . img_path . "/user.png";
                                                }
                                                ?>
                                                <li style="width:100%">
                                                    <div class="msj macro">
                                                        <div class="avatar">
                                                            <img class="rounded-circle" style="width:50px; height: 50px; margin-top: 5px;" src="<?php echo $user_src; ?>" />
                                                            <p class="profile-name"><?php echo ucfirst($get_comment_user['first_name']) ?></p>
                                                            <p class="profile-name"><?php echo ucfirst($get_comment_user['last_name']) ?></p>
                                                        </div>
                                                        <div class="text text-l">
                                                            <p><?php echo $comments_data['comment']; ?></p>
                                                            <p><small><?php echo date("F j, Y g:i a", strtotime($comments_data['created_on'])); ?></small></p>
                                                        </div>
                                                    </div>
                                                </li> 
                                                <?php
                                            }
                                            if (isset($sub_comments_data) && count($sub_comments_data) > 0) {
                                                foreach ($sub_comments_data as $sub_value) {
                                                    $get_comment_user = get_comment_user($sub_value['user_type'], $sub_value['customer_id']);
                                                    if (file_exists(dirname(BASEPATH) . "/" . uploads_path . "/profiles/" . $get_comment_user['profile_image']) && $get_comment_user['profile_image'] != '') {
                                                        $user_src = ROOT_LOCATION . uploads_path . "/profiles/" . $get_comment_user['profile_image'];
                                                    } else {
                                                        $user_src = ROOT_LOCATION . img_path . "/user.png";
                                                    }
                                                    ?>
                                                    <li style="width:100%">
                                                        <div class="msj-rta macro">
                                                            <div class="text text-r avatar_text_left">
                                                                <p><?php echo $sub_value['comment']; ?></p>
                                                                <p style="text-align: left;"><small><?php echo date("F j, Y g:i a", strtotime($sub_value['created_on'])); ?></small></p>
                                                            </div>
                                                            <div class="avatar right_avatar" style="padding-right:0; padding-left: 10px;">
                                                                <img class="rounded-circle" style="width:50px; height: 50px; margin-top: 5px;" src="<?php echo $user_src; ?>" />
                                                                <p class="profile-name"><?php echo ucfirst($get_comment_user['first_name']) ?></p>
                                                                <p class="profile-name"><?php echo ucfirst($get_comment_user['last_name']) ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>    
                                    <div>
                                        <?php echo form_open('comment-reply-send', array('name' => 'CommForm', 'id' => 'CommForm')); ?>
                                        <?php echo form_input(array('type' => 'hidden', 'name' => 'comment_id', 'id' => 'comment_id', 'value' => $comments_data['id'])); ?>
                                        <?php echo form_input(array('type' => 'hidden', 'name' => 'artical_id', 'id' => 'artical_id', 'value' => $comments_data['artical_id'])); ?>

                                        <div class="macro w-100 pt-4 " style="margin:auto;">                        
                                            <div class="w-100 text-r msg-type-box " style="background:whitesmoke !important;">
                                                <input class="mytext w-100  form-control" placeholder="Type a comment.." name='comment' required='true'/>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div> 
                                </div>   
                            <?php } ?>
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
    $('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
</script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>