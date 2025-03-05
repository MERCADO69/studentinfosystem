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
                                        {{-- Remove grades display and only show the View Grades button --}}
                                        <button class="btn btn-info btn-sm view-grades-btn" data-toggle="modal"
                                            data-target="#gradesModal"
                                            data-student="{{ $enrollment->last_name }}, {{ $enrollment->first_name }}"
                                            data-grades="{{ json_encode($enrollment->grades->map(function ($grade) {
                            return ['subject' => $grade->subject->subject_name, 'grade' => $grade->grade]; })->toArray()) }}">
                                            View Grades
                                        </button>
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

    <!-- Grades Modal -->
    <div class="modal fade" id="gradesModal" tabindex="-1" role="dialog" aria-labelledby="gradesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradesModalLabel">Student Grades</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="studentName"></h5>
                    <ul id="gradesList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.view-grades-btn').click(function () {
                let studentName = $(this).data('student');
                let grades = $(this).data('grades');  // Now this is an array of grades and subjects

                $('#studentName').text(studentName);
                $('#gradesList').empty();

                if (grades.length > 0) {
                    grades.forEach(function (grade) {
                        $('#gradesList').append(`<li>${grade.subject}: <strong>${grade.grade}</strong></li>`);
                    });
                } else {
                    $('#gradesList').append('<li>No grades assigned</li>');
                }
            });
        });
    </script>
@endsection