@extends('dashboard.layouts.app')
@section('title', 'Update Password')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
    <h3 class="page-title">Update Password</h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-12 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
        <h6 class="m-0">Enter New Credentials</h6>
      </div>
      <div class="card-body d-flex p-5">
        <form class="col-lg-12" action="{{ route('dashboard.password.update') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="password">Password *</label>
            <input id="password" type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="password-confirm">Confirm Password *</label>
            <input id="password-confirm" type="password" class="form-control form-control-lg " name="password_confirmation" required>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Update">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection