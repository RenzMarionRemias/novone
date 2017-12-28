@extends('admin.main')


@include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    
    @if($errors)
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
    </div>
    @endif
    
  <form class="form-inline"  action='/novone/public/admin/user/update/password' method="POST">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <fieldset>
    <div id="legend">
      <legend class="">Change Password</legend>
    </div>
    <div class="control-group">
      <label class="control-label"  for="old_password">Old Password</label>
      <div class="controls">
        <input type="text" id="old_password" name="old_password" placeholder="" class="input-xlarge">
      </div>
    </div>

    <div class="control-group">
    <label class="control-label"  for="new_password">New Password</label>
    <div class="controls">
      <input type="text" id="new_password" name="new_password" placeholder="" class="input-xlarge">
    </div>
  </div>

  <div class="control-group">
      <label class="control-label"  for="repeat_new_password">Repeat New Password</label>
      <div class="controls">
        <input type="text" id="repeat_new_password" name="repeat_new_password" placeholder="" class="input-xlarge">
      </div>
    </div>

    <br>

    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success">Save</button>
      </div>
    </div>
  </fieldset>
</form>
</div>