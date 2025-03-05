@extends('adminlte::page')

@section('title', 'Enrollments')

@section('content_header')
    <h1>Enrollments</h1>
@endsection
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@section('content')
    {{-- Add Student Button --}}
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        <i class="fas fa-user-plus"></i> Enroll Student
    </button>

    {{-- Enrolled Students Table --}}
    <div class="card shadow-sm rounded">
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Email</th>
                        <th>Subjects</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        <tr>
                            <td class="fw-bold">{{ $enrollment->student ? $enrollment->student->student_id : 'N/A' }}</td>
                            <td>{{ $enrollment->last_name }}, {{ $enrollment->first_name }}</td>
                            <td>{{ $enrollment->course }}</td>
                            <td>{{ $enrollment->year_level }}</td>
                            <td>{{ $enrollment->email }}</td>
                            <td>
                                @foreach($enrollment->subjects as $subject)
                                    <span class="badge bg-secondary">{{ $subject->subject_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Add Student Modal --}}
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStudentModalLabel"><i class="fas fa-user-graduate"></i> Select a Subject
                        for the student</h5>

                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.enrollments.store') }}" method="POST">
                        @csrf

                        {{-- Student Selection Dropdown --}}
                        <div class="mb-3">
                            <label for="student_select" class="form-label fw-bold">Select Student</label>
                            <select class="form-select" id="student_select" name="student_select">
                                <option value="" selected disabled>Choose a student...</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" data-student_id="{{ $student->student_id }}"
                                        data-last_name="{{ $student->last_name }}" data-first_name="{{ $student->first_name }}"
                                        data-course="{{ $student->course }}" data-year_level="{{ $student->year_level }}"
                                        data-email="{{ $student->email }}">
                                        {{ $student->student_id }} - {{ $student->last_name }}, {{ $student->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Student Details (Autofilled) --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label fw-bold">Student ID</label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label fw-bold">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label fw-bold">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="course" class="form-label fw-bold">Course</label>
                                    <input type="text" class="form-control" name="course" id="course" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year_level" class="form-label fw-bold">Year Level</label>
                                    <input type="text" class="form-control" name="year_level" id="year_level" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Subject Selection --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Available Subjects</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                    data-bs-toggle="dropdown">
                                    Select Subjects
                                </button>
                                <ul class="dropdown-menu w-100 p-2" style="max-height: 200px; overflow-y: auto;">
                                    @if($subjects && $subjects->isNotEmpty())
                                        @foreach ($subjects as $subject)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="subject_id[]"
                                                        value="{{ $subject->id }}" id="subject_{{ $subject->id }}">
                                                    <label class="form-check-label" for="subject_{{ $subject->id }}">
                                                        {{ $subject->subject_name }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="text-center">No subjects available.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check-circle"></i> Enroll Student
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentSelect = document.getElementById('student_select');

            if (studentSelect) {
                studentSelect.addEventListener('change', function () {
                    let selected = this.options[this.selectedIndex];

                    document.getElementById('student_id').value = selected.dataset.student_id || '';
                    document.getElementById('last_name').value = selected.dataset.last_name || '';
                    document.getElementById('first_name').value = selected.dataset.first_name || '';
                    document.getElementById('course').value = selected.dataset.course || '';
                    document.getElementById('year_level').value = selected.dataset.year_level || '';
                    document.getElementById('email').value = selected.dataset.email || '';
                });
            } else {
                console.error('Student select element not found');
            }
        });
    </script>
@endsection