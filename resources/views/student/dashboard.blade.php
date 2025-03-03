@extends('adminlte::page')

@section('title', 'Student Dashboard')

@section('content_header')
<h1>Student Dashboard</h1>
@stop

@section('content')
<p>Welcome, {{ Auth::user()->name }}</p>
@stop