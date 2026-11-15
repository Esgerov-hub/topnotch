@php
    $contactTitle = __('site.contact_us');
    $address = data_get($setting, "address.$currentLang") ?? data_get($setting, 'address.az') ?? data_get($setting, 'address.en') ?? data_get($setting, 'address.ru');
    $phone = $setting->phone ?? null;
    $email = $setting->email ?? null;
@endphp

@extends('site.layouts.app')

@section('site.title')
    {{ $contactTitle }}
@endsection

@section('site.meta_description')
    {{ __('site.contact_text') }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$contactTitle, __('site.contact_us'), __('site.phone'), __('site.email')])) }}
@endsection

@section('site.css')
@endsection

@section('site.content')
    <section class="bg-gredient page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pageTitle-wrap text-center">
                        <h1 class="text-light">{{ $contactTitle }}</h1>
                        <p class="text-light mb-0">@lang('site.contact_text')</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8 col-md-7">
                    <div class="card border">
                        <div class="card-header">
                            <h4 class="card-title">@lang('site.contact')</h4>
                        </div>
                        <div class="card-body p-4">
                            <div id="contact-form-alert" class="alert d-none mb-4"></div>
                            <form id="contactForm" action="{{ route('site.sendContact') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label">@lang('site.name')</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    <div class="text-danger small js-field-error" data-field="name"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label">@lang('site.surname')</label>
                                    <input type="text" name="surname" class="form-control" value="{{ old('surname') }}">
                                    <div class="text-danger small js-field-error" data-field="surname"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label">@lang('site.phone')</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+994XX XXX XX XX">
                                    <div class="text-danger small js-field-error" data-field="phone"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <label class="form-label">@lang('site.email')</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    <div class="text-danger small js-field-error" data-field="email"></div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">@lang('site.note')</label>
                                    <textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                                    <div class="text-danger small js-field-error" data-field="message"></div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-main px-5" type="submit">@lang('site.send')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5">
                    <div class="card border">
                        <div class="card-body">
                            <div class="contact-info">
                                <h4>{{ $contactTitle }}</h4>
                                <p>@lang('site.contact_full_text')</p>

                                @if($address)
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <div class="icons">
                                            <div class="square--50 rounded-3 bg-light-main"><i class="bi bi-pin-map-fill text-main"></i></div>
                                        </div>
                                        <div class="caps-content">
                                            <h5 class="cn-info-title mb-0">@lang('site.address')</h5>
                                            <p class="text-muted lh-base">{!! nl2br(e($address)) !!}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($email)
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <div class="icons">
                                            <div class="square--50 rounded-3 bg-light-main"><i class="bi bi-envelope-open text-main"></i></div>
                                        </div>
                                        <div class="caps-content">
                                            <h5 class="cn-info-title mb-0">@lang('site.email')</h5>
                                            <p class="text-muted lh-base"><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                                        </div>
                                    </div>
                                @endif

                                @if($phone)
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="icons">
                                            <div class="square--50 rounded-3 bg-light-main"><i class="bi bi-telephone text-main"></i></div>
                                        </div>
                                        <div class="caps-content">
                                            <h5 class="cn-info-title mb-0">@lang('site.phone')</h5>
                                            <p class="text-muted lh-base"><a href="tel:{{ preg_replace('/[^+0-9]/', '', $phone) }}">{{ $phone }}</a></p>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
            const $form = $('#contactForm');
            const $alert = $('#contact-form-alert');

            function resetMessages() {
                $alert.addClass('d-none').removeClass('alert-success alert-danger').text('');
                $form.find('.js-field-error').text('');
            }

            function showAlert(type, message) {
                $alert.removeClass('d-none alert-success alert-danger')
                    .addClass(type === 'success' ? 'alert-success' : 'alert-danger')
                    .text(message);
            }

            function setFieldErrors(errors) {
                if (!errors) return;
                Object.keys(errors).forEach(function (field) {
                    const message = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                    $form.find('.js-field-error[data-field="' + field + '"]').text(message || '');
                });
            }

            $form.on('submit', function (event) {
                event.preventDefault();
                resetMessages();

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function (response) {
                        if (response && response.success) {
                            showAlert('success', response.message || @json(__('site.study_abroad_request_success')));
                            $form[0].reset();
                        } else {
                            showAlert('danger', response.message || 'Xəta baş verdi.');
                        }
                    },
                    error: function (xhr) {
                        const response = xhr.responseJSON || {};
                        if (xhr.status === 422) {
                            showAlert('danger', response.message || 'Form xətası.');
                            setFieldErrors(response.errors || {});
                            return;
                        }

                        showAlert('danger', response.message || 'Xəta baş verdi.');
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
