@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">Attendance History</span>
                </div>
                <div>
                    <a href="{{ route('attendance.create') }}" class="btn btn-sm app-theme text-light"><i
                            class="fas fa-plus"></i>
                        Create New</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="my-2">
                        @php
                            $keyword = $_GET['keyword'] ?? '';
                            $from_date = $_GET['from_date'] ?? '';
                            $to_date = $_GET['to_date'] ?? '';
                            $section_id = $_GET['section_id'] ?? '';
                            $course_id = $_GET['course_id'] ?? '';
                            $att_status = $_GET['att_status'] ?? '';
                        @endphp
                        <form action="" class="col-md-4 p-0">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search" name="keyword"
                                    value="{{ $keyword }}" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#filterModal" type="button"><i
                                            class="fa-solid fa-filter"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6">
                    <a class="btn btn-sm btn-success" id="export_btn" style="float:right;">Export</a>
                </div>
            </div>
            
            <form action="{{route('att_history_export')}}" id="excel_form" method="POST">
                @csrf
                <input type="hidden" name="from_date" value="{{$from_date}}">
                <input type="hidden" name="to_date" value="{{$to_date}}">
                <input type="hidden" name="section_id" value="{{$section_id}}">
                <input type="hidden" name="course_id" value="{{$course_id}}">
                <input type="hidden" name="att_status" value="{{$att_status}}">
            </form>
            <!-- Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">More Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Section</label>
                                        <select name="section_id" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse(timetables() as $time)
                                                <option {{ $section_id == $time->id ? 'selected' : '' }}
                                                    value="{{ $time->id }}">{{ $time->section }} ({{ $time->duration }})
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Course</label>
                                        <select name="course_id" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse(courses() as $course)
                                                <option {{ $course_id == $course->id ? 'selected' : '' }}
                                                    value="{{ $course->id }}">{{ $course->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" value="{{ $from_date }}"
                                            class="form-control flatpickr" autocomplete="off"
                                            placeholder="{{ date('d-m-Y') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" value="{{ $to_date }}"
                                            class="form-control flatpickr" autocomplete="off"
                                            placeholder="{{ date('d-m-Y') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Attending Status</label>
                                        <select class="form-control" id="att_status" name="att_status" name="att_status"
                                            id="att_status">
                                            <option value="">Select Attendance Status</option>
                                            <option value="1" {{ $att_status == '1' ? 'selected' : '' }}>Present
                                            </option>
                                            <option value="2" {{ $att_status == '2' ? 'selected' : '' }}>Late</option>
                                            <option value="3" {{ $att_status == '3' ? 'selected' : '' }}>Leave
                                            </option>
                                            <option value="0" {{ $att_status == '0' ? 'selected' : '' }}>Absent
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <span class="text-primary">TODAY ATTENDANCE : {{ getTodayAttCount() }}</span>
            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Phone</th>
                            <th>Section</th>
                            <th>Course</th>
                            <th>Attending Status</th>
                            <th>Attendance Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $attendance->student_name }}</td>
                                <td>{{ $attendance->phone }}</td>
                                <td>
                                    <div>{{ $attendance->duration }} <span class="text-primary">(
                                            {{ strtoupper($attendance->section) }} )</span>
                                    </div>
                                </td>
                                <td>{{ $attendance->course_name }}</td>
                                <td>
                                    @if ($attendance->attendance_status == '1')
                                        <span class="badge badge-pill text-light"
                                            style="background-color:green;">Present</span>
                                    @elseif($attendance->attendance_status == '2')
                                        <span class="badge badge-pill badge-warning text-dark">Late</span>
                                    @elseif($attendance->attendance_status == '3')
                                        <span class="badge badge-pill text-light"
                                            style="background-color:blue;">Leave</span>
                                    @else
                                        <span class="badge badge-pill text-light"
                                            style="background-color:red;">Absent</span>
                                    @endif
                                </td>
                                <td>{{ date('d-M-Y h:i A', strtotime($attendance->date)) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST"
                                            id="delete-form-{{ $attendance->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('attendance.edit', $attendance->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <button type="button" data-id="{{ $attendance->id }}"
                                                id="delete-btn-{{ $attendance->id }}" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {!! $attendances->appends(request()->input())->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $(".flatpickr").flatpickr({
                dateFormat: "d-m-Y",
            });

            $('.select2').select2({
                theme: 'bootstrap-5',
            });

            $('#export_btn').on('click',function(){
                $('#excel_form').submit();
            });

            let timerInterval

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('success ') }}',
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
                    title: '{{ Session::get('error ') }}',
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



            // delete btn
            let attendances = @json($attendances);


            attendances.data.forEach(data => {
                $(`#delete-btn-${data.id}`).on('click', function(e) {
                    let id = $(`#delete-btn-${data.id}`).attr('data-id');
                    // sweet alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $(`#delete-form-${id}`).submit();
                        }
                    })
                });
            });

        });
    </script>
@endsection
