<div class="sidebar border-end d-lg-block d-none">
    <div>
        <ul class="nav flex-column p-3">

        <li class="nav-item sidebar-profile border rounded-2 mb-2">
                <a href="{{ url('/profile') }}" class="nav-link main-links-for-submenu collapsed m-0" role="button">
                    <div class="rounded-2 d-flex align-items-center p-0">
                        <div class="nav-link-icon px-2 d-flex align-items-center">
                            <img src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/72x72/57.webp"
                                class="img-fluid" alt="Profile">
                            <div class="ms-2">
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 14px">
                                    Adrian Davies
                                </h6>
                                <small class="mb-0 text-dark text-muted" style="font-size: 12px">
                                    Tech Lead
                                </small>
                            </div>
                        </div>
                    </div>
                </a>
            </li>

            <span class="pt-2 px-3">MAIN MENU</span>

            {{-- DASHBOARD --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center gap-2 {{request()->is('dashboard') ? 'active-nav' : ''}}" role="button">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('audio_lectures') }}" class="nav-link acc-link {{request()->is('audio_lectures') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-audio"></i>
                            Audio Lectures
                        </div>
                    </div>

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('campaigns') }}" class="nav-link acc-link {{request()->is('campaigns') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-folder-plus"></i>
                            Campaigns
                        </div>
                    </div>

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('books_library') }}" class="nav-link acc-link {{request()->is('books_library') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-book-open"></i>
                            Books Library
                        </div>
                    </div>

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('blogs') }}" class="nav-link acc-link {{request()->is('blogs') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-blog"></i>
                            Blogs
                        </div>
                    </div>

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gallery') }}" class="nav-link acc-link {{request()->is('gallery') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-images"></i>
                            Gallery Types
                        </div>
                    </div>

                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('courses') }}" class="nav-link acc-link {{request()->is('courses') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-images"></i>
                            Course Types
                        </div>
                    </div>

                </a>
            </li>

            {{-- ADMIN-SECTION --}}
            <!-- <li class="nav-item">
                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#admin" role="button"
                    aria-expanded="false" aria-controls="collapseExample">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-gear"></i>
                            Lectures
                        </div>
                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>
                    </div>
                </a>

                <div class="collapse sidebar-inner-content" id="admin">

                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a href="{{ route('audio_lectures') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('audio_lectures') ? 'active-acc' : ''}} ">
                                <span class="ms-4">Audio Lectures</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('campaigns') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('campaigns') ? 'active-acc' : ''}} ">
                                <span class="ms-4">Campaigns</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li> -->

            {{-- ACADEMICS --}}
            <!-- <li class="nav-item">

                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#sidebar-crm"
                    role="button" aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-signature"></i>
                            Academics
                        </div>

                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>

                <div class="collapse sidebar-inner-content" id="sidebar-crm">

                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a href=""
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('academic/course_type') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Course Type</span>
                            </a>
                        </li>
                        
                        <li class="nav-item ">
                            <a href=""
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('academic/program_type') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Program Type</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('academic/courses') ? 'active-acc' : ''}} @if(request()->is('academic/courses/*')) active @endif"
                                href="#">
                                <span class="ms-4">Course</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('academic/programs') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Program</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('academic/sessions') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Session</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('academic/class_schedules') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Class Schedule</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('lab') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('lab') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Lab</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('externship') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('externship') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Externship</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('instructor') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('instructor') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Instructor</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('student') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('student') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Student</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('tutorship') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('tutorship') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Tutorship</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('faqs') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('faqs') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">FAQS</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li> -->

            {{-- HR MODULE --}}
            <!-- <li class="nav-item">

                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#hr-module"
                    role="button" aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-receipt"></i>
                            HR Module
                        </div>

                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>

                <div class="collapse sidebar-inner-content" id="hr-module">

                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a href=""
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('hr/department') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Departments</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('hr/job_title') ? 'active-acc' : ''}}">
                                <span class="ms-4">Job Title</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('employees') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('employees') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Employees</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('employee_termination') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('employee_termination') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Employee Termination</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('salary_component') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('salary_component') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Salary Component</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('add_salary_component') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('add_salary_component') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Salary Management</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('add_payment_method') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('add_payment_method') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Add Payment Method</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('payroll_program') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('payroll_program') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Payroll Program</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('payroll_process') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('payroll_process') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Payroll Process Information</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('hr/leave_type') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Leaves</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('leave_management') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('leave_management') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Leaves Management</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('hr/holiday') ? 'active-acc' : ''}}"
                                href="#">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('system_users') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('system_users') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">System Users</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li> -->

            {{-- FINANCIAL MODULE --}}
            <!-- <li class="nav-item">

                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#financial-module"
                    role="button" aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-coins"></i>
                            Financial Module
                        </div>

                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>

                <div class="collapse sidebar-inner-content" id="financial-module">

                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a href="{{ url('student_registration_fees') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('student_registration_fees') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Student Registration Fee</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('studen_program_fees') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('studen_program_fees') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Student Program Fee</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ url('fee_plan') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('fee_plan') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Fee Plan</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="d-flex align-items-center justify-content-start text-start nav-link sidebar-sub-links-bg px-5"
                                href="#">
                                <span class="ms-5">Fee Types</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('expenses_and_payables') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('expenses_and_payables') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Expenses and Payables</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('taxes') }}"
                                class="d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('taxes') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Taxes</span>
                            </a>
                        </li>

                    </ul>

                </div>
            </li> -->

            {{-- STUDENT MODULE --}}
            <!-- <li class="nav-item">

                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#student-module"
                    role="button" aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-graduation-cap"></i>
                            Student Module
                        </div>

                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>
                <div class="collapse sidebar-inner-content" id="student-module">
                    <ul class="nav flex-column">
                        <li class="nav-item ">
                            <a href="{{ url('student_lisitngs') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('student_lisitngs') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Student List</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->

            {{-- SETTING MODULE --}}
            <!-- <li class="nav-item">
                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#settings-module"
                    role="button" aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-gear"></i>
                            Settings Module
                        </div>

                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>
                <div class="collapse sidebar-inner-content" id="settings-module">
                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a href="{{ url('general_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('general_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">General Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'team_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('team_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Team Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'tax_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('tax_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Tax Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'email_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('email_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Email Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'email_footer_template') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('email_footer_template') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Email Footer Template</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'email_template') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('email_template') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Email Template</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'payment_method_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('payment_method_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Payment Method Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'timezone_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('timezone_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Time Zone Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'city_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('city_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">City</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'cookie_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('cookie_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Cookie Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url(path: 'social_login') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('social_login') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Social Login</span>
                            </a>
                        </li>
                        
                        <li class="nav-item ">
                            <a href="{{ url(path: 'backup') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('backup') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Backup</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li> -->

            {{-- LIBRARY --}}
            <!-- <li class="nav-item ">
                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#library" role="button"
                    aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-book"></i>
                            Library
                        </div>
                        
                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>

                <div class="collapse sidebar-inner-content" id="library">
                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a href="{{ url('library_category') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('library_category') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Category</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url('library_subcategory') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('library_subcategory') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Sub-Category</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url('add_book') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('add_book') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Add Book</span>
                            </a>
                        </li>

                    </ul>
                </div>

            </li> -->

            {{-- UTILITY --}}
            <!-- <li class="nav-item">
                <a class="nav-link acc-link" data-bs-toggle="collapse" href="#utility" role="button"
                    aria-expanded="false" aria-controls="collapseExample">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-hammer"></i>
                            Utility
                        </div>

                        <span class="dropdown-indicator-icon-wrapper">
                            <i class="fa-solid fa-caret-down rotate-icon"></i>
                        </span>

                    </div>
                </a>

                <div class="collapse sidebar-inner-content" id="utility">
                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a href="{{ url('error_log') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('error_log') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Error Log</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url('preloader_settings') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('preloader_settings') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Preloader Settings</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url('geo_location') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('geo_location') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">Geo Location</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ url('ip_block') }}"
                                class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('ip_block') ? 'active-acc' : ''}}"
                                href="#">
                                <span class="ms-4">IP Block</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li> -->

            {{-- WEBSITE MODULE --}}
            <!-- <li class="nav-item">
                <a href="{{ url('website_module') }}" class="nav-link acc-link {{request()->is('website_module') ? 'active-nav' : ''}}">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-folder-plus"></i>
                            Website Module
                        </div>
                    </div>

                </a>
            </li> -->

            {{-- SUPPORT --}}
            <!-- <li class="nav-item">
                <a href="{{ url('support') }}" class="nav-link acc-link {{request()->is('support') ? 'active-nav' : ''}}">
                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-headset"></i>
                            Support
                        </div>

                    </div>
                </a>
            </li> -->
        </ul>
    </div>

</div>
@push('js')

<script>
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

        link.addEventListener('click', function () {

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