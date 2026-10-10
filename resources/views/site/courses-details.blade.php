@extends('site.layouts.app')

@php
    $courseTitle = data_get($course, "name.$currentLang") ?? data_get($course, 'name.az') ?? __('site.courses_title');
    $courseText = data_get($course, "text.$currentLang") ?? data_get($course, 'text.az');
    $courseFullText = data_get($course, "full_text.$currentLang") ?? data_get($course, 'full_text.az');
    $categoryName = data_get($course, "courseCategory.title.$currentLang") ?? data_get($course, 'courseCategory.title.az');
    $languageName = data_get($course, "language.name.$currentLang") ?? data_get($course, 'language.name.az');
    $levelName = data_get($course, "parentLanguage.name.$currentLang") ?? data_get($course, 'parentLanguage.name.az');
    $teacherName = data_get($course, "teacher.name.$currentLang") ?? data_get($course, 'teacher.name.az');
    $courseSlug = data_get($course, "slug.$currentLang") ?? data_get($course, 'slug.az');
@endphp

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
                    <div class="courses-video">
                        <div class="thumb">
                            <img class="pro_img img-fluid w100" src="{{ !empty($course->image) ? asset('uploads/languageCourses/'.$course->image) : asset('site/assets/img/co-5.jpg') }}" alt="{{ $courseTitle }}">
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
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="sec-heading">
                            <h2>@lang('site.courses_detail_related')</h2>
                        </div>
                    </div>
                    @foreach($relatedCourses as $related)
                        @php
                            $relatedTitle = data_get($related, "name.$currentLang") ?? data_get($related, 'name.az');
                            $relatedCourseSlug = data_get($related, "slug.$currentLang") ?? data_get($related, 'slug.az');
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="education_block_grid border h-100">
                                <div class="education-thumb position-relative">
                                    <a href="{{ route('site.courses-details', $related->id) }}">
                                        <img src="{{ !empty($related->image) ? asset('uploads/languageCourses/'.$related->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid w-100" alt="{{ $relatedTitle }}" style="aspect-ratio: 16 / 10; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="education-body p-3">
                                    <div class="education-title">
                                        <h4 class="fs-6 fw-medium mb-0">
                                            <a href="{{ route('site.courses-details', $related->id) }}">{{ $relatedTitle }}</a>
                                        </h4>
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
