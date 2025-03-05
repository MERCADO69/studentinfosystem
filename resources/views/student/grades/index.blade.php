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
                                        @if($grade['grade'] === null || $grade['grade'] === 0.00)
                                            <span class="text-muted">N/A</span>
                                        @else
                                            {{ number_format((float) $grade['grade'], 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($grade['grade'] === null)
                                            <span class="text-muted fw-bold">No Grade</span>
                                            <!-- Show "No Grade" if no grade is assigned -->
                                        @elseif($grade['grade'] == 5.00)
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
                            $totalUnits = 0;
                            $weightedGradeSum = 0;
                            $gradedSubjects = 0;

                            foreach ($grades as $grade) {
                                // Only include subjects with valid grades (greater than 0.00)
                                if ($grade['grade'] !== null && $grade['grade'] > 0) {
                                    $totalUnits += (float) $grade['units'];
                                    $weightedGradeSum += (float) $grade['units'] * (float) $grade['grade'];
                                    $gradedSubjects++;
                                }
                            }

                            $averageGrade = $gradedSubjects > 0 ? $weightedGradeSum / $totalUnits : 0;
                        @endphp
                    </div>
                    <h6 class="mt-3">
                        Average Grade: {{ number_format((float) $averageGrade, 2) }}
                    </h6>
            @endif
        </div>
    </div>
@endsection