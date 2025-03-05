@extends('adminlte::page')

@section('title', 'Add Grades')

@section('content_header')
    <h1>Grades of Students</h1>
@endsection

@section('content')
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Students Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Enrolled Students</h3>
        </div>
        <div class="card-body">
            @if($enrollments->isEmpty())
                <p>No students found.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Enrollment Number</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Subjects Enrolled</th>
                            <th>Grades</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->student ? $enrollment->student->student_id : 'N/A' }}</td>
                                <td>{{ $enrollment->id }}</td>
                                <td>{{ $enrollment->last_name }}, {{ $enrollment->first_name }}</td>
                                <td>{{ $enrollment->course }}</td>
                                <td>{{ $enrollment->year_level }}</td>
                                <td>
                                    @if($enrollment->subjects && $enrollment->subjects->isNotEmpty())
                                        {{ $enrollment->subjects->pluck('subject_name')->join(', ') }}
                                    @else
                                        No subjects enrolled
                                    @endif
                                </td>
                                <td>
    
    
    @if($enrollment->grades && $enrollment->grades->isNotEmpty())
        @foreach($enrollment->grades as $grade)
            @if($grade->subject)
                <p>{{ $grade->subject->subject_name }}: <strong>{{ $grade->grade }}</strong></p>
            @else
                <p>Grade found, but subject missing!</p>
            @endif
        @endforeach
    @else
        <p>No grades assigned</p>
    @endif
</td>

                                <td>
                                    <a href="{{ route('admin.grades.edit', $enrollment->id) }}" class="btn btn-primary btn-sm">
                                        Add Grades & Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
