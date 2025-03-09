@extends('adminlte::page')

@section('title', 'Enrollments')

@section('content_header')
    <h1>Enrollments</h1>
@endsection

@section('content')
    {{-- Add Student Button --}}
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        <i class="fas fa-user-plus"></i> Enroll Student
    </button>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Enrolled Students Table --}}
    <div class="card shadow-sm rounded">
        <div class="card-body">
            {{-- Scrollable Table Container with Sticky Header --}}
            <div style="max-height: 500px; overflow-y: auto; border: 1px solid #dee2e6;">
                <table class="table table-bordered text-center align-middle"
                    style="width: 100%; border-collapse: collapse;">
                    <thead class="table-light" style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
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
                                    <button class="btn btn-info btn-sm view-subjects"
                                        data-enrollment-id="{{ $enrollment->id }}">
                                        <i class="fas fa-eye"></i> View Subjects
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-id="{{ $enrollment->id }}">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this enrollment?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Subjects Modal --}}
    <div class="modal fade" id="subjectsModal" tabindex="-1" aria-labelledby="subjectsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="subjectsModalLabel">List of Student Enrolled Subjects</h5>
                </div>
                <div class="modal-body">
                    <ul id="subjectsList" class="list-group"></ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Student Modal --}}
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStudentModalLabel"><i class="fas fa-user-graduate"></i> Select a Subject
                        for the Student</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.enrollments.store') }}" method="POST">
                        @csrf

                        
                        {{-- Student Selection Dropdown --}}
                        <div class="mb-3">
                            <label for="student_select" class="form-label fw-bold">Select Student</label>
                            <div class="custom-dropdown">
                                <select class="form-select w-100" id="student_select" name="student_select">
                                    <option value="" selected disabled>Choose a student</option>
                                    @foreach($students as $student)
                                                                    @php
                                                                        $isEnrolled = \App\Models\Enrollment::where('student_id', $student->student_id)->exists();
                                                                    @endphp

                                                                    <option value="{{ $isEnrolled ? '' : $student->id }}"
                                                                        data-student_id="{{ $student->student_id }}"
                                                                        data-last_name="{{ $student->last_name }}"
                                                                        data-first_name="{{ $student->first_name }}" data-course="{{ $student->course }}"
                                                                        data-year_level="{{ $student->year_level }}" data-email="{{ $student->email }}" {{ $isEnrolled ? 'disabled' : '' }}
                                                                        style="{{ $isEnrolled ? 'color: green; font-weight: bold;' : '' }}">
                                                                        {{ $student->student_id }} - {{ $student->last_name }}, {{ $student->first_name }}
                                                                        @if($isEnrolled)
                                                                            <span class="badge bg-success ms-2"></span>
                                                                        @endif
                                                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <style>
                            /* Custom Dropdown Styling */
                            .custom-dropdown {
                                position: relative;
                            }

                            .custom-dropdown select {
                                appearance: none;
                                -webkit-appearance: none;
                                -moz-appearance: none;
                                background-color: #fff;
                                border: 1px solid #ced4da;
                                border-radius: 8px;
                                padding: 0.75rem 1rem;
                                font-size: 1rem;
                                color: #495057;
                                width: 100%;
                                cursor: pointer;
                                transition: border-color 0.3s ease, box-shadow 0.3s ease;
                            }

                            .custom-dropdown select:focus {
                                border-color:rgb(0, 152, 48);
                                outline: none;
                                box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
                            }

                        </style>
                        {{-- Autofilled Student Details --}}
                        <div class="row">
                            @foreach(['student_id' => 'Student ID', 'last_name' => 'Last Name', 'first_name' => 'First Name', 'course' => 'Course', 'year_level' => 'Year Level', 'email' => 'Email'] as $field => $label)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="{{ $field }}" class="form-label fw-bold">{{ $label }}</label>
                                        <input type="text" class="form-control" name="{{ $field }}" id="{{ $field }}" readonly>
                                    </div>
                                </div>
                            @endforeach
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
                    ['student_id', 'last_name', 'first_name', 'course', 'year_level', 'email'].forEach(field => {
                        document.getElementById(field).value = selected.dataset[field] || '';
                    });
                });
            }

            document.querySelectorAll('.view-subjects').forEach(button => {
                button.addEventListener('click', function () {
                    let enrollmentId = this.getAttribute('data-enrollment-id');

                    fetch(`/admin/enrollments/${enrollmentId}/subjects`)
                        .then(response => response.json())
                        .then(data => {
                            let subjectsList = document.getElementById('subjectsList');
                            subjectsList.innerHTML = '';

                            if (data.subjects.length > 0) {
                                data.subjects.forEach(subject => {
                                    let listItem = document.createElement('li');
                                    listItem.className = 'list-group-item';
                                    listItem.textContent = subject.subject_name;
                                    subjectsList.appendChild(listItem);
                                });
                            } else {
                                subjectsList.innerHTML = '<li class="list-group-item text-muted">No subjects enrolled.</li>';
                            }

                            new bootstrap.Modal(document.getElementById('subjectsModal')).show();
                        })
                        .catch(error => console.error('Error fetching subjects:', error));
                });
            });

            // Handle delete button click
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let enrollmentId = this.getAttribute('data-id');
                    let form = document.getElementById('deleteForm');
                    form.action = `/admin/enrollments/${enrollmentId}`;
                });
            });
        });
    </script>
@endsection