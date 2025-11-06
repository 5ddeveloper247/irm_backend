function getNewsEventsPageData(formValues = {}){

    let type = 'POST';
    let url = '/getNewsEventsPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getNewsEventsPageDataResponse, '', '');
}

function getNewsEventsPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var eventsList = data.events_list;

        makeEventsListing(eventsList);
    } 
}

function makeEventsListing(eventsList){
   
    var html = '';
    $("#listing_table_body").html('');
    if (eventsList.length > 0) {
        $.each(eventsList, function (index, value) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${value.title}</td>
                        <td class="text-start text-nowrap">${value.type}</td>
                        <td class="text-start text-nowrap">${formatDate(value.start_date)}</td>
                        <td class="text-start text-nowrap">${formatDate(value.end_date)}</td>
                        <td class="text-start text-nowrap">
                        ${ value.expiry_status == 'Expired'? '<span class="badge bg-danger">Expired</span>':
                            value.status == '1' ? 
                            '<span class="badge bg-success">Active</span>' 
                            : 
                            '<span class="badge bg-danger">In-Active</span>'
                        }
                        </td>
                        <td class="text-start text-nowrap">
                            <div class="btn-group">
                                <button class="btn action-buttons dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5.92A.96.96 0 1 0 12 4a.96.96 0 0 0 0 1.92m0 7.04a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92M12 20a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <a class="dropdown-item" href="javascript:;" onclick="editEvent(${value.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteEventConfirm(${value.id})">
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
    
    // listing_table
    // destroy datatable if already created
    if ($.fn.DataTable.isDataTable("#listing_table")) {
        $("#listing_table").DataTable().destroy().clear();
    }
    $("#listing_table_body").html(html);
    // listing_table
    $("#listing_table").DataTable({
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
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    console.log("Refresh button clicked");
                    $("#resetFilterButton").click(); 
                    getNewsEventsPageData();
                } 
            }
        ],
    });
}

function addNewEvent(){
    resetEventForm();
    $('#addNewsEvents_canvas').addClass('show');
}

$(document).on('click', '.closeCanvas', function (e) {
	
	resetEventForm();
    $('#addNewsEvents_canvas').removeClass('show');
});

function resetEventForm(){
    let form = $('#newsEvent_form');
    form.trigger("reset");

    selectedFiles = [];
    $("#image_file, #event_id").val('');
    $("#owner_name, #organization_no, #country, #city").val('');
    $("#file_container, #file_container_uploaded").html('');
    editorInstance.description.setData('');
    // Hide all recurring fields
    $("#recurring_type_div, #repeat_on_div, #monthly_week_div, #monthly_repeat_on_div, #yearly_week_div, #yearly_repeat_on_div").hide();
    // Reset all recurring field values
    $("#repeat_on, #monthly_week, #monthly_repeat_on, #yearly_week, #yearly_repeat_on").val(JSON.parse('[]')).trigger('change');
}

$(document).on('change', '#event_type', function (e) {
    var eventType = $(this).val();

    if(eventType != ''){
        if(eventType == 'Recurring'){
            $("#recurring_type_div").val('').show();
        }else{
            $("#recurring_type, #repeat_on, #monthly_week, #monthly_repeat_on, #yearly_week, #yearly_repeat_on").val('').trigger('change');
            $("#recurring_type_div, #repeat_on_div, #monthly_week_div, #monthly_repeat_on_div, #yearly_week_div, #yearly_repeat_on_div").hide();
        }
    }else{
        $("#recurring_type, #repeat_on, #monthly_week, #monthly_repeat_on, #yearly_week, #yearly_repeat_on").val('').trigger('change');
        $("#recurring_type_div, #repeat_on_div, #monthly_week_div, #monthly_repeat_on_div, #yearly_week_div, #yearly_repeat_on_div").hide();
    }
});

// Handle Recurring Type changes
$(document).on('change', '#recurring_type', function (e) {
    var recurringType = $(this).val();

    // Hide ALL sub-options first
    $("#repeat_on, #monthly_week, #monthly_repeat_on, #yearly_week, #yearly_repeat_on").val('').trigger('change');
    $("#repeat_on_div, #monthly_week_div, #monthly_repeat_on_div, #yearly_week_div, #yearly_repeat_on_div").hide();

    if(recurringType != ''){
        if(recurringType == 'Weekly' || recurringType == 'Bi-Weekly'){
            // For Weekly/Bi-Weekly: Show repeat_on only
            $("#repeat_on_div").show();
        } 
        else if(recurringType == 'Monthly'){
            // For Monthly: Show week and repeat_on
            $("#monthly_week_div, #monthly_repeat_on_div").show();
        } 
        else if(recurringType == 'Yearly'){
            // For Yearly: Show week and repeat_on
            $("#yearly_week_div, #yearly_repeat_on_div").show();
        }
    }
});

// Handle Monthly subtype changes
$(document).on('change', '#monthly_subtype', function (e) {
    var monthlySubtype = $(this).val();

    // Hide monthly repeat on
    $("#monthly_repeat_on").val('').trigger('change');
    $("#monthly_repeat_on_div").hide();

    if(monthlySubtype != ''){
        if(monthlySubtype == 'Weekly' || monthlySubtype == 'Bi-Weekly'){
            // Show repeat days for monthly weekly/bi-weekly
            $("#monthly_repeat_on_div").show();
        }
    }
});

// Handle Yearly subtype changes
$(document).on('change', '#yearly_subtype', function (e) {
    var yearlySubtype = $(this).val();

    // Hide yearly repeat on
    $("#yearly_repeat_on").val('').trigger('change');
    $("#yearly_repeat_on_div").hide();

    if(yearlySubtype != ''){
        if(yearlySubtype == 'Weekly' || yearlySubtype == 'Bi-Weekly'){
            // Show repeat days for yearly weekly/bi-weekly
            $("#yearly_repeat_on_div").show();
        }
    }
});

var selectedFiles = [];

$(document).on('click', '#addImage_btn', function (e) {
	$("#image_file").click();
});

$('#image_file').on('change', function (event) {
    // reset the selectedFiles array
    selectedFiles = [];
    // reset the file container
    $('#file_container_uploaded').empty();
    const files = event.target.files; // New files

    // Check if a file is already selected
    if (selectedFiles.length > 0) {
        toastr.error('You can upload only one image file.');
        // Clear the file input value to allow re-uploading the same file later
        $('#image_file').val('');
        return;
    }

    // Validate and add selected file to selectedFiles array
    const file = files[0];
    const fileType = file.type;

    // Check if the file is an image of the allowed types
    if (!fileType.match('image/jpeg') && !fileType.match('image/png') && 
        !fileType.match('image/jpg') && !fileType.match('image/gif') && 
        !fileType.match('image/svg+xml')) {
        toastr.error('Only JPEG, JPG, PNG, GIF, and SVG image files are allowed.');
    } else {
        // Add the valid image file to the selectedFiles array
        selectedFiles.push(file);
        // Display selected file
        displaySelectedFiles();
    }
    
    // Clear the file input value to allow re-uploading the same file later
    $('#image_file').val('');
});


function saveEvent(){

    let type = 'POST';
    let url = '/saveEvent';
    let message = '';
    let form = $('#newsEvent_form');
    let data = new FormData(form[0]);

    if (selectedFiles.length > 0) {
        
        for (let i = 0; i < selectedFiles.length; i++) {
            
            data.append('images[]', selectedFiles[i]);
        }
    } else {
        data.append('images', '');
    }
   
    // PASSING DATA TO FUNCTION
    $('input, select').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveEventResponse, '', '#saveEvent_btn');
}

function saveEventResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetEventForm();
        getNewsEventsPageData();
        $('#addNewsEvents_canvas').removeClass('show');
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

function editEvent(id){

    let type = 'POST';
    let url = '/getSpecificEvent';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('event_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editGalleryResponse, '', '');
}

function editGalleryResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;
        var eventDetail = data.event_detail;
        
        if(eventDetail != null){
            $("#event_id").val(eventDetail.id);
            $("#title").val(eventDetail.title);
            $("#description").val(eventDetail.description);
            editorInstance.description.setData(eventDetail.description);
            $("#event_date").val(eventDetail.event_date);
            $("#start_date").val(eventDetail.start_date);
            $("#end_date").val(eventDetail.end_date);
            $("#namaz_name").val(eventDetail.namaz_name);
            $("#owner_name").val(eventDetail.owner_name || '');
            $("#organization_no").val(eventDetail.organization_no || '');
            $("#country").val(eventDetail.country || '');
            $("#city").val(eventDetail.city || '');
            $("#event_type").val(eventDetail.type);

            if(eventDetail.type == 'Recurring'){
                $("#recurring_type_div").show();
                $("#recurring_type").val(eventDetail.recurring_type);
                
                // Handle Weekly/Bi-Weekly
                if(eventDetail.recurring_type == 'Weekly' || eventDetail.recurring_type == 'Bi-Weekly'){
                    $("#repeat_on_div").show();
                    $("#repeat_on").val(JSON.parse(eventDetail.repeat_on || '[]')).trigger('change');
                }
                // Handle Monthly
                else if(eventDetail.recurring_type == 'Monthly'){
                    $("#monthly_week_div, #monthly_repeat_on_div").show();
                    $("#monthly_week").val(eventDetail.monthly_week);
                    $("#monthly_repeat_on").val(JSON.parse(eventDetail.repeat_on || '[]')).trigger('change');
                }
                // Handle Yearly
                else if(eventDetail.recurring_type == 'Yearly'){
                    $("#yearly_week_div, #yearly_repeat_on_div").show();
                    $("#yearly_week").val(eventDetail.yearly_week);
                    $("#yearly_repeat_on").val(JSON.parse(eventDetail.repeat_on || '[]')).trigger('change');
                }
            }else{
                $("#recurring_type_div, #repeat_on_div, #monthly_week_div, #monthly_repeat_on_div, #yearly_week_div, #yearly_repeat_on_div").hide();
            }
            
            $("#location").val(eventDetail.location);
            $("#status").val(eventDetail.status);
            
            var html = '';
            var attachments = eventDetail.attachments;
            if (attachments.length > 0) {
                $.each(attachments, function (index, attachment) {
                    
                    html += `<div class="col-3 my-3" id="att_${attachment.id}">
                                <img src="${attachment.path}" class="img-prev">
                                <span class="cancel-icon" onclick="deleteEventAttConfirm(${attachment.id});">×</span>
                            </div>`;
                });
            }
            $("#file_container_uploaded").html(html);

            $('#addNewsEvents_canvas').addClass('show');
        }
    } 
}

