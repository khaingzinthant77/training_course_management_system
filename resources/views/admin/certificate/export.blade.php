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
              <th>Is Taken</th>
              <th>Taken By</th>
              <th>Taken Date</th>
              <th>Given By</th>
              <th>Generate By</th>
              <th>Generate Date</th>
            </tr>
          
         </thead>
       
         <tbody>
           @foreach($certificates as $key=>$certificate)
            <tr>
              <td>{{$certificate->name}}</td>
              <td>{{$certificate->phone_1}},{{$certificate->phone_2}}</td>
              <td>{{$certificate->course_name}}</td>
              <td>
                @if($certificate->is_taken == 0)
                  Yes
                @else
                No
                @endif
              </td>
              <td>{{$certificate->taken_by}}</td>
              <td> @if($certificate->taken_date != null){{date('d-m-Y h:i A',strtotime($certificate->taken_date))}}@endif</td>
              <td>{{$certificate->given_by}}</td>
              <td>{{$certificate->generate_by}}</td>
              <td>{{date('d-m-Y h:i A',strtotime($certificate->created_at))}}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
    </body>
</html>