<?php
include APPPATH . '/modules/views/admin_header.php';
?>
<style>
    .select-wrapper span.caret {
        top: 18px;
        color: black;
    }
    .select-wrapper input.select-dropdown {
        color: black;
    }
</style>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-8 m-auto">
                        <?php $this->load->view('message'); ?>

                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold"> Үйлчилгээний ажилтан</h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                echo form_open('assign-action', array('name' => 'assign_form', 'id' => 'assign_form'));
                                ?>
                                <div class="md-form">
                                    <p class="grey-text">Зөвшөөрлийн хүсэлт сонгох <small class="required">*</small></p>
                                    <?php
                                    $options[''] = $this->lang->line('Хүсэлт') . ' ' . $this->lang->line('Сонгох');
                                    if (isset($request_data) && !empty($request_data)) {
                                        foreach ($request_data as $row) {
                                            $options[$row['id']] = $row['subject'];
                                        }
                                    }
                                    $attributes = array('class' => 'kb-select initialized', 'id' => 'request', 'onchange' => 'get_agent_list(this)');
                                    echo form_dropdown('request', $options, "", $attributes);
                                    echo form_error('request');
                                    ?>
                                </div>
                                <div id="group_validate"></div>
                                <div class="md-form">
                                    <p class="grey-text">Үйлчилгээний ажилтан сонгох <small class="required">*</small></p>
                                    <?php
                                    $agent_options[''] = $this->lang->line('Ажилтан') . ' ' . $this->lang->line('Сонгох');
                                    $agent_attri = array('class' => 'kb-select initialized', 'id' => 'agent', "multiple" => '');
                                    echo form_dropdown('agent[]', $agent_options, "", $agent_attri);
                                    echo form_error('agent');
                                    ?>
                                </div>
                                <div id="group_validate"></div>
                                <div class="md-form">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;">Хадгалах</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!--/Form with header-->
                        </div>
                        <!--Card-->
                    </div>
                    <!-- End Col -->
                </div>
                <!--Row-->
            </section>
            <!-- End Login-->
        </div>
    </div>
</div>
<script>
    function get_agent_list(e) {
        var id = $(e).val();
        var url = base_url + "admin_request/get_agent"
        if (id) {
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id},
                beforeSend: function () {
                    $('#loadingmessage').show();
                },
                success: function (html) {
                    $('#loadingmessage').hide();
                    $('#agent').html(html).material_select();
                }
            });
        } else {
            $('#city').html('<option value="" disabled selected><?php echo $this->lang->line('Select') . " " . $this->lang->line('Request') . " " . $this->lang->line('First'); ?></option>');
        }
    }
    $(document).ready(function () {
        $("#assign_form").validate({
            ignore: [],
            rules: {
                request: {
                    required: true
                },
                'agent[]': {
                    required: true
                },
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.appendTo(element.parents(".md-form"));
            },
        });
    });
</script>
<?php include APPPATH . '/modules/views/admin_footer.php'; ?>
