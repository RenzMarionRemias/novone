@include('home.index')


<!-- ******************************************* -->
<div class="container">

    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:120px;">
    @if(Session::has('success'))
    <div class="alert alert-success">
        Credentials has been updated successfully! @php Session::forget('success'); @endphp
    </div>
    @endif

    @if(Session::has('oldPasswordFailed'))
    <div class="alert alert-danger">
        Invalid Old Password! @php Session::forget('success'); @endphp
    </div>
    @endif

    @if(Session::has('repeatNewPasswordFailed'))
    <div class="alert alert-danger">
        New Password Not Match! @php Session::forget('success'); @endphp
    </div>
    @endif


  	@if($errors->all()) 
 		<div class="alert alert-warning">
  			@foreach ($errors->all() as $error)
    			* - {{ $error }}
  			@endforeach 
		</div>
  	@endif

	
    	<div class="col-md-6">
    		<h3 class="dark-grey">Update Eail Address</h3>
          <form action="/novone/public/account/update/email" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group col-lg-12">
                <label>Old Email Address</label>
                <input type="email" name="old_email" required class="form-control" id="" value="">
              </div>

              <div class="form-group col-lg-12">
                <label>New Email Address</label>
                <input type="email" required name="email" class="form-control" id="" 
                value="">
              </div>

              <div class="form-group col-lg-12">
                <label>Repeat New Email Address</label>
                <input type="email" required name="repeat_new_email" class="form-control" id="" 
                value="">
              </div>

              <div class="form-group col-lg-12">
                <input type="submit" required name="change_password_btn" class="form-control btn btn-success" id="" 
                value="Update Email">
              </div>
          </form>
      </div>

      <div class="col-md-6">
        <h3 class="dark-grey">Update Password</h3>
          <form action="/novone/public/account/update/password" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group col-lg-12">
                <label>Old Password</label>
                <input type="password" name="old_password" required class="form-control" id="" value="">
              </div>

              <div class="form-group col-lg-12">
                <label>New Password</label>
                <input type="password" required name="new_password" class="form-control" id="" 
                value="">
              </div>

              <div class="form-group col-lg-12">
                <label>Repeat New Password</label>
                <input type="password" required name="repeat_new_password" class="form-control" id="" 
                value="">
              </div>

              <div class="form-group col-lg-12">
                <input type="submit" required name="change_password_btn" class="form-control btn btn-success" id="" 
                value="Update Password">
              </div>
          </form>
      </div>

  </div>
</div>