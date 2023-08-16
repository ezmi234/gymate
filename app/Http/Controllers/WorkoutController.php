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
        $workouts = Workout::where('user_id', Auth::user()->id)->get();
        $output = '';
        if ($workouts->isEmpty()) {
            return response()->json(['message' => 'No workouts found'], 404);
        }
        foreach ($workouts as $workout){
            $path = asset('storage/images/workouts/'.$workout->image);
            $output .='<div class="card mb-4">
                <img src="'.$path.'" alt="Workout image" class="img-fluid rounded" style="height: 40vh">
                <div class="card-body">
                    <div style="display:flex; flex-flow: wrap; align-items:baseline; justify-content: space-between;">
                        <h5 class="card-title">'.$workout->title.'</h5>';

            if(Auth::user()->id == $workout->user_id){
                $output .= '<a href="#" class="btn btn-success btn-block">Edit</a>';
            }

            $output .= '</div>
                        <p class="card-text">Description: '.$workout->description.'</p>
                        <p class="card-text">Location: '.$workout->location.'</p>
                        <p class="card-text">Date: '.$workout->date.'</p>
                        <p class="card-text">Time: '.$workout->time.'</p>
                        <p class="card-text">Duration: '.$workout->duration.'</p>
                        <p class="card-text">Capacity: '.$workout->capacity.'</p>
                    </div>
                </div>';
        }
        return response()->json([
            'status' => 200,
            'html' => $output,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg',  'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
            'location' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'integer'],
            'capacity' => ['required', 'integer'],
        ]);

        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = "public/images/workouts";
            $image->storeAs($destinationPath, $name);
            $data['image'] = $name;
        }

        $workout = Workout::create($data);

        return response()->json([
            'status' => 200,
        ]);
    }






}
