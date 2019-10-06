@extends('dashboard.layouts.app')
@section('title', 'Testimonials')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">Testimonials </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Testimonials - <a href="{{ route('dashboard.testimonials.create') }}" class="btn btn-primary">Add New Testimonial</a></h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0 table-responsive-sm table-responsive-xs">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0" width="5%">#</th>
                          <th scope="col" class="border-0" width="10%">Testimonial By</th>
                          <th scope="col" class="border-0" width="60%">Testimonial Text</th>
                          <th scope="col" class="border-0" width="20%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @forelse($testimonials as $testimonial)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $testimonial->testimonial_by }}</td>
                          <td>{{ $testimonial->testimonial_text }}</td>
                          <td>
                             <a href="{{ route('dashboard.testimonials.edit',$testimonial) }}" class="badge badge-primary">Edit</a>
                             <a href="{{ route('dashboard.testimonials.destroy',$testimonial) }}" onclick="return confirm('Are you sure?');" class="badge badge-danger">Delete</a>
                          </td>
                        </tr>
                       @empty
                        <tr>
                            <td colspan="6" class="text-center">No Testimonials Found</td>
                        </tr>
                       @endforelse
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection