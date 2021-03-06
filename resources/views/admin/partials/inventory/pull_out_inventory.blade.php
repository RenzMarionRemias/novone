@extends('admin.main') @include('admin.partials.sidebar')



<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    <h1>Pull Out Products</h1>
    <table class="table list-data">
        <thead>
            <tr>
                <th>Pull Out No.</th>
                <th>Product Code</th>
                <th>Pull Out Type</th>
                <th>Deduction Type</th>
                <th>Quantity</th>
                <th>Added by</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product->product_pull_out_id}}</td>
                <td>{{$product->product_code}}</td>
                <td>{{$product->pull_out_type}}</td>
                <td>{{$product->pull_out_deduct_type}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->email}}</td>
                <td>{{$product->created_at}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>