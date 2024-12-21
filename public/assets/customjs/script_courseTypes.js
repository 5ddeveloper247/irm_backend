function getCourseTypesPageData(){

    let type = 'POST';
    let url = '/getCourseTypesPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getCourseTypesPageDataResponse, '', '');
}

function getCourseTypesPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var typeList = data.type_list;
        var courseList = data.course_list;

        makeCourseTypesListing(typeList);
        makeCourseListing(courseList);

        var options = '<option value="">Choose</option>';
   
        if (typeList.length > 0) {
            $.each(typeList, function (index, type) {
                if(type.status == '1'){
                    options += `<option value="${type.id}">${type.title}</option>`;
                }
            });
        }
        $("#course_type").html(options);
    } 
}

function makeCourseTypesListing(typeList){
   
    var html = '';
   
    if (typeList.length > 0) {
        $.each(typeList, function (index, type) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${type.title}</td>
                        <td class="text-start text-nowrap">${trimText(type.description, 50)}</td>
                        <td class="text-start text-nowrap">${formatDate(type.date)}</td>
                        <td class="text-start text-nowrap">
                            ${type.status == '1' ? 
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editCourseType(${type.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteCourseTypeConfirm(${type.id})">
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
    $("#courseType_table_body").html(html);
}

function makeCourseListing(courseList){
   
    var html = '';
   
    if (courseList.length > 0) {
        $.each(courseList, function (index, course) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${course.title != null ? course.title : ''}</td>
                        <td class="text-start text-nowrap">${course?.type?.title != null ? course?.type?.title : ''}</td>
                        <td class="text-start text-nowrap">${course.instructor_name != null ? course.instructor_name : ''}</td>
                        <td class="text-start text-nowrap">${formatDate(course.date)}</td>
                        <td class="text-start text-nowrap">
                            ${course.status == '1' ? 
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editCourse(${course.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteCourseConfirm(${course.id})">
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
    $("#course_table_body").html(html);
}

function addNewType(){

    resetTypeForm();
    $('#addCourseType_canvas').addClass('show');
}


$(document).on('click', '.closeCanvas', function (e) {
	
	resetTypeForm();
    $('#addCourseType_canvas').removeClass('show');
});

function resetTypeForm(){

    let form = $('#type_form');
	form.trigger("reset");

    $('#type_id').val('');
}

function saveCourseType(){

    let type = 'POST';
    let url = '/saveCourseType';
    let message = '';
    let form = $('#type_form');
    let data = new FormData(form[0]);
    
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveCourseTypeResponse, '', '#addType_btn');
}

function saveCourseTypeResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetTypeForm();
        getCourseTypesPageData();
        $('#addCourseType_canvas').removeClass('show');
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

function editCourseType(id){

    let type = 'POST';
    let url = '/getSpecificCourseType';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('type_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editCourseTypeResponse, '', '');
}

function editCourseTypeResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var typeDetail = data.type_detail;
        
        if(typeDetail != null){
            $("#type_id").val(typeDetail.id);
            $("#type_title").val(typeDetail.title);
            $("#type_description").val(typeDetail.description);
            $("#type_status").val(typeDetail.status);

            $('#addCourseType_canvas').addClass('show');
        }
    } 
}

var tempId = '';
function deleteCourseTypeConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteCourseTypeConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

$(document).on('click', '#close_confirm', function (e) {
    tempId = '';
    $("#deleteConfirm_btn").attr('onclick', '');
	$("#delete_confirm_modal").modal('hide');
});

function deleteCourseTypeConfirmed(){

    let type = 'POST';
    let url = '/deleteCourseType';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('type_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteCourseTypeConfirmedResponse, '', '');
}

function deleteCourseTypeConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        getCourseTypesPageData();

        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}








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

function addNewCourse(){
    resetCourseForm();
    $('#addCourse_canvas').addClass('show');
}

function resetCourseForm(){
    let form = $('#course_form');
	form.trigger("reset");

    // selectedFiles = [];
    $("#thumbnail_file, #course_id").val('');
    $("#thumbnail_preview").hide();
}

$(document).on('click', '.closeCanvas1', function (e) {
	resetCourseForm();
    $('#addCourse_canvas').removeClass('show');
});

function saveCourse(){

    let type = 'POST';
    let url = '/saveCourse';
    let message = '';
    let form = $('#course_form');
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveCourseResponse, '', '#saveCourse_btn');
}

function saveCourseResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetCourseForm();
        getCourseTypesPageData();
        $('#addCourse_canvas').removeClass('show');
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

function editCourse(id){

    let type = 'POST';
    let url = '/getSpecificCourse';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('course_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editCourseResponse, '', '');
}

function editCourseResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var courseDetail = data.course_detail;
        
        if(courseDetail != null){
            $("#course_id").val(courseDetail.id);
            $("#course_type").val(courseDetail.type_id);
            $("#course_title").val(courseDetail.title);
            $("#course_description").val(courseDetail.description);
            editorInstance.course_description.setData(courseDetail.description);
            $("#course_instructor").val(courseDetail.instructor_name);
            $("#course_duration").val(courseDetail.duration_minutes);
            $("#course_total_lectures").val(courseDetail.total_lectures);
            $("#course_level").val(courseDetail.level);
            $("#course_language").val(courseDetail.language);
            $("#course_certificate").val(courseDetail.certificate);
            $("#course_status").val(courseDetail.status);
            
            if(courseDetail.thumbnail != null){
                $(".thumbnail_preview").attr('src', courseDetail.thumbnail).show();
            }else{
                $(".thumbnail_preview").attr('src', '').hide();
            }
            $('#addCourse_canvas').addClass('show');
        }
    } 
}

function deleteCourseConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteCourseConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteCourseConfirmed(){

    let type = 'POST';
    let url = '/deleteCourse';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('course_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteCourseConfirmedResponse, '', '');
}

function deleteCourseConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        getCourseTypesPageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}

$(document).on('change', 'input, textarea, select', function (e) {
	$(this).removeClass('is-invalid');
});

$(document).ready(function () {

    getCourseTypesPageData();
});