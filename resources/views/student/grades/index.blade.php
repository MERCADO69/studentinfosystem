@extends('adminlte::page')

@section('title', 'Grades')

@section('content_header')
    <h1>List of Your Grades</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Your Grades</h5>
        </div>
        <div class="card-body">
            @if($grades->isEmpty())
                <p class="text-center text-muted">No grades availabless.</p>
            @else
                <table class="table table-striped">
                    <thead class="table-dark">
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
                                <td>{{ $grade['grade'] }}</td>
                                <td>
                                    <span style="color: {{ $grade['grade'] == 5.00 ? 'red' : 'green' }}; font-weight: bold;">
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