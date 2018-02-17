@extends('admin.main')


<div id="fullscreen_bg" class="fullscreen_bg" />

<div class="container">


	<form action='./admin/login' method='POST' class="form-signin">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h1 class="form-signin-heading text-muted">Sign In</h1>
		<input type="text" class="form-control" name='email' placeholder="Email address" required="" autofocus="">
		<input type="password" class="form-control" name='password' placeholder="Password" required="">
		<button class="btn btn-lg btn-primary btn-block" type="submit">
			Sign In
		</button>


		@if(Session::has('loginFailed'))
		<div class="alert alert-danger" style="margin-top:25px;">
			Invalid Login @php Session::forget('loginFailed'); @endphp
		</div>
		@endif
	</form>

</div>