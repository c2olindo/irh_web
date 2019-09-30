@extends('layouts.app')

@section('page_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('irh_assets/vendor/slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('irh_assets/vendor/slick/slick-theme.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('irh_assets/css/slick-custom.css') }}"/>
@stop

@section('content')
<header id="main-header" class="responsive" style="background:linear-gradient(rgba(30, 169, 231, 0.5),rgba(250, 0, 0, 0)), url({{ asset('irh_assets/images/slider1.jpg') }});height: 800px;background-size: cover;background-attachment: fixed;">
	<div class="header-content">
		<h1 class="signika">Resources made by you. Free. Forever.</h1>
		<form action="{{ route('theme.resources.filtered') }}" method="GET" id="search-form">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search for powerpoints, worksheets, posters, visual aids and much more" name="keyword">
				<div class="input-group-prepend">
		          <span class="input-group-text bg-yellow" id="inputGroupPrepend" onclick="event.preventDefault();
              document.getElementById('search-form').submit();"><i class="fa fa-search p-2"></i></span>
		        </div>
			</div>
		</form>
	</div>
</header>

<section id="intro_video">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="video_text">
				<h2 id="video_heading">
					Assalamua'alaikum,
				</h2>
				<p id="video_heading_text">
					To all teachers, parents, imams and students - we're IRH; your one stop platform for sharing Islamic learning materials. Share your own resouce oe download resources made by others. You'll find a wide variety of learning materials that ranges from PowerPoint presentations to quizzes. What's better yet is that it's all for free. Watch the video to learn more about what we do.
				</p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="video">
				<iframe class="video" src="{{ url('https://www.youtube.com/embed/CfwPlvWexYU') }}" width="100%" height="315px" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>

<section class="container-fluid community_benifit text-center">
	<h1 class="heading">Join our community and benefit</h1>
	<p style="font-family: Roboto; ">Connect with other teachers and share your resources in four easy steps!</p>
	<div class="infographic responsive">
		<img src="{{ asset('irh_assets/images/infographic.png') }}" alt="" width="100%"  height="auto">
	</div>
</section>

<section id="categories" class="text-center">
	<div class="container">
		<h1 class="pb-5 text-white signika">Categories</h1>
		<div class="row">
			@foreach($categories as $category)
			<div class="col-md-2 categorybox p-3">
				<div class="category">
					<a href="{{ route('theme.resourcesbycategory',$category) }}">
					<img src="{{ asset('irh_assets/images/categories/'.strtolower($category->title).'.png') }}" alt="" class="hvr-grow">
					</a>
					<a href="{{ route('theme.resourcesbycategory',$category) }}"><h5 class="mb-0 pt-4 text-white">{{ $category->title }}</h5></a>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>

<section id="featured_resources" class="text-center py-5">
	<div class="container">
		<h1 class="pb-5 heading ">Featured Resources</h1>
		<p class="resource_heading">The most popular resources - selected by us.</p>
		<div class="row featured_resources_slider">
			@forelse($featured as $fr)
			<div class="col-md-3 featured_resource_box mb-4">
				<div class="resourcebox hvr-glow">
					<div class="card">
					  <a href="{{ route('theme.singleresource',$fr) }}">
					  <img class="card-img-top" src="{{ $fr->preview_attachment_path }}" alt="Card image cap" style="position: relative;"></a>
					  <span style="position: absolute;top: -1;right: 10px;" id="saveResourceContainer_{{ $fr->id }}">
					  	@auth
					  	@if(!$fr->isResourceSavedByLoggedInUser())
					  	<a href="javascript:void(0);"  onclick='saveResource("{{ $fr->id }}",false);'>
					  	<img src="{{ asset('irh_assets/images/savelogo.png') }}" alt="" width="25px" data-toggle="tooltip" data-placement="top" title="save for later">
					  	</a>
					  	@else
					  	<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="25px">
					  	@endif
					  	@endauth
					  </span>
					  <div class="card-body">
					  	<div class="pb-4 author_profile"><img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="20px" class="rounded-circle" style="display: inline-block;"><a href="{{ route('theme.resources.authorprofile',$fr->user) }}" class="ml-3 author_name">{{ $fr->user->full_name }}</a></div>
					    <a href="{{ route('theme.singleresource',$fr) }}" class="text-muted"><h5 class="card-title">{{ $fr->title }}</h5></a>
					  </div>
					  <div class="card-footer">
					  	<div style="display: grid;">
					  		<div style="grid-column: 1;border-right: 1px solid #333;"><small>VIEWS</small><br>{{ $fr->views }}</div>
					  		<div style="grid-column: 2;border-right: 1px solid #333;"><small>DOWNLOADS</small><br>{{ $fr->downloads }}</div>
					  		<div style="grid-column: 3;"><small>LIKES</small><br>{{ $fr->likes->count() }}</div>
					  	</div>
					  </div>
					</div>
				</div>
			</div>
			@empty
			<div class="col-md-4 offset-md-4">
				<h3>No Featured Resources</h3>
			</div>
			@endforelse
		</div>
	</div>
</section>

<section id="new_resources" class="text-center py-5">
	<div class="container">
		<h1 class="pb-5 heading">New Resources</h1>
		<p class="resource_heading">Check out these new amazing resources.</p>
		<div class="row new_resources_slider">
			@forelse($new_resources as $nr)
			<div class="col-md-3 featured_resource_box mb-4">
				<div class="resourcebox hvr-glow">
					<div class="card">
						<a href="{{ route('theme.singleresource',$nr) }}">
					  <img class="card-img-top" src="{{ $nr->preview_attachment_path }}" alt="Card image cap" style="position: relative;"></a>
					  <span style="position: absolute;top: -1;right: 10px;" id="saveResourceContainer_{{ $nr->id }}">
					  	@auth
					  	@if(!$nr->isResourceSavedByLoggedInUser())
					  	<a href="javascript:void(0);"  onclick='saveResource("{{ $nr->id }}",false);'>
					  	<img src="{{ asset('irh_assets/images/savelogo.png') }}" alt="" width="25px" data-toggle="tooltip" data-placement="top" title="save for later">
					  	</a>
					  	@else
					  	<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="25px">
					  	@endif
					  	@endauth
					  </span>
					  <div class="card-body">
					  	<div class="pb-4 author_profile"><img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle" style="display: inline-block;"><a href="{{ route('theme.resources.authorprofile',$nr->user) }}" class="ml-3">{{ $nr->user->full_name }}</a></div>
					    <a href="{{ route('theme.singleresource',$nr) }}" class="text-muted"><h5 class="card-title">{{ $nr->title }}</h5></a>
					  </div>
					  <div class="card-footer">
					  	<div style="display: grid;">
					  		<div style="grid-column: 1;border-right: 1px solid #333;"><small>VIEWS</small><br>{{ $nr->views }}</div>
					  		<div style="grid-column: 2;border-right: 1px solid #333;"><small>DOWNLOADS</small><br>{{ $nr->downloads }}</div>
					  		<div style="grid-column: 3;"><small>LIKES</small><br>{{ $nr->likes->count() }}</div>
					  	</div>
					  </div>
					</div>
				</div>
			</div>
			@empty
			<div class="col-md-4 offset-md-4">
				<h3>No Latest Resources</h3>
			</div>
			@endforelse
		</div>
		<div class="row pt-5">
			<div class="col-md-4 offset-md-4">
				<a href="{{ route('theme.resources') }}" class="btn btn-lg bg-yellow" style="border-radius: 2em;">Discover more Resources</a>
			</div>
		</div>
	</div>
</section>

<section id="testimonials" class="text-center py-5 bg-blue" style="border: none !important;">
	<div class="container">
		<h1 class="pb-2 signika" style="position: relative;">Testimonials</h1>
		<div class="testimonials_slider">
			@forelse($testimonials as $testimonial)
			<div class="item">
				<div class="card card-body" style="min-height: 300px;">
					<div class="py-5 blue-color">
						<p>
							{{ $testimonial->testimonial_text }}
						</p>
					</div>
					<div class="py-2">
						<img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle" style="display: inline-block;"><span class="ml-3 blue-color">{{ ucwords($testimonial->testimonial_by) }}</span>
					</div>
				</div>
			</div>
			@empty
			<div class="item">
				<div class="card card-body" style="min-height: 300px;">
					<div class="py-5 blue-color">
						<p>
							No Testimonials Found
						</p>
					</div>
				</div>
			</div>
			@endforelse
		</div>
	</div>
</section>

<section id="media_footer" style="background: grey;">
	<div class="container">
		<div class="row">
			<div class="col-md-6" id="nesletter_subscription">
				<h1 class="text-white signika">Subscribe to our mailing list</h1>
				<p class="tagline text-white">Subscribe and keep updated on new and particular resources shared</p>
				<form class="" action="{{ route('theme.newslettersubscription') }}" method="POST">
					<div id="form-container">
						<div style="grid-column: 1;">
							<input type="text" class="form-control" id="subscribeInput" placeholder="Type your e-mail address" name="email" style="background: grey;">
						</div>
						<div style="grid-column: 2;">
							<button class="btn" id="subscribeBtn" type="submit">Subscribe Now</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6" id="social_media">
				<h1 class="text-white signika">Social Media</h1>
				<p class="tagline text-white">Follow us on social media and stay updated</p>
				<div class="social-btns">
					<a href="#"> <img src="{{ asset("irh_assets/images/facebook-2.png") }}" alt=""> </a></a>
					<a href="#"> <img src="{{ asset("irh_assets/images/twitter-2.png") }}" alt=""> </a>
					<a href="#"> <img src="{{ asset("irh_assets/images/instagram-2.png") }}" alt=""> </i></a>
					<a href="#"> <img src="{{ asset("irh_assets/images/youtube.png") }}" alt=""> </a>
					<a href="#"> <img src="{{ asset("irh_assets/images/ooli.png") }}" alt=""> </a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--
<section id="newsletter" class="text-center py-5" style="background: grey;">
	<div class="container">
		<h1 class="pb-2 text-white signika">Subscribe to our newsletter</h1>
		<p class="pb-3 tagline text-white">Subscribe and keep updated on new and particular resources shared</p>
		<form action="{{ route('theme.newslettersubscription') }}" method="POST" class="my-3">
			@csrf
			<div id="form-container">
				<div style="grid-column:1;">
					<input type="text" class="form-control" id="subscribeInput" placeholder="Email ..." name="email" style="background: grey;">
				</div>
				<div style="grid-column: 2;">
					<button class="btn" id="subscribeBtn" type="submit">Subscribe Now</button>
				</div>
			</div>
		</form>
		@if(Session::has('success'))
		<div class="alert alert-success">
			{{ Session::get('success') }}
		</div>
		@endif
		@if($errors->has('email'))
		<div class="alert alert-danger">
			{{ $errors->first('email') }}
		</div>
		@endif
	</div>
</section>
-->
@endsection

@section('page_scripts')
<script src="{{ asset('irh_assets/vendor/slick/slick.min.js') }}" id="slick_js_path"></script>
<script src="{{ asset('irh_assets/js/slick-custom.js') }}?v={{ microtime() }}"></script>
@stop
