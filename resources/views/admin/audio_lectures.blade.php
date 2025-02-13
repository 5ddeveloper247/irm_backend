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
            right: 8px;
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
                            <h5 class="mb-0">Audio Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Audio Lectures</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#category-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">
                        Audio Categories</button>
                </li>
                <li class="nav-item fs-3" role="presentation">
                    <button class="nav-link" id="lectures-tab" data-bs-toggle="tab" data-bs-target="#lectures-tab-pane"
                        type="button" role="tab" aria-controls="lectures-tab-pane" aria-selected="true">Audio
                        Lectures</button>
                </li>
                <!-- <li class="nav-item ms-2" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                            type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                            Marked for test</button>
                    </li> -->
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
                                                @php 
                                                $button = '<a href="javascript:void(0);"
                                                                class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white"
                                                                data-bs-toggle="offcanvas"
                                                                onclick="addNewCategory();"><!-- data-bs-toggle="offcanvas" data-bs-target="#addAudioCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Audio Category
                                                            </a>';
                                                $filters = [
                                                    // see on Audio Category table
                                                    // Category Name
                                                    [
                                                        'name' => 'category_name',
                                                        'type' => 'text',
                                                        'label' => 'Category Name',
                                                        'placeholder' => 'Search Category Name',
                                                    ],
                                                    // Date
                                                    ['name' => 'date', 'type' => 'date', 'label' => 'Date'],
                                                    // Status select
                                                    [
                                                        'name' => 'status',
                                                        'type' => 'select',
                                                        'label' => 'Status',
                                                        'options' => [
                                                            ['value' => '', 'label' => 'Select Status'],
                                                            ['value' => '1', 'label' => 'Active'],
                                                            ['value' => '0', 'label' => 'Inactive'],
                                                        ],
                                                    ],
                                                    // ['name' => 'username', 'type' => 'text', 'label' => 'User Name', 'placeholder' => 'Search Username'],
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
                                                        <table id="audioCategory_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Category Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="audioCategory_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="lectures-tab-pane" role="tabpanel"
                                    aria-labelledby="schedule-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- filter --}}
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewAudioLecture();">
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Audio Lecture
                                                            </a>';
                                                    $filters = [
                                                        // see on lectures table
                                                        // Lecture Name
                                                        [
                                                            'name' => 'lecture_name',
                                                            'type' => 'text',
                                                            'label' => 'Lecture Name',
                                                            'placeholder' => 'Search Lecture Name',
                                                        ],
                                                        // Category Name
                                                        [
                                                            'name' => 'category_name',
                                                            'type' => 'text',
                                                            'label' => 'Category Name',
                                                            'placeholder' => 'Search Category Name',
                                                        ],
                                                        // Description
                                                        // ['name' => 'description', 'type' => 'text', 'label' => 'Description', 'placeholder' => 'Search Description'],
                                                        // Date
                                                        ['name' => 'date', 'type' => 'date', 'label' => 'Date'],
                                                        // Status select
                                                        [
                                                            'name' => 'status',
                                                            'type' => 'select',
                                                            'label' => 'Status',
                                                            'options' => [
                                                                ['value' => '', 'label' => 'Select Status'],
                                                                ['value' => '1', 'label' => 'Active'],
                                                                ['value' => '0', 'label' => 'Inactive'],
                                                            ],
                                                        ],
                                                        // ['name' => 'username', 'type' => 'text', 'label' => 'User Name', 'placeholder' => 'Search Username'],
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
                                                        <table id="audioLecture_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Lecture Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        category Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="audioLecture_table_body">

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
        id="addAudioCategory_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Audio Category Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="category_form">

                <input type="hidden" id="category_id" name="category_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <input type="text" class="form-control" id="category_title" name="category_title"
                            placeholder="Category Title" maxlength="50">
                        <label class="ms-2" for="category_title">Category Title</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" id="category_description" name="category_description"
                            placeholder="Category Description" maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="category_description">Category Description</label>
                    </div>

                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="category_status" name="category_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="category_status">Status</label>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveAudioCategory();"
                        id="addCategory_btn">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Offcanvas Add Audio Category -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="addAudio_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Audio Details</h5>
            <button type="button" class="btn-close closeCanvas1" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="audio_form">

                <input type="hidden" id="audio_id" name="audio_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <select class="form-control" id="audio_category" name="audio_category">
                            <option value="">Choose</option>

                        </select>
                        <label class="ms-2" for="audio_category">Audio Category</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="audio_title" name="audio_title"
                            placeholder="Audio Title" maxlength="50">
                        <label class="ms-2" for="audio_title">Audio Title</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" id="audio_description" name="audio_description" placeholder="Audio Description"
                            maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="audio_description">Audio Description</label>
                    </div>

                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="audio_status" name="audio_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="audio_status">Status</label>
                    </div>

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
                        <div class="col-4">
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addAudio_btn">
                                Upload Audio Files
                            </button>
                        </div>

                        <input type="file" id="audio_files" name="" accept="audio/*" single
                            style="display:none;">
                        <div class="row" id="file-container">
                            <!-- Audio Files Container -->
                        </div>
                        <div class="row" id="file-container-uploaded">
                            <!-- Audio Files Container -->
                        </div>
                    </div>
                    {{-- audio_duration --}}
                    <div class="form-floating audio_duration" style="display: none;">
                        <input type="text" class="form-control" id="audio_duration" readonly name="audio_duration"
                            placeholder="Audio Duration" maxlength="50">
                        <label class="ms-2" for="audio_duration">Audio Duration Sec</label>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas1">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveAudioLecture();"
                        id="saveAudio_btn">Add</button>
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
    <script src="{{ asset('assets/customjs/script_audioLectures.js') }}"></script>
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
                getAudioLecturesPageData(formValues);
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

                getAudioLecturesPageData();
            });
        });
    </script>
@endpush
