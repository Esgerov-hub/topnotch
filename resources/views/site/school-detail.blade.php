@extends('site.layouts.app')

@php
    $schoolTitle = data_get($school, "name.$currentLang") ?? data_get($school, 'name.az') ?? __('site.schools');
    $schoolText = data_get($school, "text.$currentLang") ?? data_get($school, 'text.az');
    $schoolFullText = data_get($school, "full_text.$currentLang") ?? data_get($school, 'full_text.az');
    $countryName = data_get($school, "country.name.$currentLang") ?? data_get($school, 'country.name.az');
    $categoryTitle = data_get($school, "category.title.$currentLang") ?? data_get($school, 'category.title.az');
    $teacherName = data_get($school, "teacher.name.$currentLang") ?? data_get($school, 'teacher.name.az');
    $languageName = data_get($school, "language.name.$currentLang") ?? data_get($school, 'language.name.az');
    $levelName = data_get($school, "parentLanguage.name.$currentLang") ?? data_get($school, 'parentLanguage.name.az');
@endphp

@section('site.title')
    {{ $schoolTitle }}
@endsection

@section('site.meta_description')
    {{ $schoolText ? \Illuminate\Support\Str::limit(strip_tags($schoolText), 160) : $schoolTitle }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$schoolTitle, $countryName, $categoryTitle, $languageName, $levelName])) }}
@endsection

@section('site.css')
@endsection

