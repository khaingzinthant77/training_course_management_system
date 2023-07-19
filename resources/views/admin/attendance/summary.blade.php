@extends('layouts.master')

@section('content')
    <style>
        table.scroll {
            overflow-x: scroll;
        }

        .c-w {
            min-width: 200px;
            max-width: 200px
        }
    </style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">
            <span class="text-primary">Attendance Summary</span>
            <div class="container-fluid d-flex justify-content-between  px-2 my-2">
                @php
                    $keyword = $_GET['keyword'] ?? '';
                    $time_table_id = $_GET['time_table'] ?? '';
                    $course_id = $_GET['course'] ?? '';
                @endphp

                <div class="col-md-10">
                    <form action="" id="my-form">
                        <div class="row">
                            <div class="form-group col-md-2 mr-2">
                                <input type="text" name="keyword" value="{{ $keyword }}" placeholder="keyword"
                                    class="form-control" autocomplete="off">
                            </div>

                            <div class="form-group col-md-3 mr-2">
                                <select name="course" id="course" class="form-control select2">
                                    <option value="">--Select--</option>
                                    @forelse (courses() as $course)
                                        <option {{ $course_id == $course->id ? 'selected' : '' }}
                                            value="{{ $course->id }}">
                                            {{ $course->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group col-md-3 mr-2">
                                <select name="time_table" id="time_table" class="form-control select2">
                                    <option value="">--Select--</option>
                                    @forelse (timetables() as $timetable)
                                        <option {{ $time_table_id == $timetable->id ? 'selected' : '' }}
                                            value="{{ $timetable->id }}">
                                            {{ $timetable->section }}
                                            ({{ $timetable->duration }})
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                    </form>
                </div>

                <div>
                    <form action="{{ route('att_summary_export') }}" id="excel-form" method="POST">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="keyword" value="{{ $keyword }}">
                        <input type="hidden" name="time_table_id" value="{{ $time_table_id }}">
                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                    </form>

                    <button type="button" id="export-btn" class="btn btn-warning">
                        <i class="fas fa-file-excel"></i> Excel Export
                    </button>
                </div>
            </div>


            {{-- TABLE --}}
            <div class="table-responsive mt-4">
                <table class="table table-bordered scroll" cellspacing="0">
                    <thead class="text-dark">
                        @php
                            $i = 0;
                        @endphp
                        <tr>
                            <th>No</th>
                            <th class="c-w">Student Name</th>
                            @forelse ($month as $day)
                                <th @if ($day['string_day'] == 'Fri') style="background-color: #1067AC; color:#fff;" @endif>
                                    <div>{{ $day['string_day'] }}</div>
                                    <div>{{ $day['number_day'] }}</div>
                                </th>
                            @empty
                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $student->name }}</td>
                                @forelse ($student->attendances as $attendance)
                                    @if ($attendance != '')
                                        @php
                                            if ($attendance->attendance_status == '1') {
                                                $status = '<i class="fa-solid fa-circle-check text-success" style="font-size: 25px;"></i>';
                                            }
                                            if ($attendance->attendance_status == '2') {
                                                $status = '<i class="fa-solid fa-circle-info text-warning" style="font-size: 25px;"></i>';
                                            }
                                            
                                            if ($attendance->attendance_status == '3') {
                                                $status = '<i class="fa-solid fa-circle-info text-primary" style="font-size: 25px;"></i>';
                                            }
                                            
                                            if ($attendance->attendance_status == '0') {
                                                $status = '<i class="fa-solid fa-solid fa-circle-xmark text-danger" style="font-size: 25px;"></i>';
                                            }
                                        @endphp
                                        <td>{!! $status !!}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @empty
                                @endforelse
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $("#export-btn").on('click', function() {
                $('#excel-form').submit();
            });

            $('#time_table').on('change', function() {
                $('#my-form').submit();
            });

            $('#course').on('change', function() {
                $('#my-form').submit();
            });

            $(".flatpickr").flatpickr({
                dateFormat: "d-m-Y",
            });

            $('.select2').select2({
                theme: 'bootstrap-5',
            });

            let timerInterval

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        success ') }}',
                    icon: 'success',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // console.log('I was closed by the timer')
                    }
                })
            @endif

            // Error Alert
            @if (Session::has('error'))
                Swal.fire({
                    title: '{{ Session::get('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        error ') }}',
                    icon: 'error',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // console.log('I was closed by the timer')
                    }
                })
            @endif

        });
    </script>
@endsection
