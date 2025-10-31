$(document).ready(function () {
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        getBookOrdersPageData();
    });
})
function getBookOrdersPageData(formValues = {}){
    // alert('getBookOrdersPageData');

    let type = 'POST';
    let url = '/getBookOrders';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getBookOrdersPageDataResponse, '', '');
}

function getBookOrdersPageDataResponse(response) {
    // console.log(response);
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        // console.log(response.data.book_orders);
        var data = response.data;
        console.log(data);
        var bookOrdersList = data.book_orders;
        // console.log(bookOrdersList);
        makeBookOrdersListing(bookOrdersList);
        BookPaymentsListing(response.payments);
    } 
}
function BookPaymentsListing(payments) {
    console.log(payments);  
    var html = "";
    // empty
    $("#payment_table_body").html('');
    if (payments.length > 0) {
        $.each(payments, function (index, payment) {
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${
                            payment?.book?.title ?? ""
                        }</td>
                        <td class="text-start text-nowrap">${
                            payment?.amount ?? ""
                        }</td>
                        <td class="text-start text-nowrap">${
                            payment?.payment?.payment_intent ?? "MANUAL PAYMENT"
                        }</td>
                        <td class="text-start text-nowrap">${formatDate(
                            payment?.created_at ?? ""
                        )}</td>
                        <td class="text-start text-nowrap">
                            ${
                                payment?.payment?.status == "succeeded"
                                    ? '<span class="badge bg-success">Success</span>'
                                    : '<span class="badge bg-danger">Failed</span>'
                            }
                            
                        </td>
                    </tr>`;
        });
    }
    
    // destroy datatable if already created
    if ($.fn.DataTable.isDataTable("#payment_table")) {
        $("#payment_table").DataTable().destroy().clear();
    }
    $("#payment_table_body").html(html);
    $("#payment_table").DataTable({
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
                    getBookOrdersPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
    // destroy datatable if already created
    // if ($.fn.DataTable.isDataTable("#payment_table")) {
    //     $("#payment_table").DataTable().destroy();
    // }
    // if (campaignPayments.length > 0) {
    //     // payment_table datatable
    //     $("#payment_table").DataTable({
    //         paging: false,
    //         lengthChange: false,
    //         searching: true,
    //         info: true,
    //         scrollY: "400px",
    //         scrollCollapse: true,
    //         responsive: true,
    //     });
    // }
}
function makeBookOrdersListing(bookOrdersList){
    console.log(bookOrdersList);
   
    var html = '';
    var htmlPending = '';
    var htmlDelivered = '';
    var htmlShipped = '';
    var htmlCompleted = '';
    $("#bookOrders_table_body").html('');
    $("#pending_table_body").html('');
    $("#delivered_table_body").html('');
    $("#shipped_table_body").html('');
    $("#completed_table_body").html('');

    // 	status => 1:pendding, 2:shipped, 3:delivered, 4:completed	
    if (bookOrdersList.length > 0) {
        $.each(bookOrdersList, function (index, bookOrder) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${bookOrder?.book?.title}</td>
                        <td class="text-start text-nowrap">${bookOrder.amount}</td>
                        <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName + " " + bookOrder.json_data.shipping.lastName}</td>
                        <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                        <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                        <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                        <td class="text-start text-nowrap">${bookOrder.action}</td>
                        
                    </tr>`;
                    // pending
                    if(bookOrder.status == 1){
                        htmlPending += `<tr>
                            <td class="text-start text-nowrap">${index+1}</td>
                            <td class="text-start text-nowrap">${bookOrder?.book?.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName  + " " + bookOrder.json_data.shipping.lastName}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                            <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                            <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                            <td class="text-start text-nowrap">${bookOrder.action}</td>
                        </tr>`;
                    }
                    // pending end
                    // delivered
                    if(bookOrder.status == 3){
                        htmlDelivered += `<tr>
                            <td class="text-start text-nowrap">${index+1}</td>
                            <td class="text-start text-nowrap">${bookOrder?.book?.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName  + " " + bookOrder.json_data.shipping.lastName}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                            <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                            <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                            <td class="text-start text-nowrap">${bookOrder.action}</td>
                        </tr>`;
                    }
                    // delivered end
                    // shipped
                    if(bookOrder.status == 2){
                        htmlShipped += `<tr>
                            <td class="text-start text-nowrap">${index+1}</td>
                            <td class="text-start text-nowrap">${bookOrder?.book?.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName  + " " + bookOrder.json_data.shipping.lastName}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                            <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                            <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                            <td class="text-start text-nowrap">${bookOrder.action}</td>
                        </tr>`;
                    }
                    // shipped end
                    // completed
                    if(bookOrder.status == 4){
                        htmlCompleted += `<tr>
                            <td class="text-start text-nowrap">${index+1}</td>
                            <td class="text-start text-nowrap">${bookOrder?.book?.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName  + " " + bookOrder.json_data.shipping.lastName}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                            <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                            <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                            <td class="text-start text-nowrap">${bookOrder.action}</td>
                        </tr>`;
                    }
                    // completed end

        });
    }
    // console.log("html",html);
    
    
    if ($.fn.DataTable.isDataTable('#bookOrders_table')) {
        $('#bookOrders_table').DataTable().destroy().clear();
    }
    $("#bookOrders_table_body").html(html);
    $("#bookOrders_table").DataTable({
        paging: true,
        bDestroy:true,
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
                    getBookOrdersPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
    // pending
    
    if ($.fn.DataTable.isDataTable('#pending_table')) {
        $('#pending_table').DataTable().destroy().clear();
    }
    $("#pending_table_body").html(htmlPending);
    $("#pending_table").DataTable({
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
                    getBookOrdersPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });

    // pending end
    // delivered 
    
    if ($.fn.DataTable.isDataTable('#delivered_table')) {
        $('#delivered_table').DataTable().destroy();
    }
    $("#delivered_table_body").html(htmlDelivered);
    $("#delivered_table").DataTable({
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
                    getBookOrdersPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
    // delivered end
    // shipped
    
    if ($.fn.DataTable.isDataTable('#shipped_table')) {
        $('#shipped_table').DataTable().destroy();
    }
    $("#shipped_table_body").html(htmlShipped);
    $("#shipped_table").DataTable({
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
                    getBookOrdersPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
    // shipped end
    // completed
    
    if ($.fn.DataTable.isDataTable('#completed_table')) {
        $('#completed_table').DataTable().destroy();
    }
    $("#completed_table_body").html(htmlCompleted);
    $("#completed_table").DataTable({
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
                    getBookOrdersPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
    // completed end
}
var bookOrderTempId = '';
var bookOrderOpenDetailsPage = false;
function statusUpdateBookOrderConfirm(id){
    bookOrderTempId = id;
    $("#bookOrderConfirm_btn").attr('onclick', 'bookOrderConfirmed()');
    $("#orderBook_confirm_modal").modal('show');
}

$(document).on('click', '#close_confirm', function (e) {
    bookOrderTempId = '';
    $("#bookOrderConfirm_btn").attr('onclick', '');
	$("#orderBook_confirm_modal").modal('hide');
});

function bookOrderConfirmed(){

    let type = 'POST';
    let url = '/changeStatus';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('id', bookOrderTempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', bookOrderConfirmedResponse, '', '');
}

function bookOrderConfirmedResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {

        $("#bookOrderConfirm_btn").attr('onclick', '');
        $("#orderBook_confirm_modal").modal('hide');
        bookOrderTempId = '';

        getBookOrdersPageData();
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        if (bookOrderOpenDetailsPage) {
            closeOrderDetailsPage();
        }
    } 
}
// viewBookOrder
// Updated viewBookOrder function
function viewBookOrder(id){
    let type = 'POST';
    let url = '/viewBookOrder';
    let data = new FormData();
    data.append('id', id);
    
    SendAjaxRequestToServer(type, url, data, '', viewBookOrderResponse, '', '');
}

// Updated response handler with modal
function viewBookOrderResponse(response) {
    if (response.status == 200 || response.status == '200') {
        var bookOrder = response.data;
        
        // Populate modal with book order details
        $('#view_order_id').text(bookOrder.id);
        $('#view_book_name').text(bookOrder.book.title);
        $('#view_book_price').text('PKR ' + bookOrder.book.price);
        $('#view_order_status').html(bookOrder.statusNameWithBadge);
        $('#view_order_date').text(formatDate(bookOrder.created_at));
        $('#view_order_payment_method').text(bookOrder.payment_method);
        
        // Customer info
        if(bookOrder.json_data && bookOrder.json_data.shipping) {
            var shipping = bookOrder.json_data.shipping;
            $('#view_order_customer_name').text(
                (shipping.firstName || '') + ' ' + (shipping.lastName || '')
            );
            $('#view_order_customer_email').text(shipping.email || 'N/A');
            $('#view_order_customer_phone').text(shipping.phoneNumber || 'N/A');
            $('#view_order_customer_address').text(
                (shipping.streetAddress || '') + ', ' + 
                (shipping.city || '') + ', ' + 
                (shipping.country || '')
            );
        }
        
        // Payment info
        if(bookOrder.payment) {
            $('#view_order_payment_status').html(getPaymentStatusBadge(bookOrder.payment.status));
            $('#view_order_payment_amount').text('PKR ' + bookOrder.payment.amount);
            $('#view_order_payment_date').text(formatDate(bookOrder.payment.created_at));
            
            // Receipt section (if available)
            if(bookOrder.payment.receipt_path) {
                $('#order_receipt_section').show();
                $('#order_receipt_name').text(bookOrder.payment.receipt_name || 'Receipt');
                
                var receiptUrl = bookOrder.payment.receipt_url;
                $('#download_order_receipt_btn').attr('href', receiptUrl);
                $('#download_order_receipt_btn').attr('download', bookOrder.payment.receipt_name);
                
                var isImage = bookOrder.payment.is_image;
                $('#view_order_receipt_btn').attr('onclick', `openOrderReceipt('${receiptUrl}', ${isImage})`);
                
                if(isImage) {
                    $('#order_receipt_preview').html(`
                        <img src="${receiptUrl}" 
                             class="img-fluid rounded cursor-pointer" 
                             style="max-height: 200px; cursor: pointer;"
                             onclick="openOrderReceipt('${receiptUrl}', true)" />
                    `);
                } else if(bookOrder.payment.is_pdf) {
                    $('#order_receipt_preview').html(`
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                            <p class="mb-0">PDF Document</p>
                        </div>
                    `);
                }
            } else {
                $('#order_receipt_section').hide();
            }
        }
        
        // Action buttons in footer
        $('#view_order_action_section').html(bookOrder.action);
        
        // Show modal
        $('#view_bookorder_modal').modal('show');
    }
}

// Helper function for payment status badge
function getPaymentStatusBadge(status) {
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
        
        default:
            return '<span class="badge bg-light text-dark">' + status + '</span>';
    }
}

// Open receipt in new tab or modal
function openOrderReceipt(url, isImage) {
    if(isImage) {
        $('#order_receipt_image_modal_img').attr('src', url);
        $('#order_receipt_image_modal').modal('show');
    } else {
        window.open(url, '_blank');
    }
}
function closeOrderDetailsPage(){
    bookOrderOpenDetailsPage = false;
    $('#order-detials-page').slideUp();
    $("#bookOrders-page").slideDown();
    // myTab
    $('#myTab').slideDown();
    resetBookOrderDetails();
}
function resetBookOrderDetails(){
    
    $("#bookName").text('');
    $("#date").text('');
    $("#price").text('');
    $("#paymentMethod").text('');
    $("#name").text('');
    $("#email").text('');
    $("#paymentStatus").text('');
    $("#phone").text('');
    $("#paymentDate").text('');
    $("#address").text('');
    $("#paymentAmount").text('');
    $("#status").text('');
}
$(document).ready(function () {

    getBookOrdersPageData();
});

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#bookOrders_table_body tr").each(function () {
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
        if ($("#bookOrders_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#bookOrders_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#bookOrders_table_body tr td").removeClass("table-highlight");
        }
    });
    $('#search_filter_2').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#pending_table_body tr").each(function () {
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
        if ($("#pending_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#pending_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#pending_table_body tr td").removeClass("table-highlight");
        }
    });
    $('#search_filter_3').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#delivered_table_body tr").each(function () {
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
        if ($("#delivered_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#delivered_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#delivered_table_body tr td").removeClass("table-highlight");
        }
    });
    $('#search_filter_4').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#shipped_table_body tr").each(function () {
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
        if ($("#shipped_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#shipped_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#shipped_table_body tr td").removeClass("table-highlight");
        }
    });
    $('#search_filter_5').on('keyup', function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value
    
        // Iterate through each row
        $("#completed_table_body tr").each(function () {
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
        if ($("#completed_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#completed_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if($(this).val()== ''){
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#completed_table_body tr td").removeClass("table-highlight");
        }
    });
});