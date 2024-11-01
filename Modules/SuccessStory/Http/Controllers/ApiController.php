<?php

namespace Modules\SuccessStory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SuccessStory\Entities\SuccessStory;
use Illuminate\Support\Facades\Validator;
use Exception;


class ApiController extends Controller
{
    public function success_story_get()
    {
        $success_stories = SuccessStory::with('user')->get();
        return response()->json(['success' => true, 'data' => $success_stories]);
    }

    public function success_story_post(Request $request)
    {
        $user = auth('sanctum')->user();
        $rules = [
            'comment' => 'required',
            'file' => 'required',
        ];

        $input = $request->only(
            'comment',
            'file',
        );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        try {
            $filePath = uploads_files('success_story');
            $success_story = new SuccessStory();
            $success_story->user_id=$user->id;
            $success_story->comment=$request->comment;
            $success_story->file = uploadFile($request, 'success_story_', 'file', 'file', $filePath);
            $success_story->deleted_at=date('Y-m-d H:i:s');
            $success_story->save();
            return response()->json(['success' => true, 'message' => 'Success Story Saved Successfully.']);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
