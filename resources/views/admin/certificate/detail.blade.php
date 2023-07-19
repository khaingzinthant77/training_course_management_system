@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Detail  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Certificate Detail</h1>
            </div>
            <div class="d-flex justify-content-between">
                <div class="col-md-4 col-sm-4 col-lg-4">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" name="student_name" id="student_name" class="form-control" value="{{$certificates->name}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>NRC</label>
                        <input type="text" name="nrc" id="nrc" class="form-control" value="{{$certificates->nrc}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="text" name="dob" id="dob" class="form-control" value="{{date('d-m-Y',strtotime($certificates->dob))}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Phone1</label>
                        <input type="text" name="phone1" id="phone1" class="form-control" value="{{$certificates->phone_1}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Phone2</label>
                        <input type="text" name="phone2" id="phone2" class="form-control" value="{{$certificates->phone_2}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Father Name</label>
                        <input type="text" name="father_name" id="father_name" class="form-control" value="{{$certificates->father_name}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" id="address" name="address" readonly>{{$certificates->address}}</textarea>
                    </div>
                </div>
               
                <div class="col-md-4 col-sm-4 col-lg-4">
                    <div class="form-group">
                        <label>Taken Date</label>
                        @if($certificates->taken_date != null)
                        <input type="text" name="taken_date" id="taken_date" class="form-control" value="{{date('d-m-Y h:i A',strtotime($certificates->taken_date))}}" readonly>
                        @else
                        <input type="text" name="taken_date" id="taken_date" class="form-control" value="" readonly>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Taken By</label>
                        <input type="text" name="taken_by" id="taken_by" class="form-control" value="{{$certificates->taken_by}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Given By</label>
                        <input type="text" name="given_by" id="given_by" class="form-control" value="{{$certificates->given_by}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Remark</label>
                        <textarea class="form-control" id="remark" name="remark" readonly>{{$certificates->taken_remark}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Is Taken</label>
                        @if($certificates->is_taken == 0)
                        <span class="badge badge-pill text-light" style="background-color:orange;">No</span>
                        @else
                        <span class="badge badge-pill text-light" style="background-color:green;">Yes</span>
                        @endif
                    </div>
                </div>
                 <div class="col-md-4 col-sm-4 col-lg-4">
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" name="course" id="course" class="form-control" value="{{$certificates->course_name}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Majors</label>
                        <!-- <textarea class="form-control" id="major" name="major" readonly>@foreach($majors as $key=>$major){{$major->name}}@endforeach
                        </textarea> -->
                        <ul>
                            @foreach($majors as $key=>$major)
                            <li>{{$major->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div style="margin-top: 20px;">
                <a href="{{ route('certificates') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: '--Select--'
            });
        });
    </script>
@endsection
