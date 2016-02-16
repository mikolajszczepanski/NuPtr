@extends('layouts.app')

@section('content')

<div class="container">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="{{action('AdminController@messages')}}">
                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                Messages
            </a>
        </li>
        <li role="presentation">
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
                <th width="10%">Category</th>
                <th width="10%">Email</th>
                <th width="60%">Text</th>
                <th width="15%">Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
            <tr>
                <td>{{$message->id}}</td>
                <td>{{$message->category_name}}</td>
                <td>{{$message->email}}</td>
                <td>{{$message->text}}</td>
                <td>{{$message->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $messages->render() !!}
</div>

@endsection