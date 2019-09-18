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
                        <div class="header bg-color-base">
                            <div class="d-flex">
                                <span>
                                    <h3 class="white-text font-bold pt-3"><?php echo $this->lang->line('Manage'); ?> <?php echo $this->lang->line('Activity'); ?></h3>
                                </span>  
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 grey lighten-3 pt-3 profile-nav mt-0">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="activity_overview-tab" data-toggle="pill" href="#activity_overview" role="tab" aria-controls="activity_overview" aria-selected="true"><?php echo $this->lang->line('Articles'); ?> <?php echo $this->lang->line('Comments'); ?><span> (<?php echo count($article_comment); ?>)</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="posts-tab" data-toggle="pill" href="#posts" role="tab" aria-controls="posts" aria-selected="false"><?php echo $this->lang->line('Posts'); ?> <?php echo $this->lang->line('Comments'); ?><span> (<?php echo count($post_comment); ?>)</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <!--col-md-12-->
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="activity_overview" role="tabpanel" aria-labelledby="activity_overview-tab">
                                        <div class="details_activity_overview">
                                            <div class="cover_info w-100">
                                                <div class="table-responsive">
                                                    <table class="table mdl-data-table" id="example">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center font-bold dark-grey-text">#</th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Article'); ?> <?php echo $this->lang->line('Title'); ?></th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Comments'); ?></th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Created'); ?> <?php echo $this->lang->line('Date'); ?></th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Action'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            if (isset($article_comment) && count($article_comment) > 0) {
                                                                foreach ($article_comment as $row) {
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $i; ?></td>
                                                                        <td class="text-center"><?php echo $row['title']; ?></td>
                                                                        <td class="text-center"><?php echo $row['comment']; ?></td>
                                                                        <td class="text-center"><?php echo date("m/d/Y", strtotime($row['created_on'])); ?></td>
                                                                        <td class="td-actions text-center">
                                                                            <a href="<?php echo base_url('articles/' . $row['slug']); ?>" class="btn-danger btn-floating btn-sm blue-gradient" title="<?php echo $this->lang->line('View'); ?>"><i class="fa fa-eye"></i></a>
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
                                    <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                        <div class="details_articles">
                                            <div class="cover_info w-100">
                                                <div class="table-responsive">
                                                    <table class="table mdl-data-table" id="example2">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center font-bold dark-grey-text">#</th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Post'); ?> <?php echo $this->lang->line('Title'); ?></th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Comments'); ?></th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Created'); ?> <?php echo $this->lang->line('Date'); ?></th>
                                                                <th class="text-center font-bold dark-grey-text"><?php echo $this->lang->line('Action'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            if (isset($post_comment) && count($post_comment) > 0) {
                                                                foreach ($post_comment as $row) {
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $i; ?></td>
                                                                        <td class="text-center"><?php echo $row['title']; ?></td>
                                                                        <td class="text-center"><?php echo $row['comment']; ?></td>
                                                                        <td class="text-center"><?php echo date("m/d/Y", strtotime($row['created_on'])); ?></td>
                                                                        <td class="td-actions text-center">
                                                                            <a href="<?php echo base_url('community/posts/' . $row['slug']); ?>" class="btn-danger btn-floating btn-sm blue-gradient" title="<?php echo $this->lang->line('View'); ?>"><i class="fa fa-eye"></i></a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<script>
    function replay_redirect(e) {
        var id = $(e).data("id");
        window.location.href = base_url + "submit-request-reply/" + id;
    }
    $(document).ready(function () {
        $('#example2').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    className: 'mdl-data-table__cell--non-numeric'
                }
            ]
        });
    });
</script>
<?php include APPPATH . '/modules/views/footer.php'; ?>