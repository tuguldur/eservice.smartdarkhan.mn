<?php
include APPPATH . '/modules/views/header_front.php';
?>
<div>
    <div class="row">
        <div class="col-md-12 grey lighten-4 my-0">
            <div class="container">   
                <div class="row">
                    <div class="col-md-8">
                        <div class="user_profile_bg w-100">               
                            <div class="my-5 resp_my-0">
                                <div class="form-inline">
                                    <div class="logo">
                                        <?php
                                        if (file_exists(FCPATH . uploads_path . "/profiles/" . $customer['profile_image']) && $customer['profile_image'] != '') {
                                            $img_src = base_url() . uploads_path . "/profiles/" . $customer['profile_image'];
                                        } else {
                                            $img_src = base_url() . img_path . "/user.png";
                                        }
                                        ?> 
                                        <img class="rounded-circle" src="<?php echo $img_src; ?>" alt="Image" width="60" height="50">
                                    </div>
                                    <div class="user_name">
                                        <h4><?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?></h4>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div class="total_activity">
                                        <p><?php echo $this->lang->line('Total'); ?> <?php echo $this->lang->line('Activity'); ?></p>
                                        <p><strong><?php echo isset($total_post) ? $total_post : 0; ?></strong></p>
                                    </div>
                                    <div class="last_activity">
                                        <p><?php echo $this->lang->line('Last'); ?> <?php echo $this->lang->line('Activity'); ?></p>
                                        <?php
                                        $date1 = date('Y-m-d H:i:s');
                                        $date2 = date('Y-m-d H:i:s', strtotime($last_activity));
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
                                        <p><strong><?php echo $main_time; ?></strong></p>
                                    </div>
                                    <div class="member_since">
                                        <p><?php echo $this->lang->line('Member'); ?> <?php echo $this->lang->line('Since'); ?></p>
                                        <p><strong><?php echo date("d M Y", strtotime($customer['created_on'])); ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4">
                        <ul class="profile-stats my-5 resp_my-0 list-inline">
                            <li class="stat">
                                <span class="stat-label"><?php echo $this->lang->line('Following'); ?></span>
                                <span class="stat-value"><?php echo $total_following; ?> <?php echo $this->lang->line('users'); ?></span>
                            </li>
                            <li class="stat">
                                <span class="stat-label"><?php echo $this->lang->line('Followed'); ?> <?php echo $this->lang->line('by'); ?></span>
                                <span class="stat-value"><?php echo $final_follwer; ?> <?php echo $this->lang->line('users'); ?></span>
                            </li>
                            <li class="stat">
                                <span class="stat-label"><?php echo $this->lang->line('Votes'); ?></span>
                                <span class="stat-value"><?php echo $final_vote; ?></span>
                            </li>
                            <li class="stat">
                                <span class="stat-label"><?php echo $this->lang->line('Subscriptions'); ?></span>
                                <span class="stat-value"><?php echo $final_follwer; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 grey lighten-3 pt-3 profile-nav mt-0">
            <div class="container">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="activity_overview-tab" data-toggle="pill" href="#activity_overview" role="tab" aria-controls="activity_overview" aria-selected="true"><?php echo $this->lang->line('Activity'); ?> <?php echo $this->lang->line('overview'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="posts-tab" data-toggle="pill" href="#posts" role="tab" aria-controls="posts" aria-selected="false"><?php echo $this->lang->line('Posts'); ?><span> (<?php echo count($all_post); ?>)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="comments-tab" data-toggle="pill" href="#comments" role="tab" aria-controls="comments" aria-selected="false"><?php echo $this->lang->line('Comments'); ?><span> (<?php echo count($all_comment); ?>)</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="activity_overview" role="tabpanel" aria-labelledby="activity_overview-tab">
            <div class="details_activity_overview">
                <div class="container">
                    <div class="cover_info">
                        <div class="heading_article">
                            <h3><?php echo $this->lang->line('Activity'); ?> <?php echo $this->lang->line('overview'); ?></h3>
                            <p><?php echo $this->lang->line('Latest'); ?> <?php echo $this->lang->line('activity'); ?> <?php echo $this->lang->line('by'); ?> <?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?></p>           
                        </div>
                        <?php if (isset($last_post) && count($last_post) > 0) { ?>
                            <ul class="profile-activity-list list-inline">
                                <?php foreach ($last_post as $key => $value) { ?>
                                    <li class="profile-activity profile-activity-created-post">
                                        <header class="profile-activity-header">
                                            <img class="user-avatar" src="<?php echo $img_src; ?>" alt="Avatar">
                                            <?php
                                            $date1 = date('Y-m-d H:i:s');
                                            $date2 = date('Y-m-d H:i:s', strtotime($value['created_on']));
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
                                            <p class="profile-activity-description"><span><?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?></span> <?php echo $this->lang->line('created'); ?> <?php echo $this->lang->line('post'); ?> , <?php echo $main_time; ?></p>
                                        </header>
                                        <div class="profile-activity-contribution profile-contribution">
                                            <header class="profile-contribution-header">
                                                <h3 class="profile-contribution-title"><a href="<?php echo base_url('community/posts/' . $value['slug']); ?>"><?php echo $value['title']; ?></a></h3>
                                            </header>
                                            <ol class="breadcrumbs profile-contribution-breadcrumbs">
                                                <li><a href="<?php echo base_url('community'); ?>"><?php echo $this->lang->line('Community'); ?></a></li>
                                                <li><a href="<?php echo base_url('community/topics/' . $value['topic_slug']); ?>"><?php echo $value['topic_title']; ?></a></li>
                                            </ol>
                                            <p class="profile-contribution-body"><?php echo $this->general->add3dots(check_code($value['description']), "...", 200); ?></p>
                                            <ul class="meta-group list-inline inline-ul">
                                                <li class="meta-data"><?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?></li>
                                                <li class="meta-data"><?php echo $main_time; ?></li>
                                                <li class="meta-data"><?php echo $value['total_follwer']; ?> <?php echo $this->lang->line('follower'); ?></li>
                                                <li class="meta-data"><?php echo $value['total_comment']; ?> <?php echo $this->lang->line('comments'); ?></li>
                                                <li class="meta-data"><?php echo $value['total_vote']; ?> <?php echo $this->lang->line('votes'); ?></li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>          
                        <?php } else { ?>
                            <div class="col-md-12 mt-5">
                                <p class="no_record"><?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('Record'); ?> <?php echo $this->lang->line('Found'); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>              
            </div>
        </div>
        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            <div class="details_articles">
                <div class="container">
                    <div class="cover_info">

                        <div class="heading_article">
                            <h3><?php echo $this->lang->line('Posts'); ?></h3>
                        </div> 
                        <hr>
                        <?php
                        if (isset($all_post) && count($all_post) > 0) {
                            foreach ($all_post as $key => $value) {
                                ?>
                                <div class="all_detail">
                                    <div class="text_icon">
                                        <i class="fa fa-sticky-note-o"></i>
                                    </div>
                                    <div class="info_text">
                                        <p class="mt-0">
                                            <a href="<?php echo base_url('community/posts/' . $value['slug']); ?>"><strong><?php echo $value['title']; ?></strong></a>
                                        </p>
                                        <ol class="breadcrumbs profile-contribution-breadcrumbs">
                                            <li><a href="<?php echo base_url('community'); ?>"><?php echo $this->lang->line('Community'); ?></a></li>
                                            <li><a href="<?php echo base_url('community/topics/' . $value['topic_slug']); ?>"><?php echo $value['topic_title']; ?></a></li>
                                        </ol>
                                        <div class="description">
                                            <?php echo $this->general->add3dots(check_code($value['description']), "...", 200); ?>
                                        </div>
                                        <div>
                                            <ul class="inline-ul meta_group pl-0">
                                                <li class="meta-data">
                                                    <span> <?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?> </span>
                                                </li>
                                                <li class="meta-data">
                                                    <?php
                                                    $date1 = date('Y-m-d H:i:s');
                                                    $date2 = date('Y-m-d H:i:s', strtotime($value['created_on']));
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
                                                    <span> <?php echo $main_time; ?> </span>
                                                </li>
                                                <li class="meta-data">
                                                    <span>
                                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                                        <?php echo $value['total_comment']; ?>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <hr> 
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-md-12 mt-5">
                                <p class="no_record"><?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('Record'); ?> <?php echo $this->lang->line('Found'); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>              
            </div>
        </div>
        <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
            <div class="details_articles">
                <div class="container">
                    <div class="cover_info">
                        <div class="heading_article">
                            <h3><?php echo $this->lang->line('Comments'); ?></h3>
                            <p><?php echo $this->lang->line('Recent'); ?> <?php echo $this->lang->line('activity'); ?> <?php echo $this->lang->line('by'); ?> <?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?></p>           
                        </div>
                        <hr>
                        <?php
                        if (isset($all_comment) && count($all_comment) > 0) {
                            foreach ($all_comment as $key => $value) {
                                ?>
                                <div class="all_detail">
                                    <div class="text_icon">
                                        <i class="fa fa-comment-o"></i>
                                    </div>
                                    <div class="info_text">
                                        <ol class="breadcrumbs profile-contribution-breadcrumbs">
                                            <li><a href="<?php echo base_url('community'); ?>"><?php echo $this->lang->line('Community'); ?></a></li>
                                            <li><a href="<?php echo base_url('community/topics/' . $value['topic_slug']); ?>"><?php echo $value['topic_title']; ?></a></li>
                                            <li><a href="<?php echo base_url('community/posts/' . $value['slug']); ?>"><?php echo $value['title']; ?></a></li>
                                        </ol>
                                        <div class="description"><div><span class="marker">Hello,</span></div>
                                            <p>&nbsp;</p>
                                        </div>
                                        <div>
                                            <ul class="inline-ul meta_group pl-0">
                                                <li class="meta-data">
                                                    <a href="<?php echo base_url('community/posts/' . $value['slug']); ?>"> <?php echo $this->lang->line('View'); ?> <?php echo $this->lang->line('comment'); ?> </a>
                                                </li>
                                                <li class="meta-data">
                                                    <span> <?php echo ucfirst($customer['first_name']) . " " . ucfirst($customer['last_name']); ?> </span>
                                                </li>
                                                <li class="meta-data">
                                                    <?php
                                                    $date1 = date('Y-m-d H:i:s');
                                                    $date2 = date('Y-m-d H:i:s', strtotime($value['created_on']));
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
                                                    <span> <?php echo $main_time; ?> </span>
                                                </li>
                                                <li class="meta-data">
                                                    <span>
                                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                                        <?php echo $value['total_comment']; ?>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <hr> 
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-md-12 mt-5">
                                <p class="no_record"><?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('Record'); ?> <?php echo $this->lang->line('Found'); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>
<?php include APPPATH . '/modules/views/footer_front.php'; ?>