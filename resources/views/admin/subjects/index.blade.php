<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Disable body scrolling */
    body {
        overflow: hidden;
    }

    .small-table {
        max-width: 900px;
        /* Adjust the width as needed */
        margin: auto;
        /* Center the table */
    }

    /* Make the table header sticky */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        /* Match the table header background color */
        z-index: 1;
        /* Ensure the header stays above the table rows */
    }

    /* Scrollable table container */
    .scrollable-table {
        max-height: 500px;
        /* Adjust the height as needed */
        overflow-y: auto;
    }
</style>

@extends('adminlte::page')

@section('title', 'Subjects List')

@section('content_header')
    <h1 class="mb-2">List of the Subjects</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
        <i class="fas fa-book"></i> Add Subject
    </button>
@endsection

@section('content')
    <!-- Error message below the title -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($subjects->isEmpty())
                <p>No subjects found.</p>
            @else
                {{-- Scrollable Table Container --}}
                <div class="scrollable-table" style="max-height: 510px; overflow-y: auto;">
                    <table class="table table-bordered" style="width: 100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Units</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->id }}</td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>{{ $subject->subject_code }}</td>
                                    <td>{{ $subject->units }}</td>
                                    <td>
                                        <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-warning btn-sm"
                                            style="padding: 4px 10px; font-size: 13px;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <!-- Delete Button triggers modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{$subject->id}}"
                                            style="padding: 4px 10px; font-size: 13px;">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{$subject->id}}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{$subject->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{$subject->id}}">
                                                            Confirm Deletion
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete
                                                        <strong>{{ $subject->subject_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('admin.subjects.destroy', $subject->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.subjects.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subject_name" class="form-label">Subject Name</label>
                            <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject_code" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="subject_code" name="subject_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="units" class="form-label">Units</label>
                            <input type="number" class="form-control" id="units" name="units" min="1" max="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Subject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection