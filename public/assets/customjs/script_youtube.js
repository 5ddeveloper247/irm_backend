function getYoutubePageData(formValues = {}){

    let type = 'POST';
    let url = '/getYoutubePageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getYoutubePageDataResponse, '', '');
}

function getYoutubePageDataResponse(response) {
    console.log(response.youtubes_list);
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var youtubesList = response.youtubes_list;

        makeYoutubeListing(youtubesList);
    } 
}

function makeYoutubeListing(youtubesList){
   
    var html = '';
    if ($.fn.DataTable.isDataTable('#listing_table')) {
        $('#listing_table').DataTable().destroy();
    }
    if (youtubesList.length > 0) {
        $.each(youtubesList, function (index, value) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>

                        <td class="text-start text-nowrap">${value.playlist_title}</td>
                        <td class="text-start text-nowrap">${value.playlist_id}</td>
                        // created_at
                        <td class="text-start text-nowrap">${formatDate(value.created_at)}</td>
                        <td class="text-start text-nowrap">
                            ${value.status == '1' ? 
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editYoutube(${value.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteYoutubeConfirm(${value.id})">
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
    $("#listing_table_body").html(html);
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
            // { extend: "copy", className: "btn btn-copy", text: "Copy" },
            // { extend: "csv", className: "btn btn-csv", text: "CSV" },
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            // { extend: "pdf", className: "btn btn-pdf", text: "PDF" },
            // { extend: "print", className: "btn btn-print", text: "Print" },
            // { 
            //     text: "Refresh", 
            //     className: "btn btn-refresh", 
            //     action: function () { 
            //         console.log("Refresh button clicked");
            //         $("#resetFilterButton").click(); 
            //         getYoutubePageData(); 
            //         // resetFilterButton click


                    
            //     } 
            // }
        ],
    });
}

function addNewYoutube(){
    tempId = '';
    resetYoutubeForm();
    $('#addYoutube_canvas').addClass('show');
}

$(document).on('click', '.closeCanvas', function (e) {
	tempId = '';
	resetYoutubeForm();
    $('#addYoutube_canvas').removeClass('show');
});

function resetYoutubeForm(){
    tempId = '';
    let form = $('#newsYoutube_form');
    $('#youtube_id').val('');
	form.trigger("reset");
}


// saveYoutube();
function saveYoutube(){

    let type = 'POST';
    let url = '/saveYoutube';
    let message = '';
    let form = $('#newsYoutube_form');
    let data = new FormData(form[0]);
    // PASSING DATA TO FUNCTION
    $('input, select').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveYoutubeResponse, '', '#saveYoutube_btn');
}

function saveYoutubeResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetYoutubeForm();
        getYoutubePageData();
        $('#addYoutube_canvas').removeClass('show');
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

function editYoutube(id){

    let type = 'POST';
    let url = '/getSpecificYoutube';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('youtube_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editYoutubePlaylistResponse, '', '');
}

function editYoutubePlaylistResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        var youtubeDetail = response.youtube;
        
        if(youtubeDetail != null){
            $("#youtube_id").val(youtubeDetail.id);
            $("#playlist_id").val(youtubeDetail.playlist_id);
            $("#playlist_title").val(youtubeDetail.playlist_title);
            // status
            $("#status").val(youtubeDetail.status);
            $('#addYoutube_canvas').addClass('show');
        }
    } 
}

var tempId = '';
function deleteYoutubeConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteYoutubeConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

function deleteYoutubeConfirmed(){

    let type = 'POST';
    let url = '/deleteYoutubePlaylist';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('youtube_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteYoutubeConfirmedResponse, '', '');
}

function deleteYoutubeConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        tempId = '';
        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        
        getYoutubePageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}


$(document).on('change', 'input, textarea, select', function (e) {
	$(this).removeClass('is-invalid');
});

$(document).ready(function () {

    getYoutubePageData();
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
// focus out from palylist_id then send request
$(document).on('focusout', '#playlist_id', function (e) {
    let type = 'POST';
    let url = 'api/getPlaylist';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('playlist_id', $(this).val());
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getYoutubePlaylistDataResponse, '', '');
});
function getYoutubePlaylistDataResponse(response) {
    console.log('Response:', response); // For debugging
    
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
        var youtubeDetail = response.channels;
        
        if (youtubeDetail && 
            youtubeDetail.original && 
            youtubeDetail.original.channel && 
            youtubeDetail.original.channel.snippet) {
            
            $("#playlist_title").val(youtubeDetail.original.channel.snippet.title);
            // enable submit button
            $('#saveYoutube_btn').removeAttr('disabled');
        } else {
            // disable submit button
            $('#saveYoutube_btn').attr('disabled', 'disabled');
            toastr.error('Channel not found', '', {
                timeOut: 3000
            });
        }
    }
}

