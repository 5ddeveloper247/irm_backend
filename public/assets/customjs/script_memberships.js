function getMembershipsPageData(formValues = {}){
    let type = 'POST';
    let url = '/getMembershipsPageData';
    let data = new FormData();
    
    // ADD FORM VALUES TO DATA
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    
    // Add CSRF token
    data.append('_token', $('meta[name="csrf-token"]').attr('content'));
    
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getMembershipsPageDataResponse, '', '');
}

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove();
        var value = $(this).val().toLowerCase();
    
        $("#memberships_table_body tr").each(function () {
            var row = $(this);
            var hasMatch = false;
    
            row.find("td").each(function () {
                var cell = $(this);
                if (cell.text().toLowerCase().indexOf(value) > -1) {
                    cell.addClass("table-highlight");
                    hasMatch = true;
                } else {
                    cell.removeClass("table-highlight");
                }
            });
    
            row.toggle(hasMatch);
        });
    
        if ($("#memberships_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="9">No result found</td>
                </tr>`;
            $("#memberships_table_body").append(no_result_row);
        }
        
        if($(this).val() == ''){
            $(".no_result_row").remove();
            $("#memberships_table_body tr td").removeClass("table-highlight");
        }
    });
});

function getMembershipsPageDataResponse(response) {
    if (response.status == 200 || response.status == '200') {
        var data = response.data;
        var membershipsList = data.memberships_list;
        makeMembershipsListing(membershipsList);
    } 
}

function makeMembershipsListing(membershipsList){
    console.log(membershipsList);
   
    var html = '';
    
    // Datatable destroy if already created
    if ($.fn.DataTable.isDataTable('#memberships_table')) {
        $('#memberships_table').DataTable().destroy();
        $("#memberships_table_body").html('');
    }
    
    if (membershipsList.length > 0) {
        $.each(membershipsList, function (index, membership) {
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${(membership?.membership_type || 'N/A').toUpperCase()}</td>
                        <td class="text-start text-nowrap">${membership.username || 'N/A'}</td>
                        <td class="text-start text-nowrap">${membership.email || 'N/A'}</td>
                        <td class="text-start text-nowrap">${membership.phone || 'N/A'}</td>
                        <td class="text-start text-nowrap">${membership.city || 'N/A'}</td> 
                        <td class="text-start text-nowrap">${membership?.country?.name || 'N/A'}</td> 
                        <td class="text-start text-nowrap">${formatDate(membership.created_at)}</td>
                        <td class="text-start text-nowrap">
                        <div class="d-flex gap-2">
                            <button type="button" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="viewMember(${membership.id})">View</button>
                            
                        </div>
                            </td>
                    </tr>`;
        });
    } else {
        html = '<tr><td colspan="9" class="text-center">No memberships found</td></tr>';
    }
    
    $("#memberships_table_body").html(html);
    
    // Initialize DataTables
    if(userRole == 1){
        $('#memberships_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "scrollX": true,
            "language": {
                search: "_INPUT_",
                searchPlaceholder: "Search",
            },
            'dom': 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-excel',
                    text: 'Excel'
                },
                {
                    text: 'Refresh',
                    className: 'btn btn-refresh',
                    action: function (e, dt, node, config) {
                        getMembershipsPageData();
                        $('#resetFilterButton').click();
                    }
                }
            ],
        });
    }else{
        $('#memberships_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "scrollX": true,
            "language": {
                search: "_INPUT_",
                searchPlaceholder: "Search",
            },
            'dom': 'Bfrtip',
            buttons: [
                {
                    text: 'Refresh',
                    className: 'btn btn-refresh',
                    action: function (e, dt, node, config) {
                        getMembershipsPageData();
                        $('#resetFilterButton').click();
                    }
                }
            ],
        });
    }

}

$(document).ready(function () {
    getMembershipsPageData();
});

$(document).on("click", ".closeCanvas", function (e) {
    $('#view_member_data').html('');
    $("#member_view_canvas").removeClass("show");
    $("#addMembership_canvas").removeClass("show");
});

// Add New Membership
function addNewMembership() {
    resetForm();
    $('#offcanvas_add_label').text('Add New Membership');
    $('#saveMembership_btn').text('Add');
    var offcanvasElement = document.getElementById('addMembership_canvas');
    var bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
    bsOffcanvas.show();
}

// View Member
function viewMember(id) {
    $.ajax({
        url: "/viewMember",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        },
        beforeSend: function() {
            $('.preloader').show();
        },
        success: function(response) {
            $('.preloader').hide();
            
            if (response.status == 200) {
                let member = response.data;
                let html = `
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <strong>Membership Type:</strong>
                            <p>${(member.membership_type || 'N/A').toUpperCase()}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Name:</strong>
                            <p>${member.username || '-'}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Email:</strong>
                            <p>${member.email || '-'}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Phone:</strong>
                            <p>${member.phone || '-'}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Country:</strong>
                            <p>${member.country ? member.country.name : '-'}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>City:</strong>
                            <p>${member.city || '-'}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Date:</strong>
                            <p>${formatDate(member.created_at)}</p>
                        </div>
                    </div>
                `;
                
                $('#view_member_data').html(html);
                var offcanvasElement = document.getElementById('member_view_canvas');
                var bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                bsOffcanvas.show();
            }
        },
        error: function(xhr) {
            $('.preloader').hide();
            toastr.error('Error loading membership details');
        }
    });
}


// Save Membership
function saveMembership() {
    let formData = new FormData($('#membership_form')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    
    // Check if we're updating or adding
    let isUpdate = $('#membership_id').val() ? true : false;
    let btnText = isUpdate ? 'Updating...' : 'Saving...';
    let successBtnText = isUpdate ? 'Update' : 'Add';
    
    $.ajax({
        url: "/saveMembership",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('#saveMembership_btn').prop('disabled', true).text(btnText);
        },
        success: function(response) {
            $('#saveMembership_btn').prop('disabled', false).text(successBtnText);
            
            if (response.status == 200) {
                toastr.success(response.message);
                var offcanvasElement = document.getElementById('addMembership_canvas');
                var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                bsOffcanvas.hide();
                resetForm();
                getMembershipsPageData();
            } else {
                toastr.error(response.message || 'Error saving membership');
            }
        },
        error: function(xhr) {
            $('#saveMembership_btn').prop('disabled', false).text(successBtnText);
            let message = xhr.responseJSON?.message || 'Error saving membership';
            toastr.error(message);
        }
    });
}


function editMembership(id) {
    $.ajax({
        url: "/viewMember",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        },
        beforeSend: function() {
            $('.preloader').show();
        },
        success: function(response) {
            $('.preloader').hide();
            
            if (response.status == 200) {
                let member = response.data;
                
                // Fill the form with member data
                $('#membership_id').val(member.id);
                $('#username').val(member.username);
                $('#email').val(member.email);
                $('#phone').val(member.phone);
                $('#country_id').val(member.country_id);
                $('#city').val(member.city);
                
                // Update offcanvas title and button
                $('#offcanvas_add_label').text('Edit Membership');
                $('#saveMembership_btn').text('Update');
                
                // Show the offcanvas
                var offcanvasElement = document.getElementById('addMembership_canvas');
                var bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                bsOffcanvas.show();
            } else {
                toastr.error(response.message || 'Member not found');
            }
        },
        error: function(xhr) {
            $('.preloader').hide();
            toastr.error('Error loading membership details');
        }
    });
}

// Reset Form
function resetForm() {
    $('#membership_form')[0].reset();
    $('#membership_id').val('');
}

// Format Date
function formatDate(dateString) {
    if (!dateString) return '-';
    let date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}