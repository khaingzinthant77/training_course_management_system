@extends('layouts.master')

@section('content')
<style type="text/css">
    tbody > tr {
    cursor: pointer;
}
</style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">
            <div>
                <span class="text-primary">Certificate</span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @php
                    $keyword = $_GET['keyword'] ?? '';
                    $course_id = $_GET['course_id'] ?? '';
                    $is_taken = $_GET['is_taken'] ?? '';
                @endphp
                <form action="{{route('certificates')}}" autocomplete="off">
                    <div class="d-flex">
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword"
                            value="{{ old('keyword',$keyword) }}">
                        </div>&nbsp;
                        <div class="input-group">
                           <select class="form-control" id="course_id" name="course_id">
                               <option value="">Select Course</option>
                               @foreach(courses() as $key=>$course)
                               <option value="{{$course->id}}" {{$course_id == $course->id ? 'selected' : ''}}>{{$course->name}}</option>
                               @endforeach
                           </select>
                        </div>&nbsp;
                        <div class="input-group">
                           <select class="form-control" id="is_taken" name="is_taken">
                               <option value="">Is Taken</option>
                               <option value="0" {{$is_taken == "0" ? 'selected' : ""}}>Pending</option>
                               <option value="1" {{$is_taken == "1" ? 'selected' : ""}}>Taken</option>
                           </select>
                        </div>
                    </div>
                    
                </form>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm btn-success" id="export_btn" style="float: right;">Export</a>
                </div>
            </div>


            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">TOTAL : {{ $count }}</span>
                </div>
                <div class="d-flex flex-row">
                  
                 <!--    <a class="btn btn-sm btn-info text-light" id="export_btn"><i class="fa-regular fa-file-excel"></i> Excel
                        Export</a> -->
                </div>
            </div>

            <form action="{{ route('certificate_export') }}" method="POST" id="excel_form">
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
                            <th>Is Taken</th>
                            <th>Taken By</th>
                            <th>Taken Date</th>
                            <th>Given By</th>
                            <th>Generate By</th>
                            <th>Generate Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $key=>$certificate)
                        <tr >
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{++$i}}</td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{$certificate->name}}</td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{$certificate->phone_1}} <br> {{$certificate->phone_2}}</td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{$certificate->course_name}}</td>
                            <td style="text-align: center;">
                                @if($certificate->is_taken == 0)
                                <a class="btn btn-sm btn-block text-warning" id="certificate"
                                        onclick="showmodal({{ $certificate->id }})">
                                <i class="fa-solid fa-calendar-clock"></i>
                            </a> 
                                @else
                                <i class="fa-solid fa-circle-check text-success"></i>
                                @endif
                            </td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{$certificate->taken_by}}</td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">
                                @if($certificate->taken_date != null)
                                {{date('d-m-Y h:i A',strtotime($certificate->taken_date))}}
                                @endif
                            </td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{$certificate->given_by}}</td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{$certificate->generate_by}}</td>
                            <td onclick="window.location.href='/certificate_detail/{{$certificate->id}}';">{{date('d-m-Y h:i A',strtotime($certificate->created_at))}}</td>
                            <td>
                               

                                <form action="{{ route('certificate.destroy', $certificate->id) }}" method="POST"
                                    id="delete-form-{{ $certificate->id }}">
                                    @csrf
                                    @method('DELETE')
                                     <a class="btn btn-sm app-theme text-light" onclick="show_edit_modal({{ $certificate->id }})"><i
                                        class="fas fa-edit"></i></a>
                                    <button type="button" data-id="{{ $certificate->id }}"
                                        id="delete-btn-{{ $certificate->id }}" class="btn btn-sm btn-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal" id="edit_modal{{$certificate->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data...</h5>
                                        {{-- <button style="float:right;" type="button" id="close_cross"
                                            data-dismiss="modal">&times;</button> --}}
                                    </div>
                                    <div class="modal-body form-group">
                                        <form action="{{ route('update_certificate_taken') }}" method="POST" autocomplete="off">
                                            @csrf
                                            @method('POST')
                                            <div class="form-group">
                                                <label>Date</label>
                                                @if($certificate->taken_date != null)
                                                <input type="text" name="edit_taken_date" id="edit_taken_date" class="form-control datepicker" placeholder="{{date('d-m-Y H:i')}}" value="{{date('d-m-Y H:i',strtotime($certificate->taken_date))}}" required>
                                                @else
                                               <input type="text" name="edit_taken_date" id="edit_taken_date" class="form-control datepicker" placeholder="{{date('d-m-Y H:i')}}" value="{{date('d-m-Y H:i')}}" required>
                                               @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Taken By</label>
                                               <input type="text" name="edit_taken_by" id="edit_taken_by" class="form-control" placeholder="Student Name" value="{{$certificate->taken_by}}" required>
                                            </div>

                                            <input type="hidden" name="edit_id" id="edit_id" value="{{$certificate->id}}">
                                           
                                            <div class="form-group">
                                                 <label>Remark</label>
                                                 <textarea class="form-control" id="remark" name="remark">{{$certificate->taken_remark}}</textarea>
                                            </div>
                                            <div style="display: flex;justify-content: center;margin-top: 20px;">
                                                <button class="btn btn-secondary"onclick="hide_edit_modal({{ $certificate->id }})" id="edit_restBtn" type="button">Cancel</button>&nbsp;
                                                <button class="btn btn-success" type="submit" id="cust_save">Save</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
            </div>

            <div class="modal" id="taken_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Taken...</h5>
                        {{-- <button style="float:right;" type="button" id="close_cross"
                            data-dismiss="modal">&times;</button> --}}
                    </div>
                    <div class="modal-body form-group">
                        <form action="{{ route('certificate_taken') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>Date</label>
                               <input type="text" name="taken_date" id="taken_date" class="form-control datepicker" placeholder="{{date('d-m-Y H:i')}}" value="{{date('d-m-Y H:i')}}" required>
                            </div>

                            <div class="form-group">
                                <label>Taken By</label>
                               <input type="text" name="taken_by" id="taken_by" class="form-control" placeholder="Student Name" required>
                            </div>

                            <input type="hidden" name="certificate_id" id="certificate_id">
                           
                            <div class="form-group">
                                 <label>Remark</label>
                                 <textarea class="form-control" id="remark" name="remark"></textarea>
                            </div>
                            <div style="display: flex;justify-content: center;margin-top: 20px;">
                                <button class="btn btn-secondary" id="restBtn" type="button">Cancel</button>&nbsp;
                                <button class="btn btn-success" type="submit" id="cust_save">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        </div>

        </tbody>
        </table>
        {!! $certificates->appends(request()->input())->links() !!}
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

        function show_edit_modal(certificate_id){
             $("#edit_modal"+certificate_id).show();
        }

        $('#restBtn').on('click', function() {
            $("#taken_modal").hide();
        });

        function hide_edit_modal(certificate_id){
            $("#edit_modal"+certificate_id).hide();
        }


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

        $('#is_taken').on('change',function(){
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

         // delete btn
            let certificates = @json($certificates);


            certificates.data.forEach(data => {
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

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: 'Success',
                    icon: 'success',
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
                    icon: 'error',
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
    </script>
@endsection
