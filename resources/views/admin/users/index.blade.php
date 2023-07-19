@extends('layouts.master')

@section('content')
<style>
</style>
<div class="container-fluid">

  <div class="card shadow mb-4 p-3">
    <div class="d-flex justify-content-between mb-3">
      <div>
        <span class="text-primary">TOTAL USER: {{$count}}</span>
      </div>
      <div>
        <a href="{{route('users.create')}}" class="btn btn-sm app-theme text-light"><i class="fas fa-plus"></i> Create New</a>
      </div>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
      <table class="table table-bordered" width="100%" cellspacing="0">
          <thead class="app-theme text-light">
              <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Created at</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
            @php
                $i = 0;
            @endphp
            @forelse ($users as $key => $user)
            <tr>
              <td>{{++$i}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>
                @if($user->role_id == 'Operator')
                <span class="badge badge-pill text-light" style="background-color:blue;">{{$user->role_id}}</span>
                @else
                <span class="badge badge-pill text-light" style="background-color:green;">{{$user->role_id}}</span>
                @endif
              </td>
              <td>
                <span class="mr-1"> {{ date('d-m-Y', strtotime($user->created_at)) }}</span>
                <small class="text-primary">{{ $user->created_at->diffForHumans() }}</small>
              </td>
              <td>
                <div class="d-flex">
                    <div class="mr-1">
                      <a href="{{route('users.show',$user->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                    </div>
                    <div class="mr-1">
                        <a href="{{ route('users.edit',$user->id) }}"
                            class="btn btn-sm app-theme text-light"><i class="fas fa-edit"></i></a>
                    </div>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                        id="delete-form-{{ $user->id }}">
                        @csrf
                        @method('DELETE')

                        <button type="button" data-id="{{ $user->id }}"
                            id="delete-btn-{{ $user->id }}" class="btn btn-sm btn-danger"><i
                                class="fas fa-trash"></i></button>
                    </form>
                </div>
              </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">There is no data</td>
                </tr>
            @endforelse
          </tbody>
      </table>
     {!! $users->appends(request()->input())->links() !!}
    </div>
  </div>
</div>
@endsection

@section('js')
  <script>
    $(document).ready(function(){

      @can('user-export')
      $('#dataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
              extend: 'excel',
              text: '<i class="fas fa-file-excel"></i> Export',
              className: 'btn btn-sm btn-warning',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5]
                  
              }
          }
        ]
      });

      @else
      $('#dataTable').DataTable();
      @endcan

     

      let timerInterval
     
      // Success Alert
      @if (Session::has('success'))
        Swal.fire({
          title: 'Success',
          icon:'success',
          html: 'autoclose in <b></b> milliseconds.',
          timer: 1000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
              b.textContent = Swal.getTimerLeft()
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            // console.log('I was closed by the timer')
          }
        })
      @endif

      // Error Alert
      @if (Session::has('error'))
        Swal.fire({
            title: 'Error',
            icon:'error',
            html: 'autoclose in <b></b> milliseconds.',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              // console.log('I was closed by the timer')
            }
          })
      @endif  

      // delete btn
      let users = @json($users);

      users.forEach(user => {
          $(`#delete-btn-${user.id}`).on('click', function(e) {
              let id = $(`#delete-btn-${user.id}`).attr('data-id');
              // sweet alert
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You want to delete this?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                  if (result.value) {
                      $(`#delete-form-${id}`).submit();
                  }
              })
          });
      });

    });
  </script>
@endsection
