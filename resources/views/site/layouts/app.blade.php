<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @php
        $siteName = config('app.name', 'Topnotch.az');
        $siteCssVersion = @filemtime(public_path('site/assets/css/styles.css')) ?: time();
        $siteColorVersion = @filemtime(public_path('site/assets/css/colors.css')) ?: time();
        $pageTitle = trim($__env->yieldContent('site.title'));
        $metaDescription = trim($__env->yieldContent('site.meta_description'));
        $metaKeywords = trim($__env->yieldContent('site.meta_keywords'));
        $metaImage = trim($__env->yieldContent('site.meta_image'));
        $fullTitle = $pageTitle !== '' ? $pageTitle . ' | ' . $siteName : $siteName;
    @endphp
    <meta charset="utf-8" />
    <meta name="author" content="{{ $siteName }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $metaDescription ?: $siteName }}">
    @if($metaKeywords !== '')
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $metaDescription ?: $siteName }}">
    @if($metaImage !== '')
        <meta property="og:image" content="{{ $metaImage }}">
        <meta name="twitter:image" content="{{ $metaImage }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription ?: $siteName }}">
    @yield('site.css')
    <link href="{{ asset('site/assets/css/styles.css') }}?v={{ $siteCssVersion }}" rel="stylesheet">
    <link href="{{ asset('site/assets/css/colors.css') }}?v={{ $siteColorVersion }}" rel="stylesheet">
</head>
<body class="red-skin">
<div id="preloader">
    <div class="preloader">
        <span></span><span></span>
    </div>
</div>
<div id="main-wrapper">
    <x-site.header />
    @yield('site.content')
    <x-site.footer />
</div>
</body>
</html>
