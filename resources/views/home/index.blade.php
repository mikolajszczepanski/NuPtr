@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-12">
        <br>
        <h1 class="text-center"><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> 
            {{Lang::get('app.landing_text')}}
            <br>
        </h1>
        <h3 class="text-center">
            <small>{{Lang::get('app.tasks')}}: <i>{{ $statistics['tasks'] }}</i></small>
            <small>{{Lang::get('app.solutions')}}: <i>{{ $statistics['solutions'] }}</i></small>
            <small>{{Lang::get('app.users')}}: <i>{{ $statistics['users'] }}</i></small>
        </h3>
    </div>
    <h4><span class="glyphicon glyphicon-fire" aria-hidden="true" style="color:#D50000;"></span> {{Lang::get('app.this_week')}}</h4>
    @include('task.table') 
</div>
@endsection
