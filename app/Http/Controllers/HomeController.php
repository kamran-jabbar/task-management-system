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
     * The task model implementation.
     * @var Task
     */
    private $task;

    /**
     * HomeController constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->middleware('auth');
        $this->task = $task;
    }

    /**
     * Show the application dashboard with tasks list.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
                'tasks' => $this->task->getListByUser(),
                'minutes' => $this->task->getTimeSpentInSeconds()
            ]
        );
    }
}
