@extends('layouts.admin.admin_master')

@push('css')
    <style>
        ul.dropdown-menu-custom {
            transform: translateX(-17px) !important;
        }
        /* .collapse.show {
            background-color: #ecf4ff00 !important;
        } */
        
        .img-prev{
            width: 70px;height: 70px;object-fit: cover;border-radius: 10px;
        }
        .cancel-icon{
            font-size: 18px !important;
            color: red;
            /* position: absolute;
            top: 265px; */
        }
       
        .dt-buttons{
            margin-top: 0px !important;
            margin-left: 10px !important;
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

                                <div class="tab-pane fade show active" id="category-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '';
                                                    $filters = [
                                                        // get my page table names
                                                        ['name' => 'module_code', 'type' => 'text', 'label' => 'Module Code'],
                                                        ['name' => 'price', 'type' => 'text', 'label' => 'Price'],
                                                        ['name' => 'payment_indent', 'type' => 'text', 'label' => 'Payment Indent'],
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
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive w-100 mt-3">
                                                        <table id="payments_table" class="table display nowrap" style="width:100%">
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
                                                                </tr>
                                                                <tr class="filter-row" id="filters-header" style="display: none">
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
                                                                </tr>
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
@endsection
@push('js')
    <script src="{{asset('assets/customjs/script_payments.js')}}"></script>
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
