<?php

namespace Modules\FAQ\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FAQ\Entities\Faq;

class ApiController extends Controller
{
    public function general_faq()
    {
        return response()->json(['general_faq'=>Faq::where('type',0)->get()]);
    }

    public function legal_faq()
    {
        return response()->json(['legal_faq'=>Faq::where('type',1)->get()]);
    }
}
