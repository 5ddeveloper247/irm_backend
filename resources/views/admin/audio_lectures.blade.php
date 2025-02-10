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
            right: 8px;
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
                            <h5 class="mb-0">Audio Section</h5>
                            <!-- <span class="count-title">123</span> -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Audio Lectures</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>



            <ul style="width:78rem;"class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        Audio Categories</button>
                </li>
                <li class="nav-item fs-3" role="presentation">
                    <button class="nav-link" id="lectures-tab" data-bs-toggle="tab"
                        data-bs-target="#lectures-tab-pane" type="button" role="tab" aria-controls="lectures-tab-pane"
                        aria-selected="true">Audio Lectures</button>
                </li>
                <!-- <li class="nav-item ms-2" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        Marked for test</button>
                </li> -->
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
                                                            <!-- <div class="dropdown me-2">
                                                                <a class="dropdown-toggle shadow d-flex align-items-center gap-1 s-theme-color" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5">
                                                                            <path stroke-linejoin="round" d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                                                            <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                                                            <path stroke-miterlimit="10" d="M19.97 14.245v5" />
                                                                            <path stroke-linejoin="round" d="m22.262 16.35l-1.967-1.967a.46.46 0 0 0-.652 0l-1.967 1.967" />
                                                                        </g>
                                                                    </svg>
                                                                    Export
                                                                    <i class="fa-solid fa-chevron-down"></i>
                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                                                <path fill="currentColor" d="M7.503 13.002a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-.5H8.5a1.5 1.5 0 0 0 0-3zm.997 2h-.497v-1H8.5a.5.5 0 1 1 0 1m6.498-1.5a.5.5 0 0 1 .5-.5h1.505a.5.5 0 1 1 0 1h-1.006l-.001 1.002h1.007a.5.5 0 0 1 0 1h-1.007l.002.497a.5.5 0 0 1-1 .002l-.003-.998v-.002zm-3.498-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h.498a2 2 0 0 0 0-4zm.5 3v-2a1 1 0 0 1 0 2M20 20v-1.164c.591-.281 1-.884 1-1.582V12.75c0-.698-.409-1.3-1-1.582v-1.34a2 2 0 0 0-.586-1.414l-5.829-5.828l-.049-.04l-.036-.03a2 2 0 0 0-.219-.18a1 1 0 0 0-.08-.044l-.048-.024l-.05-.029c-.054-.031-.109-.063-.166-.087a2 2 0 0 0-.624-.138q-.03-.002-.059-.007L12.172 2H6a2 2 0 0 0-2 2v7.168c-.591.281-1 .884-1 1.582v4.504c0 .698.409 1.3 1 1.582V20a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-2 .5H6a.5.5 0 0 1-.5-.5v-.996h13V20a.5.5 0 0 1-.5.5m.5-10.5v1h-13V4a.5.5 0 0 1 .5-.5h6V8a2 2 0 0 0 2 2zm-1.122-1.5H14a.5.5 0 0 1-.5-.5V4.621zm-12.628 4h14.5a.25.25 0 0 1 .25.25v4.504a.25.25 0 0 1-.25.25H4.75a.25.25 0 0 1-.25-.25V12.75a.25.25 0 0 1 .25-.25" />
                                                                            </svg>
                                                                            Export as PDF
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 256 256">
                                                                                <path fill="currentColor" d="M154 208a6 6 0 0 1-6 6h-28a6 6 0 0 1-6-6v-56a6 6 0 1 1 12 0v50h22a6 6 0 0 1 6 6m-62.52-60.89a6 6 0 0 0-8.36 1.39L68 169.67L52.88 148.5a6 6 0 1 0-9.76 7L60.63 180l-17.51 24.5a6 6 0 1 0 9.76 7L68 190.31l15.12 21.16A6 6 0 0 0 88 214a5.9 5.9 0 0 0 3.48-1.12a6 6 0 0 0 1.4-8.37L75.37 180l17.51-24.51a6 6 0 0 0-1.4-8.38M191 173.22c-10.85-3.13-13.41-4.69-13-7.91a6.59 6.59 0 0 1 2.88-5.08c5.6-3.79 17.65-1.83 21.44-.84a6 6 0 0 0 3.07-11.6c-2-.54-20.1-5-31.21 2.48a18.64 18.64 0 0 0-8.08 13.54c-1.8 14.19 12.26 18.25 21.57 20.94c12.12 3.5 14.77 5.33 14.2 9.76a6.85 6.85 0 0 1-3 5.34c-5.61 3.73-17.48 1.64-21.19.62a6 6 0 0 0-3.21 11.53a59.4 59.4 0 0 0 14.68 2c5.49 0 11.54-.95 16.36-4.14a18.89 18.89 0 0 0 8.31-13.81c2.01-15.66-12.91-19.97-22.82-22.83M42 112V40a14 14 0 0 1 14-14h96a6 6 0 0 1 4.24 1.76l56 56A6 6 0 0 1 214 88v24a6 6 0 1 1-12 0V94h-50a6 6 0 0 1-6-6V38H56a2 2 0 0 0-2 2v72a6 6 0 1 1-12 0m116-30h35.5L158 46.48Z" />
                                                                            </svg>
                                                                            Export as Excel
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div> -->

                                                            <a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" 
                                                            data-bs-toggle="offcanvas" onclick="addNewCategory();" ><!-- data-bs-toggle="offcanvas" data-bs-target="#addAudioCategory_canvas" -->
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Audio Category
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                                <hr>
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3"><!-- overflow-x:clip; -->
                                                        <table id="audioCategory_table" class="table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Category Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="audioCategory_table_body">
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="lectures-tab-pane" role="tabpanel"
                                    aria-labelledby="schedule-tab" tabindex="0">
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
                                                            <!-- <div class="dropdown me-2">
                                                                <a class="dropdown-toggle shadow d-flex align-items-center gap-1 s-theme-color" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5">
                                                                            <path stroke-linejoin="round" d="M20.935 11.009V8.793a2.98 2.98 0 0 0-1.529-2.61l-5.957-3.307a2.98 2.98 0 0 0-2.898 0L4.594 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l2.522-1.4" />
                                                                            <path stroke-linejoin="round" d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12" />
                                                                            <path stroke-miterlimit="10" d="M19.97 14.245v5" />
                                                                            <path stroke-linejoin="round" d="m22.262 16.35l-1.967-1.967a.46.46 0 0 0-.652 0l-1.967 1.967" />
                                                                        </g>
                                                                    </svg>
                                                                    Export
                                                                    <i class="fa-solid fa-chevron-down"></i>
                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                                                                                <path fill="currentColor" d="M7.503 13.002a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-.5H8.5a1.5 1.5 0 0 0 0-3zm.997 2h-.497v-1H8.5a.5.5 0 1 1 0 1m6.498-1.5a.5.5 0 0 1 .5-.5h1.505a.5.5 0 1 1 0 1h-1.006l-.001 1.002h1.007a.5.5 0 0 1 0 1h-1.007l.002.497a.5.5 0 0 1-1 .002l-.003-.998v-.002zm-3.498-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h.498a2 2 0 0 0 0-4zm.5 3v-2a1 1 0 0 1 0 2M20 20v-1.164c.591-.281 1-.884 1-1.582V12.75c0-.698-.409-1.3-1-1.582v-1.34a2 2 0 0 0-.586-1.414l-5.829-5.828l-.049-.04l-.036-.03a2 2 0 0 0-.219-.18a1 1 0 0 0-.08-.044l-.048-.024l-.05-.029c-.054-.031-.109-.063-.166-.087a2 2 0 0 0-.624-.138q-.03-.002-.059-.007L12.172 2H6a2 2 0 0 0-2 2v7.168c-.591.281-1 .884-1 1.582v4.504c0 .698.409 1.3 1 1.582V20a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-2 .5H6a.5.5 0 0 1-.5-.5v-.996h13V20a.5.5 0 0 1-.5.5m.5-10.5v1h-13V4a.5.5 0 0 1 .5-.5h6V8a2 2 0 0 0 2 2zm-1.122-1.5H14a.5.5 0 0 1-.5-.5V4.621zm-12.628 4h14.5a.25.25 0 0 1 .25.25v4.504a.25.25 0 0 1-.25.25H4.75a.25.25 0 0 1-.25-.25V12.75a.25.25 0 0 1 .25-.25" />
                                                                            </svg>
                                                                            Export as PDF
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 256 256">
                                                                                <path fill="currentColor" d="M154 208a6 6 0 0 1-6 6h-28a6 6 0 0 1-6-6v-56a6 6 0 1 1 12 0v50h22a6 6 0 0 1 6 6m-62.52-60.89a6 6 0 0 0-8.36 1.39L68 169.67L52.88 148.5a6 6 0 1 0-9.76 7L60.63 180l-17.51 24.5a6 6 0 1 0 9.76 7L68 190.31l15.12 21.16A6 6 0 0 0 88 214a5.9 5.9 0 0 0 3.48-1.12a6 6 0 0 0 1.4-8.37L75.37 180l17.51-24.51a6 6 0 0 0-1.4-8.38M191 173.22c-10.85-3.13-13.41-4.69-13-7.91a6.59 6.59 0 0 1 2.88-5.08c5.6-3.79 17.65-1.83 21.44-.84a6 6 0 0 0 3.07-11.6c-2-.54-20.1-5-31.21 2.48a18.64 18.64 0 0 0-8.08 13.54c-1.8 14.19 12.26 18.25 21.57 20.94c12.12 3.5 14.77 5.33 14.2 9.76a6.85 6.85 0 0 1-3 5.34c-5.61 3.73-17.48 1.64-21.19.62a6 6 0 0 0-3.21 11.53a59.4 59.4 0 0 0 14.68 2c5.49 0 11.54-.95 16.36-4.14a18.89 18.89 0 0 0 8.31-13.81c2.01-15.66-12.91-19.97-22.82-22.83M42 112V40a14 14 0 0 1 14-14h96a6 6 0 0 1 4.24 1.76l56 56A6 6 0 0 1 214 88v24a6 6 0 1 1-12 0V94h-50a6 6 0 0 1-6-6V38H56a2 2 0 0 0-2 2v72a6 6 0 1 1-12 0m116-30h35.5L158 46.48Z" />
                                                                            </svg>
                                                                            Export as Excel
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div> -->

                                                            <a href="javascript:void(0);" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white" onclick="addNewAudioLecture();">
                                                                <i class="fa-solid fa-plus"></i>
                                                                Add Audio Lecture
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                                <hr>
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">

                                                    <!-- ____________________________________ List View _______________________________________ -->


                                                    <div class="table-responsive list-view-div w-100 mt-3"><!-- overflow-x:clip; -->
                                                        <table id="audioLecture_table" class="table visitor-book-table">

                                                            <thead style="background-color: #3259901c !important;">
                                                                <tr>
                                                                    <th class="text-start text-nowrap" scope="col">Seq No.</th>
                                                                    <th class="text-start text-nowrap" scope="col">Lecture Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">category Name</th>
                                                                    <th class="text-start text-nowrap" scope="col">Description</th>
                                                                    <th class="text-start text-nowrap" scope="col">Date</th>
                                                                    <th class="text-start text-nowrap" scope="col">Status</th>
                                                                    <th class="text-start text-nowrap" scope="col">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="audioLecture_table_body">
                                                                
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
        id="addAudioCategory_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Audio Category Details</h5>
            <button type="button" class="btn-close closeCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="category_form">

                <input type="hidden" id="category_id" name="category_id" value="">
                
                <div class="row g-3">
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="category_title" name="category_title" placeholder="Category Title" maxlength="50">
                        <label class="ms-2" for="category_title">Category Title</label>
                    </div>
                    
                    <div class="form-floating">
                        <textarea class="form-control" id="category_description" name="category_description" placeholder="Category Description" maxlength="250" style="height:150px;"></textarea>
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
                    <button type="button" class="btn btn-purple" onclick="saveAudioCategory();" id="addCategory_btn">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Offcanvas Add Audio Category -->
    <div style="max-width:33rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1"  id="addAudio_canvas" aria-labelledby="offcanvas_add_label">
        <div class="offcanvas-header">
            <h5 id="offcanvas_add_label">Audio Details</h5>
            <button type="button" class="btn-close closeCanvas1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div style="padding: 6%;" class="offcanvas-body">
            <form id="audio_form">

                <input type="hidden" id="audio_id" name="audio_id" value="">
                
                <div class="row g-3">
                    
                    <div class="form-floating">
                        <select class="form-control" id="audio_category" name="audio_category">
                            <option value="">Choose</option>
                            
                        </select>
                        <label class="ms-2" for="audio_category">Audio Category</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="audio_title" name="audio_title" placeholder="Audio Title" maxlength="50">
                        <label class="ms-2" for="audio_title">Audio Title</label>
                    </div>
                    
                    <div class="form-floating">
                        <textarea class="form-control" id="audio_description" name="audio_description" placeholder="Audio Description" maxlength="250" style="height:150px;"></textarea>
                        <label class="ms-2" for="audio_description">Audio Description</label>
                    </div>
                    
                    <!-- Status -->
                    <div class="form-floating">
                        <select class="form-control" id="audio_status" name="audio_status">
                            <option value="">Choose</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                        <label class="ms-2" for="audio_status">Status</label>
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

                    <div class="row">
                        <div class="col-4">    
                            <button class="col-6 py-1 px-2 w-100 mt-2 rounded-1" type="button" id="addAudio_btn">
                                Upload Audio Files
                            </button>
                        </div>
                        
                        <input type="file" id="audio_files" name="" accept="audio/*" single style="display:none;">
                        <div class="row" id="file-container">
                           <!-- Audio Files Container --> 
                        </div>
                        <div class="row" id="file-container-uploaded">
                           <!-- Audio Files Container --> 
                        </div>
                    </div>
                    {{-- audio_duration --}}
                    <div class="form-floating audio_duration" style="display: none;">
                        <input type="text" class="form-control" id="audio_duration" readonly name="audio_duration" placeholder="Audio Duration" maxlength="50">
                        <label class="ms-2" for="audio_duration">Audio Duration Sec</label>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2 closeCanvas1">Cancel</button>
                    <button type="button" class="btn btn-purple" onclick="saveAudioLecture();" id="saveAudio_btn">Add</button>
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
    <script src="{{asset('assets/customjs/script_audioLectures.js')}}"></script>
    <!-- <script>
        $('#admin-query').DataTable({
            responsive: true,
        });
    </script> -->
@endpush
