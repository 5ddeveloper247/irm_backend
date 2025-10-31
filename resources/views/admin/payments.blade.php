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

        .dt-buttons {
            margin-top: 0px !important;
            margin-left: 10px !important;
        }

        .cursor-pointer {
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
                            <h5 class="mb-0">Payments</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payments</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            {{-- <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        All Payments</button>
                </li>
            </ul> --}}




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
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table names
                                                        [
                                                            'name' => 'module_code',
                                                            'type' => 'text',
                                                            'label' => 'Module Code',
                                                        ],
                                                        ['name' => 'price', 'type' => 'text', 'label' => 'Price'],
                                                        [
                                                            'name' => 'payment_indent',
                                                            'type' => 'text',
                                                            'label' => 'Payment Indent',
                                                        ],
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


                                                    <div class="table-responsive w-100 mt-3">
                                                        <table id="payments_table" class="table display nowrap"
                                                            style="width:100%">
                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap">Seq No.</th>
                                                                    <th class="text-start text-nowrap">Title</th>
                                                                    <th class="text-start text-nowrap">Module Code</th>
                                                                    <th class="text-start text-nowrap">Price (PKR)</th>
                                                                    <th class="text-start text-nowrap">Payment Indent</th>
                                                                    <th class="text-start text-nowrap">Username</th>
                                                                    <th class="text-start text-nowrap">Email</th>
                                                                    <th class="text-start text-nowrap">Date</th>
                                                                    <th class="text-start text-nowrap">Status</th>
                                                                    <th class="text-start text-nowrap">Action</th>
                                                                </tr>
                                                                {{-- <tr class="filter-row" id="filters-header" style="display: none">
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Seq No."></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Title"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Module Code"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Price"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Payment Indent"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Username"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Email"></th>
                                                                    <th><input type="text" class="column-filter form-control"></th>
                                                                    <th>
                                                                        <select class="column-filter form-control">
                                                                            <option value="">All</option>
                                                                            <option value="Paid">Paid</option>
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Failed">Failed</option>
                                                                        </select>
                                                                    </th>
                                                                </tr> --}}
                                                            </thead>
                                                            {{-- <tfoot>
                                                                <tr>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Seq No."></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Module Code"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Price"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Payment Indent"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Username"></th>
                                                                    <th><input type="text" class="column-filter form-control" placeholder="Filter Email"></th>
                                                                    <th><input type="date" class="column-filter form-control"></th>
                                                                    <th>
                                                                        <select class="column-filter form-control">
                                                                            <option value="">All</option>
                                                                            <option value="Paid">Paid</option>
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Failed">Failed</option>
                                                                        </select>
                                                                    </th>
                                                                </tr>
                                                            </tfoot> --}}
                                                            <tbody id="payments_table_body">
                                                                <!-- Dynamic Data -->
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

    <!-- View Payment Modal -->
    <div class="modal fade" id="view_payment_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i>Payment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Payment ID:</strong>
                            <p id="view_payment_id"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Amount:</strong>
                            <p id="view_payment_amount"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Status:</strong>
                            <p id="view_payment_status"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Payment Intent:</strong>
                            <p id="view_payment_intent"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Payment Method:</strong>
                            <p id="view_payment_method"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Module:</strong>
                            <p id="view_module_code"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Category:</strong>
                            <p id="view_category"></p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Title:</strong>
                            <p id="view_module_title"></p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Date:</strong>
                            <p id="view_payment_date"></p>
                        </div>
                    </div>

                    <hr>
                    <h6 class="mb-3">Customer Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Name:</strong>
                            <p id="view_customer_name"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p id="view_customer_email"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Phone:</strong>
                            <p id="view_customer_phone"></p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Address:</strong>
                            <p id="view_customer_address"></p>
                        </div>
                    </div>

                    <div id="receipt_section">
                        <hr>
                        <h6 class="mb-3">Payment Receipt</h6>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <strong>File Name:</strong>
                                <p id="receipt_name"></p>
                            </div>
                            <div class="col-12 mb-3" id="receipt_preview"></div>
                            <div class="col-12">
                                <a href="#" id="download_receipt_btn" class="btn btn-primary me-2" download>
                                    <i class="fas fa-download me-2"></i>Download
                                </a>
                                <button type="button" id="view_receipt_btn" class="btn btn-info" onclick="">
                                    <i class="fas fa-external-link-alt me-2"></i>Open in New Tab
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Image Modal -->
    <div class="modal fade" id="receipt_image_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Receipt Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="receipt_image_modal_img" src="" class="img-fluid" style="max-height: 80vh;" />
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/customjs/script_payments.js') }}"></script>
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

                getPaymentsPageData(formValues);
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

                getPaymentsPageData();
            });
        });
    </script>
@endpush
