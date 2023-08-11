<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.index');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact(['user']));
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function edit()
    {
        return view('users.edit');
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->name = $request->input('name');
        $user->save();
        return redirect()->route('users.profile');
    }

    public function follow($id)
    {
        $user = User::find($id);
        if (auth()->user()->isFollowing($user)) {
            auth()->user()->unfollow($user);
            return response()->json(['message' => 'Successfully unfollowed.']);
        }
        auth()->user()->follow($user);
        return response()->json(['message' => 'Successfully followed.']);
    }

    public function unfollow($id)
    {
        $user = User::find($id);
        auth()->user()->unfollow($user);
        return response()->json(['message' => 'Successfully unfollowed.']);
    }


}
