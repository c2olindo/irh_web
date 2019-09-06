@extends('dashboard.layouts.app')
@section('title', 'Add User')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
    <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
    <h3 class="page-title">Resource Tags | <a href="" class="btn btn-info">Return Back to Tags</a></h3>
  </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
  <div class="col-lg col-md-12 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
        <h6 class="m-0">Add New Tag </h6>
      </div>
      <div class="card-body d-flex p-5">
        <form class="col-lg-12" action="{{ route('dashboard.resources.tags.store') }}" method="POST">
          @csrf
          <div class="form-group {{ $errors->has('tag_group') ? ' is-invalid' : '' }}">
            <label for="tag_group">Tag Group *</label>
            <select name="tag_group" id="tag_group" class="form-control">
              <option value="Resource Type">Resource Type</option>
              <option value="Age Group">Age Group</option>
            </select>
            @if ($errors->has('tag_group'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('tag_group') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group {{ $errors->has('name') ? ' is-invalid' : '' }}">
            <label for="name">Name *</label>
            <input type="text" name="name" class="form-control">
            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          
          <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
            <label for="description">Description </label>
            <textarea name="description" rows="3" class="form-control"></textarea>
            @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('description') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group {{ $errors->has('order') ? ' is-invalid' : '' }}">
            <label for="order">Order </label>
            <input type="number" min="0" name="order" class="form-control">
            @if ($errors->has('order'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('order') }}</strong>
            </span>
            @endif
          </div>

       
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Tag">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection