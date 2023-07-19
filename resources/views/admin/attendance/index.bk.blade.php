@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="card shadow mb-4 p-3">

    <div class="d-flex justify-content-between mb-3">
      <div>
        <span class="text-primary">TODAY ATTENDANCE : {{$count}}</span>
      </div>
    </div>

    <div class="my-2">
      <form action="{{route('attendance_insert')}}" method="POST">
        @csrf 
        @method('POST')

        @php
            $course_id = $_GET['course_id'] ?? '';
        @endphp

        {{-- for testing --}}
        <input type="hidden" name="student_id" value="1">
        <input type="hidden" name="course_id" id="course_id" value="">

        <div class="input-group offset-md-4 col-md-4 mb-3">
          <input type="text" placeholder=" Attendance QR" class="form-control">
          <div class="input-group-append">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Course
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              @forelse($courses as $course)
              <a class="dropdown-item" id="{{$course->id}}" href="#" data-value="{{$course->id}}">{{$course->name}}</a>
              @empty
              @endforelse
            </div>
          </div>
        </div>
      </form>
    </div>

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
                  <th>Attendance Date</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$attendance->student_name}}</td>
                  <td>{{$attendance->phone}}</td>
                  <td>
                    <div>{{$attendance->duration}} <span class="text-primary">( {{strtoupper($attendance->section)}} )</span></div>
                  </td>
                  <td>{{$attendance->course_name}}</td>
                  <td>{{date('d-M-Y H:m',strtotime($attendance->date))}}</td>
                  <td>
                    <div class="d-flex">
                      <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST"
                          id="delete-form-{{ $attendance->id }}">
                          @csrf
                          @method('DELETE')
    
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
    $(document).ready(function(){

      @if($course_id != '')
      let id = @json($course_id);
      var course_name = $(`#${id}`).text();
        $('#dropdownMenuButton').text(course_name);
        $('#dropdownMenuButton').val(course_name);
        $("#course_id").val(id);
      @endif

      $('.dropdown-menu a').click(function() {
        var selectedValue = $(this).data('value');
        $('#dropdownMenuButton').text($(this).text());
        $('#dropdownMenuButton').val(selectedValue);
        $("#course_id").val(selectedValue);
      });
     
      let timerInterval
     
      // Success Alert
      @if (Session::has('success'))
        Swal.fire({
          title: '{{Session::get('success')}}',
          icon:'success',
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
            title: '{{Session::get('error')}}',
            icon:'error',
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
