@php use Illuminate\Support\Str; @endphp
@extends('site.layouts.app')
@section('site.title')
    {{ __('site.study_abroads') }}
@endsection

@section('site.meta_description')
    {{ __('site.study_abroads_text') }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([__('site.study_abroads'), __('site.country'), __('site.university')])) }}
@endsection

@section('site.css')
@endsection
@section('site.content')
    <section class="bg-gredient page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pageTitle-wrap">
                        <h1 class="text-light">@lang('site.study_abroads')</h1>
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
                            <a class="d-lg-none btn btn-md btn-outline-dark rounded-pill w-100" data-bs-toggle="offcanvas" href="#studyAbroadFilters" role="button" aria-controls="studyAbroadFilters">
                                <i class="bi bi-sliders me-2"></i>@lang('admin.filter')
                            </a>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-start offcanvas-collapse side-filter" tabindex="-1" id="studyAbroadFilters" aria-labelledby="studyAbroadFiltersLabel">
                        <div class="offcanvas-header d-lg-none border-bottom">
                            <h5 class="offcanvas-title" id="studyAbroadFiltersLabel">@lang('admin.filter')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body pt-4 pt-lg-0 p-lg-0">
                            <form method="GET" action="{{ route('site.study-abroad') }}" class="d-flex flex-column gap-3">
                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.search')</label>
                                    <div class="position-relative">
                                        <input type="text" name="q" value="{{ $search }}" class="form-control ps-5" placeholder="@lang('admin.search')">
                                        <span class="position-absolute top-50 start-0 translate-middle ms-4 opacity-50">
                                            <i class="bi bi-search fs-5"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.countries')</label>
                                    <select class="form-select" name="country" id="study-country">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($countries as $country)
                                            @php $countryOptionSlug = data_get($country, "slug.$currentLang") ?? data_get($country, 'slug.az'); @endphp
                                            <option value="{{ $countryOptionSlug }}" data-country-id="{{ $country->id }}" @selected(request('country') === $countryOptionSlug)>
                                                {{ data_get($country, "name.$currentLang") ?? data_get($country, 'name.az') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.universities')</label>
                                    <select class="form-select" name="university" id="study-university">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($universities as $university)
                                            @php $universitySlug = data_get($university, "slug.$currentLang") ?? data_get($university, 'slug.az'); @endphp
                                            <option value="{{ $universitySlug }}" data-country-id="{{ $university->country_id }}" @selected(request('university') === $universitySlug)>
                                                {{ data_get($university, "name.$currentLang") ?? data_get($university, 'name.az') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.educationalDegrees')</label>
                                    <select class="form-select" name="degree" id="study-degree">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($educationalDegrees as $degree)
                                            @php $degreeSlug = data_get($degree, "slug.$currentLang") ?? data_get($degree, 'slug.az'); @endphp
                                            <option value="{{ $degreeSlug }}" @selected(request('degree') === $degreeSlug)>
                                                {{ data_get($degree, "name.$currentLang") ?? data_get($degree, 'name.az') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-dark rounded-pill flex-grow-1">@lang('admin.filter')</button>
                                    <a href="{{ route('site.study-abroad') }}" class="btn btn-outline-secondary rounded-pill">Sıfırla</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8 col-12">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h2 class="h4 mb-1">@lang('site.study_abroads')</h2>
                            <div class="text-muted small">{{ $studyAbroads->total() }} nəticə</div>
                        </div>
                    </div>

                    <div class="row g-xl-3 g-4 mb-5">
                        @forelse($studyAbroads as $studyAbroad)
                            @php
                                $title = data_get($studyAbroad, "name.$currentLang") ?? data_get($studyAbroad, 'name.az');
                                $shortText = data_get($studyAbroad, "text.$currentLang") ?? data_get($studyAbroad, 'text.az');
                                $countrySlug = data_get($studyAbroad, "country.slug.$currentLang") ?? data_get($studyAbroad, 'country.slug.az');
                                $universitySlug = data_get($studyAbroad, "university.slug.$currentLang") ?? data_get($studyAbroad, 'university.slug.az');
                                $studySlug = data_get($studyAbroad, "slug.$currentLang") ?? data_get($studyAbroad, 'slug.az');
                            @endphp
                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6">
                                <div class="education_block_grid border">
                                    <div class="education-thumb position-relative">
                                        <a href="{{ route('site.study-abroad-details', [$countrySlug, $universitySlug, $studySlug]) }}">
                                            <img src="{{ !empty($studyAbroad->image) ? asset('uploads/studyAbroads/' . $studyAbroad->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid w-100" alt="{{ $title }}" style="aspect-ratio: 16 / 10; object-fit: contain;">
                                        </a>
                                    </div>

                                    <div class="education-body p-3">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-light text-dark">{{ data_get($studyAbroad, "country.name.$currentLang") ?? data_get($studyAbroad, 'country.name.az') }}</span>
                                            <span class="badge bg-light text-dark">{{ data_get($studyAbroad, "degree.name.$currentLang") ?? data_get($studyAbroad, 'degree.name.az') }}</span>
                                        </div>
                                        <div class="education-title">
                                            <h4 class="fs-6 fw-medium mb-0">
                                                <a href="{{ route('site.study-abroad-details', [$countrySlug, $universitySlug, $studySlug]) }}">{{ $title }}</a>
                                            </h4>
                                        </div>
                                        <p class="text-muted mt-3 mb-0">{{ Str::limit(strip_tags($shortText), 160) }}</p>
                                    </div>

                                    <div class="education-footer p-3 pt-0">
                                        <div class="enrolled-link">
                                            <a href="{{ route('site.study-abroad-details', [$countrySlug, $universitySlug, $studySlug]) }}" class="main-link fw-medium">
                                                @lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border mb-0">
                                    @lang('site.no_data_found')
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            {{ $studyAbroads->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('site.js')
    <script>
        (function ($) {
            const $countrySelect = $('#study-country');
            const $universitySelect = $('#study-university');
            const universityOptions = $universitySelect.find('option').toArray().map(function (option) {
                return {
                    value: option.value,
                    label: $(option).text(),
                    countryId: String($(option).data('country-id') || '')
                };
            }).filter(function (item) {
                return item.value !== '';
            });

            function renderUniversities() {
                const countryId = String($countrySelect.find('option:selected').data('country-id') || '');
                const selectedUniversity = $universitySelect.val() || '';
                const filteredUniversities = countryId
                    ? universityOptions.filter(function (item) {
                        return item.countryId === countryId;
                    })
                    : universityOptions.slice();

                $universitySelect.empty().append(new Option(@json(__('admin.choose')), '', false, false));

                filteredUniversities.forEach(function (item) {
                    const option = new Option(item.label, item.value, false, item.value === selectedUniversity);
                    $universitySelect.append(option);
                });

                if (!filteredUniversities.some(function (item) {
                    return item.value === selectedUniversity;
                })) {
                    $universitySelect.val('');
                } else {
                    $universitySelect.val(selectedUniversity);
                }
            }

            $countrySelect.on('change', function () {
                renderUniversities();
            });

            renderUniversities();
        })(jQuery);
    </script>
@endsection
