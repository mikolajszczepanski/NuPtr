@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Tasks Index</h3><a href="{{action('TaskController@getCreateView')}}">[add new]</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Name</th>
                <th width="15%">Author</th>
                <th width="50%">Descripton\solutions</th>
                <th width="15%">Created</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
        <tr class="clickableRow" link="{{$task->id}}">
            <td>{{$task->id}}</td>
            <td>{{$task->name}}</td>
            <td>
                {{$task->author}}
            </td>
            <td>
                <p>{{$task->description}}
                    @foreach ($task->files as $file)
                    <a href="{{action('TaskController@viewTaskFile',[$file->id])}}">{{$file->name}}</a>
                    @endforeach
                </p>
                <div class="hidden">
                    <table>
                        <thead>
                            <tr>
                                <th width="20%"></th>
                                <th width="55%"></th>
                                <th width="25%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($task->solutions as $solution)
                            <tr>
                                <td>{{$solution->user_name}}</td>
                                <td>
                                    @foreach ($solution->files as $file)
                                        <a href="{{action('SolutionController@viewSolutionFile',[$solution->id])}}">{{$file->name}}</a>
                                    @endforeach
                                </td>
                                <td>{{$solution->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{action('SolutionController@getCreateView',[$task->id])}}">[add new solution]</a>
                </div>
            </td>
            <td>{{$task->created_at}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {!! $tasks->render() !!}

    <script src="{{ asset('public/js/tasksIndex.js') }}"></script>
</div>
@endsection