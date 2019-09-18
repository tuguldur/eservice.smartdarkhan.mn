
$(document).ready(function () {
    $("#chat_form").validate({
        ignore: [],
        rules: {
            message: {
                required: true,
            },
        },
        messages: {
            message: {
                required: "Please enter your message"
            },
        },
    });

    $("#chat_form").submit(function (e) {
        if ($("#chat_form").valid()) {
            $("#loadingmessage ").show();
        } else {
            e.preventDefault();
        }
    });
});
