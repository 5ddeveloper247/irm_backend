//  ____________________SideBar________________________
//  <script>
//     $(document).ready(function() {
//         function checkScreenSize() {
//             if ($(window).width() < 992) {
//                 $('.sidebar').hide();
//             } else {
//                 $('.sidebar').show();
//             }
//         }

//         // Check on initial load
//         checkScreenSize();

//         // Check on resize
//         $(window).resize(function() {
//             checkScreenSize();
//         });
//     });
// </script>

//  icon rotate
// ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor2"))
//     .then((editor) => {
//         editor.setData(`
//             <div style="text-align: center; font-family: Arial, sans-serif; color: #fff; background-color: #374785 !important; padding: 20px;">
//                 <h3 style="margin-top: 0; color: #fff;">Thank You for Choosing <span style="color: #ff6584;">Merkaii Xcellence Prep</span></h3>
//                 <img src="https://via.placeholder.com/150" alt="Merkaii Logo" style="width: 150px; height: auto; margin: 20px 0;">
//                 <hr style="border: 0; border-top: 1px solid #fff; margin: 20px 0;">
//                 <p style="margin: 10px 0; font-weight: bold;">Connect with Us</p>
//                 <div style="margin: 10px 0;">
//                     <a href="#" style="text-decoration: none; margin: 0 10px;">
//                         <img src="https://via.placeholder.com/30/fb" alt="Facebook" style="width: 30px; height: 30px;">
//                     </a>
//                     <a href="#" style="text-decoration: none; margin: 0 10px;">
//                         <img src="https://via.placeholder.com/30/ig" alt="Instagram" style="width: 30px; height: 30px;">
//                     </a>
//                     <a href="#" style="text-decoration: none; margin: 0 10px;">
//                         <img src="https://via.placeholder.com/30/tk" alt="TikTok" style="width: 30px; height: 30px;">
//                     </a>
//                 </div>
//                 <p style="margin: 10px 0;">
//                     Read our <a href="#" style="color: #ff6584; text-decoration: none;">Privacy Policy</a> and <a href="#" style="color: #ff6584; text-decoration: none;">Terms of Use</a>
//                 </p>
//                 <p style="margin: 10px 0; font-size: 14px;">
//                     501 S. Florida Avenue Lakeland, FL 33801<br>
//                     863-250-8764 | 347-525-1736
//                 </p>
//                 <p style="margin: 10px 0; font-size: 12px; color: #ccc;">© 2024 <span style="color: #ff6584;">Merkaii Xcellence Prep</span></p>
//             </div>
//         `);
//     })
//     .catch((error) => {
//         console.error(error);
//     });

// ClassicEditor.create(document.querySelector("#editor3"))
//     .then((editor) => {
//         editor.setData(`<div style="font-family: Arial, sans-serif; line-height: 1.6;">
//     <!-- Header -->
//     <div style="background-color: #4A5B9F; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
//         <h1 style="color: white; margin: 0; font-size: 32px;">Tutor Package Expired</h1>
//     </div>

//     <!-- Body -->
//     <div style="padding: 20px; background-color: #F7F7F7; border-radius: 0 0 8px 8px;">
//         <p style="color: #707070; font-size: 16px;">
//             Thank you for subscribing.<br>
//             We just wanted to inform you that your Tutor Package has expired, and all your current courses have been disabled. In order to continue selling your courses, please renew or upgrade your package.
//         </p>

//         <p style="color: #707070; font-size: 16px;">
//             <strong>Previous Package Expiry Date: </strong>24 Sep 2000
//         </p>

//         <p style="color: #707070; font-size: 16px;">
//             Footer Here
//         </p>
//     </div>
// </div>
// `);
//     })
//     .catch((error) => {
//         console.error(error);
//     });
// ClassicEditor.create(document.querySelector("#editor4")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor5")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor6")).catch((error) => {
//     console.error(error);
// });

// ClassicEditor.create(document.querySelector("#editor7")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor8")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor9")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor10")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor11")).catch((error) => {
//     console.error(error);
// });
// ClassicEditor.create(document.querySelector("#editor12")).catch((error) => {
//     console.error(error);
// });




// $(document).ready(function () {
//     $(".main-links-for-submenu").on("click", function () {
//         $(this)
//             .find(".dropdown-indicator-icon-wrapper")
//             .toggleClass("rotate-90");
//     });
// });
// $(".nav-link").on("click", function () {
//     $(".nav-link-text").css("color", "");

//     $(this).find(".nav-link-text").css("color", "#3874ff");
// });




