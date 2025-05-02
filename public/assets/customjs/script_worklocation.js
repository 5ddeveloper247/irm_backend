function getWorklocationPageData(formValues = {}) {
    let type = "POST";
    let url = "/getWorklocationPageData";
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
        getWorklocationPageDataResponse,
        "",
        ""
    );
}

function getWorklocationPageDataResponse(response) {
    console.log(response.worklocations_list);
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        var worklocationsList = response.worklocations_list;

        makeWorklocationListing(worklocationsList);
    }
}

function makeWorklocationListing(worklocationsList) {
    var html = "";
    if ($.fn.DataTable.isDataTable('#listing_table')) {
        $('#listing_table').DataTable().destroy();
    }
    if (worklocationsList.length > 0) {
        $.each(worklocationsList, function (index, value) {
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${value.title}</td>
                        <td class="text-start text-nowrap">${
                            value.descriptions
                        }</td>
                        // created_at
                        <td class="text-start text-nowrap">${formatDate(
                            value.created_at
                        )}</td>
                        <td class="text-start text-nowrap">
                            ${
                                value.status == "1"
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
                                    <a class="dropdown-item" href="javascript:;" onclick="editWorklocation(${
                                        value.id
                                    })">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                            <path fill="currentColor" d="M15.49 7.3h-1.16v6.35H1.67V3.28H8V2H1.67A1.21 1.21 0 0 0 .5 3.28v10.37a1.21 1.21 0 0 0 1.17 1.25h12.66a1.21 1.21 0 0 0 1.17-1.25z" />
                                            <path fill="currentColor" d="M10.56 2.87L6.22 7.22l-.44.44l-.08.08l-1.52 3.16a1.08 1.08 0 0 0 1.45 1.45l3.14-1.53l.53-.53l.43-.43l4.34-4.36l.45-.44l.25-.25a2.18 2.18 0 0 0 0-3.08a2.17 2.17 0 0 0-1.53-.63a2.2 2.2 0 0 0-1.54.63l-.7.69l-.45.44zM5.51 11l1.18-2.43l1.25 1.26zm2-3.36l3.9-3.91l1.3 1.31L8.85 9zm5.68-5.31a.9.9 0 0 1 .65.27a.93.93 0 0 1 0 1.31l-.25.24l-1.3-1.3l.25-.25a.88.88 0 0 1 .69-.25z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteWorklocationConfirm(${
                                        value.id
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
    $("#listing_table_body").html(html);
    $("#listing_table").DataTable({
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
                    getWorklocationPageData(); 
                    // resetFilterButton click


                    
                } 
            }
        ],
    });
}

function addNewWorklocation() {
    initMap();
    tempId = "";
    resetWorklocationForm();
    $("#addWorklocation_canvas").addClass("show");
}

$(document).on("click", ".closeCanvas", function (e) {
    tempId = "";
    resetWorklocationForm();
    $("#addWorklocation_canvas").removeClass("show");
});

function resetWorklocationForm() {
    tempId = "";
    let form = $("#newsWorklocation_form");
    $("#worklocation_id").val("");
    form.trigger("reset");
}

// saveWorklocation();
function saveWorklocation() {
    let type = "POST";
    let url = "/saveWorklocation";
    let message = "";
    let form = $("#newsWorklocation_form");
    let data = new FormData(form[0]);
    // PASSING DATA TO FUNCTION
    $("input, select").removeClass("is-invalid");
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        saveWorklocationResponse,
        "",
        "#saveWorklocation_btn"
    );
}

function saveWorklocationResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        resetWorklocationForm();
        getWorklocationPageData();
        $("#addWorklocation_canvas").removeClass("show");
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

function editWorklocation(id) {
    let type = "POST";
    let url = "/getSpecificWorklocation";
    let message = "";
    let form = "";
    let data = new FormData();
    data.append("worklocation_id", id);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        editWorklocationPlaylistResponse,
        "",
        ""
    );
}

function editWorklocationPlaylistResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        var worklocationDetail = response.worklocation;

        if (worklocationDetail != null) {
            $("#worklocation_id").val(worklocationDetail.id);
            $("#title").val(worklocationDetail.title);
            $("#descriptions").val(worklocationDetail.descriptions);
            // color
            $("#color").val(worklocationDetail.color);
            // lat
            $("#lat").val(worklocationDetail.lat);
            // lng
            $("#lng").val(worklocationDetail.lng);
            // status
            $("#status").val(worklocationDetail.status);
            showMarker(worklocationDetail.lat, worklocationDetail.lng);
            $("#addWorklocation_canvas").addClass("show");
        }
    }
}

