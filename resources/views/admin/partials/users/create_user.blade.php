@extends('admin.main')


@include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    
    @if($errors->all())
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
     * {{ $error }}
    @endforeach
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success">
        Account has been created successfully!
        @php
        Session::forget('success');
        @endphp
    </div>
    @endif
    
    <form class="form-inline"  action='/novone/public/admin/user/create' method="POST">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <fieldset>
    <div id="legend">
      <legend class="">Create a new account</legend>
    </div>
    <div class="control-group">
      <label class="control-label">Lastname</label>
      <div class="controls">
        <input type="text" name="lastname" placeholder="" class="form-control input-xlarge">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Firstname</label>
      <div class="controls">
        <input type="text" name="firstname" placeholder="" class="form-control input-xlarge">
      </div>
    </div>

    <div class="control-group">
        <label class="control-label">Middlename</label>
        <div class="controls">
          <input type="text" name="middlename" placeholder="" class="form-control input-xlarge">
        </div>
      </div>

    <div class="control-group">
      <label class="control-label" for="email">Email</label>
      <div class="controls">
        <input type="text" id="email" name="email" placeholder="" class="form-control input-xlarge">
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="form-control input-xlarge">
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Password (Confirm)</label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="form-control input-xlarge">
  
      </div>
    </div>
 

    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Account Type</label>
      <div class="controls">
        <select class='form-control' name='account_type'>
          <option value='admin'>Admin</option>
          <option value='billing'>Billing</option>
          <option value='sales'>Sales</option>
        </select>
      </div>
    </div>

    <div class="control-group">
    <br/>
      <div class="controls">
        <button class="btn btn-success">Register</button>
      </div>
    </div>
  </fieldset>
</form>
</div>