@include('home.index')

<div class="container" style="padding-top:102px;">
<div class="row vertical-offset-100">
    <div class="col-md-4 col-md-offset-4">
    @if($errors->all())
	<div class="alert alert-warning">
		@foreach ($errors->all() as $error) * - {{ $error }} @endforeach
	</div>
    @endif

    @if(Session::has('forgotPasswordSubmitSuccess'))
	<div class="alert alert-success">
    Your password has been sent to your email!@php Session::forget('forgotPasswordSubmitSuccess'); @endphp
	</div>
    @endif
    @if(Session::has('accountNotExist'))
	<div class="alert alert-danger">
    Account does not exist!@php Session::forget('accountNotExist'); @endphp
	</div>
    @endif
    
        <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Forgot your password?</h3>
             </div>
              <div class="panel-body">
                <form action="/novone/public/forgotpassword" method="POST" accept-charset="UTF-8" role="form">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <fieldset>
                      <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="text">
                    </div>
                    <!--
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                        </label>
                    </div>
                    -->
                    <input class="btn btn-lg btn-success btn-block" type="submit" value="Submit">

                </fieldset>
                  </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<br>
<br>
<br> @include('home.partials.footer')