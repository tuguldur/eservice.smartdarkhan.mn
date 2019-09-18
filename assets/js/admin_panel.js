$(document).ready(function () {
// SideNav Initialization
    $(".button-collapse").sideNav();

    var container = document.getElementById('slide-out');
// Data Picker Initialization
    $('.datepicker').pickadate();

// Material Select Initialization
    $(document).ready(function () {
        $('.kb-select').material_select();
    });
});

//Animate 
new WOW().init();

function article_help(element, val) {
    var a_id = $(element).attr("data-id");
    var c_id = $(element).attr("data-c-id");
//    if (c_id == 0) {
//        $("#myModal").find(".modal-header h4").html("Article Helpful");
//        $("#myModal").find("#confirm_msg").html("Please login for submit your vote");
//        $("#myModal").modal("show");
//    } else {
        $.ajax({
            url: base_url + "add-article-helpful",
            type: "post",
            data: {a_id: a_id, value: val, token_id: csrf_token_name},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (responseJSON) {
                $(".article-votes").find("button").removeClass("help_active");
                $("body .preloader").hide();
                var response = JSON.parse(responseJSON);
                $(element).addClass("help_active");
                var tot_vote = parseInt(response.up_count) + parseInt(response.down_count);
                $("#vote_count").html(response.up_count+" out of "+tot_vote+" found this helpful");
            }
        });
//    }

}

//Back To Top
    $(document).ready(function () {
        $("#back-top").hide();
        /* Back to Top */
        $(window).scroll(function () {
            if ($(this).scrollTop()) {
                $('#toTop').removeClass(' lightSpeedOut');
                $('#toTop').addClass(' lightSpeedIn');
                $('#toTop').fadeIn();
            } else {
                $('#toTop').removeClass(' lightSpeedIn');
                $('#toTop').addClass(' lightSpeedOut');
                $('#toTop').delay(500).fadeOut();
            }
        });
        $("#toTop").click(function () {
            $("html, body").animate({scrollTop: 0}, 900);
        });
    });