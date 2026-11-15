@extends('site.layouts.app')

@php
    $pageTitle = __('site.blogs_title');
    $categories = $categories ?? collect();
@endphp

@section('site.title')
    {{ $pageTitle }}
@endsection

@section('site.meta_description')
    {{ __('site.blogs_text') }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$pageTitle, __('site.blogs'), __('site.read_more')])) }}
@endsection

@section('site.content')
    <section class="bg-gredient page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pageTitle-wrap text-center">
                        <h1 class="text-light">{{ $pageTitle }}</h1>
                        <p class="text-light">{{ __('site.blogs_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-xxl-3 col-lg-4 col-12">
                    <div class="single-side-box card border shadow-sm rounded-3 p-3 mb-3">
                        <form method="GET" action="{{ route('site.blogs') }}">
                            <label class="form-label fw-medium">@lang('admin.search')</label>
                            <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control mb-3" placeholder="@lang('admin.search')">
                            <button class="btn btn-dark rounded-pill w-100" type="submit">@lang('admin.filter')</button>
                        </form>
                    </div>
                    <div class="single-side-box card border shadow-sm rounded-3 p-3">
                        <label class="form-label fw-medium">@lang('admin.categories')</label>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 mt-3">
                            @foreach($categories as $category)
                                @php $categoryTitle = data_get($category, "title.$currentLang") ?? data_get($category, 'title.az'); @endphp
                                <li><a href="{{ route('site.blogs', ['category' => $category->id]) }}" class="text-muted-2">{{ $categoryTitle }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8 col-12">
                    <div class="row align-items-center justify-content-center mb-5">
                        @forelse($news as $item)
                            @php
                                $newsTitle = data_get($item, "title.$currentLang") ?? data_get($item, 'title.az');
                                $newsText = data_get($item, "text.$currentLang") ?? data_get($item, 'text.az');
                                $categorySlug = data_get($item, "category.slug.$currentLang") ?: data_get($item, 'category.slug.az');
                                $newsSlug = data_get($item, "slug.$currentLang") ?: data_get($item, 'slug.az');
                                $categoryTitle = data_get($item, "category.title.$currentLang") ?? data_get($item, 'category.title.az');
                            @endphp
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card mb-4 shadow-sm card-lift">
                                    <a href="{{ route('site.blogDetail', [$categorySlug ?: 'news', $newsSlug ?: 'result', $item->id]) }}">
                                        <img src="{{ !empty($item->image) ? asset('uploads/news/'.$item->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid" alt="{{ $newsTitle }}">
                                    </a>
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            @if($categoryTitle)
                                                <span class="badge bg-light-green text-green rounded-2">{{ $categoryTitle }}</span>
                                            @endif
                                        </div>
                                        <h4 class="grid-blog-heading lh-base">
                                            <a href="{{ route('site.blogDetail', [$categorySlug ?: 'news', $newsSlug ?: 'result', $item->id]) }}" class="text-inherit">{{ $newsTitle }}</a>
                                        </h4>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($newsText ?? ''), 120) }}</p>
                                        <div class="row align-items-center g-0 mt-4">
                                            <div class="col ps-2">
                                                <div class="education-footer p-3">
                                                    <div class="enrolled-link"><a href="{{ route('site.blogDetail', [$categorySlug ?: 'news', $newsSlug ?: 'result', $item->id]) }}" class="main-link fw-medium">@lang('site.read_more')<i class="bi bi-arrow-right ms-2"></i></a></div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <p class="text-muted text-mid m-0">02 Min Read</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><div class="alert alert-light border mb-0">@lang('site.no_data_found')</div></div>
                        @endforelse
                    </div>
                    <div class="row">
                        <div class="col-12">{{ $news->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('site.js')
@endsection
