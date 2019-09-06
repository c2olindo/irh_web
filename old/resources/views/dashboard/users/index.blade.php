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
        <h3 class="page-title">Users </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Users - <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">Add New User</a></h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">First Name</th>
                          <th scope="col" class="border-0">Last Name</th>
                          <th scope="col" class="border-0">Username</th>
                          <th scope="col" class="border-0">Email</th>
                          <th scope="col" class="border-0">Status</th>
                          <th scope="col" class="border-0">Role(s) Assigned</th>
                          <th scope="col" class="border-0">isVerified ?</th>
                          <th scope="col" class="border-0">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @forelse($users as $user)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $user->first_name }}</td>
                          <td>{{ $user->last_name }}</td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>
                          <td><span class="badge badge-pill badge-{{ ($user->status == 1)?'success':'danger' }}">{{ ($user->status == 1)?'Active':'Blocked' }}</span></td>
                          <td><span class="badge badge-pill badge-primary">{{ ucfirst($user->user_role) }}</span></td>
                          <td><input type="checkbox" data-switchery="true" data-id="{{ $user->id }}" class="js-switch js-check-change" {{ ($user->verified == 1)?'checked':'' }} onchange="switchChange(this);" /> Yes</td>
                          <td>
                             @if($user->status == 1)
                             <a href="{{ route('dashboard.users.block',$user) }}" class="badge badge-info">Block</a>
                             @else
                             <a href="{{ route('dashboard.users.activate',$user) }}" class="badge badge-info">Activate</a>
                             @endif
                             <a href="{{ route('dashboard.users.destroy',$user) }}" class="badge badge-danger">Delete</a>
                          </td>
                        </tr>
                       @empty
                        <tr>
                            <td colspan="6" class="text-center">No Users Found</td>
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
    var user_id = $(el).attr('data-id');
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
          url: "{{ route('dashboard.users.verified.ajax') }}",
          data: {status:status,user_id:user_id},
          success: function (data){
            if(data.error == 'error')
            {
              toastr.error('Something went wrong');
            }
            else
            {
              toastr.success("User Updated Successfully!");
            }
          },
          error: function(e) {
              console.log(e);
          }
        });
  }
</script>
@endsection