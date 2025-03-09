@extends('adminlte::page')

@section('title', 'List of Students')

@section('content_header')
    <h1>List of Students</h1>

    {{-- Success or Error Message --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    {{-- Add Student Button --}}
    <div class="mt-3">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add Student
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Scrollable Table Container --}}
            <div style="max-height: 500px; overflow-y: auto;">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td class="fw-bold">{{ $student->student_id }}</td>
                                <td>{{ $student->last_name }}</td>
                                <td>{{ $student->first_name }}</td>
                                <td>{{ $student->course }}</td>
                                <td>{{ $student->year_level }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    @if (\App\Models\Enrollment::where('student_id', $student->student_id)->exists())
                                        <button class="btn btn-danger btn-sm" disabled>
                                            Cannot Delete (Enrolled)
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-student-id="{{ $student->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @endif
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
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm
                        Deletion</h5>

                </div>
                <div class="modal-body">
                    Are you sure you want to delete this student? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
            let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            let deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let studentId = this.getAttribute('data-student-id');
                    deleteForm.action = `/admin/students/${studentId}`; // Update form action
                    deleteModal.show(); // Show the modal
                });
            });
        });
    </script>
@endsection