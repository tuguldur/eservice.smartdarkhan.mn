$(document).ready(function () {
    if ($("#description").length) {
        jQuery.validator.addMethod("ckeditor_required", function (value, element) {
            var editorId = $(element).attr('id');
            var messageLength = CKEDITOR.instances[editorId].getData().replace(/<[^>]*>/gi, '').length;
            if (messageLength > 0) {
                return true;
            } else {
                return false;
            }
        }, "This field is required.");
        
        $("#post_form").validate({
            ignore: [],
            rules: {
                topic: {
                    required: true,
                },
                description: {
                    ckeditor_required: true,
                },
                title: {
                    required: true,
                    remote: {
                        url: site_url + "check-post-title",
                        type: "post",
                        data: {
                            topic: function () {
                                return $("#topic").val();
                            },
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
                post_status: {
                    required: true,
                },
            },
            messages: {
                title: {
                    remote: "Title is already existing this topic."
                }
            },
        });
    }
    /// grid view hide ///
//    $('#mygridtablerecord').hide();

    $("#topic_form").submit(function (e) {
        if ($("#post_form").valid()) {
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
            url: site_url + "delete-post/" + id,
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

//grid to table  toggle
//function toggle_data(element) {
//    var id = $(element).attr('id');
//    if (id == 1) {
//        $('#mygridrecord').hide();
//        $('#mygridtablerecord').show();
//        $(element).attr("id", "0");
//    } else {
//        $('#mygridtablerecord').hide();
//        $('#mygridrecord').show();
//        $(element).attr("id", "1");
//    }
//
//}


//$('#RecordDelete').on('click', function () {
//    var id = $("#record_id").val();
//    $.ajax({
//        url: site_url + "delete-knowledge-article/" + id,
//        type: "post",
//        data: {token_id: csrf_token_name},
//        beforeSend: function () {
//            $("body").preloader({
//                percent: 10,
//                duration: 15000
//            });
//        },
//        success: function (data) {
//            window.location.href = site_url + "manage-article";
//        }, error: function (data) {
//            window.location.href = site_url + "manage-article";
//        }
//    });
//});