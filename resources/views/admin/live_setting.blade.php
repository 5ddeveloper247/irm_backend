@extends('layouts.admin.admin_master')

@section('title', 'Live Setting')

@section('content')
<div class="student">
    <div class="p-md-1 p-3">

        <div class="container-fluid bg-light py-2">
            <div class="row align-items-center px-2">
                <div class="col-md-6">
                    <h5 class="mb-0">Live Setting</h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-end mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Live Setting</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-8">

                <div id="alertBox" class="alert d-none mb-3" role="alert"></div>

                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex align-items-center justify-content-between">
                        <h2>Live Setting</h2>
                        <span id="statusBadge" class="badge bg-secondary">Loading...</span>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="platform">Platform <span class="text-danger">*</span></label>
                                <select id="platform" class="form-control">
                                    <option value="youtube">YouTube</option>
                                    <option value="facebook">Facebook</option>
                                </select>
                                <small class="text-muted">Select which platform the live URL belongs to.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="live_url">Live Video URL</label>
                                <input
                                    type="url"
                                    id="live_url"
                                    class="form-control"
                                    placeholder="e.g. https://www.youtube.com/watch?v=XXXXX"
                                    maxlength="500"
                                >
                                <small class="text-muted" id="urlHint">Paste a YouTube watch/live URL here. Leave empty to disable manual override.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="d-block">Status <span class="text-danger">*</span></label>
                                <div class="form-check form-switch mt-1">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" style="width:2.5em; height:1.4em;">
                                    <label class="form-check-label ms-2" for="is_active" id="activeLabel">Active</label>
                                </div>
                                <small class="text-muted">
                                    When <strong>Active</strong>, this URL will be used as the fallback on the frontend if no live stream is detected automatically.
                                </small>
                            </div>
                        </div>

                        <div id="previewSection" class="row d-none">
                            <div class="col-md-12 mb-3">
                                <label>URL Preview</label>
                                <div class="ratio ratio-16x9 rounded border overflow-hidden" style="max-height: 300px;">
                                    <iframe
                                        id="previewIframe"
                                        src=""
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            {{-- <button type="button" class="btn btn-outline-secondary px-4" onclick="previewUrl()">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button type="button" class="btn btn-outline-danger px-4" onclick="clearUrl()">
                                <i class="fas fa-times me-1"></i> Clear URL
                            </button> --}}
                            <button id="saveBtn" type="button" onclick="saveLiveSetting()" class="theme-btn d-flex align-items-center gap-1 py-2 px-3 rounded-2 text-white">
                                <span id="saveBtnText">SAVE</span>
                                <span id="saveBtnSpinner" class="spinner-border spinner-border-sm ms-1 d-none" role="status"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2><i class="fas fa-info-circle text-primary me-2"></i>How This Works</h2>
                    </div>
                    <div class="card-body">
                        <ol class="mb-0 text-muted small lh-lg ps-3">
                            <li class="mb-2">Paste a <strong>YouTube</strong> or <strong>Facebook</strong> live/video URL in the field.</li>
                            <li class="mb-2">Set Status to <strong>Active</strong> and click <strong>Save</strong>.</li>
                            <li class="mb-2">The frontend player will use this URL as the <strong>fallback</strong> when no live stream is detected automatically.</li>
                            <li>To stop using the manual URL, either set Status to <strong>Inactive</strong> or clear the URL field.</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@push('js')
