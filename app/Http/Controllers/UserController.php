<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
        $workouts = $user->workouts()->orderBy('date', 'asc')->get();
        return view('users.show', compact(['user', 'workouts']));
    }

    public function profile()
    {
        $user = User::find(User::find(auth()->user()->id)->id);
        return view('users.profile', compact(['user']));
    }

    public function edit()
    {
        return view('users.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $data = $request->validate([
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg',  'max:2048'],
            'location' => ['required', 'string', 'max:255'],
            'about_me' => ['required', 'string', 'max:1000'],
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = "public/images/profile";
            $image->storeAs($destinationPath, $name);
            $data['profile_image'] = $name;
            if ($user->profile_image != null) {
                Storage::delete('public/images/profile/' . $user->profile_image);
            }
        }

        $user->update($data);

        return view('users.profile', compact(['user']))->with('success', 'Profile updated successfully!');
    }

    public function complete_profile(Request $request)
    {
        $user = User::find(User::find(auth()->user()->id)->id);

        $data = $request->validate([
            'profile_image' => ['required', 'image', 'mimes:png,jpg,jpeg,svg',  'max:2048'],
            'location' => ['required', 'string', 'max:255'],
            'about_me' => ['required', 'string', 'max:1000'],
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
        if (User::find(auth()->user()->id)->isFollowing($user)) {
            User::find(auth()->user()->id)->unfollow($user);
            return response()->json(['message' => 'Successfully unfollowed.']);
        }
        User::find(auth()->user()->id)->follow($user);
        Notification::create([
            'type' => 'follow',
            'sender_id' => auth()->user()->id,
            'receiver_id' => $user->id,
        ]);
        return response()->json(['message' => 'Successfully followed.']);
    }

    public function unfollow($id)
    {
        $user = User::find($id);
        User::find(auth()->user()->id)->unfollow($user);
        return response()->json(['message' => 'Successfully unfollowed.']);
    }

    public function followModal($id)
    {
        $user = User::find($id);
        if (User::find(auth()->user()->id)->isFollowing($user)) {
            User::find(auth()->user()->id)->unfollow($user);
            return redirect()->back()->with('success', 'Successfully unfollowed.');
        }
        User::find(auth()->user()->id)->follow($user);
        return redirect()->back()->with('success', 'Successfully followed.');
    }


}
