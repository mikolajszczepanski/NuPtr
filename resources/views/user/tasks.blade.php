@extends('layouts.app')

@section('content')

<div class="container">
    <h3>{{Lang::get('app.my_tasks')}}</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">{{Lang::get('app.name')}}</th>
                <th width="10%">{{Lang::get('app.category')}}</th>
                <th width="15%">{{Lang::get('app.author')}}</th>
                <th width="35%">{{Lang::get('app.description_and_files')}}</th>
                <th width="15%">{{Lang::get('app.created')}}</th>
                <th width="10%">{{Lang::get('app.operations')}}</th>
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
                    <a href="{{action('TaskController@getEditView',[$task->id])}}">[{{Lang::get('app.edit')}}]</a>
                    <a href="{{action('TaskController@getDeleteView',[$task->id])}}">[{{Lang::get('app.delete')}}]</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $tasks->render() !!}
</div>

@endsection