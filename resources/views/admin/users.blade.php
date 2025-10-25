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
            font-size: 18px !important;
            color: red;
            /* position: absolute;
                    top: 265px; */
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
                            <h5 class="mb-0">Sub-Admins</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">sub-admins</li>
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
                        All Sub Admins</button>
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
                                                {{-- filter --}}
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);"
                                                                class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white"
                                                                data-bs-toggle="offcanvas"
                                                                onclick="addNewUser();"><!-- data-bs-toggle="offcanvas" data-bs-target="#addAudioCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add New Sub Admin
                                                            </a>';
                                                    $filters = [
                                                        // get my page table names
                                                        [
                                                            'name' => 'name',
                                                            'type' => 'text',
                                                            'label' => 'Name',
                                                            'placeholder' => 'Search Name',
                                                        ],
                                                        [
                                                            'name' => 'username',
                                                            'type' => 'text',
                                                            'label' => 'User Name',
                                                            'placeholder' => 'Search Username',
                                                        ],
                                                        [
                                                            'name' => 'email',
                                                            'type' => 'text',
                                                            'label' => 'Email',
                                                            'placeholder' => 'Search Email',
                                                        ],
                                                        // created_at
                                                        [
                                                            'name' => 'created_at',
                                                            'type' => 'date',
                                                            'label' => 'Created At',
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
                                                {{-- <div class="row align-items-center">
                                                    <div class="col-sm-4">
                                                        <div class="icon-form mb-3 mb-sm-0">
                                                            <span class="form-icon"></span>
                                                            <input id="search_filter" type="text" class="form-control"
                                                                placeholder="Search Here...">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <div
                                                            class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                                            
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <hr>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3">
                                                        <!-- overflow-x:clip; -->
                                                        <table id="users_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">User
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Email
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Created At</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="users_table_body">

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
        id="addUser_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Sub-Admin Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="user_form">

                <input type="hidden" id="user_id" name="user_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                            maxlength="50">
                        <label class="ms-2" for="name">Name </label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="User Title"
                            maxlength="50">
                        <label class="ms-2" for="username">User Name</label>
                    </div>

                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="User Tags" maxlength="100">
                        <label class="ms-2" for="email">Email</label>
                    </div>

                    <div class="form-floating">
                        {{-- password --}}
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" maxlength="50">
                        <label class="ms-2" for="password">Password</label>
                    </div>
                    {{-- c_password --}}
                    <div class="form-floating">
                        <input type="password" class="form-control" id="c_password" name="c_password"
                            placeholder="Confirm Password" maxlength="50">
                        <label class="ms-2" for="c_password">Confirm Password</label>

                        <!-- Status -->
                        <div class="form-floating">
                            <select class="form-control" id="status" name="status">
                                <option value="">Choose</option>
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                            </select>
                            <label class="ms-2" for="status">Status</label>
                        </div>
                        {{-- checkbox menus --}}
                        <div class="row">
                            <div class="col-12">
                                <label class="ms-2 badge-primary" for="menus">
                                    Role / Permissions
                                </label>
                            </div>
                        </div>
                        <div class="row m-1">
                            @foreach ($menus as $menu)
                                {{-- sub-admins  route check --}}
                                @if ($menu->route != 'sub-admins')
                                    <div class="col-6">
                                        <input class="" id="menu_{{ $menu->id }}" type="checkbox"
                                            name="menus[]" value="{{ $menu->id }}" >{{-- @if ($menu->route == 'dashboard') checked disabled @endif --}}
                                        @if ($menu->route == 'dashboard')
                                            <!-- <input type="hidden" name="menus[]" value="{{ $menu->id }}"> -->
                                        @endif
                                        <label class="" for="menu_{{ $menu->id }}">{{ $menu->name }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-4 my-2">
                                <button class="btn btn-purple" type="button" id="addthumbnail_btn">
                                    User Profile
                                </button>
                            </div>

                            <input type="file" id="thumbnail_file" name="thumbnail" accept="image/*" single
                                style="display:none;">
                            <div class="col-12 my-2">
                                <img class="thumbnail_preview" src=""
                                    style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                            </div>
                        </div>

                    </div>
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                        <button type="button" class="btn btn-purple" onclick="saveUser();"
                            id="saveUser_btn">Add</button>
                    </div>
            </form>
        </div>
    </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="delete_confirm_modal" tabindex="-1" aria-labelledby="delete_confirm_modal"
        aria-hidden="true">
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
    <script src="{{ asset('assets/customjs/script_users.js') }}"></script>
    <script>
        // $('#admin-query').DataTable({
        //     responsive: true,
        // });
        // email on change not add spaces
        $('#email').on('change', function() {
            $(this).val($(this).val().replace(/\s/g, ''));
            const email = $(this).val();
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                toastr.error("Invalid Email", "", {
                    timeOut: 3000,
                });
            }
        });
    </script>
    <script>
        const formValues = {};
        // Function to get all form values
        document.getElementById('filterButton').addEventListener('click', function(event) {
            event.preventDefault();

            document.querySelectorAll('.filterApplicantsInput').forEach(function(input) {
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
            getUsersPageData(formValues);
            // Log the form values (You can replace this with your actual save logic)
            console.log(formValues);
        });

        // Function to reset all form values
        document.getElementById('resetFilterButton').addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelectorAll('.filterApplicantsInput').forEach(function(input) {
                if (input.type === 'checkbox') {
                    input.checked = false;
                } else if (input.type === 'radio') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
            });
            // 
            getUsersPageData();
        });
    </script>
@endpush
