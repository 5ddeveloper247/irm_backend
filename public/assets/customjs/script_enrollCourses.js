function getEnrollCoursesPageData(formValues = {}){
    let type = 'POST';
    let url = '/getEnrollCoursesPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    for (const [key, value] of Object.entries(formValues)) {
        data.append(key, value);
    }
    SendAjaxRequestToServer(type, url, data, '', getEnrollCoursesPageDataResponse, '', '');
}

$(document).ready(function () {
    $('#search_filter').on('keyup', function () {
        $(".no_result_row").remove();
        var value = $(this).val().toLowerCase();
        // when data not match then show no result found
        $("#enrollCourses_table_body tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        // when data not match then show no result found
        if ($("#enrollCourses_table_body tr:visible").length == 0) {
            var no_result_row = `<tr class="no_result_row">
                                    <td class="text-center text-danger" colspan="8">No result found</td>
                                </tr>`;
            $("#enrollCourses_table_body").append(no_result_row);
        } else {
            // remove no result found row
            $(".no_result_row").remove();        
        }
    });
});

function getEnrollCoursesPageDataResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200  || response.status == '200') {
        var data = response.data;
        var enrollCoursesList = data.enrollCourse_list;
        makeEnrollCoursesListing(enrollCoursesList);
    } 
}

function makeEnrollCoursesListing(enrollCoursesList){
    console.log(enrollCoursesList);
   
    var html = '';
    if ($.fn.DataTable.isDataTable('#enrollCourses_table')) {
        $('#enrollCourses_table').DataTable().destroy();
    }
    
    if (enrollCoursesList.length > 0) {
        $.each(enrollCoursesList, function (index, enrollCourse) {
            // Safely get values with fallbacks
            var registerBy = enrollCourse.name || 'N/A';
            var studentName = enrollCourse.name || 'N/A';
            var email = enrollCourse.email || 'N/A';
            var courseTitle = enrollCourse?.course?.title || 'N/A';
            var instructorName = enrollCourse?.course?.instructor_name || 'N/A';
            var level = enrollCourse?.course?.level || 'N/A';
            var date = enrollCourse.created_at ? formatDate(enrollCourse.created_at) : 'N/A';
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index + 1}</td>
                        <td class="text-start text-nowrap">${registerBy}</td>
                        <td class="text-start text-nowrap">${studentName}</td>
                        <td class="text-start text-nowrap">${email}</td>
                        <td class="text-start text-nowrap">${courseTitle}</td>
                        <td class="text-start text-nowrap">${instructorName}</td>
                        <td class="text-start text-nowrap">${level}</td>
                        <td class="text-start text-nowrap">${date}</td>
                    </tr>`;
        });
    } else {
        html = `<tr>
                    <td class="text-center" colspan="8">No data available</td>
                </tr>`;
    }
    
    $("#enrollCourses_table_body").html(html);
    
    // Initialize DataTable with proper configuration
    $("#enrollCourses_table").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        info: true,
        autoWidth: false,
        responsive: true,
        scrollX: true,
        order: [[0, 'asc']], // Sort by Seq No by default
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search",
            emptyTable: "No data available in table",
            zeroRecords: "No matching records found"
        },
        dom: "Bfrtip",
        buttons: [
            { 
                extend: "excel", 
                className: "btn btn-excel", 
                text: "Excel",
                exportOptions: {
                    columns: ':visible'
                }
            },
            { 
                text: "Refresh", 
                className: "btn btn-refresh", 
                action: function () { 
                    console.log("Refresh button clicked");
                    $("#resetFilterButton").click(); 
                    getEnrollCoursesPageData(); 
                } 
            }
        ],
        columnDefs: [
            { targets: [0], orderable: true },  // Seq No
            { targets: [1, 2, 3, 4, 5, 6, 7], orderable: true }  // All other columns
        ]
    });
}

$(document).ready(function () {
    // Initialize on page load
    getEnrollCoursesPageData();
});