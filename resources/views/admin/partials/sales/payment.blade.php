@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>
    @if(Session::has('success'))
        <div class="alert alert-success">
            Transaction has been marked as paid
            @php
            Session::forget('success');
            @endphp
        </div>
    @endif
    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#measurement">Payment Schedule</a>
        </li>

    </ul>

    <div class="tab-content">
        <div id="measurement" class="tab-pane fade in active">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Status</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($payments as $payment)
                            <tr @if($payment->payment_status == "PAID") style="background-color:#7aff85;"; @endif>    
                                <td>{{$payment->transaction_id}}</td>
                                <td>
                                    @if($payment->payment_status == 'NOTPAID')
                                        NOT PAID
                                    @else
                                        PAID
                                    @endif
                                </td>
                                <td>{{$payment->amount_paid}}</td>
                                <td>{{$payment->payment_date}}</td>
                                <td>
                                    @if($payment->payment_status == 'NOTPAID')
                                    <a href="/novone/public/admin/invoicepaymentstatus/{{$payment->invoice_id}}?id={{$payment->installment_id}}&status=PAID" class="btn btn-success" >Mark as Paid</a>
                                    @else
                                    <a href="/novone/public/admin/invoicepaymentstatus/{{$payment->invoice_id}}?id={{$payment->installment_id}}&status=NOTPAID" class="btn btn-warning" >Mark as Unpaid</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>