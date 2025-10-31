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

        .details-container {
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-top: 40px;
        }

        .details-header {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #495057;
        }

        .detail-value {
            color: #6c757d;
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
                            <h5 class="mb-0">Book Orders</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">bookorders</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- View Book Order Modal -->
            <div class="modal fade" id="view_bookorder_modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-eye me-2"></i>Book Order Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Order ID:</strong>
                                    <p id="view_order_id"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Book Name:</strong>
                                    <p id="view_book_name"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Price:</strong>
                                    <p id="view_book_price"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Order Status:</strong>
                                    <p id="view_order_status"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Order Date:</strong>
                                    <p id="view_order_date"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Payment Method:</strong>
                                    <p id="view_order_payment_method"></p>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mb-3">Customer Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Name:</strong>
                                    <p id="view_order_customer_name"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Email:</strong>
                                    <p id="view_order_customer_email"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Phone:</strong>
                                    <p id="view_order_customer_phone"></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>Address:</strong>
                                    <p id="view_order_customer_address"></p>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mb-3">Payment Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Payment Status:</strong>
                                    <p id="view_order_payment_status"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Payment Amount:</strong>
                                    <p id="view_order_payment_amount"></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>Payment Date:</strong>
                                    <p id="view_order_payment_date"></p>
                                </div>
                            </div>

                            <div id="order_receipt_section" style="display: none;">
                                <hr>
                                <h6 class="mb-3">Payment Receipt</h6>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <strong>File Name:</strong>
                                        <p id="order_receipt_name"></p>
                                    </div>
                                    <div class="col-12 mb-3" id="order_receipt_preview"></div>
                                    <div class="col-12">
                                        <a href="#" id="download_order_receipt_btn" class="btn btn-primary me-2"
                                            download>
                                            <i class="fas fa-download me-2"></i>Download
                                        </a>
                                        <button type="button" id="view_order_receipt_btn" class="btn btn-info"
                                            onclick="">
                                            <i class="fas fa-external-link-alt me-2"></i>Open in New Tab
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div id="view_order_action_section" class="me-auto"></div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt Image Modal -->
            <div class="modal fade" id="order_receipt_image_modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Receipt Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="order_receipt_image_modal_img" src="" class="img-fluid"
                                style="max-height: 80vh;" />
                        </div>
                    </div>
                </div>
            </div>

            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#category-tab-pane" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false">
                        All</button>
                </li>
                {{-- Pendding --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        Pending</button>
                </li>
                {{-- Shipped --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped-tab-pane"
                        type="button" role="tab" aria-controls="shipped-tab-pane" aria-selected="false">
                        Shipped</button>
                </li>
                {{-- Delivered --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Delivered-tab" data-bs-toggle="tab"
                        data-bs-target="#Delivered-tab-pane" type="button" role="tab"
                        aria-controls="Delivered-tab-pane" aria-selected="false">
                        Delivered</button>
                </li>

                {{-- Completed --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#completed-tab-pane"
                        type="button" role="tab" aria-controls="completed-tab-pane" aria-selected="false">
                        Completed</button>
                </li>
                {{-- payment --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-tab-pane"
                        type="button" role="tab" aria-controls="payment-tab-pane" aria-selected="false">
                        Payment</button>
                </li>


            </ul>




            <div class="student" id="bookOrders-page">
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
                                                            'name' => 'book_name',
                                                            'type' => 'text',
                                                            'label' => 'Book Name',
                                                            'placeholder' => 'Search Book Name',
                                                        ],
                                                        // price
                                                        [
                                                            'name' => 'price',
                                                            'type' => 'text',
                                                            'label' => 'Price',
                                                            'placeholder' => 'Search Price',
                                                        ],
                                                        [
                                                            'name' => 'name',
                                                            'type' => 'text',
                                                            'label' => 'Name',
                                                            'placeholder' => 'Search Name',
                                                        ],
                                                        [
                                                            'name' => 'email',
                                                            'type' => 'text',
                                                            'label' => 'Email',
                                                            'placeholder' => 'Search Email',
                                                        ],
                                                        [
                                                            'name' => 'status',
                                                            'type' => 'select',
                                                            'label' => 'Status',
                                                            'options' => [
                                                                ['value' => '1', 'label' => 'Pending'],
                                                                ['value' => '2', 'label' => 'Shipped'],
                                                                ['value' => '3', 'label' => 'Delivered'],
                                                                ['value' => '4', 'label' => 'Completed'],
                                                            ],
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


                                                    <div class="table-responsive list-view-div w-100 mt-3">
                                                        <!-- overflow-x:clip; -->
                                                        <table id="bookOrders_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Book
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Price (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Email</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="bookOrders_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pendding --}}
                                <div class="tab-pane fade show" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="home-tab-pane" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table names
                                                        [
                                                            'name' => 'book_name',
                                                            'type' => 'text',
                                                            'label' => 'Book Name',
                                                            'placeholder' => 'Search Book Name',
                                                        ],
                                                        // price
                                                        [
                                                            'name' => 'price',
                                                            'type' => 'text',
                                                            'label' => 'Price',
                                                            'placeholder' => 'Search Price',
                                                        ],
                                                        [
                                                            'name' => 'name',
                                                            'type' => 'text',
                                                            'label' => 'Name',
                                                            'placeholder' => 'Search Name',
                                                        ],
                                                        [
                                                            'name' => 'email',
                                                            'type' => 'text',
                                                            'label' => 'Email',
                                                            'placeholder' => 'Search Email',
                                                        ],
                                                        // [
                                                        //     'name' => 'status',
                                                        //     'type' => 'select',
                                                        //     'label' => 'Status',
                                                        //     'options' => [
                                                        //         ['value' => '1', 'label' => 'Pending'],
                                                        //         ['value' => '2', 'label' => 'Shipped'],
                                                        //         ['value' => '3', 'label' => 'Delivered'],
                                                        //         ['value' => '4', 'label' => 'Completed'],
                                                        //     ],
                                                        // ],
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
                                                        <table id="pending_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Book
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Price (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Email</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="pending_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Pendding --}}
                                {{-- Delivered --}}
                                <div class="tab-pane fade show" id="Delivered-tab-pane" role="tabpanel"
                                    aria-labelledby="Delivered-tab-pane" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">

                                                {{-- include --}}
                                                @php
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table names
                                                        [
                                                            'name' => 'book_name',
                                                            'type' => 'text',
                                                            'label' => 'Book Name',
                                                            'placeholder' => 'Search Book Name',
                                                        ],
                                                        // price
                                                        [
                                                            'name' => 'price',
                                                            'type' => 'text',
                                                            'label' => 'Price',
                                                            'placeholder' => 'Search Price',
                                                        ],
                                                        [
                                                            'name' => 'name',
                                                            'type' => 'text',
                                                            'label' => 'Name',
                                                            'placeholder' => 'Search Name',
                                                        ],
                                                        [
                                                            'name' => 'email',
                                                            'type' => 'text',
                                                            'label' => 'Email',
                                                            'placeholder' => 'Search Email',
                                                        ],
                                                        // [
                                                        //     'name' => 'status',
                                                        //     'type' => 'select',
                                                        //     'label' => 'Status',
                                                        //     'options' => [
                                                        //         ['value' => '1', 'label' => 'Pending'],
                                                        //         ['value' => '2', 'label' => 'Shipped'],
                                                        //         ['value' => '3', 'label' => 'Delivered'],
                                                        //         ['value' => '4', 'label' => 'Completed'],
                                                        //     ],
                                                        // ],
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
                                                        <table id="delivered_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Book
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Price (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Email</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="delivered_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Delivered --}}
                                {{-- shipped-tab-pane --}}
                                <div class="tab-pane fade show" id="shipped-tab-pane" role="tabpanel"
                                    aria-labelledby="shipped-tab-pane" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table names
                                                        [
                                                            'name' => 'book_name',
                                                            'type' => 'text',
                                                            'label' => 'Book Name',
                                                            'placeholder' => 'Search Book Name',
                                                        ],
                                                        // price
                                                        [
                                                            'name' => 'price',
                                                            'type' => 'text',
                                                            'label' => 'Price',
                                                            'placeholder' => 'Search Price',
                                                        ],
                                                        [
                                                            'name' => 'name',
                                                            'type' => 'text',
                                                            'label' => 'Name',
                                                            'placeholder' => 'Search Name',
                                                        ],
                                                        [
                                                            'name' => 'email',
                                                            'type' => 'text',
                                                            'label' => 'Email',
                                                            'placeholder' => 'Search Email',
                                                        ],
                                                        // [
                                                        //     'name' => 'status',
                                                        //     'type' => 'select',
                                                        //     'label' => 'Status',
                                                        //     'options' => [
                                                        //         ['value' => '1', 'label' => 'Pending'],
                                                        //         ['value' => '2', 'label' => 'Shipped'],
                                                        //         ['value' => '3', 'label' => 'Delivered'],
                                                        //         ['value' => '4', 'label' => 'Completed'],
                                                        //     ],
                                                        // ],
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
                                                        <table id="shipped_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Book
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Price (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Email</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="shipped_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- shipped-tab-pane --}}
                                {{-- completed-tab-pane --}}
                                <div class="tab-pane fade show" id="completed-tab-pane" role="tabpanel"
                                    aria-labelledby="completed-tab-pane" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table names
                                                        [
                                                            'name' => 'book_name',
                                                            'type' => 'text',
                                                            'label' => 'Book Name',
                                                            'placeholder' => 'Search Book Name',
                                                        ],
                                                        // price
                                                        [
                                                            'name' => 'price',
                                                            'type' => 'text',
                                                            'label' => 'Price',
                                                            'placeholder' => 'Search Price',
                                                        ],
                                                        [
                                                            'name' => 'name',
                                                            'type' => 'text',
                                                            'label' => 'Name',
                                                            'placeholder' => 'Search Name',
                                                        ],
                                                        [
                                                            'name' => 'email',
                                                            'type' => 'text',
                                                            'label' => 'Email',
                                                            'placeholder' => 'Search Email',
                                                        ],
                                                        // [
                                                        //     'name' => 'status',
                                                        //     'type' => 'select',
                                                        //     'label' => 'Status',
                                                        //     'options' => [
                                                        //         ['value' => '1', 'label' => 'Pending'],
                                                        //         ['value' => '2', 'label' => 'Shipped'],
                                                        //         ['value' => '3', 'label' => 'Delivered'],
                                                        //         ['value' => '4', 'label' => 'Completed'],
                                                        //     ],
                                                        // ],
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
                                                        <table id="completed_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Book
                                                                        Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Price (PKR)</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Email</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="completed_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- completed-tab-pane --}}
                                {{-- payment-tab-pane --}}
                                <div class="tab-pane fade show" id="payment-tab-pane" role="tabpanel"
                                    aria-labelledby="payment-tab-pane" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table payment
                                                        // title
                                                        [
                                                            'name' => 'title',
                                                            'type' => 'text',
                                                            'label' => 'Title',
                                                            'placeholder' => 'Search Title',
                                                        ],
                                                        // amount
                                                        [
                                                            'name' => 'amount',
                                                            'type' => 'text',
                                                            'label' => 'Amount',
                                                            'placeholder' => 'Search Amount',
                                                        ],
                                                        // Payment Indent
                                                        [
                                                            'name' => 'payment_indent',
                                                            'type' => 'text',
                                                            'label' => 'Payment Indent',
                                                            'placeholder' => 'Search Payment Indent',
                                                        ],
                                                        // Date
                                                        ['name' => 'date', 'type' => 'date', 'label' => 'Date'],

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
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Amount (PKR)</th>
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
                                {{-- payment-tab-pane --}}

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="orderBook_confirm_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/images/remove.png') }}" width="60" alt="">
                    <h6 class="text-danger mt-3">
                        Are you sure you want to update the status of this book order?
                    </h6>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none">
                    <button type="button" class="btn btn-secondary px-5" id="close_confirm">No</button>
                    <button type="button" class="btn btn-danger px-5" id="bookOrderConfirm_btn">Yes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- book order details view modal --}}
    {{-- <div class="modal fade" id="bookOrderDetails_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bookOrderDetails_body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bookName" class="form-label">Book Name</label>
                                <input type="text" class="form-control" id="bookName" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="text" class="form-control" id="date" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Payment Method</label>
                                <input type="text" class="form-control" id="paymentMethod" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="paymentStatus" class="form-label">Payment Status</label>
                                <input type="text" class="form-control" id="paymentStatus" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="paymentDate" class="form-label">Payment Date</label>
                                <input type="text" class="form-control" id="paymentDate" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="paymentAmount" class="form-label">Payment Amount</label>
                                <input type="text" class="form-control" id="paymentAmount" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- book order details view modal --}}
@endsection
@push('js')
    <script src="{{ asset('assets/customjs/script_bookOrders.js') }}"></script>
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

                getBookOrdersPageData(formValues);
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

                getBookOrdersPageData();
            });
        });
    </script>
@endpush
