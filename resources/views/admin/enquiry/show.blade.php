@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="card shadow mb-4 p-5">

    {{-- Create  --}}
    
    <div>
      <h1 class="h4 text-gray-900 mb-4">Student Detail</h1>
    </div>
      <div class="tab">
          <button class="tablinks"  id="student" onclick="openTab(event, 'student_info')" active>Student Information</button>
         
      </div>
        
       <div id="student_info" class="tabcontent">
        <div style="justify-content: center;align-items: center;display: flex;">
          <img src="{{asset('uploads/student_photo/'.$student->photo)}}" style="width:100px;height:100px;">
        </div>
          <div class="row form-group">
              <div class="form-group col-md-6">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Mg Mg" value="{{old('name',$student->name)}}" readonly>
              @error('section')
              <div class="text-danger font-weight-bold">* {{$message}}</div>
              @enderror
            </div>
            
           <!--  <div class="form-group col-md-6">
              <label for="name">Start Date</label>
              <input type="text" name="start_date" placeholder="{{date('d-m-Y')}}" class="form-control datepicker @error('start_date') is-invalid @enderror" autocomplete="off" value="{{old('start_date',date('d-m-Y',strtotime($student->join_date)))}}" readonly>
              @error('start_date')
              <div class="text-danger font-weight-bold">* {{$message}}</div>
              @enderror
            </div> -->

            <div class="form-group col-md-6">
              <label for="name">Date of Birth</label>
              <input type="text" name="dob" placeholder="{{date('d-m-Y')}}" class="form-control datepicker" autocomplete="off" value="{{old('dob',date('d-m-Y',strtotime($student->dob)))}}" readonly>
            </div>

             <div class="form-group col-md-6">
              <label for="name">NRC</label>
              <input type="text" name="nrc" placeholder="9/PAMANA(N)XXXXXX" class="form-control @error('nrc') is-invalid @enderror" autocomplete="off" value="{{old('nrc',$student->nrc)}}" readonly>
              @error('nrc')
              <div class="text-danger font-weight-bold">* {{$message}}</div>
              @enderror
            </div>

            <div class="form-group col-md-6">
              <label for="name">Father's Name</label>
              <input type="text" name="father_name" placeholder="U Mya" class="form-control @error('father_name') is-invalid @enderror" autocomplete="off" value="{{old('father_name',$student->father_name)}}" readonly>
              @error('father_name')
              <div class="text-danger font-weight-bold">* {{$message}}</div>
              @enderror
            </div>

             <div class="form-group col-md-6">
              <label for="name">Qualification</label>
              <input type="text" value="{{old('qualification',$student->qualification)}}" name="qualification" placeholder="-" class="form-control" autocomplete="off" readonly>
            </div>

             <div class="form-group col-md-6">
              <label for="name">Nationality</label>
              <input type="text" value="{{old('nationality',$student->nationality)}}" name="nationality" placeholder="-" class="form-control" autocomplete="off" readonly>
              
            </div>

             <div class="form-group col-md-6">
              <label for="name">Race</label>
              <input type="text" value="{{old('race',$student->race)}}" name="religion" placeholder="-" class="form-control" autocomplete="off" readonly>
             
            </div>

             <div class="form-group col-md-6">
              <label for="name">Phone</label>
              <input type="number" value="{{old('phone',$student->phone)}}" name="phone" placeholder="09XXXXXXXXX" class="form-control @error('phone') is-invalid @enderror" autocomplete="off" readonly>
              @error('phone')
              <div class="text-danger font-weight-bold">* {{$message}}</div>
              @enderror
            </div>

             <div class="form-group col-md-6">
              <label for="name">Contact Address</label>
              <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Pyinmana" readonly>{{old('address',$student->address)}}</textarea>
              @error('address')
              <div class="text-danger font-weight-bold">* {{$message}}</div>
              @enderror
            </div>
           
          </div>
      </div>
      
    <div style="margin-top: 20px;">
      <a href="{{route('enquiry')}}" class="btn btn-sm btn-info">Back</a>
    </div>
  </div>
</div>

@endsection

@section('js')
<script>
  $(document).ready(function(){
    $('.select2' ).select2( {
          theme: 'bootstrap-5',
          placeholder:"Select Duration"
    });
    $(".datepicker").flatpickr({
        dateFormat: "d-m-Y",
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
</script>
@endsection
