@extends('adminlte::page')

@section('title', 'Grades')

@section('content_header')
    <h1>List of Your Grades</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if($grades->isEmpty())
                <p class="text-center text-muted">No grades available.</p>
            @else
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Subject</th>
                            <th>Subject Code</th>
                            <th>Units</th>
                            <th>Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade['subject_name'] }}</td>
                                <td>{{ $grade['subject_code'] }}</td>
                                <td>{{ $grade['units'] }}</td>
                                <td>
                                    <span
                                        class="badge 
                                                                                                    {{ $grade['grade'] >= 3.00 ? 'bg-danger' : 'bg-success' }}">
                                        {{ number_format($grade['grade'], 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="{{ $grade['grade'] == 5.00 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                        {{ $grade['grade'] == 5.00 ? 'Failed' : 'Passed' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection