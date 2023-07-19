@extends('layouts.master')

@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 2px;
            bottom: 0px;
            top: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 36px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">Student List</span>
                </div>
                <div class="d-flex flex-row">
                    <a href="{{ route('students.create') }}" class="btn btn-sm app-theme text-light"><i
                            class="fas fa-plus"></i> Create New</a>&nbsp;

                </div>
            </div>
            <div class="row">
                <div class="col-md-6 my-2">
                    @php
                        $keyword = $_GET['keyword'] ?? '';
                        $from_date = $_GET['from_date'] ?? '';
                        $to_date = $_GET['to_date'] ?? '';
                        $course_id = $_GET['course_id'] ?? '';
                        $section_id = $_GET['section_id'] ?? '';
                        $attending_status = $_GET['attending_status'] ?? '';
                        $is_foc = $_GET['is_foc'] ?? '';
                        $batch_id = $_GET['batch'] ?? '';
                    @endphp
                    <form action="" autocomplete="off" class="col-md-4 p-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="keyword"
                                value="{{ $keyword }}">
                            <input type="hidden" value="{{ $from_date }}" name="from_date">
                            <input type="hidden" value="{{ $to_date }}" name="to_date">
                            <input type="hidden" value="{{ $course_id }}" name="course_id">
                            <input type="hidden" value="{{ $section_id }}" name="section_id">
                            <input type="hidden" value="{{ $is_foc }}" name="is_foc">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary " data-toggle="modal"
                                    data-target="#filter_modal" style="font-size: 13px"><i class="fa fa-filter"
                                        aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="my-2 col-md-6">
                    <a class="btn btn-success btn-sm" style="float:right;" id="export_btn">Export</a>
                </div>
            </div>


            <!-- Modal -->
            <div id="filter_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">More Filter</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">
                            <form action="{{ route('students.index') }}" method="get" accept-charset="utf-8"
                                class="form-horizontal unicode">
                                <div class="row form-group" id="adv_filter">

                                    <div class="col-md-6 form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control flatpickr"
                                            value="{{ old('from_date', $from_date) }}" placeholder="dd-mm-yyyy"
                                            autocomplete="off">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control flatpickr"
                                            value="{{ old('to_date', $to_date) }}" placeholder="dd-mm-yyyy"
                                            autocomplete="off">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Course</label>
                                        <select class="form-control" id="course_id" name="course_id">
                                            <option value="">Select Course</option>
                                            @foreach (courses() as $key => $course)
                                                <option value="{{ $course->id }}"
                                                    {{ $course->id == $course_id ? 'selected' : '' }}>{{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group">
                                        <label>Section</label>
                                        <select class="form-control select2" id="section_id" name="section_id">
                                            <option value="">Select Time</option>
                                            @foreach (timetables() as $key => $timetable)
                                                <option value="{{ $timetable->id }}"
                                                    {{ $timetable->id == $section_id ? 'selected' : '' }}>
                                                    {{ $timetable->section }} ({{ $timetable->duration }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Attending Status</label>
                                        <select class="form-control" id="attending_status" name="attending_status">
                                            <option value="">Select</option>
                                            <option {{ $attending_status == '1' ? 'selected' : '' }} value="1">
                                                Certificated</option>

                                            <option {{ $attending_status == '0' ? 'selected' : '' }} value="0">Ongoing
                                            </option>
                                            <option {{ $attending_status == '2' ? 'selected' : '' }} value="2">Cancel
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Is FOC</label>
                                        <select class="form-control" id="is_foc" name="is_foc">
                                            <option value="">Select</option>
                                            <option {{ $is_foc == '1' ? 'selected' : '' }} value="1">
                                                FOC</option>
                                            <option {{ $is_foc == '0' ? 'selected' : '' }} value="0">Not FOC
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Batch</label>
                                        <select class="form-control select2" id="batch" name="batch">
                                            <option value="">--Select--</option>
                                            @forelse (batches() as $batch)
                                                <option {{ $batch_id == $batch->id ? 'selected' : '' }}
                                                    value="{{ $batch->id }}">{{ $batch->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <input type="hidden" name="keyword" id="keyword" value="{{ $keyword }}">

                                    <div class="col-md-12" align="center"
                                        style="justify-content: center;justify-content: center;">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-dismiss="modal">Cancel</button>

                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    </div>


                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>




            <form action="{{ route('excel_export') }}" method="POST" id="excel_form">
                @csrf
                <input type="hidden" name="from_date" value="{{ $from_date }}">
                <input type="hidden" name="to_date" value="{{ $to_date }}">
                <input type="hidden" value="{{ $course_id }}" name="course_id">
                <input type="hidden" value="{{ $section_id }}" name="section_id">
                <input type="hidden" name="attending_status" value="{{ $attending_status }}">
                <input type="hidden" value="{{ $is_foc }}" name="is_foc">
                <input type="hidden" value="{{ $batch_id }}" name="batch_id">
            </form>
            <div>
                <span class="text-primary">TOTAL STUDENT : {{ $count }}</span>
            </div>
            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>No</th>
                            <th>#</th>
                            <th>Student</th>
                            <th>Phone No</th>
                            <th>Course</th>
                            <th>Section Time</th>
                            <th>Join Date</th>
                            <th>Attending Status</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $key => $student)
                            @php
                                $courses = getAttendingCourse($student->id);
                            @endphp
                            <tr>
                                <td rowspan="{{ count($courses) + 1 }}">{{ ++$i }}</td>
                                <td rowspan="{{ count($courses) + 1 }}">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fa-solid fa-solid fa-gears"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" data-toggle="modal"
                                                data-target="#add_course_modal_{{ $student->id }}"
                                                onclick="getBatch({{ $student->id }})" href="#">Add
                                                Course</a>
                                            @if (count($courses) > 0)
                                                <a class="dropdown-item" onclick="showmodal({{ $student->id }})"
                                                    href="#">Generate Certificate</a>

                                                 <a class="dropdown-item" onclick="showprintmodal({{ $student->id }})"
                                                    href="#">Print Preview</a>

                                                <a class="dropdown-item"
                                                    href="{{ route('card_generate', $student->id) }}">Card Generate</a>

                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#cancelCourse{{ $student->id }}">Course Cancel</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>


                                <!-- Modal -->
                                <div class="modal fade" id="cancelCourse{{ $student->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Cancel Course For
                                                    {{ $student->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('cancelCourse', $student->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <select name="course_id" id="" class="form-control form-group"
                                                        required>
                                                        <option value="">--Select--</option>
                                                        @forelse(coursesByStudent($student->id) as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                    <textarea class="form-control" id="remark" name="remark" placeholder="Remark"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <td rowspan="{{ count($courses) + 1 }}">
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            @if ($student->photo != null)
                                                <img src="{{ asset('uploads/student_photo/' . $student->photo) }}"
                                                    style="width:50px;height:50px;" class="img-fluid">
                                            @else
                                                <img src="{{ asset('uploads/no_photo.jpeg') }}"
                                                    style="width:50px;height:50px;" class="img-fluid">
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('students.show', $student->id) }}" class="btn-link">
                                                {{ $student->name }}</a>
                                            <div>
                                                <small>{{ $student->studentID }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td rowspan="{{ count($courses) + 1 }}">
                                    <div>{{ $student->phone_1 }}</div>
                                    <div>{{ $student->phone_2 }}</div>
                                </td>
                                {{-- <td rowspan="{{ count($courses) + 1 }}" align="center">
                                    <button type="button" data-toggle="modal"
                                        data-target="#add_course_modal_{{ $student->id }}"
                                        class="btn btn-sm btn-block btn-outline-primary">
                                        Add Course
                                    </button>
                                </td>
                                <td rowspan="{{ count($courses) + 1 }}">
                                    <a class="btn btn-sm btn-block btn-outline-warning text-dark" id="certificate"
                                        onclick="showmodal({{ $student->id }})">Add Certificate</a>
                                </td> --}}

                                @forelse ($courses as $course)
                            <tr>
                                <td>
                                    {{ $course->name }} {!! $course->is_foc == 1 ? '<span class="badge badge-rounded badge-primary">FOC</span>' : '' !!}
                                    @php
                                        $batch = getBatchName($course->student_id, $course->course_id);
                                    @endphp
                                    <div>
                                        <small>{{ $batch ? $batch->name : '-' }}</small>
                                    </div>

                                </td>
                                <td>{{ $course->section }} ({{ $course->duration }})</td>
                                <td>{{ date('d-m-Y', strtotime($course->join_date)) }}</td>
                                <td>
                                    @if ($course->is_finished == '1')
                                        <i style="font-size: 20px"
                                            class="fa-solid fa-solid fa-file-certificate text-primary"></i>
                                    @elseif($course->is_finished == '2')
                                        <span class="badge badge-danger">Cancel</span>
                                    @else
                                        <span class="badge badge-success">Ongoing</span>
                                    @endif
                                </td>
                            </tr>

                        @empty
                        @endforelse

                        </tr>

                        {{-- MODAL --}}
                        <div class="modal" id="add_course_modal_{{ $student->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <form action="{{ route('add_course') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Course For {{ $student->name }}</h5>
                                            <button style="float:right;" type="button" id="close_cross"
                                                data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body form-group">

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Course</label>
                                                    <select class="form-control" id="course{{ $student->id }}"
                                                        name="course_id" required>
                                                        <option value="">--Select Course--</option>
                                                        @foreach (courses() as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Course Fee</label>
                                                    <input type="text" id="course_fee{{ $student->id }}"
                                                        name="course_fee" class="form-control" value="" readonly
                                                        placeholder="Course Fee Amount">
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Discount Type</label>
                                                    <select class="form-control" id="discount{{ $student->id }}"
                                                        name="discount">
                                                        <option value="">None</option>
                                                        <option value="percentage">Percentage</option>
                                                        <option value="amount">Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Discount Amount</label>
                                                    <input type="number" id="discount_amount{{ $student->id }}"
                                                        class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Net Amount</label>
                                                    <input type="text" id="net_amount{{ $student->id }}"
                                                        name="net_amount" class="form-control" value="" readonly
                                                        placeholder="Net Amount">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Payment Method</label>
                                                    <select name="payment_method" id="" class="form-control"
                                                        required>
                                                        <!-- <option value="">--Select--</option> -->
                                                        <option value="cash">Cash</option>
                                                        <option value="k-pay">KPay</option>
                                                        <option value="wave-pay">Wave Pay</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <input type="hidden" name="student_id" id="student_id"
                                                value="{{ $student->id }}">





                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Join Date</label>
                                                    <input type="text" name="join_date" class="form-control flatpickr"
                                                        value="{{ old('join_date', date('d-m-Y')) }}" required>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Section Time</label>
                                                    <select class="form-control select2" id="time_table_id"
                                                        name="time_table_id" required>
                                                        <option value="">--Select Section Time--</option>
                                                        @foreach (timetables() as $timetable)
                                                            <option value="{{ $timetable->id }}">
                                                                {{ $timetable->section }} ({{ $timetable->duration }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Batch</label>
                                                    <select class="form-control" id="batch_id" name="batch_id">
                                                        <option value="">Select Batch</option>
                                                        @foreach (getBatch() as $key => $batch)
                                                            <option value="{{ $batch->id }}">{{ $batch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- <div class="form-group col-md-6">
                                                                                            <label>Student ID</label>
                                                                                            <input type="text" class="form-control" name="studentID" id="studentID" required placeholder="ITXXXXXXX">
                                                                                        </div> -->
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label>Remark</label>
                                                    <textarea name="remark" id="" class="form-control" rows="5"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add Course</button>
                                        </div>
                                </form>
                            </div>

                        </div>
            </div>
        </div>

    @empty
        @endforelse
        </tbody>
        </table>
        {!! $students->appends(request()->input())->links() !!}

        <div class="modal" id="course_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Course...</h5>
                        {{-- <button style="float:right;" type="button" id="close_cross"
                            data-dismiss="modal">&times;</button> --}}
                    </div>
                    <div class="modal-body form-group">
                        <form action="{{ route('store_exam') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <div class="form-group">
                                <label>Course</label>
                                <select class="form-control" id="c_id" name="c_id" required>
                                    <option value="">--Select Course--</option>
                                    <!-- @foreach (courses() as $course)
    <option value="{{ $course->id }}">{{ $course->name }}</option>
    @endforeach -->
                                </select>
                            </div>
                            <input type="hidden" name="std_id" id="std_id">
                            <div class="form-group">
                                <label>Major</label>
                                <select class="form-control select2" id="major_id" name="major_id[]" multiple required>
                                    <option value="">Select Major</option>
                                    @foreach (majors() as $major)
                                        <option id="{{ $major->id }}" value="{{ $major->id }}">
                                            {{ $major->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" name="date" class="form-control flatpickr"
                                    placeholder="{{ date('d-m-Y') }}" value="{{ date('d-m-Y') }}">
                            </div>
                            <div class="form-group">
                                <label>Remark</label>
                                <textarea class="form-control" id="remark" name="remark"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Select Print Preview</label>
                                <select class="form-control" id="print_option" name="print_option">
                                    <option value="0">Without Photo</option>
                                    <option value="1">With Photo</option>
                                </select>
                            </div>
                            <div style="display: flex;justify-content: center;margin-top: 20px;">
                                <button class="btn btn-secondary" id="restBtn" type="button">Cancel</button>&nbsp;
                                <button class="btn btn-success" type="submit" id="cust_save">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- priview_modal -->
        <div class="modal" id="priview_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Course...</h5>
                        {{-- <button style="float:right;" type="button" id="preview_close_cross"
                            data-dismiss="modal">&times;</button> --}}
                    </div>
                    <div class="modal-body form-group">
                        <form action="{{ route('print_preview') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <div class="form-group">
                                <label>Course</label>
                                <select class="form-control" id="preview_c_id" name="preview_c_id" required>
                                    <option value="">--Select Course--</option>
                                </select>
                            </div>
                            <input type="hidden" name="preview_std_id" id="preview_std_id">
                            <div class="form-group">
                                <label>Major</label>
                                <select class="form-control select2" id="preview_major_id" name="preview_major_id[]" multiple required>
                                    <option value="">Select Major</option>
                                    @foreach (majors() as $major)
                                        <option id="{{ $major->id }}" value="{{ $major->id }}">
                                            {{ $major->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" name="date" class="form-control flatpickr"
                                    placeholder="{{ date('d-m-Y') }}" value="{{ date('d-m-Y') }}">
                            </div>
                            <div class="form-group">
                                <label>Remark</label>
                                <textarea class="form-control" id="remark" name="remark"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Select Print Option</label>
                                <select class="form-control" id="print_option" name="print_option">
                                    <option value="0">Without Photo</option>
                                    <option value="1">With Photo</option>
                                </select>
                            </div>
                            <div style="display: flex;justify-content: center;margin-top: 20px;">
                                <button class="btn btn-secondary" id="preview_restBtn" type="button">Cancel</button>&nbsp;
                                <button class="btn btn-success" type="submit" id="cust_save">Preview</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


    </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        function showmodal(std_id) {
            $('#std_id').val(std_id);
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo route('get_course'); ?>",
                method: 'POST',
                dataType: 'html',
                data: {
                    std_id: std_id,
                    _token: token
                },
                success: function(data) {
                    $("select[name='c_id']").html(data);
                }
            });

            $("#course_modal").show();
        }

        function showprintmodal(std_id){
            $('#preview_std_id').val(std_id);
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo route('get_course'); ?>",
                method: 'POST',
                dataType: 'html',
                data: {
                    std_id: std_id,
                    _token: token
                },
                success: function(data) {
                    $("select[name='preview_c_id']").html(data);
                }
            });

            $("#priview_modal").show();
        }

        $('.ccourse').select2({
            theme: 'bootstrap-5',
        });


        $('#close_cross').on('click', function() {
            $("#course_modal").hide();
        });

        $('#restBtn').on('click', function() {
            $("#course_modal").hide();
        });

        $('#preview_close_cross').on('click', function() {
            $("#course_modal").hide();
        });

        $('#preview_restBtn').on('click', function() {
            $("#priview_modal").hide();
        });
        

        $('#export_btn').on('click', function() {
            $('#excel_form').submit();
        });

        $('.select2').select2({
            theme: 'bootstrap-5',
        });

        $(".flatpickr").flatpickr({
            dateFormat: "d-m-Y",
        });

        function getBatch(student_id) {
            // alert(student_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/get_student_batch/" + student_id,
                success: function(data) {
                    $("select[name='batch_id']").html(data);
                }
            });
        }


        // add course 
        let students = @json($students);
        students.data.forEach(data => {
            // course change
            $(`#course${data.id}`).on("change", function() {

                if (this.value == '') {
                    $(`#course_fee${data.id}`).val('');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/get_course_fee/" + this.value,
                    success: function(response) {
                        // code to be executed if the request succeeds
                        if (response.status) {
                            $(`#course_fee${data.id}`).val(response.fee);
                            $(`#discount_amount${data.id}`).val('');
                            $(`#net_amount${data.id}`).val(response.fee);
                        }
                    }
                });
            });


            $(`#discount_amount${data.id}`).on("input", function() {
                if ($(`#course_fee${data.id}`).val() == '' || $(`#discount${data.id}`).val() == "") {
                    return;
                }

                let course_fee = $(`#course_fee${data.id}`).val();
                let discount_type = $(`#discount${data.id}`).val();
                let discount_amount = this.value;

                if (discount_type == "percentage") {
                    let net = course_fee * (discount_amount / 100);
                    let result = course_fee - net;

                    if (Math.sign(result) === -1) {
                        $(`#net_amount${data.id}`).val(0);
                    } else {
                        $(`#net_amount${data.id}`).val(result);
                    }
                }

                if (discount_type == "amount") {
                    let net = course_fee - discount_amount;


                    if (Math.sign(net) === -1) {
                        $(`#net_amount${data.id}`).val(0);
                    } else {
                        $(`#net_amount${data.id}`).val(net);
                    }
                }
            });

            $(`#discount${data.id}`).on("change", function() {
                $(`#discount_amount${data.id}`).val('');
            });

        });


        $(document).ready(function() {

            $('#c_id').on('change', function() {
                // alert('hi');
                var course_id = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "<?php echo route('get_major'); ?>",
                    method: 'POST',
                    dataType: 'html',
                    data: {
                        course_id: course_id,
                        _token: token
                    },
                    success: function(data) {
                        // $("select[name='major_id[]']").html(data);
                        // $("select[name='major_id[]']").html(data).trigger('change.select2');
                        let result = JSON.parse(data);


                        if (result.status) {
                            $("#major_id").val(result.data);
                            $('#major_id').select2({
                                theme: 'bootstrap-5',
                                placeholder: "--Select--"
                            });

                            let toRemove = result.rm;


                            toRemove.forEach(function(id) {
                                console.log(id);
                                $(`#${id}`).remove();
                            });
                        }

                    }
                });
            });

            $('#preview_c_id').on('change', function() {
                // alert('hi');
                var course_id = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "<?php echo route('get_major'); ?>",
                    method: 'POST',
                    dataType: 'html',
                    data: {
                        course_id: course_id,
                        _token: token
                    },
                    success: function(data) {
                        // $("select[name='major_id[]']").html(data);
                        // $("select[name='major_id[]']").html(data).trigger('change.select2');
                        let result = JSON.parse(data);


                        if (result.status) {
                            $("#preview_major_id").val(result.data);
                            $('#preview_major_id').select2({
                                theme: 'bootstrap-5',
                                placeholder: "--Select--"
                            });

                            let toRemove = result.rm;


                            toRemove.forEach(function(id) {
                                // console.log(id);
                                $(`#${id}`).remove();
                            });
                        }

                    }
                });
            });
            



            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "--Select--"
            });

            // $('#major_id').select2({
            //     theme: 'bootstrap-5',
            //     placeholder: "--Select--"
            // });


            let timerInterval

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: 'Success',
                    icon: 'success',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1000,
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
                    title: 'Error',
                    icon: 'error',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1000,
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

            // change status
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ url('student_change_status') }}",
                    data: {
                        'status': status,
                        'id': id
                    },
                    success: function(response) {
                        if (response.status) {

                            let timerInterval;
                            Swal.fire({
                                title: 'Success',
                                icon: 'success',
                                html: 'autoclose in <b></b> milliseconds.',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector(
                                        'b')
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
                            });
                        }
                    }
                });
            });

            // delete btn
            let students = @json($students);


            students.data.forEach(data => {
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
