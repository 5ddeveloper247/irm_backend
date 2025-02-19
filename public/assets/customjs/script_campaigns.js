$(document).ready(function () {
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        getCampaignPayments();
        getCampaignsPageData();
    });
})
// getBookPayments
function getCampaignPayments(formValues = {}) {
    let type = "POST";
    let url = "/getCampaignPayments";
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
        getcampaignPaymentsResponse,
        "",
        ""
    );
}
getCampaignPayments();
function getcampaignPaymentsResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        var data = response.data;
        var campaignPayments = data.payment_list;
        campaignPaymentsListing(campaignPayments);
    }
}
function campaignPaymentsListing(campaignPayments) {
    var html = "";
    $("#payment_table_body").html("");
    // campaign_table datatable
    if ($.fn.DataTable.isDataTable("#payment_table")) {
        $("#payment_table").DataTable().destroy().clear();
    }
    if (campaignPayments.length > 0) {
        $.each(campaignPayments, function (index, campaignPayment) {
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${
                            campaignPayment?.campaign?.title ?? ""
                        }</td>
                        <td class="text-start text-nowrap">${
                            campaignPayment?.amount ?? ""
                        }</td>
                        <td class="text-start text-nowrap">${
                            campaignPayment?.payment_intent ?? "MANUAL PAYMENT"
                        }</td>
                        <td class="text-start text-nowrap">${formatDate(
                            campaignPayment?.created_at ?? ""
                        )}</td>
                        <td class="text-start text-nowrap">
                            ${
                                campaignPayment.status == "succeeded"
                                    ? '<span class="badge bg-success">Success</span>'
                                    : '<span class="badge bg-danger">Failed</span>'
                            }
                            
                        </td>
                    </tr>`;
        });
    }
    $("#payment_table_body").html(html);
    // campaign_table
    $("#payment_table").DataTable({
        bDestroy:true,
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
                    getCampaignsPageData(); 
                    getCampaignPayments();
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
}

function getCampaignsPageData(formValues = {}) {
    let type = "POST";
    let url = "/getCampaignsPageData";
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
        getCampaignsPageDataResponse,
        "",
        ""
    );
}

function getCampaignsPageDataResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        var data = response.data;

        var campaignList = data.campaign_list;

        makeCampaignListing(campaignList);
    }
}

function makeCampaignListing(campaignList) {
    var html = "";
    $("#campaign_table_body").html("");
    // campaign_table datatable
    if ($.fn.DataTable.isDataTable("#campaign_table")) {
        $("#campaign_table").DataTable().destroy().clear();
    }
    if (campaignList.length > 0) {
        $.each(campaignList, function (index, campaign) {
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${
                            campaign.title
                        }</td>
                        <td class="text-start text-nowrap">${
                            campaign.target_amount
                        }</td>
                        <td class="text-start text-nowrap">${trimText(
                            campaign.description,
                            50
                        )}</td>
                        <td class="text-start text-nowrap">${formatDate(
                            campaign.date
                        )}</td>
                        <td class="text-start text-nowrap">
                            ${
                                campaign.status == "1"
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-danger">In-Active</span>'
                            }
                            
                        </td>
                        <td class="text-start text-nowrap">
                            <div class="btn-group">
                                <button class="btn action-buttons dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5.92A.96.96 0 1 0 12 4a.96.96 0 0 0 0 1.92m0 7.04a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92M12 20a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <a class="dropdown-item" href="javascript:;" onclick="editCampaign(${
                                        campaign.id
                                    })">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item d-none" href="javascript:;" onclick="deleteCampaignConfirm(${
                                        campaign.id
                                    })">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <g fill="none">
                                                <path fill="currentColor" d="M20 5a1 1 0 1 1 0 2h-1l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H4a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z"></path>
                                            </g>
                                        </svg> 
                                        Delete
                                    </a>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
        });
    }
    $("#campaign_table_body").html(html);
    // campaign_table
    $("#campaign_table").DataTable({
        bDestroy:true,
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
                    getCampaignsPageData(); 
                    getCampaignPayments();
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
}

$(document).on("click", "#addthumbnail_btn", function (e) {
    $("#thumbnail_file").click();
});

$(document).on("change", "#thumbnail_file", function () {
    var file = this.files[0];
    var filePreview = $(".thumbnail_preview");

    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            filePreview.attr("src", e.target.result).show(); // Show the image preview
        };
        reader.readAsDataURL(file); // Convert the file to a base64 string
    } else {
        filePreview.attr("src", "").hide();
    }
});

function addNewCampaign() {
    resetCampaignForm();
    $("#addCampaign_canvas").addClass("show");
}
// addMannualPayment
function addMannualPayment() {
    $("#add_payment_canvas").addClass("show");
}
function resetCampaignForm() {
    let form = $("#campaign_form");
    form.trigger("reset");

    $("#tasks_container").html("");
    $("#campaign_id, #thumbnail_file").val("");
    $(".thumbnail_preview").attr("src", "").hide();
}

$(document).on("click", ".closeCanvas", function (e) {
    resetCampaignForm();
    $("#addCampaign_canvas").removeClass("show");
});
// closePaymentCanvas
$(document).on("click", ".closePaymentCanvas", function (e) {
    $("#add_payment_canvas").removeClass("show");
});
// manual_payment_form
function manual_payment_form() {
    let type = "POST";
    let url = "/manual_payment_form";
    let message = "";
    let form = $("#manual_payment_form");
    let data = new FormData(form[0]);
    // PASSING DATA TO FUNCTION
    $("input").removeClass("is-invalid");
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        manual_payment_formResponse,
        "",
        "#manual_payment_btn"
    );
}
// manual_payment_formResponse
function manual_payment_formResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        // loadCampaignPayments
        getCampaignPayments();
        getCampaignsPageData();
        $("#add_payment_canvas").removeClass("show");
        toastr.success(response.message, "", {
            timeOut: 3000,
        });
    } else {
        if (response.status == 402) {
            error = response.message;
        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;
            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                // Add the 'is-invalid' class to the input field's parent or any desired container
                inputField.closest(".form-control").addClass("is-invalid");
            });
        }
        toastr.error(error, "", {
            timeOut: 3000,
        });
    }
}
function saveCampaign() {
    let type = "POST";
    let url = "/saveCampaign";
    let message = "";
    let form = $("#campaign_form");
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $("input").removeClass("is-invalid");
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        saveCampaignResponse,
        "",
        "#saveCampaign_btn"
    );
}

function saveCampaignResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        resetCampaignForm();
        getCampaignsPageData();
        $("#addCampaign_canvas").removeClass("show");
        toastr.success(response.message, "", {
            timeOut: 3000,
        });
    } else {
        if (response.status == 402) {
            error = response.message;
        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;

            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                // Add the 'is-invalid' class to the input field's parent or any desired container
                inputField.closest(".form-control").addClass("is-invalid");
            });
        }
        toastr.error(error, "", {
            timeOut: 3000,
        });
    }
}

function editCampaign(id) {
    let type = "POST";
    let url = "/getSpecificCampaign";
    let message = "";
    let form = "";
    let data = new FormData();
    data.append("campaign_id", id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, "", editCampaignResponse, "", "");
}

function editCampaignResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        var data = response.data;

        var campaignDetail = data.campaign_detail;

        if (campaignDetail != null) {
            $("#campaign_id").val(campaignDetail.id);
            $("#campaign_title").val(campaignDetail.title);
            $("#campaign_tags").val(campaignDetail.tags);
            $("#campaign_description").val(campaignDetail.description);
            $("#campaign_target_amount").val(campaignDetail.target_amount);
            $("#campaign_status").val(campaignDetail.status);

            if (campaignDetail.thumbnail != null) {
                $(".thumbnail_preview")
                    .attr("src", campaignDetail.thumbnail)
                    .show();
            } else {
                $(".thumbnail_preview").attr("src", "").hide();
            }

            var tasks = campaignDetail.tasks;
            var html = "";
            $("#tasks_container").html("");
            if (tasks.length > 0) {
                $.each(tasks, function (index, task) {
                    html += `<div class="d-flex align-items-center justify-content-between task_div" id="task_div_${
                        task.id
                    }">
                                <div class="form-floating col-5 my-2">
                                    <input type="hidden" name="tasks[${
                                        index + 1
                                    }][id]" value="${task.id}">
                                    <input class="form-control" type="text" id="task_title${
                                        index + 1
                                    }" name="tasks[${
                        index + 1
                    }][title]" value="${task.title}" placeholder="Enter Title ${
                        index + 1
                    }">
                                    <label class="ms-2" for="task_title${
                                        index + 1
                                    }">Title ${index + 1}</label>
                                </div>
                                <div class="form-floating col-5 my-2">
                                    <input class="form-control" type="text" id="task_amount${
                                        index + 1
                                    }" name="tasks[${
                        index + 1
                    }][amount]" value="${
                        task.task_amount
                    }" placeholder="Enter Amount ${index + 1}">
                                    <label class="ms-2" for="task_amount${
                                        index + 1
                                    }">Amount ${index + 1}</label>
                                </div>
                                <svg class="cross-svg" onclick="deleteCampaignTaskConfirm(${
                                    task.id
                                })" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                                    <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                                </svg>
                            </div>`;
                });
            }
            $("#tasks_container").html(html);

            $("#addCampaign_canvas").addClass("show");
        }
    }
}

var tempId = "";
function deleteCampaignTaskConfirm(id) {
    tempId = id;
    $("#deleteConfirm_btn").attr("onclick", "deleteCampaignTaskConfirmed()");
    $("#delete_confirm_modal").modal("show");
}

$(document).on("click", "#close_confirm", function (e) {
    tempId = "";
    $("#deleteConfirm_btn").attr("onclick", "");
    $("#delete_confirm_modal").modal("hide");
});

function deleteCampaignTaskConfirmed() {
    let type = "POST";
    let url = "/deleteCampaignTask";
    let message = "";
    let form = "";
    let data = new FormData();
    data.append("task_id", tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        deleteCampaignTaskConfirmedResponse,
        "",
        ""
    );
}

function deleteCampaignTaskConfirmedResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        $("#task_div_" + tempId).remove();

        $("#deleteConfirm_btn").attr("onclick", "");
        $("#delete_confirm_modal").modal("hide");
        tempId = "";

        toastr.success(response.message, "", {
            timeOut: 3000,
        });
    }
}

function deleteCampaignConfirm(id) {
    tempId = id;
    $("#deleteConfirm_btn").attr("onclick", "deleteCampaignConfirmed()");
    $("#delete_confirm_modal").modal("show");
}

function deleteCampaignConfirmed() {
    let type = "POST";
    let url = "/deleteCampaign";
    let message = "";
    let form = "";
    let data = new FormData();
    data.append("campaign_id", tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        deleteCampaignConfirmedResponse,
        "",
        ""
    );
}

function deleteCampaignConfirmedResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        $("#deleteConfirm_btn").attr("onclick", "");
        $("#delete_confirm_modal").modal("hide");
        tempId = "";

        getCampaignsPageData();
        toastr.success(response.message, "", {
            timeOut: 3000,
        });
    }
}

$(document).on("click", ".remove_task", function (e) {
    $(this).closest(".task_div").remove();
});

$("#add_row").on("click", function () {
    let count = $(".task_div").length;
    count++;
    let html = `<div class="d-flex align-items-center justify-content-between task_div">
                    <div class="form-floating col-5 my-2">
                        <input class="form-control task_title" type="text" id="task_title${count}" name="tasks[${count}][title]" placeholder="Enter Title ${count}">
                        <label class="ms-2" for="task_title${count}">Title ${count}</label>
                    </div>
                    <div class="form-floating col-5 my-2">
                        <input class="form-control task_amount" type="text" id="task_amount${count}" name="tasks[${count}][amount]" placeholder="Enter Amount ${count}">
                        <label class="ms-2" for="task_amount${count}">Amount ${count}</label>
                    </div>
                    <svg class="cross-svg remove_task" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                        <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                    </svg>
                </div>`;

    $("#tasks_container").append(html);
});

$(document).on("change", "input, textarea, select", function (e) {
    $(this).removeClass("is-invalid");
});

$(document).ready(function () {
    getCampaignsPageData();
});

$(document).ready(function () {
    $("#search_filter").on("keyup", function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value

        // Iterate through each row
        $("#campaign_table_body tr").each(function () {
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
        if ($("#campaign_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#campaign_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if ($(this).val() == "") {
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#campaign_table_body tr td").removeClass("table-highlight");
        }
    });
    $("#search_filter_2").on("keyup", function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value

        // Iterate through each row
        $("#payment_table_body tr").each(function () {
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
        if ($("#payment_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#payment_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if ($(this).val() == "") {
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#payment_table_body tr td").removeClass("table-highlight");
        }
    });
});

$(document).ready(function () {
    // Initialize Select2
    $(".select2").select2({
        width: "100%",
        placeholder: "Select an option",
        allowClear: true,
    });

    // Load Campaigns via AJAX
    $.ajax({
        url: "/getCampaignsPageData", // Define the route to fetch campaigns
        type: "POST",
        dataType: "json",
        success: function (data) {
            console.log(data.data.campaign_list);
            data = data.data.campaign_list;
            $("#payment_campaign_id")
                .empty()
                .append('<option value="">Select Campaign</option>');
            $.each(data, function (key, value) {
                $("#payment_campaign_id").append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.title +
                        "</option>"
                );
            });
        },
    });

    // Load Tasks When a Campaign is Selected
    $("#payment_campaign_id").on("change", function () {
        var campaignId = $(this).val();

        if (campaignId) {
            $.ajax({
                url: "/getTasks", // Define the route to fetch tasks
                type: "POST",
                data: { campaign_id: campaignId },
                dataType: "json",
                success: function (data) {
                    console.log(data.data);
                    data = data.data;
                    $("#payment_task_id")
                        .empty()
                        .append('<option value="">Select Task</option>');
                    $.each(data, function (key, value) {
                        $("#payment_task_id").append(
                            '<option value="' +
                                value.id +
                                '">' +
                                value.title +
                                "</option>"
                        );
                    });
                },
            });
        } else {
            $("#payment_task_id")
                .empty()
                .append('<option value="">Select Task</option>');
        }
    });
});
