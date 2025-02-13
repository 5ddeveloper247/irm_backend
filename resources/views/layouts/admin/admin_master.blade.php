<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables/css/dataTables.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables/css/buttons.dataTables.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/niceselect/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/niceselect/custom-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/preloader/preloader.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagsinput/bootstrap-tagsinput.css') }}" />
    {{-- <style>
        .main-links-for-submenu:not(.collapsed)  .dropdown-indicator-icon-wrapper{
            transform:rotate(90deg);
        }
    </style> --}}
    <style>
        .table-highlight {
            color: blue !important;
        }
    </style>

    @stack('css')

</head>
<script>
    var baseurl = "{{ url('/') }}";
</script>

<body>

    <!-- header code here -->

    <div class="preloader">
        <div class="circle circle5 c51"></div>
    </div>
    <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
    <input type="hidden" name="table_name" id="table_name" value="@yield('table')">

    <div class="d-flex">
        @auth
            <!-- side bar code here -->
            @include('layouts.admin.sidebar')
        @endauth

        <!-- main content -->
        <div class="content">
            @auth
                @include('layouts.admin.header')
            @endauth
            @yield('content')
            @include('layouts.admin.footer')
        </div>
    </div>

    <!-- Footer code here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/plugins/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/js/buttons.html5.min.js') }}"></script>

    {{-- datatables --}}
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- jQuery (Required for DataTables) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    

    {{-- datatables end  --}}
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/niceselect/nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/niceselect/custom-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor5/build/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/customjs/select2.js') }}"></script>
    <script src="{{ asset('assets/customjs/common.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <style>
        .dt-buttons{
            margin-top: 0px !important;
            margin-left: 10px !important;
        }
        /* Custom styles for primary button */
        /* Custom styles for Copy button */
        button.dt-button.btn.btn-copy {
            background-color: #007bff; /* Blue */
            border-color: #007bff;
            color: white;
        }

        button.dt-button.btn.btn-copy:hover {
            background-color: #0056b3; /* Darker Blue */
            border-color: #004085;
        }

        button.dt-button.btn.btn-copy:active {
            background-color: #004085; /* Even Darker Blue */
            border-color: #003366;
        }

        /* Custom styles for CSV button */
        button.dt-button.btn.btn-csv {
            background-color: #28a745; /* Green */
            border-color: #28a745;
            color: white;
        }

        button.dt-button.btn.btn-csv:hover {
            background-color: #218838; /* Darker Green */
            border-color: #1e7e34;
        }

        button.dt-button.btn.btn-csv:active {
            background-color: #1e7e34; /* Even Darker Green */
            border-color: #155e24;
        }

        /* Custom styles for Excel button */
        button.dt-button.btn.btn-excel {
            background-color: #28a745; /* Green */
            border-color: #28a745;
            color: white;
        }

        button.dt-button.btn.btn-excel:hover {
            background-color: #218838; /* Darker Green */
            border-color: #1e7e34;
        }

        button.dt-button.btn.btn-excel:active {
            background-color: #1e7e34; /* Even Darker Green */
            border-color: #155e24;
        }

        /* Custom styles for PDF button */
        button.dt-button.btn.btn-pdf {
            background-color: #dc3545; /* Red */
            border-color: #dc3545;
            color: white;
        }

        button.dt-button.btn.btn-pdf:hover {
            background-color: #c82333; /* Darker Red */
            border-color: #bd2130;
        }

        button.dt-button.btn.btn-pdf:active {
            background-color: #bd2130; /* Even Darker Red */
            border-color: #9a1f29;
        }

        /* Custom styles for Print button */
        button.dt-button.btn.btn-print {
            background-color: #17a2b8; /* Light Blue */
            border-color: #17a2b8;
            color: white;
        }

        button.dt-button.btn.btn-print:hover {
            background-color: #138496; /* Darker Light Blue */
            border-color: #117a8b;
        }

        button.dt-button.btn.btn-print:active {
            background-color: #117a8b; /* Even Darker Light Blue */
            border-color: #0e6f7b;
        }

        /* Custom styles for Filter button */
        button.dt-button.btn.btn-filter {
            background-color: #007bff; /* Blue */
            border-color: #007bff;
            color: white;
        }

        button.dt-button.btn.btn-filter:hover {
            background-color: #0056b3; /* Darker Blue */
            border-color: #004085;
        }

        button.dt-button.btn.btn-filter:active {
            background-color: #004085; /* Even Darker Blue */
            border-color: #003366;
        }

        /* Custom styles for Refresh button */
        button.dt-button.btn.btn-refresh {
            background-color: #6c757d; /* Gray */
            border-color: #6c757d;
            color: white;
        }

        button.dt-button.btn.btn-refresh:hover {
            background-color: #5a6268; /* Darker Gray */
            border-color: #4e555b;
        }

        button.dt-button.btn.btn-refresh:active {
            background-color: #4e555b; /* Even Darker Gray */
            border-color: #3e474b;
        }


        </style>
    <script type="text/javascript">
        // Initialize the chart
        var chart = echarts.init(document.getElementById('line-chart'));

        // Specify chart configuration
        var option = {
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                name: 'Sales',
                type: 'line',
                data: [150, 230, 224, 218, 135, 147, 260]
            }]
        };

        // Use the specified configuration to show the chart
        chart.setOption(option);
    </script>

    <script type="text/javascript">
        // Initialize the chart
        var chart = echarts.init(document.getElementById('main'));

        // Specify chart configuration
        var option = {
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [{
                name: 'Access From',
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                itemStyle: {
                    borderRadius: 10
                },
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: 5,
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: [{
                        value: 1048,
                        name: 'Search Engine'
                    },
                    {
                        value: 735,
                        name: 'Direct'
                    },
                    {
                        value: 580,
                        name: 'Email'
                    },
                    {
                        value: 484,
                        name: 'Union Ads'
                    },
                    {
                        value: 300,
                        name: 'Video Ads'
                    }
                ]
            }]
        };

        // Set the specified option to the chart
        chart.setOption(option);
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.my-select').select2({
                    placeholder: 'Select a state',
                    allowClear: true
                });
            }, 100);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#leaveTable').DataTable({
                "pagingType": "full_numbers",
                "pageLength": 1,
                "searching": false,
                "ordering": true,
                "info": true,
                "language": {
                    "emptyTable": "No leave data"
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // When the "Edit" button is clicked
            $(".edit-profile-btn").click(function() {
                $(".profile-content").addClass("d-none"); // Hide the profile view
                $(".edit-profile-content").removeClass("d-none"); // Show the edit form
            });

            // When the "Save" button is clicked
            $('.save-profile-settings').click(function() {
                $(".profile-content").removeClass("d-none"); // Show the profile view
                $(".edit-profile-content").addClass("d-none"); // Hide the edit form
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#daterange').daterangepicker({
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Attach the shown and hidden events to all collapse elements
            $('.accordion-collapse').on('shown.bs.collapse', function() {
                // Find the <a> tag that was clicked to open the accordion and its <svg> child
                $(this).prev('.filter-set-content-head').find('svg').removeClass('rotate-0').addClass(
                    'rotate-90');
            });

            $('.accordion-collapse').on('hidden.bs.collapse', function() {
                // Find the <a> tag that was clicked to close the accordion and its <svg> child
                $(this).prev('.filter-set-content-head').find('svg').removeClass('rotate-90').addClass(
                    'rotate-0');
            });
        });
    </script>
    @stack('js')
</body>

</html>
