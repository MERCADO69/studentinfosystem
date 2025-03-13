@extends('adminlte::page')

@section('title', 'Edit Student Grades')

@section('content_header')
    <h1>Add & Edit Grades for {{ $student->first_name }} {{ $student->last_name }}</h1>
    <a href="{{ route('admin.students.index') }}" class="text-secondary"
        style="text-decoration: underline !important; font-size: 1rem;">
        Back to Students
    </a>

@endsection


@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Student Information</h3>
        </div>
        <div class="card-body">
            <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
            <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
            <p><strong>Course:</strong> {{ $student->course }}</p>
            <p><strong>Year Level:</strong> {{ $student->year_level }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Current Grades</h3>
        </div>
        <div class="card-body">
            @if($grades->isEmpty())
                <p>No grades recorded for this student.</p>
            @else
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Subject</th>
                                        <th>Current Grade</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                        <tr>
                                            <td>{{ $grade->subject->subject_name }}</td>
                                            <td>
                                                <form action="{{ route('admin.grades.update', $grade->id) }}" method="POST"
                                                    class="d-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="grade" class="form-select form-select-sm">
                                                        @for($i = 1.00; $i <= 3.00; $i += 0.25)
                                                            @php 
                                                                $formattedGrade = number_format($i, 2); 
                                                            @endphp
                                                            <option value="{{ $formattedGrade }}" {{ $grade->grade == $i ? 'selected' : '' }}>{{ $formattedGrade }}
                                                            </option>
                                                        @endfor
                                                        <option value="5.00" {{ $grade->grade == 5.00 ? 'selected' : '' }}>5.00
                                                        </option></select>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-2">
                                                        <i class="fas fa-check"></i> Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <span
                                                    style="color: {{ $grade->grade == 5.00 ? 'red' : 'green' }}; font-weight: bold;">
                                                    {{ $grade->grade == 5.00 ? 'Failed' : 'Passed' }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.grades.destroy', $grade->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this grade?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Grade</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.grades.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">

                        <div class="form-group">
                            <label for="subject_id">Select Subject</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="">Select Subject</option>
                                @foreach($enrolledSubjects as $subject)
                                                            @php
                                                                $hasGrade = $grades->contains('subject_id', $subject->id);
                                                            @endphp
                                                            <option value="{{ $subject->id }}" {{ $hasGrade ? 'disabled' : '' }}>
                                                                {{ $subject->subject_name }} {{ $hasGrade ? '(Grade Already Exists)' : '' }}
                                                            </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <select name="grade" class="form-control">
                                <option value="" disabled selected>Select Grade</option>
                                @foreach(['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00', '5.00'] as $buksuGrade)
                                    <option value="{{ $buksuGrade }}">
                                        {{ $buksuGrade }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-start gap-3 mt-3">
                            <button type="submit" class="btn btn-success">Add Grade</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection