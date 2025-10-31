function getPaymentsPageData(formValues = {}){
    let type = 'POST';
    let url = '/getPaymentsPageData';
    let data = new FormData();
    
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    
    SendAjaxRequestToServer(type, url, data, '', getPaymentsPageDataResponse, '', '');
}

function getPaymentsPageDataResponse(response) {
    if (response.status == 200 || response.status == '200') {
        var paymentsList = response.data.payment_list;
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
            var firstName = payment?.non_member != null ? payment?.non_member : payment?.data2?.donatation_submit?.firstName || 'N/A';
            var lastName = payment?.non_member != null ? '' : payment?.data2?.donatation_submit?.lastName || 'N/A';
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
                        <td class="text-start text-nowrap">${getStatusBadge(payment.status)}</td>
                        <td class="text-start text-nowrap">${payment.action_buttons}</td>
                    </tr>`;
        });
    }
    
    $("#payments_table_body").html(html);
    
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
            { extend: "excel", className: "btn btn-excel", text: "Excel" },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    $("#resetFilterButton").click(); 
                    getPaymentsPageData();
                } 
            }
        ],
    });
}

// View payment details
function viewPayment(id) {
    let type = 'GET';
    let url = '/getPaymentDetails/' + id;
    let data = new FormData();
    
    SendAjaxRequestToServer(type, url, data, '', viewPaymentResponse, '', '');
}

function viewPaymentResponse(response) {
    if (response.status == 200) {
        var payment = response.data;
        
        // Populate modal with payment details
        $('#view_payment_id').text(payment.id);
        $('#view_payment_amount').text('PKR ' + payment.amount);
        $('#view_payment_status').html(getStatusBadge(payment.status));
        $('#view_payment_intent').text(payment.payment_intent);
        $('#view_payment_method').text(payment.payment_method);
        $('#view_module_code').text(payment.module_code);
        $('#view_category').text(payment.data?.donatation_submit?.category || 'N/A');
        $('#view_module_title').text(payment.module_title);
        $('#view_payment_date').text(payment.created_at);
        
        // Billing info
        if(payment.data && payment.data.donatation_submit) {
            var billing = payment.data.donatation_submit;
            $('#view_customer_name').text((billing.firstName || '') + ' ' + (billing.lastName || ''));
            $('#view_customer_email').text(billing.email || 'N/A');
            $('#view_customer_phone').text(billing.phoneNumber || 'N/A');
            $('#view_customer_address').text(
                (billing.streetAddress || '') + ', ' + 
                (billing.city || '') + ', ' + 
                (billing.country || '')
            );
        }
        
        // Receipt section
        if(payment.receipt_url) {
            $('#receipt_section').show();
            $('#receipt_name').text(payment.receipt_name);
            
            // Download button
            $('#download_receipt_btn').attr('href', payment.receipt_url);
            $('#download_receipt_btn').attr('download', payment.receipt_name);
            
            // View button
            $('#view_receipt_btn').attr('onclick', `openReceipt('${payment.receipt_url}', ${payment.is_image})`);
            
            // Preview
            if(payment.is_image) {
                $('#receipt_preview').html(`
                    <img src="${payment.receipt_url}" 
                         class="img-fluid rounded cursor-pointer" 
                         style="max-height: 200px; cursor: pointer;"
                         onclick="openReceipt('${payment.receipt_url}', true)" />
                `);
            } else if(payment.is_pdf) {
                $('#receipt_preview').html(`
                    <div class="text-center p-3 bg-light rounded">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                        <p class="mb-0">PDF Document</p>
                    </div>
                `);
            }
        } else {
            $('#receipt_section').hide();
        }
        
        // Show modal
        $('#view_payment_modal').modal('show');
    }
}

// Open receipt in new tab or modal
function openReceipt(url, isImage) {
    if(isImage) {
        // Open image in modal
        $('#receipt_image_modal_img').attr('src', url);
        $('#receipt_image_modal').modal('show');
    } else {
        // Open PDF in new tab
        window.open(url, '_blank');
    }
}

// Approve payment
function approvePayment(id) {
    if(confirm('Are you sure you want to approve this payment?')) {
        let type = 'POST';
        let url = '/approvePayment/' + id;
        let data = new FormData();
        
        SendAjaxRequestToServer(type, url, data, '', approvePaymentResponse, '', '');
    }
}

function approvePaymentResponse(response) {
    if (response.status == 200) {
        toastr.success(response.message, 'Success');
        getPaymentsPageData();
    } else {
        toastr.error(response.message, 'Error');
    }
}

// Reject payment
function rejectPayment(id) {
    if(confirm('Are you sure you want to reject this payment?')) {
        let type = 'POST';
        let url = '/rejectPayment/' + id;
        let data = new FormData();
        
        SendAjaxRequestToServer(type, url, data, '', rejectPaymentResponse, '', '');
    }
}

function rejectPaymentResponse(response) {
    if (response.status == 200) {
        toastr.success(response.message, 'Success');
        getPaymentsPageData();
    } else {
        toastr.error(response.message, 'Error');
    }
}

$(document).ready(function () {
    getPaymentsPageData();
    
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove();
        var value = $(this).val().toLowerCase();
    
        $("#payments_table_body tr").each(function () {
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
    
        if ($("#payments_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="10">No result found</td>
                </tr>`;
            $("#payments_table_body").append(no_result_row);
        }
        
        if($(this).val()== ''){
            $(".no_result_row").remove();
            $("#payments_table_body tr td").removeClass("table-highlight");
        }
    });
});