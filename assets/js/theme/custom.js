//Select Option
$(document).ready(function () {
    if ($('.kb-select').length > 0) {
        $('.kb-select').material_select();
    }
//    $('#accordion').on('shown.bs.collapse', function (e) {
//        console.log("sdsd"+$(this).attr("class"));
//    });
    $(".card").on("shown.bs.collapse hide.bs.collapse", function (e) {
        if (e.type == 'shown') {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });
});

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

//    Loader
    $('.loader').fadeOut();
});

//Fixed Side Bar
$(window).on("scroll", function () {

    if ($(window).scrollTop() >= 350) {
        $(".list_box").addClass("fixed-nav");
    } else {
        $(".list_box").removeClass("fixed-nav");
    }
});

