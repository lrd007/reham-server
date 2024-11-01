<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Comment;
use Illuminate\Support\Facades\Validator;
use Modules\Comment\Entities\PageComment;

class ApiController extends Controller
{
    public function get_all_comments()
    {
        $comments = Comment::with('lesson', 'bonus_material')->get();
        return response()->json(['success' => true, 'data' => $comments]);
    }

    public function post_comment(Request $request)
    {
        $rules = [
            'comment' => 'required',
        ];

        $input = $request->only(
            'comment',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = auth('sanctum')->user();

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent_id;
        $comment->lesson_id = $request->lesson_id;
        $comment->bonus_material_id = $request->bonus_material_id;
        $comment->course_id = $request->course_id;
        $comment->user_id = $user->id;
        $comment->deleted_at = date('Y-m-d H:i:s');

        $comment->save();

        return response()->json(['success' => true, 'message' => 'Comment Added Successfully.']);
    }

    public function like(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment->like++;
        $comment->save();
        return response()->json(['success' => true, 'message' => 'Like Added Successfully.']);
    }

    public function unlike(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment->like--;
        $comment->save();
        return response()->json(['success' => true, 'message' => 'Like Removed Successfully.']);
    }

    public function add_page_comment(Request $request)
    {
        $rules = [
            'page_name' => 'required',
            'comment' => 'required',
        ];

        $input = $request->only(
            'comment',
            'page_name',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $page_comment = new PageComment();
        $page_comment->page_name = $request->page_name;
        $page_comment->visitor_name = $request->visitor_name;
        $page_comment->visitor_email = $request->visitor_email;
        $page_comment->comment = $request->comment;
        $page_comment->save();

        return response()->json(['success' => true, 'message' => 'Comment Added Successfully']);
    }


    public function all_page_comments(Request $request)
    {
        $page_comments = PageComment::all();
        return response()->json(['success' => true, 'data' => $page_comments]);
    }
}
