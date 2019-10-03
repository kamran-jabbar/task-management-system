<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * The task model implementation.
     * @var Task
     */
    private $task;

    /**
     * TaskController constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->middleware('auth');
        $this->task = $task;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createForm()
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
        // save record in db.
        if ($this->task->store($request) instanceof Task) {
            return redirect('dashboard')->with(['message' => 'Task created successfully.', 'status' => 'success']);
        }

        return redirect('dashboard')->with([
            'message' => 'Failed to create the task, please try again.',
            'status' => 'danger'
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        if ($this->task->deleteById($id)) {
            return redirect('dashboard')->with(['message' => 'Task deleted successfully.', 'status' => 'success']);
        }

        return redirect('dashboard')->with([
            'message' => 'Failed to delete the task, please try again.',
            'status' => 'danger'
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start($id)
    {
        if ($this->task->updateById($id, Task::TASK_START_TIME_FIELD_NAME)) {
            return redirect('dashboard')->with(['message' => 'Task started successfully.', 'status' => 'success']);
        }

        return redirect('dashboard')->with([
            'message' => 'Failed to start the task, please try again.',
            'status' => 'danger'
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish($id)
    {
        if ($this->task->updateById($id, Task::TASK_FINISH_TIME_FIELD_NAME)) {
            return redirect('dashboard')->with(['message' => 'Task finished successfully.', 'status' => 'success']);
        }

        return redirect('dashboard')->with([
            'message' => 'Failed to start the finish, please try again.',
            'status' => 'danger'
        ]);
    }
}
