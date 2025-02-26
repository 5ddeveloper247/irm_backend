
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/select2.css')}}">
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables/css/dataTables.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables/css/buttons.dataTables.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/niceselect/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/niceselect/custom-styles.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/preloader/preloader.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/plugins/tagsinput/bootstrap-tagsinput.css') }}" />
    
    @push('css')
    <style>

    .login-content2 {
        position: relative;
        color: #fff;
    }

    .login-content2::after {
        content: '';
        position: absolute;
        background-color: rgba(0, 0, 0, 0.6);
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
    }

    .heading {
        position: relative;
        z-index: 9;
        font-size: clamp(28px, 4vw, 37px);
    }

    .heading span {
        background-color: #FFD500;
        color: var(--second-primary-color);
        font-size:1em !important;
    }

    .testimonial-slider p {
        font-size: 14px;
    }

    .forgot-password {
        color: #28574E;
        text-decoration: none;
        font-size: 14px;
    }

    .form-options .remember-me {
        display: flex;
        align-items: center;
    }

    .form-options .remember-me input {
        margin-right: 5px;
    }

    .form-control {
        font-size: 14px;
    }

    .or {
        position: relative;
    }

    .or::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 140%;
        border: 0.5px solid #dbdbdb;
        width: 16vw;
    }

    .or::before {
        content: '';
        position: absolute;
        top: 50%;
        right: 140%;
        border: 0.5px solid #dbdbdb;
        width: 16vw;
    } 
    </style>
    @endpush
</head>

<body>

    
    <div class="preloader">
        <div class="circle circle5 c51"></div>
    </div>
    
    <div class="d-flex">

        <!-- main content -->
        <div class="content">
            
            @section('title','Login')

            
            {{-- <div class="w-100 my-3" style="background-color:#65cb02; height:15px;"></div> --}}

            
            <section class="login vh-100 d-flex align-items-center justify-content-center overflow-hidden" style="background-image:unset; background: antiquewhite;">
    
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-12  p-5 text-center d-flex flex-column justify-content-center">
                            <div class="text-start ">
                                <h1 class="text-center" style="color: #1C8DEE;">
                                    LOGIN
                                </h1>
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{session('error')}}
                                    </div>
                                @elseif($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p class="mb-0">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif

                                <form action="{{route('loginSubmit')}}" method="POST">
                                    @csrf
                                    <div class="mt-4">
                                        <label for="">Email</label><br>
                                        <input class="form-control w-100 p-2 mt-1" type="email" placeholder="Enter Username" name="email">
                                    </div>
                                    <div class="mt-3 position-relative">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <input id="password" class="form-control w-100 p-2 mt-1" type="password" placeholder="Enter Password" name="password">
                                            <button type="button" class="toggle-password position-absolute" onclick="togglePassword()" style="right: 10px; top: 50%; transform: translate(0%, -45%); border: none; background: none;">
                                                <i id="eyeIcon" class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-options my-2 d-flex align-items-center justify-content-between gap-1">
                                        <div class="remember-me d-flex gap-1">
                                            <input type="checkbox" id="remember-me">
                                            <label class="form-label mb-1" for="remember-me">Remember me</label>
                                        </div>
                                        <div>
                                            <a href="{{route('forgetpass')}}" class="forgot-password">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <button class="py-2 px-4 mt-4 mb-3 w-100 border-0 rounded-3" type="submit" style="background-color:#1C8DEE; color: #fff;">
                                        SIGN IN
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="http://localhost:5173/src/assets/images/activity-4.png" width="100%" height="100%" alt="">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    
    <!-- Footer code here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{url('assets/plugins/datatables/js/dataTables.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{ url('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{url('assets/plugins/niceselect/nice-select.min.js')}}"></script>
    <script src="{{url('assets/plugins/niceselect/custom-select.js')}}"></script>
    <script src="{{url('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('assets/plugins/tagsinput/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{url('assets/plugins/ckeditor5/build/ckeditor.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <!-- {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}} -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script> -->
    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{url('assets/customjs/select2.js')}}"></script>
    <!-- <script src="{{asset('assets/customjs/common.js')}}"></script> -->
    <script src="{{url('assets/js/main.js')}}"></script>



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
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash"); // Change to "hide" icon
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye"); // Change back to "show" icon
        }
    }
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Attach the shown and hidden events to all collapse elements
        $('.accordion-collapse').on('shown.bs.collapse', function() {
            // Find the <a> tag that was clicked to open the accordion and its <svg> child
            $(this).prev('.filter-set-content-head').find('svg').removeClass('rotate-0').addClass('rotate-90');
        });

        $('.accordion-collapse').on('hidden.bs.collapse', function() {
            // Find the <a> tag that was clicked to close the accordion and its <svg> child
            $(this).prev('.filter-set-content-head').find('svg').removeClass('rotate-90').addClass('rotate-0');
        });
    });
</script>
    @stack('js')
</body>

</html>
