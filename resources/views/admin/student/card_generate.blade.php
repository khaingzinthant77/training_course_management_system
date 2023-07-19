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
      top:3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
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
        <span class="text-primary">Card Generate</span>
      </div>
     
    </div>
   <div class="d-flex my-2">
      @php
          $keyword = $_GET['keyword'] ?? '';
      @endphp
      <form action="" autocomplete="off">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{$keyword}}">
        </div>
      </form>
     </div>
    

    {{-- TABLE --}}
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead class="app-theme text-light">
              <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>Join Date</th>
                  <th>Course</th>
                  <th>Section</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
            @forelse ($student_has_courses as $key => $student)
            <tr>
              <td>{{++$i}}</td>
              <td>{{$student->name}}</td>
              <td>{{$student->phone_1}}</td>
              <th>{{date('d-m-Y',strtotime($student->join_date))}}</th>
              <td>{{$student->course_name}}</td>
              <td>{{$student->section}}({{$student->duration}})</td>
              <!-- <td>
                <label class="switch">
                  <input data-id="{{ $student->id }}" data-size="small" class="toggle-class"
                        type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                        data-on="Active" data-off="InActive" {{ $student->status ? 'checked' : '' }}>
                  <span class="slider round"></span>
                </label>
              </td> -->
              <td>
                <div class="mr-1">
                      <a href="{{ route('card_generate',$student->student_id) }}"
                          class="btn btn-sm app-theme text-light"><i class="fa-solid fa-address-card"></i></a>
                  </div>
              </td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" align="center">There is no data</td>
                </tr>
            @endforelse
          </tbody>
      </table>
      {!! $student_has_courses->appends(request()->input())->links() !!}


    </div>
  </div>
</div>
@endsection

@section('js')
  <script>
    function showmodal(std_id){
      $('#student_id').val(std_id);
      $("#course_modal").show();
    }

    $('#close_cross').on('click',function(){
        $("#course_modal").hide();
      });

      $('#restBtn').on('click',function(){
        $("#course_modal").hide();
      });

    $(document).ready(function(){

      $('.select2' ).select2( {
          theme: 'bootstrap-5',
          placeholder:"Select Duration"
    });

     
      let timerInterval
     
      // Success Alert
      @if (Session::has('success'))
        Swal.fire({
          title: 'Success',
          icon:'success',
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
            icon:'error',
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
            url: "{{url('student_change_status')}}",
            data: {
                'status': status,
                'id': id
            },
            success: function(response) {
                if(response.status) {

                  let timerInterval;
                  Swal.fire({
                    title: 'Success',
                    icon:'success',
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
                });
                }
            }
        });
    });



    });


  </script>
@endsection
