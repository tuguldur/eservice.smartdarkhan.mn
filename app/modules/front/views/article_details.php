<?php
include APPPATH . '/modules/views/header_front.php';
$slug = $this->uri->segment(2);
$article_id = (int) $article_id;
$group_id = (int) $group_id;

$search = $this->input->get("search");
$total_up_vote = isset($up_count) ? $up_count : 0;
$total_down_vote = isset($down_count) ? $down_count : 0;
$total_vote = $total_up_vote + $total_down_vote;
?>
<div>
    <div class="container">
        <div class="my-4">
            <div  class="breadcrumb_header_text">
                <a class="green_text" href="<?php echo base_url(); ?>"><b><?php echo $this->lang->line('Home'); ?></b></a>
                <span class="separator">/</span>
                <?php
                $breadcrumb_g = get_breadcrumb("app_article_groups", "id='$group_id'");
                $breadcrumb_a = get_breadcrumb("app_article", "id='$article_id'");

                $GroupName = ucfirst($breadcrumb_g['title']);
                $ArticleName = ucfirst($breadcrumb_a['title']);
                ?>
                <a class="current green_text" href="<?php echo base_url('groups/' . $breadcrumb_g['slug']); ?>"><span class="current-section"><?php echo $GroupName; ?></span></a>
                <span class="separator">/</span>
                <a class="current green_text" href="<?php echo base_url('articles/' . $slug); ?>"><span class="current-section"><?php echo $ArticleName; ?></span></a>
            </div>
        </div>  
        <hr>
        <div class="row article-container">
            <div class="col-md-2">
                <div class="accordion sidebar_left" id="accordionEx" role="tablist" aria-multiselectable="true">

                    <!-- Accordion card -->
                    <!-- Card header -->
                    <div role="tab" id="headingOne">
                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h3 class="mb-0">
                                <?php echo $this->lang->line('Articles'); ?><i class="fa fa-angle-down float-right rotate-icon d-inline-block d-md-none"></i>
                            </h3>
                        </a>

                        <!-- Card body -->
                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordionEx" >
                            <ul class="list-inline">
                                <?php foreach ($total_article as $value) { ?>
                                    <li class="<?php echo isset($article_id) && $value['id'] == $article_id ? "active" : ""; ?>">
                                        <a href="<?php echo base_url("articles/" . $value['slug']); ?>">
                                            <?php echo ucfirst($value['title']); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Accordion card -->

                </div>
            </div>
            <div class="col-md-10">
                <div class="fleft_side">
                    <article class="article">
                        <header class="K_header">
                            <h1><?php echo ucfirst($knowledge_article_details['title']); ?></h1>
                        </header>
                        <div class="my-3 user_info">
                            <div class="d-inline-block valign_bottom">
                                <?php
                                $root_dir = FCPATH . uploads_path . '/profiles/';
                                if (file_exists($root_dir . $knowledge_article_details['profile_image']) && $knowledge_article_details['profile_image'] != "") {
                                    $logo_image = base_url() . uploads_path . '/profiles/' . $knowledge_article_details['profile_image'];
                                } else {
                                    $logo_image = base_url() . img_path . "/user.png";
                                }
                                ?>
                                <a href="<?php echo base_url('user_profile/' . (int) $knowledge_article_details['created_by']); ?>">
                                    <img class="rounded-circle" src="<?php echo $logo_image; ?>" alt=""/>
                                </a>
                            </div>
                            <div class="d-inline-block">
                                <a href="<?php echo base_url('user_profile/' . (int) $knowledge_article_details['created_by']); ?>">
                                    <p><span><?php echo ucfirst($knowledge_article_details['first_name']) . " " . ucfirst($knowledge_article_details['last_name']); ?></span></p>
                                </a>
                                <?php
                                $date1 = date('Y-m-d H:i:s');
                                $date2 = date('Y-m-d H:i:s', strtotime($knowledge_article_details['created_on']));
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
                                <p><?php echo $main_time ?></p>
                            </div>
                        </div>

                        <div> 
                            <?php
                            if (isset($knowledge_article_details) && count($knowledge_article_details) > 0) {
                                ?>
                                <div id="description"><?php echo $knowledge_article_details['description']; ?></div>
                                <div class="description"><?php // echo str_replace("&lt;p&gt; &lt;/p&gt;","",html_entity_decode($knowledge_article_details['description']));  ?></div>
                            <?php } else {
                                ?>
                                <div class = "col-md-6">
                                    <h1>Search results</h1>
                                    <p class="no_record"><?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('results_for'); ?> "<?php echo $search; ?>"</p>
                                </div>
                            <?php } ?>
                        </div> 

                        <?php
                        $get_comment = get_comment($knowledge_article_details['id']);
                        ?>                        
                    </article>

                <hr>
                
                </div>
                <hr>
                <div class="row mb-5">
                    <div class="col-lg-12">                            
                        <!--Main wrapper-->
                        <div class="comments-list text-md-left">
                            <div class="">
                                <div class="section-heading text-left">
                                    <h3 class="m-0 p-3"><?php echo $this->lang->line('Comments'); ?>
                                        <span class="badge green"><?php echo count($get_comment) ?></span>
                                    </h3>
                                </div>
                                <hr class="p-0 m-0">
                                <div class="card-body">
                                    <?php
                                    if (isset($get_comment) && count($get_comment) > 0) {
                                        foreach ($get_comment as $c_val) {
                                            ?>
                                            <!--First row-->
                                            <div class="row" style="margin-bottom: 0.5rem;">
                                                <?php $get_comment_user = get_comment_user($c_val['user_type'], $c_val['customer_id']); ?>
                                                <!--Image column-->
                                                <div class="col-sm-2 col-3 resp_px-0">
                                                    <?php
                                                    $root_dir = FCPATH . uploads_path . '/profiles/';
                                                    if (file_exists($root_dir . $get_comment_user['profile_image']) && $get_comment_user['profile_image'] != "") {
                                                        $user_image = base_url() . uploads_path . '/profiles/' . $get_comment_user['profile_image'];
                                                    } else {
                                                        $user_image = base_url() . img_path . "/user.png";
                                                    }
                                                    ?>
                                                    <img src="<?php echo $user_image; ?>" alt="Profile Image">
                                                </div>
                                                <!--/.Image column-->
                                                <!--Content column-->
                                                <div class="col-sm-10 col-9">
                                                    <h3 class="user-name" style="font-size: 16px;"><?php echo ucfirst($get_comment_user['first_name']) . " " . ucfirst($get_comment_user['last_name']); ?>
                                                        <div class="card-data" style="background: white;text-align: left;padding-left: 0;">
                                                            <ul class="list-unstyled">
                                                                <li class="comment-date">
                                                                    <i class="fa fa-clock-o" style="margin-left: 0px;"></i>
                                                                    <?php
                                                                    $date1 = date('Y-m-d H:i:s');
                                                                    $date2 = date('Y-m-d H:i:s', strtotime($c_val['created_on']));

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
                                                                    <span style="font-size: 12px;"><?php echo $main_time ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </h3>
                                                    <p class="comment-text">
                                                        <?php echo $c_val['comment']; ?>
                                                    </p>
                                                    <?php
                                                    $get_sub_comment = get_sub_comment($c_val['id']);
                                                    if (isset($get_sub_comment) && $get_sub_comment > 0) {
                                                        foreach ($get_sub_comment as $s_c_val) {
                                                            ?>
                                                            <!-- Sub First row-->
                                                            <div class="row reply_ans">
                                                                <!--Image column-->
                                                                <?php
                                                                $get_sub_comment_user = get_comment_user($s_c_val['user_type'], $s_c_val['customer_id']);
                                                                $root_dir = FCPATH . uploads_path . '/profiles/';
                                                                if (file_exists($root_dir . $get_sub_comment_user['profile_image']) && $get_sub_comment_user['profile_image'] != "") {
                                                                    $sub_user_image = base_url() . uploads_path . '/profiles/' . $get_sub_comment_user['profile_image'];
                                                                } else {
                                                                    $sub_user_image = base_url() . img_path . "/user.png";
                                                                }
                                                                ?>
                                                                <div class="col-sm-2 col-4">
                                                                    <img src="<?php echo $sub_user_image; ?>" alt="Profile Image">
                                                                </div>
                                                                <!--/.Image column-->
                                                                <!--Content column-->
                                                                <div class="col-sm-10 col-8">
                                                                    <h3 class="user-name" style="font-size: 16px;"><?php echo ucfirst($get_sub_comment_user['first_name']) . " " . ucfirst($get_sub_comment_user['last_name']); ?>
                                                                        <div class="card-data" style="background: white;text-align: left;padding-left: 0;">
                                                                            <ul class="list-unstyled">
                                                                                <li class="comment-date">
                                                                                    <i class="fa fa-clock-o" style="margin-left: 0px;"></i>
                                                                                    <?php
                                                                                    $date1 = date('Y-m-d H:i:s');
                                                                                    $date2 = date('Y-m-d H:i:s', strtotime($s_c_val['created_on']));
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
                                                                                    <span style="font-size: 12px;"><?php echo $main_time ?></span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </h3>
                                                                    <p class="comment-text" style="font-size: 14px;">
                                                                        <?php echo $s_c_val['comment']; ?>
                                                                    </p>
                                                                </div>
                                                                <!--/.Content column-->
                                                            </div>
                                                            <!--/. Sub First row-->
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <!--/.Content column-->
                                            </div>
                                            <!--/.First row-->
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php if ($this->session->userdata('UserID')) { ?>
                                        <div class="row">
                                            <!--Image column-->
                                            <div class="col-sm-2 col-3 resp_px-0">
                                                <img src="<?php echo $ProfileImage; ?>" alt="Profile Image">
                                            </div>
                                            <!--/.Image column-->
                                            <div class="col-sm-10 col-9">
                                                <form method="post" action="<?php echo base_url('post-comment'); ?>">
                                                    <input type="hidden" name="artical_id" value="<?php echo $knowledge_article_details['id']; ?>"/>
                                                    <div class="form-group">
                                                        <label for="form8" class=""><?php echo $this->lang->line('Enter_Comment'); ?></label>
                                                        <textarea type="text" id="comment" name="comment" class="form-control" required=""></textarea>                                                        
                                                    </div>
                                                    <input type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Post"/>
                                                </form>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class=" my-4">
                                            <p><?php echo $this->lang->line('Please'); ?> <a style="color: #0066ff" href="<?php echo base_url('login'); ?>"><?php echo $this->lang->line('Log_In'); ?></a> <?php echo $this->lang->line('leave_comment'); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--/.Main wrapper-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include APPPATH . '/modules/views/footer_front.php';
?>