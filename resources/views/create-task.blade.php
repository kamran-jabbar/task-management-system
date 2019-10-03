@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Task</div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="list-style-type: none">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {!! Form::open() !!}
                        <div class="form-group">
                            {!! Form::label('Task name:') !!}
                            {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Enter Task Name']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Task description:') !!}
                            {!! Form::textarea('description', old('description'), ['class'=>'form-control', 'placeholder'=>'Enter Task Description']) !!}
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
