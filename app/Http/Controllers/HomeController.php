<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user(); // Get the currently authenticated user
        // Check the user's role and redirect accordingly
        if ($user->role === '1') {
            return view('admin.dashboard');
        } elseif ($user->role === '0') {
            return view('students.dashboard');
        } else {
            // Handle other roles or unauthorized users here
            return view('home');
        }
    }
}
