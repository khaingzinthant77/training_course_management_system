@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Section Create</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('time_tables.store') }}" method="POST" class="col-md-6" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="name">Section</label>
                        <select class="form-control @error('section') is-invalid @enderror" name="section">
                            <option value="">Select Section</option>
                            <option value="mon-to-thu">Mon to Thu</option>
                            <option value="sat-to-sun">Sat to Sun</option>
                        </select>
                        @error('section')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Duration</label>
                        <select name="duration[]" id="duration"
                            class="form-control select2 @error('duration') is-invalid @enderror " multiple>
                            <option value="">Select Duration</option>
                            <option value="9:00 ~ 11:00 AM">9:00 ~ 11:00 AM</option>
                            <option value="9:00 ~ 12:00 PM">9:00 ~ 12:00 PM</option>
                            <option value="11:00 ~ 1:00 PM">11:00 ~ 1:00 PM</option>
                            <option value="12:00 ~ 3:00 PM">12:00 ~ 3:00 PM</option>
                            <option value="1:00 ~ 3:00 PM">1:00 ~ 3:00 PM</option>
                            <option value="3:00 ~ 6:00 PM">3:00 ~ 6:00 PM</option>
                            <option value="3:00 ~ 5:00 PM">3:00 ~ 5:00 PM</option>
                            <option value="5:00 ~ 7:00 PM">5:00 ~ 7:00 PM</option>
                        </select>
                        @error('duration')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="order_no">Order No</label>
                        <input type="number" name="order_no" id="order_no"
                            class="form-control @error('order_no') is-invalid @enderror" value="{{ old('order_no') }}">
                        @error('order_no')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('time_tables.index') }}" class="btn btn-outline-primary btn-user btn-block">Go
                                Back</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-user btn-block">Create New</button>
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
