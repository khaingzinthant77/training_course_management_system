@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Course Edit</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('course.update', $course->id) }}" method="POST" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Course Title</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $course->name) }}">
                            @error('name')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Fee</label>
                            <input type="number" name="fee" id="fee"
                                class="form-control @error('fee') is-invalid @enderror"
                                value="{{ old('fee', $course->fee) }}">
                            @error('fee')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="duration">Duration</label>
                            <select name="duration" id="duration"
                                class="form-control select2 @error('duration') is-invalid @enderror ">
                                <option value="">--Select--</option>
                                <option {{ $course->duration == '1-week' ? 'selected' : '' }} value="1-week">One Week</option>
                                <option {{ $course->duration == '2-week' ? 'selected' : '' }} value="2-week">Two Weeks</option>
                                <option {{ $course->duration == '1-months' ? 'selected' : '' }} value="1-month">1 Month</option>
                                <option {{ $course->duration == '1.5-months' ? 'selected' : '' }} value="1.5-months">1.5
                                    Months</option>
                                <option {{ $course->duration == '2-months' ? 'selected' : '' }} value="2-months">2 Months
                                </option>
                                <option {{ $course->duration == '3-months' ? 'selected' : '' }} value="3-months">3 Months
                                </option>
                                <option {{ $course->duration == '6-months' ? 'selected' : '' }} value="6-months">6 Months
                                </option>
                            </select>
                            @error('major')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="major">Include Subject</label>
                            <select name="major[]" id="major"
                                class="form-control select2 @error('major') is-invalid @enderror " multiple>
                                <option value="">--Select--</option>
                                @forelse($majors as $major)
                                    <option {{ $course->duration == '3-months' ? 'selected' : '' }}
                                        value="{{ $major->id }}">{{ $major->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('major')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
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
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: '--Select--'
            });

            $('#major').val(@json($course_has_majors));

            $('#major').select2({
                theme: 'bootstrap-5',
            });

        });
    </script>
@endsection
