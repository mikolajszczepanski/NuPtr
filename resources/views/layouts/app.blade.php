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
                        Tasks <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/tasks') }}">All</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($categories as $category)
                        <li><a href="{{ action('TaskController@index',['alias' => $category->alias]) }}">{{$category->name}}</a></li>
                        @endforeach
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ action('TaskController@getCreateView') }}">Add new task</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>

            <!-- Search -->
            <div class="col-sm-offset-0 col-md-offset-1 col-lg-offset-1 col-sm-5 col-md-5 col-lg-6 pull-left">
                <form method="get" class="navbar-form" role="search" action="{{action('TaskController@search')}}">
                    <div id="search" class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="s" id="search" value="{{ !empty($search) ? $search : '' }}">
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
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        @if(Auth::user()->admin)
                        <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-th"></i>Admin panel</a></li>
                        @endif
                        <li><a href="{{ url('/account') }}"><i class="fa fa-btn fa-user"></i>My account</a></li>
                        <li><a href="{{ url('/my/tasks') }}"><i class="fa fa-btn fa-star"></i>View my tasks</a></li>
                        <li><a href="{{ url('/my/solutions') }}"><i class="fa fa-btn fa-star"></i>View my solutions</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
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
        <p id="alert-message" 
           class="alert {{ Session::get('alert')->class }} col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <strong>{{ Session::get('alert')->title }}</strong> {{ Session::get('alert')->text }}
        </p>
    </div>
    @endif

    @yield('content')

</div>

<div>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <br>
        <p class="text-center">
            All right reserved
        </p>
    </div>
</div>

@endsection
