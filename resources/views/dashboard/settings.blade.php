@extends('dashboard.layouts.app')
@section('title', 'Settings')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
    <h3 class="page-title">Update Settings</h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-12 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
        <h6 class="m-0">Update General Content</h6>
      </div>
      <div class="card-body d-flex p-5">
        <form class="col-lg-12" action="{{ route('dashboard.settings.update') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="privacy_policy">Privacy Policy: </label>
            <textarea rows="3" class="form-control summernote {{ $errors->has('privacy_policy') ? ' is-invalid' : '' }}" name="privacy_policy" required>{{ $settings->privacy_policy }}</textarea>
            @if ($errors->has('privacy_policy'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('privacy_policy') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="terms_conditions">Terms &amp; Conditions: </label>
            <textarea rows="3" class="form-control summernote {{ $errors->has('terms_conditions') ? ' is-invalid' : '' }}" name="terms_conditions" required>{{ $settings->terms_conditions }}</textarea>
            @if ($errors->has('terms_conditions'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('terms_conditions') }}</strong>
            </span>
            @endif
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