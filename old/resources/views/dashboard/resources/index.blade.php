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
                    <h6 class="m-0">All Resources </h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">Title</th>
                          <th scope="col" class="border-0">Author</th>
                          <th scope="col" class="border-0">Category</th>
                          <th scope="col" class="border-0">is Featured?</th>
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
                          <td>{{ $resource->user->full_name }}</td>
                          <td>{{ $resource->category->title }}</td>
                          <td><input type="checkbox" data-switchery="true" data-id="{{ $resource->id }}" class="js-switch js-check-change" {{ ($resource->isFeatured == 1)?'checked':'' }} onchange="switchChange(this);" /> Yes</td>
                          <td><a href="{{ route('dashboard.resources.preview.user',$resource) }}" target="_blank" class="badge badge-success">Preview</a></td>
                          <td><span class="badge badge-info">{{ $resource->resource_status_full }}</span></td>
                          <td>
                            <a href="{{ route('dashboard.resources.edit',$resource) }}" class="badge badge-info">Edit</a>
                            @if($resource->resource_status == 'inreview')
                            <a href="{{ route('dashboard.resources.approve',$resource) }}" class="badge badge-success">Approve &amp; Publish</a>
                            <a href="#" data-toggle="modal" data-target="#rejectResourceModal{{ $resource->id }}" class="badge badge-danger">Reject</a>
                            @elseif($resource->resource_status == 'rejected')
                             <a href="{{ route('dashboard.resources.approve',$resource) }}" class="badge badge-warning">Approve &amp; Publish</a>
                            @else
                            <a href="#" data-toggle="modal" data-target="#rejectResourceModal{{ $resource->id }}" class="badge badge-danger">Reject</a>
                            @endif
                          
                          </td>
                        </tr>
                        <div class="modal" id="rejectResourceModal{{ $resource->id }}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Reject Resource</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                              <form action="{{ route('dashboard.resources.disapprove',$resource) }}" method="POST">
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
@section('page_scripts')
<script src="{{ asset('irh_assets/vendor/switchery/dist/switchery.min.js') }}"></script>
<script>
$(document).ready(function(){
  if($(".js-switch")[0])
    {
      var a=Array.prototype.slice.call(document.querySelectorAll(".js-switch"));
      a.forEach(function(a){
        new Switchery(a,{color:"#26B99A"})
      })
    }
  });

function switchChange(el)
  { 
    var res_id = $(el).attr('data-id');
    var status = null;
    if ($(el).is(":checked"))
    {
       status = 1;
    }
    else
    {
       status = 0;  
    }

     $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: 'POST',
          url: "{{ route('dashboard.resources.featured') }}",
          data: {status:status,res_id:res_id},
          success: function (data){
            if(data.error == 'error')
            {
              toastr.error('Something went wrong');
            }
            else
            {
              toastr.success("Resource Featured Successfully!");
            }
          },
          error: function(e) {
              console.log(e);
          }
        });
  }
</script>
@stop