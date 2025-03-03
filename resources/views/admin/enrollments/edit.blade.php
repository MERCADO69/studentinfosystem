@extends('adminlte::page')

@section('title', 'Edit Enrollment')

@section('content_header')
    <h1>Edit Enrollment</h1>
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

            <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $enrollment->last_name }}" required oninput="validateLettersOnly(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $enrollment->first_name }}" required oninput="validateLettersOnly(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" value="{{ $enrollment->course }}" required oninput="validateLettersOnly(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label">Year Level</label>
                    <input type="number" name="year_level" class="form-control" value="{{ $enrollment->year_level }}" min="1" max="4" required>
                </div>

                <div class="mb-3">
    <label class="form-label">Subjects</label>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
            Select Subjects
        </button>
        <ul class="dropdown-menu w-100 p-2" style="max-height: 200px; overflow-y: auto;">
            @foreach($subjects as $subject)
                <li>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="subject_id[]" value="{{ $subject->id }}"
                            id="edit_subject_{{ $subject->id }}"
                            {{ in_array($subject->id, $enrollment->subjects->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_subject_{{ $subject->id }}">
                            {{ $subject->subject_name }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>


                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $enrollment->email }}" required>
                </div>

                <button type="submit" class="btn btn-success">Update Enrollment</button>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@section('js')
    <script>
        function validateLettersOnly(input) {
            input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Allows only letters and spaces
        }
    </script>
@endsection