$(".grid-view").on("click", function () {
    // Remove btn-purple class from the list-view button
    $(".list-view").removeClass("btn-purple");

    // Add btn-purple class to the grid-view button
    $(this).addClass("btn-purple");

    // Show the grid-view div and hide the list-view div
    $(".list-view-div").addClass("d-none");
    $(".grid-view-div").removeClass("d-none");
});

$(".list-view").on("click", function () {
    // Remove btn-purple class from the grid-view button
    $(".grid-view").removeClass("btn-purple");

    // Add btn-purple class to the list-view button
    $(this).addClass("btn-purple");

    // Show the list-view div and hide the grid-view div
    $(".list-view-div").removeClass("d-none");
    $(".grid-view-div").addClass("d-none");
});

$(".btn-notice-add").on("click", function () {
    $(".calendar-and-event-board").addClass("d-none");
    $(".add-event-div").removeClass("d-none");
});
$(".back-to-calendar-and-events").on("click", function () {
    $(".calendar-and-event-board").removeClass("d-none");
    $(".add-event-div").addClass("d-none");
});
$(".backtocourselist").on("click", function () {
    $(".courseList").removeClass("d-none");
    $(".add-coursee-div").addClass("d-none");
});
$(".addCourse_btn").on("click", function () {
    $(".courseList").addClass("d-none");
    $(".add-coursee-div").removeClass("d-none");
});
$(".add-smstr").on("click", function () {
    $(".add-smstr-div").toggleClass("d-none");
});
$(".add-course").on("click", function () {
    $(".add-course-div").toggleClass("d-none");
});
$(document).ready(function () {
    $("#mySelect").select2({
        placeholder: "Select an option",
        allowClear: true,
    });
});
$(document).ready(function () {
    $("#mySelect2").select2({
        placeholder: "Select Students",
        allowClear: true,
    });
});
$(document).ready(function () {
    $(".unique-category-select").on("change", function () {
        // Get the selected value
        var selectedValue = $(this).val();

        // Check if the selected value is '1' which corresponds to BSIT
        if (selectedValue == "1") {
            // Remove the d-none class from the unique-smstr-cards div
            $(".unique-smstr-cards").removeClass("d-none");
        } else {
            // Add the d-none class back if another option is selected
            $(".unique-smstr-cards").addClass("d-none");
        }
    });
});
$(document).ready(function () {
    $(".save-bttnn").on("click", function () {
        $(".challan-container").removeClass("d-none");
    });
});
$(document).ready(function () {
    // Outer tab functionality (Semesters)
    $(".custom-tab-button").click(function () {
        var target = $(this).data("target");

        // Remove 'active' class from all outer content and buttons
        $(".custom-tab-content").removeClass("active");
        $(".custom-tab-button").removeClass("active");

        // Add 'active' class to the clicked outer button and the corresponding content
        $(this).addClass("active");
        $(target).addClass("active");
    });

    // Inner tab functionality (Courses within Semester 1)
    $(".inner-tab-button").click(function () {
        var target = $(this).data("target");

        // Remove 'active' class from all inner content and buttons
        $(".inner-tab-content").removeClass("active");
        $(".inner-tab-button").removeClass("active");

        // Add 'active' class to the clicked inner button and the corresponding content
        $(this).addClass("active");
        $(target).addClass("active");
    });
});
$(document).ready(function () {
    $('.inner-custom-home .tab-button').on('click', function () {
        // Remove 'active' class from all tab buttons
        $('.inner-custom-home .tab-button').removeClass('active');

        // Add 'active' class to the clicked tab button
        $(this).addClass('active');

        // Hide all tab panels
        $('.inner-custom-home .tab-panel').removeClass('active');

        // Show the tab panel corresponding to the clicked tab
        var targetTabPane = $(this).attr('aria-controls');
        $('#' + targetTabPane).addClass('active');
    });
});
$(document).ready(function () {
    $('.student-profile-details .tab-button').on('click', function () {
        // Remove 'active' class from all tab buttons
        $('.student-profile-details .tab-button').removeClass('active');

        // Add 'active' class to the clicked tab button
        $(this).addClass('active');

        // Hide all tab panels
        $('.student-profile-details .tab-panel').removeClass('active');

        // Show the tab panel corresponding to the clicked tab
        var targetTabPane = $(this).attr('aria-controls');
        $('#' + targetTabPane).addClass('active');
    });
});
$(document).ready(function () {
    $(".tab-btn").on("click", function () {
        $(".tab-btn").removeClass("active").css("background-color", "");
        $(".tab-pane").hide();

        $(this)
            .addClass("active")
            .css("background-color", "purple")
            .css("color", "white");

        var tabToShow = $(this).data("tab");
        $("#" + tabToShow).show();
    });

    $(".tab-btn").first().trigger("click");
});

