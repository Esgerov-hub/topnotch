@extends('site.layouts.app')

@php
    $siteTitle = data_get($setting, "title.$currentLang") ?? data_get($setting, 'title.az') ?? config('app.name');
    $siteText = data_get($setting, "text.$currentLang") ?? data_get($setting, 'text.az');
    $siteAddress = data_get($setting, "address.$currentLang") ?? data_get($setting, 'address.az');
    $aboutTitle = data_get($aboutPage, "title.$currentLang") ?? data_get($aboutPage, 'title.az') ?? __('site.about_us');
    $aboutSubTitle = data_get($aboutPage, "sub_title.$currentLang") ?? data_get($aboutPage, 'sub_title.az');
    $aboutText = data_get($aboutPage, "text.$currentLang") ?? data_get($aboutPage, 'text.az');
    $aboutIntro = $aboutText ? \Illuminate\Support\Str::words(strip_tags($aboutText), 40, '...') : null;
    $aboutImage = !empty($aboutPage->image) ? asset('uploads/about/' . $aboutPage->image) : asset('site/assets/img/custom-img-1.png');
    $promoLines = array_filter([
        $siteTitle,
        '+994 50 540 92 93',
        data_get($setting, 'phone'),
        data_get($setting, 'email'),
    ]);
@endphp

@section('site.meta_description')
    {{ \Illuminate\Support\Str::limit(trim(strip_tags($siteText ?? '')), 160) ?: $siteTitle }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$siteTitle, __('site.courses_title'), __('site.study_abroads'), __('site.schools')])) }}
@endsection

@section('site.title')
    {{ $siteTitle }}
@endsection

