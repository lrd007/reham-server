<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Program;
use Modules\Subscriber\Entities\Subscriber;

class SettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        $courses = Course::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('setting::index', compact('programs', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            unset($data['_token']);
            
            if(isset($data['landing_page_intro_video'])) {
                $ladingIntroPath = uploads_files('landing_page_intro');
                $data['landing_page_intro_video'] = uploadFile($request, 'landing_page_intro_', 'plain_value', 'landing_page_intro_video', $ladingIntroPath);
            }

            if(isset($data['subscriber_page_header_video'])) {
                $subscriberPagePath = uploads_files('subscriber_page_header');
                $data['subscriber_page_header_video'] = uploadFile($request, 'landing_page_intro_', 'plain_value', 'subscriber_page_header_video', $subscriberPagePath);
            }

            if(isset($data['success_story_video_ar'])) {
                $path = uploads_files('site');
                $data['success_story_video_ar'] = uploadFile($request, 'success_story_video_ar_', 'plain_value', 'success_story_video_ar', $path);
            }

            if(isset($data['success_story_video_en'])) {
                $path = uploads_files('site');
                $data['success_story_video_en'] = uploadFile($request, 'success_story_video_en_', 'plain_value', 'success_story_video_en', $path);
            }

            if(isset($data['site_logo'])) {
                $path = uploads_files('site');
                $data['site_logo'] = uploadFile($request, 'site_logo_', 'plain_value', 'site_logo', $path);
            }

            if(isset($data['about_us_image'])) {
                $path = uploads_files('site');
                $data['about_us_image'] = uploadFile($request, 'about_us_image_', 'plain_value', 'about_us_image', $path);
            }
            
            if(isset($data['landing_page_contact_type'])) {
                $ladingPath = uploads_files('landing_page');
                if($data['landing_page_contact_type'] == 'video') {
                    $data['landing_page_contact_video'] = uploadFile($request, 'landing_page_contact_', 'plain_value', 'landing_page_contact_video', $ladingPath);
                } else if($data['landing_page_contact_type'] == 'image') {
                    $data['landing_page_contact_image'] = uploadFile($request, 'landing_page_contact_', 'plain_value', 'landing_page_contact_image', $ladingPath);
                }
            }

            if(isset($data['subscriber_page_event_type'])) {
                $subscriberPath = uploads_files('subscriber_page');
                if($data['subscriber_page_event_type'] == 'video') {
                    $data['subscriber_page_event_video'] = uploadFile($request, 'subscriber_page_event_', 'plain_value', 'subscriber_page_event_video', $subscriberPath);
                } else if($data['subscriber_page_event_type'] == 'image') {
                    $data['subscriber_page_event_image'] = uploadFile($request, 'subscriber_page_event_', 'plain_value', 'subscriber_page_event_image', $subscriberPath);
                }
            }

            setting($data);
            return $this->success();
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function landingPreview()
    {
        $programs = setting('landing_page_program') ? Program::whereIn('id', setting('landing_page_program'))->get() : [];
        $courses = Course::orderBy('id', 'desc')->limit(9)->get();
        return view('setting::landing-preview', compact('programs', 'courses'));
    }

    public function subscriberPagePreview()
    {
        $programs = setting('subscriber_page_program') ? Program::whereIn('id', setting('subscriber_page_program'))->get() : [];
        $courses = setting('subscriber_page_courses') ? Course::whereIn('id', setting('subscriber_page_courses'))->get() : [];
        return view('setting::subscriber-page-preview', compact('programs', 'courses'));
    }

    public function suggestedCoursePreview()
    {
        $subscriber = Subscriber::take(1)->get()->first();
        $allTagIds = [];
        $coursIds = [];
        foreach($subscriber->subscribePrograms as $key => $program) {
            $tagIds = $program->course->tags()->where('progress', '<=', $program->complete)->pluck('id')->toArray();
            $coursIds[] = $program->course_id;
            $allTagIds = array_unique(array_merge($allTagIds, $tagIds));
        }

        $courses = !empty($allTagIds) ? Course::whereNotIn('id', $coursIds)->whereHas('tags', function($query) use($allTagIds) {
                        $query->whereIn('id', $allTagIds);
                    })->get() : [];

        return view('setting::suggested-course-preview', compact('courses'));
    }
}
