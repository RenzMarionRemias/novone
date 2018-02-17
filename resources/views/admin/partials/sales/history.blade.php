@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>
    <h4>Transaction History</h4>


    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#sales">Transaction History</a>
        </li>
        <li>
            <a data-toggle="tab" href="#pending">Pending Order</a>
        </li>
        <li>
            <a data-toggle="tab" href="#installment">Installment Order</a>
        </li>
        <li>
            <a data-toggle="tab" href="#delivered">Delivery</a>
        </li>
        <li>
            <a data-toggle="tab" href="#cancelled">Cancelled Orders</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="sales" class="tab-pane fade in active">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Type</th>
                        <th>Delivery Status</th>
                        <th>Client ID</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->transaction_id}}</td>
                        <td>
                        @if($invoice->payment_type == 'PAYPALINSTALLMENT')
                        INSTALLMENT
                        @else
                        {{$invoice->payment_type}}
                        @endif
                        </td>
                        <td>{{$invoice->delivery_status}}</td>
                        <td>{{$invoice->email}}</td>
                        <td>{{$invoice->invoice_total_amount}}</td>
                        <td>
                            <a href="/novone/public/admin/invoice/{{$invoice->invoice_id}}" class="btn btn-primary btn-invoice-details">View Order Details</a>
                            <div class="btn-group" role="group">
                                <button type="button" style="width:100%" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Update Status
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=SHIPPING">Shipping</a>
                                    </li>
                                    <li>
                                        <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=DELIVERED">Delivered</a>
                                    </li>
                                    <li>
                                        <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=CANCEL">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="pending" class="tab-pane fade in">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Type</th>
                        <th>Delivery Status</th>
                        <th>Client ID</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice) @if($invoice->delivery_status == "PENDING")
                    <tr>
                        <td>{{$invoice->transaction_id}}</td>
                        <td>@if($invoice->payment_type == 'PAYPALINSTALLMENT')
                        INSTALLMENT
                        @else
                        {{$invoice->payment_type}}
                        @endif</td>
                        <td>{{$invoice->delivery_status}}</td>
                        <td>{{$invoice->email}}</td>
                        <td>{{$invoice->invoice_total_amount}}</td>
                        <td>
                            <a href="/novone/public/admin/invoice/{{$invoice->invoice_id}}" class="btn btn-primary btn-invoice-details">View Order Details</a>
                            <div class="btn-group" role="group">
                                    <button type="button" style="width:100%" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Status
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=SHIPPING">Shipping</a>
                                        </li>
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=DELIVERED">Delivered</a>
                                        </li>
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=CANCEL">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                        </td>
                    </tr>
                    @endif @endforeach
                </tbody>
            </table>
        </div>

        <div id="installment" class="tab-pane fade in">
        <table class="table list-data">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Type</th>
                        <th>Delivery Status</th>
                        <th>Client ID</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice) 
                    @if($invoice->payment_type == 'PAYPALINSTALLMENT')
                    <tr>
                        <td>{{$invoice->transaction_id}}</td>
                        <td>@if($invoice->payment_type == 'PAYPALINSTALLMENT')
                        INSTALLMENT
                        @else
                        {{$invoice->payment_type}}
                        @endif</td>
                        <td>{{$invoice->delivery_status}}</td>
                        <td>{{$invoice->email}}</td>
                        <td>{{$invoice->invoice_total_amount}}</td>
                        <td>
                            <a href="/novone/public/admin/invoice/{{$invoice->invoice_id}}" class="btn btn-primary btn-invoice-details" style="width:100%">View Order Details</a><br/>
                            <a href="/novone/public/admin/invoice/payment/{{$invoice->invoice_id}}" class="btn btn-primary btn-invoice-details" style="width:100%">View Payment Schedule</a><br/>
                            <div class="btn-group" role="group"  style="width:100%">
                                    <button type="button" style="width:100%" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Update Status
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=SHIPPING">Shipping</a>
                                        </li>
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=DELIVERED">Delivered</a>
                                        </li>
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=CANCEL">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="delivered" class="tab-pane fade in">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Type</th>
                        <th>Delivery Status</th>
                        <th>Client ID</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice) @if($invoice->delivery_status == "DELIVERED")
                    <tr>
                        <td>{{$invoice->transaction_id}}</td>
                        <td>@if($invoice->payment_type == 'PAYPALINSTALLMENT')
                        INSTALLMENT
                        @else
                        {{$invoice->payment_type}}
                        @endif</td>
                        <td>{{$invoice->delivery_status}}</td>
                        <td>{{$invoice->email}}</td>
                        <td>{{$invoice->invoice_total_amount}}</td>
                        <td>
                            <a href="/novone/public/admin/invoice/{{$invoice->invoice_id}}" style="display:block;" class="btn btn-primary btn-invoice-details">View Order Details</a>
                            <a href="/novone/public/download/order/{{$invoice->invoice_id}}"  style="display:block;" class="btn btn-primary pull-right">Download Receipt</a>
                            <div class="btn-group" role="group"  style="display:block;">
                                    <button type="button" style="width:100%" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Update Status
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=SHIPPING">Shipping</a>
                                        </li>
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=DELIVERED">Delivered</a>
                                        </li>
                                        <li>
                                            <a href="/novone/public/admin/transaction/update?id={{$invoice->invoice_id}}&action=CANCEL">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                        </td>
                    </tr>
                    @endif @endforeach
                </tbody>
            </table>
        </div>

        <div id="cancelled" class="tab-pane fade in">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Type</th>
                        <th>Delivery Status</th>
                        <th>Client ID</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice) @if($invoice->delivery_status == "CANCEL")
                    <tr>
                        <td>{{$invoice->transaction_id}}</td>
                        <td>@if($invoice->payment_type == 'PAYPALINSTALLMENT')
                        INSTALLMENT
                        @else
                        {{$invoice->payment_type}}
                        @endif</td>
                        <td>{{$invoice->delivery_status}}</td>
                        <td>{{$invoice->email}}</td>
                        <td>{{$invoice->invoice_total_amount}}</td>
                        <td>
                            <a href="/novone/public/admin/invoice/{{$invoice->invoice_id}}" class="btn btn-primary btn-invoice-details">View Order Details</a>

                        </td>
                    </tr>
                    @endif @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>

<!--
<div class="modal fade" id="invoiceDetails" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="lineModalLabel">Invoice Details</h3>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table></table>
                </div>
                
                <h1>test</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <td>Product Code</td>
                        </tr>
                    </thead>
                    <tbody class="invoice-content">
                    </tbody>
                </table>

       
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <ul data-brackets-id="12674" id="sortable" class="list-unstyled ui-sortable">
                        <strong class="pull-left primary-font">James</strong>
                        <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span>7 mins ago</small>
                        </br>
                        <li class="ui-state-default">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                            ut aliquip ex ea commodo consequat. </li>
                        </br>
                        <strong class="pull-left primary-font">Taylor</strong>
                        <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span>14 mins ago</small>
                        </br>
                        <li class="ui-state-default">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                            id est laborum.</li>
                    </ul>

                    <table id="classTable" class="table table-bordered">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CLN</td>
                                <td>Last Updated Date</td>
                                <td>Class Name</td>
                                <td># Tests</td>
                                <td>Test Coverage (Instruction)</td>
                                <td>Test Coverage (Complexity)</td>
                                <td>Complex Covered</td>
                                <td>Complex Total</td>
                                <td>Category</td>
                            </tr>
                        </tbody>
                    </table>
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
        </div>
    </div>
</div>
-->