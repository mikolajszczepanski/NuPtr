@extends('layouts.app')

@section('content')

<div class="container">
    <h3>My solutions</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="20%">Task</th>
                <th width="40%">Files</th>
                <th width="20%">Created</th>
                <th width="20%">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($solutions as $solution)
            <tr>
                <td>{{$solution->task_name}}</td>
                <td>
                   <p>
                        @foreach ($solution->files as $file)
                        <a href="{{action('SolutionController@viewSolutionFile',[$file->id])}}">{{$file->name}}</a>
                        @endforeach
                    </p>
                </td>
                <td>{{$solution->created_at}}</td>
                <td>
                    <a href="{{action('SolutionController@getEditView',[$solution->id])}}">[edit]</a>
                    <a href="{{action('SolutionController@getDeleteView',[$solution->id])}}">[delete]</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $solutions->render() !!}
</div>

@endsection