@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Major Edit</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('major.update', $major->id) }}" method="POST" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $major->name) }}">
                        @error('name')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="order_no">Order No</label>
                        <input type="number" name="order_no" id="order_no"
                            class="form-control @error('order_no') is-invalid @enderror"
                            value="{{ old('order_no', $major->order_no) }}">
                        @error('order_no')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('major.index') }}" class="btn btn-outline-primary btn-user btn-block">Go
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
        $(document).ready(function() {

        });
    </script>
@endsection
