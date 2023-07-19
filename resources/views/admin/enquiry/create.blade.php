@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="card shadow mb-4 p-5">

    {{-- Create  --}}
    <div>
      <h1 class="h4 text-gray-900 mb-4">Student Form</h1>
    </div>
       <form action="{{route('students.store')}}" method="POST"  class="col-md-12 row" autocomplete="off" enctype="multipart/form-data">
        @csrf
          <div class="form-group col-md-6">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Mg Mg" value="{{old('name')}}">
          @error('section')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>
      
        <input type="hidden" name="is_enquiry" value="1">
        <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Date of Birth</label>
          <input type="text" name="dob" placeholder="{{date('d-m-Y')}}" class="form-control datepicker" autocomplete="off" value="{{old('dob',date('d-m-Y'))}}">
        </div>

         <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">NRC</label>
          <div class="row g-1">
            <div class="col-md-2">
                <select class="form-control select2 @error('nrc_code') is-invalid @enderror" id="nrc_code" name="nrc_code">
                @foreach(nrc_codes() as $key=>$nrc_code)
                <option value="{{$nrc_code->id}}">{{$nrc_code->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
               <select class="form-control select2 @error('nrc_state') is-invalid @enderror" id="nrc_state" name="nrc_state">
                 
                </select>
            </div>

            <div class="col-md-2">
              <select name="nrc_status" id="nrc_status" class="form-control @error('nrc_status') is-invalid @enderror">
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
             <input type="text" name="nrc" placeholder="NRC" class="form-control @error('nrc') is-invalid @enderror" autocomplete="off" value="{{old('nrc')}}">
           </div>
             
          </div>
         @error('nrc_code')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
          @error('nrc_state')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
          @error('nrc_status')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
          @error('nrc')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

        <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Father's Name</label>
          <input type="text" name="father_name" placeholder="U Mya" class="form-control @error('father_name') is-invalid @enderror" autocomplete="off" value="{{old('father_name')}}">
          @error('father_name')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

         <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Qualification</label>
          <input type="text" value="{{old('qualification')}}" name="qualification" placeholder="-" class="form-control" autocomplete="off">
        </div>

         <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Nationality</label>
          <input type="text" value="{{old('nationality')}}" name="nationality" placeholder="-" class="form-control" autocomplete="off">
          
        </div>

         <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Race</label>
          <input type="text" value="{{old('race')}}" name="religion" placeholder="-" class="form-control" autocomplete="off">
         
        </div>

         <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Phone</label>
          <input type="number" value="{{old('phone')}}" name="phone" placeholder="09XXXXXXXXX" class="form-control @error('phone') is-invalid @enderror" autocomplete="off">
          @error('phone')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>
         <div class="form-group col-md-6 col-lg-6 col-sm-6">
          <label for="name">Photo</label>
          <input type="file" value="{{old('photo')}}" name="photo" placeholder="" class="form-control">
          
        </div>

         <div class="form-group col-md-6 col-sm-6 col-lg-6">
          <label for="name">Contact Address</label>
          <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Pyinmana">{{old('address')}}</textarea>
          @error('address')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>


       
        <div class="col-md-6 col-lg-6 col-sm-6">
            <a href="{{route('enquiry')}}" class="btn btn-outline-primary btn-user btn-block">Go Back</a>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-6">
            <button type="submit"  class="btn btn-success btn-user btn-block">Create New</button>
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
