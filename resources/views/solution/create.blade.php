@extends('layouts.app')

@section('content')

<div class="col-lg-8 col-lg-offset-2">
    <h3>Add solution</h3>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{action('SolutionController@create')}}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="task_id" value="{{ $id }}">
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
