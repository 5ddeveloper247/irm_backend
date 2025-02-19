<div class="sidebar border-end d-lg-block d-none">
    <div>
        <ul class="nav flex-column p-3">

            <li class="nav-item sidebar-profile border rounded-2 mb-2">
                <a href="javascript:;" class="nav-link main-links-for-submenu collapsed m-0 openProfileCanvas"
                    role="button">
                    <div class="rounded-2 d-flex align-items-center p-0">
                        <div class="nav-link-icon px-2 d-flex align-items-center">
                            {{-- image check --}}
                            @if (auth()->user()->image)
                                <img src="{{ url('/' . auth()->user()->image) }}" class="img-fluid" alt="Profile">
                            @else
                                <img src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/72x72/57.webp"
                                    class="img-fluid" alt="Profile">
                            @endif
                            <div class="ms-2">
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 14px">
                                    {{ auth()->user()->name }}
                                </h6>
                                <small class="mb-0 text-dark text-muted" style="font-size: 12px">
                                    {{ auth()->user()->username }}
                                </small>
                            </div>
                        </div>
                    </div>
                </a>
            </li>

            <span class="pt-2 px-3">MAIN MENU</span>
            {{-- call helper getLeftMenu --}}
            @foreach (getLeftMenu() as $menu)
                <li class="nav-item">
                    <a href="{{ route($menu->route) }}"
                        class="nav-link d-flex align-items-center gap-2 {{ request()->is($menu->route) ? 'active-nav' : '' }}"
                        role="button">
                        <i class="fa-solid {{ $menu->image }}"></i>
                        {{ $menu->name }}
                    </a>
                </li>
            @endforeach

            {{-- call helper getLeftMenu --}}
            {{-- DASHBOARD --}}
            {{-- <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link d-flex align-items-center gap-2 {{ request()->is('dashboard') ? 'active-nav' : '' }}"
                    role="button">solid
                    <i class="fa- fa-house"></i>
                    Dashboard
                </a>
            </li> --}}
        </ul>
    </div>

</div>
<!-- Offcanvas Profile -->
<div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
    id="profile_canvas" aria-labelledby="offcanvas_add_label">
    <div class="offcanvas-header">
        <h5 id="offcanvas_add_label">Profile</h5>
        <button type="button" class="btn-close closeCanvas profile_closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div style="padding: 6%;" class="offcanvas-body">
        <form id="profile_user_form">

            <input type="hidden" id="profile_user_id" name="user_id" value="{{ auth()->user()->id }}">

            <div class="row g-3">

                <div class="form-floating">
                    <input type="text" class="form-control" id="profile_name" name="name"
                        value="{{ auth()->user()->name }}" placeholder="Name" maxlength="50">
                    <label class="ms-2" for="name">Name </label>
                </div>

                <div class="form-floating">
                    <input type="text" class="form-control" id="profile_username" name="username"
                        placeholder="User Title" maxlength="50" value="{{ auth()->user()->username }}">
                    <label class="ms-2" for="profile_username">User Name</label>
                </div>

                <div class="form-floating">
                    <input type="email" class="form-control" id="profile_email" name="email" placeholder="User Tags"
                        maxlength="100" value="{{ auth()->user()->email }}">
                    <label class="ms-2" for="email">Email</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control" id="old_password" name="old_password"
                        placeholder="Old Password" maxlength="50">
                    <label class="ms-2" for="password">Old Password</label>
                    <i class="fa fa-eye position-absolute view_pass" style="top: 40%; right: 7%;font-size:12px;"></i>
                </div>

                <div class="form-floating">
                    {{-- password --}}
                    <input type="password" class="form-control" id="profile_password" name="password"
                        placeholder="Password" maxlength="50">
                    <label class="ms-2" for="password">Password</label>
                    <i class="fa fa-eye position-absolute view_pass" style="top: 40%; right: 7%;font-size:12px;"></i>
                </div>

                <div class="form-floating">
                    {{-- password --}}
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm Password" maxlength="50">
                    <label class="ms-2" for="password">Password</label>
                    <i class="fa fa-eye position-absolute view_pass" style="top: 40%; right: 7%;font-size:12px;"></i>
                </div>

                <div class="row">
                    <div class="col-4 my-2">
                        <button class="btn btn-purple" type="button" id="profile_addthumbnail_btn">
                            User Profile
                        </button>
                    </div>

                    <input type="file" id="profile_thumbnail_file" name="thumbnail" accept="image/*" single
                        style="display:none;">
                    <div class="col-12 my-2">
                        @if (auth()->user()->image)
                            <img class="profile_thumbnail_preview" src="{{ url('/' . auth()->user()->image) }}"
                                style="display:block;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                        @else
                            <img class="profile_thumbnail_preview"
                                src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/72x72/57.webp"
                                style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                        @endif
                    </div>
                </div>

            </div>
            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-secondary me-2 profile_closeCanvas">Cancel</button>
                <button type="button" class="btn btn-purple" onclick="saveAdminProfile();"
                    id="profile_saveUser_btn">Add</button>
            </div>
        </form>
    </div>
