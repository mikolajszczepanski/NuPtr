@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>Contact</h2>
        <form>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="type">Category*</label>
                <select class="form-control" id="type">
                    <option value="0">Suggestion</option>
                    <option value="1">Report bug</option>
                    <option value="2">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="text">Discribe here*</label>
                <textarea class="form-control" rows="10" id="text"></textarea>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>
@endsection
