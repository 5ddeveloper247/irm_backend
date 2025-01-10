function getBlogsPageData(){

    let type = 'POST';
    let url = '/getBlogsPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getBlogsPageDataResponse, '', '');
}

function getBlogsPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var blogsList = data.blogs_list;
        
        makeBlogsListing(blogsList);
    } 
}

function makeBlogsListing(blogsList){
   
    var html = '';
   
    if (blogsList.length > 0) {
        $.each(blogsList, function (index, blog) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${blog.author_name}</td>
                        <td class="text-start text-nowrap">${blog.title}</td>
                        <td class="text-start text-nowrap">${formatDate(blog.published_date)}</td>
                        <td class="text-start text-nowrap">${formatDate(blog.end_date)}</td>
                        <td class="text-start text-nowrap">
                            ${blog.status == '1' ? 
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editBlog(${blog.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteBlogConfirm(${blog.id})">
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
    $("#blogs_table_body").html(html);
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

function addNewBlog(){
    resetBlogForm();
    $('#addBlog_canvas').addClass('show');
}

function resetBlogForm(){
    let form = $('#blog_form');
	form.trigger("reset");

    editorInstance.blog_description.setData('');
    $("#blog_id, #thumbnail_file").val('');
    $(".thumbnail_preview").attr('src', '').hide();
}

$(document).on('click', '.closeCanvas', function (e) {
	resetBlogForm();
    $('#addBlog_canvas').removeClass('show');
});

function saveBlog(){

    let type = 'POST';
    let url = '/saveBlog';
    let message = '';
    let form = $('#blog_form');
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveBlogResponse, '', '#saveBlog_btn');
}

function saveBlogResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {

        resetBlogForm();
        getBlogsPageData();
        $('#addBlog_canvas').removeClass('show');
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


function editBlog(id){

    let type = 'POST';
    let url = '/getSpecificBlog';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('blog_id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', editBlogResponse, '', '');
}

function editBlogResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        var data = response.data;

        var blogDetail = data.blog_detail;
        
        if(blogDetail != null){
            $("#blog_id").val(blogDetail.id);
            $("#blog_author_name").val(blogDetail.author_name);
            $("#blog_title").val(blogDetail.title);
            $("#blog_tags").val(blogDetail.tags);
            $("#blog_description").val(blogDetail.description);
            editorInstance.blog_description.setData(blogDetail.description);
            $("#blog_published_date").val(blogDetail.published_date);
            $("#blog_end_date").val(blogDetail.end_date);
            $("#blog_status").val(blogDetail.status);

            if(blogDetail.thumbnail != null){
                $(".thumbnail_preview").attr('src', blogDetail.thumbnail).show();
            }else{
                $(".thumbnail_preview").attr('src', '').hide();
            }

            $('#addBlog_canvas').addClass('show');
        }
    } 
}

var tempId = '';
function deleteBlogConfirm(id){
    tempId = id;
    $("#deleteConfirm_btn").attr('onclick', 'deleteBlogConfirmed()');
    $("#delete_confirm_modal").modal('show');
}

$(document).on('click', '#close_confirm', function (e) {
    tempId = '';
    $("#deleteConfirm_btn").attr('onclick', '');
	$("#delete_confirm_modal").modal('hide');
});

function deleteBlogConfirmed(){

    let type = 'POST';
    let url = '/deleteBlog';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('blog_id', tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', deleteBlogConfirmedResponse, '', '');
}

function deleteBlogConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        $("#deleteConfirm_btn").attr('onclick', '');
        $("#delete_confirm_modal").modal('hide');
        tempId = '';

        getBlogsPageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } 
}


$(document).on('change', 'input, textarea, select', function (e) {
	$(this).removeClass('is-invalid');
});

$(document).ready(function () {

    getBlogsPageData();
});

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#blogs_table_body tr").each(function () {
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
        if ($("#blogs_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#blogs_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#blogs_table_body tr td").removeClass("table-highlight");
        }
    });
});