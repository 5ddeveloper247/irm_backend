$(document).ready(function () {
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        getCourseTypesPageData();
    });
})
var course_eligibility = document.getElementById('course_eligibility');
function getCourseTypesPageData(formValues = {}){

    let type = 'POST';
    let url = '/getCourseTypesPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
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
//    empty
    $('#courseType_table_body').html('');
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
    if ($.fn.DataTable.isDataTable('#courseType_table')) {
        $('#courseType_table').DataTable().destroy().clear();
    }
    $("#courseType_table_body").html(html);
    $("#courseType_table").DataTable({
        bDestroy:true,
        paging: true,
        lengthChange: true,
        searching: true,
        info: true,
        autoWidth: false,
        responsive: true,
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search",
        },
        dom: "Bfrtip",
        buttons: [
            { extend: "copy", className: "btn btn-copy", text: "Copy" },
            { extend: "csv", className: "btn btn-csv", text: "CSV" },
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            { extend: "pdf", className: "btn btn-pdf", text: "PDF" },
            { extend: "print", className: "btn btn-print", text: "Print" },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    console.log("Refresh button clicked");
                    $("#resetFilterButton").click(); 
                    getCourseTypesPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
    
}

function makeCourseListing(courseList){
   
    var html = '';
   $('#course_table_body').html('');
    if (courseList.length > 0) {
        $.each(courseList, function (index, course) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${course.title != null ? course.title : ''}</td>
                        <td class="text-start text-nowrap">${course?.type?.title != null ? course?.type?.title : ''}</td>
                        <td class="text-start text-nowrap">${course.instructor_name != null ? course.instructor_name : ''}</td>
                        <td class="text-start text-nowrap">${course.language != null ? course.language : ''}</td>
                        <td class="text-start text-nowrap">${course.level != null ? course.level : ''}</td>
                        <td class="text-start text-nowrap">${course.certificate != null ? course.certificate : ''}</td>
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
    if ($.fn.DataTable.isDataTable('#course_table')) {
        $('#course_table').DataTable().destroy().clear();
    }
    $("#course_table_body").html(html);
    $("#course_table").DataTable({
        bDestroy:true,
        paging: true,
        lengthChange: true,
        searching: true,
        info: true,
        autoWidth: false,
        responsive: true,
        scrollX: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search",
        },
        dom: "Bfrtip",
        buttons: [
            { extend: "copy", className: "btn btn-copy", text: "Copy" },
            { extend: "csv", className: "btn btn-csv", text: "CSV" },
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            { extend: "pdf", className: "btn btn-pdf", text: "PDF" },
            { extend: "print", className: "btn btn-print", text: "Print" },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    console.log("Refresh button clicked");
                    $("#resetFilterButton").click(); 
                    getCourseTypesPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
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
    } else{
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        toastr.error(response.message, '', {
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
    $("#fields_container, #instructor_fields_container").html('');
    $("#thumbnail_file, #course_id").val('');
    $(".thumbnail_preview").hide();
    
    editorInstance.course_description.setData('');
    editorInstance.course_eligibility.setData('');
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
            // $("#instructor_name").val(courseDetail.instructor_name);
            // add_instructor_row
            var instructors = courseDetail.instructor_name;
            console.log(instructors);
            var html = '';
            $("#instructor_fields_container").html('');
            if (instructors.length > 0) {
                $.each(instructors, function (index, instructor) {
                    console.log(instructor);
                    html += `<div class="d-flex align-items-center justify-content-between instructor_field_div">
                                <div class="form-floating col-11 my-2">
                                    <input class="form-control" type="text" id="instructor_name${index+1}" name="instructor_name[${index+1}][name]" value="${instructor}" placeholder="Enter Instructor Name ${index+1}">
                                    <label class="ms-2" for="instructor_name${index+1}">Instructor Name ${index+1}</label>
                                </div>
                                <svg class="cross-svg remove_instructor_field" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                                    <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                                </svg>
                            </div>`;
                });
                $("#instructor_fields_container").html(html);
            }
            $("#course_duration").val(courseDetail.duration_minutes);
            // total_course_duration
            $("#total_course_duration").val(courseDetail.total_course_duration);
            $("#course_total_lectures").val(courseDetail.total_lectures);
            $("#course_level").val(courseDetail.level);
            $("#course_language").val(courseDetail.language);
            $("#course_certificate").val(courseDetail.certificate);
            $("#course_status").val(courseDetail.status);
            // course_eligibility
            $("#course_eligibility").val(courseDetail.eligibility);
            // ckeditor
            editorInstance.course_eligibility.setData(courseDetail.eligibility??'');
            
            if(courseDetail.thumbnail != null){
                $(".thumbnail_preview").attr('src', courseDetail.thumbnail).show();
            }else{
                $(".thumbnail_preview").attr('src', '').hide();
            }

            var videos = courseDetail.videos;
            var html = '';
            $("#fields_container").html('');
            if (videos.length > 0) {
                $.each(videos, function (index, video) {
                    
                    html += `<div class="d-flex align-items-center justify-content-between field_div" id="field_div_${video.id}">
                                <div class="form-floating col-11 my-2">
                                    <input type="hidden" name="videos[${index+1}][id]" value="${video.id}">
                                    <input class="form-control" type="text" id="course_video_url${index+1}" name="videos[${index+1}][url]" value="${video.video_url}" placeholder="Enter Youtube URL ${index+1}">
                                    <label class="ms-2" for="course_video_url${index+1}">Youtube URL ${index+1}</label>
                                </div>
                                
                                <svg class="cross-svg" onclick="deleteCourseVideoConfirm(${video.id})" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                                    <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                                </svg>
                            </div>`;
                });
            }
            $("#fields_container").html(html);

            $('#addCourse_canvas').addClass('show');
        }
    } 
}

function deleteCourseVideoConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteCourseVideoConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteCourseVideoConfirmed(){

    let type = 'POST';
    let url = '/deleteCourseVideo';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('video_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteCourseVideoConfirmedResponse, '', '');
}

function deleteCourseVideoConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        $("#field_div_"+tempId).remove();
        
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        tempId = '';

        toastr.success(response.message, '', {
            timeOut: 3000
        });
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
    }else{
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        toastr.error(response.message, '', {
            timeOut: 3000
        });
    }
}

$(document).on('click', '.remove_field', function (e) {
    $(this).closest('.field_div').remove();
});
// add_instructor_row
$('#add_instructor_row').on('click',function(){
    // instructor_fields_container on this part
    let count = $('.instructor_field_div').length;
    count++;
    let html = `<div class="d-flex align-items-center justify-content-between instructor_field_div">
                    <div class="form-floating col-11 my-2">
                        <input class="form-control" type="text" id="instructor_name${count}" name="instructor_name[${count}][name]" placeholder="Enter Instructor Name ${count}">
                        <label class="ms-2" for="instructor_name${count}">Instructor Name ${count}</label>
                    </div>
                    <svg class="cross-svg remove_instructor_field" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                        <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                    </svg>
                </div>`;
                $('#instructor_fields_container').append(html);
});
// remove_instructor_field
$(document).on('click', '.remove_instructor_field', function (e) {
    $(this).closest('.instructor_field_div').remove();
});

$('#add_row').on('click',function(){
    
    let count = $('.field_div').length;
    count++;
    let html = `<div class="d-flex align-items-center justify-content-between field_div">
                    <div class="form-floating col-11 my-2">
                        <input class="form-control course_video_url" type="text" id="course_video_url${count}" name="videos[${count}][url]" placeholder="Enter Youtube URL ${count}">
                        <label class="ms-2" for="course_video_url${count}">Youtube URL ${count}</label>
                    </div>
                    <svg class="cross-svg remove_field" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                        <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                    </svg>
                </div>`;
    
    $('#fields_container').append(html);
});

$(document).on('change', 'input, textarea, select', function (e) {
	$(this).removeClass('is-invalid');
});

$(document).ready(function () {

    getCourseTypesPageData();
});

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#courseType_table_body tr").each(function () {
            var row = $(this);
            var hasMatch = false;
    
            // Iterate through each cell in the row
            row.find("td").each(function () {
                var cell = $(this);
                if (cell.text().toLowerCase().indexOf(value) > -1) {
                    cell.addClass("table-highlight"); // Highlight matching cell
                    hasMatch = true; // Mark the row as having a match
                } else {
                    cell.removeClass("table-highlight"); // Remove table-highlight from non-matching cells
                }
            });
    
            // Toggle the visibility of the row based on whether it has a match
            row.toggle(hasMatch);
        });
    
        // Display 'No result found' if no rows are visible
        if ($("#courseType_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#courseType_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#courseType_table_body tr td").removeClass("table-highlight");
        }
    });
    $('#search_filter_02').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#course_table_body tr").each(function () {
            var row = $(this);
            var hasMatch = false;
    
            // Iterate through each cell in the row
            row.find("td").each(function () {
                var cell = $(this);
                if (cell.text().toLowerCase().indexOf(value) > -1) {
                    cell.addClass("table-highlight"); // Highlight matching cell
                    hasMatch = true; // Mark the row as having a match
                } else {
                    cell.removeClass("table-highlight"); // Remove table-highlight from non-matching cells
                }
            });
    
            // Toggle the visibility of the row based on whether it has a match
            row.toggle(hasMatch);
        });
    
        // Display 'No result found' if no rows are visible
        if ($("#course_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#course_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#course_table_body tr td").removeClass("table-highlight");
        }
    });
});