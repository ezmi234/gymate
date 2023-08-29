<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $workout_id = $request->input('workout_id');
        $data = $request->validate([
            'body' => 'required',
        ]);

        $comment = Comment::create([
            'body' => $data['body'],
            'workout_id' => $workout_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($comment->workout->user->id != Auth::user()->id){
        Notification::create([
            'type' => 'comment',
            'sender_id' => Auth::user()->id,
            'receiver_id' => $comment->workout->user->id,
            'workout_id' => $workout_id,
            'comment_id' => $comment->id,
        ]);
        }

        $user = User::find(Auth::user()->id);

        return redirect()->back();

    }

    public function delete(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect()->back();
    }
}
