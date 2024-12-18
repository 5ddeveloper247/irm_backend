
function verifyForgetEmail(){

    let type = 'POST';
    let url = '/verifyForgetEmail';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('email', $("#email").val());
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', verifyForgetEmailResponse, '', '#verifyEmail_btn');
}

function verifyForgetEmailResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        $("#email").attr('disabled', true);
        $("#verifyEmail_btn").hide();
        $("#verifyOtp_btn, .step-2").show();

        toastr.success(response.message, '', {
            timeOut: 3000
        });

    } else {

        if (response.status == 402) {

            error = response.message;

        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;

            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                // Add the 'is-invalid' class to the input field's parent or any desired container
                inputField.closest('.form-control').addClass('is-invalid');
            });
        }
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

function verifyForgetOtp(){

    let type = 'POST';
    let url = '/verifyForgetOtp';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('email', $("#email").val());
    data.append('otp', $("#otp").val());
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', verifyForgetOtpResponse, '', '#verifyOtp_btn');
}

function verifyForgetOtpResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        $("#email, #otp").attr('disabled', true);
        $("#verifyEmail_btn, #verifyOtp_btn, .step-1, .step-2").hide();
        $("#changePass_btn, .step-3").show();

        $("#new_password, #confirm_password").val('');

        toastr.success(response.message, '', {
            timeOut: 3000
        });

    } else {
        if (response.success == false || response.success == 'false') {

            error = response.message;

        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;

            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                // Add the 'is-invalid' class to the input field's parent or any desired container
                inputField.closest('.form-control').addClass('is-invalid');
            });
        }
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

function verifyForgetPassword(){

    let type = 'POST';
    let url = '/verifyForgetPassword';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('email', $("#email").val());
    data.append('otp', $("#otp").val());
    data.append('password', $("#new_password").val());
    data.append('password_confirmation', $("#password_confirmation").val());
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', verifyForgetPasswordResponse, '', '#changePass_btn');
}

function verifyForgetPasswordResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        toastr.success(response.message, '', {
            timeOut: 3000
        });

        setTimeout(function(){
            window.location.href = '/login';
        },2000);
    } else {
        if (response.success == false || response.success == 'false') {

            error = response.message;

        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;

            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                // Add the 'is-invalid' class to the input field's parent or any desired container
                inputField.closest('.form-control').addClass('is-invalid');
            });
        }
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).ready(function () {

   //
});