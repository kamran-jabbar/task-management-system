<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
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
}
