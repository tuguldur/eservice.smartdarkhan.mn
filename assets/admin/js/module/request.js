
$(document).ready(function () {
    $("#submit_request").validate({
        rules: {
            subject: {
                required: true,
            }, description: {
                required: true,
            },
        },
        messages: {
            subject: {
                required: "Please enter your subject"
            }, description: {
                required: "Please enter your description"
            },
        },
    });

});
