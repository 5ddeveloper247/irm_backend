function getBookOrdersPageData(){
    // alert('getBookOrdersPageData');

    let type = 'POST';
    let url = '/getBookOrders';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getBookOrdersPageDataResponse, '', '');
}

function getBookOrdersPageDataResponse(response) {
    // console.log(response);
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        // console.log(response.data.book_orders);
        var data = response.data;

        var bookOrdersList = data.book_orders;
        // console.log(bookOrdersList);
        makeBookOrdersListing(bookOrdersList);
        BookPaymentsListing(response.payments);
    } 
}
function BookPaymentsListing(payments) {
    console.log(payments);  
    var html = "";
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
    $("#payment_table_body").html(html);
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
    // 	status => 1:pendding, 2:shipped, 3:delivered, 4:completed	
    if (bookOrdersList.length > 0) {
        $.each(bookOrdersList, function (index, bookOrder) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${bookOrder.book.title}</td>
                        <td class="text-start text-nowrap">${bookOrder.amount}</td>
                        <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName + bookOrder.json_data.shipping.lastName}</td>
                        <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                        <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                        <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                        <td class="text-start text-nowrap">${bookOrder.action}</td>
                        
                    </tr>`;
                    // pending
                    if(bookOrder.status == 1){
                        htmlPending += `<tr>
                            <td class="text-start text-nowrap">${index+1}</td>
                            <td class="text-start text-nowrap">${bookOrder.book.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName + bookOrder.json_data.shipping.lastName}</td>
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
                            <td class="text-start text-nowrap">${bookOrder.book.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName + bookOrder.json_data.shipping.lastName}</td>
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
                            <td class="text-start text-nowrap">${bookOrder.book.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName + bookOrder.json_data.shipping.lastName}</td>
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
                            <td class="text-start text-nowrap">${bookOrder.book.title}</td>
                            <td class="text-start text-nowrap">${bookOrder.amount}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.firstName + bookOrder.json_data.shipping.lastName}</td>
                            <td class="text-start text-nowrap">${bookOrder.json_data.shipping.email}</td>
                            <td class="text-start text-nowrap">${bookOrder.statusName}</td>
                            <td class="text-start text-nowrap">${formatDate(bookOrder.created_at)}</td>
                            <td class="text-start text-nowrap">${bookOrder.action}</td>
                        </tr>`;
                    }
                    // completed end

        });
    }
    $("#bookOrders_table_body").html(html);
    // pending
    $("#pending_table_body").html(htmlPending);
    // pending end
    // delivered 
    $("#delivered_table_body").html(htmlDelivered);
    // delivered end
    // shipped
    $("#shipped_table_body").html(htmlShipped);
    // shipped end
    // completed
    $("#completed_table_body").html(htmlCompleted);
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
function viewBookOrder(id){
    let type = 'POST';
    let url = '/viewBookOrder';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('id', id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', viewBookOrderResponse, '', '');
}
// show data in model
// bookOrderDetails_modal
function viewBookOrderResponse(response) {
    bookOrderOpenDetailsPage = true;
    $("#bookOrders-page").slideUp();
    resetBookOrderDetails();
    // console.log(response);
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        var book = response.data;
        console.log(book, book.book.title);
        // var book = data.book_order;
        // var book = bookOrder.book;
        // show data in model
        // $("#bookOrderDetails_modal").modal('show');
        $('#order-detials-page').slideDown();
        $("#bookName").text(book.book.title);
        $("#date").text(formatDate(book.book.date));
        $("#price").text(book.book.price);
        $("#paymentMethod").text(book.json_data.paymentMethodId);
        $("#name").text(book.json_data.shipping.firstName + book.json_data.shipping.lastName);
        
        $("#email").text(book.json_data.shipping.email);
        $("#paymentStatus").text(book.payment.status);
        $("#phone").text(book.json_data.shipping.phoneNumber);
        $("#paymentDate").text(formatDate(book.payment.created_at));
        $("#address").text(book.json_data.shipping.streetAddress);
        $("#paymentAmount").text(book.payment.amount);
        $("#status").html(book.statusNameWithBadge);
        $("#action").html(book.action);
        console.log('book.statusNameWithBadge',book.statusNameWithBadge);
    }
    // console.log(bookOrder);
}
function closeOrderDetailsPage(){
    bookOrderOpenDetailsPage = false;
    $('#order-detials-page').slideUp();
    $("#bookOrders-page").slideDown();
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