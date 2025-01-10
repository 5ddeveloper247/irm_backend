function getMembershipsPageData(){

    let type = 'POST';
    let url = '/getMembershipsPageData';
    let message = '';
    let form = '';
    let data = new FormData();
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
   
    if (membershipsList.length > 0) {
        $.each(membershipsList, function (index, membership) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${membership.username}</td>
                        <td class="text-start text-nowrap">${membership.email}</td>
                        <td class="text-start text-nowrap">${membership.phone}</td>
                        <td class="text-start text-nowrap">${membership.city}</td> 
                        <td class="text-start text-nowrap">${membership.country.name}</td> 
                        <td class="text-start text-nowrap">${formatDate(membership.created_at)}</td>
                        
                        
                    </tr>`;
        });
    }
    $("#memberships_table_body").html(html);
    // setTimeout(function () {
    //     $('#memberships_table').DataTable({
    //         // add serch pan in table
    //         "searching": true,
    //         // pagination
    //         "paging": true,
    //     });
    // }, 1000);
}

$(document).ready(function () {
    // datatables
    getMembershipsPageData();
});