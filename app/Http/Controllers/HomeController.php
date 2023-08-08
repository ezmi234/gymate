<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
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

        return view('search-user', compact('users'));
    }
}
