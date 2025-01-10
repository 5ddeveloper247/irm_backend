function getJoinUsPageData() {
    let type = "POST";
    let url = "/getJoinUsPageData";
    let message = "";
    let form = "";
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        getJoinUsPageDataResponse,
        "",
        ""
    );
}
// $(document).ready(function () {
//     $('#search_filter').on('keyup', function () {
//         var value = $(this).val().toLowerCase();
//         $("#join_us_table_body tr").filter(function () {
//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//         });
//     });
// });
$(document).ready(function () {
    $("#search_filter").on("keyup", function () {
        $(".no_result_row").remove();
        var value = $(this).val().toLowerCase();
        // when data not match then show no result found
        $("#join_us_table_body tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
        // when data not match then show no result found
        if ($("#join_us_table_body tr:visible").length == 0) {
            var no_result_row = `<tr class="no_result_row">
                                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                                    </tr>`;
            $("#join_us_table_body").append(no_result_row);
        } else {
            // remove no result found row
            $(".no_result_row").remove();
        }
    });
});
function getJoinUsPageDataResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        // console.log(response.data.join_list);
        var data = response.data;

        var joinUsList = data.join_list;
        // console.log(joinUsList);
        makeJoin_usListing(joinUsList);
    }
}

function makeJoin_usListing(joinUsList) {
    console.log(joinUsList);

    var html = "";

    if (joinUsList.length > 0) {
        $.each(joinUsList, function (index, join) {
            let eye = '<i class="fa-regular fa-eye"></i>';
            eye = join.message.length > 30 ? join.message.substring(0, 30) + ' &nbsp;<i class="fa-regular fa-eye text-primary"></i>' : join.message;
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${join.name}</td>
                        <td class="text-start text-nowrap">${join.email}</td>
                        <td class="text-start text-nowrap">${join.phone}</td>
                        <td class="text-start text-nowrap">${join.subject}</td> 
                        <td style="cursor: pointer;" class="text-start text-nowrap showDescriptions" data-description="${
                            join.message
                        }">${eye}</td> 
                        <td class="text-start text-nowrap">${formatDate(
                            join.created_at
                        )}</td>
                        
                        
                    </tr>`;
        });
    }
    $("#join_us_table_body").html(html);
    // setTimeout(function () {
    //     $('#join_us_table').DataTable({
    //         // add serch pan in table
    //         "searching": true,
    //         // pagination
    //         "paging": true,
    //     });
    // }, 1000);
}

$(document).ready(function () {
    // datatables
    getJoinUsPageData();
});
$(document).on("click", ".showDescriptions", function () {
    console.log("dfdf");
    var description = $(this).data("description");
    toastr.info(description, "Descriptions", {
        timeOut: 8000,
    });
});
