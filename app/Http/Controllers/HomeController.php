<?php

namespace App\Http\Controllers;

use App\Task;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard with tasks list.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        /* @todo: we should get the date time difference to calculate time spent from query instead of on blade. */
        $tasks = Task::where(['user_id' => $user->id])->get()->toarray();

        return view('home', ['tasks' => $tasks]);
    }
}
