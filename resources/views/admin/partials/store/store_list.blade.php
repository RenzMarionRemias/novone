@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>
    <h1>Stores</h1>
    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#home">Products</a>
        </li>

    </ul>

    <div class="tab-content">
        <div id="sales" class="tab-pane fade in active">
            <table class="table list-data" style="text-align:center;">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Price Per Bundle</th>
                        <th>Price Per Item</th>
                        <th>Critical Level</th>
                        <th>Pieces Per Bundle</th>
                        <th>Total Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($storeProducts as $products)
                        <tr @if($products->total_quantity <= $products->critical_level) style="background-color:red;" @endif
                            @if(($products->critical_level + 20) >= $products->total_quantity) style="background-color:yellow;" @endif>
                            <td>{{$products->product_code}}</td>
                            <td>{{$products->product_name}}</td>
                            <td>{{$products->price}}</td>
                            <td>{{$products->price_per_item}}</td>
                            <td>{{$products->critical_level}}</td>
                            <td>{{$products->pcs_per_bundle}}</td>
                            <td>{{$products->total_quantity}}</td>
                            <td> 
                                <a class="btn btn-primary btn-sm btn-pull-out-store-products" data-toggle="modal" data-target="#pullOutStoreProduct" data-productcode="{{$products->product_code}}" data-productname="{{$products->product_name}}" data-pcsperbundle="{{$products->pcs_per_bundle}}"
                                data-totalquantity="{{$products->total_quantity}}"
                                data-price="{{$products->price}}"
                                data-priceperitem="{{$products->price_per_item}}"
                                >Pull Out Products</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
        </div>
    </div>
</div>


<div class="modal fade" id="pullOutStoreProduct" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="lineModalLabel">Pull Out Store Product</h3>
                </div>
                <form action='/novone/public/admin/stores/pullout' method='post'>
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
                        <input type='hidden' class='hiddenPullOutProductCode' name='product_code' />
                        <input type='hidden' class='hiddenPcsPerBundle' name='pcs_per_bundle' />
                        <input type='hidden' class='hiddenTotalQuantity' name='total_quantity' />
                        <input type='hidden' class='hiddenTotalPrice' name='price' />
                        <input type='hidden' class='hiddenTotalPullOutQuantity' name='total_pull_out_quantity'/>
                        <input type='hidden' class='hiddenPullOutTotalAmount' name='pull_out_total_amount'/>
                        <div class="form-group">
                            <label>Pull Out Type</label>
                            <select class="form-control" id="pullOutType" name="pull_out_type">
                                <option value="DEFECT">DEFECT</option>
                                <option value="SALES">SALES</option>
                            </select>   
                        </div>
                        <div class="form-group">
                            <label>Deduction Type</label>
                            <select class="form-control" name="deduct_type" id="deductType">
                                <option value="BUNDLE">PER BUNDLE</option>
                                <option value="ITEM">PER ITEM</option>
                            </select>  
                        </div>
                        <div class="form-group">
                            <label>No. of items/bundle</label>
                            <input type="number" class="form-control" name="item_amount" id="pullOutAmount" min="1"/>
                        </div>

                        <div class="form-group" id="pullOutTotalAmount" style="display:none;">
                            <label>Total Amount: <span id="pullOutTotalAmountLabel"></span></label>  
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