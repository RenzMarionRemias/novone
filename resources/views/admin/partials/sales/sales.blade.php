@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:60px;'>
    <h1></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <strong>Order summary</strong>
                    </h3>
                </div>
                <div class="panel-body">
                    <!-- 
                        <tr>
                                <td style="font-weight:bolder;">Ordered by: </td>
                                <td style="font-weight:bolder;">
                                    <div>
                                        Payment Type {{$products[0]->payment_type}}
                                    </div>
                                    <div>
                                        Amount Paid P {{$products[0]->invoice_payment}}
                                    </div>
                                </td>
                                <td align="center" style="font-weight:bolder;">Total P {{$total}}</td>
                            </tr>
                            
-->

                    <div class="row">
                        <div class="col-xs-6">
                            <address>
                                <div>
                                    <b>Payment Type</b> 
                                    @if($products[0]->payment_type == "PAYPALINSTALLMENT")
                                    INSTALLMENT
                                    @else
                                    {{$products[0]->payment_type}}
                                    @endif
                                </div>
                                <div>
                                    @if($products[0]->payment_type == "PAYPALINSTALLMENT")
                                    <b> Initial Downpayment</b> P {{$products[0]->monthly_payment}}<br/>
                                    <b> Monthly Payment</b> P {{$products[0]->monthly_payment}}
                                    @else
                                    <b> Amount Paid</b> P {{$products[0]->invoice_payment}}
                                    @endif
                                </div>

                            </address>
                        </div>
                        <div class="col-xs-6">
                            <address align="right">
                                <strong>Billed To:</strong>
                                <br> {{ucfirst($client->firstname)}} {{ucfirst($client->lastname)}}
                                <br> {{$client->email}}
                            </address>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-xs-6">
                                    <address>
                                        <strong>Delivery Status:</strong>
                                        <div>
                                            {{$products[0]->delivery_status}}
                                        </div>

                                    </address>
                                </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td>
                                        <strong>Product Code</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>Quantity</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>Purchase Amount</strong>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{$product->product_code}}</td>
                                    <td class="text-center">{{$product->purchase_quantity}}</td>
                                    <td class="text-center">{{$product->purchase_amount}}</td>
                                </tr>
                                @endforeach

                                <tr>
                                <td></td>
                                <td></td>
                               <!-- <td style="text-align:center;font-weight:bolder;">Total: {{$total}}</td>-->
                                </tr>
                            </tbody>
                        </table>

                            
                    </div>
                    <div class="table-responsive">
                        
                    @if(count($paymentDate))
                    @if($products[0]->payment_type == 'PAYPALINSTALLMENT')
                        <table class="table table-condensed" style="text-align:center;">
                            <thead>
                                <tr>
                                    <td>
                                        <strong>Payment Date</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>Amount</strong>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($paymentDate as $pDate) 
                                <tr>
                                    <td>{{$pDate->payment_date}}</td>
                                    <td>P {{$pDate->amount_paid}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="text-align:center;font-weight:bolder;">Total: {{$total}}</td>
                            </tr>
                            </tbody>
                            </table>
                    @endif
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>