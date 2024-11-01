<?php

namespace Modules\BonusMaterial\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;

class ApiController extends Controller
{
    public function bonus_material(Request $request)
    {
        $course=Course::find($request->course_id);
        $bonus_materials=$course->bonusMaterials()->with('materials')->get();
        return response()->json(['data' => $bonus_materials]);
    }
}
