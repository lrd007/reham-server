<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Course\Entities\Course;
use Modules\Event\Entities\Event;
use Modules\FAQ\Entities\Faq;
use Illuminate\Support\Facades\Notification;
use Modules\NotificationCenter\Notifications\TechnicalSupport;
use Modules\Program\Entities\Program;


class HomeController extends Controller
{
    public function home()
    {
        $programs = Program::all();
        $landing_page_video = url(uploads_files('landing_page_intro', null, true) . '/' . setting('landing_page_intro_video'));
        $bonus_materials = BonusMaterial::all();
        // $special_offers=
        $title = __('words.Homepage');
        return view('website.homepage.index', compact('title','programs', 'landing_page_video','bonus_materials'));
    }

    public  function  calendar(){
        $title = __('words.Calendar');
        $events = Event::orderBy('id','desc' )->get();
        return view('website.calendar',compact('events','title'));

    }

    public function about()
    {
        $description_en = setting('footer_about_en');
        $description_ar = setting('footer_about_ar');
        $title = __('words.About');
        $image = url(uploads_files('site', null, true) . '/' . setting('about_us_image'));
        return view('frontend.about', compact('title','description_en', 'description_ar', 'image'));
    }

    public function faq()
    {
        $faqs = Faq::where('type', 0)->get();
        $title = __('words.FAQs');
        return view('website.faq', compact('faqs','title'));
    }

    public function legal_faq()
    {
        $legal_faqs = Faq::where('type', 1)->get();
        $title= __('words.Legal');
        return view('website.legal', compact('title','legal_faqs'));
    }

    public function technical_support()
    {
        $title = 'الدعم الفني ';
        return view('website.technical_support', compact('title'));
    }

    public function technical_support_post(Request $request)
    {
        $user = Auth::user();
        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $data['user_name'] = $user->name;
        $data['user_email'] = $user->email;
        Notification::route('mail', 'fenixthelord@gmail.com')->notify(new TechnicalSupport($data));

        // return response()->json(['success' => true, 'message' => 'Email Sent Successfully to System Admin']);
        return view('website.technical_support');
    }

    public function all_programs(){
        $user = auth()->user();
        $courses =[];
        $title = __('words.My Programs');
        // Admin User.
        if($user->isAdmin())
        {
            $courses = Course::withCount('chapters')->with(['getStartedFiles', 'bonusMaterials.materials', 'chapters.lessons' => function ($query) {
                $query->orderBy('id', 'ASC');
            }])->get();
            $my_programs = $courses;
        }
        else{
            $courses = $user->subscriber->subscribePrograms()->with(['course', 'course.getStartedFiles', 'course.bonusMaterials.materials', 'course.chapters.lessons' => function ($query) {
                $query->orderBy('id', 'ASC');
            }])->get();
            $my_programs = collect();
            foreach ($courses as $course) {
                $my_programs->push($course->course);
            }

        }
        return view('website.program.all_programs', compact('user','title','my_programs'));

    }
}
