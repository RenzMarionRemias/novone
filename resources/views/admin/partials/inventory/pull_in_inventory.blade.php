@extends('admin.main') @include('admin.partials.sidebar')



<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    <h1>Pull In Products</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Pull In No.</th>
                <th>Product Code</th>
                <th>Quantity</th>
                <th>Added by</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product['product_pull_in_id']}}</td>
                <td>{{$product['product_code']}}</td>
                <td>{{$product['quantity']}}</td>
                <td>admin@gmail.com</td>
                <td>{{$product['created_at']}}</td>
                <td></td>

            </tr>
            @endforeach

        </tbody>
    </table>

</div>