function getPaymentsPageData(){

    let type = 'POST';
    let url = '/getPaymentsPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
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

function makePaymentsListing(paymentsList){
    console.log(paymentsList);
   
    var html = '';
   
    if (paymentsList.length > 0) {
        $.each(paymentsList, function (index, payment) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${payment.module_code}</td>
                        <td class="text-start text-nowrap">${payment.amount}</td>
                        <td class="text-start text-nowrap">${payment.payment_intent}</td>
                        <td class="text-start text-nowrap">${formatDate(payment.created_at)}</td>
                        <td class="text-start text-nowrap">
                            ${payment.status == "succeeded" ? 
                            '<span class="badge bg-success">Success</span>' 
                            : 
                            '<span class="badge bg-danger">Failed</span>'}
                            
                        </td>
                        
                    </tr>`;
        });
    }
    $("#payments_table_body").html(html);
    // datatables
    if ($.fn.DataTable.isDataTable('#payments_table')) {
        $('#payments_table').DataTable().destroy();
    }
    $('#payments_table').DataTable({
        dom: 'Bfrtip',
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
                text: 'Filter',
                className: 'btn btn-filter',  // Custom class for Filter button
                action: function (e, dt, node, config) {
                    $('#filters-header').toggle();  // Toggle filter header visibility
                }
            },
            {
                text: 'Refresh',
                className: 'btn btn-refresh',  // Custom class for Refresh button
                action: function (e, dt, node, config) {
                    getPaymentsPageData();  // Refresh data
                    $('#search_filter').val('');  // Reset search filter
                    $('.column-filter').val('');  // Clear column filters
                }
            }
        ],
        
        paging: true,
        searching: true,
        ordering: false,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
        },
        initComplete: function () {
            var api = this.api();

            // Apply filters for header & footer without duplication
            $('.column-filter').on('keyup change', function () {
                var columnIndex = $(this).closest('th').index();
                api.column(columnIndex).search(this.value).draw();
            });
        }
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