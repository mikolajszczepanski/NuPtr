<?php
    $selected = 'selected';
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-8 col-lg-offset-2">
        <h3>{{ $task ? Lang::get('app.editing_task') : Lang::get('app.add_task') }}</h3>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{action('TaskController@createOrEdit')}}">
          <input type="hidden" name="task_id" value="{{ $task ? $task->id : '' }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label for="taskName">{{Lang::get('app.name')}}</label>
            <input type="text" value="{{ $task ? $task->name : '' }}" class="form-control" id="taskName" name="name" placeholder="{{Lang::get('app.name_task')}}">
          </div>
          <div class="form-group">
            <label for="author">{{Lang::get('app.author')}}</label>
            <input type="text" value="{{ $task ? $task->author : '' }}" class="form-control" id="author" name="author" placeholder="{{Lang::get('app.author')}}">
          </div>
          <div class="form-group">
            <label for="description">{{Lang::get('app.description')}}</label>
            <input type="text" value="{{ $task ? $task->description : '' }}" class="form-control" id="description" name="description" placeholder="{{Lang::get('app.description')}}">
          </div>
          <div class="form-group">
            <label for="category">{{Lang::get('app.category')}}</label>
            <select id="category" class="form-control" name="category_id">
                @foreach($categories as $category)
                    <option {{ $task && $category->id == $task->category_id ? $selected : ''}} value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
              <label>{{Lang::get('app.files')}}</label>
          </div>
          <div id="filesArray">
              <?php $temp_id = 1;  ?>
              @if($task)
                @foreach($task->files as $file)
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
</div>
@endsection