@section('site.content')
    <div class="notifications-wrapper bg-warning py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <marquee>
                        @foreach($promoLines as $line)
                            <span><i class="bi bi-lightbulb-fill me-2"></i>{{ $line }}</span>
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    </div>

    <div class="hero_banner py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-12">
                    <div class="hero-media-shell ps-xl-5">
                        <div class="hero-media-slider">
                            @forelse($sliders as $slider)
                                @php
                                    $sliderTitle = data_get($slider, "title.$currentLang") ?? data_get($slider, 'title.az');
                                    $sliderText = data_get($slider, "text.$currentLang") ?? data_get($slider, 'text.az');
                                @endphp
                                <div>
                                    <div class="hero-media-card">
                                        <img src="{{ !empty($slider->image) ? asset('uploads/sliders/' . $slider->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid home-slide-image" alt="{{ $sliderTitle ?? $siteTitle }}" onerror="this.onerror=null;this.src='{{ asset('site/assets/img/co-1.jpg') }}';">
                                        <div class="hero-media-overlay">
                                            <span>{{ $siteTitle }}</span>
                                            <strong>{{ $sliderTitle ?? $siteTitle }}</strong>
                                            @if($sliderText)
                                                <p class="mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($sliderText), 90) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    <div class="hero-media-card">
                                        <img src="{{ asset('site/assets/img/co-1.jpg') }}" class="img-fluid home-slide-image" alt="{{ $siteTitle }}">
                                        <div class="hero-media-overlay">
                                            <span>{{ $siteTitle }}</span>
                                            <strong>{{ $siteTitle }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="trips_wrap full bg-main py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="trips d-flex align-items-center gap-3 pe-xl-5">
                        <div class="trips_icons flex-1">
                            <span class="square--60 circle bg-transparents"><i class="bi bi-person-badge fs-4 text-light"></i></span>
                        </div>
                        <div class="trips_detail">
                            <h5 class="text-light lh-base mb-0">22+ @lang('site.teacher')</h5>
                            <p class="text-light opacity-75 lh-base m-0">Müəllim heyəti</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="trips d-flex align-items-center gap-3 pe-xl-5">
                        <div class="trips_icons flex-1">
                            <span class="square--60 circle bg-transparents"><i class="bi bi-airplane-fill fs-4 text-light"></i></span>
                        </div>
                        <div class="trips_detail">
                            <h5 class="text-light lh-base mb-0">6000+ @lang('site.study_abroads')</h5>
                            <p class="text-light opacity-75 lh-base m-0">Xaricdə təhsil qəbulu</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="trips d-flex align-items-center gap-3 pe-xl-5">
                        <div class="trips_icons flex-1">
                            <span class="square--60 circle bg-transparents"><i class="bi bi-translate fs-4 text-light"></i></span>
                        </div>
                        <div class="trips_detail">
                            <h5 class="text-light lh-base mb-0">8000+ @lang('site.language_courses')</h5>
                            <p class="text-light opacity-75 lh-base m-0">Dil kursu Məzunu</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="trips d-flex align-items-center gap-3 pe-xl-5">
                        <div class="trips_icons flex-1">
                            <span class="square--60 circle bg-transparents"><i class="bi bi-building fs-4 text-light"></i></span>
                        </div>
                        <div class="trips_detail">
                            <h5 class="text-light lh-base mb-0">80+ @lang('site.university')</h5>
                            <p class="text-light opacity-75 lh-base m-0">Tərəfdaş Universitet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center justify-content-center gx-xl-5 gx-lg-5 g-4">
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <div class="history-Wraping">
                        <div class="d-block mb-4">
                            <h2 class="display-5 fw-normal">{{ $aboutTitle }}</h2>
                            @if($aboutSubTitle)
                                <p class="text-muted-2">{{ $aboutSubTitle }}</p>
                            @endif
                          {{--  @if($aboutIntro)
                                <div class="text-muted-2">{!! $aboutIntro !!}</div>
                            @endif--}}
                        </div>

                        <div class="benifit-wraps mb-4">
                            <div class="d-flex flex-column gap-4">
                                <div class="d-flex align-items-center justify-content-start gap-3">
                                    <div class="icons"><span class="square--50 circle bg-light-green fs-5"><i class="bi bi-patch-check-fill text-green"></i></span></div>
                                    <div class="caps">
                                        <h5>@lang('site.language_courses')</h5>
                                        <p class="text-muted-2 m-0">@lang('site.language_courses_text')</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start gap-3">
                                    <div class="icons"><span class="square--50 circle bg-light-green fs-5"><i class="bi bi-patch-check-fill text-green"></i></span></div>
                                    <div class="caps">
                                        <h5>@lang('site.study_abroads')</h5>
                                        <p class="text-muted-2 m-0">@lang('site.study_abroads_text')</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start gap-3">
                                    <div class="icons"><span class="square--50 circle bg-light-green fs-5"><i class="bi bi-patch-check-fill text-green"></i></span></div>
                                    <div class="caps">
                                        <h5>@lang('site.schools')</h5>
                                        <p class="text-muted-2 m-0">@lang('site.contact_text')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('site.about') }}" class="btn btn-dark rounded-pill px-5">@lang('site.read_more')</a>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 order-lg-2">
                    <div class="facts-img">
                        <img src="{{ $aboutImage }}" class="img-fluid" alt="{{ $aboutTitle }}" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center justify-content-center gx-xl-5 gx-lg-5 g-4">
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
                    <div class="facts-img">
                        <img src="{{ asset('site/assets/img/custom-img-3.png') }}" class="img-fluid" alt="" />
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <div class="supporting-wraps">
                        <div class="d-block mb-4">
                            <h2 class="display-5 fw-normal">@lang('site.faq')</h2>
                            <p class="text-muted-2">@lang('site.contact_text')</p>
                        </div>

                        <div id="supportingExample" class="accordion supporting">
                            @forelse($faqs as $index => $faq)
                                @php
                                    $faqTitle = data_get($faq, "question.$currentLang") ?? data_get($faq, 'question.az');
                                    $faqText = data_get($faq, "answer.$currentLang") ?? data_get($faq, 'answer.az');
                                @endphp
                                <div class="card border shadow-0 mb-3">
                                    <div id="heading{{ $index }}" class="card-header">
                                        <h6 class="mb-0 accordion_title">
                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}" class="d-block position-relative text-dark fw-semibold collapsible-link py-2">{{ $faqTitle }}</a>
                                        </h6>
                                    </div>
                                    <div id="collapse{{ $index }}" aria-labelledby="heading{{ $index }}" data-parent="#supportingExample" class="collapse @if($index === 0) show @endif">
                                        <div class="card-body text-muted p-3">
                                            {{ $faqText }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-light border mb-0">@lang('site.no_data_found')</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5 home-featured-courses-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="sec-heading center">
                        <h2>@lang('site.courses_title')</h2>
                        <p>@lang('site.courses_text')</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="four_slide articles arrow_middle home-featured-courses">
                        @forelse($featuredCourses as $course)
                            @php
                                $courseTitle = data_get($course, "name.$currentLang") ?? data_get($course, 'name.az');
                                $courseText = data_get($course, "text.$currentLang") ?? data_get($course, 'text.az');
                                $courseSlug = data_get($course, "slug.$currentLang") ?? data_get($course, 'slug.az');
                                $courseCategory = data_get($course, "courseCategory.title.$currentLang") ?? data_get($course, 'courseCategory.title.az');
                            @endphp
                            <div class="singles_items">
                                <div class="education_block_grid border">
                                    <div class="education-thumb position-relative">
                                        <a href="{{ route('site.courses-details', $course->id) }}">
                                            <img src="{{ !empty($course->image) ? asset('uploads/languageCourses/' . $course->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid home-slide-image" alt="{{ $courseTitle }}" onerror="this.onerror=null;this.src='{{ asset('site/assets/img/co-1.jpg') }}';">
                                        </a>
                                    </div>
                                    <div class="education-body p-3">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            @if($courseCategory)
                                                <span class="badge bg-light-primary text-primary rounded-pill">{{ $courseCategory }}</span>
                                            @endif
                                            @if($course->teacher)
                                                <span class="badge bg-light text-dark rounded-pill">{{ data_get($course, "teacher.name.$currentLang") ?? data_get($course, 'teacher.name.az') }}</span>
                                            @endif
                                        </div>
                                        <div class="education-title">
                                            <h4 class="fs-6 fw-medium">
                                                <a href="{{ route('site.courses-details', $course->id) }}">{{ $courseTitle }}</a>
                                            </h4>
                                        </div>
                                        @if($courseText)
                                            <p class="text-muted-2 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($courseText), 120) }}</p>
                                        @endif
                                    </div>
                                    <div class="education-footer p-3">
                                        <a href="{{ route('site.courses-details', $course->id) }}" class="main-link fw-medium">@lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border mb-0">@lang('site.no_data_found')</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="sec-heading center">
                        <h2>@lang('site.blogs_title')</h2>
                        <p>@lang('site.blogs_text')</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="arrow_slide four_slide arrow_middle">
                        @forelse($news as $item)
                            @php
                                $newsTitle = data_get($item, "title.$currentLang") ?? data_get($item, 'title.az');
                                $newsText = data_get($item, "text.$currentLang") ?? data_get($item, 'text.az');
                                $newsSlug = data_get($item, "slug.$currentLang") ?? data_get($item, 'slug.az');
                                $categorySlug = data_get($item, "category.slug.$currentLang") ?? data_get($item, 'category.slug.az');
                            @endphp
                            <div class="singles_items">
                                <div class="education_block_grid border">
                                    <div class="education-thumb position-relative">
                                        <a href="{{ route('site.blogDetail', [$categorySlug, $newsSlug]) }}">
                                            <img src="{{ !empty($item->image) ? asset('uploads/news/' . $item->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid home-slide-image" alt="{{ $newsTitle }}" onerror="this.onerror=null;this.src='{{ asset('site/assets/img/co-1.jpg') }}';">
                                        </a>
                                    </div>
                                    <div class="education-body p-3">
                                        <div class="education-title">
                                            <h4 class="fs-6 fw-medium">
                                                <a href="{{ route('site.blogDetail', [$categorySlug, $newsSlug]) }}">{{ $newsTitle }}</a>
                                            </h4>
                                        </div>
                                        @if($newsText)
                                            <p class="text-muted-2 mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($newsText), 120) }}</p>
                                        @endif
                                    </div>
                                    <div class="education-footer p-3">
                                        <a href="{{ route('site.blogDetail', [$categorySlug, $newsSlug]) }}" class="main-link fw-medium">@lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="singles_items">
                                <div class="alert alert-light border mb-0">@lang('site.no_data_found')</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="sec-heading center">
                        <h2>@lang('site.team_text')</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="arrow_slide reviews-slide arrow_middle">
                        @forelse($commits as $commit)
                            @php
                                $commitName = data_get($commit, "name.$currentLang") ?? data_get($commit, 'name.az');
                                $commitDesc = data_get($commit, "description.$currentLang") ?? data_get($commit, 'description.az');
                                $commitImage = !empty($commit->image) ? asset('uploads/commits/' . $commit->image) : null;
                                $commitDate = !empty($commit->datetime) ? \Carbon\Carbon::parse($commit->datetime)->translatedFormat('d M Y') : (!empty($commit->created_at) ? $commit->created_at->translatedFormat('d M Y') : '');
                            @endphp

                            <div class="singles_items">
                                <div class="card-hover p-4 rounded-3 card card-body m-0">
                                    <div class="rating-star">
                                        <div class="d-flex align-items-center gap-1 mb-2">
                                            <span class="text-warning"><i class="bi bi-star-fill"></i></span><span class="text-warning"><i class="bi bi-star-fill"></i></span><span class="text-warning"><i class="bi bi-star-fill"></i></span><span class="text-warning"><i class="bi bi-star-fill"></i></span><span class="text-warning"><i class="bi bi-star-fill"></i></span>
                                        </div>
                                    </div>
                                    <div class="review-caption d-block mb-4">
                                        <h5 class="text-dark fw-semibold mb-0 lh-base">{{ $commitName }}</h5>
                                        <p class="text-muted-2">{{ $commitDesc }}</p>
                                    </div>
                                    <div class="d-flex bg-light align-items-center justify-content-between rounded-3 p-3">
                                        <div class="revierwer-avatar d-flex align-items-center gap-2">
                                            <div class="avatar-box">
                                                @if($commitImage)
                                                    <img src="{{ $commitImage }}" class="img-fluid square--50 circle" alt="{{ $commitName ?? $siteTitle }}" onerror="this.onerror=null;this.src='{{ asset('site/assets/img/user-1.jpg') }}';">
                                                @else
                                                    <span class="square--50 circle d-inline-flex align-items-center justify-content-center bg-light-primary text-primary" role="img" aria-label="{{ $commitName ?? $siteTitle }}">
                                                        <i class="bi bi-person-fill fs-4" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="reviewer-caps">
                                                <h6 class="fw-semibold text-dark m-0">{{ $commitName ?? $siteTitle }}</h6>
                                                <p class="text-muted-2 m-0 text-mid">{{ $commitDate }}</p>
                                            </div>
                                        </div>
                                        <div class="reviewer-post"><span class="badge bg-green rounded-pill">@lang('site.student')</span></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="singles_items">
                                <div class="alert alert-light border mb-0">@lang('site.no_data_found')</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div>
                    <div class="_partner_brands op-1">
                        <div class="single_brand" id="brand-slide">
                            @foreach($universities as $university)
                                    @php
                                        $universityName = data_get($university, "name.$currentLang") ?? data_get($university, 'name.az');
                                    @endphp
                                    <div class="single_brands">
                                        <img src="{{ asset('uploads/universities/' . $university->image) }}" class="img-fluid" alt="{{ $universityName }}" />
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('site.js')
@endsection
