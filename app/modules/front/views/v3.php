<?php
include APPPATH . '/modules/views/header_front.php';
?>
<div class="home-v3">
    <div class="banner-img">
        <div class="banner_search">
            <h1><?php echo $this->lang->line('Create_base'); ?></h1>
            <p><?php echo $this->lang->line('Base_description'); ?></p>
            <form class="search text-center mb-3">
                <input type="search" class="w-50 h-50px resp_w-90" name="search" id="search faq_title" placeholder="<?php echo $this->lang->line('Search'); ?>" value="<?php echo isset($search) ? $search : ''; ?>">
            </form>
        </div>
    </div>
</div>

<div class="home-v2-main home-v3-main">
    <div class="container">
        <!--FAGs Section-->
        <section class="section">
            <div class="service_kbse">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <a href="<?php echo base_url('chatbot'); ?>">
                            <div class="icon_img mb-4">
                                <img src="<?php echo base_url() . img_path; ?>/home1/about/1.png" class="img-fluid" alt="faqs img"/>
                            </div>
                            <h5>УХААЛАГ ЧАТ БОТ</h5>
                            <p>ЭНД ЯМАР НЭГЭН ТАЙЛБАР БАЙРШИНА ТЭГЭЭД БОЛООДОО ДАХИАД ЖООХОН ҮГ</p>
                        </a>
                    </div>

                    <div class="col-md-4 text-center">
                        <a href="<?php echo base_url(''); ?>">
                            <div class="icon_img mb-4">
                                <img src="<?php echo base_url() . img_path; ?>/home1/about/2.png" class="img-fluid" alt="faqs img"/>
                            </div>
                            <h5>ХЯЛБАР СИСТЕМ</h5>
                            <p>ЭНД ЯМАР НЭГЭН ТАЙЛБАР БАЙРШИНА ТЭГЭЭД БОЛООДОО ДАХИАД ЖООХОН ҮГ</p>
                        </a>
                    </div>

                    <div class="col-md-4 text-center">
                        <a href="<?php echo base_url('community'); ?>">
                            <div class="icon_img mb-4">
                                <img src="<?php echo base_url() . img_path; ?>/home1/about/3.png" class="img-fluid" alt="faqs img"/>
                            </div>
                            <h5>ЦАХИМ ЗӨВШӨӨРӨЛ</h5>
                            <p><p>ЭНД ЯМАР НЭГЭН ТАЙЛБАР БАЙРШИНА ТЭГЭЭД БОЛООДОО ДАХИАД ЖООХОН ҮГ</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>      
    </div>
    <?php if (empty($search)) { ?>
        <div class="section-container">
            <section id="categories" class="service_kbse section-categories">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 m-auto text-center">
                            <h2>ҮЙЧИЛГЭЭНИЙ ТӨРӨЛҮҮД</h2>
                            <h4 class="service-text">ЭНД ЯМАР НЭГЭН ТАЙЛБАР БАЙРШИНА ТЭГЭЭД БОЛООДОО ДАХИАД ЖООХОН ҮГ</h4>
                        </div>
                    </div>
                    <?php
                    if (isset($knowledge_group_name) && !empty($knowledge_group_name)) {
                        $ci = 0;

                        foreach ($knowledge_group_name as $row) {
                            if ($ci % 4 == 0) {
                                echo '<div class="row">';
                            }
                            ?>
                            <div class="col-md-3">
                                <ul class="list-inline text-center">
                                    <li class="v3-group-title facts_info_wrap">
                                        <a href="<?php echo base_url('groups/' . $row['slug']); ?>" class="v3-group-anchor">
                                            <i class="fa <?php echo $row['group_icon']; ?>"> </i>
                                            <h4><?php echo ucfirst($row['title']); ?></h4>
                                            <span>(<?php echo $row['tot_article']; ?>)</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            $ci++;
                            if ($ci % 4 == 0) {
                                echo '</div>';
                            } elseif (count($knowledge_group_name) == $ci) {
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </div>
            </section>
        </div>
    <?php } ?>
    <div class="container">
        <div class="row mb-5">
            <?php if (empty($search)) { ?>
                <div class="col-md-6">
                    <section class="mt-5">
                        <div class="popular-activity">
                            <h2 class="sidenav-title recent-header"><u><?php echo $this->lang->line('Popular_activity'); ?></u></h2>
                        </div>
                        <div class="row"> 
                            <?php
                            if (isset($popular_activity) && !empty($popular_activity)) {
                                foreach ($popular_activity as $value) {
                                    ?>
                                    <div class="col-md-12">
                                        <ul class="recent-activity-list">
                                            <li class="recent-activity-item">
                                                <a class="recent-activity-item-link" href="<?php echo base_url('articles/' . $value['slug']); ?>"><?php echo ucfirst($value['title']); ?></a>
                                                <div class="recent-activity-item-meta">
                                                    <a class="recent-activity-item-link" href="<?php echo base_url('articles/' . $value['slug']); ?>">
                                                        <i class="fa fa-angle-right"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </section>
                </div>
            <?php } ?>
            <div class="col-md-6">
                <section class="mt-5">
                    <?php if (empty($search) && count($knowledge_recent_activity) > 0) { ?>
                        <div id="ajax_id3" class="recent-activity">
                            <h2 class="sidenav-title recent-header "><u><?php echo $this->lang->line('Recent_activity'); ?></u></h2>
                        </div>
                    <?php } else if (count($knowledge_recent_activity) > 0) { ?>
                        <div class="row"> 
                            <div class="col-md-6">
                                <h1 id="faq_title"><?php echo $this->lang->line('Search_results'); ?></h1>
                                <p class="page-header-description"><?php echo count($knowledge_recent_activity); ?> <?php echo $this->lang->line('results_for'); ?> "<?php echo $search; ?>"</p>
                            </div>
                        </div>
                    <?php } ?>
                    <div id="ajax_data" class="row"> </div>
                    <div id="ajax_id" class="row"> 
                        <?php
                        if (isset($knowledge_recent_activity) && count($knowledge_recent_activity) > 0) {
                            foreach ($knowledge_recent_activity as $row) {
                                ?>
                                <div class="col-md-12">
                                    <ul class="recent-activity-list">
                                        <li class="recent-activity-item">
                                            <a class="recent-activity-item-link" href="<?php echo base_url('articles/' . $row['slug']); ?>"><?php echo ucfirst($row['title']); ?></a>
                                            <div class="recent-activity-item-meta">
                                                <a  class="recent-activity-item-link"  href="<?php echo base_url('articles/' . $row['slug']); ?>">
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            }
                        } else {
                            $empty_search_records = 1;
                        }
                        ?>
                </section>
            </div>
            <?php if (isset($empty_search_records) && $empty_search_records == 1) { ?>
                <div class="col-md-12">
                    <p class="no_record"><?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('Record'); ?> <?php echo $this->lang->line('Found'); ?></p>
                </div>
            <?php } ?>
        </div>
        <p class="mt-5 resp_b-3 all_article text-center">
            <a href="submit_request" class="btn btn-pink" type="button"><?php echo $this->lang->line('Contact_Support'); ?></a>
        </p>
    </div>
</div>
<?php include APPPATH . '/modules/views/footer_front.php'; ?>