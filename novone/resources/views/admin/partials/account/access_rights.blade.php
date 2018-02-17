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
  <form class="form-horizontal"  action='/novone/public/admin/account/type/{{$accountTypeId}}' method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class="table">
    <thead>
      <tr>
        <th>Module</th>
        <th>Access</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Transaction</td>
        <td><input type="checkbox" @if($module_invoice == 1) checked @endif name="module_invoice"></td>
      </tr>
      <tr>
        <td>Products</td>
        <td><input type="checkbox"  @if($module_products == 1) checked @endif name="module_products"></td>
      </tr>
      <tr>
        <td>Maintenance</td>
        <td><input type="checkbox"  @if($module_maintenance == 1) checked @endif name="module_maintenance"></td>
      </tr>
      <tr>
        <td>Category</td>
        <td><input type="checkbox"  @if($module_category == 1) checked @endif name="module_category"></td>
      </tr>
      <tr>
        <td>Measurement</td>
        <td><input type="checkbox"  @if($module_measurement == 1) checked @endif name="module_measurement"></td>
      </tr>
      <tr>
        <td>Store</td>
        <td><input type="checkbox"  @if($module_store == 1) checked @endif name="module_store"></td>
      </tr>
      <!--
      <tr>
        <td>Product List</td>
        <td><input type="checkbox" name="module_invoice"></td>
      </tr>
      -->
      <tr>
        <td>Inventory</td>
        <td><input type="checkbox" @if($module_inventory == 1) checked @endif name="module_inventory"></td>
      </tr>
      <tr>
        <td>Messages</td>
        <td><input type="checkbox" @if($module_message == 1) checked @endif name="module_message"></td>
      </tr>
      <tr>
        <td>Logs</td>
        <td><input type="checkbox" @if($module_logs == 1) checked @endif name="module_logs"></td>
      </tr>
      <tr>
      <td>Customer</td>
      <td><input type="checkbox" @if($module_clients == 1) checked @endif name="module_clients"></td>
      </tr>
      <tr>
      <td>Reports</td>
      <td><input type="checkbox" @if($module_reports == 1) checked @endif name="module_reports"></td>
      </tr>
    </tbody>
    </table>

    <input type="submit" class="form-control pull-right" value="Save"/>
    </form>
</div>