<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Linn Training</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css">

    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dt.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style type="text/css">
        .wrapper {
            width: 100vw;
            height: 100vh;
            padding: 20px;
            /*position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;*/
        }

        img {
            width: 20rem;
            opacity: 0.9;
        }
    </style>
</head>

<body id="page-top">

    <div class="wrapper">
        <div class="row">

            <div class="col-md-4">
                <div id="backdrop">
                    <img src="{{ asset('images/logo.png') }}" alt="">
                    </div>
                    <form action="" method="GET" id="filter_form">
                        @csrf
                        <input type="hidden" name="c_id" id="c_id">
                        <input type="hidden" name="timetable_id" id="time_id">
                    </form>

                    <form action="{{ route('attendance_insert') }}" method="POST" id="form">
                            @csrf
                            @method('POST')
                        <div class="row form-group">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <select class="form-control" id="course_id" name="course_id">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{$c_id == $course->id ? 'selected' : ''}}>{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <select class="form-control" id="timetable_id" name="timetable_id">
                                    <option value="">Select Timetable</option>
                                    @foreach(timetables() as $timetable)
                                        <option value="{{$timetable->id}}" {{$time_id == $timetable->id ? 'selected' : ''}}>{{$timetable->duration}} ({{strtoupper($timetable->section)}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                            @php
                                $course_id = $_GET['course_id'] ?? '';
                                $timetable_id = $_GET['timetable_id'] ?? '';
                            @endphp

                            {{-- for testing --}}

                            <div class="input-group mb-3">
                                <input type="text" placeholder=" Attendance QR" class="form-control" name="student_id" autofocus
                                    autocomplete="off">
                            </div>
                        </form>

                    <div class="card p-3 bg-gray-100">
                        <table>
                            <tr style="text-align:center;">
                                <th>Total</th>
                                <th>Attendance</th>
                            </tr>
                            <tr style="text-align:center;">
                                <td>{{$student_total}}</td>
                                <td>{{$att_count}}</td>
                            </tr>
                        </table>
                    </div>
                   
            </div>
            <div class="col-md-8">
                <div class="my2">
                    <h4> Recently Attendances</h4>
                </div>
                {{-- TABLE --}}
                <div class="table-responsive p-3">
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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
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
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        

        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>


        <!-- Page level plugins -->
        {{-- <script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}"></script> --}}

        <!-- Page level custom scripts -->
        {{-- <script src="{{asset('admin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('admin/js/demo/chart-pie-demo.js')}}"></script> --}}

        {{-- Jquery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
            integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        {{-- Sweet Alert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('js/select2.full.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/dt.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
            $(document).ready(function() {

                $('#course_id').on('change',function(){
                    $('#c_id').val($(this).val());
                    $('#time_id').val($('#timetable_id').val());
                    // console.log($(this).val());
                    // console.log($('#filter_form'));
                    $('#filter_form').submit();
                });
                $('#timetable_id').on('change',function(){
                    $('#c_id').val($('#course_id').val());
                    $('#time_id').val($(this).val());
                    $('#filter_form').submit();
                });

               @if ($course_id != '')
                    // let id = @json($course_id);
                    // var course_name = $(`#${id}`).text();
                    // $('#dropdownMenuButton').text(course_name);
                    // $('#dropdownMenuButton').val(course_name);
                    // $("#course_id").val(id);
                $('#course_id').val(@json($course_id));
                @endif

                 @if ($timetable_id != '')
                    // let id = @json($course_id);
                    // var course_name = $(`#${id}`).text();
                    // $('#dropdownMenuButton').text(course_name);
                    // $('#dropdownMenuButton').val(course_name);
                    // $("#course_id").val(id);
                $('#timetable_id').val(@json($timetable_id));
                @endif



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
            });
        </script>

</body>

</html>
