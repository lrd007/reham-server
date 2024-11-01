<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Chapter\Entities\Chapter;
use Modules\Comment\Entities\Comment;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Entities\LessonCompletion;
use Modules\Program\Entities\Program;

class ProgramController extends Controller
{
    public $percent;
    public function __construct()
    {
        $this->percent = null;
    }

    public function program_details(Program $program)
    {

        $sections = $program->sections;

        // calcluate the total price for all courses.
        $amount = 0;
        foreach ($program->courses as $course) {
            $amount += $course->courseFees()->pluck('sale_fee')->first();
        }
        $title = (app()->getLocale() == 'ar') ? $program->name_ar : $program->name_en;
        //dd($sections,$program->courses,$program);
        return view('website.program.program_details', compact('title','program', 'sections', 'amount'));
    }

    public function show(Request $request, $program_id)
    {
        $program_data = Course::find($program_id);
        $title = (app()->getLocale() == 'ar') ? $program_data->name_ar : $program_data->name_en;

        if(auth()->user()){
            $percent = auth()->user()->subscriber->CourseComplete($program_data->id);
        }else {
            $percent = $this->percent;
        }

        return view('website.program.show-program', compact('title','program_data','percent'));
    }


    public function chapterDetails(Request $request, $program_id, $course_id)
    {
        $user_id = auth()->user()->id;
        $program_data = Course::findOrFail($program_id);
        $course_data = Chapter::findOrFail($course_id);
        $title =  $program_data->name_ar;

        if(auth()->user()){
            $percent = auth()->user()->subscriber->CourseComplete($program_data->id,$course_data->id);
        }else {
            $percent = $this->percent;
        }
        return view('website.program.chapter-details', compact('program_data', 'course_data','title','percent'));
    }


    public function BonusMaterial(Request $request, $program_id, $bonus_id)
    {
        $user_id = auth()->user()->id;
        $program_data = Course::findOrFail($program_id);
        $bonus_data = BonusMaterial::findOrFail($bonus_id);
        $title =  $program_data->name_ar;

        if(auth()->user()){
            $percent = 100;
        }else {
            $percent = $this->percent;
        }
        return view('website.program.bonus-material', compact('program_data', 'bonus_data','title','percent'));
    }

    public function lessonDetails(Request $request, $program_id, $course_id, $chapter_id)
    {
        $user_id = auth()->user()->id;
        $program_data = Course::find($program_id);
        $course_data = Chapter::find($course_id);
        $chapter_data = $lesson_data = Lesson::find($chapter_id);
        $lesson_complete = LessonCompletion::where('subscriber_id', $user_id)->where('lesson_id', $chapter_data->id)->first();
        $title =  (app()->getLocale() == 'ar') ? $lesson_data->name_ar : $lesson_data->name_en;




        $list = $course_data->lessons()->pluck('id')->toArray();
        // get index
        $index = array_search($chapter_data->id,$list);


        $next = ($list[$index] !=  end($list)) ? $list[$index+1] : null;
        $last = ($index > 0) ? $list[$index-1] : null;

        $next_lesson = isset($next) ? route('lesson-details',[$program_id, $course_id,$next]) : null ;
        $previous_lesson = isset($last) ?route('lesson-details',[$program_id, $course_id,$last]) : null ;

        return view('website.program.single-lesson-details',
            compact('program_data', 'course_data', 'chapter_data',
                'lesson_data', 'lesson_complete','title',
            'next_lesson','previous_lesson'
            ));
    }

    public function singleLessonDetails(Request $request,$program_id, $course_id, $chapter_id, $lesson_id)
    {
        // dd($program_id, $course_id, $chapter_id, $lesson_id);/
        $user_id = auth()->user()->id;
        $program_data = Program::find($program_id);
        $course_data = Course::find($course_id);
        $chapter_data = Chapter::find($chapter_id);
        $lesson_data = Lesson::find($lesson_id);
        $lesson_complete = LessonCompletion::where('subscriber_id', $user_id)->where('lesson_id', $lesson_id)->first();

        return view('frontend.single-lesson-deatils', compact('program_data', 'course_data', 'chapter_data', 'lesson_data', 'lesson_complete'));
    }

    public function lessonMarkAsRead(Request $request, $lesson_id)
    {
        $user_id = auth()->user()->subscriber->id;
        $lesson_complete = LessonCompletion::where('subscriber_id', $user_id)->where('lesson_id', $lesson_id)->first();
        if ($lesson_complete == NULL) {
            LessonCompletion::create(["subscriber_id" => $user_id, "lesson_id" => $lesson_id]);
            return response()->json([
                "success" => true,
                "message" => "Complete your lesson."
            ]);
        } else {
            $lesson_complete->delete();
            return response()->json([
                "success" => true,
                "message" => "Remove, Not completed Your lesson."
            ]);
        }
    }

    public function getAdjascentKey( $key, $hash = array(), $increment ) {
        $keys = array_keys( $hash );
        $found_index = array_search( $key, $keys );
        if ( $found_index === false ) {
            return false;
        }
        $newindex = $found_index+$increment;
        // returns false if no result found
        return ($newindex > 0 && $newindex < sizeof($hash)) ? $keys[$newindex] : false;
    }

    public function lessonComment(Request $request,$lesson_id,$comment_id = null){

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = auth()->user()->id;
        if(isset($comment_id)) {
            $comment->parent_id = $comment_id;
        }else{
            $comment->lesson_id = $lesson_id;
        }

        $comment->save();

        return redirect()->back();


    }
    public function BonusComment(Request $request,$lesson_id,$comment_id = null){

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = auth()->user()->id;
        if(isset($comment_id)) {
            $comment->parent_id = $comment_id;
        }else{
            $comment->bonus_material_id = $lesson_id;
        }

        $comment->save();

        return redirect()->back();


    }

    public function like(Request $request,$id)
    {
        $comment = Comment::find($id);
        $comment->like++;
        $comment->save();
        return response()->json(['success' => true, 'message' => 'true','like'=>$comment->like]);
    }


}
