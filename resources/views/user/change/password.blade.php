@extends('layouts.app')

@section('content')

<div class="col-lg-8 col-lg-offset-2">
    <h4 href="{{action('UserController@account')}}" class="divAsLink"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Account</h4>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{action('UserController@changePassword')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="data-row col-lg-12 col-md-12 col-sd-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">
                <p>Current password:</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">
                <input type="password" name="current_password" class="form-control">
            </div>
            
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">
                <p>New password:</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">
                <input type="password" name="password" class="form-control">
            </div>

            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">
                <p>Repeat new password:</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 form-group">    
                <button type="submit" name="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection