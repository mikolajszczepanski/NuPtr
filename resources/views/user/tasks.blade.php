@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <h3>My tasks</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Name</th>
                <th width="15%">Author</th>
                <th width="35%">Description/Files</th>
                <th width="15%">Created</th>
                <th width="15%">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{$task->id}}</td>
                <td>{{$task->name}}</td>
                <td>{{$task->author}}</td>
                <td>
                    <p>{{$task->description}}
                        @foreach ($task->files as $file)
                        <a href="{{action('TaskController@viewTaskFile',[$file->id])}}">{{$file->name}}</a>
                        @endforeach
                    </p>
                </td>
                <td>{{$task->created_at}}</td>
                <td>
                    <a href="{{action('TaskController@getEditView',[$task->id])}}">[edit]</a>
                    [delete]
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $tasks->render() !!}
</div>

@endsection