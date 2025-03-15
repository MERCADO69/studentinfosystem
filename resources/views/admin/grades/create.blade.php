@extends('adminlte::page')

@section('title', 'Add Grade')

@section('content_header')
    <h1>Add Grade</h1>
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
        <div class="card-body">
            <form action="{{ route('admin.grades.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="student_id">Select Student</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">Select Student</option>
                        @foreach($enrollments as $enrollment)
                            <option value="{{ $enrollment->student_id }}">
                                {{ $enrollment->student_id }} - {{ $enrollment->first_name }} {{ $enrollment->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject_id">List of Subjects</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        <option value="">Select Subject</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="grade">Add Grade</label>
                    <select name="grade" id="grade" class="form-control" required>
                        <option value="">Select Grade</option>
                        <option value="1.00">1.00</option>
                        <option value="1.25">1.25</option>
                        <option value="1.50">1.50</option>
                        <option value="1.75">1.75</option>
                        <option value="2.00">2.00</option>
                        <option value="2.25">2.25</option>
                        <option value="2.50">2.50</option>
                        <option value="2.75">2.75</option>
                        <option value="3.00">3.00</option>
                        <option value="5.00">5.00</option>
                    </select>
                </div>


            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('student_id').addEventListener('change', function () {
            const studentId = this.value;
            if (!studentId) {
                document.getElementById('subject_id').innerHTML = '<option value="">Select Subject</option>';
                return;
            }

            fetch(`/admin/get-student-subjects/${studentId}`)
                .then(response => response.json())
                .then(data => {
                    let subjectSelect = document.getElementById('subject_id');
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';

                    if (data.subjects.length === 0) {
                        subjectSelect.innerHTML += '<option value="" disabled>No subjects enrolled</option>';
                        return;
                    }

                    data.subjects.forEach(subject => {
                        let isDisabled = subject.has_grade ? 'disabled' : '';
                        let optionText = `${subject.subject_name} ${isDisabled ? '(Grade already added)' : ''}`;
                        subjectSelect.innerHTML += `<option value="${subject.id}" ${isDisabled}>${optionText}</option>`;
                    });
                });
        });
    </script>
@endsection