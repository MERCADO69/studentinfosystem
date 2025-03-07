@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
<h1>Admin Dashboard</h1>
<p>Student Information System</p>
<p style="font-size: 1.5rem; font-weight: bold;">Welcome, {{ Auth::user()->name }}</p>
@stop

@section('content')
<div style="width: 100%; height: 70vh; overflow: hidden; position: relative;">
    <!-- Full-Screen Image -->
    <img src="{{ asset('images/DSC_6533.jpg') }}" alt="Description of the image" class="img-fluid"
        style="width: 100%; height: 100%; object-fit: cover;">

    <!-- Dark Overlay -->
    <div
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(246, 246, 246, 0.5); z-index: 1;">
    </div>

    <!-- Welcome Message (Overlapping Text) -->
</div>
@stop