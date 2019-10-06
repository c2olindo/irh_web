@extends('dashboard.layouts.app')
@section('title', 'Profile')
@section('page_styles')
<link rel="stylesheet" href="{{ asset('irh_assets/vendor/jquery.tagsinput/src/jquery.tagsinput.css') }}">
<style>
    #user_name
    {
        font-size: 25px;
        padding-left: 20px;
        position: absolute;
        bottom: 48px;
    }
    #profile_picture 
    {
      position: relative;
      display: inline-block;
    }
    #profile_picture_overlay
    {
      position: absolute;
      top: 0;
      background: #333;
      width: 100%;
      height: 100%;
      opacity: 0.5;
      border-radius: .375rem;
      display: none;
    }

    #profile_picture:hover #profile_picture_overlay
    {
      cursor: pointer;
      display: block !important;
    }
</style>
@stop
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">{{ $user->full_name }} 's Profile </h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">My Profile</h6>
            </div>
            <div class="card-body p-0 d-flex">
                <div class="card w-100">
                    <div class="card-header bg-primary text-white" style="height: 150px;">
                        <div class="container-fluid w-100">
                            <div class="row">
                                <div class="col-md-8 profile_pictur_container mt-5">
                                    <div id="profile_picture">
                                      <img src="{{ asset($user->profile_picture_path) }}" alt="" class="img-thumbnail" width="120px"><span id="user_name">{{ $user->username }}</span>
                                      <div id="profile_picture_overlay" class="text-center pt-4">
                                       <a href="#" style="color:#fff;" data-toggle="modal" data-target="#updateProfilePictureModal">
                                         <i class="material-icons" style="font-size: 3rem;">
                                           camera_alt
                                         </i>
                                       </a>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ route('dashboard.user.profile') }}?action=edit" style="font-size: 25px;color:white;">
                                    <i class="material-icons">
                                    create
                                    </i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <div class="about_section py-4">
                           @if(\Request::has('action') && \Request::get('action') == 'edit')
                            <p><strong>Please note that all information underneath will be visible to other users of the website except that which you choose to ’Keep private’.</strong></p>
                                <form action="{{ route('dashboard.user.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="first_name">First Name <span>( Private ? <input type="checkbox" name="private[first_name]" value="first_name" {{ $user->isPrivate('first_name')?'checked':'' }}> )</span></label>
                                        <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span>( Private ? <input type="checkbox" name="private[last_name]"  value="last_name" {{ $user->isPrivate('last_name')?'checked':'' }}> )</span></label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Position <span>( Private ? <input type="checkbox" name="private[position]"  value="address" {{ $user->isPrivate('position')?'checked':'' }}> )</span></label>
                                        <input type="text" class="form-control" name="position" value="{{ $user->position }}" placeholder="E.g Teacher">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Working in <span>( Private ? <input type="checkbox" name="private[working_in]"  value="city" {{ $user->isPrivate('working_in')?'checked':'' }}> )</span></label>
                                        <input type="text" class="form-control" name="working_in" value="{{ $user->working_in }}" placeholder="e.g High School">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Specialist subjects <small>(separate by comma)</small> <span>( Private ? <input type="checkbox" name="private[subjects]"  value="city" {{ $user->isPrivate('subjects')?'checked':'' }}> )</span></label>
                                        <input id="tags_1" type="text" class="tags form-control" value="{{ $user->subjects }}" name="subjects" placeholder="e.g Arabic, Sociology" />
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country <span>( Private ? <input type="checkbox" name="private[country]"  value="country" {{ $user->isPrivate('country')?'checked':'' }}> )</span></label>
                                        <input type="text" class="form-control" name="country" value="{{ $user->country }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="about_me">About Me <span>( Private ? <input type="checkbox" name="private[about_me]"  value="about_me" {{ $user->isPrivate('about_me')?'checked':'' }}> )</span></label>
                                        <textarea name="about_me" rows="3" class="form-control">{{ $user->about_me }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-accent" value="Update Profile">
                                        <a href="{{ route('dashboard.user.profile') }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                           @else
                           @if(($user->first_name !== null)OR($user->about_me !== null))
                           <h5 class="m-0 pt-3">About Me:</h5>
                           <p class="text-justify">{!! $user->about_me !!}</p>
                           <hr>
                           <div class="info py-4">
                               <ul class="list-group">
                                   <li class="list-group-item"><i class="material-icons">location_on</i> Position: {{ $user->position ?? 'N/A' }}</li>
                                   <li class="list-group-item"><i class="material-icons">location_city</i> Working in: {{ $user->working_in ?? 'N/A' }}</li>
                                   <li class="list-group-item"><i class="material-icons">location_city</i>  Subjects Specialized: {{ $user->subjects ?? 'N/A' }}</li>
                                   <li class="list-group-item"><i class="material-icons">flag</i> Country: {{ $user->country ?? 'N/A' }}</li>
                               </ul>
                           </div>
                           @else
                           <div class="alert alert-info"><h6 class="m-0 text-white">Please Update Your Profile</h6></div>
                           @endif
                           @endif
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="updateProfilePictureModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Profile Picture</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ route('dashboard.user.profilepicture.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="profile_picture_uploader">Upload New Profile Picture</label>
            <input type="file" name="profile_picture_uploader" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-accent" value="Upload">
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

@endsection
@section('page_scripts')
<script src="{{ asset('irh_assets/vendor/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
<script>
  $(document).ready(function(){
    $("#tags_1").tagsInput({width:"auto",'defaultText':'Subjects'});
  });
</script>
@stop