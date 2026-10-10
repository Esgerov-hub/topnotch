@php
    use Illuminate\Support\Str;

    $title = data_get($studyAbroad, "name.$currentLang") ?? data_get($studyAbroad, 'name.az');
    $shortText = data_get($studyAbroad, "text.$currentLang") ?? data_get($studyAbroad, 'text.az');
    $fullText = data_get($studyAbroad, "full_text.$currentLang") ?? data_get($studyAbroad, 'full_text.az');
    $countryName = data_get($studyAbroad, "country.name.$currentLang") ?? data_get($studyAbroad, 'country.name.az');
    $universityName = data_get($studyAbroad, "university.name.$currentLang") ?? data_get($studyAbroad, 'university.name.az');
    $degreeName = data_get($studyAbroad, "degree.name.$currentLang") ?? data_get($studyAbroad, 'degree.name.az');
    $countrySlug = data_get($studyAbroad, "country.slug.$currentLang") ?? data_get($studyAbroad, 'country.slug.az');
    $universitySlug = data_get($studyAbroad, "university.slug.$currentLang") ?? data_get($studyAbroad, 'university.slug.az');
    $studySlug = data_get($studyAbroad, "slug.$currentLang") ?? data_get($studyAbroad, 'slug.az');
@endphp

@extends('site.layouts.app')

@section('site.title')
    {{ $title }}
@endsection

@section('site.meta_description')
    {{ $shortText ? \Illuminate\Support\Str::limit(strip_tags($shortText), 160) : $title }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$title, $countryName, $universityName, $degreeName])) }}
@endsection

@section('site.css')
@endsection

@section('site.content')
    <section class="bg-gredient page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pageTitle-wrap">
                        <h1 class="text-light">{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="ed_detail_head py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-4 col-md-5">
                    <div class="courses-video">
                        <div class="thumb">
                            <img
                                class="pro_img img-fluid w-100 rounded-3"
                                src="{{ !empty($studyAbroad->image) ? asset('uploads/studyAbroads/' . $studyAbroad->image) : asset('site/assets/img/co-5.jpg') }}"
                                alt="{{ $title }}"
                                style="aspect-ratio: 4 / 3; object-fit: contain;"
                            >
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7">
                    <div class="ed_detail_wrap">
                        <div class="course-type d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge bg-light-green text-green rounded-pill">{{ $countryName }}</span>
                            <span class="badge bg-light-red text-red rounded-pill">
                                <i class="bi bi-tags me-1"></i>{{ $degreeName }}
                            </span>
                        </div>

                        <div class="ed_header_caption">
                            <h2 class="ed_title mb-2">{{ $title }}</h2>
                            <ul class="list-inline mb-0 text-muted d-flex flex-wrap gap-3">
                                @if($countryName)
                                    <li class="list-inline-item"><i class="bi bi-geo-alt me-1"></i>{{ $countryName }}</li>
                                @endif
                                @if($universityName)
                                    <li class="list-inline-item"><i class="bi bi-building me-1"></i>{{ $universityName }}</li>
                                @endif
                            </ul>
                        </div>

                        @if($shortText)
                            <div class="ed_header_short mt-3">
                                <p class="mb-0">{{ $shortText }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-8 col-lg-8 col-md-12 pe-xl-4">
                    <div class="edu_wraper">
                        <h4 class="edu_title">@lang('site.about_us')</h4>

                        @if($fullText)
                            <div class="content-body">
                                {!! $fullText !!}
                            </div>
                        @else
                            <p class="mb-0 text-muted">@lang('site.no_data_found')</p>
                        @endif
                    </div>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 pe-xl-5">
                    <div class="edu_wraper">
                        <h4 class="edu_title">@lang('site.study_abroads')</h4>
                        <ul class="edu_list right">
                            @if($countryName)
                                <li>
                                    <span class="info-title"><i class="bi bi-geo-alt"></i>@lang('site.country')</span>
                                    <span class="text-dark right">{{ $countryName }}</span>
                                </li>
                            @endif

                            @if($universityName)
                                <li>
                                    <span class="info-title"><i class="bi bi-building"></i>@lang('site.university')</span>
                                    <span class="text-dark right">{{ $universityName }}</span>
                                </li>
                            @endif

                            @if($degreeName)
                                <li>
                                    <span class="info-title"><i class="bi bi-tags"></i>@lang('site.education_degree')</span>
                                    <span class="text-dark right">{{ $degreeName }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="edu_wraper mt-4">
                        <h4 class="edu_title">@lang('site.study_abroad_form_title')</h4>
                        <p class="text-muted mb-4">@lang('site.study_abroad_form_text')</p>

                        <div id="study-abroad-form-alert" class="alert d-none mb-4"></div>

                        <form action="{{ route('site.sendStudyAbroadContact') }}" method="POST" class="row g-3" id="studyAbroadContactForm">
                            @csrf
                            <input type="hidden" name="study_abroad_id" value="{{ $studyAbroad->id }}">

                            <div class="col-md-6">
                                <label class="form-label">@lang('site.name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('site.name')">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="name"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('validation.attributes.surname')</label>
                                <input type="text" name="surname" value="{{ old('surname') }}" class="form-control" placeholder="@lang('validation.attributes.surname')">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="surname"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('site.phone')</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+994XX XXX XX XX">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="phone"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('site.email')</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('site.email')">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="email"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">@lang('site.note')</label>
                                <textarea name="note" class="form-control" rows="4" placeholder="@lang('site.note')">{{ old('note') }}</textarea>
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="note"></div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">@lang('site.send')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('site.js')
    <script>
        (function ($) {
            const $form = $('#studyAbroadContactForm');
            const $alert = $('#study-abroad-form-alert');

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

                const formData = new FormData(this);

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response && response.success) {
                            showAlert('success', response.message || @json(__('site.study_abroad_request_success')));
                            $form[0].reset();
                        } else {
                            showAlert('danger', response.message || 'Xəta baş verdi.');
                        }
                    },
                    error: function (xhr) {
                        let response = xhr.responseJSON || {};
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
