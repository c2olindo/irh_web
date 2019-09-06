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
        <table class="table mb-0 table-responsive">
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
              <td>
                @if($flag->resource->resource_status == 'rejected')
                <span class="badge badge-success">Fixed</span>
                @else
                 <span class="badge badge-primary">{{ $flag->status }}</span>
                @endif
              </td>
              <td>
                @if($flag->resource->resource_status == 'rejected')
                <span class="badge badge-primary">Resource Rejected</span>
                @else
                <a  data-toggle="modal" data-target="#rejectResourceModal{{ $flag->id }}" href="#" class="badge badge-danger">Reject Resource</a>
                <a href="{{ route('dashboard.resource.flagreject',$flag) }}" class="badge badge-info">Reject Flag</a>
                @endif
              </td>
            </tr>
            <div class="modal" id="rejectResourceModal{{ $flag->id }}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Reject Resource</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                    <form action="{{ route('dashboard.resources.disapprove',$flag->resource->id) }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label for="reason">Reason *</label>
                        <select name="reason" id="" class="form-control">
                          <option value="Copyrighted material">Copyrighted material</option>
                          <option value="Inappropriate content">Inappropriate content</option>
                          <option value="Promoting sectarianism">Promoting sectarianism</option>
                          <option value="Does not represent mainstream Islam">Does not represent mainstream Islam</option>
                          <option value="Other">Other</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="details">Please provide further details (optional)</label>
                        <textarea name="details" rows="3" class="form-control" required></textarea>
                      </div>
                      <div class="form-group">
                        <input type="submit" class="btn btn-accent" value="Reject">
                      </div>
                    </form>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
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