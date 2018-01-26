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
 
  @foreach ($errors->all() as $error)
  <div class="alert alert-warning">
    * - {{ $error }}
  </div>
  @endforeach 

  @endif
  
  <form class="form-inline" action='/novone/public/admin/product/add' method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <fieldset>
      <div id="legend">
        <legend class="">Add New Product</legend>
      </div>
      <br/>

      <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="control-group">
          <label class="control-label" for="product_code">Product Code</label>
          <div class="controls">
            <input type="text" id="product_code" disabled  placeholder="" class="form-control input-xlarge">
            <input type="hidden" id="hiddenProductCode"  name="product_code" placeholder="" class="form-control input-xlarge">
            <input type="hidden" name="barcode_image" id="barcodeImage"/> 
            <input type="button" class="btn btn-primary" id="enableProductCode" value="Edit"/>
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
          <label class="control-label" for="product_name">Pieces Per Bundle</label>
          <div class="controls">
            <input type="text" id="pcs_per_bundle" name="pcs_per_bundle" placeholder="" class="form-control input-xlarge">
          </div>
        </div>
        <br/>


      <div class="control-group">
        <label class="control-label" for="productImage">Product Category</label>
        <div class="controls">
          <select class='form-control' name='product_category' id='product_category'>
           <option value='0'>Please select a category</option>
            @foreach($categories as $category)
            <option value='{{$category["id"]}}'>{{$category["name"]}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <br/>

      <div class="control-group">
        <label class="control-label" for="critical_level">Critical Level</label>
        <div class="controls">
          <input type="text" class="form-control" id="critical_level" name="critical_level"/>
        </div>
      </div>
      </br>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="control-group">
          <label class="control-label" for="product_name">Unit</label>
          <div class="controls">
            <input type="text" id="product_unit" name="product_unit" placeholder="" class="form-control input-xlarge">
            <select class="form-control" id="product_measurement" name="product_measurement">
                  <option>Please select a unit</option>
                @foreach($measurements as $unit)
                  <option value="{{$unit->measurement_id}}">{{$unit->measurement_name}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <br/>

        <div class="control-group">
          <label class="control-label" for="price">Price Per Bundle</label>
          <div class="controls">
            <input type="text" id="price" name="price" placeholder="" class="form-control input-xlarge">
          </div>
        </div>
        <br/>
        <div class="control-group">
          <label class="control-label" for="price">Price Per item</label>
          <div class="controls">
            <input type="text" id="price_per_item" name="price_per_item" placeholder="" class="form-control input-xlarge">
          </div>
        </div>

        <br/>
        <!--
        <div class="control-group">
          <label class="control-label" for="price">Discount Percentage</label>
          <div class="controls">
   
            <input type="number" id="discount" min="0" max="70" value="0" name="discount" placeholder="" class="form-control input-xlarge">
        
          </div>
        </div>
        -->
        <!--

        <div class="control-group">
          <label class="control-label" for="manufactured_date">Manufactured Date</label>
          <div class="controls">
            <input type="date" id="manufactured_date" name="manufactured_date" placeholder="" class="form-control input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="expiration_date">Expiration Date</label>
          <div class="controls">
            <input type="date" id="expiration_date" name="expiration_date" placeholder="" class="form-control input-xlarge">
          </div>
        </div>

        -->

      <div class="control-group">
        <label class="control-label" for="price">Description</label>
        <div class="controls">
          <textarea id="desc" name="description" rows="5" cols="55" placeholder="" class="form-control input-xlarge"></textarea>
        </div>
      </div>
      <br/>

      <div class="control-group">
          <label class="control-label" for="productImage">Image</label>
          <div class="controls">
            <input type="file" id="productImage" name="product_images" placeholder="" class="">
          </div>
        </div>
      <br/>


      <div class="control-group">
        <div class="controls">
          <button class="btn btn-success pull-right" style="margin-right:62px" width="100%">Save</button>
        </div>
      </div>
      </div>


    </fieldset>
  </form>
</div>

