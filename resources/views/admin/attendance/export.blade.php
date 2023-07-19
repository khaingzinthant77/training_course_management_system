<html>

<head>
</head>
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css">
<style>
    table.scroll {
        overflow-x: scroll;
    }

    .c-w {
        min-width: 200px;
        max-width: 200px
    }
</style>

<body>
    <table class="table table-bordered styled-table ">
        <thead>
            @php
                $i = 0;
            @endphp
            <tr>
                <th>No</th>
                <th class="c-w">Student Name</th>
                @forelse ($month as $day)
                    <th @if ($day['string_day'] == 'Fri') style="background-color: #1067AC; color:#fff;" @endif>
                        <div>{{ $day['string_day'] }}</div>
                        <div>{{ $day['number_day'] }}</div>
                    </th>
                @empty
                @endforelse
            </tr>
        </thead>

        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $student->name }}</td>
                    @forelse ($student->attendances as $attendance)
                        @if ($attendance != '')
                            @if ($attendance->attendance_status == '1')
                                <td style="color: green">
                                    P
                                </td>
                            @endif

                            @if ($attendance->attendance_status == '2')
                                <td style="color: green">
                                    P
                                </td>
                            @endif

                            @if ($attendance->attendance_status == '3')
                                <td style="color: blue">
                                    L
                                </td>
                            @endif

                            @if ($attendance->attendance_status == '0')
                                <td style="color: red">
                                    A
                                </td>
                            @endif
                        @else
                            <td></td>
                        @endif
                    @empty
                    @endforelse
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</body>

</html>
