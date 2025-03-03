@extends('adminlte::page')

@section('title', 'Edit Student')

@section('content_header')
    <h1>Edit Student</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_id" class="form-control" value="{{ $student->student_id }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $student->last_name }}" required oninput="validateLettersOnly(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $student->first_name }}" required oninput="validateLettersOnly(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" value="{{ $student->course }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Year Level</label>
                    <input type="number" name="year_level" class="form-control" value="{{ $student->year_level }}" min="1" max="4" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                </div>

                <button type="submit" class="btn btn-success">Update Student</button>
                <a href="{{ route('admin.students.list') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

<script>
    function validateLettersOnly(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Allows only letters and spaces
    }
</script>
