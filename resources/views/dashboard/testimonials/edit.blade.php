@extends('dashboard.layouts.app')
@section('title', 'Add Testimonial')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
    <h3 class="page-title">Testimonials | <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-info">Return Back to Testimonials</a></h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-12 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
        <h6 class="m-0">Edit Existing Testimonial - <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-primary">Show All Testimonials</a></h6>
      </div>
      <div class="card-body d-flex p-5">
        <form class="col-lg-12" action="{{ route('dashboard.testimonials.update',$testimonial) }}" method="POST">
          @csrf
          <div class="form-group {{ $errors->has('testimonial_by') ? ' is-invalid' : '' }}">
            <label for="testimonial_by">Testimonial By</label>
            <input id="testimonial_by" type="text" class="form-control {{ $errors->has('testimonial_by') ? ' is-invalid' : '' }}" name="testimonial_by" value="{{ $testimonial->testimonial_by }}" required>
            @if ($errors->has('testimonial_by'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('testimonial_by') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group {{ $errors->has('testimonial_text') ? ' is-invalid' : '' }}">
            <label for="testimonial_text">Testimonial Text *</label>
            <textarea name="testimonial_text" id="" rows="3" class="form-control {{ $errors->has('testimonial_text') ? ' is-invalid' : '' }}" required>{{ $testimonial->testimonial_text }}</textarea>
            @if ($errors->has('testimonial_text'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('testimonial_text') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update Testimonial">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection