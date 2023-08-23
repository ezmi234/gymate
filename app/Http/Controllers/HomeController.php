<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function adminHome()
    {
        return view('adminHome');
    }

    public function userHome()
    {
        return view('userHome');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('term');

        // Perform your search logic here, e.g., search users by name or any other criteria
        $users = User::where('name', 'like', '%' . $searchTerm . '%')
                    ->limit(5)
                    ->get();

        return view('search-results', compact('users'));
    }

    public function searchView(Request $request)
    {
        $searchTerm = $request->input('term');

        // Perform your search logic here, e.g., search users by name or any other criteria
        $users = User::where('name', 'like', '%' . $searchTerm . '%')
                    ->get();
        return view('search-user')
            ->with('users', $users)
            ->with('allUsers', User::all());
    }

    public function fetchAllWorkouts()
    {
        //get all workouts of all users followed by the current user
        $user = User::find(Auth::user()->id);
        $follows = $user->follows()->pluck('follow_id');
        $workouts = DB::table('workouts')->whereIn('user_id', $follows)->get();

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
                        <div style="display:flex; flex-flow: wrap;">
                        <p class="card-text" style="margin-right: 10px;"><i class="bi-geo-alt-fill"></i> '.$workout->location.'</p>
                        <p class="card-text" style="margin-right: 10px;"><i class="bi-calendar3"></i> '.$date.'</p>
                        <p class="card-text" style="margin-right: 10px;"><i class="bi-clock"></i> '.$workout->time.'</p>
                        <p class="card-text" style="margin-right: 10px;"><i class="bi-stopwatch"></i> '.$workout->duration.' min</p>
                        <p class="card-text" style="margin-right: 10px;"><i class="bi-people-fill"></i> '.$workout->capacity.' people</p>
                        </div>
                        <p class="card-text">'.$workout->description.'</p>
                    </div>
                </div>';
        }
        return response()->json([
            'status' => 200,
            'html' => $output,
        ]);
    }
}
