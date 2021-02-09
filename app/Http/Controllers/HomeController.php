<?php

namespace App\Http\Controllers;

use App\Mail\TaskMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        // Mail::to(auth()->user()->email)->send(new TaskMail(auth()->user()->name, 'Test task detail!'));
        return view('home');
    }
}