@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            <div class="my-2">
                <a href="{{ route('enquiries.index') }}" class="btn btn-sm btn-primary">Go Back</a>
            </div>

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Enquiry Detail</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form class="col-md-12" autocomplete="off">


                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" readonly
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $enquiry->name) }}">
                            @error('name')
                                <div class="text-danger font-weight-bold">* {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="qualification">Qualification</label>
                            <select name="qualification" id="qualification" disabled
                                class="form-control select2 @error('qualification') is-invalid @enderror ">
                                <option value="">--Select--</option>
                                <option {{ $enquiry->qualification == 'kid' ? 'selected' : '' }} value="kid">Elementary
                                    Student</option>
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

                        <div class="form-group col-md-3">
                            <label for="phone_1">Phone Number </label>
                            <input type="number" name="phone_1" readonly value="{{ $enquiry->phone_1 }}"
                                class="form-control
                              @error('qualification') is-invalid @enderror">
                            @error('phone_1')
                                <div class="text-danger
                              font-weight-bold">* {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone_2">Phone Number (2)</label>
                            <input type="number" name="phone_2" readonly value="{{ $enquiry->phone_2 }}"
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
                        <div class="form-group col-md-3">
                            <label>Condition</label>
                            <select name="enquiry_status" id="" class="form-control" disabled>
                                <option {{ $enquiry->enquiry_status == 0 ? 'selected' : '' }} value="0">
                                    Pending</option>
                                <option {{ $enquiry->enquiry_status == 1 ? 'selected' : '' }} value="1">
                                    Student</option>
                                <option {{ $enquiry->enquiry_status == 2 ? 'selected' : '' }} value="2">
                                    Cancel</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Created By</label>
                            <input type="text" value="{{ $enquiry->c_by }}" readonly class="form-control">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name">Date</label>
                            <input type="text" readonly class="form-control"
                                value="{{ date('d-m-Y', strtotime($enquiry->created_at)) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="name">Time</label>
                            <input type="text" readonly class="form-control"
                                value="{{ date('H:i', strtotime($enquiry->created_at)) }}">
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Interested Courses</label>
                            <select name="course[]" id="course" disabled
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

                        <div class="form-group col-md-6">
                            <label>Interested Section Time</label>
                            <select name="time_table" id="time_table" disabled
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
                            <label>Remark</label>
                            <textarea readonly name="remark" id="" cols="10" rows="5" class="form-control">{{ $enquiry->remark }}</textarea>
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
