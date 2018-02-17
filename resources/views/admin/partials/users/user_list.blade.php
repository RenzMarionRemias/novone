@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    @if(Session::has('success'))
    <div class="alert alert-success">
        Account has been updated successfully!
        @php
        Session::forget('success');
        @endphp
    </div>
    @endif

  <table class="table list-data">
    <thead>
      <tr>
      <th>Email</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Account Type</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user) @if($currentUserId != $user['id'])
      <tr>
      <td>
          <span id="display-email-{{$user['id']}}" class='field-display'>{{$user['email']}}</span>
          <input id="form-email-{{$user['id']}}" type='text' class='form-control field-edit' value="{{$user['email']}}">
        </td>
        <td>
          <span id="display-firstname-{{$user['id']}}" class='field-display'>{{$user['firstname']}}</span>
          <input id="form-firstname-{{$user['id']}}" type='text' class='form-control field-edit' value="{{$user['firstname']}}">
        </td>
        <td>
          <span id="display-lastname-{{$user['id']}}" class='field-display'>{{$user['lastname']}}</span>
          <input id="form-lastname-{{$user['id']}}" type='text' class='form-control field-edit' value="{{$user['lastname']}}">
        </td>
        <td>
          {{ucfirst($user['account_type'])}}
        </td>
        <td>
          @if($user['account_status'] == 1) Active @else Inactive @endif

        </td>
        <td>
          <div id="radioBtn" class="btn-group">
            <a class="btn btn-primary btn-sm edit-user" data-toggle="modal" data-target="#userModal" data-id="{{$user['id']}}"
              data-lastname="{{$user['lastname']}}" data-email="{{$user['email']}}" data-firstname="{{$user['firstname']}}"  data-middlename="{{$user['middlename']}}" 
              data-accounttype="{{$user['account_type']}}">Edit</a>
            @if($user['account_status'] == 1)
            <a href="/novone/public/admin/user/inactive/{{$user['id']}}" class="btn btn-danger btn-sm edit-user">Set As Inactive</a>
            @else
            <a href="/novone/public/admin/user/active/{{$user['id']}}" class="btn btn-success btn-sm edit-user" >Set As Active</a>
            @endif
          </div>
        </td>
      </tr>
      @endif @endforeach
    </tbody>
  </table>
</div>


<!-- MODAL HERE -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
          <span class="sr-only">Close</span>
        </button>
        <h3 class="modal-title" id="lineModalLabel">User Information</h3>
      </div>
      <form action='/novone/public/admin/user/update' method='post'>
        <div class="modal-body">

          <!-- content goes here -->
          {{ csrf_field() }}
          <div class="form-group">
            <label >Lastname</label>
            <input type="text" class="form-control" id='editLastname' name="editLastname">
          </div>
          <div class="form-group">
            <label >Firstname</label>
            <input type="text" class="form-control" id='editFirstname' name="editFirstname">
          </div>
          <div class="form-group">
              <label >Middlename</label>
              <input type="text" class="form-control" id='editMiddlename' name="editMiddlename">
            </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id='editEmail' name="editEmail">
          </div>
          <input type='hidden' name='currentEmail' id='currentEmail' />
          <div class="form-group">
            <label for="exampleInputEmail1">Account Type</label>
            <select class='form-control' id='editAccountType' name='account_type'>
              @foreach($accountType as $type) 
                <option value='{{$type["account_type_name"]}}'>{{$type['account_type_name']}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group btn-group-justified" role="group" aria-label="group button">
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
            </div>
            <div class="btn-group btn-delete hidden" role="group">
              <button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">Delete</button>
            </div>
            <div class="btn-group" role="group">
              <button type="submit" id="Submit" class="btn btn-success btn-hover-green" data-action="save" role="button">Save</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