var tempId = '';
function deleteEventAttConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteEventAttConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteEventAttConfirmed(){

    let type = 'POST';
    let url = '/deleteEventAtt';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('attachment_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteEventAttConfirmedResponse, '', '');
}

function deleteEventAttConfirmedResponse(response) {

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

function deleteEventConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteEventConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteEventConfirmed(){

    let type = 'POST';
    let url = '/deleteEvent';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('event_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteEventConfirmedResponse, '', '');
}

function deleteEventConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        getNewsEventsPageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}

function displaySelectedFiles() {
    const $imageContainer = $('#file_container');
    $imageContainer.empty()
    if (selectedFiles.length < 8) {
        $imageContainer.empty() // Clear previous images
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader()
            reader.onload = function (e) {
                const $imageDiv = $('<div>').addClass('col-3 my-3')
                const $image = $('<img>').attr('src', e.target.result).addClass('img-prev')
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

    getNewsEventsPageData();
});

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#listing_table_body tr").each(function () {
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
        if ($("#listing_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#listing_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#listing_table_body tr td").removeClass("table-highlight");
        }
    });
});

$(document).on('click', '#close_confirm', function (e) {
    tempId = '';
    $("#deleteConfirm_btn").attr('onclick', '');
	$("#delete_confirm_modal").modal('hide');
});