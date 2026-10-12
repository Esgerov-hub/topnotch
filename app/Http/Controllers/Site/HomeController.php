<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\Category;
use App\Models\Commit;
use App\Models\Country;
use App\Models\EducationalDegree;
use App\Models\Faq;
use App\Models\Language;
use App\Models\LanguageCourse;
use App\Models\News;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\CourseCategory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\StudyAbroad;
use App\Models\Teacher;
use App\Models\University;
use App\Models\Translation;
use App\Models\UsefulLink;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $currentLang;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->currentLang = LaravelLocalization::getCurrentLocale();
            $locales = Translation::where('status', 1)->pluck('code')->toArray();
            if (!in_array($this->currentLang, $locales)) {
                return $this->notFound();
            }

            if ($request->path() === '/') {
                return redirect('/az');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $currentLang = $this->currentLang;
        $setting = Setting::first();
        $aboutPage = AboutPage::where('status', 1)->first();
        $sliders = Slider::where('status', 1)->orderBy('order_by', 'asc')->orderByDesc('id')->take(5)->get();
        $faqs = Faq::orderByDesc('id')->take(3)->get();

        $news = News::with('category')->where('status', 1)->where('is_main', 1)->orderByDesc('datetime')->take(8)->get();
        $teachers = Teacher::with('position')->where('status', 1)->where('is_main', 1)->orderBy('order_by', 'asc')->orderByDesc('id')->take(8)->get();
        $commits = Commit::orderByDesc('id')->take(6)->get();
        $universities = University::whereNotNull('image')->where('status', 1)->where('is_main', 1)->orderBy('order_by', 'asc')->orderByDesc('id')->take(10)->get();
        $featuredCourses = LanguageCourse::with(['courseCategory', 'language', 'parentLanguage', 'teacher'])
            ->where('status', 1)
            ->where('is_main', 1)
            ->orderByDesc('id')
            ->take(10)
            ->get();
        $mainSchools = School::with(['category', 'country'])
            ->where('status', 1)
            ->where('is_main', 1)
            ->orderByDesc('id')
            ->take(8)
            ->get();
        $counts = [
            'courses' => LanguageCourse::where('status', 1)->count(),
            'teachers' => Teacher::where('status', 1)->count(),
            'schools' => School::where('status', 1)->count(),
            'news' => News::where('status', 1)->count(),
        ];

        return view('site.home', compact(
            'currentLang',
            'setting',
            'aboutPage',
            'sliders',
            'faqs',
            'news',
            'teachers',
            'commits',
            'universities',
            'featuredCourses',
            'mainSchools',
            'counts'
        ));
    }

    public function studyAbroad(Request $request)
    {
        $currentLang = $this->currentLang;
        $search = trim((string) $request->get('q'));
        $countrySlug = $request->get('country');
        $universitySlug = $request->get('university');
        $degreeSlug = $request->get('degree');

        $studyAbroadsQuery = StudyAbroad::with(['country', 'university', 'degree'])
            ->where('status', 1);

        if ($search !== '') {
            $studyAbroadsQuery->where(function ($query) use ($currentLang, $search) {
                $query->where("name->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("text->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("full_text->{$currentLang}", 'like', '%' . $search . '%');
            });
        }

        if ($countrySlug) {
            $studyAbroadsQuery->whereHas('country', function ($query) use ($currentLang, $countrySlug) {
                $query->where("slug->{$currentLang}", $countrySlug);
            });
        }

        if ($universitySlug) {
            $studyAbroadsQuery->whereHas('university', function ($query) use ($currentLang, $universitySlug) {
                $query->where("slug->{$currentLang}", $universitySlug);
            });
        }

        if ($degreeSlug) {
            $studyAbroadsQuery->whereHas('degree', function ($query) use ($currentLang, $degreeSlug) {
                $query->where("slug->{$currentLang}", $degreeSlug);
            });
        }

        $studyAbroads = $studyAbroadsQuery->orderByDesc('id')->paginate(12)->withQueryString();

        $countries = Country::where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();
        $universities = University::where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();
        $educationalDegrees = EducationalDegree::where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();

        return view('site.study-abroad', compact(
            'currentLang',
            'studyAbroads',
            'countries',
            'universities',
            'educationalDegrees',
            'search',
            'countrySlug',
            'universitySlug',
            'degreeSlug'
        ));
    }

    public function degreeStudyAbroad($degreeSlug = null, Request $request)
    {
        if ($degreeSlug) {
            $request->merge(['degree' => $degreeSlug]);
        }

        return $this->studyAbroad($request);
    }

    public function studyAbroadDetails($countrySlug = null, $universitySlug = null, $studySlug = null)
    {
        $currentLang = $this->currentLang;

        $studyAbroadQuery = StudyAbroad::with(['country', 'university', 'degree'])
            ->where('status', 1);

        if ($studySlug) {
            $studyAbroadQuery->where("slug->{$currentLang}", $studySlug);
        }

        if ($countrySlug) {
            $studyAbroadQuery->whereHas('country', function ($query) use ($currentLang, $countrySlug) {
                $query->where("slug->{$currentLang}", $countrySlug);
            });
        }

        if ($universitySlug) {
            $studyAbroadQuery->whereHas('university', function ($query) use ($currentLang, $universitySlug) {
                $query->where("slug->{$currentLang}", $universitySlug);
            });
        }

        $studyAbroad = $studyAbroadQuery->orderByDesc('id')->first();

        if (!$studyAbroad) {
            return $this->notFound();
        }

        $relatedStudyAbroads = StudyAbroad::with(['country', 'university', 'degree'])
            ->where('status', 1)
            ->where('id', '!=', $studyAbroad->id)
            ->where('country_id', $studyAbroad->country_id)
            ->orderByDesc('id')
            ->take(6)
            ->get();

        return view('site.study-abroad-details', compact('currentLang', 'studyAbroad', 'relatedStudyAbroads'));
    }

    public function courses(Request $request)
    {
        $currentLang = $this->currentLang;
        $search = trim((string) $request->get('q'));
        $categoryId = $request->get('category');
        $languageId = $request->get('language');
        $levelId = $request->get('level');


        $courseQuery = LanguageCourse::with(['courseCategory', 'language', 'parentLanguage', 'teacher'])
            ->where('status', 1);

        if ($search !== '') {
            $courseQuery->where(function ($query) use ($currentLang, $search) {
                $query->where("name->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("text->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("full_text->{$currentLang}", 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $courseQuery->where('course_category_id', $categoryId);
        }

        if ($languageId) {
            $courseQuery->where('language_id', $languageId);
        }

        if ($levelId) {
            if (ctype_digit((string) $levelId)) {
                // Keep existing numeric level filter URLs working.
                $courseQuery->where('parent_language_id', $levelId);
            } else {
                $courseQuery->whereHas('parentLanguage', function ($query) use ($currentLang, $levelId) {
                    $query->where("name->{$currentLang}", $levelId);
                });
            }
        }

        $courses = $courseQuery->orderByDesc('id')->paginate(12)->withQueryString();
        $courseCategories = CourseCategory::where('status', 1)->orderBy('order_by', 'asc')->orderByDesc('id')->get();
        $mainLanguages = Language::whereNull('parent_id')->where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();
        $levels = Language::whereNotNull('parent_id')->where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();
        $teachers = Teacher::where('status', 1)->get();

        return view('site.courses', compact('currentLang', 'courses', 'courseCategories', 'mainLanguages', 'levels', 'teachers', 'search', 'categoryId', 'languageId', 'levelId'));
    }


    public function coursesDetails($courseSlug = null, $courseId = null)
    {
        $currentLang = $this->currentLang;
        $courseQuery = LanguageCourse::with(['courseCategory', 'language', 'parentLanguage', 'teacher'])
            ->where('status', 1);

        if ($courseId && ctype_digit((string) $courseId)) {
            $courseQuery->whereKey((int) $courseId);
        } elseif ($courseSlug && ctype_digit((string) $courseSlug)) {
            // Keep previous numeric detail URLs working.
            $courseQuery->whereKey((int) $courseSlug);
        } elseif ($courseSlug) {
            // Keep legacy slug-only URLs working.
            $courseQuery->where("slug->{$currentLang}", $courseSlug);
        }

        $course = $courseQuery->first();
        if (!$course) {
            return $this->notFound();
        }

        $relatedCoursesQuery = LanguageCourse::with(['courseCategory', 'language', 'parentLanguage', 'teacher'])
            ->where('status', 1)
            ->where('id', '!=', $course->id)
            ->orderByDesc('id');

        if (!empty($course->course_category_id)) {
            $relatedCoursesQuery->where('course_category_id', $course->course_category_id);
        } elseif (!empty($course->language_id)) {
            $relatedCoursesQuery->where('language_id', $course->language_id);
        }

        $relatedCourses = $relatedCoursesQuery->take(6)->get();

        return view('site.courses-details', compact('currentLang', 'course', 'relatedCourses'));
    }

    public function signup()
    {
        return view('site.signup');
    }

    public function blogs(Request $request)
    {
        $currentLang = $this->currentLang;
        $search = trim((string) $request->get('q'));
        $categoryId = $request->get('category');

        $newsQuery = News::with('category')->where('status', 1);

        if ($search !== '') {
            $newsQuery->where(function ($query) use ($currentLang, $search) {
                $query->where("title->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("text->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("fulltext->{$currentLang}", 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $newsQuery->where('category_id', $categoryId);
        }

        $news = $newsQuery->orderByDesc('datetime')->paginate(12)->withQueryString();
        $categories = Category::where('status', 1)->orderByDesc('id')->get();

        return view('site.blogs', compact('currentLang', 'news', 'categories', 'search', 'categoryId'));
    }

    public function blogDetail($categorySlug = null, $newsSlug = null)
    {
        $currentLang = $this->currentLang;
        $newsQuery = News::with('category')->where('status', 1);

        if ($newsSlug) {
            $newsQuery->where("slug->{$currentLang}", $newsSlug);
        }

        if ($categorySlug) {
            $newsQuery->whereHas('category', function ($query) use ($currentLang, $categorySlug) {
                $query->where("slug->{$currentLang}", $categorySlug);
            });
        }

        $news = $newsQuery->first();
        if (!$news) {
            return $this->notFound();
        }

        $relatedNews = News::with('category')
            ->where('status', 1)
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->orderByDesc('datetime')
            ->take(6)
            ->get();

        return view('site.blog-detail', compact('currentLang', 'news', 'relatedNews'));
    }

    public function schools(Request $request)
    {
        $currentLang = $this->currentLang;
        $search = trim((string) $request->get('q'));
        $categoryId = $request->get('category');
        $countryId = $request->get('country');
        $languageId = $request->get('language');
        $levelId = $request->get('level');

        $schoolQuery = School::with(['category', 'language', 'parentLanguage', 'teacher', 'country'])
            ->where('status', 1);

        if ($search !== '') {
            $schoolQuery->where(function ($query) use ($currentLang, $search) {
                $query->where("name->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("text->{$currentLang}", 'like', '%' . $search . '%')
                    ->orWhere("full_text->{$currentLang}", 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $schoolQuery->where('category_id', $categoryId);
        }

        if ($countryId) {
            $schoolQuery->where('country_id', $countryId);
        }

        if ($languageId) {
            $schoolQuery->where('language_id', $languageId);
        }

        if ($levelId) {
            $schoolQuery->where('parent_language_id', $levelId);
        }

        $schools = $schoolQuery->orderByDesc('id')->paginate(12)->withQueryString();

        $schoolCategories = SchoolCategory::where('status', 1)->orderBy('order_by', 'asc')->get();
        $countries = Country::where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();
        $mainLanguages = Language::whereNull('parent_id')->where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();
        $levels = Language::whereNotNull('parent_id')->where('status', 1)->orderBy("name->{$currentLang}", 'asc')->get();

        return view('site.schools', compact(
            'currentLang',
            'schoolCategories',
            'countries',
            'mainLanguages',
            'levels',
            'schools',
            'search',
            'categoryId',
            'countryId',
            'languageId',
            'levelId'
        ));
    }

    public function schoolDetails($categorySlug = null, $countrySlug = null, $schoolSlug = null)
    {
        $currentLang = $this->currentLang;

        $schoolQuery = School::with(['category', 'language', 'parentLanguage', 'teacher', 'country'])
            ->where('status', 1);

        if ($schoolSlug) {
            $schoolQuery->where("slug->{$currentLang}", $schoolSlug);
        }

        if ($categorySlug) {
            $schoolQuery->whereHas('category', function ($query) use ($currentLang, $categorySlug) {
                $query->where("slug->{$currentLang}", $categorySlug);
            });
        }

        if ($countrySlug) {
            $schoolQuery->whereHas('country', function ($query) use ($currentLang, $countrySlug) {
                $query->where("slug->{$currentLang}", $countrySlug);
            });
        }

        $school = $schoolQuery->first();

        if (!$school) {
            return $this->notFound();
        }

        $relatedSchools = School::with(['category', 'country'])
            ->where('status', 1)
            ->where('id', '!=', $school->id)
            ->where('country_id', $school->country_id)
            ->orderByDesc('id')
            ->take(6)
            ->get();

        return view('site.school-detail', compact('currentLang', 'school', 'relatedSchools'));
    }


    public function contact()
    {
        $currentLang = $this->currentLang;
        $setting = Setting::first();
        return view('site.contact', compact('currentLang', 'setting'));
    }

    public function about()
    {
        $currentLang = $this->currentLang;
        $about = AboutPage::where('status', 1)->first();
        $teachers = Teacher::with('position')->where('status', 1)->orderByDesc('id')->get();

        return view('site.about', compact('currentLang', 'about', 'teachers'));
    }

    public function faqs()
    {
        $currentLang = $this->currentLang;
        $faqs = Faq::orderByDesc('id')->get();
        return view('site.faqs', compact('currentLang', 'faqs'));
    }

    public function conditions()
    {
        $currentLang = $this->currentLang;
        return view('site.conditions', compact('currentLang'));
    }

    public function rules()
    {
        $currentLang = $this->currentLang;
        return view('site.rules', compact('currentLang'));
    }

    public function notPage()
    {
        $currentLang = $this->currentLang;
        return view('errors.404', compact('currentLang'));
    }

    public function notFound()
    {
        $currentLang = $this->currentLang;
        return view('site.not_found', compact('currentLang'));
    }
}