<script>


    $(document).ready(function () {
        loadLiveSettingData();
        bindPlatformHint();
        bindActiveToggleLabel();
    });

    function loadLiveSettingData() {
        $.ajax({
            url: '{{ route("getLiveSettingData") }}',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                if (res.status === 200) {
                    const d = res.data.live_setting;

                    $('#platform').val(d.platform || 'youtube');
                    $('#live_url').val(d.live_url || '');
                    $('#is_active').prop('checked', d.is_active == 1);

                    updateStatusBadge(d.is_active == 1);
                    updateActiveLabel(d.is_active == 1);
                    updatePlatformHint(d.platform || 'youtube');
                }
            },
            error: function () {
                showAlert('danger', 'Failed to load live setting data.');
            }
        });
    }

    function saveLiveSetting() {
        const platform  = $('#platform').val();
        const live_url  = $('#live_url').val().trim();
        const is_active = $('#is_active').is(':checked') ? 1 : 0;

        setBtnLoading(true);

        $.ajax({
            url: '{{ route("saveLiveSetting") }}',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: { platform, live_url, is_active },
            success: function (res) {
                setBtnLoading(false);
                if (res.status === 200) {
                    showAlert('success', res.message);
                    updateStatusBadge(is_active == 1);
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function () {
                setBtnLoading(false);
                showAlert('danger', 'An error occurred while saving. Please try again.');
            }
        });
    }

    function previewUrl() {
        const platform = $('#platform').val();
        const url      = $('#live_url').val().trim();

        if (!url) {
            showAlert('warning', 'Please enter a URL to preview.');
            return;
        }

        let embedUrl = null;

        if (platform === 'youtube') {
            const match = url.match(/(?:v=|youtu\.be\/|\/live\/)([a-zA-Z0-9_\-]{11})/);
            if (match) {
                embedUrl = `https://www.youtube.com/embed/${match[1]}?autoplay=0`;
            }
        } else if (platform === 'facebook') {
            const encoded = encodeURIComponent(url);
            embedUrl = `https://www.facebook.com/plugins/video.php?href=${encoded}&show_text=false&width=900&height=450`;
        }

        if (!embedUrl) {
            showAlert('warning', 'Could not build an embed URL from the provided link. Please check the URL format.');
            return;
        }

        $('#previewIframe').attr('src', embedUrl);
        $('#previewSection').removeClass('d-none');
        $('html, body').animate({ scrollTop: $('#previewSection').offset().top - 80 }, 400);
    }

    function clearUrl() {
        $('#live_url').val('');
        $('#previewSection').addClass('d-none');
        $('#previewIframe').attr('src', '');
    }

    function showAlert(type, message) {
        const box = $('#alertBox');
        box.removeClass('d-none alert-success alert-danger alert-warning alert-info')
           .addClass(`alert-${type}`)
           .html(message);

        setTimeout(() => box.addClass('d-none'), 5000);
    }

    function setBtnLoading(loading) {
        $('#saveBtn').prop('disabled', loading);
        $('#saveBtnText').text(loading ? 'Saving...' : 'SAVE');
        $('#saveBtnSpinner').toggleClass('d-none', !loading);
    }

    function updateStatusBadge(isActive) {
        const badge = $('#statusBadge');
        if (isActive) {
            badge.removeClass('bg-secondary').addClass('bg-success').text('Active — Manual URL is ON');
        } else {
            badge.removeClass('bg-success').addClass('bg-secondary').text('Inactive — Using Auto Detection');
        }
    }

    function updateActiveLabel(isActive) {
        $('#activeLabel').text(isActive ? 'Inactive' : 'Active');
    }

    function updatePlatformHint(platform) {
        const hints = {
            youtube:  'Paste a YouTube watch/live URL. Example: https://www.youtube.com/watch?v=XXXXX',
            facebook: 'Paste a Facebook video/live URL. Example: https://www.facebook.com/PAGE/videos/XXXXX',
        };
        $('#urlHint').text(hints[platform] || '');
    }

    function bindPlatformHint() {
        $('#platform').on('change', function () {
            updatePlatformHint($(this).val());
            $('#previewSection').addClass('d-none');
            $('#previewIframe').attr('src', '');
        });
    }

    function bindActiveToggleLabel() {
        $('#is_active').on('change', function () {
            updateActiveLabel($(this).is(':checked'));
            updateStatusBadge($(this).is(':checked'));
        });
    }

</script>
@endpush
