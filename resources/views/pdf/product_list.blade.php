<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="/novone/public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
    tr{
        border-bottom:1px solid black;
    }
</style>
</head>
<body>

<h2>List of products</h2>

<table class="table list-data">
    <thead>
        <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Pcs Per Bundle</th>
        <th>Product Category</th>
        <th>Critical Level</th>
        <th>Price Per Bundle</th>
        <th>Price Per Item</th>

        <th>Date Added</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
            <td>{{$product->product_code}}</td>
            <td>{{$product->product_name}}</td>
            <td style="text-align:center;">{{$product->pcs_per_bundle}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->critical_level}}</td>
            <td>P{{$product->price}}</td>
            <td>P{{$product->price_per_item}}</td>
            <td>{{$product->created_at}}</td>     
            </tr>
        @endforeach

    </tbody>
    </table>
</body>
</html>