@extends('site.layouts.app')

@php
    $courseTitle = data_get($course, "name.$currentLang") ?? data_get($course, 'name.az') ?? __('site.courses_title');
    $courseText = data_get($course, "text.$currentLang") ?? data_get($course, 'text.az');
    $courseFullText = data_get($course, "full_text.$currentLang") ?? data_get($course, 'full_text.az');
    $categoryName = data_get($course, "courseCategory.title.$currentLang") ?? data_get($course, 'courseCategory.title.az');
    $languageName = data_get($course, "language.name.$currentLang") ?? data_get($course, 'language.name.az');
    $levelName = data_get($course, "parentLanguage.name.$currentLang") ?? data_get($course, 'parentLanguage.name.az');
    $teacherName = data_get($course, "teacher.name.$currentLang") ?? data_get($course, 'teacher.name.az');
    $courseSlug = data_get($course, "slug.$currentLang") ?: data_get($course, 'slug.az') ?: 'course';
@endphp

@section('site.css')
    <style>
        .course-detail-media::before { display: none; }
        .course-detail-media .thumb {
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f5f8;
        }
        .course-detail-media .thumb .course-detail-poster {
            width: 100% !important;
            height: 100% !important;
            min-height: 0 !important;
            max-height: none !important;
            object-fit: contain !important;
            object-position: center;
        }
        @media (max-width: 767.98px) {
            .course-detail-media .thumb { height: 340px; }
        }
        @media (max-width: 479.98px) {
            .course-detail-media .thumb { height: 300px; }
        }
    </style>
@endsection

@section('site.title')
    {{ $courseTitle }}
@endsection

@section('site.meta_description')
    {{ $courseText ? \Illuminate\Support\Str::limit(strip_tags($courseText), 160) : $courseTitle }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$courseTitle, $categoryName, $languageName, $levelName])) }}
@endsection

@section('site.content')
    <div class="ed_detail_head">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5">
                    <div class="courses-video course-detail-media">
                        <div class="thumb">
                            <img class="pro_img img-fluid w100 course-detail-poster" src="{{ !empty($course->image) ? asset('uploads/languageCourses/'.$course->image) : asset('site/assets/img/co-5.jpg') }}" alt="{{ $courseTitle }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="ed_detail_wrap">
                        <div class="course-type d-flex align-items-center gap-2 mb-1 flex-wrap">
                            @if($categoryName)
                                <span class="badge bg-light-primary text-primary rounded-pill">{{ $categoryName }}</span>
                            @endif
                            @if($languageName)
                                <span class="badge bg-light-green text-green rounded-pill">{{ $languageName }}</span>
                            @endif
                            @if($levelName)
                                <span class="badge bg-light-red text-red rounded-pill">{{ $levelName }}</span>
                            @endif
                        </div>
                        <div class="ed_header_caption">
                            <h2 class="ed_title">{{ $courseTitle }}</h2>
                            <ul>
                                @if($teacherName)
                                    <li><i class="bi bi-people"></i>{{ $teacherName }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="ed_header_short">
                            @if($courseText)
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($courseText), 220) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 pe-xl-4">
                    <div class="edu_wraper">
                        <h4 class="edu_title">@lang('site.courses_detail_title')</h4>
                        {!! $courseFullText ?: nl2br(e($courseText ?? '')) !!}
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 pe-xl-5">
                    <div class="edu_wraper">
                        <h4 class="edu_title">@lang('site.courses_detail_features')</h4>
                        <ul class="edu_list right">
                            @if($teacherName)
                                <li><span class="info-title"><i class="bi bi-people"></i>@lang('site.teacher')</span><span class="text-dark right">{{ $teacherName }}</span></li>
                            @endif
                            @if($languageName)
                                <li><span class="info-title"><i class="bi bi-translate"></i>@lang('site.language')</span><span class="text-dark right">{{ $languageName }}</span></li>
                            @endif
                            @if($levelName)
                                <li><span class="info-title"><i class="bi bi-tags"></i>@lang('site.leve')</span><span class="text-dark right">{{ $levelName }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @if($relatedCourses->count())
                <div class="row g-xl-3 g-4 mt-4">
                    <div class="col-12">
                        <div class="sec-heading">
                            <h2>@lang('site.courses_detail_related')</h2>
                        </div>
                    </div>
                    @foreach($relatedCourses as $related)
                        @php
                            $relatedTitle = data_get($related, "name.$currentLang") ?? data_get($related, 'name.az');
                            $relatedCourseSlug = data_get($related, "slug.$currentLang") ?: data_get($related, 'slug.az') ?: 'course';
                            $relatedText = data_get($related, "text.$currentLang") ?? data_get($related, 'text.az');
                            $relatedTeacherName = data_get($related, "teacher.name.$currentLang") ?? data_get($related, 'teacher.name.az');
                            $relatedCategoryName = data_get($related, "courseCategory.title.$currentLang") ?? data_get($related, 'courseCategory.title.az');
                        @endphp
                        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6">
                            <div class="education_block_grid border">
                                <div class="education-thumb position-relative">
                                    <a href="{{ route('site.courses-details', ['courseSlug' => $relatedCourseSlug, 'courseId' => $related->id]) }}">
                                        <img src="{{ !empty($related->image) ? asset('uploads/languageCourses/'.$related->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid w-100" alt="{{ $relatedTitle }}" style="aspect-ratio: 16 / 10; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="education-body p-3">
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @if($relatedTeacherName)
                                            <span class="badge bg-light text-dark rounded-pill">{{ $relatedTeacherName }}</span>
                                        @endif
                                        @if($relatedCategoryName)
                                            <span class="badge bg-light-primary text-primary rounded-pill">{{ $relatedCategoryName }}</span>
                                        @elseif($related->language)
                                            <span class="badge bg-light text-dark rounded-pill">{{ data_get($related, "language.name.$currentLang") ?? data_get($related, 'language.name.az') }}</span>
                                        @endif
                                    </div>
                                    <div class="education-title">
                                        <h4 class="fs-6 fw-medium mb-2">
                                            <a href="{{ route('site.courses-details', ['courseSlug' => $relatedCourseSlug, 'courseId' => $related->id]) }}">{{ $relatedTitle }}</a>
                                        </h4>
                                    </div>
                                    @if($relatedText)
                                        <p class="text-muted-2 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($relatedText), 140) }}</p>
                                    @endif
                                </div>
                                <div class="education-footer p-3">
                                    <div class="enrolled-link">
                                        <a href="{{ route('site.courses-details', ['courseSlug' => $relatedCourseSlug, 'courseId' => $related->id]) }}" class="main-link fw-medium">@lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@section('site.js')
@endsection
