@extends('dashboard.layouts.app')
@section('title', 'Manage Users')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">Resource Tags </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Tags - <a href="{{ route('dashboard.resources.tags.create') }}" class="btn btn-primary">Add New Resource Tag</a></h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0 table-responsive-sm table-responsive-xs">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Tag Group</th>
                          <th scope="col" class="border-0">Name</th>
                          <th scope="col" class="border-0">Description</th>
                          <th scope="col" class="border-0">Order</th>
                          <th scope="col" class="border-0">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @forelse($tags as $tag)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $tag->tag_group }}</td>
                          <td>{{ $tag->name }}</td>
                          <td>{{ $tag->description }}</td>
                          <td>{{ $tag->order }}</td>
                          <td>
                            <a href="{{ route('dashboard.resources.tags.edit',$tag) }}" class="badge badge-info">Edit</a>
                            <a href="{{ route('dashboard.resources.tags.destroy',$tag) }}" class="badge badge-danger">Delete</a>
                          </td>
                        </tr>
                       @empty
                        <tr>
                            <td colspan="6" class="text-center">No Tags Found</td>
                        </tr>
                       @endforelse
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection