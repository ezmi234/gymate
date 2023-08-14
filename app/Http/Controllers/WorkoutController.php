<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchAll()
    {
        $workouts = Workout::where('user_id', Auth::user()->user_id)->get();
        if ($workouts->isEmpty()) {
            return response()->json(['message' => 'No workouts found']);
        }
        return response()->json($workouts);
    }

    public function create()
    {
        return view('workouts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'duration' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        $workout = Workout::create([
            'title' => $request->title,
            'image' => $request->image,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'duration' => $request->duration,
            'capacity' => $request->capacity,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('home');
    }

    public function show($id)
    {
        $workout = Workout::find($id);
        return view('workouts.show', compact('workout'));
    }

    public function edit($id)
    {
        $workout = Workout::find($id);
        return view('workouts.edit', compact('workout'));
    }

    public function update(Request $request, $id)
    {
        $workout = Workout::find($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'duration' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        $workout->update([
            'title' => $request->title,
            'image' => $request->image,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'duration' => $request->duration,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('home');
    }


}