</div>
@push('js')
    <script>
        $(document).on('click', '.view_pass', function (e) {
            var passwordField = $(this).siblings('.form-control');
            var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            $(this).toggleClass('fa-eye-slash').toggleClass('fa-eye');
        });
        function saveAdminProfile() {

            let type = 'POST';
            let url = '/saveAdminProfile';
            let message = '';
            let form = $('#profile_user_form');
            let data = new FormData(form[0]);

            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', saveAdminProfileResponse, '', '#profile_saveUser_btn');
        }

        function saveAdminProfileResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.status == 200 || response.status == '200') {
                $('#profile_canvas').removeClass('show');
                toastr.success(response.message, '', {
                    timeOut: 3000
                });

            } else {

                if (response.status == 402) {

                    error = response.message;

                } else {
                    error = response.responseJSON.message;
                    var is_invalid = response.responseJSON.errors;

                    $.each(is_invalid, function(key) {
                        // Assuming 'key' corresponds to the form field name
                        var inputField = $('[name="' + key + '"]');
                        // Add the 'is-invalid' class to the input field's parent or any desired container
                        inputField.closest('.form-control').addClass('is-invalid');
                    });
                }
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }
        }
        $(document).on('click', '#profile_addthumbnail_btn', function(e) {
            $("#profile_thumbnail_file").click();
        });
        $(document).on('change', '#profile_thumbnail_file', function() {
            var file = this.files[0];
            var filePreview = $('.profile_thumbnail_preview');

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.attr('src', e.target.result).show(); // Show the image preview
                }
                reader.readAsDataURL(file); // Convert the file to a base64 string
            } else {
                filePreview.attr('src', '').hide();
            }
        });
        // profile_closeCanvas
        $(".profile_closeCanvas").on("click", function() {
            // $(".profileCanvas").toggleClass("d-none");
            $('#profile_canvas').removeClass('show');
        });
        // openProfileCanvas
        $(".openProfileCanvas").on("click", function() {
            // $(".profileCanvas").toggleClass("d-none");
            $('#old_password, #profile_password, #password_confirmation').val('');
            $('#profile_canvas').addClass('show');
        });
        document.querySelectorAll('.nav-link-acc').forEach((link) => {
            if (link.href === window.location.href) {
                link.classList.add('active');

                const parentCollapse = link.closest('.collapse');
                if (parentCollapse) {
                    parentCollapse.classList.add('show');

                    // Add rotation to the dropdown icon
                    const parentNavLink = parentCollapse.previousElementSibling;
                    if (parentNavLink && parentNavLink.classList.contains('acc-link')) {
                        parentNavLink.classList.add('active-nav');

                        const icon = parentNavLink.querySelector('.rotate-icon');
                        if (icon) {
                            icon.classList.add('rotate');
                        }
                    }

                    if (parentNavLink && parentNavLink.classList.contains('nav-link-acc')) {
                        parentNavLink.classList.add('active');
                    }
                }
            }

            link.addEventListener('click', function() {

                document.querySelectorAll('.collapse.show').forEach((collapse) => {
                    if (collapse !== this.closest('.collapse')) {
                        collapse.classList.remove('show');

                        const parentLink = collapse.previousElementSibling;
                        if (parentLink) {
                            const icon = parentLink.querySelector('.rotate-icon');
                            if (icon) {
                                icon.classList.remove('rotate');
                            }
                        }
                    }
                });

                document.querySelectorAll('.nav-link-acc.active').forEach((activeLink) => {
                    if (activeLink !== this) {
                        activeLink.classList.remove('active');
                    }
                });

                document.querySelectorAll('.acc-link').forEach((accLink) => {
                    accLink.classList.remove('active-nav');

                    const icon = accLink.querySelector('.rotate-icon');
                    if (icon) {
                        icon.classList.remove('rotate');
                    }
                });

                const parentCollapse = this.closest('.collapse');
                if (parentCollapse) {
                    const parentNavLink = parentCollapse.previousElementSibling;
                    if (parentNavLink && parentNavLink.classList.contains('acc-link')) {
                        parentNavLink.classList.add('active-nav');

                        const icon = parentNavLink.querySelector('.rotate-icon');
                        if (icon) {
                            icon.classList.add('rotate');
                        }
                    }
                }

                this.classList.add('active');
            });
        });
    </script>
@endpush