var tempId = "";
function deleteWorklocationConfirm(id) {
    tempId = id;
    $("#deleteConfirm_btn").attr("onclick", "deleteWorklocationConfirmed()");
    $("#delete_confirm_modal").modal("show");
}

function deleteWorklocationConfirmed() {
    let type = "POST";
    let url = "/deleteWorklocation";
    let message = "";
    let form = "";
    let data = new FormData();
    data.append("worklocation_id", tempId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        deleteWorklocationConfirmedResponse,
        "",
        ""
    );
}

function deleteWorklocationConfirmedResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == "200") {
        tempId = "";
        $("#deleteConfirm_btn").attr("onclick", "");
        $("#delete_confirm_modal").modal("hide");

        getWorklocationPageData();
        toastr.success(response.message, "", {
            timeOut: 3000,
        });
    }
}

$(document).on("change", "input, textarea, select", function (e) {
    $(this).removeClass("is-invalid");
});

$(document).ready(function () {
    getWorklocationPageData();
});

$(document).ready(function () {
    $("#search_filter").on("keyup", function () {
        $(".no_result_row").remove(); // Remove 'No result found' row
        var value = $(this).val().toLowerCase(); // Get the input value

        // Iterate through each row
        $("#listing_table_body tr").each(function () {
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
        if ($("#listing_table_body tr:visible").length === 0) {
            var no_result_row = `
                <tr class="no_result_row">
                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
                </tr>`;
            $("#listing_table_body").append(no_result_row);
        }
        // remove table-highlight class from all td when input is empty
        if ($(this).val() == "") {
            $(".no_result_row").remove();
            // remove table-highlight class from all td
            $("#listing_table_body tr td").removeClass("table-highlight");
        }
    });
});

$(document).on("click", "#close_confirm", function (e) {
    tempId = "";
    $("#deleteConfirm_btn").attr("onclick", "");
    $("#delete_confirm_modal").modal("hide");
});


// Google Map
let map, marker;

function initMap() {
    // Destroy the map and marker if they already exist
    destroyMap();

    // Create a new map
    map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: 30.3753,
            lng: 69.3451,
        }, // Pakistan center
        zoom: 8,
    });

    // Initialize the search box
    const input = document.getElementById("search-box");
    const searchBox = new google.maps.places.SearchBox(input);

    // Bias the SearchBox results towards the current map's viewport
    map.addListener("bounds_changed", function () {
        searchBox.setBounds(map.getBounds());
    });

    // Marker for displaying selected location
    marker = new google.maps.Marker({
        map: map,
    });

    // Listen for click events on the map
    map.addListener("click", function (event) {
        console.log(event);
        // Get latitude and longitude
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        $("#lat").val(lat);
        $("#lng").val(lng);
        // Update marker position
        marker.setPosition(event.latLng);
    });

    // Listen for places changed in the search box
    searchBox.addListener("places_changed", function () {
        const places = searchBox.getPlaces();

        if (places.length === 0) return;

        // Get the first place
        const place = places[0];
        // If the place has a geometry, display it on the map
        if (place.geometry && place.geometry.location) {
            // Set the map center and zoom
            map.setCenter(place.geometry.location);
            map.setZoom(15);

            // Update marker position
            marker.setPosition(place.geometry.location);

            // Display coordinates
            document.getElementById(
                "coordinates"
            ).innerText = `Latitude: ${place.geometry.location.lat()}, Longitude: ${place.geometry.location.lng()}`;
        }
    });
}

// Function to show marker at specific coordinates
function showMarker(lat, lng) {
    // Destroy the map and marker if they already exist
    destroyMap();

    // Create a new map
    map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: parseFloat(lat),
            lng: parseFloat(lng),
        },
        zoom: 6,
    });

    // Marker for displaying selected location
    marker = new google.maps.Marker({
        map: map,
        position: {
            lat: parseFloat(lat),
            lng: parseFloat(lng),
        },
    });

    // Update marker position
    marker.setPosition({
        lat: parseFloat(lat),
        lng: parseFloat(lng),
    });

    // Listen for click events on the map
    map.addListener("click", function (event) {
        console.log(event);
        // Get latitude and longitude
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        $("#lat").val(lat);
        $("#lng").val(lng);
        // Update marker position
        marker.setPosition(event.latLng);
    });
}

// Function to destroy map and marker
function destroyMap() {
    if (map) {
        map = null;
        marker = null;
    }
}

window.onload = initMap;
