@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="data-row-danger">
            <h3>
                <span class="glyphicon glyphicon-alert" aria-hidden="true" style="color:#D50000"></span>
                Delete
            </h3>
            <p>You delete this solution with files forever, its very long. </p>
            <br>
            <form method="post" action="{{action("SolutionController@delete")}}">
                <input type="hidden" name="solution_id" value="{{ $solution->id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-default" style="border-color:#D50000;color:#D50000">Submit</button>
            </form>
        </div>
    </div>
</div>


@endsection