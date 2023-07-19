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

            <div class="d-flex my-2">
                @php
                    $keyword = $_GET['keyword'] ?? '';
                    $from_date = $_GET['from_date'] ?? date('d-m-Y');
                    $to_date = $_GET['to_date'] ?? date('d-m-Y');
                    $course_id = $_GET['course_id'] ?? '';
                    $section_id = $_GET['section_id'] ?? '';
                @endphp
                <form action="" autocomplete="off">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword"
                            value="{{ $keyword }}">
                        <input type="hidden" value="{{ $from_date }}" name="from_date">
                        <input type="hidden" value="{{ $to_date }}" name="to_date">
                        <input type="hidden" value="{{ $course_id }}" name="course_id">
                        <input type="hidden" value="{{ $section_id }}" name="section_id">

                        <button type="button" class="btn btn-warning " data-toggle="modal" data-target="#filter_modal"
                            style="font-size: 13px"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>

            <!-- Modal -->
            <div id="filter_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-md">

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
                                            <option value="">Select Section</option>
                                            @foreach (timetables() as $key => $timetable)
                                                <option value="{{ $timetable->id }}"
                                                    {{ $timetable->id == $section_id ? 'selected' : '' }}>
                                                    {{ $timetable->section }} ({{ $timetable->duration }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control datepicker"
                                            value="{{ old('from_date', $from_date) }}">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control datepicker"
                                            value="{{ old('to_date', $to_date) }}">
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


            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">TOTAL Students : {{ $count }}</span>
                </div>
                <div class="d-flex flex-row">
                    <a href="{{ route('enquiry_create') }}" class="btn btn-sm app-theme text-light"><i
                            class="fas fa-plus"></i> Create New</a>&nbsp;
                    <a class="btn btn-sm btn-info text-light" id="export_btn"><i class="fa-regular fa-file-excel"></i> Excel
                        Export</a>
                </div>
            </div>

            <form action="{{ route('excel_export') }}" method="POST" id="excel_form">
                @csrf
                <input type="hidden" name="from_date" value="{{ $from_date }}">
                <input type="hidden" name="to_date" value="{{ $to_date }}">
                <input type="hidden" value="{{ $course_id }}" name="course_id">
                <input type="hidden" value="{{ $section_id }}" name="section_id">
                <input type="hidden" name="is_enquiry" value="1">
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Phone No</th>
                            <!-- <th>Status</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $key => $student)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    @if ($student->photo != null)
                                        <img src="{{ asset('uploads/student_photo/' . $student->photo) }}"
                                            style="width:50px;height:50px;">
                                    @else
                                        <img src="{{ asset('uploads/no_photo.jpeg') }}" style="width:50px;height:50px;">
                                    @endif
                                </td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone }}</td>
                                <!--  <td>
                                <label class="switch">
                                  <input data-id="{{ $student->id }}" data-size="small" class="toggle-class"
                                        type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                        data-on="Active" data-off="InActive" {{ $student->status ? 'checked' : '' }}>
                                  <span class="slider round"></span>
                                </label>
                              </td> -->
                                <td>
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            <a href="{{ route('enquiry_edit', $student->id) }}"
                                                class="btn btn-sm app-theme text-light"><i class="fas fa-edit"></i></a>
                                        </div>

                                        <div class="mr-1">
                                            <a href="{{ route('enquiry_detail', $student->id) }}"
                                                class="btn btn-sm btn-primary text-light"><i class="fas fa-eye"></i></a>
                                        </div>


                                        <button type="button" class="btn btn-sm btn-info text-light"
                                            onclick="showmodal({{ $student->id }})"><i class="fas fa-plus"></i></button>

                                        <!-- <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-info text-light"><i class="fas fa-plus"></i></a> -->

                                        <form action="{{ route('enquiry_delete', $student->id) }}" method="POST"
                                            id="delete-form-{{ $student->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" data-id="{{ $student->id }}"
                                                id="delete-btn-{{ $student->id }}" class="btn btn-sm btn-danger ml-1"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">There is no data</td>
                            </tr>
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
                                <button style="float:right;" type="button" id="close_cross"
                                    data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body form-group">
                                <form action="{{ route('course_add') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <label>Join Date</label>
                                        <input type="text" name="join_date" class="form-control datepicker"
                                            value="{{ old('join_date', date('d-m-Y')) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Course</label>
                                        <select class="form-control" id="course" name="course_id" required>
                                            <option value="">--Select Course--</option>
                                            @foreach (courses() as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Course Fee</label>
                                        <input type="text" id="course_fee" name="course_fee" class="form-control"
                                            value="" readonly placeholder="Course Fee Amount">
                                    </div>


                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Discount Type</label>
                                            <select class="form-control" id="discount" name="discount" required>
                                                <option value="">None</option>
                                                <option value="percentage">Percentage</option>
                                                <option value="amount">Amount</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Discount Amount</label>
                                            <input type="number" id="discount_amount" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Net Amount</label>
                                        <input type="text" id="net_amount" name="net_amount" class="form-control"
                                            value="" readonly placeholder="Net Amount">
                                    </div>


                                    <input type="hidden" name="student_id" id="student_id">
                                    <div class="form-group">
                                        <label>Section Time</label>
                                        <select class="form-control select2" id="time_table_id" name="time_table_id"
                                            required>
                                            <option value="">--Select Section Time--</option>
                                            @foreach (timetables() as $timetable)
                                                <option value="{{ $timetable->id }}">{{ $timetable->section }}
                                                    ({{ $timetable->duration }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select name="payment_method" id="" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="cash">Cash</option>
                                            <option value="k-pay">KPay</option>
                                            <option value="wave-pay">Wave Pay</option>
                                        </select>
                                    </div>

                                    <div style="display: flex;justify-content: center;margin-top: 20px;">
                                        <button class="btn btn-secondary" id="restBtn"
                                            type="button">Cancel</button>&nbsp;
                                        <button class="btn btn-success" type="submit" id="cust_save">Save</button>
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
            $('#student_id').val(std_id);
            $("#course_modal").show();
        }

        $(".datepicker").flatpickr({
            dateFormat: "d-m-Y",
        });

        $('#close_cross').on('click', function() {
            $("#course_modal").hide();
        });

        $('#restBtn').on('click', function() {
            $("#course_modal").hide();
        });

        $('#export_btn').on('click', function() {
            $('#excel_form').submit();
        });

        $(document).ready(function() {

            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Section Time"
            });

            $("#course").on("change", function() {

                if (this.value == '') {
                    $("#course_fee").val('');
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
                            $("#course_fee").val(response.fee);
                            $("#discount_amount").val('');
                            $("#net_amount").val(response.fee);
                        }
                    }
                });
            });

            $("#discount_amount").on("input", function() {
                if ($("#course_fee").val() == '' || $("#discount").val() == "") {
                    return;
                }

                let course_fee = $("#course_fee").val();
                let discount_type = $('#discount').val();
                let discount_amount = this.value;

                if (discount_type == "percentage") {
                    let net = course_fee * (discount_amount / 100);
                    let result = course_fee - net;

                    if (Math.sign(result) === -1) {
                        $("#net_amount").val(0);
                    } else {
                        $("#net_amount").val(result);
                    }
                }

                if (discount_type == "amount") {
                    let net = course_fee - discount_amount;


                    if (Math.sign(net) === -1) {
                        $("#net_amount").val(0);
                    } else {
                        $("#net_amount").val(net);
                    }
                }
            });

            $("#discount").on("change", function() {
                $("#discount_amount").val('');
            });


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
