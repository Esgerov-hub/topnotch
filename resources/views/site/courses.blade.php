@extends('site.layouts.app')

@php
    $pageTitle = __('site.courses_title');
    $courseCategories = $courseCategories ?? collect();
    $mainLanguages = $mainLanguages ?? collect();
    $levels = $levels ?? collect();
@endphp

@section('site.title')
    {{ $pageTitle }}
@endsection

@section('site.meta_description')
    {{ __('site.courses_text') }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$pageTitle, __('site.course_categories'), __('site.language_courses')])) }}
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
                            <a class="d-lg-none btn btn-md btn-outline-dark rounded-pill w-100" data-bs-toggle="offcanvas" href="#coursesFilters" role="button" aria-controls="coursesFilters">
                                <i class="bi bi-sliders me-2"></i>@lang('admin.filter')
                            </a>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-start offcanvas-collapse side-filter" tabindex="-1" id="coursesFilters" aria-labelledby="coursesFiltersLabel">
                        <div class="offcanvas-header d-lg-none border-bottom">
                            <h5 class="offcanvas-title" id="coursesFiltersLabel">@lang('admin.filter')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body pt-4 pt-lg-0 p-lg-0">
                            <form method="GET" action="{{ route('site.courses') }}" class="d-flex flex-column gap-3">
                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.search')</label>
                                    <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="@lang('admin.search')">
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('site.course_categories')</label>
                                    <select class="form-select" name="category">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($courseCategories as $category)
                                            @php $categoryName = data_get($category, "title.$currentLang") ?? data_get($category, 'title.az'); @endphp
                                            <option value="{{ $category->id }}" @selected((string)($categoryId ?? '') === (string)$category->id)>{{ $categoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('admin.languages')</label>
                                    <select class="form-select" name="language" id="course-language">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($mainLanguages as $language)
                                            @php $languageName = data_get($language, "name.$currentLang") ?? data_get($language, 'name.az'); @endphp
                                            <option value="{{ $language->id }}" @selected((string)($languageId ?? '') === (string)$language->id)>{{ $languageName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="single-side-box card border shadow-sm rounded-3 p-3">
                                    <label class="form-label fw-medium">@lang('site.course_level')</label>
                                    <select class="form-select" name="level" id="course-level">
                                        <option value="">@lang('admin.choose')</option>
                                        @foreach($levels as $level)
                                            @php $levelName = data_get($level, "name.$currentLang") ?? data_get($level, 'name.az'); @endphp
                                            <option value="{{ $levelName }}" data-language-id="{{ $level->parent_id }}" @selected((string)($levelId ?? '') === (string)$level->id || (string)($levelId ?? '') === (string)$levelName)>{{ $levelName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-dark rounded-pill flex-grow-1">@lang('admin.filter')</button>
                                    <a href="{{ route('site.courses') }}" class="btn btn-outline-secondary rounded-pill">@lang('admin.clear')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8 col-12">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h2 class="h4 mb-1">@lang('site.language_courses')</h2>
                            <div class="text-muted small">{{ $courses->total() }} @lang('site.course')</div>
                        </div>
                    </div>

                    <div class="row g-xl-3 g-4 mb-5">
                        @forelse($courses as $course)
                            @php
                                $courseTitle = data_get($course, "name.$currentLang") ?? data_get($course, 'name.az');
                                $courseText = data_get($course, "text.$currentLang") ?? data_get($course, 'text.az');
                                $courseSlug = data_get($course, "slug.$currentLang") ?: data_get($course, 'slug.az') ?: 'course';
                                $teacherName = data_get($course, "teacher.name.$currentLang") ?? data_get($course, 'teacher.name.az');
                                $categoryName = data_get($course, "courseCategory.title.$currentLang") ?? data_get($course, 'courseCategory.title.az');
                            @endphp
                            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6">
                                <div class="education_block_grid border">
                                    <div class="education-thumb position-relative">
                                        <a href="{{ route('site.courses-details', ['courseSlug' => $courseSlug, 'courseId' => $course->id]) }}">
                                            <img src="{{ !empty($course->image) ? asset('uploads/languageCourses/' . $course->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid w-100" alt="{{ $courseTitle }}" style="aspect-ratio: 16 / 10; object-fit: contain;">
                                        </a>
                                    </div>
                                    <div class="education-body p-3">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            @if($teacherName)
                                                <span class="badge bg-light text-dark rounded-pill">{{ $teacherName }}</span>
                                            @endif
                                            @if($categoryName)
                                                <span class="badge bg-light-primary text-primary rounded-pill">{{ $categoryName }}</span>
                                            @elseif($course->language)
                                                <span class="badge bg-light text-dark rounded-pill">{{ data_get($course, "language.name.$currentLang") ?? data_get($course, 'language.name.az') }}</span>
                                            @endif
                                        </div>
                                        <div class="education-title">
                                            <h4 class="fs-6 fw-medium mb-2">
                                                <a href="{{ route('site.courses-details', ['courseSlug' => $courseSlug, 'courseId' => $course->id]) }}">{{ $courseTitle }}</a>
                                            </h4>
                                        </div>
                                        @if($courseText)
                                            <p class="text-muted-2 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($courseText), 140) }}</p>
                                        @endif
                                    </div>
                                    <div class="education-footer p-3">
                                        <div class="enrolled-link">
                                            <a href="{{ route('site.courses-details', ['courseSlug' => $courseSlug, 'courseId' => $course->id]) }}" class="main-link fw-medium">@lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i></a>
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
                        <div class="col-12">{{ $courses->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('site.js')
    <script>
        (function () {
            const languageSelect = document.getElementById('course-language');
            const levelSelect = document.getElementById('course-level');
            if (!languageSelect || !levelSelect) return;

            const levelOptions = Array.from(levelSelect.options).map(option => ({
                value: option.value,
                label: option.text,
                languageId: option.dataset.languageId || ''
            })).filter(item => item.value !== '');

            function renderLevels() {
                const selectedLanguage = languageSelect.value || '';
                const selectedLevel = levelSelect.value || '';
                const filtered = selectedLanguage ? levelOptions.filter(item => item.languageId === selectedLanguage) : levelOptions.slice();

                levelSelect.innerHTML = '';
                const empty = document.createElement('option');
                empty.value = '';
                empty.textContent = @json(__('admin.choose'));
                levelSelect.appendChild(empty);

                const uniqueFiltered = filtered.filter((item, index, items) =>
                    items.findIndex(candidate => candidate.value === item.value) === index
                );

                uniqueFiltered.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.value;
                    option.textContent = item.label;
                    option.selected = item.value === selectedLevel;
                    levelSelect.appendChild(option);
                });

                if (!uniqueFiltered.some(item => item.value === selectedLevel)) {
                    levelSelect.value = '';
                }
            }

            languageSelect.addEventListener('change', renderLevels);
            renderLevels();
        })();
    </script>
@endsection
