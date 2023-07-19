@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="card shadow mb-4 p-5">

    {{-- Create  --}}
    <div class="text-center">
      <h1 class="h4 text-gray-900 mb-4">User Edit</h1>
    </div>
    <div class="d-flex justify-content-center">
      <form action="{{route('users.update',$user->id)}}" method="POST" class="col-md-6" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name',$user->name)}}">
          @error('name')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email',$user->email)}}">
          @error('email')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="For Password Reset">
          @error('password')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

          <div class="form-group">
          <label for="role_id">Role</label>
          <select class="form-control" id="role_id" name="role_id">
            <option value="">Select Role</option>
            <option value="Super Admin" {{$user->role_id == 'Super Admin' ? 'selected' : ''}}>Super Admin</option>
            <option value="Operator" {{$user->role_id == 'Operator' ? 'selected' : ''}}>Operator</option>
           </select>
          @error('role_id')
          <div class="text-danger font-weight-bold">* {{$message}}</div>
          @enderror
        </div>

        <div class="row">
          <div class="col-md-6">
            <a href="{{route('users.index')}}" class="btn btn-outline-primary btn-user btn-block">Go Back</a>
          </div>
          <div class="col-md-6">
            <button type="submit"  class="btn btn-success btn-user btn-block">Update</button>
          </div>
        </div>
      </form>
    </div>

  </div>
</div>

@endsection

@section('js')

@endsection
