@php
    $setting = $data['setting'] ?? null;
    $siteName = $data['siteName'] ?? config('app.name', 'Topnotch.az');
    $siteAddress = $data['siteAddress'] ?? null;
    $sitePhone = $data['sitePhone'] ?? null;
    $siteEmail = $data['siteEmail'] ?? null;
    $siteJsVersion = @filemtime(public_path('site/assets/js/custom.js')) ?: time();
    $footerLogo = !empty(data_get($setting, 'footer_logo'))
        ? asset('uploads/settings/' . data_get($setting, 'footer_logo'))
        : asset('site/assets/img/logo-icon.png');
    $copyrightYear = now()->year;
@endphp

<section class="bg-cover newsletter bg-main" style="background:url({{ asset('site/assets/img/detail-bg-2.jpg') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8 col-sm-12">
                <div class="text-center">
                    <div class="subscribe-caption d-block mb-4">
                        <h2 class="text-light">@lang('site.newsletter_title')</h2>
                        <p class="text-light opacity-75">@lang('site.newsletter_text')</p>
                    </div>
                    <a href="{{ route('site.signup') }}" class="btn btn-dark rounded-pill px-5">@lang('site.newsletter_button')</a>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="dark-footer">
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="footer-widget">
                        <img src="{{ $footerLogo }}" class="img-footer" alt="{{ $siteName }}" />
                        <div class="footer-add">
                            @if(!empty($siteAddress))
                                <address class="mb-4 lh-base">{!! nl2br(e($siteAddress)) !!}<br>{{ $siteName }}</address>
                            @endif
                            @if(!empty($sitePhone))
                                <div class="d-flex align-items-center call-now gap-2 mb-3">
                                    <div class="square--30 circle bg-light-main text-main"><i class="bi bi-telephone"></i></div>
                                    <a class="fs-6 fw-semibold text-reset" href="tel:{{ preg_replace('/[^+0-9]/', '', $sitePhone) }}">{{ $sitePhone }}</a>
                                </div>
                                <div class="d-flex align-items-center call-now gap-2 mb-3">
                                    <div class="square--30 circle bg-light-main text-main"><i class="bi bi-telephone"></i></div>
                                    <a class="fs-6 fw-semibold text-reset" href="tel:+994505409293">+994 50 540 92 93</a>
                                </div>
                            @endif
                            @if(!empty($siteEmail))
                                <div class="d-flex align-items-center call-now gap-2">
                                    <div class="square--30 circle bg-light-main text-main"><i class="bi bi-envelope"></i></div>
                                    <a class="fs-6 fw-semibold text-reset" href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="footer-widget">
                        <h4 class="widget-title">@lang('site.footer_services')</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ route('site.study-abroad') }}">@lang('site.study_abroads')</a></li>
                            <li><a href="{{ route('site.courses') }}">@lang('site.courses_title')</a></li>
                            <li><a href="{{ route('site.schools') }}">@lang('site.schools')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5">
                    <div class="footer-widget">
                        <h4 class="widget-title">@lang('site.footer_other')</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ route('site.about') }}">@lang('site.about_us')</a></li>
                            <li><a href="{{ route('site.faqs') }}">@lang('site.faq')</a></li>
                            <li><a href="{{ route('site.contact') }}">@lang('site.contact_us')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-6 col-md-6">
                    <p class="mb-0">
                        &copy; {{ $copyrightYear }} {{ $siteName }} &mdash; @lang('site.footer_copyright')
                    </p>
                </div>
                <div class="col-lg-6 col-md-6 text-md-end">
                    <ul class="footer-bottom-social">
                        @foreach(['instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'twitter' => 'X', 'youtube' => 'YouTube', 'telegram' => 'Telegram', 'whatsapp' => 'WhatsApp'] as $icon => $label)
                            @php
                                $url = trim(data_get($setting, $icon) ?? '');
                                $socialHosts = [
                                    'instagram' => ['instagram.com'],
                                    'linkedin' => ['linkedin.com'],
                                    'twitter' => ['x.com', 'twitter.com'],
                                    'youtube' => ['youtube.com', 'youtu.be'],
                                    'telegram' => ['t.me', 'telegram.me'],
                                    'whatsapp' => ['wa.me', 'whatsapp.com'],
                                ];
                                $host = preg_replace('/^www\./', '', strtolower((string) parse_url($url, PHP_URL_HOST)));
                                $profilePath = trim((string) parse_url($url, PHP_URL_PATH), '/');
                            @endphp
                            @if(filter_var($url, FILTER_VALIDATE_URL) && in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true) && in_array($host, $socialHosts[$icon], true) && $profilePath !== '')
                                <li><a href="{{ $url }}" aria-label="{{ $label }}"><i class="bi bi-{{ $icon }}" aria-hidden="true"></i></a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<a id="back2Top" class="top-scroll" title="{{ __('site.back_to_top') }}" href="#"><i class="bi bi-arrow-up"></i></a>
</div>
<script src="{{ asset('site/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('site/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('site/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('site/assets/js/select2.min.js') }}"></script>
<script src="{{ asset('site/assets/js/slick.js') }}"></script>
<script src="{{ asset('site/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('site/assets/js/counterup.min.js') }}"></script>
<script>
    window.siteI18n = window.siteI18n || {};
    window.siteI18n.selectCategory = @json(__('site.select_category'));
    window.siteI18n.previousSlide = @json(__('site.previous_slide'));
    window.siteI18n.nextSlide = @json(__('site.next_slide'));
</script>
<script src="{{ asset('site/assets/js/custom.js') }}?v={{ $siteJsVersion }}"></script>
<script>
    const toggle = document.getElementById('billingSwitch');
    const prices = document.querySelectorAll('.card-price');

    function updatePrices(isYearly) {
        prices.forEach(price => {
            const monthly = price.getAttribute('data-monthly');
            const yearly = price.getAttribute('data-yearly');
            if (isYearly) {
                price.innerHTML = `$${yearly}<span class="text-dark fw-normal fs-6">/year</span>`;
            } else {
                price.innerHTML = `$${monthly}<span class="text-dark fw-normal fs-6">/mo</span>`;
            }
        });
    }

    if (toggle) {
        toggle.addEventListener('change', () => {
            updatePrices(toggle.checked);
        });

        updatePrices(toggle.checked);
    }
</script>
@yield('site.js')
</body>
</html>

