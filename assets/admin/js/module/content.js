
// Login Form 
$(document).ready(function () {
    $("#Login").validate({
        ignore: [],
        rules: {
            username: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                maxlength: 15
            }
        },
        messages: {
            username: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            password: {
                required: "Please enter your password"
            }
        },
    });
    $("#Login").submit(function (e) {
        if ($("#Login").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });

});


$("#Forgot_password").validate({
    rules: {
        email: {
            required: true,
            email: true
        }
    },
    messages: {
        email: {
            required: "Please enter your email",
            email: "Please enter a valid email"
        }
    },
});
$("#Forgot_password").submit(function (e) {
    if ($("#Forgot_password").valid()) {
        $("body").preloader({
            percent: 10,
            duration: 15000
        });
    } else {
        e.preventDefault();
    }
});
$("#Forgot_password").submit(function () {
    if ($("#Forgot_password").valid()) {
        $('#loadingmessage').show();
    }
});


// Reset Password Form


$.validator.addMethod("passwordRule", function (value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/.test(value);
}, "Please enter valid password.");

$("#Reset_password").validate({
    rules: {
        password: {
            required: true,
            minlength: 8,
            maxlength: 15,
            passwordRule: true
        },
        cpassword: {
            required: true,
            equalTo: "#password"
        }
    },
    messages: {
        password: {
            required: "Please enter a password",
            minlength: "Please enter minimum 8 characters",
            maxlength: "Please enter maximum 15 characters"
        },
        cpassword: {
            required: "Please enter a confirm password",
            equalTo: "Password and confirm password must be same."
        }
    },
    highlight: function (e) {
        $(e).closest('.validate').removeClass('has-success has-error').addClass('has-error');
    }
});
$("#Reset_password").submit(function (e) {
    if ($("#Reset_password").valid()) {
        $("body").preloader({
            percent: 10,
            duration: 15000
        });
    } else {
        e.preventDefault();
    }
});


// Update Password Form
$(document).ready(function () {
    $.validator.addMethod("passwordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/.test(value);
    }, "Please enter valid password.");

    $("#Update_password").validate({
        rules: {
            old_password: {
                required: true
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 15,
                passwordRule: true
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            old_password: {
                required: "Please enter old password",
            },
            password: {
                required: "Please enter password",
                minlength: "Please enter minimum 8 characters",
                maxlength: "Please enter maximum 15 characters"
            },
            confirm_password: {
                required: "Please enter confirm password",
                equalTo: "Password and confirm password must be same."
            }
        },
    });
    $("#Update_password").submit(function (e) {
        if ($("#Update_password").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    $("#Update_password").submit(function () {
        if ($("#Update_password").valid()) {
            $('#loadingmessage').show();
        }
    });
});

// Profile Form
$(document).ready(function () {
    $("#Profile").validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                minlength: 10,
                maxlength: 14,
                required: true,
            },
            profile_image: {
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            first_name: {
                required: "Please enter your firstname",
            },
            last_name: {
                required: "Please enter your lastname",
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            phone: {
                required: "Please enter your phone number",
                minlength: "Please enter minimum 10 digit of number",
                maxlength: "Please enter maximum 14 digit of number"
            },
            profile_image: {
                extension: "File must be JPEG or PNG "
            }

        },
    });

    $("#Profile").submit(function (e) {
        if ($("#Profile").valid()) {
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
