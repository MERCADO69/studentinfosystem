@extends('adminlte::page') {{-- Make sure you're using the correct AdminLTE layout --}}

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
    <p>Student Information System</p>

@endsection

@section('content')
    <div style="width: 100%; height: 77vh; overflow: hidden; position: relative;">
        <!-- Full-Screen Image -->
        <img src="{{ asset('images/DSC_6533.jpg') }}" alt="Description of the image" class="img-fluid"
            style="width: 100%; height: 100%; object-fit: cover;">

        <!-- Dark Overlay -->#
        <div
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1;">
        </div>

        <!-- Welcome Message (Overlapping Text) -->
        <div
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; z-index: 2; text-align: center;">
            <h2>Welcome, {{ Auth::user()->name }}!</h2>
            <p>Manage students, enrollments, and grades efficiently.</p>
        </div>
    </div>
@endsection