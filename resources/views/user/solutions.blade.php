@extends('layouts.app')

@section('content')

<div class="container">
    <h3>{{Lang::get('app.my_solutions')}}</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="20%">{{Lang::get('app.task')}}</th>
                <th width="40%">{{Lang::get('app.files')}}</th>
                <th width="20%">{{Lang::get('app.created')}}</th>
                <th width="20%">{{Lang::get('app.operations')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($solutions as $solution)
            <tr>
                <td>
                    <a href="{{action('TaskController@viewTask',['id' => $solution->task_id])}}">
                        {{$solution->task_name}}
                    </a>
                </td>
                <td>
                   <p>
                        @foreach ($solution->files as $file)
                        <a href="{{action('SolutionController@viewSolutionFile',[$file->id])}}">{{$file->name}}</a>
                        @endforeach
                    </p>
                </td>
                <td>{{$solution->created_at}}</td>
                <td>
                    <a href="{{action('SolutionController@getEditView',[$solution->id])}}">[{{Lang::get('app.edit')}}]</a>
                    <a href="{{action('SolutionController@getDeleteView',[$solution->id])}}">[{{Lang::get('app.delete')}}]</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $solutions->render() !!}
</div>

@endsection