@extends('layouts.master')

@section('content')
    <style>
        #mydob>.flatpickr-wrapper {
            width: 23rem;
        }
    </style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">Enquiry</span>
                </div>

                <div>
                    <a href="{{ route('enquiries.create') }}" class="btn btn-sm app-theme text-light"><i
                            class="fas fa-plus"></i>
                        Create New</a>
                </div>
            </div>

            <div class="row">
                <div class="my-2 col-md-6">
                    @php
                        $keyword = $_GET['keyword'] ?? '';
                        $from_date = $_GET['from_date'] ?? '';
                        $to_date = $_GET['to_date'] ?? '';
                        $qualification = $_GET['qualification'] ?? '';
                        $course_id = $_GET['course'] ?? '';
                        $time_table_id = $_GET['time_table'] ?? '';
                        $condition = $_GET['condition'] ?? '';
                        $cby = $_GET['cby'] ?? '';
                    @endphp
                    <form action="" class="col-md-4 p-0">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search" name="keyword"
                                value="{{ $keyword }}" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#filterModal"
                                    type="button"><i class="fa-solid fa-filter"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="my-2 col-md-6">
                    <a class="btn btn-success btn-sm" style="float:right;" id="export_btn">Export</a>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">More Filter...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Qualification</label>
                                        <select name="qualification" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            <option {{ $qualification == 'elementary-student' ? 'selected' : '' }}
                                                value="elementary-student">Elementary
                                                Student</option>
                                            <option {{ $qualification == 'grade-6' ? 'selected' : '' }} value="grade-6">
                                                Grade-6
                                            </option>
                                            <option {{ $qualification == 'grade-7' ? 'selected' : '' }} value="grade-7">
                                                Grade-7
                                            </option>
                                            <option {{ $qualification == 'grade-8' ? 'selected' : '' }} value="grade-8">
                                                Grade-8
                                            </option>
                                            <option {{ $qualification == 'grade-9' ? 'selected' : '' }} value="grade-9">
                                                Grade-9
                                            </option>
                                            <option {{ $qualification == 'grade-10' ? 'selected' : '' }} value="grade-10">
                                                Grade-10</option>
                                            <option {{ $qualification == 'grade-11' ? 'selected' : '' }} value="grade-11">
                                                Grade-11</option>
                                            <option {{ $qualification == 'grade-12' ? 'selected' : '' }} value="grade-12">
                                                Grade-12</option>
                                            <option {{ $qualification == 'college-student' ? 'selected' : '' }}
                                                value="college-student">College Student</option>
                                            <option {{ $qualification == 'graduated' ? 'selected' : '' }}
                                                value="graduated">
                                                Graduated</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Course</label>
                                        <select name="course" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse (courses() as $course)
                                                <option {{ $course_id == $course->id ? 'selected' : '' }}
                                                    value="{{ $course->id }}">{{ $course->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Section Time</label>
                                        <select name="time_table" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            <option value="any">Any Time</option>
                                            @forelse (timetables() as $timetable)
                                                <option {{ $time_table_id == $timetable->id ? 'selected' : '' }}
                                                    value="{{ $timetable->id }}">{{ $timetable->section }}
                                                    ({{ $timetable->duration }})
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Condition</label>
                                        <select name="condition" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            <option {{ $condition == '0' ? 'selected' : '' }} value="0">Pending
                                            </option>
                                            <option {{ $condition == '1' ? 'selected' : '' }} value="1">Student
                                            </option>
                                            <option {{ $condition == '2' ? 'selected' : '' }} value="2">Cancel
                                            </option>
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form action="{{ route('enquiry_export') }}" method="POST" id="excel_form">
                @csrf
                <input type="hidden" name="from_date" value="{{ $from_date }}">
                <input type="hidden" name="to_date" value="{{ $to_date }}">
                <input type="hidden" name="qualification" value="{{ $qualification }}">
                <input type="hidden" name="course_id" value="{{ $course_id }}">
                <input type="hidden" name="time_table_id" value="{{ $time_table_id }}">
                <input type="hidden" name="condition" value="{{ $condition }}">
            </form>

            <div>
                <span class="text-primary">TOTAL ENQUIRY : {{ $count }}</span>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Name</th>
                            <th>PhoneNo</th>
                            <th>Qualification</th>
                            <th>Interested Course</th>
                            <th>Section Time</th>
                            <th>Condition</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiries as $enquiry)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ date('d-m-Y', strtotime($enquiry->created_at)) }}</td>
                                <td>{{ date('H:i', strtotime($enquiry->created_at)) }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td>
                                    <div>{{ $enquiry->phone_1 }}</div>
                                    <div>{{ $enquiry->phone_2 }}</div>
                                </td>
                                <td>{{ strtoupper($enquiry->qualification) }}</td>
                                @php
                                    $courses = getCourseByEnquiry($enquiry->id);
                                @endphp
                                <td>
                                    @forelse ($courses as $course)
                                        <div class="my-1">
                                            {{ $course->name }}</div>
                                    @empty
                                    @endforelse
                                </td>
                                <td>
                                    @if ($enquiry->is_anytime)
                                        <span class="badge badge-primary">any-time</span>
                                    @else
                                        <div> {{ $enquiry->section }}</div>
                                        <div>({{ $enquiry->duration }})</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($enquiry->enquiry_status == 0)
                                        <span class="badge badge-primary">pending</span>
                                    @elseif($enquiry->enquiry_status == 1)
                                        <span class="badge badge-success">student</span>
                                    @elseif($enquiry->enquiry_status == 2)
                                        <span class="badge badge-danger">cancel</span>
                                    @else
                                    @endif
                                </td>
                                <td>{{ $enquiry->c_by }}</td>
                                <td>{{ $enquiry->u_by }}</td>
                                <td>{{ Illuminate\Support\Str::limit($enquiry->remark, 20) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            <a href="{{ route('enquiries.show', $enquiry->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="mr-1">
                                            <a href="{{ route('enquiries.edit', $enquiry->id) }}"
                                                class="btn btn-sm app-theme text-light"><i class="fas fa-edit"></i></a>
                                        </div>
                                        {{-- {{ dd($enquiry) }} --}}
                                        @if ($enquiry->enquiry_status != '1')
                                            <div class="mr-1">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#addStudentModal{{ $enquiry->id }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-user-plus"></i>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="mr-1">
                                            <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST"
                                                id="delete-form-{{ $enquiry->id }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" data-id="{{ $enquiry->id }}"
                                                    id="delete-btn-{{ $enquiry->id }}" class="btn btn-sm btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal" id="addStudentModal{{ $enquiry->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <!-- Modal content-->
                                    <form action="{{ route('add_to_student') }}" method="POST" autocomplete="off"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                                        <input type="hidden" name="dob" id="change_dob{{ $enquiry->id }}"
                                            value="">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> Add {{ $enquiry->name }} To Student List</h5>
                                                <button style="float:right;" type="button" id="close_cross"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body form-group">
                                                <div class="cus-border">

                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $enquiry->name }}" required>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Image (Optional)</label>
                                                            <input type="file" class="form-control-file"
                                                                name="file">
                                                        </div>


                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>Father Name</label>
                                                            <input type="text" name="father_name" placeholder="U Mya"
                                                                class="form-control @error('father_name') is-invalid @enderror"
                                                                autocomplete="off" value="{{ old('father_name') }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>DOB</label>
                                                            <div id="mydob">
                                                                <input type="text" name="dob" id="dob"
                                                                    data-id="{{ $enquiry->id }}"
                                                                    class="form-control dob" autocomplete="off"
                                                                    placeholder="{{ date('d-m-Y') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <div class="">
                                                                <label for="name">NRC</label>
                                                                <div class="row g-1">
                                                                    <div class="col-md-2">
                                                                        <select
                                                                            class="form-control select2 @error('nrc_code') is-invalid @enderror"
                                                                            id="nrc_code" name="nrc_code">
                                                                            <option value="">Select</option>
                                                                            @foreach (nrc_codes() as $key => $nrc_code)
                                                                                <option value="{{ $nrc_code->id }}">
                                                                                    {{ $nrc_code->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <select
                                                                            class="form-control select2 @error('nrc_state') is-invalid @enderror"
                                                                            id="nrc_state" name="nrc_state">

                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <select name="nrc_status" id="nrc_status"
                                                                            class="form-control @error('nrc_status') is-invalid @enderror">
                                                                            <option value="N" selected>N</option>
                                                                            <option value="P">P</option>
                                                                            <option value="E">E</option>
                                                                            <option value="A">A</option>
                                                                            <option value="F">F</option>
                                                                            <option value="TH">TH</option>
                                                                            <option value="G">G</option>
                                                                        </select>
                                                                    </div>


                                                                    <div class="col-md-5">
                                                                        <input type="text" name="nrc"
                                                                            placeholder="NRC"
                                                                            class="form-control @error('nrc') is-invalid @enderror"
                                                                            autocomplete="off"
                                                                            value="{{ old('nrc') }}">
                                                                    </div>

                                                                </div>
                                                                @error('nrc_code')
                                                                    <div class="text-danger font-weight-bold">*
                                                                        {{ $message }}</div>
                                                                @enderror
                                                                @error('nrc_state')
                                                                    <div class="text-danger font-weight-bold">*
                                                                        {{ $message }}</div>
                                                                @enderror
                                                                @error('nrc_status')
                                                                    <div class="text-danger font-weight-bold">*
                                                                        {{ $message }}</div>
                                                                @enderror
                                                                @error('nrc')
                                                                    <div class="text-danger font-weight-bold">*
                                                                        {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="phone_1">Phone Number </label>
                                                            <input type="number" name="phone_1" required
                                                                value="{{ $enquiry->phone_1 }}"
                                                                class="form-control
                                                                @error('qualification') is-invalid @enderror">
                                                            @error('phone_1')
                                                                <div
                                                                    class="text-danger
                                                                font-weight-bold">
                                                                    * {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="phone_2">Phone Number (2)</label>
                                                            <input type="number" name="phone_2"
                                                                value="{{ $enquiry->phone_2 }}"
                                                                class="form-control
                                                              @error('qualification') is-invalid @enderror">
                                                            @error('phone_2')
                                                                <div
                                                                    class="text-danger
                                                              font-weight-bold">
                                                                    * {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="qualification">Qualification</label>
                                                            <select name="qualification" id="qualification" required
                                                                class="form-control select2 @error('qualification') is-invalid @enderror ">
                                                                <option value="">--Select--</option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'elementary-student' ? 'selected' : '' }}
                                                                    value="elementary-student">Elementary
                                                                    Student</option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-6' ? 'selected' : '' }}
                                                                    value="grade-6">Grade-6
                                                                </option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-7' ? 'selected' : '' }}
                                                                    value="grade-7">Grade-7
                                                                </option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-8' ? 'selected' : '' }}
                                                                    value="grade-8">Grade-8
                                                                </option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-9' ? 'selected' : '' }}
                                                                    value="grade-9">Grade-9
                                                                </option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-10' ? 'selected' : '' }}
                                                                    value="grade-10">
                                                                    Grade-10</option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-11' ? 'selected' : '' }}
                                                                    value="grade-11">
                                                                    Grade-11</option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'grade-12' ? 'selected' : '' }}
                                                                    value="grade-12">
                                                                    Grade-12</option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'college-student' ? 'selected' : '' }}
                                                                    value="college-student">College Student</option>
                                                                <option
                                                                    {{ $enquiry->qualification == 'graduated' ? 'selected' : '' }}
                                                                    value="graduated">
                                                                    Graduated</option>
                                                            </select>
                                                            @error('qualification')
                                                                <div class="text-danger font-weight-bold">*
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Nationality</label>
                                                            <input type="text" name="nationality"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="name">Race</label>
                                                            <input type="text" value="{{ old('race') }}"
                                                                name="religion" placeholder="-" class="form-control"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="name">Student ID</label>
                                                            <input type="text" value="{{ old('student_id') }}"
                                                                name="religion" placeholder="ITXXXXXXX"
                                                                class="form-control" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="name">Contact Address</label>
                                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                                                placeholder="Pyinmana" rows="5">{{ old('address') }}</textarea>
                                                            @error('address')
                                                                <div class="text-danger font-weight-bold">*
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add To Student
                                                    List</button>
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
        {!! $enquiries->appends(request()->input())->links() !!}
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        $(".dob").flatpickr({
            dateFormat: "d-m-Y",
            static: true,
        });

        $(".dob").on("change", function() {
            let id = $(this).data('id');
            let dob = $(this).val();
            if (dob == '') {
                $(`#change_dob${id}`).val();
            } else {
                $(`#change_dob${id}`).val(dob);
            }


        });

        $('#export_btn').on('click', function() {
            $('#excel_form').submit();
        });

        $(document).ready(function() {

            $('.modal').on('change', '#nrc_code', function() {
                var code_id = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "<?php echo route('nrc_state'); ?>",
                    method: 'POST',
                    dataType: 'html',
                    data: {
                        code_id: code_id,
                        _token: token
                    },
                    success: function(data) {
                        $("select[name='nrc_state']").html(data);
                    }
                });
            });

            $('.select2').select2({
                theme: 'bootstrap-5',
            });

            $(".flatpickr").flatpickr({
                dateFormat: "d-m-Y",
            });




            let timerInterval

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('success') }}',
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
                    title: '{{ Session::get('error') }}',
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
            let enquiries = @json($enquiries);


            enquiries.data.forEach(data => {
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
