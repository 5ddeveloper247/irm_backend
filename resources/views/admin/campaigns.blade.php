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
                            <h5 class="mb-0">Campaigns Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Campaigns</li>
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
                        All Campaigns</button>
                </li>
                {{-- payments --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="paymenttab" data-bs-toggle="tab" data-bs-target="#payment-tab"
                        type="button" role="tab" aria-controls="payment-tab" aria-selected="false">
                        Payments</button>
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
                                                    $button = '<a href="javascript:void(0);"
                                                                class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white"
                                                                data-bs-toggle="offcanvas"
                                                                onclick="addNewCampaign();"><!-- data-bs-toggle="offcanvas" data-bs-target="#addAudioCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add New Campaigns
                                                            </a>';
                                                    $filters = [
                                                        // get columns from Campaigns table
                                                        [
                                                            'name' => 'campaign_title',
                                                            'type' => 'text',
                                                            'label' => 'Campaign Title',
                                                            'placeholder' => 'Search Campaign Title',
                                                        ],

                                                        [
                                                            'name' => 'campaign_target_amount',
                                                            'type' => 'text',
                                                            'label' => 'Target Amount',
                                                            'placeholder' => 'Search Target Amount',
                                                        ],
                                                        // campaign_date
                                                        [
                                                            'name' => 'campaign_date',
                                                            'type' => 'date',
                                                            'label' => 'Date',
                                                        ],
                                                        [
                                                            'name' => 'campaign_status',
                                                            'type' => 'select',
                                                            'label' => 'Status',
                                                            'options' => [
                                                                ['value' => '', 'label' => 'Select Status'],
                                                                ['value' => '1', 'label' => 'Active'],
                                                                ['value' => '0', 'label' => 'In-Active'],
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
                                                        <table id="campaign_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Campaigns Title</th>
                                                                        {{-- Task Amount --}}
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Task Amount (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Target (PKR)</th>
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

                                                            <tbody id="campaign_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- paym --}}

                                <div class="tab-pane fade" id="payment-tab" role="tabpanel" aria-labelledby="payment-tab"
                                    tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);"
                                                                class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white"
                                                                data-bs-toggle="offcanvas"
                                                                onclick="addMannualPayment();"><!-- data-bs-toggle="offcanvas" data-bs-target="#addAudioCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Mannual Payment
                                                            </a>';
                                                    $filters = [
                                                        // get columns from Payment table
                                                        [
                                                            'name' => 'campaign_title',
                                                            'type' => 'text',
                                                            'label' => 'Campaign Title',
                                                            'placeholder' => 'Search Campaign Title',
                                                        ],

                                                        [
                                                            'name' => 'payment_amount',
                                                            'type' => 'text',
                                                            'label' => 'Payment Amount',
                                                            'placeholder' => 'Search Payment Amount',
                                                        ],
                                                        // Payment Indent
                                                        [
                                                            'name' => 'payment_indent',
                                                            'type' => 'text',
                                                            'label' => 'Payment Indent',
                                                            'placeholder' => 'Search Payment Indent',
                                                        ],
                                                        ['name' => 'payment_date', 'type' => 'date', 'label' => 'Date'],
                                                        [
                                                            'name' => 'payment_status',
                                                            'type' => 'select',
                                                            'label' => 'Status',
                                                            'options' => [
                                                                ['value' => '', 'label' => 'Select Status'],
                                                                ['value' => 'succeeded', 'label' => 'Success'],
                                                                ['value' => 'failed', 'label' => 'Failed'],
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
                                                        <table id="payment_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Title</th>
                                                                    <th class="text-start text-nowrap" scope="col">Amount (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Email</th>
                                                                    
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Payment Indent
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Status</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="payment_table_body">

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
        id="addCampaign_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Campaign Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="campaign_form">

                <input type="hidden" id="campaign_id" name="campaign_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <input type="text" class="form-control" id="campaign_title" name="campaign_title"
                            placeholder="Campaign Title" maxlength="50">
                        <label class="ms-2" for="campaign_title">Campaign Title</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="campaign_tags" name="campaign_tags"
                            placeholder="Campaign Tags" maxlength="50">
                        <label class="ms-2" for="campaign_tags">Campaign Tags</label>
                    </div>
                    <span class="mt-0"><small>Add comma seperated tags here...</small></span>

                    <div class="form-floating">
                        <textarea class="form-control" id="campaign_description" name="campaign_description"
                            placeholder="Campaign Description" maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="campaign_description">Campaign Description</label>
                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" id="campaign_target_amount"
                            name="campaign_target_amount" placeholder="Target Amount">
                        <label class="ms-2" for="campaign_target_amount">Campaign Target Amount (PKR)</label>
                    </div>

                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="campaign_status" name="campaign_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="campaign_status">Status</label>
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
                        <div class="col-4 my-2">
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="add_row">
                                Add Task
                            </button>
                        </div>

                        <div class="col-12" id="tasks_container">

                            <!-- <div class="d-flex align-items-center justify-content-between task_div">
                                            <div class="form-floating col-5 my-2">
                                                <input class="form-control" type="text" id="task_title1" name="tasks[1][title]" placeholder="Enter Title 1">
                                                <label class="ms-2" for="task_title1">Title</label>
                                            </div>
                                            <div class="form-floating col-5 my-2">
                                                <input class="form-control" type="text" id="task_amount1" name="tasks[1][amount]" placeholder="Enter Amount 1">
                                                <label class="ms-2" for="task_amount1">Amount</label>
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
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveCampaign();"
                        id="saveCampaign_btn">Add</button>
                </div>
            </form>
        </div>
    </div>
    {{-- add_payment_canvas --}}
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="add_payment_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Add Manual Payment</h5>
            <button type="button" class="btn-close closePaymentCanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="manual_payment_form">

                <div class="row g-3">

                    <div class="">
                        {{-- campaign title --}}
                        <label class="ms-2" for="payment_campaign_id">Campaign Title</label>
                        <select class="form-select select2 p-5" id="payment_campaign_id" name="payment_campaign_id">
                            <option value="">Select Campaign</option>
                        </select>

                    </div>

                    {{-- select shows according to campaign tasks --}}
                    <div class="">
                        <label class="ms-2" for="payment_task_id">Task</label>
                        <select class="form-select select2 p-5" id="payment_task_id" name="payment_task_id">
                            <option value="">Select Task</option>
                        </select>

                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" id="campaign_amount" name="campaign_amount"
                            placeholder="Target Amount">
                        <label class="ms-2" for="campaign_amount">Campaign Amount (PKR)</label>
                    </div>

                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closePaymentCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="manual_payment_form();"
                        id="manual_payment_btn">Add</button>
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
    <script src="{{ asset('assets/customjs/script_campaigns.js') }}"></script>
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

                getCampaignsPageData(formValues);
                getCampaignPayments(formValues);
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

                getCampaignsPageData();
                getCampaignPayments();
            });
        });
    </script>
@endpush
