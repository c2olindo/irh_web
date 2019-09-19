@extends('layouts.app')
@section('content')
<header  style="background:linear-gradient(rgba(30, 169, 231, 0.5),rgba(51, 57, 61, 0.5)),url({{ asset('irh_assets/images/contactbg.jpg') }});height: 820px;background-size: cover;background-position:center; ">
</header>
<section id="contactus" class="text-center py-5">
	<div class="container" style="margin-top:-25%;">
		<div class="row">
			<div class="col-md-8 px-0">
				<div class="card" style="height: 520px;">
					<div class="card-body p-5">
						<h3 class="mb-3 text-left">Contact us</h3>
						<form action="{{ route('theme.contactus.sendmail') }}" method="POST">
							@csrf
							<div class="form-group">
								<input type="text" class="form-control" placeholder="First Name" name="first_name">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Last Name" name="last_name">
							</div>
							<div class="form-group">
								<input type="email" class="form-control" placeholder="Email Address" name="email">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Subject" name="subject">
							</div>
							<div class="form-group">
								<textarea name="message" id="" rows="3" class="form-control" placeholder="Please type you message here..."></textarea>
							</div>
							<div class="form-group">
								<input type="submit" class="btn bg-yellow" value="Send Message">
							</div>
						</form>
						@if(Session::has('success'))
						<div class="alert alert-success">
							{{ Session::get('success') }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-4 px-0">
				<div class="card p-5 bg-blue text-white text-left" style="height: 520px;">
					<h3 class="mb-0 pb-4">As-salamu 'alaykum</h3>
					<p style="color:#fff;font-size: 22px;">
							Have a question? Want to give feedback? Or maybe a specific resource in mind that you would like to be made? <br><br>
							Contact us using this form.
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container mt-5">
		<h3 class="pb-5 m-0 heading">FAQs</h3>
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div id="accordion">
				  <div class="card">
				    <div class="card-header bg-blue">
				      <a class="card-link text-white" data-toggle="collapse" href="#collapseOne">
				        Does any of these resources cost anything?
				      </a>
				    </div>
				    <div id="collapseOne" class="collapse show" data-parent="#accordion">
				      <div class="card-body">
				        None of our resources that can be found on islamicresourcehub.com cost anything. We want to keep resources free. Forever.
				      </div>
				    </div>
				  </div>

				  <div class="card">
				    <div class="card-header bg-blue">
				      <a class="collapsed card-link text-white" data-toggle="collapse" href="#collapseTwo">
				        Are there any copyrights on any resource found on this website?
				      </a>
				    </div>
				    <div id="collapseTwo" class="collapse" data-parent="#accordion">
				      <div class="card-body">
				        None of the resources that can be found on the website have any copyrights attributed to them.
				      </div>
				    </div>
				  </div>

				  <div class="card">
				    <div class="card-header bg-blue">
				      <a class="collapsed card-link text-white" data-toggle="collapse" href="#collapseThree">
				        Are there any restrictions with what I can do with a resource once downloaded?
				      </a>
				    </div>
				    <div id="collapseThree" class="collapse" data-parent="#accordion">
				      <div class="card-body">
				        There are three licences with which an uploader can put up a resource with. They are as follows:
						<ol class="text-left mt-2">
							<li>Attribution License, it means the author wishes to retain their attribution to their work whilst freely allowing others to make changes to it and also to sell it on their own platforms.</li>
							<li>ShareALike Licence, which is the same as above but with the condition that those who download it must not sell that resource even if they make changes to the original.</li>
							<li>NoDerivatives Licence, this means the author wishes to retain their attribution to their work and they insist others do not share any changes they make to that resource.</li>
						</ol>
				      </div>
				    </div>
				  </div>

				  <div class="card">
				    <div class="card-header bg-blue">
				      <a class="collapsed card-link text-white" data-toggle="collapse" href="#collapseTwo">
				        Are resources found on this website vetted for inappropriate materials?
				      </a>
				    </div>
				    <div id="collapseTwo" class="collapse" data-parent="#accordion">
				      <div class="card-body">
				        All resources that can be found on islamicresourcehub.com are vetted by a team of qualified scholars. <br>
						Whilst we endeavour to make sure no inappropriate material are uploaded onto the website we may miss something. If you come across something which you deem to be inappropriate/offensive then you can easily report the resource and the uploader to our team of admins who will review the case and take action accordingly.
				      </div>
				    </div>
				  </div>

				</div>
			</div>
		</div>
	</div>
</section>
@stop
