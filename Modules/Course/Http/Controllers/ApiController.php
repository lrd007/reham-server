<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Comment\Entities\Comment;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\Lesson;

class ApiController extends Controller
{
    public function course_detail(Course $course)
    {
        return response()->json(['course' => Course::withCount('chapters')->with(['getStartedFiles', 'courseFees', 'bonusMaterials.materials', 'chapters.lessons' => function ($query) {
            $query->orderBy('id', 'ASC');
        }])->find($course->id)]);
    }

    public function search_courses(Request $request)
    {
        $result = Course::where('name_en', 'LIKE', '%' . $request->key . '%')->orWhere('name_ar', 'LIKE', '%' . $request->key . '%')->get();
        if (count($result)) {
            return Response()->json(['Result' => $result]);
        } else {
            return response()->json(['Result' => 'No Data not found'], 404);
        }
    }

    public function lesson_comments(Request $request)
    {
        $lesson = Lesson::find($request->lesson_id);
        $comments = $lesson->comments()->with('user', 'allChildren')->whereNull('parent_id')->get();
        return response()->json(['comments' => $comments]);
    }


    public function course_comments(Request $request)
    {
        $course = Course::find($request->course_id);
        $comments = $course->comments()->with('user', 'allChildren')->whereNull('parent_id')->get();
        return response()->json(['comments' => $comments]);
    }

    public function bonus_material_comments(Request $request)
    {
        $bonus_material = BonusMaterial::find($request->bonus_material_id);
        $comments = $bonus_material->comments()->with('user', 'allChildren')->whereNull('parent_id')->get();
        return response()->json(['comments' => $comments]);
    }

    public function suggested_courses(Request $request)
    {


        $user = auth('sanctum')->user();
        $courses = $user->subscriber->subscribePrograms()->with('course')->get();

        $my_courses = collect();

        foreach ($courses as $course) {
            $my_courses->push($course->course);
        }

        $suggested_courses = Course::whereNotIn('id', $my_courses->pluck('id'))->get();
        return response()->json(['suggested_courses' => $suggested_courses]);

        // $course=Course::find($request->course_id);
        // $tagNames=$course->tags->pluck('id');

        // $suggested_courses = Course::whereHas('tags', function ($query) use ($tagNames) {
        //     $query->whereIn('id', $tagNames);
        // })
        // ->get();

        // $data=$suggested_courses->except($course->id);
        // return response()->json(['suggested_courses' => $data]);
    }

    public function all_courses()
    {
        $courses = Course::withCount('chapters')->with(['getStartedFiles', 'bonusMaterials.materials', 'chapters.lessons' => function ($query) {
            $query->orderBy('id', 'ASC');
        }])->get();

        return response()->json(['data' => $courses]);
    }
}
