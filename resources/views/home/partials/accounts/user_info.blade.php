@include('home.index')


<!-- ******************************************* -->
<div class="container">

    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:120px;">
    	@if(Session::has('success'))
    <div class="alert alert-success">
        User Information has been updated successfully! @php Session::forget('success'); @endphp
    </div>
    @endif

  	@if($errors->all()) 
 		<div class="alert alert-warning">
  			@foreach ($errors->all() as $error)
    			* - {{ $error }}
  			@endforeach 
		</div>
  	@endif

		<form action="/novone/public/account/update" method="POST">
    	<div class="col-md-6">
    		
				<h3 class="dark-grey">User Information</h3>
						
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group col-lg-12">
								<label>Email</label>
								<input type="email" name="email" required class="form-control" id="" value="{{$userInformation['email']}}">
							</div>

							<div class="form-group col-lg-4">
								<label>Lastname</label>
								<input type="text" required name="lastname" class="form-control" id="" 
								value="{{$userInformation['lastname']}}">
							</div>

							<div class="form-group col-lg-4">
								<label>Firstname</label>
								<input type="text" required name="firstname" class="form-control" id="" 
								value="{{$userInformation['firstname']}}">
							</div>

							<div class="form-group col-lg-4">
								<label>Middlename</label>
								<input type="text" name="middlename" class="form-control" id="" 
								value="{{$userInformation['middlename']}}">
							</div>

							<div class="form-group col-lg-6">
								<br/>
								<label>Gender</label>
								<input type="radio" required name="gender" class="" id="" value="Male"
								@if($userInformation['gender'] == 'Male')  checked @endif> Male
								<input type="radio" required name="gender" class="" id="" value="Female"
								@if($userInformation['gender'] == 'Female')  checked @endif> Female
							</div>

							<div class="form-group col-lg-6">
								<label>Birthdate</label>
								<input type="date" required name="birthdate" class="form-control" id="" value="{{$userInformation['birthdate']}}">
							</div>

							<div class="form-group col-lg-12">
								<label>Contact No.</label>
								<input type="text" required name="contact_no" class="form-control" id="" value="{{$userInformation['contact_no']}}">
							</div>
							<!--
							<div class="form-group col-lg-12">
								<label>Client Photo</label>
								<input type="file" required name="client_photo" class="dropify" />
							</div>
							-->
						</div>

						<div class="col-md-6">

							<h3 class="dark-grey">Business Information</h3>
							<div class="form-group col-lg-12">
								<label>Business Name</label>
								<input type="text" required name="business_name" class="form-control" id="" 
								value="{{$userInformation['business_name']}}">
							</div>

							<div class="form-group col-lg-12">
								<label>Business Address</label>
								<input type="text" required name="business_address" class="form-control" id="" 
								value="{{$userInformation['business_address']}}">
							</div>

							<div class="form-group col-lg-12">
								<label>Business Contact</label>
								<input type="text" required name="business_contact" class="form-control" id="" 
								value="{{$userInformation['business_contact']}}">
							</div>

							<!--
							<div class="form-group col-lg-12">
								<label>Valid ID</label>
								<input type="file" required name="client_valid_id" class="dropify" />
							</div>
							-->
							<div class="form-group col-lg-12">
								<input class="btn btn-lg btn-success" type="submit" value="Save">
							</div>
						</div>
			</form>
    </div>	
</div>


@include('home.partials.footer')