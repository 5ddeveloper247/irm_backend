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
                            <h5 class="mb-0">Books Library</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Books Library</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                {{-- category --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        Book Category</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="profile-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        All Books</button>
                </li>
            </ul>




            <div class="student">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                            <!-- _____________________________________TABS_______________________________________ -->

                            <div class="tab-content" id="myTabContent">
                                {{-- category --}}
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                <div class="row align-items-center justify-content-end w-100 g-0">
                                                    <div
                                                        class="col-sm-6 d-flex align-items-center justify-content-end gap-3 px-0">
                                                        <div class="form-sorts dropdown me-2">
                                                            <a class="d-flex gap-1 show" data-bs-toggle="dropdown"
                                                                data-bs-auto-close="outside" aria-expanded="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                                    height="1em" viewBox="0 0 24 24">
                                                                    <path fill="none" stroke="currentColor"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="m12 20l-3 1v-8.5L4.52 7.572A2 2 0 0 1 4 6.227V4h16v2.172a2 2 0 0 1-.586 1.414L15 12v2m4 8v-6m3 3l-3-3l-3 3">
                                                                    </path>
                                                                </svg>
                                                                Filter
                                                            </a>
                                                            <div class="filter-dropdown-menu dropdown-menu dropdown-menu-md-end p-3"
                                                                data-popper-placement="bottom-end"
                                                                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 40.8889px, 0px);">
                                                                <div class="filter-set-view">
                                                                    <div
                                                                        class="filter-set-head d-flex align-items-center gap-1">
                                                                        <h5 class="fw-bold mb-0">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <path fill="none" stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" stroke-width="2"
                                                                                    d="m12 20l-3 1v-8.5L4.52 7.572A2 2 0 0 1 4 6.227V4h16v2.172a2 2 0 0 1-.586 1.414L15 12v2m4 8v-6m3 3l-3-3l-3 3">
                                                                                </path>
                                                                            </svg>
                                                                            Filter
                                                                        </h5>
                                                                    </div>

                                                                    <div class="accordion mt-4" id="accordionExample">
                                                                        <div class="filter-set-content mb-3">
                                                                            <div
                                                                                class="filter-set-content-head d-flex gap-1">
                                                                                <a href="#" data-bs-toggle="collapse"
                                                                                    data-bs-target="#collapsecategory_name"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapsecategory_name">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="1.3em" height="1.3em"
                                                                                        viewBox="0 0 48 48">
                                                                                        <path fill="none"
                                                                                            stroke="currentColor"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="4"
                                                                                            d="m19 12l12 12l-12 12"></path>
                                                                                    </svg>
                                                                                    Category Name
                                                                                </a>
                                                                            </div>

                                                                            <div class="filter-set-contents accordion-collapse collapse"
                                                                                id="collapsecategory_name"
                                                                                data-bs-parent="#accordionExample">
                                                                                <div class="filter-content-list px-3 py-2">
                                                                                    <div class="mb-2 icon-form">
                                                                                        <span class="form-icon"></span>
                                                                                        <input type="text"
                                                                                            name="category_name"
                                                                                            class="form-control filterApplicantsInput"
                                                                                            placeholder="Search Category Name">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="filter-set-content mb-3">
                                                                            <div
                                                                                class="filter-set-content-head d-flex gap-1">
                                                                                <a href="#"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#collapsestatus"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapsestatus">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="1.3em" height="1.3em"
                                                                                        viewBox="0 0 48 48">
                                                                                        <path fill="none"
                                                                                            stroke="currentColor"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="4"
                                                                                            d="m19 12l12 12l-12 12"></path>
                                                                                    </svg>
                                                                                    Status
                                                                                </a>
                                                                            </div>

                                                                            <div class="filter-set-contents accordion-collapse collapse"
                                                                                id="collapsestatus"
                                                                                data-bs-parent="#accordionExample">
                                                                                <div class="filter-content-list px-3 py-2">
                                                                                    <div class="mb-2">
                                                                                        <select name="status"
                                                                                            class="form-control filterApplicantsInput">
                                                                                            <option value="">Select
                                                                                                Status</option>
                                                                                            <option value="1">Active
                                                                                            </option>
                                                                                            <option value="0">Inactive
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="filter-reset-btns">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <a href="#"
                                                                                    class="btn btn-secondary w-100 resetappbtn"
                                                                                    id="resetFilterButton2">Reset</a>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <a href="#"
                                                                                    class="btn btn-danger w-100 filterBtn"
                                                                                    id="filterButton2">Filter</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span>
                                                            <a href="javascript:void(0);"
                                                                class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white"
                                                                data-bs-toggle="offcanvas"
                                                                onclick="addNewCategory();"><!-- data-bs-toggle="offcanvas" data-bs-target="#addBookCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Book Category
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                {{-- include --}}


                                                <hr>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3">
                                                        <!-- overflow-x:clip; -->
                                                        <table id="bookCategory_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Category Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="bookCategory_table_body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="category-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                {{-- include --}}
                                                @php
                                                    $button = '<a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" 
                                                            data-bs-toggle="offcanvas" onclick="addNewBook();" ><!-- data-bs-toggle="offcanvas" data-bs-target="#addBookCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add New Book
                                                            </a>';
                                                    $filters = [
                                                        // get columns from library table
                                                        [
                                                            'name' => 'book_title',
                                                            'type' => 'text',
                                                            'label' => 'Book Title',
                                                            'placeholder' => 'Search Book Title',
                                                        ],
                                                        // bookcategory
                                                        [
                                                            'name' => 'book_category',
                                                            'type' => 'text',
                                                            'label' => 'Book Category',
                                                            'placeholder' => 'Search Book Category',
                                                        ],
                                                        [
                                                            'name' => 'book_description',
                                                            'type' => 'text',
                                                            'label' => 'Description',
                                                            'placeholder' => 'Search Description',
                                                        ],
                                                        [
                                                            'name' => 'book_price',
                                                            'type' => 'text',
                                                            'label' => 'Price',
                                                            'placeholder' => 'Search Price',
                                                        ],
                                                        [
                                                            'name' => 'book_date',
                                                            'type' => 'date',
                                                            'label' => 'Book Date',
                                                        ],
                                                        [
                                                            'name' => 'book_status',
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
                                                        <table id="books_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Book
                                                                        Title</th>
                                                                    {{-- book category --}}
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Book Category</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Price (PKR)</th>
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

                                                            <tbody id="books_table_body">

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
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
    id="addBookCategory_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Book Category Details</h5>
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
                    <button type="button" class="btn btn-purple" onclick="saveBookCategory();"
                        id="addCategory_btn">Add</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Offcanvas Add Book Category -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="addBook_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Book Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="book_form">

                <input type="hidden" id="book_id" name="book_id" value="">

                <div class="row g-3">

                    <div class="form-floating">
                        <input type="text" class="form-control" id="book_title" name="book_title"
                            placeholder="Book Title" maxlength="50">
                        <label class="ms-2" for="book_title">Book Title</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" id="book_description" name="book_description" placeholder="Book Description"
                            maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="book_description">Book Description</label>
                    </div>
                    <div class="form-floating">
                        <select class="form-control" id="book_category_id" name="book_category_id">
                            <option value="">Choose</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        <label class="ms-2" for="book_category_id">Book Category</label>
                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" id="book_price" name="book_price"
                            placeholder="Book Price">
                        <label class="ms-2" for="book_price">Book Price (PKR)</label>
                    </div>

                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="book_status" name="book_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="book_status">Status</label>
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
                    {{-- view on home page  --}}
                    <div class="form-floating">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="book_homepage" name="book_homepage">
                            <label class="form-check-label" for="book_homepage">
                              Show on Homepage
                            </label>
                          </div>
                          
                    </div>
                    


                    <div class="row">
                        <div class="col-4 my-2">
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addBook_btn">
                                Add Book
                            </button>
                        </div>

                        <input type="file" id="book_file" name="book" accept=".pdf" style="display:none;">

                        <div class="col-12 my-2">
                            <a href="javascript:;" class="book_preview_a" download>
                                <img class="book_preview" src="{{ asset('assets/images/pdf-placeholder.png') }}"
                                    style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">

                            </a>
                            <div class="book_preview_name"></div>
                        </div>
                    </div>

                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveBook();" id="saveBook_btn">Add</button>
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
    <script src="{{ asset('assets/customjs/script_booksLibrary.js') }}"></script>
    <!-- <script>
        $('#admin-query').DataTable({
            responsive: true,
        });
    </script> -->
    <script>
        $('button[data-bs-toggle="tab"]').on("shown.bs.tab", function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
        // resetFilterButton2
        $('#resetFilterButton2').on('click', function() {
            // Reset all filter inputs
            // category_name
            document.querySelector('input[name="category_name"]').value = '';
            // status
            document.querySelector('select[name="status"]').value = '';
            // Call the function to get books page data with empty filters
            getBooksPageData();

        });
        
        const formValues = {};
        // filterButton2
        $('#filterButton2').on('click', function() {
            // Get all filter inputs
            const categoryName = document.querySelector('input[name="category_name"]').value;
            const status = document.querySelector('select[name="status"]').value;

            // Create an object to hold the filter values
            const formValues = {
                category_name: categoryName,
                status: status
            };

            // Call the function to get books page data with the filter values
            getBooksPageData(formValues);
        });
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

                getBooksPageData(formValues);
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

                getBooksPageData();
            });
        });
    </script>
@endpush
