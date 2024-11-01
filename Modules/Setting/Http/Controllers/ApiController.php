<?php

namespace Modules\Setting\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Program;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function homepage()
    {
        // Landing page array.
        $data['landing_page_video'] = url(uploads_files('landing_page_intro', null, true) . '/' . setting('landing_page_intro_video'));
        $data['contact_type_heading_ar'] = setting('landing_page_contact_heading_ar');
        $data['contact_type_heading_en'] = setting('landing_page_contact_heading_en');
        $data['contact_image_url'] = setting('landing_page_contact_image_url');
        $data['contact_type'] = setting('landing_page_contact_type');
        $data['contact_image'] = url(uploads_files('landing_page', null,true) . '/' . setting('landing_page_contact_image'));
        $data['contact_description_en'] = setting('landing_page_contact_description_en');
        $data['contact_description_ar'] = setting('landing_page_contact_description_ar');
        $data['programs'] = setting('landing_page_program') ? Program::whereIn('id', setting('landing_page_program'))->get() : [];

        return response()->json(['data' => $data]);
    }

    public function special_courses()
    {
        $data['special_courses'] = setting('landing_page_special_courses') ? Course::with('courseFees')->withCount('chapters')->whereIn('id', setting('landing_page_special_courses'))->get() : [];
        return response()->json(['data' => $data]);
    }

    public function footer()
    {
        // Footer array.
        $data['footer_contact_email'] = setting('footer_contact_email');
        $data['footer_contact_phone_no'] = setting('footer_contact_phone_no');
        $data['footer_facebook_url'] = setting('footer_facebook_url');
        $data['footer_twitter_url'] = setting('footer_twitter_url');
        $data['footer_pinterest_url'] = setting('footer_pinterest_url');
        $data['footer_intagram_url'] = setting('footer_intagram_url');
        $data['footer_google_plus_url'] = setting('footer_google_plus_url');
        $data['footer_linkedin_url'] = setting('footer_linkedin_url');
        $data['site_logo'] = url(uploads_files('site', null, true) . '/' . setting('site_logo'));

        return response()->json(['data' => $data]);
    }

    public function about_us()
    {
        $data['about_en'] = unserialize(DB::table('settings')->where('key', 'footer_about_en')->pluck('plain_value')->first());
        $data['about_ar'] = unserialize(DB::table('settings')->where('key', 'footer_about_ar')->pluck('plain_value')->first());
        $data['about_us_image']=url(uploads_files('site', null, true) . '/' . setting('about_us_image'));
        return response()->json(['data' => $data]);
    }

    public function success_story_guidelines()
    {
        $data['success_story_description_en'] = setting('success_story_description_en');
        $data['success_story_description_ar'] = setting('success_story_description_ar');
        $data['success_story_video_en']=url(uploads_files('site', null, true) . '/' . setting('success_story_video_en'));
        $data['success_story_video_ar']=url(uploads_files('site', null, true) . '/' . setting('success_story_video_ar'));
        return response()->json(['data' => $data]);
    }

    public function newsletter(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        $input = $request->only(
            'email',
        );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        return response()->json(['success' => true, 'message' => 'Added to Newsletter Successfully.']);
    }

    public function paypal_rate()
    {
        $usdAmount = Cache::remember('usd_rate', 60*60*4, function () {
            // Make the API request
            $client = new Client();
            $response = $client->request('GET', "https://openexchangerates.org/api/latest.json",
                [
                    'query' => [
                        'app_id' => '57633f90cdee4773b18d3c5e76dde0b1',
                    ]
                ]
            );

            // Parse the response
            $data = json_decode($response->getBody(), true);

            // Get the KWD rate
            $kwdRate = $data['rates']['KWD'];

            // Convert KWD to USD
            return 1 / $kwdRate;
        });

        return response()->json(['success' => true,'data' => ['paypal_rate' => $usdAmount]]);

        $data['paypal_rate'] = setting('paypal_rate');
        return response()->json(['success' => true,'data' => $data]);
    }
}
