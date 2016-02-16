@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>Contact</h2>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{action('HomeController@createContactMessage')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            </div>
            <div class="form-group">
                <label for="type">Category*</label>
                <select class="form-control" id="type" name="category_id">
                    @foreach($contact_messages_categories as $contact_messages_category)
                    <option value="{{$contact_messages_category->id}}">{{$contact_messages_category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="text">Discribe here*</label>
                <textarea class="form-control" rows="10" id="text" name="text"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>
@endsection
