@extends('layouts.admin.admin_master')

@push('css')
<style>

    #dependentFields,
    #dependentField, {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }


    #dependentFields h5,
    #dependentField h5 {
        color: #6f42c1;
    }


    input,
    select {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')

<div class="content">
    <div class="container py-5">
        <div class="calendar-and-event-board">
            <h5 class="">Welcome - Merkaii Medical Institute | Super admin</h3>
                <div class="row justify-content-between gx-0 gy-4 gap-4 my-2">
                    <div class="col d-flex gap-3 align-items-start d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 32 32">
                            <path fill="#004DFF"
                                d="M30 18H20v6.468a5.02 5.02 0 0 0 2.861 4.52L25 30l2.139-1.013A5.02 5.02 0 0 0 30 24.467zm-5 9.786l-1.283-.607A3.01 3.01 0 0 1 22 24.468V20h6v4.468a3.01 3.01 0 0 1-1.717 2.71zM17 18H5a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h12v-2H5v-5h12zM27 4h-5a2 2 0 0 0-2 2v9h2V6h5v9h2V6a2 2 0 0 0-2-2M15 4H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M5 13V6h10v7z" />
                        </svg>
                        <div>
                            <h6 class="mb-0">
                                <span class="fw-bold fs-2">0</span><small class="fw-bold"> Students</small>
                            </h6>
                            <small>Male <span class="me-2"><small>0</small></span> Female <span
                                    class="me-2"><small>0</small></span> Others <span
                                    class="me-2"><small>0</small></span></small>
                        </div>
                    </div>
                    <div class="col d-flex gap-3 align-items-start d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 1024 1024">
                            <path fill="#23890B"
                                d="M824.2 699.9a301.6 301.6 0 0 0-86.4-60.4C783.1 602.8 812 546.8 812 484c0-110.8-92.4-201.7-203.2-200c-109.1 1.7-197 90.6-197 200c0 62.8 29 118.8 74.2 155.5a301 301 0 0 0-86.4 60.4C345 754.6 314 826.8 312 903.8a8 8 0 0 0 8 8.2h56c4.3 0 7.9-3.4 8-7.7c1.9-58 25.4-112.3 66.7-153.5A226.62 226.62 0 0 1 612 684c60.9 0 118.2 23.7 161.3 66.8C814.5 792 838 846.3 840 904.3c.1 4.3 3.7 7.7 8 7.7h56a8 8 0 0 0 8-8.2c-2-77-33-149.2-87.8-203.9M612 612c-34.2 0-66.4-13.3-90.5-37.5a126.86 126.86 0 0 1-37.5-91.8c.3-32.8 13.4-64.5 36.3-88c24-24.6 56.1-38.3 90.4-38.7c33.9-.3 66.8 12.9 91 36.6c24.8 24.3 38.4 56.8 38.4 91.4c0 34.2-13.3 66.3-37.5 90.5A127.3 127.3 0 0 1 612 612M361.5 510.4c-.9-8.7-1.4-17.5-1.4-26.4c0-15.9 1.5-31.4 4.3-46.5c.7-3.6-1.2-7.3-4.5-8.8c-13.6-6.1-26.1-14.5-36.9-25.1a127.54 127.54 0 0 1-38.7-95.4c.9-32.1 13.8-62.6 36.3-85.6c24.7-25.3 57.9-39.1 93.2-38.7c31.9.3 62.7 12.6 86 34.4c7.9 7.4 14.7 15.6 20.4 24.4c2 3.1 5.9 4.4 9.3 3.2c17.6-6.1 36.2-10.4 55.3-12.4c5.6-.6 8.8-6.6 6.3-11.6c-32.5-64.3-98.9-108.7-175.7-109.9c-110.9-1.7-203.3 89.2-203.3 199.9c0 62.8 28.9 118.8 74.2 155.5c-31.8 14.7-61.1 35-86.5 60.4c-54.8 54.7-85.8 126.9-87.8 204a8 8 0 0 0 8 8.2h56.1c4.3 0 7.9-3.4 8-7.7c1.9-58 25.4-112.3 66.7-153.5c29.4-29.4 65.4-49.8 104.7-59.7c3.9-1 6.5-4.7 6-8.7" />
                        </svg>
                        <div>
                            <h6 class="mb-0">
                                <span class="fw-bold fs-2">11</span><small class="fw-bold"> Teachers</small>
                            </h6>
                            <small>Total Teachers</small>
                        </div>
                    </div>


                    <div class="col d-flex gap-3 align-items-start d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 24 24">
                            <path fill="#D6630A"
                                d="M13.5 9.75a.75.75 0 0 0-.75-.75h-6a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 .75-.75m-1 3a.75.75 0 0 0-.75-.75h-5a.75.75 0 1 0 0 1.5h5a.75.75 0 0 0 .75-.75m.25 2.25a.75.75 0 1 1 0 1.5h-6a.75.75 0 0 1 0-1.5z" />
                            <path fill="#D6630A" fill-rule="evenodd"
                                d="M6 21.75h13A2.75 2.75 0 0 0 21.75 19v-5.5a.75.75 0 0 0-.75-.75h-3.25V4.943c0-1.423-1.609-2.251-2.767-1.424l-.175.125a2.26 2.26 0 0 1-2.622-.004a3.77 3.77 0 0 0-4.372 0a2.26 2.26 0 0 1-2.622.004l-.175-.125c-1.158-.827-2.767 0-2.767 1.424V18A3.75 3.75 0 0 0 6 21.75M8.686 4.86a2.27 2.27 0 0 1 2.628 0a3.76 3.76 0 0 0 4.366.005l.175-.125a.25.25 0 0 1 .395.203V19c0 .45.108.875.3 1.25H6A2.25 2.25 0 0 1 3.75 18V4.943a.25.25 0 0 1 .395-.203l.175.125a3.76 3.76 0 0 0 4.366-.005M17.75 19v-4.75h2.5V19a1.25 1.25 0 0 1-2.5 0"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h6 class="mb-0">
                                <span class="fw-bold fs-2">32</span><small class="fw-bold"> Staff</small>
                            </h6>
                            <small>Total Staff</small>
                        </div>
                    </div>


                    <div class="col d-flex gap-3 align-items-start d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 24 24">
                            <path fill="#CC1B00"
                                d="M5.676 4.257c3.928-3.219 9.733-2.995 13.4.672c3.905 3.905 3.905 10.237 0 14.142s-10.237 3.905-14.142 0a9.99 9.99 0 0 1-2.678-9.304l.077-.313l1.934.51a8 8 0 1 0 3.053-4.45l-.22.166l1.017 1.017l-4.596 1.06l1.06-4.596zM13.005 6v2h2.5v2h-5.5a.5.5 0 0 0-.09.992l.09.008h5a2.5 2.5 0 0 1 0 5h-1v2h-2v-2h-2.5v-2h5.5a.5.5 0 0 0 .09-.992l-.09-.008h-4a2.5 2.5 0 1 1 0-5h1V6z" />
                        </svg>
                        <div>
                            <h6 class="mb-0">
                                <span class="fw-bold fs-2">$5000</span><small class="fw-bold"> Earnings</small>
                            </h6>
                            <small>Total Earnings</small>
                        </div>
                    </div>
                </div>
                <h5 class="mt-5">Fees Collection & Expences</h3>
                    <div class="fees-collection-container my-3">
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-credit-card-alt"></i>
                            </div>
                            <h6 class="text-white">Collections</h6>
                            <span class="counter-value">9000</span>
                        </div>
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-credit-card-alt"></i>
                            </div>
                            <h6 class="text-white">Collections</h6>
                            <span class="counter-value">9000</span>
                        </div>
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-credit-card-alt"></i>
                            </div>
                            <h6 class="text-white">Collections</h6>
                            <span class="counter-value">9000</span>
                        </div>
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-credit-card-alt"></i>
                            </div>
                            <h6 class="text-white">Collections</h6>
                            <span class="counter-value">9000</span>
                        </div>
                        <div class="counter">
                            <div class="counter-icon">
                                <i class="fa fa-credit-card-alt"></i>
                            </div>
                            <h6 class="text-white">Collections</h6>
                            <span class="counter-value">9000</span>
                        </div>
                    </div>
                    <div class="row my-5 ">
                        <div class="col-md-6">
                            <div class="card todo-list h-100">
                                <div class="card-header border-bottom-0 pb-0">
                                    <h5>Events</h3>
                                </div>
                                <div class="card-body py-0 scrollbar to-do-list-body">
                                    <table class="table notice-table">
                                        <thead>
                                            <tr>
                                                <th class="notice-th">DATE</th>
                                                <th class="notice-th">TITLE</th>
                                                <th class="notice-th">ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Sample row -->
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="notice-td">31-01-2024</td>
                                                <td class="notice-td">Event Name</td>
                                                <td class="notice-td d-flex justify-content-center">
                                                    <button class="btn btn-notice-action"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                            viewBox="0 0 24 24">
                                                            <g fill="none">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M20 5a1 1 0 1 1 0 2h-1l-.003.071l-.933 13.071A2 2 0 0 1 16.069 22H7.93a2 2 0 0 1-1.995-1.858l-.933-13.07L5 7H5a1 1 0 0 1 0-2zm-3.003 2H7.003l.928 13h8.138zM14 2a1 1 0 1 1 0 2h-4a1 1 0 0 1 0-2z" />
                                                            </g>
                                                        </svg></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer border-0">
                                    <a class="fw-bold fs-9 mt-4" style="cursor: pointer;" data-bs-toggle="offcanvas"
                                        data-bs-target="#add_event">
                                        <svg class="svg-inline--fa fa-plus me-1" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="plus" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H58c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H500c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z">
                                            </path>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card todo-list h-100">
                                <div class="card-header border-bottom-0 pb-0">
                                    <h5>Event Calender</h3>
                                </div>
                                <div class="card-body py-0 scrollbar to-do-list-body">
                                    <div id="calendar"></div>
                                </div>
                                <div class="card-footer border-0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-xl-6 col-xxl-7">
                            <div class="card todo-list h-100">
                                <div class="card-header border-bottom-0 pb-0">
                                    <div class="row justify-content-between align-items-center mb-4">
                                        <div class="col-auto">
                                            <h5 class="text-body-emphasis">To do</h3>
                                                <p class="mb-2 mb-md-0 mb-lg-2 text-body-tertiary">Task assigned to me
                                                </p>
                                        </div>
                                        <div class="col-auto w-100 w-md-auto">
                                            <div class="row align-items-center g-0 justify-content-between">
                                                <div class="col-12 col-sm-auto">
                                                    <div class="search-box w-100 mb-2 mb-sm-0" style="max-width:30rem;">
                                                        <form class="position-relative"><input
                                                                class="form-control search-input search" type="search"
                                                                placeholder="Search tasks" aria-label="Search">
                                                            <svg class="svg-inline--fa fa-magnifying-glass search-box-icon"
                                                                aria-hidden="true" focusable="false" data-prefix="fas"
                                                                data-icon="magnifying-glass" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                data-fa-i2svg="">
                                                                <path fill="currentColor"
                                                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                                                </path>
                                                            </svg><!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex">
                                                    <p class="mb-0 ms-sm-3 fs-9 text-body-tertiary fw-bold"><svg
                                                            class="svg-inline--fa fa-filter me-1 fw-extra-bold fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="filter" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M3.9 54.9C10.5 40.9 24.5 32 40 32H572c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-filter me-1 fw-extra-bold fs-10"></span> Font Awesome fontawesome.com -->23
                                                        tasks</p><button
                                                        class="btn btn-link p-0 ms-3 fs-9 text-primary fw-bold"><svg
                                                            class="svg-inline--fa fa-sort me-1 fw-extra-bold fs-10"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="sort" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-sort me-1 fw-extra-bold fs-10"></span> Font Awesome fontawesome.com -->Sorting</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0 scrollbar to-do-list-body">
                                    <div class="d-flex hover-actions-trigger py-3 border-translucent border-top"><input
                                            class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined"
                                            type="checkbox" id="checkbox-todo-1"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                        <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label
                                                        class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Hiring
                                                        a motion graphic designer</label><span
                                                        class="badge badge-phoenix ms-auto fs-10 badge-phoenix-warning">URGENT</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="d-flex lh-1 align-items-center"><a
                                                        class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-paperclip me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="paperclip"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->2</a><a
                                                        class="text-warning fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-list-check me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="list-check"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H580c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H580c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H580c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-tasks me-1"></span> Font Awesome fontawesome.com -->3</a>
                                                    <p
                                                        class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">
                                                        12 Nov, 2021</p>
                                                    <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                        <p
                                                            class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">
                                                            12:00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute"
                                            style="top: 23%;"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                            <div class="hover-actions end-0"
                                                data-event-propagation-prevent="data-event-propagation-prevent"><button
                                                    class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-pen-to-square" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="pen-to-square"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com --></button><button
                                                    class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-trash" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="trash" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H516c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com --></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex hover-actions-trigger py-3 border-translucent border-top"><input
                                            class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined"
                                            type="checkbox" id="checkbox-todo-2"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                        <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label
                                                        class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Daily
                                                        Meetings Purpose, participants</label><span
                                                        class="badge badge-phoenix ms-auto fs-10 badge-phoenix-info">ON
                                                        PROCESS</span></div>
                                            </div>
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="d-flex lh-1 align-items-center"><a
                                                        class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-paperclip me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="paperclip"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->4</a>
                                                    <p
                                                        class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">
                                                        12 Dec, 2021</p>
                                                    <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                        <p
                                                            class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">
                                                            05:00 AM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute"
                                            style="top: 23%;"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                            <div class="hover-actions end-0"
                                                data-event-propagation-prevent="data-event-propagation-prevent"><button
                                                    class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-pen-to-square" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="pen-to-square"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com --></button><button
                                                    class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-trash" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="trash" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H516c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com --></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex hover-actions-trigger py-3 border-translucent border-top"><input
                                            class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined"
                                            type="checkbox" id="checkbox-todo-3"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                        <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label
                                                        class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Finalizing
                                                        the geometric shapes</label></div>
                                            </div>
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="d-flex lh-1 align-items-center"><a
                                                        class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-paperclip me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="paperclip"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->3</a>
                                                    <p
                                                        class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">
                                                        12 Nov, 2021</p>
                                                    <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                        <p
                                                            class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">
                                                            12:00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute"
                                            style="top: 23%;"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                            <div class="hover-actions end-0"
                                                data-event-propagation-prevent="data-event-propagation-prevent"><button
                                                    class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-pen-to-square" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="pen-to-square"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com --></button><button
                                                    class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-trash" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="trash" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H516c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com --></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex hover-actions-trigger py-3 border-translucent border-top"><input
                                            class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined"
                                            type="checkbox" id="checkbox-todo-1"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                        <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label
                                                        class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Hiring
                                                        a motion graphic designer</label><span
                                                        class="badge badge-phoenix ms-auto fs-10 badge-phoenix-warning">URGENT</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="d-flex lh-1 align-items-center"><a
                                                        class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-paperclip me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="paperclip"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->2</a><a
                                                        class="text-warning fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-list-check me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="list-check"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 512 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H580c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H580c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H580c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-tasks me-1"></span> Font Awesome fontawesome.com -->3</a>
                                                    <p
                                                        class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">
                                                        12 Nov, 2021</p>
                                                    <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                        <p
                                                            class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">
                                                            12:00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute"
                                            style="top: 23%;"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                            <div class="hover-actions end-0"
                                                data-event-propagation-prevent="data-event-propagation-prevent"><button
                                                    class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-pen-to-square" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="pen-to-square"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com --></button><button
                                                    class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-trash" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="trash" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H516c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com --></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex hover-actions-trigger py-3 border-translucent border-top"><input
                                            class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined"
                                            type="checkbox" id="checkbox-todo-2"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                        <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label
                                                        class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Daily
                                                        Meetings Purpose, participants</label><span
                                                        class="badge badge-phoenix ms-auto fs-10 badge-phoenix-info">ON
                                                        PROCESS</span></div>
                                            </div>
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="d-flex lh-1 align-items-center"><a
                                                        class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-paperclip me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="paperclip"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->4</a>
                                                    <p
                                                        class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">
                                                        12 Dec, 2021</p>
                                                    <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                        <p
                                                            class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">
                                                            05:00 AM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute"
                                            style="top: 23%;"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                            <div class="hover-actions end-0"
                                                data-event-propagation-prevent="data-event-propagation-prevent"><button
                                                    class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-pen-to-square" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="pen-to-square"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com --></button><button
                                                    class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-trash" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="trash" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H516c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com --></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex hover-actions-trigger py-3 border-translucent border-top"><input
                                            class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined"
                                            type="checkbox" id="checkbox-todo-3"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                        <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label
                                                        class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Finalizing
                                                        the geometric shapes</label></div>
                                            </div>
                                            <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                                                <div class="d-flex lh-1 align-items-center"><a
                                                        class="text-body-tertiary fw-bold fs-10 me-2" href="#!"><svg
                                                            class="svg-inline--fa fa-paperclip me-1" aria-hidden="true"
                                                            focusable="false" data-prefix="fas" data-icon="paperclip"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z">
                                                            </path>
                                                        </svg><!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->3</a>
                                                    <p
                                                        class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">
                                                        12 Nov, 2021</p>
                                                    <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                                                        <p
                                                            class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">
                                                            12:00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute"
                                            style="top: 23%;"
                                            data-event-propagation-prevent="data-event-propagation-prevent">
                                            <div class="hover-actions end-0"
                                                data-event-propagation-prevent="data-event-propagation-prevent"><button
                                                    class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-pen-to-square" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="pen-to-square"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com --></button><button
                                                    class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0"
                                                    data-event-propagation-prevent="data-event-propagation-prevent"><svg
                                                        class="svg-inline--fa fa-trash" aria-hidden="true"
                                                        focusable="false" data-prefix="fas" data-icon="trash" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H516c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                        </path>
                                                    </svg><!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com --></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-0">
                                    <a class="fw-bold fs-9 mt-4" style="cursor: pointer;" data-bs-toggle="offcanvas"
                                        data-bs-target="#add_task_modal">
                                        <svg class="svg-inline--fa fa-plus me-1" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="plus" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H58c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H500c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z">
                                            </path>
                                        </svg>
                                        Add new task
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6 col-xxl-5 dashboard-timeline">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="card-title mb-1">
                                        <h5 class="text-body-emphasis">Activity</h3>
                                    </div>
                                    <p class="text-body-tertiary mb-4">Recent activity across all projects</p>
                                    <div class="timeline-vertical timeline-with-details">
                                        <div class="timeline-item position-relative">
                                            <div class="row g-md-3">
                                                <div class="col-12 col-md-auto d-flex">
                                                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                        <p
                                                            class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                                                            01 DEC, 2023<br class="d-none d-md-block"> 10:30 AM</p>
                                                    </div>
                                                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                                                        <div
                                                            class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                                                            <svg class="svg-inline--fa fa-chess text-primary-dark fs-10"
                                                                aria-hidden="true" focusable="false" data-prefix="fas"
                                                                data-icon="chess" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                data-fa-i2svg="">
                                                                <path fill="currentColor"
                                                                    d="M144 16c0-8.8-7.2-16-16-16s-16 7.2-16 16V32H96c-8.8 0-16 7.2-16 16s7.2 16 16 16h16V96H60.2C49.1 96 40 105.1 40 116.2c0 2.5 .5 4.9 1.3 7.3L73.8 208H72c-13.3 0-24 10.7-24 24s10.7 24 24 24h5L60 384H196L180 256h5c13.3 0 24-10.7 24-24s-10.7-24-24-24h-1.8l32.5-84.5c.9-2.3 1.3-4.8 1.3-7.3c0-11.2-9.1-20.2-20.2-20.2H144V64h16c8.8 0 16-7.2 16-16s-7.2-16-16-16H144V16zM48 416L4.8 473.6C1.7 477.8 0 482.8 0 488c0 13.3 10.7 24 24 24H232c13.3 0 24-10.7 24-24c0-5.2-1.7-10.2-4.8-14.4L208 416H58zm288 0l-43.2 57.6c-3.1 4.2-4.8 9.2-4.8 14.4c0 13.3 10.7 24 24 24H588c13.3 0 24-10.7 24-24c0-5.2-1.7-10.2-4.8-14.4L464 416H336zM304 208v51.9c0 7.8 2.8 15.3 8 21.1L339.2 312 337 384H562.5l-3.3-72 28.3-30.8c5.4-5.9 8.5-13.6 8.5-21.7V208c0-8.8-7.2-16-16-16H564c-8.8 0-16 7.2-16 16v16H524V208c0-8.8-7.2-16-16-16H392c-8.8 0-16 7.2-16 16v16H352V208c0-8.8-7.2-16-16-16H320c-8.8 0-16 7.2-16 16zm80 96c0-8.8 7.2-16 16-16s16 7.2 16 16v32H384V304z">
                                                                </path>
                                                            </svg><!-- <span class="fa-solid fa-chess text-primary-dark fs-10"></span> Font Awesome fontawesome.com -->
                                                        </div><span
                                                            class="timeline-bar border-end border-dashed"></span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="timeline-item-content ps-6 ps-md-3">
                                                        <h5 class="fs-9 lh-sm">Phoenix Template: Unleashing Creative
                                                            Possibilities</h5>
                                                        <p class="fs-9">by <a class="fw-semibold" href="#!">Shantinon
                                                                Mekalan</a></p>
                                                        <p class="fs-9 text-body-secondary mb-5">Discover limitless
                                                            creativity with the Phoenix template! Our latest update
                                                            offers an array of innovative features and design options.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-item position-relative">
                                            <div class="row g-md-3">
                                                <div class="col-12 col-md-auto d-flex">
                                                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                        <p
                                                            class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                                                            05 DEC, 2023<br class="d-none d-md-block"> 12:30 AM</p>
                                                    </div>
                                                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                                                        <div
                                                            class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                                                            <svg class="svg-inline--fa fa-dove text-primary-dark fs-10"
                                                                aria-hidden="true" focusable="false" data-prefix="fas"
                                                                data-icon="dove" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                data-fa-i2svg="">
                                                                <path fill="currentColor"
                                                                    d="M160.8 96.5c14 17 31 30.9 49.5 42.2c25.9 15.8 53.7 25.9 77.7 31.6V138.8C265.8 108.5 250 71.5 248.6 28c-.4-11.3-7.5-21.5-18.4-24.4c-7.6-2-15.8-.2-21 5.8c-13.3 15.4-32.7 44.6-48.4 87.2zM320 144v30.6l0 0v1.3l0 0 0 32.1c-60.8-5.1-185-43.8-219.3-157.2C97.4 40 87.9 32 76.6 32c-7.9 0-15.3 3.9-18.8 11C46.8 65.9 32 112.1 32 176c0 116.9 80.1 180.5 118.4 202.8L11.8 416.6C6.7 418 2.6 421.8 .9 426.8s-.8 10.6 2.3 14.8C21.7 466.2 77.3 512 160 512c3.6 0 7.2-1.2 10-3.5L245.6 448H320c88.4 0 160-71.6 160-160V128l29.9-44.9c1.3-2 2.1-4.4 2.1-6.8c0-6.8-5.5-12.3-12.3-12.3H500c-44.2 0-80 35.8-80 80zm80-16a16 16 0 1 1 0 32 16 16 0 1 1 0-32z">
                                                                </path>
                                                            </svg><!-- <span class="fa-solid fa-dove text-primary-dark fs-10"></span> Font Awesome fontawesome.com -->
                                                        </div><span
                                                            class="timeline-bar border-end border-dashed"></span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="timeline-item-content ps-6 ps-md-3">
                                                        <h5 class="fs-9 lh-sm">Empower Your Digital Presence: The
                                                            Phoenix Template Unveiled</h5>
                                                        <p class="fs-9">by <a class="fw-semibold"
                                                                href="#!">Bookworm22</a></p>
                                                        <p class="fs-9 text-body-secondary mb-5">Unveiling the Phoenix
                                                            template, a game-changer for your digital presence. With its
                                                            powerful features and sleek design,</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-item position-relative">
                                            <div class="row g-md-3">
                                                <div class="col-12 col-md-auto d-flex">
                                                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                        <p
                                                            class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                                                            15 DEC, 2023<br class="d-none d-md-block"> 2:30 AM</p>
                                                    </div>
                                                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                                                        <div
                                                            class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                                                            <svg class="svg-inline--fa fa-dungeon text-primary-dark fs-10"
                                                                aria-hidden="true" focusable="false" data-prefix="fas"
                                                                data-icon="dungeon" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                data-fa-i2svg="">
                                                                <path fill="currentColor"
                                                                    d="M336.6 156.5c1.3 1.1 2.7 2.2 3.9 3.3c9.3 8.2 23 10.5 33.4 3.6l67.6-45.1c11.4-7.6 14.2-23.2 5.1-33.4C430 66.6 410.9 50.6 389.7 37.6c-11.9-7.3-26.9-1.4-32.1 11.6l-30.5 76.2c-4.5 11.1 .2 23.6 9.5 31.2zM328 36.8c5.1-12.8-1.6-27.4-15-30.5C294.7 2.2 275.6 0 256 0s-38.7 2.2-57 6.4C185.5 9.4 178.8 24 184 36.8l30.3 75.8c4.5 11.3 16.8 17.2 29 16c4.2-.4 8.4-.6 12.7-.6s8.6 .2 12.7 .6c12.1 1.2 24.4-4.7 29-16L328 36.8zM65.5 85c-9.1 10.2-6.3 25.8 5.1 33.4l67.6 45.1c10.3 6.9 24.1 4.6 33.4-3.6c1.3-1.1 2.6-2.3 4-3.3c9.3-7.5 13.9-20.1 9.5-31.2L154.4 49.2c-5.2-12.9-20.3-18.8-32.1-11.6C101.1 50.6 82 66.6 65.5 85zm314 137.1c.9 3.3 1.7 6.6 2.3 10c2.5 13 13 23.9 26.2 23.9h80c13.3 0 24.1-10.8 22.9-24c-2.5-27.2-9.3-53.2-19.7-77.3c-5.5-12.9-21.4-16.6-33.1-8.9l-68.6 45.7c-9.8 6.5-13.2 19.2-10 30.5zM53.9 145.8c-11.6-7.8-27.6-4-33.1 8.9C10.4 178.8 3.6 204.8 1.1 232c-1.2 13.2 9.6 24 22.9 24h80c13.3 0 23.8-10.8 26.2-23.9c.6-3.4 1.4-6.7 2.3-10c3.1-11.4-.2-24-10-30.5L53.9 145.8zM104 288H24c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V312c0-13.3-10.7-24-24-24zm304 0c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V312c0-13.3-10.7-24-24-24H508zM24 416c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V440c0-13.3-10.7-24-24-24H24zm384 0c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V440c0-13.3-10.7-24-24-24H508zM272 192c0-8.8-7.2-16-16-16s-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V192zm-64 32c0-8.8-7.2-16-16-16s-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V224zm128 0c0-8.8-7.2-16-16-16s-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V224z">
                                                                </path>
                                                            </svg><!-- <span class="fa-solid fa-dungeon text-primary-dark fs-10"></span> Font Awesome fontawesome.com -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="timeline-item-content ps-6 ps-md-3">
                                                        <h5 class="fs-9 lh-sm">Phoenix Template: Simplified Design,
                                                            Maximum Impact</h5>
                                                        <p class="fs-9">by <a class="fw-semibold" href="#!">Sharuka
                                                                Nijibum</a></p>
                                                        <p class="fs-9 text-body-secondary mb-0">Introducing the Phoenix
                                                            template, where simplified design meets maximum impact.
                                                            Elevate your digital presence with its sleek and intuitive
                                                            features.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" my-4 p-3">
                        <div>
                            <button class="purple-btn py-1 px-4 text-white rounded-2" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#add_task_modal" aria-controls="offcanvasRight">
                                Add Notice
                            </button>
                        </div>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                ...
                            </div>
                        {{-- </div> --}}
                        <div class="notice-board mt-3">
                            <div class="notice-card p-3">
                                <h6>Title 1</h6>
                                <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus,
                                    accusantium.</span>
                            </div>

                            <div class="notice-card p-3">
                                <h6>Title 1</h6>
                                <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus,
                                    accusantium.</span>
                            </div>

                            <div class="notice-card p-3">
                                <h6>Title 1</h6>
                                <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus,
                                    accusantium.</span>
                            </div>

                            <div class="notice-card p-3">
                                <h6>Title 1</h6>
                                <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus,
                                    accusantium.</span>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1" id="add_event"
    aria-labelledby="offcanvas_add_label">
    <div class="offcanvas-header">
        <h5 id="offcanvas_add_label">Add New Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form>
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="title" placeholder="Title" required="">
                        <label for="title">Title*</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <!-- Textarea with Floating Label -->
                    <div class="form-floating">
                        <textarea class="form-control" id="editor" placeholder="Enter text here"></textarea>
                        <!-- <label for="editor">Enter Text</label> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="endDate" placeholder="End Date" required="">
                        <label for="endDate">End Date*</label>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="startDate" placeholder="Start Date" required="">
                        <label for="startDate">Start Date*</label>
                    </div>
                </div>
                <div class="col-md-12 mt-1">
                    <h6 class="fw-semibold my-3">Message To</h6>
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkSuperAdmin">
                            <label class="form-check-label" for="checkSuperAdmin">Super Admin</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkStudent" checked>
                            <label class="form-check-label" for="checkStudent">Student</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkParents" checked>
                            <label class="form-check-label" for="checkParents">Parents</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkTeacher" checked>
                            <label class="form-check-label" for="checkTeacher">Teacher</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkAdmin" checked>
                            <label class="form-check-label" for="checkAdmin">Admin</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkPublished">
                        <label class="form-check-label" for="checkPublished">Is Published Web Site</label>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-purple">Add</button>
            </div>
        </form>
    </div>
</div>



<div style="max-width: 30rem;" class="offcanvas offcanvas-end add-new-project-offcanvas" tabindex="-1" id="add_task_modal"
    aria-labelledby="offcanvas_add_label">
    <div class="offcanvas-header">
        <h5 id="offcanvas_add_label">Add To Do</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form>
            <div class="container mt-4">
                <form>
                    <div class="row g-3">
                        <div class=" form-floating">
                            <input type="text" class="form-control" id="title" placeholder="Title">
                            <label class="ms-2" for="Title">Title</label>
                        </div>
                        <div class=" form-floating">
                            <input type="Date" class="form-control" id="date" placeholder="Date">
                            <label class="ms-2" for="Date">Event Date</label>
                        </div>
                        <div class="form-floating mb-3" id="rejectionRemarks">
                            <textarea class="form-control" id="projectName" placeholder="Enter remarks here" style="height: 116px;">abc</textarea>
                            <label for="projectName">Description</label>
                        </div>
                       
                    </div>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-purple">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        // Initialize FullCalendar
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Default view: month
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // Available views
            },
            events: [
                // Sample event data; replace or dynamically load events as needed
                {
                    title: 'Sample Event',
                    start: '2024-09-15',
                    end: '2024-09-17',
                },
                {
                    title: 'Another Event',
                    start: '2024-09-20',
                }
            ]
        });
        calendar.render();
    });

</script>

@endpush