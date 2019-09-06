@extends('layouts.app')
@section('content')
<section id="resources" class="text-center py-5">
	<div class="container">
		<h1 class="pb-5 heading">{{ $category }} Resources</h1>
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
					  	<img src="{{ asset('irh_assets/images/savelogo.png') }}" alt="" width="25px">
					  	</a>
					  	@else
					  	<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="25px">
					  	@endif
					  </span>
					  <div class="card-body">
					  	<div class="pb-4"><img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle"><span class="ml-3">{{ $resource->user->full_name }}</span></div>
					    <a href="{{ route('theme.singleresource',$resource) }}"><h5 class="card-title text-muted">{{ $resource->title }}</h5></a>
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
	</div>
</section>
@stop