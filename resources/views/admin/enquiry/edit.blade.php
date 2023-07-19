@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="card shadow mb-4 p-5">

    {{-- Create  --}}
    <div>
      <h1 class="h4 text-gray-900 mb-4">Student Form</h1>
    </div>
       <form action="{{route('students.update',$student->id)}}" method="POST"  class="col-md-12 row" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('PUT')
          <div class="form-group col-md-6">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Mg Mg" value="{{old('name',$student->name)}}">
          @error('section')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>
        <input type="hidden" name="is_enquiry" value="1">
        <div class="form-group col-md-6">
          <label for="name">Date of Birth</label>
          <input type="text" name="dob" placeholder="{{date('d-m-Y')}}" class="form-control datepicker" autocomplete="off" value="{{old('dob',date('d-m-Y',strtotime($student->dob)))}}">
        </div>

         <div class="form-group col-md-6">
          <label for="name">NRC</label>
          <?php 
            $nrc_code = explode('/', $student->nrc);
           
            $nrc_state = explode('(',$nrc_code[1]);
            $nrc_state_id = $nrc_state[0];
            $nrc_status = explode(')',$nrc_state[1]);
            $nrc_status_id = $nrc_status[0];
            $nrc_no = $nrc_status[1];

           ?>
          <!-- <input type="text" name="nrc" placeholder="9/PAMANA(N)XXXXXX" class="form-control @error('nrc') is-invalid @enderror" autocomplete="off" value="{{old('nrc',$student->nrc)}}">
          @error('nrc')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror -->
          <div class="row g-1">
            <div class="col-md-2">
                <select class="form-control select2 @error('nrc_code') is-invalid @enderror" id="nrc_code" name="nrc_code">
                @foreach(nrc_codes() as $key=>$nrc_code)
                <option value="{{$nrc_code->id}}" {{$code_id == $nrc_code->id ? 'selected' : ''}}>{{$nrc_code->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
               <select class="form-control select2 @error('nrc_state') is-invalid @enderror" id="nrc_state" name="nrc_state">
                @foreach(nrcstate() as $key=>$nrc_state)
                 <option value="{{$nrc_state->name}}" {{$nrc_state->name == $nrc_state ? 'selected' : ''}}>{{$nrc_state->name}}</option>
                 @endforeach
                </select>
            </div>

            <div class="col-md-2">
              <select name="nrc_status" id="nrc_status" class="form-control @error('nrc_status') is-invalid @enderror">
                  <option value="N" {{$nrc_state_id == 'N' ? 'selected' : ''}}>N</option>
                  <option value="P" {{$nrc_state_id == 'P' ? 'selected' : ''}}>P</option>
                  <option value="E" {{$nrc_state_id == 'E' ? 'selected' : ''}}>E</option>
                  <option value="A" {{$nrc_state_id == 'A' ? 'selected' : ''}}>A</option>
                  <option value="F" {{$nrc_state_id == 'F' ? 'selected' : ''}}>F</option>
                  <option value="TH"{{$nrc_state_id == 'TH' ? 'selected' : ''}}>TH</option>
                  <option value="G" {{$nrc_state_id == 'G' ? 'selected' : ''}}>G</option>
              </select>
          </div>

           
           <div class="col-md-5">
             <input type="text" name="nrc" placeholder="NRC" class="form-control @error('nrc') is-invalid @enderror" autocomplete="off" value="{{old('nrc',$nrc_no)}}">
           </div>
             
          </div>
        </div>

        <div class="form-group col-md-6">
          <label for="name">Father's Name</label>
          <input type="text" name="father_name" placeholder="U Mya" class="form-control @error('father_name') is-invalid @enderror" autocomplete="off" value="{{old('father_name',$student->father_name)}}">
          @error('father_name')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

         <div class="form-group col-md-6">
          <label for="name">Qualification</label>
          <input type="text" value="{{old('qualification',$student->qualification)}}" name="qualification" placeholder="-" class="form-control" autocomplete="off">
        </div>

         <div class="form-group col-md-6">
          <label for="name">Nationality</label>
          <input type="text" value="{{old('nationality',$student->nationality)}}" name="nationality" placeholder="-" class="form-control" autocomplete="off">
          
        </div>

         <div class="form-group col-md-6">
          <label for="name">Race</label>
          <input type="text" value="{{old('race',$student->race)}}" name="religion" placeholder="-" class="form-control" autocomplete="off">
         
        </div>

         <div class="form-group col-md-6">
          <label for="name">Phone</label>
          <input type="number" value="{{old('phone',$student->phone)}}" name="phone" placeholder="09XXXXXXXXX" class="form-control @error('phone') is-invalid @enderror" autocomplete="off">
          @error('phone')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

        <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Photo</label>
          <input type="file" value="{{old('photo')}}" name="photo" placeholder="" class="form-control" value="{{$student->photo}}">

          <img src="{{asset('uploads/student_photo/'.$student->photo)}}" style="width:50px;height:50px;">
        </div>

         <div class="form-group col-md-6">
          <label for="name">Contact Address</label>
          <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Pyinmana">{{old('address',$student->address)}}</textarea>
          @error('address')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>
       
        <div class="col-md-6">
            <a href="{{route('enquiry')}}" class="btn btn-outline-primary btn-user btn-block">Go Back</a>
          </div>
          <div class="col-md-6">
            <button type="submit"  class="btn btn-success btn-user btn-block">Update</button>
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
          placeholder:"Select Duration"
    });
    $(".datepicker").flatpickr({
        dateFormat: "d-m-Y",
      });
  });
</script>
@endsection
