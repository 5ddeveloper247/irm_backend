@extends('layouts.admin.admin_master')

@push('css')
    <style>
        ul.dropdown-menu-custom {
            transform: translateX(-17px) !important;
        }

        /* .collapse.show {
                background-color: #ecf4ff00 !important;
            } */

        .img-prev {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cancel-icon {
            font-size: 20px !important;
            color: red;
            position: relative;
            top: -32px;
            right: 0px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="student">
        <div class="p-md-1 p-3">
            <div class="container-fluid bg-light py-2">
                <div class="row align-items-center px-2">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Course Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Course Types</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#category-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Course Types</button>
                </li>
                <li class="nav-item fs-3" role="presentation">
                    <button class="nav-link" id="listing-tab" data-bs-toggle="tab" data-bs-target="#listing-tab-pane"
                        type="button" role="tab" aria-controls="listing-tab-pane" aria-selected="true">Course
                        List</button>
                </li>

            </ul>




            <div class="student">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                            <!-- _____________________________________TABS_______________________________________ -->

                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="category-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewType();" >
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Course Type
                                                            </a>';
                                                    $filters = [
                                                        // get my page table course type
                                                        [
                                                            'name' => 'type_title',
                                                            'type' => 'text',
                                                            'label' => 'Type Title',
                                                            'placeholder' => 'Search Type Title',
                                                        ],
                                                        // Date
                                                        ['name' => 'date', 'type' => 'date', 'label' => 'Date'],
                                                        // Status
                                                        [
                                                            'name' => 'type_status',
                                                            'type' => 'select',
                                                            'label' => 'Status',
                                                            'options' => [
                                                                ['value' => '', 'label' => 'Select'],
                                                                ['value' => '1', 'label' => 'Active'],
                                                                ['value' => '0', 'label' => 'Inactive'],
                                                            ],
                                                        ],
                                                        //
                                                        // ['name' => 'email', 'type' => 'text', 'label' => 'Email', 'placeholder' => 'Search Email'],
                                                        // // Select options
                                                        // ['name' => 'role', 'type' => 'select', 'label' => 'Role', 'options' => [
                                                        //     ['value' => 'admin', 'label' => 'Admin'],
                                                        //     ['value' => 'user', 'label' => 'User']
                                                        // ]],
                                                        // // Date
                                                        // ['name' => 'created_at', 'type' => 'date', 'label' => 'Created At'],
                                                        // // Radio buttons
                                                        // ['name' => 'gender', 'type' => 'radio', 'label' => 'Gender', 'options' => [
                                                        //     ['value' => 'male', 'label' => 'Male'],
                                                        //     ['value' => 'female', 'label' => 'Female']
                                                        // ]],
                                                        // ['name' => 'status', 'type' => 'checkbox', 'label' => 'Status', 'options' => [
                                                        //     ['value' => '1', 'label' => 'Active'],
                                                        //     ['value' => '0', 'label' => 'Inactive']
                                                        // ]]
                                                    ];
                                                @endphp
                                                @include('admin.filter.index')
                                                {{-- include --}}


                                                <hr>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3">
                                                        <!-- overflow-x:clip; -->
                                                        <table id="courseType_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Type
                                                                        Title</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Status
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="courseType_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="listing-tab-pane" role="tabpanel"
                                    aria-labelledby="schedule-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewCourse();">
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Course
                                                            </a>';
                                                    $filters = [
                                                        // get my page table courses
                                                        [
                                                            'name' => 'course_title',
                                                            'type' => 'text',
                                                            'label' => 'Course Title',
                                                            'placeholder' => 'Search Course Title',
                                                        ],

                                                        // course_type
                                                        [
                                                            'name' => 'course_type',
                                                            'type' => 'text',
                                                            'label' => 'Type Name',
                                                            'placeholder' => 'Search Type Name',
                                                        ],
                                                        // Instructor Name
                                                        [
                                                            'name' => 'course_instructor',
                                                            'type' => 'text',
                                                            'label' => 'Instructor Name',
                                                            'placeholder' => 'Search Instructor Name',
                                                        ],
                                                        // Course Date
                                                        [
                                                            'name' => 'course_date',
                                                            'type' => 'date',
                                                            'label' => 'Course Date',
                                                        ],

                                                        [
                                                            'name' => 'course_status',
                                                            'type' => 'select',
                                                            'label' => 'Status',
                                                            'options' => [
                                                                ['value' => '', 'label' => 'Select'],
                                                                ['value' => '1', 'label' => 'Active'],
                                                                ['value' => '0', 'label' => 'Inactive'],
                                                            ],
                                                        ],
                                                        //
                                                        // ['name' => 'email', 'type' => 'text', 'label' => 'Email', 'placeholder' => 'Search Email'],
                                                        // // Select options
                                                        // ['name' => 'role', 'type' => 'select', 'label' => 'Role', 'options' => [
                                                        //     ['value' => 'admin', 'label' => 'Admin'],
                                                        //     ['value' => 'user', 'label' => 'User']
                                                        // ]],
                                                        // // Date
                                                        // ['name' => 'created_at', 'type' => 'date', 'label' => 'Created At'],
                                                        // // Radio buttons
                                                        // ['name' => 'gender', 'type' => 'radio', 'label' => 'Gender', 'options' => [
                                                        //     ['value' => 'male', 'label' => 'Male'],
                                                        //     ['value' => 'female', 'label' => 'Female']
                                                        // ]],
                                                        // ['name' => 'status', 'type' => 'checkbox', 'label' => 'Status', 'options' => [
                                                        //     ['value' => '1', 'label' => 'Active'],
                                                        //     ['value' => '0', 'label' => 'Inactive']
                                                        // ]]
                                                    ];
                                                @endphp
                                                @include('admin.filter.index')
                                                {{-- include --}}


                                                <hr>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100"
                                                        style="overflow: auto;"><!-- overflow-x:clip; -->
                                                        <table id="course_table" class="table visitor-book-table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Course
                                                                        Title</th>
                                                                    <th class="text-start text-nowrap" scope="col">Type
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Instructor Name</th>
                                                                        {{-- language --}}
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Language</th>
                                                                        {{-- level --}}
                                                                    <th class="text-start text-nowrap" scope="col">Level</th>
                                                                    {{-- certificate --}}
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Certificate</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Status
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="course_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Add Audio Category -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="addCourseType_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Course Type Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="type_form">

                <input type="hidden" id="type_id" name="type_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <input type="text" class="form-control" id="type_title" name="type_title"
                            placeholder="Type Title" maxlength="50">
                        <label class="ms-2" for="type_title">Type Title</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" id="type_description" name="type_description" placeholder="Type Description"
                            maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="type_description">Type Description</label>
                    </div>

                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="type_status" name="type_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="type_status">Status</label>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveCourseType();"
                        id="addCourse_btn">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Offcanvas Add Audio Category -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="addCourse_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Course Details</h5>
            <button type="button" class="btn-close closeCanvas1" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="course_form">

                <input type="hidden" id="course_id" name="course_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <select class="form-control" id="course_type" name="course_type">
                            <option value="">Choose</option>
                        </select>
                        <label class="ms-2" for="course_type">Course Type</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="course_title" name="course_title"
                            placeholder="Course Title" maxlength="50">
                        <label class="ms-2" for="course_title">Course Title</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control custom-ckeditor" id="course_description" name="course_description"
                            placeholder="Course Description" maxlength="250" style="height:150px;"></textarea>
                        <!-- <label class="ms-2" for="course_description">Course Description</label> -->
                    </div>
                    {{-- eligibility textarea --}}
                    <div class="form-floating">
                        <textarea class="form-control custom-ckeditor" id="course_eligibility" name="course_eligibility"
                            placeholder="Course Eligibility" maxlength="250" style="height:150px;"></textarea>
                    </div>
                    {{-- <div class="form-floating">
                        <input type="text" class="form-control" id="course_instructor" name="course_instructor" placeholder="Course Instructor" maxlength="50">
                        <label class="ms-2" for="course_instructor">Course Instructor</label>
                    </div> --}}

                    <div class="form-floating">
                        <input type="number" class="form-control" id="course_duration" name="course_duration"
                            placeholder="Course Duration" maxlength="50">
                        <label class="ms-2" for="course_duration">Course Duration (Minutes)</label>
                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" id="course_total_lectures"
                            name="course_total_lectures" placeholder="Course Total Lectures" maxlength="50">
                        <label class="ms-2" for="course_total_lectures">Course Lectures</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-control" id="course_level" name="course_level">
                            <option value="">Choose</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                        </select>
                        <label class="ms-2" for="course_level">Course Level</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-control" id="course_language" name="course_language">
                            <option value="">Choose</option>
                            <option value="Urdu">Urdu</option>
                            <option value="Arabic">Arabic</option>
                            <option value="English">English</option>
                        </select>
                        <label class="ms-2" for="course_language">Course Language</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-control" id="course_certificate" name="course_certificate">
                            <option value="">Choose</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label class="ms-2" for="course_certificate">Course Certificate</label>
                    </div>

                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="course_status" name="course_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="course_status">Status</label>
                    </div>
                    {{-- add instructor --}}
                    <div class="row">
                        <div class="col-4 my-2">
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="add_instructor_row">
                                Add Instructor
                            </button>
                        </div>

                        <div class="col-12" id="instructor_fields_container">

                            <!-- <div class="d-flex align-items-center justify-content-between field_div">
                                    <div class="form-floating col-11 my-2">
                                        <input class="form-control" type="text" id="course_video_url1" name="video[1][url]" placeholder="Enter Youtube URL 1">
                                        <label class="ms-2" for="course_video_url1">Youtube URL</label>
                                    </div>
                                    <svg class="cross-svg remove_task" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                                        <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                                    </svg>
                                </div> -->
                        </div>
                    </div>
                    {{-- add instructor end --}}
                    <div class="row">
                        <div class="col-4 my-2">
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addthumbnail_btn">
                                Add Thumbnail
                            </button>
                        </div>

                        <input type="file" id="thumbnail_file" name="thumbnail" accept="image/*" single
                            style="display:none;">
                        <div class="col-12 my-2">
                            <img class="thumbnail_preview" src=""
                                style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-4 my-2">
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="add_row">
                                Add Video URL
                            </button>
                        </div>

                        <div class="col-12" id="fields_container">

                            <!-- <div class="d-flex align-items-center justify-content-between field_div">
                                    <div class="form-floating col-11 my-2">
                                        <input class="form-control" type="text" id="course_video_url1" name="video[1][url]" placeholder="Enter Youtube URL 1">
                                        <label class="ms-2" for="course_video_url1">Youtube URL</label>
                                    </div>
                                    <svg class="cross-svg remove_task" xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 15 15">
                                        <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27"></path>
                                    </svg>
                                </div> -->
                        </div>
                    </div>


                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas1">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveCourse();"
                        id="saveCourse_btn">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="delete_confirm_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/images/remove.png') }}" width="60" alt="">
                    <h6 class="text-danger mt-3">
                        Are you sure you want to delete this record?
                    </h6>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none">
                    <button type="button" class="btn btn-secondary px-5" id="close_confirm">No</button>
                    <button type="button" class="btn btn-danger px-5" id="deleteConfirm_btn">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/customjs/script_courseTypes.js') }}"></script>
    <!-- <script>
        $('#admin-query').DataTable({
            responsive: true,
        });
    </script> -->
    <script>
        const formValues = {};
        // Function to get all form values
        document.querySelectorAll('.filterBtn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                let formValues = {};
                let filterContainer = button.closest('.filter-dropdown-menu');

                filterContainer.querySelectorAll('.filterApplicantsInput').forEach(function(input) {
                    if (input.type === 'checkbox') {
                        if (!formValues[input.name]) {
                            formValues[input.name] = [];
                        }
                        if (input.checked) {
                            formValues[input.name].push(input.value);
                        }
                    } else if (input.type === 'radio') {
                        if (input.checked) {
                            formValues[input.name] = input.value;
                        }
                    } else if (input.type === 'select-one') {
                        formValues[input.name] = input.value;
                    } else {
                        formValues[input.name] = input.value;
                    }
                });

                getCourseTypesPageData(formValues);
                console.log(formValues);
            });
        });

        document.querySelectorAll('.resetappbtn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                let filterContainer = button.closest('.filter-dropdown-menu');

                filterContainer.querySelectorAll('.filterApplicantsInput').forEach(function(input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });

                getCourseTypesPageData();
            });
        });
    </script>
@endpush
