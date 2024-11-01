<?php

namespace Modules\NotificationCenter\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\NotificationCenter\Notifications\TechnicalSupport;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Notification;

class ApiController extends Controller
{
    public function get_user_notifications()
    {
        $user = auth('sanctum')->user();
        return response()->json(['success' => true, 'data' => $user->notifications]);
    }

    public function technical_support(Request $request)
    {     
        $rules = [
            'subject' => 'required',
            'message' => 'required',
        ];

        $input = $request->only(
            'subject',
            'message',
        );
        
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        
        $user = auth('sanctum')->user();

        //$admins=User::where('is_admin',true)->get();
        $data['subject']=$request->subject;
        $data['message']=$request->message;
        $data['user_name']=$user->name;
        $data['user_email']=$user->email;
        // foreach($admins as $admin)
        // {
        //     $admin->notify(new TechnicalSupport($data));
        // }
        Notification::route('mail', 'hello@reham.com')->notify(new TechnicalSupport($data));

        return response()->json(['success' => true, 'message' => 'Email Sent Successfully to System Admin']);
    }
}
