@extends('layouts.app')

@section('content')

<div class="container">
    
   <ul class="nav nav-tabs">
        <li role="presentation">
            <a href="{{action('AdminController@messages')}}">
                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                Messages
            </a>
        </li>
        <li role="presentation" class="active">
            <a href="{{action('AdminController@users')}}">
                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                Users
            </a>
        </li>
        <li role="presentation">
            <a href="{{url('admin/logs')}}">
                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                Logs
            </a>
        </li>
    </ul>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="25%">Name</th>
                <th width="20%">Email</th>
                <th width="10%">Admin</th>
                <th width="20%">Created</th>
                <th width="20%">Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->admin}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $users->render() !!}
</div>

@endsection