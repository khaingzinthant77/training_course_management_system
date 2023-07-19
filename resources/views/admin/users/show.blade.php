@extends('layouts.master')

@section('content')
<style>
  th, td {
    padding: 15px;
  }
</style>
<div class="container-fluid">

  <div class="card shadow mb-4 p-3">
   <a href="{{route('users.index')}}" class="btn-link"><i class="fas fa-arrow-left"></i> User List</a>

    <div class="mt-5 mb-3">
      <div class="d-flex">
        <div class="col-md-4">
          <p class="text-muted font-weight-bold" style="padding: 0 15px;">User Information</p>
          <table>
            <tr>
              <td align="left">Name:</td>
              <td>{{$user->name}}</td>
            </tr>
            <tr>
              <td align="left">Email:</td>
              <td>{{$user->email}}</td>
            </tr>
            <tr>
              <td align="left">Phone:</td>
              <td>{{$user->phone ?? "-"}}</td>
            </tr>
            <tr>
              <td align="left">Role:</td>
              <td>
                <span class="badge badge-pill text-light" style="background-color:green;">{{$user->role_id ?? "-"}}</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  
  </div>
</div>
@endsection

@section('js')
  <script>
    $(document).ready(function(){
      $('#dataTable').DataTable();
    });

    let handleClick = (folder_id) => {
      let url = "{{url('vm_list')}}" + "/" + folder_id;
      window.location.href = url;
    }
  </script>
@endsection
