@extends('admin.main')


@include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:30px;'>

@if(Session::has('success'))
    <div class="alert alert-success">
        Product has been updated successfully! @php Session::forget('success'); @endphp
    </div>
    @endif

<!--
<div class='col-xs-12 col-sm-12 col-md-12 nopadding'>

  <form action='/novone/public/admin/product/search' method='post' class="form-inline" >
 <div class="control-group">
          <label class="control-label" for="product_name">Filter By:</label>
          <div class="controls">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <select class="form-control" id="search_category" name="product_search_category">
             <option value='ALL'>ALL</option>
                @foreach($categories as $category)
                    <option value='{{$category["id"]}}'>{{$category["name"]}}</option>
                @endforeach
            </select>

              <input type="submit"  placeholder="" class="form-control btn btn-primary input-xlarge">
          </div>
        </div>
    </form>
</div>
-->

<a href="/novone/public/products/download/pdf" class="pull-right">Download List of Products</a>
<table class="table list-data">
    <thead>
      <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Pcs Per Bundle</th>
        <th>Product Category</th>
        <th>Critical Level</th>
        <th>Price Per Bundle</th>
        <th>Price Per Item</th>

        <th>Date Added</th>
        <!--<th>Image</th>-->
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
            <td>{{$product->product_code}}</td>
            <td>{{$product->product_name}}</td>
            <td style="text-align:center;">{{$product->pcs_per_bundle}}</td>
            <!-- CATEGORY NAME -->
            <td>{{$product->name}}</td>
            <!-- ************* -->
            <td>{{$product->critical_level}}</td>
            <td>P{{$product->price}}</td>
            <td>P{{$product->price_per_item}}</td>
            <td>{{$product->created_at}}</td>

            <!--
            <td>
                <img src="/novone/storage/app/{{$product->image}}" width='35' height='35'/>
            </td>
            -->
            <td>
            <a href='#' class='btn btn-primary btn-edit-quantity'  data-toggle="modal" data-target="#inventoryQuantityModal"  data-id="{{$product->id}}" data-image="{{$product->image}}"  data-productcode="{{$product->product_code}}" data-productname="{{$product->product_name}}" data-producttype="{{$product->product_type}}">Add Stocks</a> 
            <a href='#' class='edit-product btn btn-info'  data-toggle="modal" data-target="#editProductInfo"  data-id="{{$product->id}}" data-image="{{$product->image}}"  data-productcode="{{$product->product_code}}" data-productname="{{$product->product_name}}" data-producttype="{{$product->product_type}}" data-criticallevel="{{$product->critical_level}}" data-productprice="{{$product->price}}" data-pcsperbundle="{{$product->pcs_per_bundle}}"
            data-measurementid="{{$product->product_measurement}}" 
            data-discount="{{$product->discount}}" data-priceperitem="{{$product->price_per_item}}" data-barcode="{{$product->barcode_image}}">Edit</a> 
            <a class='btn btn-danger' href='/novone/public/admin/product/delete/{{$product->id}}'>Delete</a>
            </td>
            </tr>
        @endforeach

    </tbody>
    </table>
    
</div>


<!-- MODAL HERE -->
<div class="modal fade" id="editProductInfo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel">Update Product Information</h3>
		</div>
			<form action='/novone/public/admin/product/update' method='post' enctype='multipart/form-data'>
    <div class="modal-body">
			
            <!-- content goes here -->
            {{ csrf_field() }}

            <div class="col-xs-12 col-sm-12 col-md-6">
              <div class="form-group">
                <label for="editProductCode">Product Code</label>
                <input type="text" class="form-control" id='editProductCode' name="editProductCode" >
              </div>
              <div class="form-group">
                <label for="editProductName">Product Name</label>
                <input type="text" class="form-control" id='editProductName' name="editProductName">
              </div>

              <div class="form-group">
                <label for="editProductPrice">Pcs per bundle</label>
                <input type="text" class="form-control" id='editPcsPerBundle' name="editPcsPerBundle">
              </div>

              <div class="form-group">
                <label for="editProductPrice">Measurement Unit</label>
                <select class="form-control" id="editMeasurementUnit" name="editMeasurementUnit">
                  <option>Please select a unit</option>
                @foreach($measurements as $unit)
                  <option value="{{$unit->measurement_id}}">{{$unit->measurement_name}}</option>
                @endforeach
                </select>
            
              </div>

              <div class="form-group">
                <label for="editProductPrice">Price Per Bundle</label>
                <input type="number" class="form-control" min="1" id='editProductPrice' name="editProductPrice">
              </div>

              <div class="form-group">
                <label for="editProductPricePerItem">Price Per Item</label>
                <input type="number" class="form-control"  min="1" id='editProductPricePerItem' name="editProductPricePerItem">
              </div>
            </div>
            <input type='hidden' name='hiddenProductId' id='hiddenProductId'>

            <div class="col-xs-12 col-sm-12 col-md-6">
              <div class="form-group">
                <label for="editProductPrice">Discount Percentage</label>
                <input type="number" class="form-control"  min="1" id='editDiscountPercentage' name="editDiscountPercentage">
              </div>

              <div class="form-group">
                <label for="productCategory">Product Type</label>
                    <select class='form-control' name='productCategory' id='productCategory'>
                        @foreach($categories as $category)
                            <option value='{{$category["id"]}}'>{{$category["name"]}}</option>
                        @endforeach
                    </select>
              </div>

            <div class="form-group">
                <label for="editCriticalLevel">Critical Level</label>
                <input type="text" class="form-control" id='editCriticalLevel' name="editCriticalLevel">
              </div>

            <div class="form-group">
                <label for="editProductName">Image</label><br>
               <img src='' id='editProductImage' width='200' height='200'>
               <br/>
               <input type="file" id="productImage" name="productImage" placeholder=""  accept="image/x-png,image/gif,image/jpeg">
            </div>
            
            <div class="form-group">
                <label for="editProductBarcodeImage">Barcode Image</label><br>
                <img src='' id='editProductBarcodeImage' width='100%' height='auto' style="max-height:400px;">
                <br/>
            </div>
            </div>


		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
				</div>
				<div class="btn-group btn-delete hidden" role="group">
					<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
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


<!-- ADD QUANTITY MODAL -->


<!-- QUANTITY MODAL -->

<div class="modal fade" id="inventoryQuantityModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="lineModalLabel">Update Product Bundle</h3>
                </div>
                <form action='/novone/public/admin/inventory/update/quantity' method='post'>
                    <div class="modal-body">
    
                        <!-- content goes here -->
                        {{ csrf_field() }}
                    
                        <div class="form-group">
                            <label>
                                <b>Product Code</b>
                            </label>
                            <span class="productCodeLabel"></span>
                        </div>
    
                        <div class="form-group">
                            <label>
                                <b>Product Name</b>
                            </label>
                            <span class="productNameLabel"></span>
                        </div>
                        <input type='hidden' class='hiddenProductCode' name='product_code' />
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" class="form-control" required id='editProductQuantity' name="quantity">
                        </div>

                        <div class="form-group">
                            <label>Manufactured Date</label>
                            <input type="date" class="form-control" required id='editManufacturedDate' name="manufactured_date">
                        </div>

                        <div class="form-group">
                            <label>Expiration Date Date</label>
                            <input type="date" class="form-control" required id='editExpirationDate' name="expiration_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
                            </div>
                            <div class="btn-group btn-delete hidden" role="group">
                                <button type="button"  class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">Delete</button>
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