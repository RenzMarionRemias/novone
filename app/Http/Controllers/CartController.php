<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;
use App\Invoice;
use App\InvoiceDetail;
use App\Product;
use App\User;


use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;

use Carbon;
use DB;
use PayPal;
use Redirect;
use Storage;
use Session;

use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;


class CartController extends Controller {

    private $_api_context;
    
    public function __construct() {
        // setup PayPal api context
        $paypal_conf = config('paypal');

        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    
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
        
        $currentDate = date("Y-m-d");

        $total = 0;

        $orderedProducts = DB::table('invoices')
            ->leftJoin('clients', 'clients.client_id' ,'=','invoices.client_id')
            ->select('invoices.*','clients.email')
            ->get();

        $products = DB::table('carts')
                    ->leftJoin('products', 'carts.product_code' ,'=','products.product_code')
                    ->where('carts.user_id',session()->get('currentClient')['id'])
                    ->where('carts.cart_status','PENDING')
                    ->get()
                    ->toArray();
        

        /*
        foreach($products as $product){
            $total = $total + ($product->price);
        }
        */

        return view('home.partials.cart.client_cart',[
            'orderedProducts' => $orderedProducts,
            'products'        => $products,
            'total'           => $total,
            'currentDate'     => $currentDate
        ]);      
    }

    public function proceedPayment(Request $request){

        $data = [];
        
        $data['items'] = [];
        

        foreach($request->all()['product'] as $product){
            $p = json_decode($product);

            array_push($data['items'],[ 
                'product_code' => $p->product_code,
                'name'  => $p->product_name,
                'price' => $p->price,
                'qty'   => array_key_exists ('quantity',$p) ? $p->quantity : 1
            ]);
        }



        $data['invoice_description'] = "Novone Products";
        $data['return_url'] = url('cart/payment/success');
        $data['cancel_url'] = url('/cart/user');
    
        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
    
        $data['total'] = $total;

        $this->saveInvoice($data);

        $this->saveInvoiceDetails($data,session()->get('currentInvoiceId'));
        $invoiceInfo = Invoice::where('invoice_id',session()->get('currentInvoiceId'))->orderBy('invoice_id', 'desc')->first();
        $this->updateCartStatus(session()->get('currentInvoiceId'));
        
        return $this->payment($data,$invoiceInfo);
    }

