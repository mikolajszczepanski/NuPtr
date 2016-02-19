@extends('layouts.basic')

@section('body')

<div class="col-lg-12 ">
    <h1 class="httpException">
        <span class="httpException">406</span>
        <br>
        <small>Internal Server Error</small>
        <br>
        <br>
        <small>Unexpected error occured</small>
        <br>
        @include('errors.wiki_link')
    </h1>
</div>



@endsection
