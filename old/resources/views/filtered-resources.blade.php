@extends('layouts.app')
@section('content')
<header id="resources-header" style="background:linear-gradient(rgba(255, 205, 36, 0.5),rgba(51, 57, 61, 0.5)), url({{ asset('irh_assets/images/resourcesheader.jpg') }});height: 800px;background-size: cover;background-attachment: fixed;">
	<div class="header-content container">
		<div class="row">
			<div class="col-md-6">
				<div class="card card-body">
					<form action="{{ route('theme.resources.filtered') }}" method="GET">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search for resources .." name="keyword">
						</div>
						<div class="form-group">
							<select name="age_group" id="" class="form-control">
								<option value="" selected disabled>--Filter By Age Group--</option>
								@foreach($age_groups as $ag)
								<option value="{{ $ag->id }}">{{ $ag->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<select name="resource_type" id="" class="form-control">
								<option value="" selected disabled>--Filter By Resource Type--</option>
								@foreach($resource_types as $rt)
								<option value="{{ $rt->id }}">{{ $rt->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<input type="submit" class="btn bg-blue btn-block">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</header>
<section id="resources" class="text-center py-5">
	<div class="container">
		<h1 class="pb-5 heading">Filtered Search Results</h1>
		<div class="row">
			@forelse($resources as $resource)
			<div class="col-md-3 mb-4">
				<div class="resourcebox">
					<div class="card">
						<a href="{{ route('theme.singleresource',$resource) }}">
					  <img class="card-img-top" src="{{ $resource->preview_attachment_path }}" alt="Card image cap" style="position: relative;"></a>
					  <span style="position: absolute;top: -1;right: 10px;">
					  	@if(!$resource->isResourceSavedByLoggedInUser())
					  	<a href="{{ route('theme.saveresource',$resource) }}">
					  	<img src="{{ asset('irh_assets/images/savelogo.png') }}" alt="" width="25px" data-toggle="tooltip" data-placement="top" title="save for later">
					  	</a>
					  	@else
					  	<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="25px">
					  	@endif
					  </span>
					  <div class="card-body">
					  	<div class="pb-4"><img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle"><span class="ml-3">{{ $resource->user->full_name }}</span></div>
					   <a href="{{ route('theme.singleresource',$resource) }}" class="text-muted"> <h5 class="card-title">{{ $resource->title }}</h5></a>
					  </div>
					  <div class="card-footer">
					  	<div style="display: grid;">
					  		<div style="grid-column: 1;border-right: 1px solid #333;"><small>VIEWS</small><br>{{ $resource->views }}</div>
					  		<div style="grid-column: 2;border-right: 1px solid #333;"><small>DOWNLOADS</small><br>{{ $resource->downloads }}</div>
					  		<div style="grid-column: 3;"><small>LIKES</small><br>{{ $resource->likes->count() }}</div>
					  	</div>
					  </div>
					</div>
				</div>
			</div>
			@empty
			<div class="col-md-4 offset-md-4">
				<h3>No Resources Found</h3>
			</div>
			@endforelse
		</div>
		<div class="row mt-4">
			<div class="col-md-4 offset-md-5">
				{{ $resources->appends(Request::except('page'))->links() }}
			</div>
		</div>
	</div>
</section>
@stop