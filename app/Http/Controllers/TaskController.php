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

        $task = new Task();
        $task->name = request('name');
        $task->description = request('description');
        $task->user_id = auth()->user()->id;

        if (!$task->save()) {
            return redirect('dashboard')->with([
                'message' => 'Failed to create the task, please try again.',
                'status' => 'danger'
            ]);
        }

        return redirect('dashboard')->with(['message' => 'Task created successfully.', 'status' => 'success']);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = auth()->user();
        $tasks = Task::where(['user_id' => $user->id, 'id' => $id])->get()->toarray();

        if (count($tasks)) {
            $deleteStatus = Task::where('id', $id)->delete();

            if ($deleteStatus) {
                return redirect('dashboard')->with(['message' => 'Task deleted successfully.', 'status' => 'success']);
            }

            return redirect('dashboard')->with([
                'message' => 'Failed to delete the task, please try again.',
                'status' => 'danger'
            ]);
        }

        return redirect('dashboard')->with(['message' => 'You can delete own tasks only.', 'status' => 'danger']);
    }
}
