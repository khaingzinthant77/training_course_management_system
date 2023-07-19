@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Enquiry Edit</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('enquiries.update', $enquiry->id) }}" method="POST" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $enquiry->name) }}">
                            @error('name')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="qualification">Qualification</label>
                            <select name="qualification" id="qualification"
                                class="form-control select2 @error('qualification') is-invalid @enderror ">
                                <option value="">--Select--</option>
                                <option {{ $enquiry->qualification == 'elementary-student' ? 'selected' : '' }}
                                    value="elementary-student">Elementary
                                    Student</option>
                                <option {{ $enquiry->qualification == 'grade-6' ? 'selected' : '' }} value="grade-6">Grade-7
                                </option>
                                <option {{ $enquiry->qualification == 'grade-7' ? 'selected' : '' }} value="grade-7">Grade-7
                                </option>
                                <option {{ $enquiry->qualification == 'grade-8' ? 'selected' : '' }} value="grade-8">Grade-8
                                </option>
                                <option {{ $enquiry->qualification == 'grade-9' ? 'selected' : '' }} value="grade-9">Grade-9
                                </option>
                                <option {{ $enquiry->qualification == 'grade-10' ? 'selected' : '' }} value="grade-10">
                                    Grade-10</option>
                                <option {{ $enquiry->qualification == 'grade-11' ? 'selected' : '' }} value="grade-11">
                                    Grade-11</option>
                                <option {{ $enquiry->qualification == 'grade-12' ? 'selected' : '' }} value="grade-12">
                                    Grade-12</option>
                                <option {{ $enquiry->qualification == 'college-student' ? 'selected' : '' }}
                                    value="college-student">College Student</option>
                                <option {{ $enquiry->qualification == 'graduated' ? 'selected' : '' }} value="graduated">
                                    Graduated</option>
                            </select>
                            @error('qualification')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="phone_1">Phone Number </label>
                            <input type="number" name="phone_1" value="{{ $enquiry->phone_1 }}"
                                class="form-control
                                @error('qualification') is-invalid @enderror">
                            @error('phone_1')
                                <div class="text-danger
                                font-weight-bold">* {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone_2">Phone Number (2)</label>
                            <input type="number" name="phone_2" value="{{ $enquiry->phone_2 }}"
                                class="form-control
                              @error('qualification') is-invalid @enderror">
                            @error('phone_2')
                                <div class="text-danger
                              font-weight-bold">* {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Interested Courses</label>
                            <select name="course[]" id="course"
                                class="form-control select2  @error('course') is-invalid @enderror" multiple>
                                <option value="">--Select--</option>
                                @forelse(courses() as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('course')
                                <div class="text-danger
                              font-weight-bold">* {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Interested Section Time</label>
                            <select name="time_table" id="time_table"
                                class="form-control select2  @error('time_table') is-invalid @enderror">
                                <option value="">--Select--</option>
                                <option {{ $enquiry->time_table_id == null ? 'selected' : '' }} value="any">Any Time
                                </option>
                                @forelse(timetables() as $section)
                                    <option {{ $enquiry->time_table_id == $section->id ? 'selected' : '' }}
                                        value="{{ $section->id }}">{{ $section->section }}
                                        ({{ $section->duration }})
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('time_table')
                                <div class="text-danger
                              font-weight-bold">* {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Condition</label>
                            <select name="enquiry_status" id="" class="form-control select2">
                                <option {{ $enquiry->enquiry_status == 1 ? 'selected' : '' }} value="1">
                                    Student</option>
                                <option {{ $enquiry->enquiry_status == 0 ? 'selected' : '' }} value="0">
                                    Pending</option>
                                <option {{ $enquiry->enquiry_status == 2 ? 'selected' : '' }} value="2">
                                    Cancel</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="form-group col-md-12">
                            <label>Enquiry By</label>
                            <select class="form-control" id="enquiry_by" name="enquiry_by">
                                @foreach (users() as $user)
                                    <option value="{{ $user->name }}"
                                        {{ $user->name == auth()->user()->name ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Remark</label>
                            <textarea name="remark" id="" cols="10" rows="5" class="form-control">{{ $enquiry->remark }}</textarea>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('enquiries.index') }}" class="btn btn-outline-primary btn-user btn-block">Go
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

            let ehc = @json($enquiry_has_courses);
            $("#course").val(ehc);

            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: '--Select--'
            });
        });
    </script>
@endsection
