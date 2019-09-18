function post_vote(e) {
    class_name = $(e).attr('class');
    voted = 'not';
    vote_add = '0';
    vote_class = "add"
    vote_name = "";
    if ($(e).parents("#vote-content").find(".vote-voted").length > '0') {
        voted = 'voted';
    }
    if (class_name == 'vote-up' || class_name == 'vote-up vote-voted') {
        vote_name = 'up';
        if (voted == 'voted' && class_name == 'vote-up vote-voted') {
            vote_add = "-1";
            vote_class = "remove";
        } else if (voted == 'voted' && class_name == 'vote-up') {
            vote_add = "+2";
            vote_class = "add";
        } else {
            vote_add = "+1";
            vote_class = "add";
        }
    } else {
        vote_name = 'down';
        if (voted == 'voted' && class_name == 'vote-down vote-voted') {
            vote_add = "+1";
            vote_class = "remove";
        } else if (voted == 'voted' && class_name == 'vote-down') {
            vote_add = "-2";
            vote_class = "add";
        } else {
            vote_add = "-1";
            vote_class = "add";
        }
    }
    var id = $(e).data("id");
    $.ajax({
        url: base_url + "post-vote/" + id,
        type: "post",
        data: {vote_add: vote_add, vote_class: vote_class, vote_name: vote_name, token_id: csrf_token_name},
        beforeSend: function () {
            $("#loadingmessage").show();
        },
        success: function (data) {
            $("#vote-content").html('');
            $("#vote-content").html(data);
            $("#loadingmessage").hide();
        }
    });
}
$("#CommentForm").validate({
    ignore: [],
    rules: {
        comment: {
            required: true
        }
    },
});
$("#CommentForm").submit(function () {
    if ($("#CommentForm").valid()) {
        $('.loadingmessage').show();
    }
});