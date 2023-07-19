@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">
            <span class="text-primary">Certificate History</span>
            <div class="row my-2">
                <div class="col-md-6">
                    @php
                    $keyword = $_GET['keyword'] ?? '';
                    $course_id = $_GET['course_id'] ?? '';
                  
                    @endphp
                    <form action="{{route('certificate_history')}}" autocomplete="off">
                        <div class="d-flex">
                            <div class="input-group col-md-3 col-sm-3 col-lg-3">
                            <input type="text" class="form-control" placeholder="Search" name="keyword"
                                value="{{ old('keyword',$keyword) }}">
                            </div>&nbsp;
                            <div class="input-group col-md-3 col-sm-3 col-lg-3">
                               <select class="form-control" id="course_id" name="course_id">
                                   <option value="">Select Course</option>
                                   @foreach(courses() as $key=>$course)
                                   <option value="{{$course->id}}" {{$course_id == $course->id ? 'selected' : ''}}>{{$course->name}}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm btn-success" id="export_btn" style="float:right;">Export</a>
                </div>
                
            </div>


            <form action="{{ route('history_export') }}" method="POST" id="excel_form">
                @csrf
               
                <input type="hidden" value="{{ $course_id }}" name="course_id">
               
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Phone No</th>
                            <th>Course</th>
                            <th>Print Date</th>
                            <th>Print By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificate_history as $key=>$history)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$history->name}}</td>
                            <td>
                                {{$history->phone_1}}
                                <br>
                                {{$history->phone_2}}
                            </td>
                            <td>{{$history->course_name}}</td>
                            <td>{{date('d-m-Y h:i A',strtotime($history->created_at))}}</td>
                            <td>{{$history->print_by}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                        
            </div>
        </div>

        </tbody>
        </table>
        {!! $certificate_history->appends(request()->input())->links() !!}
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        function showmodal(certificate_id) {
            $('#certificate_id').val(certificate_id);
            $("#taken_modal").show();
        }
        $('#restBtn').on('click', function() {
            $("#taken_modal").hide();
        });

        $('#export_btn').on('click', function() {
            $('#excel_form').submit();
        });

        $('.select2').select2({
            theme: 'bootstrap-5',
        });

        $(".datepicker").flatpickr({
            dateFormat: "d-m-Y H:i",
            enableTime:true,
            // minTime: "09:00"
        });

        $('#course_id').on('change',function(){
            this.form.submit();
        });

        $('#keyword').on('change',function(){
            this.form.submit();
        });

        $(document).ready(function() {

            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Section Time"
            });

            $('#major_id').select2({
                theme: 'bootstrap-5',
                placeholder: "Section Time"
            });

        });
    </script>
@endsection
