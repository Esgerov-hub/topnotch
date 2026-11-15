@php
    $pageTitle = __('site.faq');
@endphp

@extends('site.layouts.app')

@section('site.title')
    {{ $pageTitle }}
@endsection

@section('site.meta_description')
    {{ __('site.faq') }}
@endsection

@section('site.meta_keywords')
    {{ implode(', ', array_filter([$pageTitle, __('site.faq'), __('site.contact_us')])) }}
@endsection

@section('site.css')
@endsection

@section('site.content')
    <section class="bg-gredient page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pageTitle-wrap text-center">
                        <h1 class="text-light">{{ $pageTitle }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if($faqs->count())
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $faq)
                        @php
                            $question = data_get($faq, "question.$currentLang") ?? data_get($faq, 'question.az');
                            $answer = data_get($faq, "answer.$currentLang") ?? data_get($faq, 'answer.az');
                        @endphp
                        <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqHeading{{ $faq->id }}">
                                <button class="accordion-button @if(!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $faq->id }}" aria-expanded="@if($loop->first) true @else false @endif" aria-controls="faqCollapse{{ $faq->id }}">
                                    {{ $question }}
                                </button>
                            </h2>
                            <div id="faqCollapse{{ $faq->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="faqHeading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! $answer !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-light border mb-0">
                    <a class="alert-link" href="{{ route('site.contact') }}">@lang('site.faq_empty')</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('site.js')
@endsection
