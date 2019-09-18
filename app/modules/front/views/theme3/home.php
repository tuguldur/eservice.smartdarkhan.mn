<?php include 'header.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>theme/parallax.min.js"  type="text/javascript"></script>
<!--Banner Section-->
<div class="home_banner" data-parallax="scroll" data-image-src="<?php echo base_url() . img_path ?>/theme/banner.jpg">
    <div class="img-overlay">
        <div class="container">
            <div class="banner_content">
                <h1><?php echo $this->lang->line('Create_base'); ?></h1>
                <p><?php echo $this->lang->line('Base_description'); ?></p>

                <div class="div col-md-8 m-auto">
                    <form id="search-form" class="search-form" method="get" action="#" autocomplete="off">
                        <input class="search-term" type="text" id="search" name="search" placeholder="Search..."/>
                        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
<!--End Banner Section-->

<!--Main Content-->
<div class="my-5">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="<?php echo base_url('faqs'); ?>" class="outline-none service_block">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <div class="icon_img">
                                    <i class="fa fa-question-circle"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-9">
                                <div class="more_info">
                                    <h5><?php echo $this->lang->line('Recent_faq'); ?></h5>
                                    <p><?php echo $this->lang->line('Recent_faq_description'); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url(''); ?>" class="outline-none service_block">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <div class="icon_img">
                                    <i class="fa fa-comments-o"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-9">
                                <div class="more_info">
                                    <h5><?php echo $this->lang->line('Account'); ?> <?php echo $this->lang->line('Settings'); ?></h5>
                                    <p><?php echo $this->lang->line('Account_description'); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url('community'); ?>" class="outline-none service_block">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <div class="icon_img">
                                    <i class="fa fa-book"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-9">
                                <div class="more_info">
                                    <h5><?php echo $this->lang->line('Community_Forum'); ?></h5>
                                    <p><?php echo $this->lang->line('Community_Forum_description'); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 grey lighten-4 article-box">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto text-center">
                    <h1>Latest articles</h1>
                    <div class="border_top"></div>
                    <div class="border_center"></div>
                    <div class="border_bottom"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="background: url('<?php echo base_url() . img_path; ?>/theme/home-slide-1.jpg');background-size: 100% 100%;">
                        <div class="card-body">
                            <a href="<?php echo base_url('Theme/theme_group'); ?>" class="outline-none">
                                <span class="badge blue">Ck Editor</span>
                            </a>
                            <div class="article_info">
                                <h5>TEST Client</h5>
                                <p class="sort_description">
                                    This plugin allows inserting Youtube videos using embed code or just the video URL.
                                    Responsive youtube embed <a class=" white-text" href="<?php echo base_url('Theme/theme_articles'); ?>"><i class="fa fa-long-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo base_url('Theme/theme_group'); ?>" class="outline-none">
                                <span class="badge green">Ck Editor</span>
                            </a>
                            <div class="article_info">
                                <h5 class="black-text">TEST Client</h5>
                                <p class="sort_description black-text">
                                    This plugin allows inserting Youtube videos using embed code or just the video URL.
                                    Responsive youtube embed <a href="<?php echo base_url('Theme/theme_articles'); ?>"><i class="fa fa-long-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo base_url('Theme/theme_group'); ?>" class="outline-none">
                                <span class="badge purple">Ck Editor</span>
                            </a>
                            <div class="article_info">
                                <h5 class="black-text">TEST Client</h5>
                                <p class="sort_description black-text">
                                    This plugin allows inserting Youtube videos using embed code or just the video URL.
                                    Responsive youtube embed <a href="<?php echo base_url('Theme/theme_articles'); ?>"><i class="fa fa-long-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo base_url('Theme/theme_group'); ?>" class="outline-none">
                                <span class="badge yellow darken-4">Ck Editor</span>
                            </a>
                            <div class="article_info">
                                <h5 class="black-text">TEST Client</h5>
                                <p class="sort_description black-text">
                                    This plugin allows inserting Youtube videos using embed code or just the video URL.
                                    Responsive youtube embed <a href="<?php echo base_url('Theme/theme_articles'); ?>"><i class="fa fa-long-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="background: url('<?php echo base_url() . img_path; ?>/theme/home-slide-1.jpg');background-size: 100% 100%;">
                        <div class="card-body">
                            <a href="<?php echo base_url('Theme/theme_group'); ?>" class="outline-none">
                                <span class="badge red">Ck Editor</span>
                            </a>
                            <div class="article_info">
                                <h5>TEST Client</h5>
                                <p class="sort_description">
                                    This plugin allows inserting Youtube videos using embed code or just the video URL.
                                    Responsive youtube embed <a class="white-text" href="<?php echo base_url('Theme/theme_articles'); ?>"><i class="fa fa-long-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo base_url('Theme/theme_group'); ?>" class="outline-none">
                                <span class="badge pink">Ck Editor</span>
                            </a>
                            <div class="article_info">
                                <h5 class="black-text">TEST Client</h5>
                                <p class="sort_description black-text">
                                    This plugin allows inserting Youtube videos using embed code or just the video URL.
                                    Responsive youtube embed <a href="<?php echo base_url('Theme/theme_articles'); ?>"><i class="fa fa-long-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a class="btn red darken-1" href="<?php echo base_url('theme_articles'); ?>">View More</a>
                </div>
            </div>
        </div>
    </section>

    <section class="my-5 faqs_section">
        <div class="container">           
            <div class="row">
                <div class="col-md-8 m-auto text-center">
                    <h1>Top FAQs</h1>
                    <div class="border_top"></div>
                    <div class="border_center"></div>
                    <div class="border_bottom"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card hoverable">
                        <div class="card-body">
                            <div class="faqs_list">
                                <h4>How do I buy?</h4>
                                <p>Please purchase from CodeCanyon. Thanks</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card hoverable">
                        <div class="card-body">
                            <div class="faqs_list">
                                <h4>What version of PHP is required?</h4>
                                <p>PHP 5.4+ is required. Works with PHP 7+ too.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card hoverable">
                        <div class="card-body">
                            <div class="faqs_list">
                                <h4>Is this a PHP Script?</h4>
                                <p>Yes, it is based on the CodeIgniter Framework.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card hoverable">
                        <div class="card-body">
                            <div class="faqs_list">
                                <h4>How much does this software cost?</h4>                                
                                <p>As of 2018, it costs $34.00 USD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a class="btn red darken-1" href="<?php echo base_url('theme_faqs'); ?>">View More</a>
                </div>
            </div>
        </div>
    </section>
</div>
<!--End Main Content-->
<?php include 'footer.php'; ?>