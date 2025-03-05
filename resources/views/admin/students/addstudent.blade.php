@extends('adminlte::page')

@section('title', 'Add Student')

@section('content_header')
<h1>Add Student</h1>
@stop

@section('content')
{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="student_id" class="form-control" required value="{{ old('student_id') }}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10">
                @error('student_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}"
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                @error('last_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}"
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Course</label>
                <input type="text" name="course" class="form-control" required value="{{ old('course') }}"
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                @error('course')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Year Level</label>
                <select name="year_level" class="form-control" required>
                    <option value="" disabled {{ old('year_level') == '' ? 'selected' : '' }}>Select Year Level</option>
                    <option value="1" {{ old('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                    <option value="2" {{ old('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3" {{ old('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4" {{ old('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                </select>
                @error('year_level')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Assigned Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password field removed, as the password will be set automatically --}}

            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
</div>
@stop