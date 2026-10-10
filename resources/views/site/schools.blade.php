@extends('site.layouts.app')

@php
    $pageTitle = __('site.schools');
    $selectedCategories = $schoolCategories ?? collect();
    $levelOptions = $levels ?? collect();
@endphp

@section('site.title')
    {{ $pageTitle }}
@endsection

@section('site.meta_description')
    {{ __('site.schools') . ' - ' . __('site.study_abroads_text') }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$pageTitle, __('site.schools'), __('site.country')])) }}
@endsection

@section('site.css')
@endsection

@section('site.content')
    <section class="bg-gredient page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pageTitle-wrap">
                        <h1 class="text-light">{{ $pageTitle }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-xxl-3 col-lg-4 col-12">
                    <div class="d-flex flex-row align-items-center justify-content-between mt-2 mb-3">
                        <div class="d-flex w-100">
                            <a class="d-lg-none btn btn-md btn-outline-dark rounded-pill w-100" data-bs-toggle="offcanvas" href="#schoolsFilters" role="button" aria-controls="schoolsFilters">
                                <i class="bi bi-sliders me-2"></i>@lang('admin.filter')
                            </a>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-start offcanvas-collapse side-filter" tabindex="-1" id="schoolsFilters" aria-labelledby="schoolsFiltersLabel">
                        <div class="offcanvas-header d-lg-none border-bottom">
                            <h5 class="offcanvas-title" id="schoolsFiltersLabel">@lang('admin.filter')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body pt-4 pt-lg-0 p-lg-0">
                            <form method="GET" action="{{ route('site.schools') }}" class="d-flex flex-column gap-3">
                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.search')</label>
                                    <div class="position-relative">
                                        <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control ps-5" placeholder="@lang('admin.search')">
                                        <span class="position-absolute top-50 start-0 translate-middle ms-4 opacity-50">
                                            <i class="bi bi-search fs-5"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.categories')</label>
                                    <select class="form-select" name="category" id="school-category">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($selectedCategories as $category)
                                            @php
                                                $categoryTitle = data_get($category, "title.$currentLang") ?? data_get($category, 'title.az');
                                            @endphp
                                            <option value="{{ $category->id }}" @selected((string)($categoryId ?? '') === (string)$category->id)>
                                                {{ $categoryTitle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.countries')</label>
                                    <select class="form-select" name="country" id="school-country">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($countries as $country)
                                            @php
                                                $countryName = data_get($country, "name.$currentLang") ?? data_get($country, 'name.az');
                                            @endphp
                                            <option value="{{ $country->id }}" @selected((string)($countryId ?? '') === (string)$country->id)>
                                                {{ $countryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.languages')</label>
                                    <select class="form-select" name="language" id="school-language">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($mainLanguages as $language)
                                            @php
                                                $languageName = data_get($language, "name.$currentLang") ?? data_get($language, 'name.az');
                                            @endphp
                                            <option value="{{ $language->id }}" @selected((string)($languageId ?? '') === (string)$language->id)>
                                                {{ $languageName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.parent_languages')</label>
                                    <select class="form-select" name="level" id="school-level">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($levelOptions as $level)
                                            @php
                                                $levelName = data_get($level, "name.$currentLang") ?? data_get($level, 'name.az');
                                            @endphp
                                            <option value="{{ $level->id }}" data-language-id="{{ $level->parent_id }}" @selected((string)($levelId ?? '') === (string)$level->id)>
                                                {{ $levelName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-dark rounded-pill flex-grow-1">@lang('admin.filter')</button>
                                    <a href="{{ route('site.schools') }}" class="btn btn-outline-secondary rounded-pill">@lang('admin.clear')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8 col-12">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h2 class="h4 mb-1">@lang('site.schools')</h2>
                            <div class="text-muted small">{{ $schools->total() }} @lang('site.student')</div>
                        </div>
                    </div>

                    <div class="row g-xl-3 g-4 mb-5">
                        @forelse($schools as $school)
                            @php
                                $schoolTitle = data_get($school, "name.$currentLang") ?? data_get($school, 'name.az');
                                $schoolText = data_get($school, "text.$currentLang") ?? data_get($school, 'text.az');
                                $countryName = data_get($school, "country.name.$currentLang") ?? data_get($school, 'country.name.az');
                                $categoryTitle = data_get($school, "category.title.$currentLang") ?? data_get($school, 'category.title.az');
                                $teacherName = data_get($school, "teacher.name.$currentLang") ?? data_get($school, 'teacher.name.az');
                                $languageName = data_get($school, "language.name.$currentLang") ?? data_get($school, 'language.name.az');
                                $levelName = data_get($school, "parentLanguage.name.$currentLang") ?? data_get($school, 'parentLanguage.name.az');
                                $categorySlug = data_get($school, "category.slug.$currentLang") ?? data_get($school, 'category.slug.az');
                                $countrySlug = data_get($school, "country.slug.$currentLang") ?? data_get($school, 'country.slug.az');
                                $schoolSlug = data_get($school, "slug.$currentLang") ?? data_get($school, 'slug.az');
                            @endphp

                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6">
                                <div class="education_block_grid border">
                                    <div class="education-thumb position-relative">
                                        <a href="{{ route('site.schools-details', [$categorySlug, $countrySlug, $schoolSlug]) }}">
                                            <img
                                                src="{{ !empty($school->image) ? asset('uploads/schools/' . $school->image) : asset('site/assets/img/co-1.jpg') }}"
                                                class="img-fluid w-100"
                                                alt="{{ $schoolTitle }}"
                                                style="aspect-ratio: 16 / 10; object-fit: contain;"
                                            >
                                        </a>
                                    </div>

                                    <div class="education-body p-3">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            @if($countryName)
                                                <span class="badge bg-light text-dark rounded-pill">{{ $countryName }}</span>
                                            @endif
                                            @if($categoryTitle)
                                                <span class="badge bg-light text-dark rounded-pill">{{ $categoryTitle }}</span>
                                            @endif
                                        </div>

                                        <div class="education-title">
                                            <h4 class="fs-6 fw-medium mb-2">
                                                <a href="{{ route('site.schools-details', [$categorySlug, $countrySlug, $schoolSlug]) }}">{{ $schoolTitle }}</a>
                                            </h4>
                                        </div>

                                        <div class="d-flex flex-column gap-1 text-muted-2 mb-3">
                                            @if($teacherName)
                                                <div><strong>@lang('site.teacher'):</strong> {{ $teacherName }}</div>
                                            @endif
                                            @if($languageName || $levelName)
                                                <div><strong>@lang('site.language'):</strong> {{ trim(($languageName ?? '') . ($levelName ? ' - ' . $levelName : '')) }}</div>
                                            @endif
                                        </div>

                                        @if($schoolText)
                                            <p class="text-muted-2 mb-0">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($schoolText), 140) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="education-footer p-3">
                                        <div class="enrolled-link">
                                            <a href="{{ route('site.schools-details', [$categorySlug, $countrySlug, $schoolSlug]) }}" class="main-link fw-medium">
                                                @lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border mb-0">@lang('site.no_data_found')</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    {{ $schools->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('site.js')
    <script>
        (function () {
            const languageSelect = document.getElementById('school-language');
            const levelSelect = document.getElementById('school-level');
            if (!languageSelect || !levelSelect) return;

            const levelOptions = Array.from(levelSelect.options).map(option => ({
                value: option.value,
                label: option.text,
                languageId: option.dataset.languageId || ''
            })).filter(item => item.value !== '');

            function renderLevels() {
                const selectedLanguage = languageSelect.value || '';
                const selectedLevel = levelSelect.value || '';
                const filtered = selectedLanguage
                    ? levelOptions.filter(item => item.languageId === selectedLanguage)
                    : levelOptions.slice();

                levelSelect.innerHTML = '';
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = @json(__('admin.choose'));
                levelSelect.appendChild(emptyOption);

                filtered.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.value;
                    option.textContent = item.label;
                    option.selected = item.value === selectedLevel;
                    levelSelect.appendChild(option);
                });

                if (!filtered.some(item => item.value === selectedLevel)) {
                    levelSelect.value = '';
                }
            }

            languageSelect.addEventListener('change', renderLevels);
            renderLevels();
        })();
    </script>
@endsection
