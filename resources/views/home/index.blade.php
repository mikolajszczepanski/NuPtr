@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-12">
        <br>
        <h1 class="text-center"><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
            Solve and share tasks
            <br>
        </h1>
        <h3 class="text-center">
            <small>Tasks: <i>{{ $statistics['tasks'] }}</i></small>
            <small>Solutions: <i>{{ $statistics['solutions'] }}</i></small>
            <small>Users: <i>{{ $statistics['users'] }}</i></small>
        </h3>
    </div>
    <h4><span class="glyphicon glyphicon-fire" aria-hidden="true" style="color:#D50000;"></span> This week</h4>
    @include('task.table') 
</div>
@endsection
