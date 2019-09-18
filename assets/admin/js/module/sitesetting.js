$(document).ready(function () {
    $("#site_form").submit(function (e) {
        if ($("#site_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    $("#site_email_form").validate({
        ignore: [],
        rules: {
            smtp_host: {
                required: true
            },
            smtp_password: {
                required: true
            },
            smtp_secure: {
                required: true
            },
            smtp_port: {
                required: true,
                number: true
            },
            smtp_username: {
                required: true
            },
            email_from_name: {
                required: true
            }
        },
    });
    $("#site_email_form").submit(function (e) {
        if ($("#site_email_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
});
// Profile Image On Click Function 
function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    //alert(image);
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// Steppers                
$(document).ready(function () {
    var navListItems = $('div.setup-panel-2 div a'),
            allWells = $('.setup-content-2'),
            allNextBtn = $('.nextBtn-2'),
            allPrevBtn = $('.prevBtn-2');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
            $item.addClass('btn-amber');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function () {
        var curStep = $(this).closest(".setup-content-2"),
                curStepBtn = curStep.attr("id"),
                prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        prevStepSteps.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content-2"),
                curStepBtn = curStep.attr("id"),
                nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'],input[type='email'],input[type='file'], textarea ,select"),
                isValid = true;
            
        var form = $("#site_form");
        form.validate({
            ignore: [],
            rules: {
                company_name: {
                    required: true
                },
                company_email1: {
                    required: true,
                    email: true
                },
                home_page: {
                    required: true
                },
                Pro_img: {
                    extension: "png|jpeg|jpg",
                },
                banner_img: {
                    extension: "png|jpeg|jpg",
                }
            },
            messages: {
                company_name: {
                    required: "Please Enter Company name"
                },
                company_email1: {
                    required: "Please enter email ",
                    email: "Please enter valid email "
                },
                home_page: {
                    required: "Please select home page ",
                },
                Pro_img: {
                    extension: "File must be JPEG or PNG "
                },
                banner_img: {
                    extension: "File must be JPEG or PNG "
                }

            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                element.parents(".form-group").append(error);
            }
        });
        if(!curInputs.valid()){
            return false;
        }
        if (isValid)
            nextStepSteps.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel-2 div a.btn-amber').trigger('click');
});  