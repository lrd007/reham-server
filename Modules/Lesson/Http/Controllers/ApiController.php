<?php

namespace Modules\Lesson\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Chapter\Entities\Chapter;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Entities\LessonCompletion;

class ApiController extends Controller
{
    public function lesson_completed(Request $request)
    {
        $user = auth('sanctum')->user();
        $subscriber = $user->subscriber;

        $lesson = Lesson::find($request->lesson_id);

        $previously_completed = LessonCompletion::where('subscriber_id', $subscriber->id)->where('lesson_id', $lesson->id)->first();
        if ($previously_completed) {
            return response()->json(['success' => false, 'message' => 'Lesson Already Marked As Completed']);
        } else {
            $lesson_completion = new LessonCompletion();
            $lesson_completion->subscriber_id = $subscriber->id;
            $lesson_completion->lesson_id = $lesson->id;
            $lesson_completion->save();
            return response()->json(['success' => true, 'message' => 'Lesson Marked As Completed']);
        }
    }




    public function remove_lesson_completed(Request $request)
    {
        $user = auth('sanctum')->user();
        $subscriber = $user->subscriber;

        $lesson = Lesson::find($request->lesson_id);

        $previously_completed = LessonCompletion::where('subscriber_id', $subscriber->id)->where('lesson_id', $lesson->id)->first();
        if ($previously_completed) {
          $previously_completed->delete();
          return response()->json(['success' => true, 'message' => 'Lesson Marked Incompleted Successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Lesson Already Incomplete']);
        }
    }


    public function chapter_percentage(Request $request)
    {
        $user = auth('sanctum')->user();
        $subscriber = $user->subscriber;

        $chapter = Chapter::where('id', $request->chapter_id)->withCount('lessons')->first();
        $chapterLessonCount = $chapter->lessons_count;

        $chapter_lessons = $chapter->lessons->pluck('id');

        $subscriberCompletedLessonCount = LessonCompletion::where('subscriber_id', $subscriber->id)->whereIn('lesson_id', $chapter_lessons)->count();
        $percentage=($subscriberCompletedLessonCount/$chapterLessonCount)*100;
        return response()->json(['success' => true, 'percentage' => round($percentage,2)]);
    }
}
