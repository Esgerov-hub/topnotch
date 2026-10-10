<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Sitemap\SitemapGenerator;

try {
    Route::get('/generate-sitemap', function () {
        SitemapGenerator::create('https://topnotch.az/az/')
            ->writeToFile(public_path('sitemap.xml'));

        return 'Sitemap yaradıldı!';
    });

    Route::group([
    'prefix' => implode('/', [LaravelLocalization::setLocale(), '']),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function() {
        Route::get('/', 'HomeController@index')->name('index');
        Route::get('/about', 'HomeController@about')->name('about');
        Route::get('/faqs', 'HomeController@faqs')->name('faqs');
        Route::get('/conditions', 'HomeController@conditions')->name('conditions');
        Route::get('/rules', 'HomeController@rules')->name('rules');
        Route::get('/study-abroad', 'HomeController@studyAbroad')->name('study-abroad');
        Route::get('/study-abroad-degree/{degreeSlug?}', 'HomeController@degreeStudyAbroad')->name('degree-study-abroad');
        Route::get('/study-abroad/{countrySlug?}/{universitySlug?}/{studySlug?}', 'HomeController@studyAbroadDetails')->name('study-abroad-details');
        Route::get('/schools', 'HomeController@schools')->name('schools');
        Route::get('/schools-details/{categorySlug?}/{countrySlug?}/{schoolSlug?}', 'HomeController@schoolDetails')->name('schools-details');
        Route::get('/courses', 'HomeController@courses')->name('courses');
        Route::get('/courses-details/{courseSlug?}/{courseId?}', 'HomeController@coursesDetails')->name('courses-details');
        Route::get('/blogs', 'HomeController@blogs')->name('blogs');
        Route::get('/blog-detail/{categorySlug?}/{newsSlug?}', 'HomeController@blogDetail')->name('blogDetail');
        Route::get('/contact', 'HomeController@contact')->name('contact');
        Route::get('/404', 'HomeController@notPage')->name('404');
        Route::get('/signup', 'HomeController@signup')->name('signup');
        Route::post('/send-contact', 'AjaxController@sendContact')->name('sendContact');
        Route::post('/send-study-abroad-contact', 'AjaxController@sendStudyAbroadContact')->name('sendStudyAbroadContact');
    });
    Route::fallback(function () {
        abort(404);
    });
}catch (\Exception $exception){
    return response($exception->getMessage(), 500);
}
