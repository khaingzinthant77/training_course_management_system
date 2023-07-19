<html>
    <head>
    </head>
    <body>
      <table class="table table-bordered styled-table ">
         <thead>
            <tr>
               <th>Student</th>
                <th>Phone</th>
                <th>Section</th>
                <th>Course</th>
                <th>Attending Status</th>
                <th>Attendance Date</th>
            </tr>
          
         </thead>
            @foreach($data as $key=>$attendance)
            <tr>
               <td>{{ $attendance->student_name }}</td>
                <td>{{ $attendance->phone }}</td>
                <td>
                    <div>{{ $attendance->duration }} <span class="text-primary">(
                            {{ strtoupper($attendance->section) }} )</span>
                    </div>
                </td>
                <td>{{ $attendance->course_name }}</td>
                <td>
                    @if ($attendance->attendance_status == '1')
                        <span class="badge badge-pill text-light"
                            style="background-color:green;">Present</span>
                    @elseif($attendance->attendance_status == '2')
                        <span class="badge badge-pill badge-warning text-dark">Late</span>
                    @elseif($attendance->attendance_status == '3')
                        <span class="badge badge-pill text-light"
                            style="background-color:blue;">Leave</span>
                    @else
                        <span class="badge badge-pill text-light"
                            style="background-color:red;">Absent</span>
                    @endif
                </td>
                <td>{{ date('d-M-Y h:i A', strtotime($attendance->date)) }}</td>
            </tr>
            @endforeach
         <tbody>
           
         </tbody>
      </table>
    </body>
</html>