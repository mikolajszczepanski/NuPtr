@extends('layouts.app')

@section('content')
<div class="container">

    @if($tasks)
    <h4>Found: {{count($tasks)}} </h4>
    @endif
    
@include('task.table') 

</div>
@endsection