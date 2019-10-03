@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Welcome! You are logged in, you can
                <a href="{{ url('create-task') }}" class="btn btn-info">Create Task</a>
                <br>
                <p><b>Total time spent(minutes):</b> {{ round($minutes,2) }}</p>
                @if (\Session::has('status'))
                    <div class="alert alert-{!! \Session::get('status') !!}">
                        <ul style="list-style-type: none">
                            <li>{!! \Session::get('message') !!}</li>
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Tasks</div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Time Spent(Y-m-d H:m:s)</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($tasks) > 0)
                                @foreach($tasks as $task)
                                    <tr>
                                        <th scope="row">{{ $task['id'] }}</th>
                                        <td>{{ $task['name'] }}</td>
                                        <td>{{ $task['description'] }}</td>
                                        <td>{{ $task['start_time'] }}</td>
                                        <td>{{ $task['end_time'] }}</td>
                                        <td>@if($task['start_time'] && $task['end_time'])
                                                Completed
                                            @elseif($task['start_time'])
                                                In progress
                                            @else
                                                Not started
                                            @endif
                                        </td>
                                        <td>
                                            {{--@todo: Conditions are too odd so that should get data from query in controller .--}}
                                            @if($task['start_time'] && $task['end_time'])
                                                {{
                                                    (new \Carbon\Carbon($task['start_time']))
                                                    ->diff(new \Carbon\Carbon($task['end_time']))
                                                    ->format('%Y-%m-%d %H:%i:%s')
                                                }}
                                            @endif
                                        </td>
                                        <td>
                                            {{--@todo: Conditions are too odd so that should get data from query.--}}
                                            @if($task['start_time'] && $task['end_time'] === null)
                                                <a href="{{ url('finish-task') . '/' . $task['id'] }}"
                                                   onclick="return confirm('Are you sure to finish this task?')">Finish</a>
                                                |
                                            @elseif($task['start_time'] === null)
                                                <a href="{{ url('start-task') . '/' . $task['id'] }}"
                                                   onclick="return confirm('Are you sure to start this task?')">Start</a>
                                                |
                                            @endif
                                            <a href="{{ url('delete-task') . '/' . $task['id'] }}"
                                               onclick="return confirm('Are you sure to delete this task?')">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" align="center">
                                        No task found.
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
