@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Section Create</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('time_tables.update', $timetable->id) }}" method="POST" class="col-md-6"
                    autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Section</label>
                        <select class="form-control @error('section') is-invalid @enderror" name="section">
                            <option value="">Select Section</option>
                            <option value="mon-to-thu" {{ $timetable->section == 'mon-to-thu' ? 'selected' : '' }}>Mon to
                                Thu</option>
                            <option value="sat-to-sun" {{ $timetable->section == 'sat-to-sun' ? 'selected' : '' }}>Sat to
                                Sun</option>
                        </select>
                        @error('section')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Duration</label>
                        <select name="duration" id="duration"
                            class="form-control select2 @error('duration') is-invalid @enderror ">
                            <option value="">Select Duration</option>
                            <option value="9:00 ~ 11:00 AM"
                                {{ $timetable->duration == '9:00 ~ 11:00 AM' ? 'selected' : '' }}>9:00 ~ 11:00 AM</option>
                            <option value="9:00 ~ 12:00 PM"
                                {{ $timetable->duration == '9:00 ~ 12:00 PM' ? 'selected' : '' }}>9:00 ~ 12:00 PM</option>
                            <option value="11:00 ~ 1:00 PM"
                                {{ $timetable->duration == '11:00 ~ 1:00 PM' ? 'selected' : '' }}>11:00 ~ 1:00 PM</option>
                            <option value="12:00 ~ 3:00 PM"
                                {{ $timetable->duration == '12:00 ~ 3:00 PM' ? 'selected' : '' }}>12:00 ~ 3:00 PM</option>
                            <option value="1:00 ~ 3:00 PM" {{ $timetable->duration == '1:00 ~ 3:00 PM' ? 'selected' : '' }}>
                                1:00 ~ 3:00 PM</option>
                            <option value="3:00 ~ 6:00 PM" {{ $timetable->duration == '3:00 ~ 6:00 PM' ? 'selected' : '' }}>
                                3:00 ~ 6:00 PM</option>
                            <option value="3:00 ~ 5:00 PM"
                                {{ $timetable->duration == '3:00 ~ 5:00 PM' ? 'selected' : '' }}>3:00 ~ 5:00 PM</option>
                            <option value="5:00 ~ 7:00 PM"
                                {{ $timetable->duration == '5:00 ~ 7:00 PM' ? 'selected' : '' }}>5:00 ~ 7:00 PM</option>
                        </select>
                        @error('duration')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="order_no">Order No</label>
                        <input type="number" name="order_no" id="order_no"
                            class="form-control @error('order_no') is-invalid @enderror"
                            value="{{ old('order_no', $timetable->order_no) }}">
                        @error('order_no')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('time_tables.index') }}"
                                class="btn btn-outline-primary btn-user btn-block">Go Back</a>
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
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Select Duration"
            });
        });
    </script>
@endsection
