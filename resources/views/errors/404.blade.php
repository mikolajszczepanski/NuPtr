@extends('layouts.basic')

@section('body')

<div class="col-lg-12 ">
    <h1 class="httpException">
        <span class="httpException">404</span>
        <br>
        <small>Not Found</small>
        <br>
        <small>The requested page could not be found</small>
        <br>
        <br>
        @include('errors.wiki_link')
    </h1>
</div>

@endsection
