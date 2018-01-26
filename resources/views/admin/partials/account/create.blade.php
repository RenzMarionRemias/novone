@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

  @if(Session::has('success'))
    <div class="alert alert-success">
        Account Type has been added!
        @php
        Session::forget('success');
        @endphp
    </div>
  @endif

  <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#createAccountType" style="margin-bottom:42px;">New</a> 


<table class="table list-data">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Products</th>
        <th>Invoice</th>
        <th>Inventory</th>
        <th>Maintenance</th>
        <th>Clients</th>
        <th>Users</th>
        <th>Action</th>

      </tr>
    </thead>
    <tbody>
        @foreach($accountType as $type)
          <tr>
              <td>{{$type['account_type_name']}}</td>
              <td>{{$type['account_type_status']}}</td>
              <td>{{$type['module_products'] ? 'ON' : 'OFF'}}</td>
              <td>{{$type['module_invoice'] ? 'ON' : 'OFF'}}</td>
              <td>{{$type['module_inventory'] ? 'ON' : 'OFF'}}</td>
              <td>{{$type['module_maintenance'] ? 'ON' : 'OFF'}}</td>
              <td>{{$type['module_clients'] ? 'ON' : 'OFF'}}</td>
              <td>{{$type['module_users'] ? 'ON' : 'OFF'}}</td>
              <td>
              <a href="#" class="btn btn-primary">Edit</a>
              @if($type['account_type_status'] == 'ACTIVE')
              <a href="/novone/public/admin/account/type/inactive/{{$type['account_type_id']}}" class="btn btn-danger" >Set as inactive</a>
              @else
              <a href="/novone/public/admin/account/type/active/{{$type['account_type_id']}}" class="btn btn-info" >Set as active</a>
              @endif
              </td>
          </tr>
        @endforeach
    </tbody>
  </table>
</div>




<div class="modal fade" id="createAccountType" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="lineModalLabel">Create Account Type</h3>
                </div>
                <form action="/novone/public/admin/account/type/create" method="post">
                    <div class="modal-body">
    
                        <!-- content goes here -->
                        {{ csrf_field() }}
    
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="control-group">
                            <label class="control-label" for="account_type_name">Account Type Name</label>
                            <div class="controls">
                              <input type="text" id="account_type_name" name="account_type_name" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>
                       </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom:32px;">
                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom:14px;">
                            <b>Module Access </b>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <label class="control-label" for="account_type_name">Products</label>
                             <div class="controls">
                            <input type="checkbox" name="module_products" style="width:16px;height:16px;" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <label class="control-label" for="account_type_name">Inventory</label>
                             <div class="controls">
                            <input type="checkbox" name="module_inventory" style="width:16px;height:16px;" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <label class="control-label" for="account_type_name">Invoice</label>
                             <div class="controls">
                            <input type="checkbox" name="module_invoice" style="width:16px;height:16px;" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <label class="control-label" for="account_type_name">Maintenance</label>
                             <div class="controls">
                            <input type="checkbox" name="module_maintenance" style="width:16px;height:16px;" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <label class="control-label" for="account_type_name">Clients</label>
                             <div class="controls">
                            <input type="checkbox" name="module_clients" style="width:16px;height:16px;" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-4">
                            <label class="control-label" for="account_type_name">Users</label>
                             <div class="controls">
                            <input type="checkbox" name="module_users" style="width:16px;height:16px;" placeholder="" class="form-control input-xlarge">
                            </div>
                          </div>



                      </div>

                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
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