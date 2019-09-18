<?php
include 'header.php';
$slug = $this->uri->segment(2);
$search = $this->input->get("search");
?>

<!--Banner Section-->
<div class="breadcrumb_banner">
    <div class="img-overlay">
        <div class="container">
            <div class="banner_content">
                <nav aria-label="breadcrumb" class="breadcrumb_grey">
                    <ol class="breadcrumb px-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('theme'); ?>"><?php echo $this->lang->line('Home'); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Group</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="white text_search">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <form id="search-form" class="search-form" method="get" action="#" autocomplete="off">
                    <input class="search-term" type="text" id="search" name="search" placeholder="Search..." title="* Please enter a search Article!" />
                    <a class="search-btn" type="submit" href=""><i class="fa fa-search"></i></a>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Banner Section-->

<div class="my-5">
    <div class="container">
        <div class="row">                        
            <div class="col-md-3 order-md-2">
                <div class="card">
                    <div class="p-3">
                        <div class="accordion sidebar_left" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <!-- Accordion card -->
                            <div role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h3 class="mb-0">
                                        <?php echo $this->lang->line('Groups'); ?>
                                        <i class="fa fa-angle-down float-right rotate-icon d-inline-block d-md-none"></i>
                                    </h3>
                                </a>

                                <!-- Card body -->
                                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordionEx" >
                                    <ul class="list-inline">
                                        <?php
//                                if (isset($total_group) && count($total_group) > 0) {
//                                    foreach ($total_group as $value) {
                                        ?>
                                        <li class="active <?php // echo isset($value['slug']) && $value['slug'] == $slug ? "active" : "";  ?>">
                                            <a href="<?php // echo base_url("groups/" . $value['slug']);                       ?>">
                                                <?php // echo ucfirst($value['title']); ?>
                                                CK Editor
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="">
                                                CK Editor
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="">
                                                CK Editor
                                            </a>
                                        </li>
                                        <?php
//                                }
//                                }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- Accordion card -->
                        </div>      
                    </div>
                </div>
            </div>
            <div class="col-md-9 order-md-1">
                <div class="card">
                    <div class="section-container">
                        <section class="section-content">
                            <div class="card">
                                <div class="card-body">
                                    <header class="K_header">
                                        <h1>
                                            <?php
//                                if (!empty($knowledge_group_details[0]['group_title']))
//                                    echo ucfirst($knowledge_group_details[0]['group_title']);
//                                else {
//                                    if (!empty($group_name['group_title']))
//                                        echo ucfirst($group_name['group_title']);
//                                }                            
                                            ?>
                                            Ck Editor
                                        </h1>
                                    </header>
                                    <div class="pl-0">
                                        <?php
//                            if (isset($knowledge_group_details) && count($knowledge_group_details) > 0) {
//                                foreach ($knowledge_group_details as $row) {
                                        ?>
                                        <ul class="list-inline">
                                            <li class="article_list_item">
                                                <a href="<?php echo base_url('articles/' . $row['slug']); ?>">
                                                    <spn>Block Quote <?php // echo ucfirst($row['title']);                    ?></spn>

                                                    <div class="recent-activity-item-meta">
                                                        <i class="fa fa-angle-right"></i>

                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <?php
//                                }
//                            } else {
                                        ?>
                                        <div class="col-md-12 d-none">
                                            <i class="fa fa-exclamation-triangle not_found_icon" aria-hidden="true"></i>
                                            <h4 class='no_record'> <?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('article'); ?> <?php echo $this->lang->line('found'); ?></h4>
                                        </div>
                                        <?php // } ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>