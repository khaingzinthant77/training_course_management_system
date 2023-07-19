@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">{{$student_course->name}} Course Edit</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('student_course.update', $student_course->id) }}" method="POST" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    {{$student_course}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Course</label>
                            <select class="form-control" id="course_id" name="course_id">
                                <option value="">Select Course</option>
                                @foreach (courses() as $key => $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $student_course->course_id ? 'selected' : '' }}>{{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Course Fee</label>
                           <input type="text" id="course_fee" name="course_fee" class="form-control" value="" readonly placeholder="Course Fee Amount">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Discount Type</label>
                            <select class="form-control" id="discount" name="discount">
                                <option value="">None</option>
                                <option value="percentage">Percentage</option>
                                <option value="amount">Amount</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Discount Amount</label>
                            <input type="number" id="discount_amount"
                                class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Net Amount</label>
                            <input type="text" id="net_amount"
                                name="net_amount" class="form-control" value="" readonly
                                placeholder="Net Amount">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Payment Method</label>
                            <select name="payment_method" id="" class="form-control"
                                required>
                                <!-- <option value="">--Select--</option> -->
                                <option value="cash">Cash</option>
                                <option value="k-pay">KPay</option>
                                <option value="wave-pay">Wave Pay</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="student_id" id="student_id" value="{{ $student_course->student_id }}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Join Date</label>
                            <input type="text" name="join_date" class="form-control flatpickr"
                                value="{{ old('join_date', date('d-m-Y',strtotime($student_course->join_date))) }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Section Time</label>
                            <select class="form-control select2" id="time_table_id"
                                name="time_table_id" required>
                                <option value="">--Select Section Time--</option>
                                @foreach (timetables() as $timetable)
                                    <option value="{{ $timetable->id }}" {{$timetable->id == $student_course->time_table_id ? 'selected' : ''}}>
                                        {{ $timetable->section }} ({{ $timetable->duration }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Batch</label>
                            <select class="form-control" id="batch_id" name="batch_id">
                                <option value="">Select Batch</option>
                                @foreach (getBatch() as $key => $batch)
                                    <option value="{{ $batch->id }}" {{$batch->id == $student_course->batch_id ? 'selected' : ''}}>{{ $batch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('course.index') }}" class="btn btn-outline-primary btn-user btn-block">Go
                                Back</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-user btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
         $(".flatpickr").flatpickr({
            dateFormat: "d-m-Y",
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: '--Select--'
            });


            $('#major').select2({
                theme: 'bootstrap-5',
            });
           
            $(`#course_id`).on("change", function() {

                if (this.value == '') {
                    $(`#course_fee`).val('');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/get_course_fee/" + this.value,
                    success: function(response) {
                        // code to be executed if the request succeeds
                        if (response.status) {
                            $(`#course_fee`).val(response.fee);
                            $(`#discount_amount`).val('');
                            $(`#net_amount`).val(response.fee);
                        }
                    }
                });
            });

            $(`#discount_amount`).on("input", function() {
                if ($(`#course_fee`).val() == '' || $(`#discount`).val() == "") {
                    return;
                }

                let course_fee = $(`#course_fee`).val();
                let discount_type = $(`#discount`).val();
                let discount_amount = this.value;

                if (discount_type == "percentage") {
                    let net = course_fee * (discount_amount / 100);
                    let result = course_fee - net;

                    if (Math.sign(result) === -1) {
                        $(`#net_amount`).val(0);
                    } else {
                        $(`#net_amount`).val(result);
                    }
                }

                if (discount_type == "amount") {
                    let net = course_fee - discount_amount;


                    if (Math.sign(net) === -1) {
                        $(`#net_amount`).val(0);
                    } else {
                        $(`#net_amount`).val(net);
                    }
                }
            });

            $(`#discount`).on("change", function() {
                $(`#discount_amount`).val('');
            });

        });
    </script>
@endsection
