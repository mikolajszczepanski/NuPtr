@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-8 col-lg-offset-2">

        <h3><i class="fa fa-btn fa-user"></i>Account</h3>
        <div class="data-row col-lg-12 col-md-12 col-sd-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12">
                <p>Email:</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 divAsLink" href="{{action('UserController@getChangeEmailView')}}">
                <i>{{$user->email}}
                <span class="glyphicon glyphicon-menu-right pull-right" aria-hidden="true"></span>
                </i>
            </div>
        </div>
        <div class="data-row col-lg-12 col-md-12 col-sd-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12">
                <p>Name:</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 divAsLink" href="{{action('UserController@getChangeNameView')}}">
                <i>{{$user->name}}
                <span class="glyphicon glyphicon-menu-right pull-right" aria-hidden="true"></span>
                </i>
            </div>
        </div>
        <div class="data-row col-lg-12 col-md-12 col-sd-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12">
                <p>Password:</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sd-12 col-xs-12 divAsLink"  href="{{action('UserController@getChangePasswordView')}}">
                <i>******
                <span class="glyphicon glyphicon-menu-right pull-right" aria-hidden="true"></span>
                </i>
            </div>
        </div>
        @if(Auth::user()->admin)
        <div class="data-row-danger col-lg-12 col-md-12 col-sd-12 col-xs-12">
            <p style="color:#D50000;">This is an admin account.</p>
        </div>
        @endif
    </div>
</div>
@endsection