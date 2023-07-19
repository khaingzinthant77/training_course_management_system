<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Information</title>
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style type="text/css">
        #backdrop {
            opacity: 0.1;
            position: absolute;
            /*      top:6%;*/
        }

        #backdrop img {
            width: 100%;
            /* transform: rotate(-35deg); */
        }
    </style>
</head>

<body>
    <div class="table-responsive" style="align-items: center;">
        <div id="backdrop">
            <img src="{{ asset('images/logo.png') }}" alt="">
        </div>
        <table class="table table-bordered" cellspacing="0">

            <thead>
                <tr>
                    <th colspan="4" style="text-align: center;">
                        @if ($student->photo != null)
                            <img src="{{ asset('uploads/student_photo/', $student->photo) }}" width="100px;"
                                height="100px;">
                        @else
                            <img src="{{ asset('uploads/no_photo.jpeg') }}" width="100px;" height="100px;">
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Student ID</th>
                    <th>{{ $student->studentID }}</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <th>{{ $student->name }}</th>
                </tr>

                @forelse ($courses as $course)
                    <tr>
                        <th>{{ $course->name }}</th>
                        <th>
                            @if ($course->is_finished == '0')
                                <span class="badge badge-primary">Ongoing</span>
                            @elseif($course->is_finished == '1')
                                <span class="badge badge-success">Finished</span>
                            @elseif($course->is_finished == '2')
                                <span class="badge badge-danger">Cancel</span>
                            @endif
                        </th>
                    </tr>
                @empty
                @endforelse

                {{-- <tr>
              	<th>Phone No</th>
              	<th>{{$student->phone_1}}</th>
              </tr>
              <tr>
              	<th>NRC</th>
              	<th>{{$student->nrc}}</th>
              </tr>
              <tr>
              	<th>Father Name</th>
              	<th>{{$student->father_name}}</th>
              </tr>
              <tr>
              	<th>Qualification</th>
              	<th>{{$student->qualification}}</th>
              </tr>
              <tr>
              	<th>Nationality</th>
              	<th>{{$student->nationality}}</th>
              </tr>
              <tr>
              	<th>Religion</th>
              	<th>{{$student->religion}}</th>
              </tr>
              <tr>
              	<th>Address</th>
              	<th>{{$student->address}}</th>
              </tr> --}}
            </tbody>
        </table>
    </div>

</body>

</html>
