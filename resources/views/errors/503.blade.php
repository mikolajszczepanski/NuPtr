@extends('layouts.basic')

@section('body')

<div class="col-lg-12 ">
    <h1 class="httpException">
        <span class="httpException">503</span>
        <br>
        <small>Service Unavailable</small>
        <br>
        <small>The server is currently unavailable because it is down for maintenance</small>
        <br>
        <br>
        @include('errors.wiki_link')
    </h1>
</div>



@endsection
