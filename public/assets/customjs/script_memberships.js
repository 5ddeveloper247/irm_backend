function getMembershipsPageData(formValues = {}){

    let type = 'POST';
    let url = '/getMembershipsPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // ADD FORM VALUES TO DATA
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getMembershipsPageDataResponse, '', '');
}
// $(document).ready(function () {
//     $('#search_filter').on('keyup', function () {
//         var value = $(this).val().toLowerCase();
//         $("#memberships_table_body tr").filter(function () {
//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//         });
//     });
// });
$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#memberships_table_body tr").each(function () {
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
        if ($("#memberships_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#memberships_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#memberships_table_body tr td").removeClass("table-highlight");
        }
    });
});
function getMembershipsPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        // console.log(response.data.membership_list);
        var data = response.data;

        var membershipsList = data.memberships_list;
        // console.log(membershipsList);
        makeMembershipsListing(membershipsList);
    } 
}

function makeMembershipsListing(membershipsList){
    console.log(membershipsList);
   
    var html = '';
    // datatable destroy if already created
    if ($.fn.DataTable.isDataTable('#memberships_table')) {
        $('#memberships_table').DataTable().destroy();
        $("#memberships_table_body").html('');
    }
    if (membershipsList.length > 0) {
        $.each(membershipsList, function (index, membership) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${(membership?.membership_type || 'N/A').toUpperCase()}</td>
                        <td class="text-start text-nowrap">${membership.username}</td>
                        <td class="text-start text-nowrap">${membership.email}</td>
                        <td class="text-start text-nowrap">${membership.phone}</td>
                        <td class="text-start text-nowrap">${membership.city}</td> 
                        <td class="text-start text-nowrap">${membership.country.name}</td> 
                        <td class="text-start text-nowrap">${formatDate(membership.created_at)}</td>
                        <td class="text-start text-nowrap">
                            <button type="button" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="viewMember(${membership.id})">View</button>
                        </td>
                        
                        
                    </tr>`;
        });
        $("#memberships_table_body").html(html);
        // datatables
        
    }
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
        // add export buttons
        'dom': 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-copy',  // Custom class for Copy button
                text: 'Copy'
            },
            {
                extend: 'csv',
                className: 'btn btn-csv',  // Custom class for CSV button
                text: 'CSV'
            },
            {
                extend: 'excel',
                className: 'btn btn-excel',  // Custom class for Excel button
                text: 'Excel'
            },
            {
                extend: 'pdf',
                className: 'btn btn-pdf',  // Custom class for PDF button
                text: 'PDF'
            },
            {
                extend: 'print',
                className: 'btn btn-print',  // Custom class for Print button
                text: 'Print'
            },
            {
                text: 'Refresh',
                className: 'btn btn-refresh',  // Custom class for Refresh button
                action: function (e, dt, node, config) {
                    getMembershipsPageData();  // Refresh data
                    // resetFilterButton click
                    $('#resetFilterButton').click();
                    
                }
            }
        ],
    });
}

$(document).ready(function () {
    // datatables
    getMembershipsPageData();
});

$(document).on("click", ".closeCanvas", function (e) {
    // view_member_data
    $('#view_member_data').html('');
    $("#member_view_canvas").removeClass("show");
});
// viewMember
function viewMember(id){
    console.log(id);
    let type = 'POST';
    let url = '/viewMember';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', viewMemberResponse, '', '');
}
function viewMemberResponse(response){
    console.log(response);
    if (response.status == 200  || response.status == '200') {
        // member_view_canvas open canvas
        $('#member_view_canvas').addClass('show');
        var member = response.data;
        var html = '';
        // write form read only data use floating label
        // console.log(member.membership_type);
        if(member.membership_type == "active"){
            html = `<div class="row g-3">
                        
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.username ?? 'N/A'}" readonly>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="floatingInput" placeholder="" value="${member.email  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating">

                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.phone  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Phone</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.city  ?? 'N/A'}" readonly>
                            <label for="floatingInput">City</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.country.name  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Country</label>
                        </div>
                        <div class="">
                        <label for="floatingTextarea">Message</label>
                            <textarea class="form-control" rows="10" id="floatingTextarea" placeholder="" readonly>${member.message  ?? 'N/A'}</textarea>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.education  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Education</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${formatDate(member.date_of_birth)  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Date of Birth</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.cnic_number  ?? 'N/A'}" readonly>
                            <label for="floatingInput">CNIC Number</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.whatsapp_number  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Whatsapp Number</label>
                        </div>
                        <div class="form-floating">


                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.tehsil  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Tehsil</label>
                        </div>
                        <div class="form-floating">

                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.district  ?? 'N/A'}" readonly>
                            <label for="floatingInput">District</label>
                        </div>
                        <div class="form-floating">
                        
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.province  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Province</label> 
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.permanent_address  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Permanent Address</label>
                        </div>
                        <div class="form-floating">

                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.present_address  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Present Address</label>
                        </div>
                    </div>`;
        }else{
            html = `<div class="row g-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.username ?? 'N/A'}" readonly>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="floatingInput" placeholder="" value="${member.email  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.phone  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Phone</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.city  ?? 'N/A'}" readonly>
                            <label for="floatingInput">City</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="" value="${member.country.name  ?? 'N/A'}" readonly>
                            <label for="floatingInput">Country</label>
                        </div>
                        <div class="">
                        <label for="floatingTextarea">Message</label>
                            <textarea class="form-control" rows="10" id="floatingTextarea" placeholder="" readonly>${member.message  ?? 'N/A'}</textarea>
                            
                        </div>
                    </div>`;
        }
        $("#view_member_data").html(html);
    }
}