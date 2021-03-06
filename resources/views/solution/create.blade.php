<?php
    $selected = 'selected';
?>

@extends('layouts.app')

@section('content')
<div class="col-lg-8 col-lg-offset-2">
    <h3>{{ $solution ? Lang::get('app.editing_solution') : Lang::get('app.add_solution') }}</h3>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{action('SolutionController@createOrEdit')}}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="task_id" value="{{ $id }}">
      <input type="hidden" name="solution_id" value="{{ $solution ? $solution->id : '' }}">
      <div class="form-group">
          <label>{{Lang::get('app.files')}}</label>
      </div>
      <div id="filesArray">
          <?php $temp_id = 1; ?>
          @if($solution)
                @foreach($solution->files as $file)
                <div id="file{{$temp_id}}">
                    <div class="form-group">
                        <label for="file_name{{$temp_id}}">{{Lang::get('app.file')}} {{$temp_id}}</label>
                        <input type="text" 
                               name="files[{{$temp_id}}][name]" 
                               class="form-control" 
                               id="file_name{{$temp_id}}" 
                               value="{{$file->name}}" 
                               placeholder="{{Lang::get('app.file_name')}} {{$temp_id}}">
                    </div>
                    <div class="form-group">
                        <label for="file_data{{$temp_id}}">{{Lang::get('app.code')}}</label>
                        <textarea class="form-control" 
                                  name="files[{{$temp_id}}][data]" 
                                  id="file_data{{$temp_id}}" 
                                  rows="6">{{$file->data}}</textarea>
                    </div>
                </div>
                <?php $temp_id++;  ?>
                @endforeach
           @endif
          <input type="hidden" id="num_of_files" value="{{ $temp_id - 1 }}">
      </div>
      <div class="form-group">
          <button class="btn btn-default" id="addFileToFilesArray">{{Lang::get('app.add_file')}}</button>
          <button class="btn btn-default" id="removeFileFromFilesArray">{{Lang::get('app.remove_file')}}</button>
      </div>
      <hr>
      <button type="submit" class="btn btn-default">{{Lang::get('app.submit')}}</button>
    </form>
</div>
<script src="{{ URL::asset('public/js/filesArray.js') }}"></script>

@endsection
