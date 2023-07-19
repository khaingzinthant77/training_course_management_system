@extends('layouts.master')


@section('content')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}

            <div>
                <h1 id="test" class="h4 text-gray-900 mb-4">Student Detail</h1>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <div class="mr-1">
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm app-theme text-light"><i
                            class="fas fa-edit"></i></a>
                </div>
                 <form action="{{ route('students.destroy', $student->id) }}" method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')

                    <button type="button" data-id="{{ $student->id }}" id="delete-btn" class="btn btn-sm btn-danger"><i
                            class="fas fa-trash"></i></button>
                </form>
               
            </div>

            <div class="tab">
                <button class="tablinks" id="student" onclick="openTab(event, 'student_info')" active>Student
                    Information</button>

                <button class="tablinks" onclick="openTab(event, 'course')">Course</button>

                <button class="tablinks" onclick="openTab(event, 'attendance')">Attendance</button>
            </div>

            <div id="student_info" class="tabcontent">
                <div style="justify-content: center;align-items: center;display: flex;">
                    @if ($student->photo != null)
                        <img src="{{ asset('uploads/student_photo/' . $student->photo) }}" style="width:100px;height:100px;"
                            class="img-thumbnail img-fluid mb-4">
                    @endif
                </div>
                <div class="row form-group">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Mg Mg"
                            value="{{ old('name', $student->name) }}" readonly>
                        @error('section')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="name">Date of Birth</label>
                        <input type="text" name="dob" placeholder="{{ date('d-m-Y') }}"
                            class="form-control datepicker" autocomplete="off"
                            value="{{ old('dob', date('d-m-Y', strtotime($student->dob))) }}" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">NRC</label>
                        <input type="text" name="nrc" placeholder="9/PAMANA(N)XXXXXX"
                            class="form-control @error('nrc') is-invalid @enderror" autocomplete="off"
                            value="{{ old('nrc', $student->nrc) }}" readonly>
                        @error('nrc')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Father's Name</label>
                        <input type="text" name="father_name" placeholder="U Mya"
                            class="form-control @error('father_name') is-invalid @enderror" autocomplete="off"
                            value="{{ old('father_name', $student->father_name) }}" readonly>
                        @error('father_name')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Qualification</label>
                        <input type="text" value="{{ old('qualification', $student->qualification) }}"
                            name="qualification" placeholder="-" class="form-control" autocomplete="off" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Nationality</label>
                        <input type="text" value="{{ old('nationality', $student->nationality) }}" name="nationality"
                            placeholder="-" class="form-control" autocomplete="off" readonly>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Phone</label>
                        <input type="number" value="{{ old('phone', $student->phone_1) }}" name="phone"
                            placeholder="09XXXXXXXXX" class="form-control @error('phone') is-invalid @enderror"
                            autocomplete="off" readonly>
                        @error('phone')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Phone (2)</label>
                        <input type="number" value="{{ old('phone', $student->phone_2) }}" name="phone"
                            class="form-control @error('phone') is-invalid @enderror" autocomplete="off" readonly>
                        @error('phone')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Race</label>
                        <input type="text" value="{{ old('race', $student->race) }}" name="religion" placeholder="-"
                            class="form-control" autocomplete="off" readonly>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Contact Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" rows="5" id="address" name="address"
                            placeholder="Pyinmana" readonly>{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
            <div id="course" class="tabcontent">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Invoice ID</th>
                            <th>Course</th>
                            <th>Duration</th>
                            <th>Join Date</th>
                            <th>Attending Status</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($student_has_courses as $key => $course)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td><a href="{{ url('invoice?keyword='.$course->invoiceID) }}">{{ $course->invoiceID }}</a></td>
                                <td>{{ $course->course_name }}</td>
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
                                <td>
                                    {{$course->remark}}
                                </td>
                                <td>
                                    <div class="d-flex">
                                       <!--  <div class="mr-1">
                                            <a href="{{route('student_course_edit',$course->id)}}"
                                                class="btn btn-sm app-theme text-light"><i class="fas fa-edit"></i></a>
                                        </div> -->
                                        <form action="{{route('student_course_delete',$course->id)}}" id="{{$course->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                           <!--  <button type="submit" data-id="{{ $course->id }}"
                                                id="course-delete-btn-{{ $course->id }}" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button> -->
                                                    <button type="submit" onclick="handle_delete(event,{{$course->id}});" id="submit-btn" class="btn btn-sm btn-danger"><i
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
            </div>

            <div id="attendance" class="tabcontent">
                <div class="card shadow mb-4 p-0 py-3">
                    <div class="container-fluid d-flex justify-content-between p-0">
                        @php
                            $date = $_GET['date'] ?? '';
                        @endphp

                        <div class="col-md-10">
                            <form action="" id="my-form">
                                <div class="row">
                                    <div class="form-group col-md-2 mr-2">
                                        <input type="text" name="date" id="date" value="{{ $date }}"
                                            placeholder="{{ date('m-Y') }}" class="form-control datePicker"
                                            autocomplete="off">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>


                    {{-- TABLE --}}
                    <div class="table-responsive mt-4 p-3">
                        <table class="table table-bordered scroll" cellspacing="0">
                            <thead class="text-dark">
                                @php
                                    $i = 0;
                                @endphp
                                <tr>
                                    <th>No</th>
                                    <th class="c-w">Student Name</th>
                                    @forelse ($month as $day)
                                        <th
                                            @if ($day['string_day'] == 'Fri') style="background-color: #1067AC; color:#fff;" @endif>
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
            <div style="margin-top: 20px;">
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Select Duration"
            });

            $("#date").on('change', function() {
                $("#my-form").submit();
            });

            $(".datePicker").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });

            document.getElementById("student_info").style.display = "block";

            $("#student").addClass("active");
        });

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

        // delete btn
        // $(`#delete-btn`).on('click', function(e) {
        //     let id = $(`#delete-btn`).attr('data-id');
        //     // sweet alert
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You want to delete this?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.value) {
        //             $(`#delete-form`).submit();
        //         }
        //     })
        // });

        function handle_delete(event,id){
            // alert(id);
            event.preventDefault();
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // console.log(result.value);
                    if (result.value) {
                        $(`#${id}`).submit();
                    }
                })
        }
        
    </script>
@endsection
