
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

            
            <section class="login vh-100 d-flex align-items-center justify-content-center" style="background-image:unset;">
    
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6 p-5 h-100 text-center d-flex flex-column justify-content-center bg-white shadow">
                            <div class="text-start ">
                                <h1 class="text-center">
                                    Forget Password
                                </h1>
                                
                                <form id="forgetPassword_form" action="" method="">
                                    
                                    <div class="mt-4 step-1">
                                        <label for="">Email</label><br>
                                        <input class="form-control w-100 p-2 mt-1" type="text" name="email" id="email" placeholder="Enter Email">
                                    </div>
                                    <div class="mt-3 step-2" style="display:none;">
                                        <label for="">OTP (One Time Password)</label><br>
                                        <input class="form-control w-100 p-2 mt-1" type="text" name="otp" id="otp" placeholder="Enter Password">
                                    </div>
                                    <div class="mt-3 step-3" style="display:none;">
                                        <label for="">New Password</label><br>
                                        <input class="form-control w-100 p-2 mt-1" type="password" name="password" id="new_password" placeholder="********">
                                    </div>
                                    <div class="mt-3 step-3" style="display:none;">
                                        <label for="">Confirm Password</label><br>
                                        <input class="form-control w-100 p-2 mt-1" type="password" name="password_confirmation" id="password_confirmation" placeholder="********">
                                    </div>


                                    <button class="py-2 px-4 mt-4 mb-3 w-100 border-0 rounded-3" type="button" id="verifyEmail_btn"
                                            onclick="verifyForgetEmail();" style="background-color:#1C8DEE; color: #fff;">
                                        Verify Email
                                    </button>
                                    <button class="py-2 px-4 mt-4 mb-3 w-100 border-0 rounded-3" type="button" id="verifyOtp_btn"
                                            onclick="verifyForgetOtp();" style="display:none; background-color:#1C8DEE; color: #fff;">
                                        Verify OTP
                                    </button>
                                    <button class="py-2 px-4 mt-4 mb-3 w-100 border-0 rounded-3" type="button" id="changePass_btn"
                                            onclick="verifyForgetPassword();" style="display:none; background-color:#1C8DEE; color: #fff;">
                                        Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            {{-- <footer class="">
                <div class="main-footer border-end border-top toggle-button ">
                    <div class="d-flex align-items-center justify-content-center p-3">
                        <p class="mb-0">Thank you for creating with IRM | <?= date('Y') ?> ©</p>
                        <a class="mx-1" href="https://themewagon.com">IRM</a>
                    </div>
                </div>
            </footer> --}}
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
    <!-- <script src="{{url('assets/customjs/common.js')}}"></script> -->
    <script src="{{url('assets/js/main.js')}}"></script>
    <script src="{{url('assets/customjs/script_forgetpassword.js')}}"></script>

</body>

</html>
