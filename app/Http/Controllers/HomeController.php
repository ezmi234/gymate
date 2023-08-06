<?php

namespace App\Http\Controllers;

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

    public function searchUser(Request $request)
    {
        $search = $request->get('search');
        $users = DB::table('users')->where('name', 'like', '%'.$search.'%')->paginate(5);
        dd($users);
        return view('home', ['users' => $users]);
    }
}
