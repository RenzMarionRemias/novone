@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>


  @if($errors) @foreach ($errors->all() as $error)
  <div class="alert alert-danger">
    {{ $error }}
  </div>
  @endforeach @endif

  @if(Session::has('updateInformationSuccess'))
  <div class="alert alert-success">
      Information has been updated successfully!
      @php
      Session::forget('updateInformationSuccess');
      @endphp
  </div>
  @endif
  
  <div class="col-xs-12 col-sm-6 col-md-5">
      <form class="form-inline" action='/novone/public/admin/user/update/information' method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
          <div id="legend">
            <legend class="">User Information</legend>
          </div>

          <div class="control-group">
              <label class="control-label" for="email">Email</label>
              <div class="controls">
                <input type="text" id="email" name="email" placeholder="" value="{{$user->email}}" class="form-control input-xlarge">
              </div>
            </div>
          <div class="control-group">
            <label class="control-label" for="lastname">Lastname</label>
            <div class="controls">
              <input type="text" id="lastname" name="lastname" placeholder="" value="{{$user->lastname}}" class="form-control input-xlarge">
            </div>
          </div>
  
          <div class="control-group">
            <label class="control-label" for="firstname">Firstname</label>
            <div class="controls">
              <input type="text" id="firstname" name="firstname" placeholder="" value="{{$user->firstname}}" class="form-control input-xlarge">
            </div>
          </div>
  
          <div class="control-group">
            <label class="control-label" for="middlename">Middlename</label>
            <div class="controls">
              <input type="text" id="middlename" name="middlename" placeholder="" value="{{$user->middlename}}" class="form-control input-xlarge">
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

  <div class="col-xs-12 col-sm-6 col-md-5">

    <form class="form-inline" action='/novone/public/admin/user/update/password' method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <fieldset>
        <div id="legend">
          <legend class="">Change Password</legend>
        </div>
        <div class="control-group">
          <label class="control-label" for="old_password">Old Password</label>
          <div class="controls">
            <input type="password" id="old_password" name="old_password" placeholder="" class="form-control input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="new_password">New Password</label>
          <div class="controls">
            <input type="password" id="new_password" name="new_password" placeholder="" class="form-control input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="repeat_new_password">Repeat New Password</label>
          <div class="controls">
            <input type="password" id="repeat_new_password" name="repeat_new_password" placeholder="" class="form-control input-xlarge">
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
</div>