function getJoinUsPageData(formValues = {}) {
    let type = "POST";
    let url = "/getJoinUsPageData";
    let message = "";
    let form = "";
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
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

    // Ensure `joinUsList` is an array before proceeding
    if (!Array.isArray(joinUsList) || joinUsList.length === 0) {
        console.error("Invalid or empty joinUsList:", joinUsList);
        $("#join_us_table_body").html("<tr><td colspan='7' class='text-center'>No data available</td></tr>");
        return;
    }

    // Destroy existing DataTable to prevent errors
    if ($.fn.DataTable.isDataTable("#join_us_table")) {
        $("#join_us_table").DataTable().clear().destroy();
    }

    // Ensure table headers exist
    if ($("#join_us_table").find("thead").length === 0) {
        $("#join_us_table").append(`
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="join_us_table_body"></tbody>
        `);
    }

    // Build HTML for table rows
    var html = "";
    $.each(joinUsList, function (index, join) {
        let eye = join.message.length > 30
            ? join.message.substring(0, 30) + ' &nbsp;<i class="fa-regular fa-eye text-primary"></i>'
            : join.message;

        html += `<tr>
                    <td class="text-start">${index + 1}</td>
                    <td class="text-start">${join.name}</td>
                    <td class="text-start">${join.email}</td>
                    <td class="text-start">${join.phone}</td>
                    <td class="text-start">${join.subject}</td> 
                    <td class="text-start showDescriptions" style="cursor: pointer;" data-description="${join.message}">${eye}</td> 
                    <td class="text-start">${formatDate(join.created_at)}</td>
                </tr>`;
    });

    // Append rows to the table body
    $("#join_us_table_body").html(html);

    // Initialize DataTable with options
    $("#join_us_table").DataTable({
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
                    getJoinUsPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
}


// function makeJoin_usListing(joinUsList) {
//     console.log(joinUsList);
//     // join_us_table destroy and empty
//     if ($.fn.DataTable.isDataTable("#join_us_table")) {
//         $("#join_us_table").DataTable().destroy();
//         $("#join_us_table").empty();
//     }
//     // if ($.fn.DataTable.isDataTable('#memberships_table')) {
//     //     $('#memberships_table').DataTable().destroy();
//     //     $("#memberships_table_body").html('');
//     // }
//     var html = "";

//     if (joinUsList.length > 0) {
//         $.each(joinUsList, function (index, join) {
//             let eye = '<i class="fa-regular fa-eye"></i>';
//             eye =
//                 join.message.length > 30
//                     ? join.message.substring(0, 30) +
//                       ' &nbsp;<i class="fa-regular fa-eye text-primary"></i>'
//                     : join.message;
//             html += `<tr>
//                         <td class="text-start text-nowrap">${index + 1}</td>
//                         <td class="text-start text-nowrap">${join.name}</td>
//                         <td class="text-start text-nowrap">${join.email}</td>
//                         <td class="text-start text-nowrap">${join.phone}</td>
//                         <td class="text-start text-nowrap">${join.subject}</td> 
//                         <td style="cursor: pointer;" class="text-start text-nowrap showDescriptions" data-description="${
//                             join.message
//                         }">${eye}</td> 
//                         <td class="text-start text-nowrap">${formatDate(
//                             join.created_at
//                         )}</td>
                        
                        
//                     </tr>`;
//         });
       
//     }
//     $("#join_us_table_body").html(html);
//     $("#join_us_table").DataTable({
//         paging: true,
//         lengthChange: true,
//         searching: true,
//         // ordering: true,
//         info: true,
//         autoWidth: false,
//         responsive: true,
//         scrollX: true,
//         language: {
//             search: "_INPUT_",
//             searchPlaceholder: "Search",
//         },
//         // add export buttons
//         dom: "Bfrtip",
//         buttons: [
//             {
//                 extend: "copy",
//                 className: "btn btn-copy", // Custom class for Copy button
//                 text: "Copy",
//             },
//             {
//                 extend: "csv",
//                 className: "btn btn-csv", // Custom class for CSV button
//                 text: "CSV",
//             },
//             {
//                 extend: "excel",
//                 className: "btn btn-excel", // Custom class for Excel button
//                 text: "Excel",
//             },
//             {
//                 extend: "pdf",
//                 className: "btn btn-pdf", // Custom class for PDF button
//                 text: "PDF",
//             },
//             {
//                 extend: "print",
//                 className: "btn btn-print", // Custom class for Print button
//                 text: "Print",
//             },
//             {
//                 text: "Refresh",
//                 className: "btn btn-refresh", // Custom class for Refresh button
//                 action: function () {
//                     getJoinUsPageData(); // Refresh data
//                     // resetFilterButton click
//                     $("#resetFilterButton").click();
//                 },
//             },
//         ],
//     });

//     // setTimeout(function () {
//     //     $('#join_us_table').DataTable({
//     //         // add serch pan in table
//     //         "searching": true,
//     //         // pagination
//     //         "paging": true,
//     //     });
//     // }, 1000);
// }

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
