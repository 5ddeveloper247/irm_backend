@extends('layouts.admin.admin_master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Settings</h2>
                </div>
                <div class="card-body">
                    <form id="updateSettings" action="{{route('admin.settings.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">Company Name *</label>
                                <input type="text" name="company_name" class="form-control" id="validationServer01" value="{{$settings->company_name}}" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="validationServer02">Company Logo</label>
                                <input type="file" name="company_logo" class="form-control" id="company_logo">
                            </div>
                            <div class="col-md-3 mb-3">
                                
                                <img src="{{ url('/'.$settings->company_logo) }}" id="company_logo_preview" alt="" style="width: 100px; height: 100px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="validationServer03">Company Address *</label>
                                <textarea name="company_address" class="form-control" id="validationServer03" required>{{$settings->company_address}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer05">Company Email *</label>
                                <input type="email" name="company_email" class="form-control" id="validationServer05" value="{{$settings->company_email}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer04">Company Phone *</label>
                                <input type="text" name="company_phone" class="form-control" id="validationServer04" value="{{$settings->company_phone}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer06">Company Website</label>
                                <input type="text" name="company_website" class="form-control" id="validationServer06" value="{{$settings->company_website}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer08">Twitter Link</label>
                                <input type="text" name="twitter_link" class="form-control" id="validationServer08" value="{{$settings->twitter_link}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer09">Instagram Link</label>
                                <input type="text" name="instagram_link" class="form-control" id="validationServer09" value="{{$settings->instagram_link}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer10">Linkedin Link</label>
                                <input type="text" name="linkedin_link" class="form-control" id="validationServer10" value="{{$settings->linkedin_link}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer11">Youtube Link</label>
                                <input type="text" name="youtube_link" class="form-control" id="validationServer11" value="{{$settings->youtube_link}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer07">Facebook Link</label>
                                <input type="text" name="facebook_link" class="form-control" id="validationServer07" value="{{$settings->facebook_link}}" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="updateSettings_btn" onclick="updateSettings()" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white">SAVE</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="{{asset('assets/customjs/script_settings.js')}}"></script>
@endpush
