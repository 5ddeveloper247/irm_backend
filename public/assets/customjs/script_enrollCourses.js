function getEnrollCoursesPageData(){

    let type = 'POST';
    let url = '/getEnrollCoursesPageData';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getEnrollCoursesPageDataResponse, '', '');
}
// $(document).ready(function () {
//     $('#search_filter').on('keyup', function () {
//         var value = $(this).val().toLowerCase();
//         $("#enrollCourses_table_body tr").filter(function () {
//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//         });
//     });
// });
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
                                    <td class="text-start text-danger text-center" colspan="8">No result found</td>
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
        // console.log(response.data.enrollCourse_list);
        var data = response.data;

        var enrollCoursesList = data.enrollCourse_list;
        // console.log(enrollCoursesList);
        makeEnrollCoursesListing(enrollCoursesList);
    } 
}

function makeEnrollCoursesListing(enrollCoursesList){
    console.log(enrollCoursesList);
   
    var html = '';
   
    if (enrollCoursesList.length > 0) {
        $.each(enrollCoursesList, function (index, enrollCourse) {
            
            html += `<tr>
                        <td class="text-start text-nowrap">${index+1}</td>
                        <td class="text-start text-nowrap">${enrollCourse.name}</td>
                        <td class="text-start text-nowrap">${enrollCourse.email}</td>
                        <td class="text-start text-nowrap">${enrollCourse.course.title}</td>
                        <td class="text-start text-nowrap">${enrollCourse.course.instructor_name}</td> 
                        <td class="text-start text-nowrap">${enrollCourse.course.level}</td> 
                        <td class="text-start text-nowrap">${formatDate(enrollCourse.created_at)}</td>
                        
                        
                    </tr>`;
        });
    }
    $("#enrollCourses_table_body").html(html);
    // setTimeout(function () {
    //     $('#enrollCourses_table').DataTable({
    //         // add serch pan in table
    //         "searching": true,
    //         // pagination
    //         "paging": true,
    //     });
    // }, 1000);
}

$(document).ready(function () {
    // datatables
    getEnrollCoursesPageData();
});