
$(document).ready(function () {
    $("#submit_request").validate({
        ignore: [],
        rules: {
            subject: {
                required: true,
            },
            description: {
                required: true,
            },
            request_priority: {
                required: true,
            },
            category_id: {
                required: true,
            }
        },
    });

    $("#submit_request").submit(function (e) {
        if ($("#submit_request").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
});
function check_article(s) {
    $.ajax({
        url: base_url + "front/get_request_article",
        type: "post",
        data: {s: s, token_id: csrf_token_name},
        beforeSend: function () {
            $("#loadingmessage").show();
        },
        success: function (data) {
            if (data != false) {
                $("#feature_request").find('#request_content').html(data);
                $("#feature_request").show();
            } else {
                $("#feature_request").find('#request_content').html('');
                ;
                $("#feature_request").hide();
            }
            $("#loadingmessage").hide();
        }
    });
}