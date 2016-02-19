@extends('layouts.app')

@section('content')
<div class="container">

    @if(!empty($search))
    <!--<h4>{{Lang::get('app.found')}}: {{count($tasks)}} </h4>-->
    @endif
    
@include('task.table') 

</div>
@endsection