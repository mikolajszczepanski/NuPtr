@extends('layouts.app')

@section('content')


<script type="text/javascript" src="{{ asset('js/syntaxhighlighter/scripts/shCore.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/syntaxhighlighter/scripts/shBrushCpp.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/syntaxhighlighter/scripts/shAutoloader.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('css/syntaxhighlighter/styles/shCoreDefault.css') }}" />

<div class="container-fluid">
    <h3>{{ $taskFile->name }} <small>Updated at {{$taskFile->updated_at}}</small></h3>
    <pre class="brush: cpp;">
    {{$taskFile->data}}
    </pre>
</div>
<script type="text/javascript">SyntaxHighlighter.all();</script>

@endsection
