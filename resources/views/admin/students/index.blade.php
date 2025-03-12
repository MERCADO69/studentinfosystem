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
    {{-- Students Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Enrolled Students</h3>
        </div>
        <div class="card-body">
            @if($enrollments->isEmpty())
                <p>No students found.</p>
            @else
                {{-- Scrollable Table Container with Sticky Header --}}
                <div style="max-height: 500px; overflow-y: auto; border: 1px solid #dee2e6;">
                    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
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
                                                        <button class="btn btn-info btn-sm view-subjects-btn" data-toggle="modal"
                                                            data-target="#subjectsModal"
                                                            data-subjects="{{ json_encode($enrollment->subjects->pluck('subject_name')) }}">
                                                            <i class="fas fa-eye"></i> View Subjects
                                                        </button>
                                                    @else
                                                        No subjects enrolled
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm view-grades-btn" data-toggle="modal"
                                                        data-target="#gradesModal"
                                                        data-student="{{ $enrollment->last_name }}, {{ $enrollment->first_name }}" data-grades="{{ json_encode($enrollment->grades->map(function ($grade) {
                                    return ['subject' => $grade->subject->subject_name, 'grade' => $grade->grade];
                                })->toArray()) }}">
                                                        <i class="fas fa-eye"></i> View Grades
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.grades.edit', $enrollment->id) }}" class="btn btn-sm text-white"
                                                        style="background-color: #FF8C00; border: none;">
                                                        <i class="fas fa-plus"></i> <i class="fas fa-edit"></i> Add & Edit Grades
                                                    </a>
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <!-- Grades Modal -->
    <div class="modal fade" id="gradesModal" tabindex="-1" role="dialog" aria-labelledby="gradesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="gradesModalLabel">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Student Grades
                    </h5>

                </div>
                <div class="modal-body">
                    <h5 class="mb-4" id="studentName">
                        <i class="fas fa-user mr-2"></i>
                        <span id="studentNameText"></span>
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody id="gradesList">
                                <!-- Grades will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subjects Modal -->
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

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // Handle View Grades Button Click
            $('.view-grades-btn').click(function () {
                let studentName = $(this).data('student');
                let grades = $(this).data('grades');  // This is an array of grades and subjects

                // Set the student name in the modal
                $('#studentNameText').text(studentName);

                // Clear the existing table rows
                $('#gradesList').empty();

                // Populate the table with grades
                if (grades.length > 0) {
                    grades.forEach(function (grade) {
                        // Determine the color based on the grade
                        let gradeClass = (grade.grade == 5.00) ? 'text-danger' : 'text-success';

                        $('#gradesList').append(`
                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                        <td>${grade.subject}</td>
                                                                                                                                                                                                                        <td class="${gradeClass}"><strong>${grade.grade}</strong></td>
                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                `);
                    });
                } else {
                    $('#gradesList').append(`
                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                    <td colspan="2" class="text-center">No grades assigned</td>
                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                            `);
                }
            });

            // Handle View Subjects Button Click
            $('.view-subjects-btn').click(function () {
                let subjects = $(this).data('subjects');  // This is an array of subjects

                $('#subjectsList').empty();

                if (subjects.length > 0) {
                    subjects.forEach(function (subject) {
                        $('#subjectsList').append(`<li class="list-group-item">${subject}</li>`);
                    });
                } else {
                    $('#subjectsList').append('<li class="list-group-item">No subjects enrolled</li>');
                }
            });
        });
    </script>
@endsection