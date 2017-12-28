@extends('admin.main')


@include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

@if(Session::has('success'))
    <div class="alert alert-success">
        Product has been updated successfully! @php Session::forget('success'); @endphp
    </div>
    @endif

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

<table class="table">
    <thead>
      <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Product Category</th>
        <th>Price</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
            <td>{{$product->product_code}}</td>
            <td>{{$product->product_name}}</td>
             <td>{{$product->name}}</td>
            <td>{{$product->price}}</td>
            <td>
                <img src="/novone/storage/app/{{$product->image}}" width='100' height='100'/>
            </td>

            <td>
            <a href='#' class='btn btn-primary btn-edit-quantity'  data-toggle="modal" data-target="#inventoryQuantityModal"  data-id="{{$product->id}}" data-image="{{$product->image}}"  data-productcode="{{$product->product_code}}" data-productname="{{$product->product_name}}" data-producttype="{{$product->product_type}}">Add to Inventory</a> 
            <a href='#' class='edit-product btn btn-info'  data-toggle="modal" data-target="#editProductInfo"  data-id="{{$product->id}}" data-image="{{$product->image}}"  data-productcode="{{$product->product_code}}" data-productname="{{$product->product_name}}" data-producttype="{{$product->product_type}}">Edit</a> 
            <a class='btn btn-warning' href='/novone/public/admin/product/delete/{{$product->id}}'>Delete</a>
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
            <input type='hidden' name='hiddenProductId' id='hiddenProductId'>
              <div class="form-group">
                <label for="editProductCode">Product Code</label>
                <input type="text" class="form-control" id='editProductCode' name="editProductCode" >
              </div>
              <div class="form-group">
                <label for="editProductName">Product Name</label>
                <input type="text" class="form-control" id='editProductName' name="editProductName">
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
                <label for="editProductName">Image</label><br>
               <img src='' id='editProductImage' width='200' height='200'>
               <br/>
               <input type="file" id="productImage" name="productImage" placeholder=""  accept="image/x-png,image/gif,image/jpeg">
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
                    <h3 class="modal-title" id="lineModalLabel">Update Product Quantity</h3>
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