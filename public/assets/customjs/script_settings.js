function updateSettings(){

    let type = 'POST';
    let message = '';
    let form = $('#updateSettings');
    // get form action url

    let url = form.attr('action');
    let data = new FormData(form[0]);
    console.log(data, url);
    // PASSING DATA TO FUNCTION
    // $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', updateSettingsResponse, '', '#updateSettings_btn');
}
function updateSettingsResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

    } else {
        if (response.status == 402) {
            error = response.message;
        } else {
            error = response.message;
        }
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

// company_logo preview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#company_logo_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#company_logo").change(function() {
    readURL(this);
});