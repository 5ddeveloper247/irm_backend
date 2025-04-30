$(document).ready(function () {
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        getGalleryTypesPageData();
    });
})
function getGalleryTypesPageData(formValues = {}){

    let type = 'POST';
    let url = '/getGalleryTypesPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getGalleryTypesPageDataResponse, '', '');
}

function getGalleryTypesPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var typeList = data.type_list;
        var galleryList = data.gallery_list;

        makeGalleryTypesListing(typeList);
        makeGalleryListing(galleryList);

        var options = '<option value="">Choose</option>';
   
        if (typeList.length > 0) {
            $.each(typeList, function (index, type) {
                if(type.status == '1'){
                    options += `<option value="${type.id}">${type.title}</option>`;
                }
            });
        }
        $("#gallery_type").html(options);
    } 
}

function makeGalleryTypesListing(typeList){
   
    var html = '';
   $("#galleryType_table_body").html('');
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editGalleryType(${type.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteGalleryTypeConfirm(${type.id})">
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
    
    if ($.fn.DataTable.isDataTable('#galleryType_table')) {
        $('#galleryType_table').DataTable().destroy().clear();
    }
    $("#galleryType_table_body").html(html);
    $("#galleryType_table").DataTable({
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
            // { extend: "copy", className: "btn btn-copy", text: "Copy" },
            // { extend: "csv", className: "btn btn-csv", text: "CSV" },
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            // { extend: "pdf", className: "btn btn-pdf", text: "PDF" },
            // { extend: "print", className: "btn btn-print", text: "Print" },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    console.log("Refresh button clicked");
                    $("#resetFilterButton").click(); 
                    getGalleryTypesPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
}

function makeGalleryListing(galleryList){
   
    var html = '';
   $("#gallery_table_body").html('');
    if (galleryList.length > 0) {
        $.each(galleryList, function (index, gallery) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${gallery.title != null ? gallery.title : ''}</td>
                        <td class="text-start text-nowrap">${gallery?.type?.title != null ? gallery?.type?.title : ''}</td>
                        <td class="text-start text-nowrap">${gallery.description != null ? trimText(gallery.description, 30) : ''}</td>
                        <td class="text-start text-nowrap">${formatDate(gallery.date)}</td>
                        <td class="text-start text-nowrap">
                            ${gallery.status == '1' ? 
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editGallery(${gallery.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteGalleryConfirm(${gallery.id})">
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
    // gallery_table
    if ($.fn.DataTable.isDataTable('#gallery_table')) {
        $('#gallery_table').DataTable().destroy().clear();
    }
    $("#gallery_table_body").html(html);
    $("#gallery_table").DataTable({
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
            // { extend: "copy", className: "btn btn-copy", text: "Copy" },
            // { extend: "csv", className: "btn btn-csv", text: "CSV" },
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            // { extend: "pdf", className: "btn btn-pdf", text: "PDF" },
            // { extend: "print", className: "btn btn-print", text: "Print" },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    console.log("Refresh button clicked");
                    $("#resetFilterButton").click(); 
                    getGalleryTypesPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });

}

function addNewType(){

    resetTypeForm();
    $('#addGalleryType_canvas').addClass('show');
}


$(document).on('click', '.closeCanvas', function (e) {
	
	resetTypeForm();
    $('#addGalleryType_canvas').removeClass('show');
});

function resetTypeForm(){

    let form = $('#type_form');
	form.trigger("reset");

    $('#type_id').val('');
}

function saveGalleryType(){

    let type = 'POST';
    let url = '/saveGalleryType';
    let message = '';
    let form = $('#type_form');
    let data = new FormData(form[0]);
    
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveGalleryTypeResponse, '', '#addType_btn');
}

function saveGalleryTypeResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetTypeForm();
        getGalleryTypesPageData();
        $('#addGalleryType_canvas').removeClass('show');
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

function editGalleryType(id){

    let type = 'POST';
    let url = '/getSpecificGalleryType';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('type_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editGalleryTypeResponse, '', '');
}

function editGalleryTypeResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var typeDetail = data.type_detail;
        
        if(typeDetail != null){
            $("#type_id").val(typeDetail.id);
            $("#type_title").val(typeDetail.title);
            $("#type_description").val(typeDetail.description);
            $("#type_status").val(typeDetail.status);

            $('#addGalleryType_canvas').addClass('show');
        }
    } 
}

var tempId = '';
function deleteGalleryTypeConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteGalleryTypeConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

$(document).on('click', '#close_confirm', function (e) {
    tempId = '';
    $("#deleteConfirm_btn").attr('onclick', '');
	$("#delete_confirm_modal").modal('hide');
});

function deleteGalleryTypeConfirmed(){

    let type = 'POST';
    let url = '/deleteGalleryType';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('type_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteGalleryTypeConfirmedResponse, '', '');
}

function deleteGalleryTypeConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        getGalleryTypesPageData();

        toastr.success(response.message, '', {
            timeOut: 3000
        });
    }else{
        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        toastr.error(response.message, '', {
            timeOut: 3000
        });
    }
}








var selectedFiles = [];

// $(document).on('click', '#addthumbnail_btn', function (e) {
// 	$("#thumbnail_file").click();
// });

// $(document).on('change', '#thumbnail_file', function() {
//     var file = this.files[0];
//     var filePreview = $('.thumbnail_preview');

//     if (file) {
//         var reader = new FileReader();
//         reader.onload = function(e) {
//             filePreview.attr('src', e.target.result).show(); // Show the image preview
//         }
//         reader.readAsDataURL(file); // Convert the file to a base64 string
//     } else {
//         filePreview.attr('src', '').hide();
//     }
// });


$(document).on('click', '#addGallery_btn', function (e) {
	$("#image_file").click();
});

$('#image_file').on('change', function (event) {
    const files = event.target.files; // New files
    // var allfileslength = files.length + selectedFiles.length; // Total files count

    // // Check if total files exceed the limit
    // if (allfileslength > 7) {
    //     toastr.error('You can upload a maximum of 7 image files.');
    //     // Clear the file input value to allow re-uploading the same file later
    //     $('#image_file').val('');
    //     return;
    // }

    // Validate and add selected files to selectedFiles array
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileType = file.type;

        // Check if the file is an image of the allowed types
        if (!fileType.match('image/jpeg') && !fileType.match('image/png') && 
            !fileType.match('image/jpg') && !fileType.match('image/gif') && 
            !fileType.match('image/svg+xml')) {
            toastr.error('Only JPEG, JPG, PNG, GIF, and SVG image files are allowed.');
            continue;
        }

        // Add the valid image file to the selectedFiles array
        selectedFiles.push(file);
    }

    // Display selected files
    displaySelectedFiles();

    // Clear the file input value to allow re-uploading the same file later
    $('#image_file').val('');
});

function addNewGallery(){
    resetGalleryForm();
    $('#addGallery_canvas').addClass('show');
}

function resetGalleryForm(){
    let form = $('#gallery_form');
	form.trigger("reset");

    selectedFiles = [];
    $("#image_file, #gallery_id").val('');
    $("#file_container, #file_container_uploaded").html('');
}

$(document).on('click', '.closeCanvas1', function (e) {
	resetGalleryForm();
    $('#addGallery_canvas').removeClass('show');
});

function saveGallery(){

    let type = 'POST';
    let url = '/saveGallery';
    let message = '';
    let form = $('#gallery_form');
    let data = new FormData(form[0]);

    if (selectedFiles.length > 0) {
        
        for (let i = 0; i < selectedFiles.length; i++) {
            
            data.append('images[]', selectedFiles[i]);
        }
    } else {
        data.append('images', '');
    }
   
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveGalleryResponse, '', '#saveGallery_btn');
}

function saveGalleryResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetGalleryForm();
        getGalleryTypesPageData();
        $('#addGallery_canvas').removeClass('show');
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

function editGallery(id){

    let type = 'POST';
    let url = '/getSpecificGallery';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('gallery_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editGalleryResponse, '', '');
}

function editGalleryResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var galleryDetail = data.gallery_detail;
        
        if(galleryDetail != null){
            $("#gallery_id").val(galleryDetail.id);
            $("#gallery_type").val(galleryDetail.type_id);
            $("#gallery_title").val(galleryDetail.title);
            $("#gallery_description").val(galleryDetail.description);
            $("#gallery_status").val(galleryDetail.status);
            
            var html = '';
            var attachments = galleryDetail.attachments;
            if (attachments.length > 0) {
                $.each(attachments, function (index, attachment) {
                    
                    html += `<div class="col-3 my-3" id="att_${attachment.id}">
                                <img src="${attachment.path}" class="img-prev">
                                <span class="cancel-icon" onclick="deleteGalleryAttConfirm(${attachment.id});">×</span>
                            </div>`;
                });
            }
            $("#file_container_uploaded").html(html);

            $('#addGallery_canvas').addClass('show');
        }
    } 
}

function deleteGalleryAttConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteGalleryAttConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteGalleryAttConfirmed(){

    let type = 'POST';
    let url = '/deleteGalleryAtt';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('attachment_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteGalleryAttConfirmedResponse, '', '');
}

function deleteGalleryAttConfirmedResponse(response) {

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

function deleteGalleryConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteGalleryConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteGalleryConfirmed(){

    let type = 'POST';
    let url = '/deleteGallery';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('gallery_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteGalleryConfirmedResponse, '', '');
}

function deleteGalleryConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        getGalleryTypesPageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}


function displaySelectedFiles() {
    const $imageContainer = $('#file_container');
    $imageContainer.empty(); // Clear previous images
    
    // Display all selected files regardless of count
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const $imageDiv = $('<div>').addClass('col-3 my-3');
            const $image = $('<img>').attr('src', e.target.result).addClass('img-prev');
            $imageDiv.append($image);
            const $cancelButton = $('<span>').html('&times;').addClass('cancel-icon');
            $cancelButton.on('click', function () {
                selectedFiles.splice(index, 1);
                displaySelectedFiles();
            });
            $imageDiv.append($cancelButton);
            $imageContainer.append($imageDiv);
        };
        reader.readAsDataURL(file);
    });
    
    
}

$(document).on('change', 'input, textarea, select', function (e) {
	$(this).removeClass('is-invalid');
});

$(document).ready(function () {

    getGalleryTypesPageData();
});


$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#galleryType_table_body tr").each(function () {
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
        if ($("#galleryType_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#galleryType_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#galleryType_table_body tr td").removeClass("table-highlight");
        }
    });
    $('#search_filter_02').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#gallery_table_body tr").each(function () {
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
        if ($("#gallery_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#gallery_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#gallery_table_body tr td").removeClass("table-highlight");
        }
    });
});