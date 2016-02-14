@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Tasks Index</h3><a href="{{action('TaskController@getCreateView')}}">[add new]</a>
    @include('task.table') 

</div>
@endsection