    public function saveInvoice($data){

        $invoice = new Invoice;
        
        $invoice->client_id = session()->get('currentClient')['id'];

                    
        $invoice->invoice_total_amount = $data['total'];

        $invoice->invoice_payment = $data['total'];
        
        $invoice->payment_type = 'CASH';

        $lastId = $invoice->save();

        Session::put('currentInvoiceId', $invoice->id);
 
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

            //$inventory->purchaseItem($item['product_code'],$item['qty']);
        }
    }


    // ADMIN

    public function showInvoice(){

        $invoices = DB::table('invoices')
                        ->leftJoin('clients', 'clients.client_id' ,'=','invoices.client_id')
                        ->get()
                        ->toArray();
        return view('admin.partials.sales.history',['invoices'=>$invoices]);
    }

    public function showInvoiceDetails($invoiceId){
        
        
        $invoiceDetail =  DB::table('invoice_details')
                        ->leftJoin('invoices','invoices.invoice_id','=','invoice_details.invoice_id')
                        ->leftJoin('clients','invoices.client_id','=','clients.client_id')
                        ->where('invoice_details.invoice_id',$invoiceId)
                        ->get()
                        ->toArray();

        $clientInformation =  DB::table('clients')
                        ->leftJoin('invoices','invoices.client_id','=','clients.client_id')
                        ->where('invoices.invoice_id',$invoiceId)
                        ->select('clients.*')
                        ->get();

        $total = DB::table('invoice_details')
                    ->where('invoice_id',$invoiceId)
                ->sum('purchase_amount');

        return view('admin.partials.sales.sales',['products'=>$invoiceDetail,'total'=>$total,'client'=>$clientInformation[0],]);
    }

    public function updateTransaction(Request $request){

        $action = strtoupper($request->query('action'));

        if($action != "PENDING" && $action != "SHIPPING" && $action != "DELIVERED" && $action != "CANCEL"){
            return redirect()->back()->with('error',true);
        }

        Invoice::where('invoice_id', $request->query('id'))
                ->update(['delivery_status' => $action]);

        return redirect()->back()->with('success',true);
    }

    public function payment($data,$invoiceInfo){

        ini_set('max_execution_time', 10000);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    
        
        $items = array();
        foreach($data['items'] as $i){
            $item = new Item();
            $item->setName($i['name']);
            $item->setCurrency("PHP");
            $item->setQuantity($i['qty']);
            $item->setPrice($i['price']); 
            $items[] = $item;           
        }

        /*
        $item = new Item();
        $item->setName('Amount to Add')// item name
            ->setCurrency('PHP')
            ->setQuantity(1)
            ->setPrice(50); // unit price
            */
        
        // add item to list
        $item_list = new ItemList();
        $item_list->setItems($items);

        $amount = new Amount();

        $amount->setCurrency('PHP')
            ->setTotal($data['total']);
        
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Amount to Add');
        
        $redirect_urls = new RedirectUrls();
        // Specify return & cancel URL
        $redirect_urls->setReturnUrl(url('/payment/add-funds/paypal/status?s=success'))
            ->setCancelUrl(url('/cart/user?s=failed'));
      
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
    
        try {

            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        
            Session::flash('alert', 'Something Went wrong, funds could not be loaded');
            Session::flash('alertClass', 'danger no-auto-close');

            return redirect('/payment/add-funds/paypal/status');
        }
        
        foreach ($payment->getLinks() as $link) {
          if ($link->getRel() == 'approval_url') {
            $redirect_url = $link->getHref();
            break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());
        

        if (isset($redirect_url)) {
            return redirect()->away($redirect_url);
        }
        
        
        Session::flash('alert', 'Unknown error occurred');
        Session::flash('alertClass', 'danger no-auto-close');
        return redirect('/cart/user');
    }

    public function updateCartStatus($invoiceId){
        
        DB::table('carts')
        ->leftJoin('invoice_details','invoice_details.product_code','=','carts.product_code','invoice_details.client_id','=','carts.user_id')
        ->where('invoice_details.invoice_id',$invoiceId)
        ->update([ 'carts.cart_status' => 'SOLD']);

    }
    public function getPaymentStatus(Request $request){

        ini_set('max_execution_time', 10000);

        $payment_id = Session::get('paypal_payment_id');
        
        Session::forget('paypal_payment_id');
    
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::flash('alert', 'Payment failed');
            Session::flash('alertClass', 'danger no-auto-close');
            return redirect('/cart/user');
        }
    
        $payment = Payment::get($payment_id, $this->_api_context);
    
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        $result = $payment->execute($execution, $this->_api_context);
    
        if ($result->getState() == 'approved') { // payment made
            // Payment is successful do your business logic here
            $this->updateInvoice($result);
            session()->forget('currentInvoiceId');
            Session::flash('alert', 'Funds Loaded Successfully!');
            Session::flash('alertClass', 'success');
            return redirect('/cart/user');
      }
      
        Session::flash('alert', 'Unexpected error occurred & payment has been failed.');
        Session::flash('alertClass', 'danger no-auto-close');

        return redirect('/payment/add-funds/paypal/status');
    }

    public function updateInvoice ($result) {
        Invoice::where('invoice_id', session()->get('currentInvoiceId'))
        ->update(['transaction_id' => $result->id]);
    }


    public function getOrderDetails($id){

        $total = 0;

        $transaction = DB::table('invoices')
                    ->where('invoices.client_id',session()->get('currentClient')['id'])
                    ->get();

        $orderedProducts = DB::table('invoice_details')
            ->leftJoin('invoices', 'invoices.invoice_id' ,'=','invoice_details.invoice_id')
            ->leftJoin('products', 'products.product_code','=','invoice_details.product_code')
            ->where('invoice_details.invoice_id',$id)
            ->where('invoices.client_id' ,session()->get('currentClient')['id'])
            ->select('invoice_details.*','products.*')
            ->get();

        foreach($orderedProducts as $product){
            $total = $total + ($product->purchase_quantity * $product->purchase_amount);
        }

        return view('home.partials.cart.order_details',[
            'orderedProducts' => $orderedProducts,
            'total'           => $total,
            'transaction'     => $transaction[0]
        ]);     
        
    }
        
}