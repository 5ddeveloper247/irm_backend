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

        .select2-container {
            width: 100% !important;

        }

        .select2-container .select2-selection {
            height: 55px !important;
        }
    </style>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        #search-box {
            margin-top: 10px;
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
                            <h5 class="mb-0">Worklocation Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Worklocation</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#worklocations-tab-pane" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false">Worklocation</button>
                </li>
                <!-- <li class="nav-item fs-3" role="presentation">
                                    <button class="nav-link" id="listing-tab" data-bs-toggle="tab"
                                        data-bs-target="#listing-tab-pane" type="button" role="tab" aria-controls="listing-tab-pane"
                                        aria-selected="true">Gallery List</button>
                                </li> -->

            </ul>




            <div class="student">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                            <!-- _____________________________________TABS_______________________________________ -->

                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="worklocations-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- filter --}}
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);"
                                                                class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white"
                                                                onclick="addNewWorklocation();">
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Worklocation
                                                            </a>';
                                                    $filters = [
                                                        // get my page table names
                                                        ['name' => 'title', 'type' => 'text', 'label' => 'Title', 'placeholder' => 'Search Title'],
                                                        ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => [
                                                            ['value' => '1', 'label' => 'Active'],
                                                            ['value' => '0', 'label' => 'In-Active']
                                                        ]],
                                                        // date
                                                        ['name' => 'date', 'type' => 'date', 'label' => 'Date'],
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
                                                        <table id="listing_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Title
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Description
                                                                    </th>
                                                                    {{-- created_at --}}
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Status
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="listing_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="tab-pane fade " id="listing-tab-pane" role="tabpanel" aria-labelledby="schedule-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                        <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4">
                                                        <div class="icon-form mb-3 mb-sm-0">
                                                            <span class="form-icon"></span>
                                                            <input type="text" class="form-control" placeholder="Search Here...">
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-sm-8">
                                                        <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                                            <a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewGallery();">
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Gallery
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                                <hr>
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3"><!-- overflow-x:clip; -->
                                                        <table id="gallery_table" class="table visitor-book-table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Gallery Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Type Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="gallery_table_body">
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Add News Worklocation -->
    <div style="max-width:43rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="addWorklocation_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Location</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="newsWorklocation_form">

                <input type="hidden" id="worklocation_id" name="worklocation_id" value="">

                <div class="row g-3">


                    <div class="form-floating">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                            maxlength="50">
                        <label class="ms-2" for="title">Title*</label>
                    </div>
                    {{-- color --}}
                    <div class="form-floating">
                        <input type="color" class="form-control" id="color" name="color" placeholder="Color">
                        <label class="ms-2" for="color">Color*</label>
                    </div>
                    {{-- lat & lng --}}
                    <div class="form-floating">
                        <input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude"
                            readonly>
                        <label class="ms-2" for="lat">Latitude*</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="lng" name="lng"
                            placeholder="Longitude" readonly>
                        <label class="ms-2" for="lng">Longitude*</label>
                    </div>
                    {{-- descriptions --}}
                    <div class="">
                        <textarea class="form-control" id="descriptions" name="descriptions" rows="5" placeholder="Description"
                            maxlength="200"></textarea>
                        {{-- <label class="ms-2" for="descriptions">Description</label> --}}
                    </div>

                    <div class="form-floating">
                        <select class="form-control" id="status" name="status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="status">Status*</label>
                    </div>
                    <h3>Select a Location</h3>
                    {{-- <input id="search-box" type="text" placeholder="Search for a place" /> --}}
                    <div id="map"></div>
                    {{-- <p id="coordinates">
                        Click on the map or search for a location to see the coordinates.
                    </p> --}}
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveWorklocation();"
                        id="saveWorklocation_btn">Add</button>
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
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIWqK6P-vh-UBkXC-3bfddjhNUzAp6Z_A&libraries=places"> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwsQKB077FuvOAYF_ZgE01TOGC-sX0-3Y&libraries=places">
    </script>
    <script src="{{ asset('assets/customjs/script_worklocation.js') }}"></script>
    <!-- <script>
        $('#admin-query').DataTable({
            responsive: true,
        });
    </script> -->
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
            getWorklocationPageData(formValues);
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
            getWorklocationPageData();
        });
    </script>
@endpush
