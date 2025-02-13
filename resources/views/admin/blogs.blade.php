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
    </style>
@endpush

@section('content')
    <div class="student">
        <div class="p-md-1 p-3">
            <div class="container-fluid bg-light py-2">
                <div class="row align-items-center px-2">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Blogs</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        All Blogs</button>
                </li>
            </ul>




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
                                                    $button = '<a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" data-bs-toggle="offcanvas" onclick="addNewBlog();" ><!-- data-bs-toggle="offcanvas" data-bs-target="#addAudioCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add New Blog
                                                            </a>';
                                                    $filters = [
                                                        // get columns from blog table
                                                        ['name' => 'author_name', 'type' => 'text', 'label' => 'Author Name', 'placeholder' => 'Search Author Name'],
                                                        ['name' => 'title', 'type' => 'text', 'label' => 'Blog Title', 'placeholder' => 'Search Blog Title'],
                                                        
                                                        ['name' => 'published_date', 'type' => 'date', 'label' => 'Published Date'],
                                                        ['name' => 'end_date', 'type' => 'date', 'label' => 'End Date'],
                                                        ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => [
                                                            ['value' => '1', 'label' => 'Active'],
                                                            ['value' => '0', 'label' => 'In-Active']
                                                        ]],
                                                        
                                                        
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
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3"><!-- overflow-x:clip; -->
                                                        <table id="blogs_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Author Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Blog Title</th>
                                                                    <th class="text-start text-nowrap" scope="col">Published Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">End Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="blogs_table_body">
                                                                
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
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"  id="addBlog_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Blog Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="blog_form">

                <input type="hidden" id="blog_id" name="blog_id" value="">
                
                <div class="row g-3">
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="blog_author_name" name="blog_author_name" placeholder="Author Name" maxlength="50">
                        <label class="ms-2" for="blog_author_name">Author Name</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="blog_title" name="blog_title" placeholder="Blog Title" maxlength="50">
                        <label class="ms-2" for="blog_title">Blog Title</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="blog_tags" name="blog_tags" placeholder="Blog Tags" maxlength="100">
                        <label class="ms-2" for="blog_tags">Tags</label>
                    </div>
                    <span class="mt-0"><small>Add comma seperated tags here...</small></span>

                    <div class="form-floating">
                        <textarea class="form-control custom-ckeditor" id="blog_description" name="blog_description" placeholder="Blog Description" maxlength="250" style="height:150px;"></textarea>
                        <!-- <label class="ms-2" for="book_description">Blog Description</label> -->
                    </div>

                    <div class="form-floating">
                        <input type="date" class="form-control" id="blog_published_date" name="blog_published_date" placeholder="Published Date">
                        <label class="ms-2" for="blog_published_date">Published Date</label>
                    </div>

                    <div class="form-floating">
                        <input type="date" class="form-control" id="blog_end_date" name="blog_end_date" placeholder="End Date">
                        <label class="ms-2" for="blog_end_date">End Date</label>
                    </div>
                    
                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="blog_status" name="blog_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="blog_status">Status</label>
                    </div>

                    <div class="row">
                        <div class="col-4 my-2">    
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addthumbnail_btn">
                                Add Thumbnail
                            </button>
                        </div>
                        
                        <input type="file" id="thumbnail_file" name="thumbnail" accept="image/*" single style="display:none;">
                        <div class="col-12 my-2">
                            <img class="thumbnail_preview" src="" style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                        </div>
                    </div>

                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveBlog();" id="saveBlog_btn">Add</button>
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
                    <img src="{{asset('assets/images/remove.png')}}" width="60" alt="">
                    <h6 class="text-danger mt-3">
                        Are you sure you want to delete this record?
                    </h6>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-center" style="border: none" >
                    <button type="button" class="btn btn-secondary px-5" id="close_confirm">No</button>
                    <button type="button" class="btn btn-danger px-5" id="deleteConfirm_btn">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('assets/customjs/script_blogs.js')}}"></script>
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

                getBlogsPageData(formValues);
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

                getBlogsPageData();
            });
        });
    </script>
@endpush
