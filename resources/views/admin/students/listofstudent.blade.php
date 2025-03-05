@extends('adminlte::page')

@section('title', 'List of Students')

@section('content_header')
    <h1>List of Students</h1>

    {{-- Success or Error Message --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- Add Student Button --}}
    <div class="mt-3">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">Add Student</a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
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
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->last_name }}</td>
                            <td>{{ $student->first_name }}</td>
                            <td>{{ $student->course }}</td>
                            <td>{{ $student->year_level }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <a href="{{ route('admin.students.edit', $student->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <!-- Check if the student can be deleted -->
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    @if (\App\Models\Enrollment::where('student_id', $student->student_id)->exists())
                                        <button type="submit" class="btn btn-danger btn-sm" disabled>
                                            Cannot Delete (Enrolled)
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection