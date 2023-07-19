<html>
    <head>
    </head>
    <body>
      <table class="table table-bordered styled-table ">
         <thead>
            <tr>
               <th>Date</th>
               <th>Time</th>
               <th>Name</th>
               <th>PhoneNo</th>
               <th>Qualification</th>
               <th>Interested Course</th>
               <th>Section Time</th>
               <th>Condition</th>
               <th>Created By</th>
               <th>Updated By</th>
               <th>Remark</th>
            </tr>
          
         </thead>
       
         <tbody>
            @foreach($data as $key=>$enquiry)
            <tr>
               <td>{{ date('d-m-Y', strtotime($enquiry->created_at)) }}</td>
               <td>{{ date('H:i', strtotime($enquiry->created_at)) }}</td>
               <td>{{ $enquiry->name }}</td>
              <td>
                  <div>{{ $enquiry->phone_1 }}</div>
                  <div>{{ $enquiry->phone_2 }}</div>
              </td>
              <td>{{ strtoupper($enquiry->qualification) }}</td>
              @php
                  $courses = getCourseByEnquiry($enquiry->id);
              @endphp
              <td>
                  @forelse ($courses as $course)
                      <div class="my-1">
                          {{ $course->name }}</div>
                  @empty
                  @endforelse
              </td>
              <td>
                  @if ($enquiry->is_anytime)
                      <span class="badge badge-primary">any-time</span>
                  @else
                      <div> {{ $enquiry->section }}</div>
                      <div>({{ $enquiry->duration }})</div>
                  @endif
              </td>
              <td>
                  @if ($enquiry->enquiry_status == 0)
                      <span class="badge badge-primary">pending</span>
                  @elseif($enquiry->enquiry_status == 1)
                      <span class="badge badge-success">student</span>
                  @elseif($enquiry->enquiry_status == 2)
                      <span class="badge badge-danger">cancel</span>
                  @else
                  @endif
              </td>
              <td>{{ $enquiry->c_by }}</td>
              <td>{{ $enquiry->u_by}}</td>
              <td>{{$enquiry->remark }}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
    </body>
</html>