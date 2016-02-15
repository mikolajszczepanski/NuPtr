<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NuPtr</title>
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}">
    
    <meta name="description" content="Tasks and solutions online repertory">
    <meta name="keywords" content="tasks,programming,code,problems,solutions">

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('public/css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/default.css') }}" />
    
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('public/js/app.js') }}"></script> --}}

    <!-- Cookies -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.cookiebar.css') }}" />
    <script type="text/javascript" src="{{ asset('public/js/jquery.cookiebar.js') }}"></script>
    
    <!-- Default -->
    <script type="text/javascript" src="{{ asset('public/js/default.js') }}"></script>
    
</head>
<body id="app-layout">
    @yield('body')
</body>
</html>
