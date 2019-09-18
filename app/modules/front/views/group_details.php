<?php
   include APPPATH . '/modules/views/header_front.php';
   $slug = $this->uri->segment(2);
   $search = $this->input->get("search");
   ?>
<div>
   <div class="container">
      <div class="my-4">
         <div class="row breadcrumb_header_text">
            <div class="col-md-5 mt-3 pt-1">
               <a class="green_text"  href="<?php echo base_url(); ?>"><?php echo $this->lang->line('Home'); ?></a>
               <span class="separator">/</span>
               <?php
                  ?>
               <a class="current green_text" href="<?php echo base_url('groups/' . $slug); ?>"><span class="current-section"><?php echo ucfirst($group_name); ?></span></a>
            </div>
            <div class="col-md-7 d-flex flex-r">
            <button type="button" class="btn btn-outline-primary btn-request mr-3" id="show-request">Хүсэлт</button>
            <button type="button" class="btn btn-outline-primary btn-request mr-3" id="show-halamj" style="display:none">ХӨДӨЛМӨР ХАЛАМЖ</button>
               <form class="search">
                  <input type="hidden" class="form-control" name="token" id="token" value="<?php echo $slug; ?>">
                  <input type="search" class="form-control" name="search" id="search" placeholder="<?php echo $this->lang->line('Search'); ?> <?php echo $this->lang->line('article'); ?> <?php echo $this->lang->line('title'); ?>" value="<?php echo isset($search) ? $search : ''; ?>">
               </form>
            </div>
         </div>
      </div>
      <hr>
      <div class="row mb-5" id="halamj">
         <div class="col-md-2">
            <div class="accordion sidebar_left" id="accordionEx" role="tablist" aria-multiselectable="true">
               <!-- Accordion card -->
               <!-- Card header -->
               <div role="tab" id="headingOne">
                  <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     <h3 class="mb-0">
                        АНГИЛАЛУУД
                        <i class="fa fa-angle-down float-right rotate-icon d-inline-block d-md-none"></i>
                     </h3>
                  </a>
                  <!-- Card body -->
                  <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordionEx" >
                     <ul class="list-inline">
                        <?php
                           if (isset($total_group) && count($total_group) > 0) {
                               foreach ($total_group as $value) {
                                   ?>
                        <li class="<?php echo isset($value['slug']) && $value['slug'] == $slug ? "active" : ""; ?>">
                           <a href="<?php echo base_url("groups/" . $value['slug']); ?>">
                           <?php echo ucfirst($value['title']); ?>
                           </a>  
                        </li>
                        <?php
                           }
                           }
                           ?>
                     </ul>
                  </div>
               </div>
               <!-- Accordion card -->
            </div>
         </div>
         <div class="col-md-10">
            <div class="section-container">
               <section class="section-content">
                  <header class="K_header">
                     <h1><?php
                        if (!empty($knowledge_group_details[0]['group_title']))
                            echo ucfirst($knowledge_group_details[0]['group_title']);
                        else {
                            if (!empty($group_name['group_title']))
                                echo ucfirst($group_name['group_title']);
                        }
                        ?></h1>
                  </header>
                  <div class="col-md-10" style="padding-left: 0;">
                     <?php
                        if (isset($knowledge_group_details) && count($knowledge_group_details) > 0) {
                            foreach ($knowledge_group_details as $row) {
                                ?>
                     <ul class="list-inline">
                        <li class="article_list_item">
                           <a href="<?php echo base_url('articles/' . $row['slug']); ?>"><?php echo ucfirst($row['title']); ?></a>
                           <div class="recent-activity-item-meta">
                              <a href="<?php echo base_url('article/' . $row['slug']); ?>">
                              <i class="fa fa-angle-right"></i>
                              </a>
                           </div>
                        </li>
                     </ul>
                     <?php
                        }
                        } else {
                        ?>
                     <div class = "col-md-12">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red; padding-top: 50px; font-size: 40px; text-align: center; width: 100%;" ></i>
                        <h4 class='no_record'> <?php echo $this->lang->line('No'); ?> <?php echo $this->lang->line('article'); ?> <?php echo $this->lang->line('found'); ?></h4>
                     </div>
                     <?php } ?>
                  </div>
               </section>
            </div>
         </div>
      </div>
      <!-- Хүсэлт -->
      <div class="row md-5" id="request" style="display:none">
         <div class="table-responsive">
            <table class="table mdl-data-table">
               <thead>
                  <tr>
                     <th class="text-center font-bold dark-grey-text">№</th>
                     <th class="text-center font-bold dark-grey-text">Нэр</th>
                     <th class="text-center font-bold dark-grey-text">text</th>
                     <th class="text-center font-bold dark-grey-text">Хугацаа</th>
                     <th class="text-center font-bold dark-grey-text">Төлөв</th>
                     <th class="text-center font-bold dark-grey-text">Огноо</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     if (isset($request_data) && count($request_data) > 0) {
                         $i = 1;
                         foreach ($request_data as $row) {
                             $unread_reply = (int) get_unread_requst_admin($row['id']);
                             ?>
                  <tr data-id="<?php echo (int) $row['id']; ?>" class="data-tr">
                     <td  class="text-center"><?php echo "#" . str_pad($row['id'], 4, "0", STR_PAD_LEFT); ?></td>
                     <td  class="text-center"><?php echo ucfirst($row['first_name']) . "&nbsp;" . ucfirst($row['last_name']); ?></td>
                     <td  class="text-center"><?php echo ucfirst($row['subject']); ?></td>
                     <?php
                        if ($row['request_priority'] == 'H') {
                            $priority = $this->lang->line('1 жил');
                            $priority_alert = "success";
                        } elseif ($row['request_priority'] == 'M') {
                            $priority = $this->lang->line('2 жил');
                            $priority_alert = "success";
                        } else {
                            $priority = $this->lang->line('3 жил');
                            $priority_alert = "success";
                        }
                        ?>
                     <td  class="text-center"><span class="alert alert-<?php echo $priority_alert; ?>"><?php echo $priority; ?></span></td>
                     <?php
                        if ($row['status'] == 'O') {
                            $status = $this->lang->line('Open');
                            $alert = "success";
                        } elseif ($row['status'] == 'P') {
                            $status = $this->lang->line('Pending');
                            $alert = "danger";
                        } else {
                            $status = $this->lang->line('Solved');
                            $alert = "info";
                        }
                        ?>
                     <td  class="text-center"><span class="alert alert-<?php echo $alert; ?>"><?php echo $status; ?></span></td>
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
</div>
</div>
<?php include APPPATH . '/modules/views/footer_front.php'; ?>