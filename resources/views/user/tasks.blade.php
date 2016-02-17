@extends('layouts.app')

@section('content')

<div class="container">
    <h3>My tasks</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">Name</th>
                <th width="10%">Category</th>
                <th width="15%">Author</th>
                <th width="35%">Description/Files</th>
                <th width="15%">Created</th>
                <th width="10%">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{$task->id}}</td>
                <td><a href="{{action('TaskController@viewTask',['id' => $task->id])}}">{{$task->name}}<a></td>
                <td>{{$task->category_name}}</td>
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
                    <a href="{{action('TaskController@getDeleteView',[$task->id])}}">[delete]</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $tasks->render() !!}
</div>

@endsection