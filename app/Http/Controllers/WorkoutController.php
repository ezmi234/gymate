<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchAll(Request $request)
    {
        $workouts = Workout::where('user_id', $request->user_id)->get();
        $output = '';
        if ($workouts->isEmpty()) {
            return response()->json(['message' => 'No workouts found'], 404);
        }
        foreach ($workouts as $workout){
            $date = Carbon::parse($workout->date)->format('d/m/Y');
            $path = asset('storage/images/workouts/'.$workout->image);
            $output .='<div class="card mb-4">
                <img src="'.$path.'" alt="Workout image" class="img-fluid rounded" style="height: 40vh">
                <div class="card-body">
                    <div style="display:flex; flex-flow: wrap; align-items:baseline; justify-content: space-between;">
                        <h5 class="card-title">'.$workout->title.'</h5>';

            if(Auth::user()->id == $workout->user_id){
                $output .= '<div>
                <a href="#" id="' . $workout->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editWorkoutModal"><i class="bi-pencil-square h4"></i></a>
                <a href="#" id="' . $workout->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </div>';
            }

            $output .= '</div>
                        <p class="card-text">'.$workout->description.'</p>
                        <p class="card-text"><i class="bi-geo-alt-fill"></i> '.$workout->location.'</p>
                        <p class="card-text"><i class="bi-calendar3"></i> '.$date.'</p>
                        <p class="card-text"><i class="bi-clock"></i> '.$workout->time.'</p>
                        <p class="card-text"><i class="bi-stopwatch"></i> '.$workout->duration.' min</p>
                        <p class="card-text"><i class="bi-people-fill"></i> '.$workout->capacity.' people</p>
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

    public function delete(Request $request) {
        $id = $request->id;
        $workout = Workout::find($id);
        if (Storage::delete('public/images/workouts/'.$workout->image)) {
            Workout::destroy($id);
        }
        return response()->json([
            'status' => 200,
        ]);
    }






}
