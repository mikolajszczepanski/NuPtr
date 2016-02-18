@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>{{Lang::get('app.contact')}}</h2>
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
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="email">{{Lang::get('app.email_address')}}</label>
                    <input type="email" class="form-control" id="email" placeholder="{{Lang::get('app.email')}}" name="email">
                </div>
                <div class="form-group">
                    <label for="type">{{Lang::get('app.category')}}*</label>
                    <select class="form-control" id="type" name="category_id">
                        @foreach($contact_messages_categories as $contact_messages_category)
                        <option value="{{$contact_messages_category->id}}">{{Lang::get('app.'.$contact_messages_category->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <label for="text">{{Lang::get('app.description')}}*</label>
                    <textarea class="form-control" rows="10" id="text" name="text"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-default">{{Lang::get('app.submit')}}</button>
            </div>
        </form>
    </div>
</div>
@endsection
