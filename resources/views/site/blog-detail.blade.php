@extends('site.layouts.app')

@php
    $newsTitle = data_get($news, "title.$currentLang") ?? data_get($news, 'title.az') ?? __('site.blog_detail_title');
    $newsText = data_get($news, "text.$currentLang") ?? data_get($news, 'text.az');
    $newsFullText = data_get($news, "fulltext.$currentLang") ?? data_get($news, 'fulltext.az');
    $categoryTitle = data_get($news, "category.title.$currentLang") ?? data_get($news, 'category.title.az');
    $categorySlug = data_get($news, "category.slug.$currentLang") ?? data_get($news, 'category.slug.az');
    $newsSlug = data_get($news, "slug.$currentLang") ?? data_get($news, 'slug.az');
@endphp

@section('site.title')
    {{ $newsTitle }}
@endsection

@section('site.meta_description')
    {{ $newsText ? \Illuminate\Support\Str::limit(strip_tags($newsText), 160) : $newsTitle }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$newsTitle, $categoryTitle, __('site.blogs')])) }}
@endsection

@section('site.css')
    <style>
        .news-detail-media::before { display: none; }
        .news-detail-media .thumb img {
            display: block;
            width: 100%;
            height: clamp(240px, 45vw, 420px);
            object-fit: contain;
            background: #f3f5f8;
        }
    </style>
@endsection

@section('site.content')
    <div class="ed_detail_head">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5">
                    <div class="news-detail-media">
                        <div class="thumb">
                            <img class="img-fluid rounded-3" src="{{ !empty($news->image) ? asset('uploads/news/'.$news->image) : asset('site/assets/img/co-5.jpg') }}" alt="{{ $newsTitle }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="ed_detail_wrap">
                        <div class="course-type d-flex align-items-center gap-2 mb-1 flex-wrap">
                            @if($categoryTitle)
                                <span class="badge bg-light-green text-green rounded-pill">{{ $categoryTitle }}</span>
                            @endif
                        </div>
                        <div class="ed_header_caption">
                            <h1 class="ed_title">{{ $newsTitle }}</h1>
                        </div>
                        <div class="ed_header_short">
                            @if($newsText)
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($newsText), 220) }}</p>
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
                        <h4 class="edu_title">@lang('site.blog_detail_title')</h4>
                        {!! $newsFullText ?: nl2br(e($newsText ?? '')) !!}
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 pe-xl-5">
                    <div class="edu_wraper">
                        <h4 class="edu_title">@lang('site.blog_detail_related')</h4>
                        <ul class="edu_list right">
                            <li><span class="info-title"><i class="bi bi-tags"></i>@lang('site.blogs')</span><span class="text-dark right">{{ $categoryTitle ?? '-' }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if($relatedNews->count())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="sec-heading">
                            <h2>@lang('site.blog_detail_related')</h2>
                        </div>
                    </div>
                    @foreach($relatedNews as $item)
                        @php
                            $itemTitle = data_get($item, "title.$currentLang") ?? data_get($item, 'title.az');
                            $itemCategorySlug = data_get($item, "category.slug.$currentLang") ?: data_get($item, 'category.slug.az');
                            $itemSlug = data_get($item, "slug.$currentLang") ?: data_get($item, 'slug.az');
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="card mb-4 shadow-sm card-lift">
                                <a href="{{ route('site.blogDetail', [$itemCategorySlug ?: 'news', $itemSlug ?: 'result', $item->id]) }}">
                                    <img src="{{ !empty($item->image) ? asset('uploads/news/'.$item->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid" alt="{{ $itemTitle }}">
                                </a>
                                <div class="card-body">
                                    <h4 class="grid-blog-heading lh-base">
                                        <a href="{{ route('site.blogDetail', [$itemCategorySlug ?: 'news', $itemSlug ?: 'result', $item->id]) }}" class="text-inherit">{{ $itemTitle }}</a>
                                    </h4>
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
