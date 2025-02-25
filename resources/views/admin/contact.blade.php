@extends('layouts.admin.admin_master')

@push('css')
    <style>
        .card-header{
            background: var(--second-primary-color);
            color: white;
        }
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
                            <h5 class="mb-0">Contacts</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            {{-- <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        All Contact</button>
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
                                                        ['name' => 'name', 'type' => 'text', 'label' => 'Name', 'placeholder' => 'Search Name'],
                                                        ['name' => 'email', 'type' => 'text', 'label' => 'Email', 'placeholder' => 'Search Email'],
                                                        ['name' => 'phone', 'type' => 'text', 'label' => 'Phone', 'placeholder' => 'Search Phone'],
                                                        ['name' => 'subject', 'type' => 'text', 'label' => 'Subject', 'placeholder' => 'Search Subject'],
                                                        // ['name' => 'message', 'type' => 'text', 'label' => 'Message', 'placeholder' => 'Search Message'],
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
                                                        <table id="contact_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq
                                                                        No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Name
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Email
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Phone
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Subject</th>
                                                                    <th class="text-start text-nowrap" scope="col">
                                                                        Message</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Status
                                                                    </th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="contact_table_body">
                                                                {{-- no_result --}}
                                                            <div id="no_result" class="no_result text-center" style="display:none;">
                                                                <h5>No Result Found</h5>
                                                            </div>
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

    <!-- Offcanvas Add Pdf Category -->
    <div style="max-width:50rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"
        id="replyContact_Canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Contact Reply</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="form_reply_contact">

                <input type="hidden" id="contact_id" name="contact_id" value="">

                <div class="row g-3">

                    <div class="col-6">
                        <p id="contact_name"></p>
                    </div>
                    {{-- email --}}
                    <div class="col-6">
                        <p id="contact_email"></p>
                    </div>
                    {{-- phone --}}
                    <div class="col-6">
                        <p id="contact_phone"></p>
                    </div>
                    {{-- subject --}}
                    <div class="col-6">
                        <p id="contact_subject"></p>
                    </div>
                    <div class="form-floating">
                        <p id="contact_message"></p>
                    </div>

                    {{-- replyMessage --}}
                    <div class="form-floating">
                        <textarea class="form-control" id="reply_message" name="reply_message" placeholder="Type Description"
                            maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="reply_message">Reply Message</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">    
                        <button class="btn btn-success w-100 col-2 py-1 px-2 mt-2 rounded-1" type="button" id="addPdf_btn">
                            <i class="fa-solid fa-link"></i> &nbsp; Attachments
                        </button>
                    </div>
                    {{-- add pnly pdf --}}
                    <input type="file" id="attachment_files" name="attachment_files" multiple single style="display:none;">

                    {{-- <input type="file" id="attachment_files" name="" accept="pdf/*" single style="display:none;"> --}}
                    <div class="row" id="file-container">
                       <!-- Pdf Files Container --> 
                    </div>
                    <div class="row" id="file-container-uploaded">
                       <!-- Pdf Files Container --> 
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveReplyContact();" id="saveReplyContact_btn">Send</button>
                </div>
            </form>
            {{-- replies --}}
            <div class="row mt-3">
                <div class="col-12">
                    <h5 id="replies_label">Replies</h5>
                    <div id="replies_container">
                        <!-- Replies Container -->
                    </div>
                </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/customjs/script_contact.js') }}"></script>
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
            getContactPageData(formValues);
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
            getContactPageData();
        });
    </script>
@endpush
