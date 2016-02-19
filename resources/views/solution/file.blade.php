@extends('layouts.app')

@section('content')


<script type="text/javascript" src="{{ asset('public/js/syntaxhighlighter/scripts/shCore.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/js/syntaxhighlighter/scripts/'.$script) }}"></script>

<script type="text/javascript" src="{{ asset('public/js/syntaxhighlighter/scripts/shAutoloader.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('public/css/syntaxhighlighter/styles/shCoreDefault.css') }}" />

<div class="container-fluid">
    
    <ol class="breadcrumb">
        <li><a href="{{action('HomeController@index')}}">{{Lang::get('app.home')}}</a></li>
        <li><a href="{{action('TaskController@viewTask',['id' => $task->id])}}">{{ $task->name }}</a></li>
        <li><a href="{{action('TaskController@viewTask',['id' => $task->id])}}">{{Lang::get('app.solution')}}</a></li>
        <li class="active">{{ $solutionFile->name }}</li>
    </ol>
    
    <h3>{{ $solutionFile->name }} <small>{{Lang::get('app.updated_at')}} {{$solutionFile->updated_at}}</small></h3>
    <pre class="brush: {{$alias}};">{{$solutionFile->data}}</pre>
</div>
<script type="text/javascript">SyntaxHighlighter.all();</script>

@endsection
