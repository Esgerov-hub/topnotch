@php
    $headerLogo = !empty(data_get($data['setting'] ?? null, 'header_logo'))
        ? asset('uploads/settings/' . data_get($data['setting'] ?? null, 'header_logo'))
        : asset('site/assets/img/logo-icon.png');
@endphp
<div class="header header-light">
    <div class="container">
        <nav id="navigation" class="navigation navigation-landscape">
            <div class="nav-header">
                <a class="nav-brand" href="{{ route('site.index') }}">
                    <img src="{{ $headerLogo }}" class="logo" alt="{{ config('app.name', 'Topnotch.az') }}" />
                </a>
                <div class="mobile_nav">
                    <div class="btn-group account-drop language-drop">
                        <button type="button" class="btn btn-order-by-filt language-switch-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-globe"></i>
                            <span>{{ strtoupper($data['lang'] ?? app()->getLocale()) }}</span>
                        </button>
                        <ul class="dropdown-menu language-menu">
                            @foreach(($data['languageLinks'] ?? []) as $language)
                                <li>
                                    <a class="dropdown-item @if($language->active) active @endif" href="{{ $language->url }}" lang="{{ $language->code }}">{{ $language->label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </div>
            <div class="nav-menus-wrapper">
                <ul class="nav-menu">
                    <li>
                        <a href="#">@lang('site.about_us')</a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="{{ route('site.about') }}">@lang('site.who')</a></li>
                            <li><a href="{{ route('site.blogs') }}">@lang('site.blogs')</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">@lang('site.courses_title')</a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="{{ route('site.courses') }}">@lang('site.all_courses')</a></li>
                            @if(!empty($data['courseCategories']))
                                @foreach($data['courseCategories'] as $categoryItem)
                                    <li>
                                        <a href="{{ $categoryItem->url }}">{{ $categoryItem->title }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>

                    <li><a href="{{ route('site.study-abroad') }}">@lang('site.study_abroads')</a></li>
                    <li><a href="{{ route('site.schools') }}">@lang('site.schools')</a></li>
                    <li><a href="{{ route('site.contact') }}">@lang('site.contact_us')</a></li>
                    <li class="desktop-lang">
                        <div class="btn-group account-drop language-drop">
                            <button type="button" class="btn btn-order-by-filt language-switch-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-globe"></i>
                                <span>{{ strtoupper($data['lang'] ?? app()->getLocale()) }}</span>
                            </button>
                            <ul class="dropdown-menu language-menu">
                                @foreach(($data['languageLinks'] ?? []) as $language)
                                    <li>
                                        <a class="dropdown-item @if($language->active) active @endif" href="{{ $language->url }}" lang="{{ $language->code }}">{{ $language->label }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="clearfix"></div>
