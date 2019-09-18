
$(document).ready(function () {
    if ($("#description").length > '0') {
        jQuery.validator.addMethod("ckeditor_required", function (value, element) {
            var editorId = $(element).attr('id');
            var messageLength = CKEDITOR.instances[editorId].getData().replace(/<[^>]*>/gi, '').length;
            if (messageLength > 0) {
                return true;
            } else {
                return false;
            }
        }, "This field is required.");
        
        $("#topic_form").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                    remote: {
                        url: site_url + "check-topic-title",
                        type: "post",
                        data: {
                            title: function () {
                                return $("#title").val();
                            },
                            id: function () {
                                return $("#id").val();
                            }
                        }
                    }
                },
                seo_description: {
                    required: true,
                },
                seo_keyword: {
                    required: true,
                },
                description: {
                    ckeditor_required: true,
                },
            },
            messages: {
                title: {
                    remote: "Title is already existing."
                }
            },
        });
    }
    
    $("#topic_form").submit(function (e) {
        if ($("#topic_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "delete-topic/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (data) {
                if (data == true) {
                    window.location.reload();
                } else {
                    window.location.reload();
                }
            }
        });
    });

});


function DeleteRecord(element) {
    var id = $(element).attr('data-id');
    var title = $(element).attr('title');
    $("#some_name").html(title);
    $("#confirm_msg").html("Are you sure you want to delete this record?");
    $("#record_id").val(id);
}