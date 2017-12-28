@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

  @if(Session::has('success'))
    <div class="alert alert-success">
        Product has been added!
        @php
        Session::forget('success');
        @endphp
    </div>
    @endif


  @if($errors->all()) 
 <div class="alert alert-warning">
  @foreach ($errors->all() as $error)
    * - {{ $error }}
  @endforeach 
</div>
  @endif

  <form class="form-inline" action='/novone/public/admin/product/add' method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <fieldset>
      <div id="legend">
        <legend class="">Add New Product</legend>
      </div>
      <br/>


        <div class="control-group">
          <label class="control-label" for="product_code">Product Code</label>
          <div class="controls">
            <input type="text" id="product_code" name="product_code" placeholder="" class="form-control input-xlarge">
          </div>
        </div>
        <br/>


        <div class="control-group">
          <label class="control-label" for="product_name">Product Name</label>
          <div class="controls">
            <input type="text" id="product_name" name="product_name" placeholder="" class="form-control input-xlarge">
          </div>
        </div>
        <br/>


      <div class="control-group">
        <label class="control-label" for="productImage">Product Category</label>
        <div class="controls">
          <select class='form-control' name='productCategory' id='productCategory'>
            @foreach($categories as $category)
            <option value='{{$category["id"]}}'>{{$category["name"]}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <br/>

        <div class="control-group">
          <label class="control-label" for="product_name">Unit</label>
          <div class="controls">
            <input type="text" id="product_unit" name="product_unit" placeholder="" class="form-control input-xlarge">
            <select class="form-control" id="product_measurement" name="product_measurement">
              <option value="None">None</option>
              <option value="L">Liter</option>
              <option value="kg">Kilogram</option>
              <option value="g">Gram</option>
              <option value="NC">NC</option>
            </select>
          </div>
        </div>
        <br/>

        <div class="control-group">
          <label class="control-label" for="price">Price</label>
          <div class="controls">
            <input type="text" id="price" name="price" placeholder="" class="form-control input-xlarge">
          </div>
        </div>
        <br/>
        <div class="control-group">
          <label class="control-label" for="productImage">Image</label>
          <div class="controls">
            <input type="file" id="productImage" name="productImage" placeholder="" class="">
          </div>
        </div>
        <br/>




      <div class="control-group">
        <label class="control-label" for="price">Description</label>
        <div class="controls">
          <textarea id="desc" name="description" rows="5" cols="55" placeholder="" class="form-control input-xlarge"></textarea>
        </div>
      </div>
      <br/>


      <div class="control-group">
        <!-- Button -->
        <br/>
        <div class="controls">
          <button class="btn btn-success" width="100%">Save</button>
        </div>
      </div>


    </fieldset>
  </form>
</div>