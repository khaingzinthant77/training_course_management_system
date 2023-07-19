@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <form action="{{ route('attendance.store') }}" method="POST" class="col-md-12 row" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6 offset-md-3">

                    <div>
                        <h1 class="h4 text-gray-900 mb-4 text-center">Attendance Form</h1>
                    </div>
 
                    <div class="form-group">
                        <label for="name">Student Name</label>
                        <select class="form-control @error('std_id') is-invalid @enderror select2" name="std_id"
                            id="std_id">
                            <option value="">Select Student</option>
                            @foreach (students() as $key => $student)
                                <option value="{{ old('std_id', $student->id) }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('std_id')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Course</label>
                        <select class="form-control @error('course_id') is-invalid @enderror select2" name="course_id"
                            id="course_id">
                            <option value="">Select Course</option>
                            @foreach (courses() as $key => $course)
                                <option value="{{ old('course_id', $course->id) }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="name">Attendance Date/Time</label>
                        <input type="text" name="att_date" id="att_date"
                            class="form-control datepicker @error('att_date') is-invalid @enderror"
                            placeholder="{{ date('d-m-Y H:i') }}" value="{{ old('att_date', date('d-m-Y H:i')) }}">
                        @error('att_date')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="name">Attendance Status</label>
                        <select class="form-control @error('att_status') is-invalid @enderror" id="att_status"
                            name="att_status" name="att_status" id="att_status">
                            <option value="">Select Attendance Status</option>
                            <option value="{{ old('att_status', 1) }}">Present</option>
                            <option value="{{ old('att_status', 2) }}">Late</option>
                            <option value="{{ old('att_status', 3) }}">Leave</option>
                            <option value="{{ old('att_status', 0) }}">Absent</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label>Created By</label>
                        <select class="form-control" id="created_by" name="created_by">
                        @foreach(users() as $key=>$user)
                        <option value="{{$user->name}}" {{$user->name == auth()->user()->name ? 'selected' : ''}}>{{$user->name}}</option>
                        @endforeach
                    </select>
                    </div> -->
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('att_history') }}" class="btn btn-outline-primary btn-user btn-block">Go
                                Back</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-user btn-block">Create New</button>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "--Select--"
            });
            $(".datepicker").flatpickr({
                dateFormat: "d-m-Y h:i",
                enableTime: true,
                minTime: "09:00"
            });
        });

        $('#std_id').on('change',function(){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo route('get_course'); ?>",
                method: 'POST',
                dataType: 'html',
                data: {
                    std_id: $(this).val(),
                    _token: token
                },
                success: function(data) {
                    $("select[name='course_id']").html(data);
                }
            });
        });

        $('#nrc_code').on('change', function() {
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
    </script>
@endsection
