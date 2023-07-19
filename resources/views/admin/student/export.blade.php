<html>
    <head>
    </head>
    <body>
      <table class="table table-bordered styled-table ">
         <thead>
            <tr>
                <th>Student</th>
                <th>Phone No</th>
                <th>Course</th>
                <th>Section Time</th>
                <th>Join Date</th>
                <th>Attending Status</th>
            </tr>
          
         </thead>
       
         <tbody>
            @forelse ($students as $key => $student)
                {{-- Attending  Status Filter --}}
                @if ($attending_status != '')
                    @if (checkAttendingStatus($student->id, $attending_status))
                        @continue
                    @endif
                @endif

                {{-- Course Filter --}}
                @if ($course_id != '')
                    @if (!checkCourseFilter($student->id, $course_id))
                        @continue
                    @endif
                @endif


                {{-- Section Time  Filter --}}
                @if ($section_id != '')
                    @if (!checkSectionFilter($student->id, $section_id))
                        @continue
                    @endif
                @endif

                {{--  Batch  Filter --}}
                @if ($batch_id != '')
                    @if (!checkBatchFilter($batch_id, $student->id))
                        @continue
                    @endif
                @endif

                @php
                    $courses = getAttendingCourse($student->id);

                @endphp
                <tr>
                    <td rowspan="{{ count($courses) + 1 }}">
                        
                    </td>
                    <td rowspan="{{ count($courses) + 1 }}">
                        <div>{{ $student->phone_1 }}</div>
                        <div>{{ $student->phone_2 }}</div>
                    </td>
                </tr>
                @foreach ($courses as $course)
                <tr>
                    <td>
                        {{ $course->name }} {!! $course->is_foc == 1 ? '<span class="badge badge-rounded badge-primary">FOC</span>' : '' !!}

                    </td>
                    <td>{{ $course->section }} ({{ $course->duration }})</td>
                    <td>{{ date('d-m-Y', strtotime($course->join_date)) }}</td>
                    <td>
                        @if ($course->is_finished == '1')
                            <i style="font-size: 20px"
                                class="fa-solid fa-solid fa-file-certificate text-primary"></i>
                        @elseif($course->is_finished == '2')
                            <span class="badge badge-danger">Cancel</span>
                        @else
                            <span class="badge badge-success">Ongoing</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            @empty
            @endforelse
         </tbody>
      </table>
    </body>
</html>