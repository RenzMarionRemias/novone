@include('home.index')

<div class="wrap" style="margin-top:82px; background-color:white !important;">
    <div class="menu">
        <div class="mini-menu">
            <ul>
                @foreach($categories as $category)
                <li class="sub">
                    <a href="/novone/public/products/{{$category['id']}}">{{$category['name']}}</a>
                    <!--
                        <ul>
                            <li>
                                <a href="#">Jackets</a>
                            </li>
                            <li>
                                <a href="#">Blazers</a>
                            </li>
                        </ul>
                    -->
                </li>
                @endforeach

            </ul>
        </div>
        <!--
        <div class="menu-size menu-item">
            <div class="header-item">Size</div>
            <ul class="color-row1">
                <li class="color-circle size-circle">
                    <p class="sizedouble">XS</p>
                </li>
                <li class="color-circle size-circle" style="background-color:#343534">
                    <p style="color:#999" class="size">S</p>
                </li>
                <li class="color-circle size-circle">
                    <p class="size">M</p>
                </li>
                <li class="color-circle size-circle">
                    <p class="size">L</p>
                </li>
                <li class="color-circle size-circle">
                    <p class="sizedouble">XL</p>
                </li>
            </ul>
        </div>
        -->
        <!--
        <div class="menu-price menu-item">
            <div class="header-item">Price</div>
            <p>
                <label for="amount">Price range:</label>
                <input type="text" readonly id="amount" style="border:0; color:#f6931f; font-weight:bold;">
            </p>
            <div id="slider-range"></div>
        </div>
        -->

    </div>

    <div class="items" style="background-color:white;">


        @if(Session::has('success'))
        <div class="alert alert-success">
            Product has been added to cart successfully! 
        </div>
        @endif

        <div class="items" style="background-color:white;">
            @foreach($products as $product)
            <div data-price="{{$product->price}}" class="item">
                <img src="/novone/storage/app/{{$product->image}}" alt="jacket" class="img-item" style="object-fit: cover;" />
                <div class="info" style="text-align:center;">
                    <h3>{{$product->product_name}}</h3>
                    <!--<p class="product-description" style="text-align:center;">{{$product->description}}</p>-->
                    <h5>P{{$product->price}}</h5>
                    <a href="#" class="btn btn-primary btn-show-product-information" data-toggle="modal" data-target="#productInformation" data-productid="{{$product->id}}"
                        data-productcode="{{$product->product_code}}" data-productname="{{$product->product_name}}" data-price="{{$product->price}}"
                        data-description="{{$product->description}}" data-productimage="/novone/storage/app/{{$product->image}}">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</div>



<div class="modal fade" id="productInformation" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="lineModalLabel">Product Information</h3>
            </div>
            <form action='/novone/public/cart/add' method='post'>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-8">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_code" id="productCode" />
                            <div class="form-group">
                                <label>Product Code</label>
                                <p id="clientProductCode"></p>
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <p id="clientProductName"></p>
                            </div>
                            <div class="form-group">
                                <label>Product Description</label>
                                <p id="clientProductDescription"></p>
                            </div>
                            <div class="form-group">
                                <label>Product Price</label>
                                <p id="clientProductPrice"></p>
                            </div>
                            <!--
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="0" />
                            </div>
                            -->
                        </div>

                        <div class="col-md-4">
                            <img id="clientProductImage" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
                            </div>
                            @if(Session::has('currentClient'))
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-primary btn-hover-green" data-action="save" role="button">Add to cart</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@include('home.partials.footer')