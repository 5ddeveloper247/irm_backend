<nav class="navbar navbar-top navbar-expand px-3" id="navbarDefault">
  <div class="navbar-collapse justify-content-between">

    <div class="navbar-logo d-flex align-items-center">
      <!-- Toggle button for Small Screen  -->
      <button class="navbar-toggler d-lg-none d-block" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa-solid fa-bars fs-5"></i>
      </button>
      
      <div class="collapse collapse-for-toggle-icon" id="collapseExample">
        <ul class="nav flex-column p-3">

          <li class="nav-item sidebar-profile border rounded-2 mb-2 position-sticky top-0">
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
              <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center gap-2 {{request()->is('/') ? 'active-nav' : ''}}" role="button">
                  <i class="fa-solid fa-house"></i>
                  Dashboard
              </a>
          </li>


          {{-- ADMIN-SECTION --}}
          <li class="nav-item">
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
                              class=" d-flex align-items-center justify-content-start text-start m-0 py-2 px-3 nav-link-acc {{request()->is('admission_query') ? 'active-acc' : ''}} "
                              href="#">
                              <span class="ms-4">Audio Lectures</span>
                          </a>
                      </li>

                      

                  </ul>
              </div>
          </li>

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

      <a class="navbar-brand d-flex me-1 me-sm-3" href="#">
        <div class="d-flex align-items-center">
        
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/images/logo-new.png') }}" alt="Al-Maqsood Foundation" width="70">
            </div>
          
            <h6 class="logo-text me-2 fw-bolder d-none d-sm-block ms-3">Al-Maqsood <br> Foundation</h6> 
        </div>
      </a>
      
    </div>

    <ul class="navbar-nav navbar-nav-icons d-flex gap-3 flex-row align-items-center">
      <li class="nav-item p-2 rounded-2" style="border: 2px solid #cbcbcb62">
        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
          <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            <path d="M19.5 7A9 9 0 0 0 12 3a8.99 8.99 0 0 0-7.484 4" />
            <path d="M11.5 3a17 17 0 0 0-1.826 4M12.5 3a17 17 0 0 1 1.828 4M19.5 17a9 9 0 0 1-7.5 4a8.99 8.99 0 0 1-7.484-4" />
            <path d="M11.5 21a17 17 0 0 1-1.826-4m2.826 4a17 17 0 0 0 1.828-4M2 10l1 4l1.5-4L6 14l1-4m10 0l1 4l1.5-4l1.5 4l1-4M9.5 10l1 4l1.5-4l1.5 4l1-4" />
          </g>
        </svg>
      </li>


      <li class="nav-item dropdown position-relative">

        <div class="rounded-2 p-2" style="border: 2px solid #cbcbcb62" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
          <i class="fa-regular fa-bell fs-5"></i>
        </div>

        <div class="notification-dropdown rounded-2 overflow-hidden" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">

          <div class="position-relative border-0">

            <div class="p-3">
              <div class="d-flex justify-content-between">
                <h6 class="fw-bolder">Notifications</h6>
                <span class="s-theme-color">Mark all as read</span>
              </div>
            </div>

            <div style="height: 14rem; overflow-y: auto">

              <div class="px-2 px-sm-3 py-3 notification-card position-relative read border-bottom">
                <div class="d-flex align-items-center justify-content-between position-relative">
                  <div class="d-flex">
                    <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/40x40/57.webp" alt=""></div>
                    <div class="flex-1 me-sm-3">

                      <h6 class="fw-bold">Jessie Samson</h6>
                      <span class="">
                        <span class="me-1 fs-10">💬</span>Mentioned you in a comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">10m</span>
                      </span>
                      <p class="text-body-secondary fs-9 mb-0">
                        <span class="me-1 fas fa-clock"></span>
                        <span class="fw-bold">10:41 AM </span>
                        <span>August 7,2021</span>
                      </p>

                    </div>
                  </div>

                  <div>
                    <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"      aria-expanded="false" data-bs-reference="parent">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="dropdown-menu mark-unread py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                  </div>
                </div>
              </div>


              <div class="px-2 px-sm-3 py-3 notification-card position-relative read border-bottom">
                <div class="d-flex align-items-center justify-content-between position-relative">
                  <div class="d-flex">
                    <div class="avatar avatar-m status-online me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/40x40/57.webp" alt=""></div>
                    <div class="flex-1 me-sm-3">

                      <h6 class="fw-bold">Jessie Samson</h6>
                      <span class="">
                        <span class="me-1 fs-10">💬</span>Mentioned you in a comment.<span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">10m</span>
                      </span>
                      <p class="text-body-secondary fs-9 mb-0">
                        <span class="me-1 fas fa-clock"></span>
                        <span class="fw-bold">10:41 AM </span>
                        <span>August 7,2021</span>
                      </p>

                    </div>
                  </div>

                  <div>
                    <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"      aria-expanded="false" data-bs-reference="parent">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="dropdown-menu mark-unread py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
                  </div>
                </div>
              </div>

            </div>

            <div class="px-4 py-2 theme-btn border-0 text-center">
              <a href="{{url('notifications')}}" class="fw-bolder text-white">Notification history</a>
            </div>
          </div>
        </div>
      </li>

    
      <li class="nav-item dropdown">

        <a class="nav-link lh-1 p-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-l ">
            <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/40x40/57.webp" alt="">
          </div>
        </a>

        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border" style="min-width: 16rem" aria-labelledby="navbarDropdownUser">
          <div class="position-relative border-0">
            <div class="p-0">
              <div class="d-flex flex-column align-items-center text-center py-2">
                <div class="avatar avatar-xl ">
                  <img class="rounded-circle img-fluid" src="https://prium.github.io/phoenix/v1.18.0/assets/img/team/72x72/57.webp" alt="">
                </div>
                <h6 class="mt-2 fw-bold m-theme-color">Jerry Seinfield</h6>
              </div>
              <div class="mb-3 mx-3">
                <input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status">
              </div>
            </div>

            <div class="overflow-auto scrollbar" style="height: 10rem;">

              <ul class="nav d-flex flex-column mb-2 pb-1">

                <li class="nav-item">
                  <a class="nav-profile py-2 px-3 d-block" href="{{url('profile')}}"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2 text-body align-bottom">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Profile
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-profile py-2 px-3 d-block" href="{{url('change_password')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2 text-body align-bottom">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Change Password
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-profile py-2 px-3 d-block" href="{{url('/')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body align-bottom">
                      <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                      <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                    </svg>
                    Dashboard
                  </a>
                </li>

                {{-- <li class="nav-item"><a class="nav-profile py-2 px-3 d-block" href="#!"> <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock me-2 text-body align-bottom">
                      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                      <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>Posts &amp; Activity</a></li> --}}
                <li class="nav-item">
                  <a class="nav-profile py-2 px-3 d-block" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings me-2 text-body align-bottom">
                      <circle cx="12" cy="12" r="3"></circle>
                      <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    Settings &amp; Privacy
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-profile py-2 px-3 d-block" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle me-2 text-body align-bottom">
                      <circle cx="12" cy="12" r="10"></circle>
                      <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                      <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    Help Center
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-profile py-2 px-3 d-block" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 text-body align-bottom">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="2" y1="12" x2="22" y2="12"></line>
                      <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                    Language
                  </a>
                </li>

              </ul>
            </div>
            <div class="p-0 border-top border-translucent">
              {{-- <ul class="nav d-flex flex-column my-3">
                <li class="nav-item"><a class="nav-profile py-2 px-3 d-block" href="#!"> <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus me-2 text-body align-bottom">
                      <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                      <circle cx="8.5" cy="7" r="4"></circle>
                      <line x1="20" y1="8" x2="20" y2="14"></line>
                      <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>Add another account</a></li>
              </ul> --}}
             
              <div class="py-3">
                <a class="btn btn-phoenix-secondary d-flex align-items-center text-danger w-100 fw-bold logoutUser" href="javascript:void(0)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out me-2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>Sign out
                </a>
              </div>
              
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>