@section('site.content')
    <div class="ed_detail_head">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5">
                    <div class="courses-video">
                        <div class="thumb">
                            <img class="pro_img img-fluid w100" src="{{ !empty($school->image) ? asset('uploads/schools/'.$school->image) : asset('site/assets/img/co-5.jpg') }}" alt="{{ $schoolTitle }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7">
                    <div class="ed_detail_wrap">
                        <div class="course-type d-flex align-items-center gap-2 mb-1 flex-wrap">
                            @if($countryName)
                                <span class="badge bg-light-green text-green rounded-pill">{{ $countryName }}</span>
                            @endif
                            @if($categoryTitle)
                                <span class="badge bg-light-red text-red rounded-pill">{{ $categoryTitle }}</span>
                            @endif
                        </div>
                        <div class="ed_header_caption">
                            <h2 class="ed_title">{{ $schoolTitle }}</h2>
                            <ul>
                                @if($teacherName)
                                    <li><i class="bi bi-people"></i>{{ $teacherName }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="ed_header_short">
                            @if($schoolText)
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($schoolText), 220) }}</p>
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
                        <h4 class="edu_title">@lang('site.school_details_overview')</h4>
                        {!! $schoolFullText ?: nl2br(e($schoolText ?? '')) !!}

                        <div class="who-enrolled-block mt-4">
                            <h5 class="edu_title mb-2">@lang('site.school_details_features')</h5>
                            <ul class="features-list">
                                @if($languageName)
                                    <li><i class="bi bi-check-circle"></i>{{ $languageName }}</li>
                                @endif
                                @if($levelName)
                                    <li><i class="bi bi-check-circle"></i>{{ $levelName }}</li>
                                @endif
                                @if($countryName)
                                    <li><i class="bi bi-check-circle"></i>{{ $countryName }}</li>
                                @endif
                                @if($categoryTitle)
                                    <li><i class="bi bi-check-circle"></i>{{ $categoryTitle }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 pe-xl-5">
                    <div class="edu_wraper">
                        <h4 class="edu_title">@lang('site.school_details_info')</h4>
                        <ul class="edu_list right">
                            @if($teacherName)
                                <li><span class="info-title"><i class="bi bi-people"></i>@lang('site.teacher')</span><span class="text-dark right">{{ $teacherName }}</span></li>
                            @endif
                            @if($countryName)
                                <li><span class="info-title"><i class="bi bi-flag"></i>@lang('site.country')</span><span class="text-dark right">{{ $countryName }}</span></li>
                            @endif
                            @if($languageName)
                                <li><span class="info-title"><i class="bi bi-translate"></i>@lang('site.language')</span><span class="text-dark right">{{ $languageName }}</span></li>
                            @endif
                            @if($levelName)
                                <li><span class="info-title"><i class="bi bi-tags"></i>@lang('site.leve')</span><span class="text-dark right">{{ $levelName }}</span></li>
                            @endif
                        </ul>
                    </div>

                    <div class="edu_wraper mt-4">
                        <h4 class="edu_title">@lang('site.school_details_form_title')</h4>
                        <p class="text-muted mb-4">@lang('site.school_details_form_text')</p>

                        <div id="school-detail-form-alert" class="alert d-none mb-4"></div>

                        <form action="{{ route('site.sendContact') }}" method="POST" class="row g-3" id="schoolDetailContactForm">
                            @csrf
                            <input type="hidden" name="school_name" value="{{ $schoolTitle }}">

                            <div class="col-12">
                                <label class="form-label">@lang('site.name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('site.name')">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="name"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">@lang('validation.attributes.surname')</label>
                                <input type="text" name="surname" value="{{ old('surname') }}" class="form-control" placeholder="@lang('validation.attributes.surname')">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="surname"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">@lang('site.phone')</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+994XX XXX XX XX">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="phone"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">@lang('site.email')</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('site.email')">
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="email"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">@lang('site.note')</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="@lang('site.school_details_message_placeholder')">{{ old('message') }}</textarea>
                                <div class="invalid-feedback d-block small text-danger js-field-error" data-field="message"></div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">@lang('site.send')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if($relatedSchools->count())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="sec-heading">
                            <h2>@lang('site.school_details_related')</h2>
                        </div>
                    </div>
                    @foreach($relatedSchools as $related)
                        @php
                            $relatedTitle = data_get($related, "name.$currentLang") ?? data_get($related, 'name.az');
                            $relatedCountry = data_get($related, "country.name.$currentLang") ?? data_get($related, 'country.name.az');
                            $relatedCategory = data_get($related, "category.title.$currentLang") ?? data_get($related, 'category.title.az');
                            $relatedCategorySlug = data_get($related, "category.slug.$currentLang") ?? data_get($related, 'category.slug.az');
                            $relatedCountrySlug = data_get($related, "country.slug.$currentLang") ?? data_get($related, 'country.slug.az');
                            $relatedSlug = data_get($related, "slug.$currentLang") ?? data_get($related, 'slug.az');
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="education_block_grid border h-100">
                                <div class="education-thumb position-relative">
                                    <a href="{{ route('site.schools-details', [$relatedCategorySlug, $relatedCountrySlug, $relatedSlug]) }}">
                                        <img src="{{ !empty($related->image) ? asset('uploads/schools/'.$related->image) : asset('site/assets/img/co-1.jpg') }}" class="img-fluid w-100" alt="{{ $relatedTitle }}" style="aspect-ratio: 16 / 10; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="education-body p-3">
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @if($relatedCountry)
                                            <span class="badge bg-light text-dark rounded-pill">{{ $relatedCountry }}</span>
                                        @endif
                                        @if($relatedCategory)
                                            <span class="badge bg-light text-dark rounded-pill">{{ $relatedCategory }}</span>
                                        @endif
                                    </div>
                                    <div class="education-title">
                                        <h4 class="fs-6 fw-medium mb-0">
                                            <a href="{{ route('site.schools-details', [$relatedCategorySlug, $relatedCountrySlug, $relatedSlug]) }}">{{ $relatedTitle }}</a>
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
    <script>
        (function ($) {
            const $form = $('#schoolDetailContactForm');
            const $alert = $('#school-detail-form-alert');

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
                const schoolName = $form.find('input[name="school_name"]').val() || '';
                const userMessage = $form.find('textarea[name="message"]').val() || '';
                formData.set('message', [schoolName, userMessage].filter(Boolean).join('\n\n'));

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response && response.success) {
                            showAlert('success', response.message || @json(__('site.school_details_success')));
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
