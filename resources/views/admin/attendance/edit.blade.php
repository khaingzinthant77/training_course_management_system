@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="card shadow mb-4 p-5">

    {{-- Create  --}}
    <div>
      <h1 class="h4 text-gray-900 mb-4">Attendance Form</h1>
    </div>
       <form action="{{route('attendance.update',$attendance->id)}}" method="POST"  class="col-md-12 row" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('PUT')
          <div class="form-group col-md-6">

          <div class="form-group">
            <label for="name">Student Name</label>
           <select class="form-control @error('std_id') is-invalid @enderror select2" name="std_id" id="std_id">
            <option value="">Select Student</option>
            @foreach(students() as $key=>$student)
             <option value="{{$student->id}}" {{$attendance->student_id == $student->id ? 'selected' : ''}}>{{$student->name}}</option>
            @endforeach
           </select>
            @error('std_id')
            <div class="text-danger font-weight-bold">* {{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="name">Course</label>
           <select class="form-control @error('course_id') is-invalid @enderror select2" name="course_id" id="course_id">
            <option value="">Select Course</option>
            @foreach(courses() as $key=>$course)
             <option value="{{$course->id}}" {{$attendance->course_id == $course->id ? 'selected' : ''}}>{{$course->name}}</option>
            @endforeach
           </select>
            @error('course_id')
            <div class="text-danger font-weight-bold">* {{$message}}</div>
            @enderror
          </div>
          

          <div class="form-group">
            <label for="name">Attendance Date/Time</label>
            <input type="text" name="att_date" id="att_date" class="form-control datepicker @error('att_date') is-invalid @enderror" placeholder="{{date('d-m-Y H:i')}}" value="{{old('att_date',date('d-m-Y h:i',strtotime($attendance->date)))}}">
            @error('att_date')
            <div class="text-danger font-weight-bold">* {{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="name">Attendance Status</label>
             <select class="form-control @error('att_status') is-invalid @enderror" id="att_status" name="att_status" name="att_status" id="att_status">

               <option value="">Select Attendance Status</option>
               <option value="1" {{$attendance->attendance_status == '1' ? 'selected' : ''}}>Present</option>
               <option value="2" {{$attendance->attendance_status == '2' ? 'selected' : ''}}>Late</option>
               <option value="3" {{$attendance->attendance_status == '3' ? 'selected' : ''}}>Leave</option>
               <option value="0" {{$attendance->attendance_status == '0' ? 'selected' : ''}}>Absent</option>
             </select>
          </div>
          <!-- <div class="form-group">
              <label>Updated By</label>
              <select class="form-control" id="updated_by" name="updated_by">
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
                <button type="submit" class="btn btn-success btn-user btn-block">Update</button>
            </div>
        </div>

        </div>
        
      </form>
  
  </div>
</div>

@endsection

@section('js')
<script>
  $(document).ready(function(){
    $('.select2' ).select2( {
          theme: 'bootstrap-5',
          placeholder:"--Select--"
    });
    $(".datepicker").flatpickr({
        dateFormat: "d-m-Y h:i",
        enableTime:true,
        minTime: "09:00"
      });
  });
  $('#nrc_code').on('change',function(){
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
