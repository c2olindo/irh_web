@extends('layouts.app')
@section('content')
<header id="single-resource-header" class="bg-blue py-5">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 text-left">
				<h3 class="text-white mb-0">{{ ucwords($resource->title) }}</h3>
				<div class="py-2" style="border-bottom: 1px solid #ffffff85;">
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="far fa-star"></i>
					<span class="pl-2">{{ $resource->reviews->count() }} {{ str_plural('Review',$resource->reviews->count()) }}</span>
				</div>
				<div class="py-2">
					<div class="float-left">
						<h5 class="text-white mb-0">Author: {{ ucwords($resource->user->full_name) }}</h5>
						<h5 class="text-white mb-0 mt-2">Created at: {{ date('d-M-Y',strtotime($resource->created_at)) }}</h5>
					</div>
					<div class="float-right">
						<span class="px-2"><i class="fab fa-instagram"></i></span>
						<span class="px-2"><i class="fab fa-facebook"></i></span>
						<span class="px-2"><i class="fab fa-whatsapp"></i></span>
						<span class="px-2"><i class="fab fa-twitter"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card">
					<div class="card-body">
						<a href="{{ route('theme.downloadresource',$resource) }}" class="btn bg-blue btn-block"><i class="fas fa-download"></i> Download</a>
					</div>
					<div class="card-footer">
						<div class="my-2" style="display: grid;">
							<div style="grid-column: 1;">
								@if(!$resource->isResourceSavedByLoggedInUser())
								<a href="{{ route('theme.saveresource',$resource) }}">
									<img src="{{ asset('irh_assets/images/singlesave.png') }}" alt="" width="30px"> <span class="text-muted pl-3">Save for later</span>
								</a>
								@else
								<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="30px"> Saved
								@endif
								
							</div>
							<div style="grid-column: 2;">
								@if(!$resource->isResourceLikedByLoggedInUser())
								<a href="{{ route('theme.likeresource',$resource) }}" class="btn bg-yellow"><i class="far fa-thumbs-up"></i> Like</a>
								@else
								<a href="javascript:void(0);" class="btn bg-yellow"><i class="fas fa-thumbs-up"></i> Liked</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<section id="single-resource" class="p-5">
	<div class="description">
		{!! $resource->description !!}
	</div>
	<hr>
	<div class="files py-4">
		<h4 class="heading">File(s) Included:</h4>
		<div>
			<figure class="figure">
				<img src="{{ $resource->cover_attachment_path }}" alt="" class="img-thumbnail" width="200px" height="200px">
				<figcaption class="figure-caption ml-3"><a href="{{ route('theme.downloadresource',$resource) }}"><i class="fas fa-download"></i> Download resource file</a></figcaption>
			</figure>
		</div>
	</div>
	<hr>
	@auth
	<p>Report a <a href="" data-toggle="modal" data-target="#flagResourceModal">Problem</a></p>
	@if(Session::has('success'))
	<div class="alert alert-success">
		{{ Session::get('success') }}
	</div>
	@endif
	<hr>
	@endauth
	<h4 class="heading">Review(s):
	@auth
	@if(!$resource->loggedInUserHasReview())
	<a href="#" data-toggle="modal" data-target="#addReviewModal" class="btn bg-blue btn-sm">Add a Review</a>
	@endif
	@endauth
	</h4>
	<div class="reviews">
		@foreach($resource->reviews as $rv)
		<div class="review py-4">
			<h6 class="text-muted"><i class="fa fa-angle-right"></i> {{ $rv->user->full_name }} <span>{!! $rv->resourceStarsRatings() !!}</span>
			@if($rv->status == 1)
			@if($rv->user_id == Auth::id())
			&nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#editReviewModal{{ $rv->id }}" class="text-muted"><i class="fa fa-pen"></i></a>
			@endif
			@if(Auth::check() && Auth::user()->hasRole('admin'))
			<a href="{{ route('theme.deletereviewfromresource',$rv) }}" class="text-muted ml-2" onclick="return confirm('Are you sure you want to delete this?');"><i class="fa fa-times"></i></a>
			@endif
			</h6>
			<p class="ml-3">{{ $rv->review }}</p>
			@else
			</h6>
			<p class="ml-3"><em>This review has been removed by a moderator.</em></p>
			@endif
		</div>
		<div class="modal fade" id="editReviewModal{{ $rv->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ route('theme.updatereviewfromresource',$rv) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Review</label>
								<textarea name="review" rows="2" class="form-control" placeholder="Review ..">{{ $rv->review }}</textarea>
							</div>
							<div class="form-group">
								<label for="">Rating</label>
								<select name="stars" id="" class="form-control">
									<option value="1" {{ ($rv->stars == 1)?'selected':'' }}>1 Star</option>
									<option value="2" {{ ($rv->stars == 2)?'selected':'' }}>2 Star</option>
									<option value="3" {{ ($rv->stars == 3)?'selected':'' }}>3 Star</option>
									<option value="4" {{ ($rv->stars == 4)?'selected':'' }}>4 Star</option>
									<option value="5" {{ ($rv->stars == 5)?'selected':'' }}>5 Star</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" class="btn bg-blue" value="Update Review">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<hr>
	<h4 class="heading">Tags:</h4>
	<div class="tags py-4">
		@foreach($resource->tags as $tag)
		<span class="bg-blue p-2" style="border-radius:3em;">{{ $tag->name }}</span>
		@endforeach
	</div>
	<hr>
	<h4 class="heading text-center">Related Resources:</h4>
	<div class="relatedResources py-4 text-center">
		<div class="container">
			<div class="row">
				@forelse($related as $rel)
				<div class="col-md-3 mb-4">
					<div class="resourcebox">
						<div class="card">
							<a href="{{ route('theme.singleresource',$rel) }}">
							<img class="card-img-top" src="{{ $rel->preview_attachment_path }}" alt="Card image cap" style="position: relative;"></a>
							<span style="position: absolute;top: -1;right: 10px;">
								@if(!$rel->isResourceSavedByLoggedInUser())
								<a href="{{ route('theme.saveresource',$rel) }}">
									<img src="{{ asset('irh_assets/images/savelogo.png') }}" alt="" width="25px" data-toggle="tooltip" data-placement="top" title="save for later">
								</a>
								@else
								<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="25px">
								@endif
							</span>
							<div class="card-body">
								<div class="pb-4"><img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle"><span class="ml-3">{{ $rel->user->full_name }}</span></div>
								<a href="{{ route('theme.singleresource',$rel) }}" class="text-muted"><h5 class="card-title">{{ $rel->title }}</h5></a>
							</div>
							<div class="card-footer">
								<div style="display: grid;">
									<div style="grid-column: 1;border-right: 1px solid #333;"><small>VIEWS</small><br>{{ $rel->views }}</div>
									<div style="grid-column: 2;border-right: 1px solid #333;"><small>DOWNLOADS</small><br>{{ $rel->downloads }}</div>
									<div style="grid-column: 3;"><small>LIKES</small><br>{{ $rel->likes->count() }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@empty
				<div class="col-md-4 offset-md-4">
					<h3>No Related Resource</h3>
				</div>
				@endforelse
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add a Review</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('theme.addreviewtoresource') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="">Review</label>
						<textarea name="review" rows="2" class="form-control" placeholder="Review .."></textarea>
					</div>
					<div class="form-group">
						<label for="">Rating</label>
						<select name="stars" id="" class="form-control">
							<option value="1">1 Star</option>
							<option value="2">2 Star</option>
							<option value="3">3 Star</option>
							<option value="4">4 Star</option>
							<option value="5">5 Star</option>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="resource_id" value="{{ $resource->id }}">
						<input type="submit" class="btn bg-blue" value="Add Review">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="flagResourceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Flag this Resource</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('theme.flagresource') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="">Reason</label>
						<textarea name="reason" rows="2" class="form-control" placeholder="Explain your problem .."></textarea>
					</div>
					<div class="form-group">
						<input type="hidden" name="resource_id" value="{{ $resource->id }}">
						<input type="submit" class="btn bg-blue" value="Report">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@stop