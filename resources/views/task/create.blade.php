@extends('layouts.app')

@section('content')

<div class="col-lg-8 col-lg-offset-2">
    <h3>Create new task</h3>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{action('TaskController@create')}}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
        <label for="taskName">Name</label>
        <input type="text" class="form-control" id="taskName" name="name" placeholder="Name of task">
      </div>
      <div class="form-group">
        <label for="author">Author</label>
        <input type="text" class="form-control" id="author" name="author" placeholder="Author">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" class="form-control" name="category_id">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
      </div>
      <div class="form-group">
          <label>Files</label>
      </div>
      <div id="filesArray">
      </div>
      <div class="form-group">
          <button class="btn btn-default" id="addFileToFilesArray">Add new file</button>
          <button class="btn btn-default" id="removeFileFromFilesArray">Remove last file</button>
      </div>
      <hr>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
<script src="{{ URL::asset('public/js/filesArray.js') }}"></script>

@endsection
