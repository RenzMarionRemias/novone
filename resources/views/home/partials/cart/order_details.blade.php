@include('home.index')

<div class="container" style="padding-top:42px;padding-left:180px;padding-right:180px;">

    <div class="row">
        <div class="col-xs-12" style="margin-top:24px;">
            <div class="invoice-title">
                <h2>Transaction Details</h2><h3 class="pull-right" style="font-weight:bolder;">Order # {{$transaction->transaction_id}}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                    <strong>Billed To:</strong><br>
                        {{ucfirst(session()->get('currentClient')['firstname'])}}  {{ucfirst(session()->get('currentClient')['lastname'])}}<br>
                        {{ucfirst(session()->get('currentClient')['business_address'])}}<br>
                    </address>
                </div>
                
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Payment Method:</strong><br>
                        @if($transaction->payment_type == 'PAYPALINSTALLMENT')
                        INSTALLMENT
                        @else
                        {{$transaction->payment_type}}
                        @endif
                    </address>
                </div>
                
            </div>
            <div class="row">
                <div class="col-xs-6">
                <address>
                        <strong>Delivery Status:</strong><br>
                        {{$transaction->delivery_status}}<br><br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{$transaction->created_at}}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top:15px;">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed" style="text-align:center;">
    						<thead>
                                <tr>
        							<td><strong>Product Code</strong></td>
                                    <td><strong>Product Name</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach($orderedProducts as $product)
    							<tr>
    								<td>{{$product->product_code}}</td>
                                    <td>{{$product->product_name}}</td>
    								<td class="text-center">{{$product->purchase_amount}}</td>
    								<td class="text-center">{{$product->purchase_quantity}}</td>
    								<td class="text-right">{{$product->purchase_amount * $product->purchase_quantity}}</td>
    							</tr>
                                @endforeach
                                
    							<tr>
    								<td class="thick-line"></td>
                                    <td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">{{$total}}</td>
    							</tr>
                                <!--
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    <td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">$15</td>
    							</tr>
                                -->
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    <td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">P{{$total}}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>  
                    @if($transaction->payment_type == 'PAYPALINSTALLMENT')
                    @if($paymentDate)
                    <div class="panel-heading">
    				    <h3 class="panel-title"><strong>Monthly Payment summary</strong></h3>
    			    </div>
    				<div class="table-responsive">
    					<table class="table table-condensed" style="text-align:center;">
    						<thead>
                                <tr>
        							<td><strong>Payment Date</strong></td>
                                    <td><strong>Payment Status</strong></td>
                                    <td><strong>Amount</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach($paymentDate as $date)
    							<tr>
    								<td>{{$date->payment_date}}</td>
                                    <td>{{$date->payment_status}}</td>
    								<td class="text-center">{{$date->amount_paid}}</td>
    							</tr>
                                @endforeach
                                
    						</tbody>
    					</table>
    				</div>
                    @endif
                    @endif
    			</div>
    		</div>
    	</div>
    </div>
</div>

@include('home.partials.footer')