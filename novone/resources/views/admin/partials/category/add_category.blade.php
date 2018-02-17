@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>


  @if($errors) @foreach ($errors->all() as $error)
  <div>{{ $error }}</div>
  @endforeach @endif

  <form class="form-inline" action='/novone/public/admin/category/add' method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <fieldset>
      <div id="legend">
        <legend class="">Add New Category</legend>
      </div>
      <div class="control-group">
        <label class="control-label" for="product_name">Category Name</label>
        <div class="controls">
          <input type="text" id="category_name" name="category_name" placeholder="" class="form-control">
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