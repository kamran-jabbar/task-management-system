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
        $task = Task::where(['user_id' => $user->id, 'id' => $id])->get()->toarray();

        if (count($task)) {
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

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start($id)
    {
        $user = auth()->user();
        $task = Task::where(['user_id' => $user->id, 'id' => $id])->get();
        /* @todo: have to implement the feature if current user tries to hit URL manually after completion of task will be a trouble :( */
        if (count($task)) {
            $startStatus = Task::find($id)->update(['start_time' => new Carbon()]);

            if ($startStatus) {
                return redirect('dashboard')->with(['message' => 'Task started successfully.', 'status' => 'success']);

            }

            return redirect('dashboard')->with([
                'message' => 'Failed to start the task, please try again.',
                'status' => 'danger'
            ]);
        }

        return redirect('dashboard')->with(['message' => 'You can start own tasks only.', 'status' => 'danger']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish($id)
    {
        $user = auth()->user();
        $task = Task::where(['user_id' => $user->id, 'id' => $id])->get();
        /* @todo: have to implement the feature if current user tries to hit URL manually after completion of task will be a trouble :( */
        if (count($task)) {
            $startStatus = Task::find($id)->update(['end_time' => new Carbon()]);

            if ($startStatus) {
                return redirect('dashboard')->with(['message' => 'Task finished successfully.', 'status' => 'success']);
            }

            return redirect('dashboard')->with([
                'message' => 'Failed to start the finish, please try again.',
                'status' => 'danger'
            ]);
        }

        return redirect('dashboard')->with(['message' => 'You can finish own tasks only.', 'status' => 'danger']);
    }
}
