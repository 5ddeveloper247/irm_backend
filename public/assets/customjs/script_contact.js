function getContactPageData(formValues = {}){

    let type = 'POST';
    let url = '/getContactPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getContactPageDataResponse, '', '');
}
$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove();
        var value = $(this).val().toLowerCase();
        // when data not match then show no result found
        $("#contact_table_body tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        // when data not match then show no result found
        if ($("#contact_table_body tr:visible").length == 0) {
            var no_result_row = `<tr class="no_result_row">
                                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                                    </tr>`;
            $("#contact_table_body").append(no_result_row);
        } else {
            // remove no result found row
            $(".no_result_row").remove();        
        }
    });
});
function getContactPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        // console.log(response.data.contact_list);
        var data = response.data;

        var contactList = data.contact_list;
        // console.log(contactList);
        makeContactListing(contactList);
    } 
}

function makeContactListing(contactList){
    console.log(contactList);
   
    var html = '';
    if ($.fn.DataTable.isDataTable('#contact_table')) {
        $('#contact_table').DataTable().destroy();
    }
    if (contactList.length > 0) {
        $.each(contactList, function (index, contact) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${contact.name}</td>
                        <td class="text-start text-nowrap">${contact.email}</td>
                        <td class="text-start text-nowrap">${contact.phone}</td>
                        <td class="text-start text-nowrap">${contact.subject}</td> 
                        <td class="text-start text-nowrap">${contact.message.substring(0, 40)}...</td>
                        <td class="text-start text-nowrap">${formatDate(contact.created_at)}</td>
                        <td class="text-start text-nowrap">
                            <button type="button" class="btn btn-purple" onclick="editReplyContact(${contact.id})"><i class="fa-solid fa-reply"></i></button>
                        </td>
                        
                        
                    </tr>`;
        });
    }
    $("#contact_table_body").html(html);
    $("#contact_table").DataTable({
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
                    getContactPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
}

// Contact Reply
function editReplyContact(id){

    let type = 'POST';
    let url = '/getContactDetail';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', replyContact, '', '');
}

function replyContact(response) {
    console.log(response.status);
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        console.log(response.data);
        $('#replyContact_Canvas').addClass('show');
        var replyContactData = response.data;
        $('#contact_id').val(replyContactData.id);
        $('#contact_name').html("Customer Name: <b>"+replyContactData.name +"</b>");
        $('#contact_email').html("Customer Email: <b>"+replyContactData.email +"</b>");
        $('#contact_phone').html("Customer Phone: <b>"+replyContactData.phone +"</b>");
        $('#contact_subject').html("Subject: <b>"+replyContactData.subject +"</b>");
        $('#contact_message').html("Message: <b>"+replyContactData.message +"</b>");
        getReplyMessage(replyContactData);
    } 
}
function getReplyMessage(data) {
    let html = '';

    if (data.replies.length > 0) {
        $("#replies_label").html('Replies: <b>'+data.replies.length+' replies found</b>');
        for (let reply of data.replies) {
            let attachmentsHtml = '';
            
            for (let attachment of reply.attachments) {
                let placeholder, filePreview;
                switch (attachment.type) {
                    case 'application/pdf':
                        placeholder = '/assets/images/pdf-placeholder.png';
                        filePreview = `<a href="${attachment.path}" download><img src="${placeholder}" data-url="${attachment.path}" class="img-prev" /></a>`;
                        break;

                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/jpg':
                    case 'image/gif':
                    case 'image/bmp':
                    case 'image/webp':
                        filePreview = `<a href="${attachment.path}" download><img src="${attachment.path}" data-url="${attachment.path}" class="img-prev" /></a>`;
                        break;

                    case 'audio/mp3':
                    case 'audio/mpeg':
                    case 'audio/wav':
                    case 'audio/ogg':
                    case 'audio/m4a':
                    case 'audio/flac':
                    case 'audio/aac':
                    case 'audio/aiff':
                    case 'audio/wma':
                        placeholder = '/assets/images/audio-placeholder.png';
                        filePreview = `<a href="${attachment.path}" download><img src="${placeholder}" data-url="${attachment.path}" class="img-prev" /></a>`;
                        break;

                    default:
                        placeholder = '/assets/images/search-placeholder.png';
                        filePreview = `<a href="${attachment.path}" download><img src="${placeholder}" data-url="${attachment.path}" class="img-prev" /></a>`;
                }

                attachmentsHtml += `
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                ${filePreview}
                                <p class="card-title">${attachment.name.substring(0, 20)}</p>
                            </div>
                        </div>
                    </div>`;
            }

            html += `
                <div class="card mb-2">
                    <div class="card-header">
                        <h5 class="card-title">${reply.reply_message}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">${formatDate(reply.created_at)}</p>
                        <div class="row">
                            ${attachmentsHtml}
                        </div>
                    </div>
                </div>`;
        }

        $("#replies_container").html(html);
    }else{
        $("#replies_label").html('Replies: <b>No replies found</b>');
    }
}

// close canvas
$(document).on('click', '.closeCanvas', function (e) {
	// reset form
    $('#replyContact_Canvas').removeClass('show');
});
$(document).ready(function () {
    // datatables
    getContactPageData();
});

// add multiple pdf

var selectedFiles = [];
function displaySelectedFiles() {
    const $imageContainer = $('#file-container');
    $imageContainer.empty()
    if (selectedFiles.length < 8) {
        $imageContainer.empty() // Clear previous images
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader()
            reader.onload = function (e) {
                // get type of file
                const fileType = file.type;
                console.log(fileType);
                const $imageDiv = $('<div>').addClass('col-3 my-3')
                let $image = '';
                if(fileType == 'application/pdf'){
                    $image = $('<img>').attr('src', '/assets/images/pdf-placeholder.png').addClass('img-prev');
                    $imageDiv.append($image);
                }else if(fileType == 'image/jpeg' || fileType == 'image/png' || fileType == 'image/jpg' || fileType == 'image/gif' || fileType == 'image/bmp' || fileType == 'image/webp'){
                    $image = $('<img>').attr('src', e.target.result).addClass('img-prev');
                    $imageDiv.append($image);
                }
                else if(fileType == 'audio/mp3' || fileType == 'audio/mpeg' || fileType == 'audio/wav' || fileType == 'audio/ogg' || fileType == 'audio/m4a' || fileType == 'audio/flac' || fileType == 'audio/aac' || fileType == 'audio/aiff' || fileType == 'audio/wma'){
                    $image = $('<img>').attr('src', '/assets/images/audio-placeholder.png').addClass('img-prev');
                    $imageDiv.append($image);
                }
                else{
                    $image = $('<img>').attr('src', '/assets/images/search-placeholder.png').addClass('img-prev');
                    $imageDiv.append($image);
                }
                
                // const $image = $('<img>').attr('src', '/assets/images/pdf-placeholder.png').addClass('img-prev')
                // $imageDiv.append($image)
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
$(document).on('click', '#addPdf_btn', function (e) {
	$("#attachment_files").click();
});

$('#attachment_files').on('change', function (event) {
    const files = event.target.files;
    var allfileslength = files.length + selectedFiles.length;

    // Check if total files exceed the limit
    if (allfileslength > 7) {
        toastr.error('You can upload a maximum of 7 files.');
        // Clear the file input value to allow re-uploading the same file later
        $('#attachment_files').val('');
        return;
    }

    // Clear previous items in the container
    $('#file-container').empty();

    // Validate and add selected files to selectedFiles array
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileType = file.type;

        // Check if the file is an pdf of the allowed types
        // if (!fileType.match('application/pdf')) {
        //     toastr.error('Only pdf files are allowed.');
        //     continue;
        // }
        // Add the valid pdf file to the selectedFiles array
        selectedFiles.push(file);
    }

    // Display selected files
    displaySelectedFiles();
    // Clear the file input value to allow re-uploading the same file later
    $('#attachment_files').val('');
});
// pdf end
// reset form on close and reset image container
$(document).on('click', '.closeCanvas', function (e) {
    // reset form
    $('#form_reply_contact').trigger('reset');
    // reset image container
    $('#file-container').empty();
    selectedFiles = [];
    // remove is-invalid class from input fields
    $('input').removeClass('is-invalid');
    $('textarea').removeClass('is-invalid');
    $("#replies_container").html('');
});
// save replyContact
function saveReplyContact(){
    let type = 'POST';
    let url = '/saveRelyContact';
    let message = '';
    let form = $('#form_reply_contact');
    let data = new FormData(form[0]);
    if (selectedFiles.length > 0) {
        
        for (let i = 0; i < selectedFiles.length; i++) {
            
            data.append('attachment_files[]', selectedFiles[i]);
        }
    } else {
        data.append('attachment_files', '');
    }
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveReplyContactResponse, '', '#saveReplyContact_btn');
}
function saveReplyContactResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        // console.log(response.data);
        $('#replyContact_Canvas').removeClass('show');
        getContactPageData();
        toastr.success(response.message);
        $('.closeCanvas').trigger('click');
    } 
}
