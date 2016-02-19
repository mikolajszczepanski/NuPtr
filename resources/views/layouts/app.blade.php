@extends('layouts.basic')

@section('body')

<nav id="navbar" class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                NuPtr
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{Lang::get('app.tasks')}} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/tasks') }}">{{Lang::get('app.all')}}</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($categories as $category)
                        <li><a href="{{ action('TaskController@index',['alias' => $category->alias]) }}">{{$category->name}}</a></li>
                        @endforeach
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ action('TaskController@getCreateView') }}">{{Lang::get('app.add_task')}}</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/contact') }}">{{Lang::get('app.contact')}}</a></li>
            </ul>

            <!-- Search -->
            <div class="col-sm-offset-0 col-md-offset-1 col-lg-offset-1 col-sm-5 col-md-5 col-lg-6 pull-left">
                <form method="get" class="navbar-form" role="search" action="{{action('TaskController@search')}}">
                    <div id="search" class="input-group">
                        <input type="text" class="form-control" placeholder="{{Lang::get('app.search')}}" name="s" id="search" value="{{ !empty($search) ? $search : '' }}">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                <li><a href="{{ url('/login') }}">{{Lang::get('app.login2')}}</a></li>
                <li><a href="{{ url('/register') }}">{{Lang::get('app.register')}}</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        @if(Auth::user()->admin)
                        <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-th"></i>{{Lang::get('app.admin_panel')}}</a></li>
                        @endif
                        <li><a href="{{ url('/account') }}"><i class="fa fa-btn fa-user"></i>{{Lang::get('app.my_account')}}</a></li>
                        <li><a href="{{ url('/my/tasks') }}"><i class="fa fa-btn fa-star"></i>{{Lang::get('app.view_my_tasks')}}</a></li>
                        <li><a href="{{ url('/my/solutions') }}"><i class="fa fa-btn fa-star"></i>{{Lang::get('app.view_my_solutions')}}</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{Lang::get('app.logout')}}</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div id="main-content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
    @if(Session::has('alert'))
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <div id="alert-message" 
           role="alert"
           class="alert alert-dismissible {{ Session::get('alert')->class }} col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{ Session::get('alert')->title }}</strong> {{ Session::get('alert')->text }}
        </div>
    </div>
    @endif

    @yield('content')

</div>

<div>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <br>
        <p class="text-center">
            NuPtr <?php echo date('Y') ?>
        </p>
    </div>
    @if(!Auth::guest() && Auth::user()->admin && !empty($debug_time_of_execution))
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <br>
        <p class="text-center">
            Time of script execution: {{$debug_time_of_execution}}s
        </p>
    </div>
    @endif
</div>

@endsection
