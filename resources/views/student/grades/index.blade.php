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
                                    <td>{{ number_format($grade['grade'], 2) }}</td>
                                    <td>
                                        @if($grade['grade'] == 5.00)
                                            <span class="text-danger fw-bold">Failed</span>
                                        @else
                                            <span class="text-success fw-bold">Passed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Calculate and Display Average --}}
                    <div class="text-center mt-3">
                        @php
                            // Calculate weighted average (assuming 'units' and 'grade' are numeric)
                            $totalUnits = 0;
                            $weightedGradeSum = 0;

                            foreach ($grades as $grade) {
                                $totalUnits += $grade['units'];
                                $weightedGradeSum += $grade['units'] * $grade['grade'];
                            }

                            $averageGrade = $totalUnits > 0 ? $weightedGradeSum / $totalUnits : 0;
                        @endphp


                    </div>
                    <h6 class="mt-3">
                        Average Grade: {{ number_format($averageGrade, 2) }}
                    </h6>
            @endif
        </div>
    </div>
@endsection