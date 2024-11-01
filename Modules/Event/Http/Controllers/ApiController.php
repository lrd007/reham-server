<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Event\Entities\Event;
use Modules\Subscriber\Entities\SubscriberProgram;

class ApiController extends Controller
{
    public function events(Request $request)
    {
        $user = auth('sanctum')->user();
        $subscriber=$user->subscriber;

        $checkPaidSubscriber=SubscriberProgram::where('subscriber_id',$subscriber->id)->first();

        if($checkPaidSubscriber)
        {
            $events=Event::all();
            return response()->json(['success' => true, 'data' => $events]);
        }
        else
        {
            // return response()->json(['success' => false, 'data' => 'Subscriber has not purchased any course.']);

            $events=Event::all();
            return response()->json(['success' => true, 'data' => $events]);
        }
    }
}
