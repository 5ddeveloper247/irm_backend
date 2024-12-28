function getAudioLecturesPageData(){

    let type = 'POST';
    let url = '/getAudioLecturesPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getAudioLecturesPageDataResponse, '', '');
}

function getAudioLecturesPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var categoryList = data.category_list;
        var lectureList = data.lecture_list;

        makeAudioCategoryListing(categoryList);
        makeAudioLectureListing(lectureList);

        var options = '<option value="">Choose</option>';
   
        if (categoryList.length > 0) {
            $.each(categoryList, function (index, category) {
                if(category.status == '1'){
                    options += `<option value="${category.id}">${category.title}</option>`;
                }
            });
        }
        $("#audio_category").html(options);
    } 
}

function makeAudioCategoryListing(categoryList){
   
    var html = '';
   
    if (categoryList.length > 0) {
        $.each(categoryList, function (index, category) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${category.title}</td>
                        <td class="text-start text-nowrap">${trimText(category.description, 50)}</td>
                        <td class="text-start text-nowrap">${formatDate(category.date)}</td>
                        <td class="text-start text-nowrap">
                            ${category.status == '1' ? 
                            '<span class="badge bg-success">Active</span>' 
                            : 
                            '<span class="badge bg-danger">In-Active</span>'}
                            
                        </td>
                        <td class="text-start text-nowrap">
                            <div class="btn-group">
                                <button class="btn action-buttons dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5.92A.96.96 0 1 0 12 4a.96.96 0 0 0 0 1.92m0 7.04a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92M12 20a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <a class="dropdown-item" href="javascript:;" onclick="editAudioCategory(${category.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteAudioCategoryConfirm(${category.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none">
                                                <path fill="currentColor" d="M20 5a1 1 0 1 1 0 2h-1l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H4a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z"></path>
                                            </g>
                                        </svg> 
                                        Delete
                                    </a>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
        });
    }
    $("#audioCategory_table_body").html(html);
}

function makeAudioLectureListing(lectureList){
   
    var html = '';
   
    if (lectureList.length > 0) {
        $.each(lectureList, function (index, lecture) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${lecture.title}</td>
                        <td class="text-start text-nowrap">${lecture?.category?.title}</td>
                        <td class="text-start text-nowrap">${trimText(lecture.description, 30)}</td>
                        <td class="text-start text-nowrap">${formatDate(lecture.date)}</td>
                        <td class="text-start text-nowrap">
                            ${lecture.status == '1' ? 
                            '<span class="badge bg-success">Active</span>' 
                            : 
                            '<span class="badge bg-danger">In-Active</span>'}
                            
                        </td>
                        <td class="text-start text-nowrap">
                            <div class="btn-group">
                                <button class="btn action-buttons dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5.92A.96.96 0 1 0 12 4a.96.96 0 0 0 0 1.92m0 7.04a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92M12 20a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <a class="dropdown-item" href="javascript:;" onclick="editAudioLecture(${lecture.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteAudioLectureConfirm(${lecture.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none">
                                                <path fill="currentColor" d="M20 5a1 1 0 1 1 0 2h-1l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H4a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z"></path>
                                            </g>
                                        </svg> 
                                        Delete
                                    </a>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
        });
    }
    $("#audioLecture_table_body").html(html);
}

function addNewCategory(){

    resetCategoryForm();
    $('#addAudioCategory_canvas').addClass('show');
}


$(document).on('click', '.closeCanvas', function (e) {
	
	resetCategoryForm();
    $('#addAudioCategory_canvas').removeClass('show');
});

function resetCategoryForm(){

    let form = $('#category_form');
	form.trigger("reset");
    
    $("#category_id").val('');
}

function saveAudioCategory(){

    let type = 'POST';
    let url = '/saveAudioCategory';
    let message = '';
    let form = $('#category_form');
    let data = new FormData(form[0]);
    
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveAudioCategoryResponse, '', '#addCategory_btn');
}

function saveAudioCategoryResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetCategoryForm();
        getAudioLecturesPageData();
        $('#addAudioCategory_canvas').removeClass('show');
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

function editAudioCategory(id){

    let type = 'POST';
    let url = '/getSpecificAudioCategory';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('category_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editAudioCategoryResponse, '', '');
}

function editAudioCategoryResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var categoryDetail = data.category_detail;
        
        if(categoryDetail != null){
            $("#category_id").val(categoryDetail.id);
            $("#category_title").val(categoryDetail.title);
            $("#category_description").val(categoryDetail.description);
            $("#category_status").val(categoryDetail.status);

            $('#addAudioCategory_canvas').addClass('show');
        }
    } 
}

var tempId = '';
function deleteAudioCategoryConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteAudioCategoryConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

$(document).on('click', '#close_confirm', function (e) {
    tempId = '';
    $("#deleteConfirm_btn").attr('onclick', '');
	$("#delete_confirm_modal").modal('hide');
});

function deleteAudioCategoryConfirmed(){

    let type = 'POST';
    let url = '/deleteAudioCategory';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('category_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteAudioCategoryConfirmedResponse, '', '');
}

function deleteAudioCategoryConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        getAudioLecturesPageData();

        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}








var selectedFiles = [];

$(document).on('click', '#addthumbnail_btn', function (e) {
	$("#thumbnail_file").click();
});

$(document).on('change', '#thumbnail_file', function() {
    var file = this.files[0];
    var filePreview = $('.thumbnail_preview');

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            filePreview.attr('src', e.target.result).show(); // Show the image preview
        }
        reader.readAsDataURL(file); // Convert the file to a base64 string
    } else {
        filePreview.attr('src', '').hide();
    }
});


$(document).on('click', '#addAudio_btn', function (e) {
	$("#audio_files").click();
});

$('#audio_files').on('change', function (event) {
    const files = event.target.files;
    var allfileslength = files.length + selectedFiles.length;

    // Check if total files exceed the limit
    if (allfileslength > 7) {
        toastr.error('You can upload a maximum of 7 audio files.');
        // Clear the file input value to allow re-uploading the same file later
        $('#audio_files').val('');
        return;
    }

    // Clear previous items in the container
    $('#file-container').empty();

    // Validate and add selected files to selectedFiles array
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileType = file.type;

        // Check if the file is an audio of the allowed types
        if (!fileType.match('audio/mpeg') && !fileType.match('audio/wav') && !fileType.match('audio/ogg')) {
            toastr.error('Only MP3, WAV, and OGG audio files are allowed.');
            continue;
        }

        // Add the valid audio file to the selectedFiles array
        selectedFiles.push(file);
    }

    // Display selected files
    displaySelectedFiles();
    // Clear the file input value to allow re-uploading the same file later
    $('#audio_files').val('');
});

function addNewAudioLecture(){
    resetLectureForm();
    $('#addAudio_canvas').addClass('show');
}

function resetLectureForm(){
    let form = $('#audio_form');
	form.trigger("reset");

    selectedFiles = [];
    $("#audio_id, #audio_files, #thumbnail_file").val('');
    $("#file-container").html('');
    $(".thumbnail_preview").attr('src', '').hide();
}

$(document).on('click', '.closeCanvas1', function (e) {
	resetLectureForm();
    $('#addAudio_canvas').removeClass('show');
});

function saveAudioLecture(){

    let type = 'POST';
    let url = '/saveAudioLecture';
    let message = '';
    let form = $('#audio_form');
    let data = new FormData(form[0]);

    if (selectedFiles.length > 0) {
        
        for (let i = 0; i < selectedFiles.length; i++) {
            
            data.append('audio_files[]', selectedFiles[i]);
        }
    } else {
        data.append('audio_files', '');
    }
   
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveAudioLectureResponse, '', '#saveAudio_btn');
}

function saveAudioLectureResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetLectureForm();
        getAudioLecturesPageData();
        $('#addAudio_canvas').removeClass('show');
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

function editAudioLecture(id){

    let type = 'POST';
    let url = '/getSpecificAudioLecture';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('lecture_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editAudioLectureResponse, '', '');
}

function editAudioLectureResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var lectureDetail = data.lecture_detail;
        
        if(lectureDetail != null){
            $("#audio_id").val(lectureDetail.id);
            $("#audio_category").val(lectureDetail.category_id);
            $("#audio_title").val(lectureDetail.title);
            $("#audio_description").val(lectureDetail.description);
            $("#audio_status").val(lectureDetail.status);
            
            if(lectureDetail.thumbnail != null){
                $(".thumbnail_preview").attr('src', lectureDetail.thumbnail).show();
            }else{
                $(".thumbnail_preview").attr('src', '').hide();
            }

            var html = '';
            var attachments = lectureDetail.attachments;
            if (attachments.length > 0) {
                $.each(attachments, function (index, attachment) {
                    
                    html += `<div class="col-3 my-3" id="att_${attachment.id}">
                                <img src="/assets/images/audio-placeholder.png" class="img-prev">
                                <span class="cancel-icon" onclick="deleteAudioLectureAttConfirm(${attachment.id});">×</span>
                            </div>`;
                });
            }
            $("#file-container-uploaded").html(html);

            $('#addAudio_canvas').addClass('show');
        }
    } 
}

function deleteAudioLectureAttConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteAudioLectureAttConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteAudioLectureAttConfirmed(){

    let type = 'POST';
    let url = '/deleteAudioLectureAtt';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('attachment_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteAudioLectureAttConfirmedResponse, '', '');
}

function deleteAudioLectureAttConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        $("#att_"+tempId).remove();
        
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        tempId = '';

        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}

function deleteAudioLectureConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteAudioLectureConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteAudioLectureConfirmed(){

    let type = 'POST';
    let url = '/deleteAudioLecture';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('lecture_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteAudioLectureConfirmedResponse, '', '');
}

function deleteAudioLectureConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        getAudioLecturesPageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}



function displaySelectedFiles() {
    const $imageContainer = $('#file-container');
    $imageContainer.empty()
    if (selectedFiles.length < 8) {
        $imageContainer.empty() // Clear previous images
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader()
            reader.onload = function (e) {
                const $imageDiv = $('<div>').addClass('col-3 my-3')
                const $image = $('<img>').attr('src', '/assets/images/audio-placeholder.png').addClass('img-prev')
                $imageDiv.append($image)
                const $cancelButton = $('<span>').html('&times;').addClass('cancel-icon')
                $cancelButton.on('click', function () {
                    selectedFiles.splice(index, 1)
                    displaySelectedFiles()
                })
                $imageDiv.append($cancelButton)
                $imageContainer.append($imageDiv)
            }
        reader.readAsDataURL(file)
        })
    }
}

$(document).on('change', 'input, textarea, select', function (e) {
	$(this).removeClass('is-invalid');
});

$(document).ready(function () {

    getAudioLecturesPageData();
});