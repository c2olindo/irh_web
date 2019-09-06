@extends('layouts.app')
@section('content')
<header id="supportusheader">
	<div id="bottomScrollerContainer">
		<p style="
		    font-weight: bold;
		    font-size: 20px;
		    color: #fff;
		">Scroll Down</p>
		<a href="#" id="bottomScroller"><i class="fa fa-angle-down"></i></a>
	</div>
</header>
<section id="supportus" class="text-center py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<img src="{{ asset('irh_assets/images/spread.png') }}" alt="">
				<div class="py-2">
					<h3 class="text-muted">Spread the word</h3>
					<div class="pt-3 pb-2">
						<p>Help us spread the word by following us on facebook, twitter and Instagram. Also share the website!</p>
					</div>
					<a href="" class="btn btn-block bg-blue">Spread the Word</a>
				</div>
			</div>
			<div class="col-md-4">
				<img src="{{ asset('irh_assets/images/monthly.png') }}" alt="">
				<div class="py-2">
					<h3 class="text-muted">Give Monthly</h3>
					<div class="pt-3 pb-2">
						<p>Support us by donating a small amount each month. The price of a cup of coffee is all we need!</p>
					</div>
					<a href="#" class="btn btn-block bg-blue" data-toggle="modal" data-target="#oneTimeDonationModal">Give Monthly</a>
				</div>
			</div>
			<div class="col-md-4">
				<img src="{{ asset('irh_assets/images/now.png') }}" alt="">
				<div class="py-2">
					<h3 class="text-muted">Give Now</h3>
					<div class="pt-3 pb-2">
						<p>Donate and help develop the platform to support teachers worldwide.</p>
						<br>
					</div>
					<a href="#" class="btn btn-block bg-blue" data-toggle="modal" data-target="#oneTimeDonationModal">Make a One-Time Donation</a>
				</div>
			</div>
		</div>

		@if(Session::has('success'))
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success">
					{{Session::get('success') }}
				</div>
			</div>
		</div>
		@endif
	</div>
</section>
<div class="modal fade" id="oneTimeDonationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">One-Time Donation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('theme.supportus.donationonetime') }}" method="post">
			@csrf
		 <div class="form-group">
		 	<label for="">Enter donation amount (in USD)</label>
		 	<input type="number" class="form-control" name="amount" id="custom-donation-amount" placeholder="e.g. 10" min="1" step="10.00" />
		 </div>
		  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		            data-key="<?php echo env('STRIPE_KEY'); ?>"
		            data-name="Islamic Resource Hub"
					data-description="One-Time Donation"
					data-locale="auto"
					data-label="Donate Now"
					data-currency="usd">
		          	></script>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop
@section('page_scripts')
<script>
	$("#bottomScroller").bind('click',function() {
	    $('html, body').animate({
	        scrollTop: $("#supportus").offset().top
	    }, 2000);
	});
</script>
@stop