$(".sub-payment-methods-btn").on("click", function () {
    $(".sub-payment-methods-div").toggleClass("d-none");
});
$(".add-geo-location-btn").on("click", function () {
    $(".add-geo-location-div").toggleClass("d-none");
});
//  sidebar collapse logics
document.getElementById("toggleSidebar").addEventListener("click", function () {
    const sidebar = document.querySelector(".sidebar");
    const collapseButton = document.querySelector(".sidebar-collapse-button");
    const forwardIcon = document.querySelector(".sidebar-forward-icon");
    const sidebarFooter = document.querySelector(".sidebar-footer");
    const contentSidebarCollapse = document.querySelector(
        ".sidebar-inner-content"
    );

    sidebar.classList.toggle("collapsed");

    if (sidebar.classList.contains("collapsed")) {
        collapseButton.style.display = "none";
        forwardIcon.style.display = "block";
        sidebarFooter.style.width = "80px";
        sidebarFooter.style.display = "flex";
        sidebarFooter.style.justifyContent = "center";
        $(".sidebar-inner-content").addClass("d-none");
        $(".clinicdropdown").addClass("d-none");
        $(".sidebar-sub-links-bg").removeClass("px-5");
        $(".crm-dropdown").removeClass("d-none");
        $(".landing-dropdown").removeClass("d-none");
        $(".mail-dropdown").removeClass("d-none");
        $(".sidebar").css("overflow", "visible");
    } else {
        collapseButton.style.display = "block";
        forwardIcon.style.display = "none";
        sidebarFooter.style.width = "250px";
        sidebarFooter.style.display = "flex";
        sidebarFooter.style.justifyContent = "start";
        $(".sidebar-inner-content").removeClass("d-none");
        $(".clinicdropdown").removeClass("d-none");
        $(".sidebar-sub-links-bg").addClass("px-5");
        $(".crm-dropdown").addClass("d-none");
        $(".landing-dropdown").addClass("d-none");
        $(".mail-dropdown").addClass("d-none");
    }
});
//  dropdown mouse event none
$(document).ready(function () {
    $(".crm").hover(
        function () {
            $(".crm-dropdown").css("opacity", "1");
            $(".mail, .landing").addClass("disabled");
        },
        function () {
            $(".crm-dropdown").css("opacity", "0");
            $(".mail, .landing").removeClass("disabled");
        }
    );

    $(".mail").hover(
        function () {
            $(".mail-dropdown").css("opacity", "1");
            $(".crm, .landing").addClass("disabled");
        },
        function () {
            $(".mail-dropdown").css("opacity", "0");
            $(".crm, .landing").removeClass("disabled");
        }
    );

    $(".landing").hover(
        function () {
            $(".landing-dropdown").css("opacity", "1");
            $(".crm, .mail").addClass("disabled");
        },
        function () {
            $(".landing-dropdown").css("opacity", "0");
            $(".crm, .mail").removeClass("disabled");
        }
    );
});
//  ____________________SideBar Ends________________________

//  <h1>Footer</h1>

$(document).ready(function () {
    // Initialize Summernote
    $("#summernote").summernote({
        height: 210, // Initial height setting, adjust as needed
    });
});

const ctx = document.getElementById("myLineChart").getContext("2d");
const myLineChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
        ],
        datasets: [
            {
                label: "My First Dataset",
                data: [0, 10, 5, 2, 20, 30, 45],
                borderColor: "rgba(75, 192, 192, 1)",
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                fill: false,
                tension: 0.1,
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: "Month",
                    font: {
                        size: 10, // Font size for x-axis title
                    },
                },
                ticks: {
                    font: {
                        size: 10, // Font size for x-axis labels
                    },
                },
            },
            y: {
                title: {
                    display: true,
                    text: "Value",
                    font: {
                        size: 10, // Font size for y-axis title
                    },
                },
                ticks: {
                    font: {
                        size: 10, // Font size for y-axis labels
                    },
                },
            },
        },
        plugins: {
            legend: {
                labels: {
                    font: {
                        size: 10, // Font size for legend labels
                    },
                },
            },
            tooltip: {
                bodyFont: {
                    size: 8, // Font size for tooltip body
                },
                titleFont: {
                    size: 10, // Font size for tooltip title
                },
            },
        },
    },
});

const chatTextarea = document.querySelector(".chat-textarea");

function updatePlaceholder() {
    if (chatTextarea.textContent.trim() === "") {
        chatTextarea.classList.add("empty");
    } else {
        chatTextarea.classList.remove("empty");
    }
}

chatTextarea.addEventListener("input", updatePlaceholder);
chatTextarea.addEventListener("focus", updatePlaceholder);
chatTextarea.addEventListener("blur", updatePlaceholder);

// Initial check
updatePlaceholder();
