@extends('dashboard.layouts.app')
@section('title', 'Manage Users')
@section('page_styles')
<link href="{{ asset('irh_assets/vendor/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">Resources </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Flagged Resources </h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Flag By</th>
                          <th scope="col" class="border-0">Flagged Resource</th>
                          <th scope="col" class="border-0">Reason</th>
                          <th scope="col" class="border-0">Status</th>
                          <th scope="col" class="border-0">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @forelse($flags as $flag)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $flag->user->full_name }}</td>
                          <td><a href="{{ route('dashboard.resources.preview.user',$flag->resource) }}" target="_blank">{{ $flag->resource->title }}</a></td>
                          <td>{{ $flag->reason }}</td>
                          <td><span class="badge badge-primary">{{ $flag->status }}</span></td>
                          <td>
                            <a href="{{ route('dashboard.resources.disapprove',$flag->resource) }}" class="badge badge-danger">Disapprove Resource</a>
                            <a href="{{ route('dashboard.resource.flagreject',$flag) }}" class="badge badge-info">Reject Flag</a>
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