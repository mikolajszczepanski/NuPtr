@extends('layouts.basic')

@section('body')

<div class="col-lg-12 ">
    <h1 class="httpException">
        <span class="httpException">403</span>
        <br>
        <small>Forbidden</small>
        <br>
        <small>You do not have required permissions to access this area</small>
        <br>
        <br>
        @include('errors.wiki_link')
    </h1>
</div>

@endsection
