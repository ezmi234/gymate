<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

        $user = User::find(Auth::user()->id);

        return redirect()->back();



    }
}
