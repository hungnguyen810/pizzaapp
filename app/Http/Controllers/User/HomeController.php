<?php

namespace App\Http\Controllers\User;

use App\Repositories\UserRepository;

class HomeController extends Controller
{

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param \App\Repositories\UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.home.index');
    }
}
