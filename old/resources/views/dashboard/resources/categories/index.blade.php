@extends('dashboard.layouts.app')
@section('title', 'Resource Categories')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">Resource Categories</h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
   <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
    <div class="card">
      <div class="card-header border-bottom">
          <h6 class="m-0">Add New Resource Category</h6>
      </div>
      <div class="card-body p-3 d-flex">
        <form action="{{ route('dashboard.resources.categories.store') }}" method="POST" class="w-100">
          @csrf
          <div class="form-group">
            <label for="size_title">Title: *</label>
            <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required>
            @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value=" + Add Resource Category">
          </div>
        </form>
      </div>
    </div>
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 mb-4"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Resource Categories</a></h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Title</th>
                          <th scope="col" class="border-0">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($categories as $cat)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $cat->title }}</td>
                          <td>
                              <a href="{{ route('dashboard.resources.categories.edit',$cat) }}" class="badge badge-info">Edit</a>
                              <a href="{{ route('dashboard.resources.categories.destroy',$cat) }}" class="badge badge-danger">Delete</a>
                          </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No Resource Categories Found</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection