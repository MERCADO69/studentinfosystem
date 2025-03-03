@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
<h1>Admin Dashboard</h1>
@stop

@section('content')
<p>Welcome, {{ Auth::user()->name }}</p>
@stop