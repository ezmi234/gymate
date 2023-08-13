<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $user = User::find(auth()->user()->id);
        return view('users.profile', compact(['user']));
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

    public function complete_profile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg',  'max:2048'],
            'location' => ['nullable', 'string', 'max:255'],
            'about_me' => ['nullable', 'string', 'max:1000'],
        ]);
        
        $data['profile_completed'] = true;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = "public/images/profile";
            $image->storeAs($destinationPath, $name);
            $data['profile_image'] = $name;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
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

    public function followModal($id)
    {
        $user = User::find($id);
        if (auth()->user()->isFollowing($user)) {
            auth()->user()->unfollow($user);
            return redirect()->back()->with('success', 'Successfully unfollowed.');
        }
        auth()->user()->follow($user);
        return redirect()->back()->with('success', 'Successfully followed.');
    }


}
