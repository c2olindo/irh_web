@extends('dashboard.layouts.app')
@section('title', 'Add User')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
    <h3 class="page-title">Users | <a href="" class="btn btn-info">Return Back to Users</a></h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-12 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
        <h6 class="m-0">Add New User - <a href="" class="btn btn-primary">Show All Users</a></h6>
      </div>
      <div class="card-body d-flex p-5">
        <form class="col-lg-12" action="{{ route('dashboard.users.store') }}" method="POST">
          @csrf
          <div class="form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}">
            <label for="first_name">First Name *</label>
            <input id="first_name" type="text" class="form-control form-control-lg {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
            @if ($errors->has('first_name'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('first_name') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group {{ $errors->has('last_name') ? ' is-invalid' : '' }}">
            <label for="last_name">Last Name *</label>
            <input id="last_name" type="text" class="form-control form-control-lg {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
            @if ($errors->has('last_name'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('last_name') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input id="email" type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="username">Username *</label>
            <input id="username" type="text" class="form-control form-control-lg {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
            @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('username') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="password">Password *</label>
            <input id="password" type="text" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="password-confirm">Confirm Password *</label>
            <input id="password-confirm" type="text" class="form-control form-control-lg " name="password_confirmation" required>
          </div>

          <div class="form-group">
            <label for="user_role">Roles</label>
            <select name="user_role" id="user_role" class="form-control">
              <option value="">--Choose Role--</option>
              @foreach($roles as $role)
              <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Add User">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection