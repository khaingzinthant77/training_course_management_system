@extends('layouts.master')

@section('content')
    <style>
    </style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div>
                <h1 class="h4 text-center text-gray-900 mb-4">{{ $batch->name }}</h1>
            </div>

            <div class="tab">

                <button class="tablinks active" onclick="openTab(event, 'batch_info')">Batch Info</button>
                <button class="tablinks" id="student" onclick="openTab(event, 'student_info')">Student
                    Info</button>
            </div>

            <div id="batch_info" class="tabcontent">
                <div class="table-responsive ">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="app-theme text-light">
                            <tr>
                                <th>Batch</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $batch->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($batch->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($batch->end_date)) }}</td>
                                <td> {{ getStudentCountByBatch($batch->id) }} / {{ $batch->max_students }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="student_info" class="tabcontent">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="app-theme text-light">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->studentID }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone_1 }}</td>
                                    <td>
                                        @if ($student->is_finished == '1')
                                            <span class="badge badge-success">Finished</span>
                                        @elseif($student->is_finished == '2')
                                            <span class="badge badge-danger">Cancel</span>
                                        @elseif($student->is_finished == '0')
                                            <span class="badge badge-primary">Ongoing</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-md-4 mt-2 p-0">
                <a href="{{ route('batch.index') }}" class="btn btn-primary">Go Back</a>
            </div>


        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#batch_info').show();

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";

        }

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "--Select--"
            });
            $(".datepicker").flatpickr({
                dateFormat: "d-m-Y",
            });



        });
    </script>
@endsection
