@include('home.index')


<!-- ******************************************* -->
<div class="container">

    <div class='col-xs-12 col-sm-12 col-md-12' style='margin-top:120px;'>

        <ul class="nav nav-tabs" style='margin-bottom:20px;'>
            <li class="active">
                <a data-toggle="tab" href="#shoppingCart">Shopping Cart</a>
            </li>
            <li>
                <a data-toggle="tab" href="#orderStatus">Order Status</a>
            </li>
            <li>
                <a data-toggle="tab" href="#orderHistory">Returned Items</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="shoppingCart" class="tab-pane fade in active">
                <form action="/novone/public/cart/payment" method="POST">
                    <div id="example-basic" style="">
                        <h3>Orders</h3>
                        <section>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width:50%">Product Name</th>
                                        <th style="width:10%">Price</th>
                                        <th style="width:8%">Quantity</th>
                                        <th style="width:10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td data-th="Product Name">
                                            <div class="row">
                                                <div class="col-sm-2 hidden-xs">
                                                    <img src="/novone/storage/app/{{$product->image}}" class="img-responsive" />
                                                </div>
                                                <div class="col-sm-10">
                                                    <input type="hidden" id="{{$product->product_code}}Object" name="product[]" value="{{json_encode($product)}}" />
                                                    <h4 class="nomargin">{{$product->product_name}}</h4>
                                                    <p>{{$product->description}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">P {{$product->price}}</td>
                                        <td data-th="Quantity">
                                            <input type="number" name="quantity" class="form-control text-center cart-product-price" value="1" min="1">
                                            <input type="hidden" id="{{$product->product_code}}" class="" value="{{$product->price}}"/>
                                        </td>
                                  
                                        <td class="actions" data-th="">
                                            <button class="btn btn-info btn-sm">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                            <a class="btn btn-danger btn-sm" href="/novone/public/cart/delete/{{$product->cart_id}}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="visible-xs">
                                        <td class="text-center">
                                            <strong>Total </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" class="btn btn-warning">
                                                <i class="fa fa-angle-left"></i> Continue Shopping</a>
                                        </td>
                                        <td colspan="2" class="hidden-xs text-center">

                                        </td>
                                        <td colspan="2">
                                            <div class="form-group">
                                                <label for="sName">Payment Method</label>
                                                <select class="form-control" id="paymentMethod" name="payment_method">
                                                    <option value="CASH">CASH ON DELIVERY</option>
                                                    <option value="CHEQUE">CHEQUE</option>
                                                    <option value="PAYPAL">PAYPAL</option>
                                                </select>
                                            </div>
                                        </td>

                                        <!--
                                        <td class="hidden-xs text-center">
                                            <strong>Total P{{$total}}</strong>
                                        </td>
                                    -->
                                    </tr>

                                </tfoot>
                            </table>

                        </section>
                        <h3>Order Summary</h3>
                        <section style="overflow-y:scroll !important;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <h3 class="pull-right">Order # 12345</h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <address>
                                                <strong>Billed To:</strong>
                                                <br> John Smith
                                                <br> 1234 Main
                                                <br> Apt. 4B
                                                <br> Springfield, ST 54321
                                            </address>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <address>
                                                <strong>Shipped To:</strong>
                                                <br> {{ucfirst(session()->get('currentClient')['firstname'])}} {{ucfirst(session()->get('currentClient')['lastname'])}}
                                                <br> {{ucfirst(session()->get('currentClient')['business_address'])}}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <address>
                                                <strong>Payment Method:</strong>
                                                <br> <span id="paymentMethodLabel">CASH ON DELIVERY</span>
                                                <br> jsmith@email.com
                                            </address>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <address>
                                                <strong>Order Date:</strong>
                                                <br> March 7, 2014
                                                <br>
                                                <br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <strong>Order summary</strong>
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <strong>Item</strong>
                                                            </td>
                                                            <td class="text-center">
                                                                <strong>Price</strong>
                                                            </td>
                                                            <td class="text-center">
                                                                <strong>Quantity</strong>
                                                            </td>
                                                            <td class="text-right">
                                                                <strong>Totals</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productSummary">
                                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                        @foreach($products as $product)
                                                        <tr>
                                                            <td>{{$product->product_name}}</td>
                                                            <td class="text-center">P {{$product->price}}</td>
                                                            <td id="{{$product->product_code}}-cell" class="text-center">1</td>
                                                            <td id="{{$product->product_code}}-total-cell" class="text-right price-subtotal">P <span>{{$product->price}}</span></td>
                                                        </tr>
                                                        @endforeach
                                                        <!--
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Shipping</strong>
                                                            </td>
                                                            <td class="no-line text-right">$15</td>
                                                        </tr>
                                                    -->
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td class="no-line text-right" id="orderTotalPrice">P <span>{{$total}}</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                        <h3>Finished</h3>
                        <section>
                                <button type="submit" class="btn btn-success btn-block">Proceed Checkout
                                        <i class="fa fa-angle-right"></i>
                                </button>
                        </section>
                    </div>
                </form>

            </div>
            <div id="orderStatus" class="tab-pane fade in">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice Id</th>
                            <th>Ordered Date</th>
                            <th>Payment Type</th>
                            <th>Delivery Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div id="returnedItems" class="tab-pane fade in"></div>
        </div>
    </div>

</div>
<!-- ******************************************* -->

@include('home.partials.footer')