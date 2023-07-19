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
              <th>Print Date</th>
              <th>Print By</th>
            </tr>
          
         </thead>
       
         <tbody>
           @foreach($certificate_history as $key=>$history)
            <tr>
              <td>{{$history->name}}</td>
              <td>{{$history->phone_1}},{{$history->phone_2}}</td>
              <td>{{$history->course_name}}</td>
              <td>{{date('d-m-Y h:i A',strtotime($history->created_at))}}</td>
              <td>{{$history->print_by}}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
    </body>
</html>