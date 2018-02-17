 @include('home.index')

<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:80px !important;">


	<div class="container-fluid">
		<section class="container">
			<div class="container-page">
				<form action="/novone/public/client/register" method="POST"  enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="col-md-6">

						@if(Session::has('success'))
						<div class="alert alert-success">
							Client has been registered successfully! @php Session::forget('success'); @endphp
						</div>
						@endif @if($errors->all())
						<div class="alert alert-warning">
							@foreach ($errors->all() as $error) * - {{ $error }} @endforeach
						</div>
						@endif

						<div class="col-md-12">

							<h3 class="dark-grey">Registration</h3>

							<div class="form-group col-lg-12">
								<label>Email</label>
								<input type="email" name="email" required class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-4">
								<label>Lastname</label>
								<input type="text" required name="lastname" class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-4">
								<label>Firstname</label>
								<input type="text" required name="firstname" class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-4">
								<label>Middlename</label>
								<input type="text" name="middlename" class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-6">
								<br/>
								<label>Gender</label>
								<input type="radio" required name="gender" class="" id="" value="Male"> Male
								<input type="radio" required name="gender" class="" id="" value="Female"> Female
							</div>

							<div class="form-group col-lg-6">
								<label>Birthdate</label>
								<input type="date" required name="birthdate" class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-12">
								<label>Contact No.</label>
								<input type="text" required name="contact_no" class="form-control" id="" value="">
							</div>
<!--
							<div class="form-group col-lg-12">
								<label>Client Photo</label>
								<input type="file" required name="client_photo" class="dropify" />
							</div>
-->
						</div>

						<div class="col-md-12">

							<h3 class="dark-grey">Business</h3>
							<div class="form-group col-lg-12">
								<label>Business Name</label>
								<input type="text" required name="business_name" class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-12">
								<label>Business Address</label>
								<input type="text" required name="business_address" class="form-control" id="" value="">
							</div>

							<div class="form-group col-lg-12">
								<label>Business Contact</label>
								<input type="text" required name="business_contact" class="form-control" id="" value="">
							</div>

							<!--
							<div class="form-group col-lg-12">
								<label>Valid ID</label>
								<input type="file" required name="client_valid_id" class="dropify" />
							</div>
-->


						</div>

					</div>

					<div class="col-md-6">
						<h3 class="dark-grey">Terms and Conditions</h3>
						<p>
							By clicking on "Register" you agree to The Company's' Terms and Conditions
						</p>
						<p>
							While rare, prices are subject to change based on exchange rate fluctuations - should such a fluctuation happen, we may request
							an additional payment. You have the option to request a full refund or to pay the new price. (Paragraph 13.5.8)
						</p>
						<p>
							Should there be an error in the description or pricing of a product, we will provide you with a full refund (Paragraph 13.5.6)
						</p>
						<p>
							Acceptance of an order by us is dependent on our suppliers ability to provide the product. (Paragraph 13.5.6)
						</p>

						<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>
<br>
<br>
<br> @include('home.partials.footer')