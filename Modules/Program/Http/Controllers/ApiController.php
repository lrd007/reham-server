<?php

namespace Modules\Program\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Program\Entities\Program;

class ApiController extends Controller
{
    public function all_programs()
    {
        // $programs = Program::with(['courses' => function ($query) {
        //     $query->with('courseFees')->withCount('chapters');
        // }])->get();
        $programs = Program::with(['courses.courseFees', 'courses.bonusMaterials.materials', 'courses.chapters.lessons' => function ($query) {
            $query->orderBy('id', 'ASC');
        }])->get();
        return response()->json(['programs' => $programs]);
        //return response()->json(['programs'=>Program::with('courses.courseFees')->get()]);
    }

    public function program_details(Program $program)
    {
        // $program = Program::with(['sections','sections.elements','courses' => function ($query) {
        //     $query->with('courseFees')->withCount('chapters');
        // },'courses.chapters.lessons'])->find($program->id);
        // return response()->json(['program' => $program]);
        // return response()->json(['programs' => Program::with('courses.courseFees')->find($program->id)]);
        $program = Program::with(['sections','sections.elements','courses' => function ($query) {
            $query->with('courseFees')->withCount('chapters');
        },'courses.chapters.lessons'])->find($program->id);
        // Calculate the total price of the program.
        $total_price=0;
        foreach($program->courses as $course)
        {
            $total_price += $course->courseFees()->pluck('sale_fee')->first();
        }
        $program['total_price']=$total_price;
        return response()->json(['program' => $program]);
    }
}
