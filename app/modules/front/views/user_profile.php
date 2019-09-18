<?php
include APPPATH . '/modules/views/header_front.php';
?>
<div>
    <div class="col-md-12">
        <div class="row">
            <div class="user_profile_bg grey lighten-4 w-100">
                <div class="container">
                    <div class="my-5">
                        <div class="form-inline">
                            <div class="logo">
                                <?php
                                $root_dir = FCPATH . uploads_path . '/profiles/';
                                if (file_exists($root_dir . $user_profile[0]['profile_image']) && $user_profile[0]['profile_image'] != "") {
                                    $logo_image = base_url() . uploads_path . '/profiles/' . $user_profile[0]['profile_image'];
                                } else {
                                    $logo_image = base_url() . img_path . "/user.png";
                                }
                                ?>
                                <img class="rounded-circle" src="<?php echo $logo_image; ?>" alt="Image" width="60" height="50">
                            </div>
                            <div class="user_name">
                                <h4><?php echo ucfirst($user_profile[0]['first_name']) . " " . ucfirst($user_profile[0]['last_name']); ?></h4>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div class="total_activity">
                                <p><?php echo $this->lang->line('Total'); ?> <?php echo $this->lang->line('Activity'); ?></p>
                                <p><strong><?php echo count($user_profile); ?></strong></p>
                            </div>
                            <div class="last_activity">
                                <p><?php echo $this->lang->line('Last'); ?> <?php echo $this->lang->line('Activity'); ?></p>
                                <?php
                                $date1 = date('Y-m-d H:i:s');
                                $date2 = date('Y-m-d H:i:s', strtotime($user_profile[0]['created_on']));
                                $datetime1 = new DateTime($date1);
                                $datetime2 = new DateTime($date2);
                                $interval = $datetime1->diff($datetime2);
                                $time0 = (int) $interval->format('%y');
                                $time1 = (int) $interval->format('%m');
                                $time2 = (int) $interval->format('%a');
                                $time3 = (int) $interval->format('%h');
                                $time4 = (int) $interval->format('%i');
                                $time5 = (int) $interval->format('%s');
                                if ($time0 <= 0) {
                                    if ($time1 <= 0) {
                                        if ($time2 <= 0) {
                                            if ($time3 <= 0) {
                                                if ($time4 <= 0) {
                                                    $main_time = $interval->format('%s Second Ago');
                                                } else {
                                                    $main_time = $interval->format('%i Minute Ago');
                                                }
                                            } else {
                                                $main_time = $interval->format('%h Hour Ago');
                                            }
                                        } else {
                                            $main_time = $interval->format('%a Day Ago');
                                        }
                                    } else {
                                        $main_time = $interval->format('%m Month Ago');
                                    }
                                } else {
                                    $main_time = $interval->format('%y Year Ago');
                                }
                                ?>
                                <p><strong><?php echo $main_time ?></strong></p>
                            </div>
                            <div class="member_since">
                                <p><?php echo $this->lang->line('Member'); ?> <?php echo $this->lang->line('Since'); ?></p>
                                <p><strong><?php echo date("d M Y", strtotime($user_profile[0]['AuthorCreatedOn'])); ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div class="details_articles">
        <div class="container">
            <div class="cover_info">
                <div class="heading_article">
                    <h3><?php echo $this->lang->line('Articles'); ?></h3>
                    <p><?php echo $this->lang->line('Recent_activity'); ?> <?php echo $this->lang->line('by'); ?> <?php echo ucfirst($user_profile[0]['first_name']) . " " . ucfirst($user_profile[0]['last_name']); ?></p>           
                </div>
                <hr>
                <?php
                if (isset($user_profile) && count($user_profile) > 0) {
                    foreach ($user_profile as $row) {
                        ?>
                        <div class="all_detail">
                            <div class="text_icon">
                                <i class="fa fa-file-o"></i>
                            </div>
                            <div class="info_text">
                                <p class="mt-0 green-text"><a href="<?php echo base_url("articles/" . $row['slug']); ?>"><strong><?php echo ucfirst($row['title']); ?></strong></a></p>
                                <div class="description"><?php echo $this->general->add3dots(check_code($row['description']), "...", 200); ?></div>
                                <div>
                                    <ul class="inline-ul meta_group">
                                        <li class="meta-data">
                                            <?php
                                            $date1 = date('Y-m-d H:i:s');
                                            $date2 = date('Y-m-d H:i:s', strtotime($row['created_on']));
                                            $datetime1 = new DateTime($date1);
                                            $datetime2 = new DateTime($date2);
                                            $interval = $datetime1->diff($datetime2);
                                            $time0 = (int) $interval->format('%y');
                                            $time1 = (int) $interval->format('%m');
                                            $time2 = (int) $interval->format('%a');
                                            $time3 = (int) $interval->format('%h');
                                            $time4 = (int) $interval->format('%i');
                                            $time5 = (int) $interval->format('%s');
                                            if ($time0 <= 0) {
                                                if ($time1 <= 0) {
                                                    if ($time2 <= 0) {
                                                        if ($time3 <= 0) {
                                                            if ($time4 <= 0) {
                                                                $main_time = $interval->format('%s Second Ago');
                                                            } else {
                                                                $main_time = $interval->format('%i Minute Ago');
                                                            }
                                                        } else {
                                                            $main_time = $interval->format('%h Hour Ago');
                                                        }
                                                    } else {
                                                        $main_time = $interval->format('%a Day Ago');
                                                    }
                                                } else {
                                                    $main_time = $interval->format('%m Month Ago');
                                                }
                                            } else {
                                                $main_time = $interval->format('%y Year Ago');
                                            }
                                            ?>
                                            <span> <?php echo $main_time ?> </span>
                                        </li>
                                        <li class="meta-data">
                                            <span><i class="fa fa-comments-o" aria-hidden="true"></i>
                                                <?php echo count(get_comment($row['id'])); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr> 
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include APPPATH . '/modules/views/footer_front.php'; ?>
