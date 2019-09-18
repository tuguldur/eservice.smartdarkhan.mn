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
        $("#PostForm").validate({
            ignore: [],
            rules: {
                description: {
                    ckeditor_required: true
                },
                title: {
                    required: true
                },
                topic_id: {
                    required: true
                }
            }
        });
    }
    /// grid view hide ///
    $('#mygridtablerecord').hide();

    $("#PostForm").submit(function (e) {
        if ($("#PostForm").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });


});
function check_post(t) {
    $.ajax({
        url: base_url + "front/get_post",
        type: "post",
        data: {t: t, token_id: csrf_token_name},
        beforeSend: function () {
            $("#loadingmessage").show();
        },
        success: function (data) {
            if (data != false) {
                $("#feature_request").find('#request_content').html(data);
                $("#feature_request").show();
            }else{
                $("#feature_request").find('#request_content').html('');;
                $("#feature_request").hide();
            }
            $("#loadingmessage").hide();
        }
    });
}