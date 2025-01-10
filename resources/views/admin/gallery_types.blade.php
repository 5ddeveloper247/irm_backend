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
    </style>
@endpush

@section('content')
    <div class="student">
        <div class="p-md-1 p-3">
            <div class="container-fluid bg-light py-2">
                <div class="row align-items-center px-2">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Gallery Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Gallery Types</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" 
                        data-bs-target="#category-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" 
                        aria-selected="false">Gallery Types</button>
                </li>
                <li class="nav-item fs-3" role="presentation">
                    <button class="nav-link" id="listing-tab" data-bs-toggle="tab"
                        data-bs-target="#listing-tab-pane" type="button" role="tab" aria-controls="listing-tab-pane"
                        aria-selected="true">Gallery List</button>
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
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4">
                                                        <div class="icon-form mb-3 mb-sm-0">
                                                            <span class="form-icon"></span>
                                                            <input id="search_filter" type="text" class="form-control" placeholder="Search Here...">
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-sm-8">
                                                        <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                                            <a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewType();" >
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Gallery Type
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                                <hr>
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3"><!-- overflow-x:clip; -->
                                                        <table id="galleryType_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Type Title</th>
                                                                    <th class="text-start text-nowrap" scope="col">Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="galleryType_table_body">
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="listing-tab-pane" role="tabpanel" aria-labelledby="schedule-tab" tabindex="0">
                                    <div class="schedule">
                                        <div class="card">

                                        <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4">
                                                        <div class="icon-form mb-3 mb-sm-0">
                                                            <span class="form-icon"></span>
                                                            <input id="search_filter_02" type="text" class="form-control" placeholder="Search Here...">
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
        id="addGalleryType_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Gallery Type Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="type_form">

                <input type="hidden" id="type_id" name="type_id" value="">
                
                <div class="row g-3">
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="type_title" name="type_title" placeholder="Type Title" maxlength="50">
                        <label class="ms-2" for="type_title">Type Title</label>
                    </div>
                    
                    <div class="form-floating">
                        <textarea class="form-control" id="type_description" name="type_description" placeholder="Type Description" maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="type_description">Type Description</label>
                    </div>
                    
                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="type_status" name="type_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="type_status">Status</label>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveGalleryType();" id="addType_btn">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Offcanvas Add Audio Category -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"  id="addGallery_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Gallery Details</h5>
            <button type="button" class="btn-close closeCanvas1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="gallery_form">

                <input type="hidden" id="gallery_id" name="gallery_id" value="">
                
                <div class="row g-3">
                    
                    <div class="form-floating">
                        <select class="form-control" id="gallery_type" name="gallery_type">
                            <option value="">Choose</option>
                        </select>
                        <label class="ms-2" for="gallery_type">Gallery Type</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="gallery_title" name="gallery_title" placeholder="Gallery Title" maxlength="50">
                        <label class="ms-2" for="gallery_title">Gallery Title</label>
                    </div>
                    
                    <div class="form-floating">
                        <textarea class="form-control" id="gallery_description" name="gallery_description" placeholder="Gallery Description" maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="gallery_description">Gallery Description</label>
                    </div>
                    
                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="gallery_status" name="gallery_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="gallery_status">Status</label>
                    </div>

                    <!-- <div class="row">
                        <div class="col-4 my-2">    
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addthumbnail_btn">
                                Add Thumbnail
                            </button>
                        </div>
                        
                        <input type="file" id="thumbnail_file" name="thumbnail" accept="image/*" single style="display:none;">
                        <div class="col-12 my-2">
                            <img class="thumbnail_preview" src="" style="display:none;width: 70px;height: 70px;object-fit: cover;border-radius: 10px;">
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-4">    
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addGallery_btn">
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
                    <button type="button" class="btn btn-secondary me-2 closeCanvas1">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveGallery();" id="saveGallery_btn">Add</button>
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
    <script src="{{asset('assets/customjs/script_galleryTypes.js')}}"></script>
    <!-- <script>
        $('#admin-query').DataTable({
            responsive: true,
        });
    </script> -->
@endpush
