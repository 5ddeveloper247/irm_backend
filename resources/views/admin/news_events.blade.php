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
            font-size: 20px !important;
            color: red;
            position: relative;
            top: -32px;
            right: 0px;
            cursor:pointer;
        }
        .select2-container {
            width: 100% !important;
            
        }
        .select2-container .select2-selection{
            height: 55px !important;
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
                            <h5 class="mb-0">News & Events Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">News & Events</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" 
                        data-bs-target="#events-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" 
                        aria-selected="false">News & Events</button>
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

                                <div class="tab-pane fade show active" id="events-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4">
                                                        <div class="icon-form mb-3 mb-sm-0">
                                                            <span class="form-icon"></span>
                                                            <input id="search_filter" type="text" class="form-control" placeholder="Search Here...">
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-sm-8">
                                                        <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                                            <a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewEvent();" >
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Event
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                                <hr>
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3"><!-- overflow-x:clip; -->
                                                        <table id="listing_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Title</th>
                                                                    <th class="text-start text-nowrap" scope="col">Type</th>
                                                                    <th class="text-start text-nowrap" scope="col">Start Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">End Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
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

                                {{--<div class="tab-pane fade " id="listing-tab-pane" role="tabpanel" aria-labelledby="schedule-tab" tabindex="0">
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
                                </div>--}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Add News Event -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"  id="addNewsEvents_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">News & Event Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="newsEvent_form">

                <input type="hidden" id="event_id" name="event_id" value="">
                
                <div class="row g-3">
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" maxlength="50">
                        <label class="ms-2" for="title">Title*</label>
                    </div>
                    
                    <div class="form-floating">
                        <textarea class="form-control custom-ckeditor" id="description" name="description" placeholder="Description*" maxlength="250" style="height:150px;"></textarea>
                        <!-- <label class="ms-2" for="description">Description</label> -->
                    </div>

                    
                    
                    <div class="col-6 form-floating">
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
                        <label class="ms-2" for="start_date">Start Date*</label>
                    </div>

                    <div class="col-6 form-floating">
                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="End Date">
                        <label class="ms-2" for="end_date">End Date*</label>
                    </div>
                    
                    <div class="col-6 form-floating">
                        <input type="time" class="form-control" id="event_time" name="event_time" placeholder="Event Time">
                        <label class="ms-2" for="event_time">Event Time*</label>
                    </div>
                    <div class="col-6 form-floating">
                        <input type="date" class="form-control" id="event_date" name="event_date" placeholder="Event Date">
                        <label class="ms-2" for="event_date">Event Date*</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-control" id="event_type" name="event_type">
                            <option value="">Choose</option>
                            <option value="Recurring">Recurring</option>
                            <option value="Non-Recurring">Non-Recurring</option>
                        </select>
                        <label class="ms-2" for="event_type">Event Type*</label>
                    </div>

                    <div class="form-floating" id="recurring_type_div" style="display:none;">
                        <select class="form-control" id="recurring_type" name="recurring_type">
                            <option value="">Choose</option>
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                        <label class="ms-2" for="recurring_type">Recurring Type*</label>
                    </div>

                    <div class="form-floating" id="repeat_on_div" style="display:none;">
                        <select class="form-control select2" id="repeat_on" name="repeat_on[]" multiple="multiple" placeholder="Choose Days">
                            <option value="Mon">Mon</option>
                            <option value="Tue">Tue</option>
                            <option value="Wed">Wed</option>
                            <option value="Thu">Thu</option>
                            <option value="Fri">Fri</option>
                            <option value="Sat">Sat</option>
                            <option value="Sun">Sun</option>
                        </select>
                        <label class="ms-2" for="repeat_on">Repeat On*</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="location" name="location" placeholder="location" maxlength="200">
                        <label class="ms-2" for="location">Location</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-control" id="status" name="status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="status">Status*</label>
                    </div>

                    <div class="row">
                        <div class="col-4">    
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addImage_btn">
                                Upload Image
                            </button>
                        </div>
                        
                        <input type="file" id="image_file" name="" accept="image/*" single style="display:none;">
                        <div class="row" id="file_container">
                           <!-- Image Files Container --> 
                        </div>
                        <div class="row" id="file_container_uploaded">
                           <!-- Image Files Container --> 
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveEvent();" id="saveEvent_btn">Add</button>
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
    <script src="{{asset('assets/customjs/script_newsEvents.js')}}"></script>
    <!-- <script>
        $('#admin-query').DataTable({
            responsive: true,
        });
    </script> -->
@endpush
