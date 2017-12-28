<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;
use App\Invoice;
use App\InvoiceDetail;
use App\Product;
use App\User;


use DB;
use PayPal;
use Storage;
use Session;

use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;


class CartController extends Controller {
    // PRODUCT CART

    public function addProductToCart(Request $request){

        /*
        $request->validate([
            'quantity'    => 'required|numeric'
        ]);
        */
        $products = Cart::where('product_code','=',$request->product_code)
                    ->where('user_id','=',session()->get('currentClient')['id'])
                    ->first();
        if($products){

            return redirect()->back()->with('success',true);
        }
        else{

            $cart = new Cart;

            $cart->product_code = $request->product_code;

            $cart->user_id = session()->get('currentClient')['id'];
            
            $cart->save();

            return redirect()->back()->with('success',true);
        }
    }

    public function deleteItemToCart($cartId){

        Cart::where('cart_id', $cartId)
        ->delete();
    
        return redirect()->back()->with('success',true);

    }


    public function showCart(){
        
        $total = 0;
        $products = DB::table('carts')
                    ->leftJoin('products', 'carts.product_code' ,'=','products.product_code')
                    ->where('carts.user_id',session()->get('currentClient')['id'])
                    ->get()
                    ->toArray();

        /*
        foreach($products as $product){
            $total = $total + ($product->price);
        }
        */

        return view('home.partials.cart.client_cart',[
            'products' => $products,
            'total'    => $total
        ]);      
    }

    public function proceedPayment(Request $request){
        $provider = new ExpressCheckout;      // To use express checkout.

        $provider = PayPal::setProvider('express_checkout');      // To use express checkout(used by default).
        
        $data = [];
        
        $data['items'] = [];
        
        
        foreach($request->all()['product'] as $product){
            $p = json_decode($product);

            array_push($data['items'],[ 
                'product_code' => $p->product_code,
                'name'  => $p->product_name,
                'price' => $p->price,
                'qty'   => $p->quantity
            ]);
        }


        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Novone Products";
        $data['return_url'] = url('/payment/success');
        $data['cancel_url'] = url('/cart/user');
    
        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }
    
        $data['total'] = $total;

        $options = [
            'BRANDNAME' => 'Novone',
            'LOGOIMG' => 'https://example.com/mylogo.png',
            'CHANNELTYPE' => 'Merchant'
        ];

        $this->saveInvoice($data);
        
        $invoiceInfo = Invoice::where('client_id',session()->get('currentClient')['id'])->orderBy('invoice_id', 'desc')->first();
        
        $this->saveInvoiceDetails($data,$invoiceInfo->invoice_id);

        
        $provider->addOptions($options)->setExpressCheckout($data);

        $response = $provider->setExpressCheckout($data);
    
        // Use the following line when creating recurring payment profiles (subscriptions)
        $response = $provider->setExpressCheckout($data, true);
    
        // This will redirect user to PayPal
        return redirect($response['paypal_link']);
        
    

    }

    public function saveInvoice($data){

        $invoice = new Invoice;
        
        $invoice->client_id = session()->get('currentClient')['id'];
                    
        $invoice->transaction_id = '111111';
                    
        $invoice->invoice_total_amount = $data['total'];

        $invoice->invoice_payment = $data['total'];
        
        $invoice->payment_type = 'CASH';

        $invoice->save();

 
    }

    public function saveInvoiceDetails($data,$invoiceId){

        $inventory = new InventoryController;
        
        foreach($data['items'] as $item){

            $invoice = new InvoiceDetail;            

            $invoice->invoice_id = $invoiceId;
                        
            $invoice->product_code =  $item['product_code'];

            $invoice->purchase_quantity = $item['qty'];

            $invoice->purchase_amount = $item['price'];
    
            $invoice->save();

            $inventory->purchaseItem($item['product_code'],$item['qty']);
        }
    }

    public function paymentSuccess(){
        
    }
    
        
}