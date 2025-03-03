@extends('adminlte::page')

@section('title', 'Edit Subject')

@section('content_header')
    <h1>Edit Subject</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name"
                        value="{{ $subject->subject_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control" id="subject_code" name="subject_code"
                        value="{{ $subject->subject_code }}" required>
                </div>
                <div class="mb-3">
                    <label for="units" class="form-label">Units</label>
                    <input type="number" class="form-control" id="units" name="units" value="{{ $subject->units }}" min="1"
                        max="10" required>
                </div>

                <button type="submit" class="btn btn-success">Update Subject</button>

                <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection