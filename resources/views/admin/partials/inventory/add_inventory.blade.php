@extends('admin.main')


@include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    
    @if($errors)
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
    @endif
    
    <form class="form-horizontal"  action='/novone/public/admin/inventory/update' method="POST" enctype="multipart/form-data">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <fieldset>
    <div id="legend">
      <legend class="">Inventory</legend>
    </div>
    <div class="control-group">
      <label class="control-label"  for="product_code">Product Code</label>
      <div class="controls">
        <select name='product_code'>    
            @foreach($products as $product)
                <option value="{{$product['product_code']}}">{{$product['product_name']}}</option>
            @endforeach
        </select>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label"  for="quantity">Quantity</label>
      <div class="controls">
        <input type="text" id="quantity" name="quantity" required placeholder="" class="input-xlarge">
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