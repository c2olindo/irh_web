@extends('dashboard.layouts.app')
@section('title', 'Manage Users')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">{{ Auth::user()->full_name }} 's Resources </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">My Resources </h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0 table-responsive">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Title</th>
                          <th scope="col" class="border-0">Category</th>
                          <th scope="col" class="border-0">Downloads</th>
                          <th scope="col" class="border-0">Views</th>
                          <th scope="col" class="border-0">Likes</th>
                          <th scope="col" class="border-0">Preview</th>
                          <th scope="col" class="border-0">Status</th>
                          <th scope="col" class="border-0">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @forelse($resources as $resource)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $resource->title }}</td>
                          <td>{{ $resource->category->title }}</td>
                          <td>{{ $resource->downloads }}</td>
                          <td>{{ $resource->views }}</td>
                          <td>{{ $resource->likes->count() }}</td>
                          <td><a href="{{ route('dashboard.resources.preview.user',$resource) }}" target="_blank" class="badge badge-primary">Preview</a></td>
                          <td><span class="badge badge-info">{{ $resource->resource_status_full }}</span></td>
                          <td>
                             <a href="{{ route('dashboard.resources.edit',$resource) }}" class="badge badge-info">Edit</a>
                            @if($resource->resource_status == 'drafted')
                            <a href="{{ route('dashboard.resource.submitforreviewbyuser',$resource) }}" class="badge badge-primary">Submit for Review</a>
                            @endif
                             <a href="{{ route('dashboard.resources.destroy',$resource) }}" onclick="return confirm('Are you sure?');" class="badge badge-danger">Delete</a>
                          </td>
                        </tr>
                       @empty
                        <tr>
                            <td colspan="6" class="text-center">No Resources Found</td>
                        </tr>
                       @endforelse
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection