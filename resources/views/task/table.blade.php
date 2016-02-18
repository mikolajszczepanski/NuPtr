@if($tasks)
<table class="table table-striped">
    <thead>
        <tr>
            <th width="5%">#</th>
            @if(empty($alias))
            <th width="5%">{{Lang::get('app.category')}}</th>
            @endif
            <th width="15%">{{Lang::get('app.name')}}</th>
            <th width="15%">{{Lang::get('app.author')}}</th>
            <th width="{{(empty($alias)) ? '45%' : '50%'}}">{{Lang::get('app.description_and_solutions')}}</th>
            <th width="15%">{{Lang::get('app.created')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr class="clickableRow" link="{{$task->id}}">
            <td>{{$task->id}}</td>
            @if(empty($alias))
            <td>{{$task->category_name}}</td>
            @endif
            <td>{{$task->name}}</td>
            <td>
                {{$task->author}}
            </td>
            <td>
                <p>{{$task->description}}
                    @foreach ($task->files as $file)
                    <a href="{{action('TaskController@viewTaskFile',[$file->id])}}">{{$file->name}}</a>
                    @endforeach
                </p>
                <div class="hidden">
                    <table>
                        <thead>
                            <tr>
                                <th width="20%"></th>
                                <th width="55%"></th>
                                <th width="25%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($task->solutions as $solution)
                            <tr>
                                <td>{{$solution->user_name}}</td>
                                <td>
                                    @foreach ($solution->files as $file)
                                    <a href="{{action('SolutionController@viewSolutionFile',[$file->id])}}">{{$file->name}}</a>
                                    @endforeach
                                </td>
                                <td>{{$solution->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{action('SolutionController@getCreateView',[$task->id])}}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        {{Lang::get('app.add_solution')}}
                    </a>
                </div>
            </td>
            <td>{{$task->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $tasks->render() !!}

<script src="{{ asset('public/js/tasksTable.js') }}"></script>
@else
<br>
<p><i>No results</i></p>
@endif
