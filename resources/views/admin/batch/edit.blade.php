@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div>
                <h1 class="h4 text-gray-900 mb-4">Batch Edit</h1>
            </div>
            <form action="{{ route('batch.update', $batch->id) }}" method="POST" class="col-md-12 row" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Enter Batch Name"
                        value="{{ old('name', $batch->name) }}">
                    @error('name')
                        <div class="text-danger font-weight-bold">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-6 col-sm-6">
                    <label for="course">Course</label>
                    <select name="course" id=""
                        class="form-control select2  @error('course') is-invalid @enderror">
                        <option value="">--Select--</option>
                        @forelse (courses() as $course)
                            <option {{ $batch->course_id == $course->id ? 'selected' : '' }} value="{{ $course->id }}">
                                {{ $course->name }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('course')
                        <div class="text-danger font-weight-bold">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-6 col-sm-6 mb-4">
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date"
                        class="form-control datepicker  @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', date('d-m-Y', strtotime($batch->start_date))) }}">
                    @error('start_date')
                        <div class="text-danger font-weight-bold">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-6 col-sm-6">
                    <label for="max_students">Max Students</label>
                    <input type="number" name="max_students" value="{{ old('max_students', $batch->max_students) }}"
                        class="form-control @error('max_students') is-invalid @enderror">
                    @error('max_students')
                        <div class="text-danger font-weight-bold">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-6 col-sm-6 mb-5">
                    <label for="students">Students</label>
                    <select name="students[]" multiple
                        class="form-control select2Student
                        @error('students') is-invalid @enderror">
                        <option value="">--Select--</option>
                        @forelse (students() as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @empty
                        @endforelse

                    </select>
                    @error('students')
                        <div class="text-danger font-weight-bold">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-6 col-sm-6 mb-5">
                   <!--  <label for="u_by">Updated By</label>
                    <select name="u_by" id="" class="form-control select2">
                        @forelse (users() as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @empty
                        @endforelse
                    </select> -->
                </div>




                <div class="col-md-6 col-lg-6 col-sm-6">
                    <a href="{{ route('batch.index') }}" class="btn btn-outline-primary btn-user btn-block">Go
                        Back</a>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6">
                    <button type="submit" class="btn btn-success btn-user btn-block">Update</button>
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
                dateFormat: "d-m-Y",
            });

            $('.select2Student').val(@json($student_ids));

            $('.select2Student').select2({
                theme: 'bootstrap-5',
                placeholder: "--Select--"
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
    </script>
@endsection
