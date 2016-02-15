@extends('layouts.app')

@section('content')
<div class="container">
    @if(!empty($alias))
    <h3>
        <?php
            foreach($categories as $category){
                if($category->alias == $alias){
                    echo $category->name;
                    break;
                }
            }
        ?>
    </h3>
    @endif
    <a href="{{action('TaskController@getCreateView')}}">[add new]</a>
    @include('task.table') 

</div>
@endsection