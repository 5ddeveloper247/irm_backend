
<div class="row align-items-center justify-content-end w-100 g-0">
    <div class="col-sm-6 d-flex align-items-center justify-content-end gap-3 px-0">
        <div class="form-sorts dropdown me-2">
            <a class="d-flex gap-1" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m12 20l-3 1v-8.5L4.52 7.572A2 2 0 0 1 4 6.227V4h16v2.172a2 2 0 0 1-.586 1.414L15 12v2m4 8v-6m3 3l-3-3l-3 3" />
                </svg>
                Filter
            </a>
            <div class="filter-dropdown-menu dropdown-menu dropdown-menu-md-end p-3">
                <div class="filter-set-view">
                    <div class="filter-set-head d-flex align-items-center gap-1">
                        <h5 class="fw-bold mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m12 20l-3 1v-8.5L4.52 7.572A2 2 0 0 1 4 6.227V4h16v2.172a2 2 0 0 1-.586 1.414L15 12v2m4 8v-6m3 3l-3-3l-3 3" />
                            </svg>
                            Filter
                        </h5>
                    </div>

                    <div class="accordion mt-4" id="accordionExample">
                        @foreach ($filters as $filter)
                            <div class="filter-set-content mb-3">
                                <div class="filter-set-content-head d-flex gap-1">
                                    <a href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $filter['name'] }}"
                                        aria-expanded="false"
                                        aria-controls="collapse{{ $filter['name'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em"
                                            viewBox="0 0 48 48">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="4"
                                                d="m19 12l12 12l-12 12" />
                                        </svg>
                                        {{ $filter['label'] }}
                                    </a>
                                </div>

                                <div class="filter-set-contents accordion-collapse collapse"
                                    id="collapse{{ $filter['name'] }}" data-bs-parent="#accordionExample">
                                    <div class="filter-content-list px-3 py-2">
                                        @if ($filter['type'] == 'text')
                                            <div class="mb-2 icon-form">
                                                <span class="form-icon"></span>
                                                <input type="text" name="{{ $filter['name'] }}"
                                                    class="form-control filterApplicantsInput"
                                                    placeholder="{{ $filter['placeholder'] ?? '' }}">
                                            </div>
                                        @elseif ($filter['type'] == 'checkbox')
                                            <ul>
                                                @foreach ($filter['options'] as $option)
                                                    <li>
                                                        <div class="filter-checks">
                                                            <label class="checkboxs">
                                                                <input type="checkbox"
                                                                    class="filterApplicantsInput"
                                                                    name="{{ $filter['name'] }}[]"
                                                                    value="{{ $option['value'] }}">
                                                                <span class="checkmarks"></span>
                                                                {{ $option['label'] }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @elseif ($filter['type'] == 'select')
                                            <div class="mb-2">
                                                <select name="{{ $filter['name'] }}" class="form-control filterApplicantsInput">
                                                    @foreach ($filter['options'] as $option)
                                                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @elseif ($filter['type'] == 'date')
                                            <div class="mb-2">
                                                <input type="date" name="{{ $filter['name'] }}"
                                                    class="form-control filterApplicantsInput">
                                            </div>
                                        @elseif ($filter['type'] == 'radio')
                                            <ul>
                                                @foreach ($filter['options'] as $option)
                                                    <li>
                                                        <div class="filter-radios">
                                                            <label class="radios">
                                                                <input type="radio" name="{{ $filter['name'] }}"
                                                                    class="filterApplicantsInput"
                                                                    value="{{ $option['value'] }}">
                                                                <span class="radiomarks"></span>
                                                                {{ $option['label'] }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="filter-reset-btns">
                        <div class="row">
                            <div class="col-6">
                                <a href="#" class="btn btn-secondary w-100 resetappbtn" id="resetFilterButton">Reset</a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-danger w-100 filterBtn" id="filterButton">Filter</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>  
        @isset($button)
        <span>
            {!!$button !!}
        </span>
        @endisset
    </div>
</div>


