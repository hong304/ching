<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\User;
use App\Notifications\BlogCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogCommentController extends Controller
{
    public function createComment(Request $request)
    {
        //add new comment: check user login and add comment

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $comment = new BlogComment();
        $comment->user_id = Auth::id();
        $comment->blog_id = $request->bid;
        $comment->comment = $request->comment;
        $comment->save();

        $comment = BlogComment::with('user')->find($comment->id);

        //send email here
        $comment->notify(new BlogCommentNotification($comment));

        return redirect()->back();
    }

    public function deleteComment(Request $request)
    {

        $comment = BlogComment::find($request->cid);
        if ($comment) {
            if (Auth::id() == $comment->user_id || Auth::user()->admin) {

                BlogComment::destroy($request->cid);
                return redirect()->back();
            } else {
                return redirect()->back()
                    ->withErrors("You have no permission to delete this comment.");
            }
        } else {
            return redirect()->back()->withErrors("No comment to delete.");
        }

    }

    public function spamComment(Request $request)
    {
        $comment = BlogComment::find($request->cid);
        if ($comment) {
            BlogComment::where('user_id', $comment->user_id)->delete();
            User::destroy($comment->user_id);
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors("No comment to spam.");
        }
    }
}
