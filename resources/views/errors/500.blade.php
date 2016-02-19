@extends('layouts.basic')

@section('body')

<div class="col-lg-12 ">
    <h1 class="httpException">
        <span class="httpException">500</span>
        <br>
        <small>Internal Server Error</small>
        <br>
        <small>Your request could not be resolve</small>
        <br>
        <br>
        @include('errors.wiki_link')
    </h1>
</div>



@endsection
