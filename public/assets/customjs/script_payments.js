function getPaymentsPageData(formValues = {}){

    let type = 'POST';
    let url = '/getPaymentsPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getPaymentsPageDataResponse, '', '');
}

function getPaymentsPageDataResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        // console.log(response.data.payment_list);
        var data = response.data;

        var paymentsList = data.payment_list;
        // console.log(paymentsList);
        makePaymentsListing(paymentsList);
    } 
}

function getStatusBadge(status) {
    const statusLower = status ? status.toLowerCase() : '';
    
    switch (statusLower) {
        case 'succeeded':
        case 'success':
        case 'completed':
        case 'paid':
            return '<span class="badge bg-success text-white">Success</span>';
        
        case 'failed':
        case 'failure':
        case 'error':
        case 'declined':
            return '<span class="badge bg-danger text-white">Failed</span>';
        
        case 'pending':
        case 'processing':
        case 'in_progress':
            return '<span class="badge bg-warning text-dark">Pending</span>';
        
        case 'cancelled':
        case 'canceled':
        case 'voided':
            return '<span class="badge bg-secondary text-white">Cancelled</span>';
        
        
        
        case 'requires_action':
        case 'requires_confirmation':
        case 'requires_payment_method':
            return '<span class="badge bg-primary text-white">Action Required</span>';
        
        default:
            return '<span class="badge bg-light text-dark">Unknown</span>';
    }
}


function makePaymentsListing(paymentsList){
    
    var html = '';
    if ($.fn.DataTable.isDataTable('#payments_table')) {
        $('#payments_table').DataTable().destroy();
    }
    if (paymentsList.length > 0) {
        $.each(paymentsList, function (index, payment) {
            var paymentData = JSON.parse(payment.data);
            console.log(paymentData);
            // Extract required values
            // var firstName = paymentData?.donatation_submit?.firstName || 'N/A';
            var firstName = payment?.non_member != null ? payment?.non_member : payment?.data2?.donatation_submit.firstName || 'N/A';
            var lastName = payment?.non_member != null ? '' : payment?.data2?.donatation_submit.lastName || 'N/A';
            // var lastName = paymentData?.donatation_submit?.lastName || 'N/A';
            var email = paymentData?.donatation_submit?.email || 'N/A';

            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        
                        <td class="text-start text-nowrap">${payment.module_title || 'N/A'}</td>
                        <td class="text-start text-nowrap">${payment.module_code}</td>
                        <td class="text-start text-nowrap">${payment.amount}</td>
                        <td class="text-start text-nowrap">${payment.payment_intent}</td>
                        <td class="text-start text-nowrap">${firstName} ${lastName}</td>
                        <td class="text-start text-nowrap">${email}</td>
                        <td class="text-start text-nowrap">${formatDate(payment.created_at)}</td>
                        <td class="text-start text-nowrap">
        ${getStatusBadge(payment.status)}
    </td>
                        
                    </tr>`;
        });
    }
    $("#payments_table_body").html(html);
    // datatables
    if ($.fn.DataTable.isDataTable('#payments_table')) {
        $('#payments_table').DataTable().destroy();
    }
    $("#payments_table").DataTable({
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
                    getPaymentsPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });

    // Prevent duplicate header filters in responsive mode
    $('.filter-row').clone().appendTo('#payments_table thead').hide();
    // datatables end
}

$(document).ready(function () {

    getPaymentsPageData();
});

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#payments_table_body tr").each(function () {
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
        if ($("#payments_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#payments_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#payments_table_body tr td").removeClass("table-highlight");
        }
    });
});