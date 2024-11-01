<?php

namespace Modules\Coupon\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Coupon;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\ProgramCourse;
use Carbon\Carbon;
use Validator;

class ApiController extends Controller
{
    public function check_coupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'=> 'required',
            'courseCodes' => 'required|array',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'code' => 400,
                'message' => 'Bad Request',
                'content' => $validator->errors()
            ],400);
        }

        $coupon = Coupon::where('code', $request->code)->first();
        if ($coupon) {
            // check for coupon expiry.
            $today = date("Y-m-d H:i:s");
            $expiry_date = new \DateTime($coupon->end_date);
            $today_date = new  \DateTime($today);
            if($expiry_date < $today_date)
            {
                return response()->json(['success' => false, 'message' => 'Coupon Code Expired'],404);
            }
/*
            $isValidCouponCode = Course::whereIn('id', $request->courseCodes)
                                        ->where('coupon_code', $coupon->id)
                                        ->exists();
*/
        $isValidCouponCode = ProgramCourse::where('program_id', $request->courseCodes)
                    ->whereHas('course', function ($query) use ($coupon) {
                        $query->where('coupon_code', $coupon->id);
                    })
                    ->exists();
            if($isValidCouponCode)
            {
                return response()->json(['success' => true, 'data' => $coupon],200);
            }
            else {
                $courses = Course::whereIn('id', $request->courseCodes)
                                  ->where('coupon_code', $request->id)->get();
                // Promo code is not valid for the provided course codes
                return response()->json(['code'=> 422,'message' => 'Invalid coupon code for the provided course codes', 'courses' => $courses], 422);
            }

        } else {
            // invalid coupon code.
            return response()->json(['success' => false, 'message' => 'رقم قسيمه غير صالح'],400);
        }
    }

    // public function apply_coupon(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'program_id'=> 'required',
    //         'code' => 'required'
    //     ]);

    //     if($validator->fails())
    //     {
    //         return response()->json([
    //             'code' => 400,
    //             'message' => 'Bad Request',
    //             'content' => $validator->errors()
    //         ],400);
    //     }
    //     $coupon = Coupon::where('code', $request->code)->first();
    //     if ($coupon) {
    //         // check for coupon expiry.
    //         $today = date("Y-m-d H:i:s");
    //         $expiry_date = new \DateTime($coupon->end_date);
    //         $today_date = new  \DateTime($today);
    //         if($expiry_date < $today_date)
    //         {
    //             return response()->json(['success' => false, 'message' => 'Coupon Code Expired']);
    //         }

    //         // $course =

    //         return response()->json(['success' => true, 'data' => $coupon]);
    //     } else {
    //         // invalid coupon code.
    //         return response()->json(['success' => false, 'message' => 'Coupon Code Invalid']);
    //     }
    // }
}
