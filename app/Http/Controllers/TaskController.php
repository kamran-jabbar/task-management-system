<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_form()
    {
        return view('create-task');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
        ]);

        if (!$validatedData) {
            return view('create-task');
        }

        $task = new Task();
        $task->name = request('name');
        $task->description = request('description');
        $task->user_id = auth()->user()->id;

        if (!$task->save()) {
            return redirect('dashboard')->with(['message' => 'Failed to create the task, please try again.', 'status' => 'danger']);
        }

        return redirect('dashboard')->with(['message' => 'Task created successfully.', 'status' => 'success']);
    }
}
