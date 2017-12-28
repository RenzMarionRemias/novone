@extends('admin.main') @include('admin.partials.sidebar')



<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    @if(Session::has('success'))
    <div class="alert alert-success">
        Product has been updated successfully! @php Session::forget('success'); @endphp
    </div>
    @endif
    <h1>Inventories</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Critical Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <td>{{$inventory->product_code}}</td>
                <td>{{$inventory->product_name}}</td>
                <td>{{$inventory->quantity}}</td>
                <td>{{$inventory->price}}</td>
                <th>{{$inventory->critical}}</th>
                <td>
                    <a class="btn btn-primary btn-sm btn-edit-quantity" data-toggle="modal" data-target="#inventoryQuantityModal" data-productcode="{{$inventory->product_code}}"
                        data-quantity="{{$inventory->quantity}}" data-productname="{{$inventory->product_name}}">Update Quantity</a>
                    <a class="btn btn-danger btn-sm btn-edit-critical" data-toggle="modal" data-target="#inventoryCriticalModal" data-productcode="{{$inventory->product_code}}"
                        data-critical="{{$inventory->critical}}" data-productname="{{$inventory->product_name}}">Set Critical Level</a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>


<!-- MODAL HERE -->
<div class="modal fade" id="inventoryCriticalModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="lineModalLabel">Update Product Critical Level</h3>
            </div>
            <form action='/novone/public/admin/inventory/update/critical' method='post'>
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
                        <label>Critical Level</label>
                        <input type="text" class="form-control" required id='editCriticalLevel' name="critical">
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