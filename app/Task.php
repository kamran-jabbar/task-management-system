<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    const DEFAULT_PAGINATION_LIMIT = 10;
    const TASK_START_TIME_FIELD_NAME = 'start_time';
    const TASK_FINISH_TIME_FIELD_NAME = 'end_time';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'password',
        'user_id',
        'start_time',
        'end_time'
    ];

    /**
     * Get the tasks of a user.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tasks()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @param Request $request
     * @return Task
     */
    public function store($request)
    {
        $request->merge(array('user_id' => auth()->user()->id));

        return Task::create($request->all());
    }

    /**
     * @return Task
     */
    public function getListByUser()
    {
        return Task::where(['user_id' => auth()->user()->id])->paginate(self::DEFAULT_PAGINATION_LIMIT);
    }

    /**
     * @return float|int
     */
    public function getTimeSpentInSeconds()
    {
        $total = Task::select(DB::raw("SUM(time_to_sec(timediff(end_time, start_time))) as seconds"))->where('user_id',
            auth()->user()->id)->first();
        return $total['seconds'] / 60;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        return Task::where(['user_id' => auth()->user()->id, 'id' => $id])->delete();
    }

    /**
     * @param $id
     * @param $dbField
     * @return Task
     */
    public function updateById($id, $dbField)
    {
        return Task::where(['user_id' => auth()->user()->id, 'id' => $id])->update([$dbField => new Carbon()]);
    }
}
