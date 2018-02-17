<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;
use App\Invoice;
use App\InvoiceDetail;
use App\Product;
use App\TransactionInstallment;
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
use PDF;
use Redirect;
use Storage;
use Session;

use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;


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
                    ->where('cart_status','=','PENDING')
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
        
        $currentDate = date('Y-m-d');

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

        $priceMinLimit = 10000;

        $data = [];
        
        $data['items'] = [];
        
        foreach($request->all()['product'] as $product){
            $p = json_decode($product);

            array_push($data['items'],[ 
                'product_code' => $p->product_code,
                'name'         => $p->product_name,
                'price'        => $p->price,
                'qty'          => array_key_exists ('quantity',$p) ? $p->quantity : 1
            ]);
        }
        
        $method = [
            'payment_method' => $request->payment_method,
            'monthly_price' => $request->monthly_price,
            'installment_method' => $request->installment_method
        ];

        $total = 0;
        
        foreach($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        if($total < $priceMinLimit) {
            return redirect()->back()->with('priceMinLimit',true);
        }
        
            
        $data['total'] = $total;
        
        if($request->payment_method != 'CASH'){

            $data['invoice_description'] = "Novone Products";
            $data['return_url'] = url('cart/payment/success');
            $data['cancel_url'] = url('/cart/user');
            
            
            if($method['payment_method'] == 'PAYPALINSTALLMENT'){
                $this->createMonthlyPayment(session()->get('currentInvoiceId'),$method);
            }
        }

        $this->saveInvoice($data,$method);
        $this->saveInvoiceDetails($data,session()->get('currentInvoiceId'));
        
        $invoiceInfo = Invoice::where('invoice_id',session()->get('currentInvoiceId'))->orderBy('invoice_id', 'desc')->first();
        
        if($request->payment_method != 'CASH'){
            return $this->payment($data,$invoiceInfo);  
        }

        $this->updateCartStatus(session()->get('currentInvoiceId'));

        return redirect()->back()->with('cashOrderSuccess',true);
    }

    public function saveInvoice($data,$method){

        $invoice = new Invoice;
        
        $invoice->client_id = session()->get('currentClient')['id'];

        if($method['payment_method'] == 'PAYPALINSTALLMENT') {
            $invoice->no_of_months = $method['installment_method'];
            $invoice->monthly_payment = $method['monthly_price'];
        }
        if($method['payment_method'] == 'CASH'){
            $uuid1 = Uuid::uuid1();
            $invoice->transaction_id = $uuid1->toString();
        }
                    
        $invoice->invoice_total_amount = $data['total'];

        $invoice->invoice_payment = $data['total'];
        
        $invoice->payment_type = $method['payment_method'];

        $lastId = $invoice->save();

        Session::put('currentInvoiceId', $invoice->id);
    }

    public function createMonthlyPayment ($invoiceId,$transaction) {
        $data = array();
        
        for($ctr = 1;$ctr<=$transaction['installment_method'];$ctr++){
            $paymentDate = date('Y/m/d', strtotime('+'.$ctr.' months'));
            $data[$ctr-1] = [
                'invoice_id'   => $invoiceId, 
                'payment_date' => $paymentDate,
                'amount_paid' =>  $transaction['monthly_price']
            ];
        }
        TransactionInstallment::insert($data);
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
    public function getTransaction($invoiceId){
    
        $result = DB::table('invoices')
                    ->where('invoice_id',$invoiceId)
                    ->get()
                    ->toArray();

        if(count($result) > 0 ){
            return $result[0];
        }

        return null;
    }
    

    public function showInvoice(){

        $invoices = DB::table('invoices')
                        ->leftJoin('clients', 'clients.client_id' ,'=','invoices.client_id')
                        ->get()
                        ->toArray();
                        
        return view('admin.partials.sales.history',[
            'invoices'=>$invoices
        ]);
    }

    public function showInvoiceDetails($invoiceId){

        //{{date('d/m/Y', strtotime('+2 months'))}}
        $paymentDate = [];

        $invoices = $this->getTransaction($invoiceId);

        if($invoices->payment_type == 'PAYPALINSTALLMENT') {
            $paymentDate = $this->getPaymentDate($invoices->invoice_id);
        }

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

        $total = DB::table('invoices')
                    ->where('invoice_id',$invoiceId)
                    ->sum('invoice_total_amount');

        return view('admin.partials.sales.sales',[
                    'products'=>$invoiceDetail,
                    'total'=> (int)$total,
                    'client'=>$clientInformation[0],
                    'paymentDate' => $paymentDate
        ]);
    }

    public function showPaymentSchedule($id){
  
        $transaction = $this->getTransaction($id);

        if($transaction->payment_type == 'PAYPALINSTALLMENT') {
            $paymentDate = $this->getPaymentDate($transaction->invoice_id);
            
            return view('admin.partials.sales.payment',[
                'transaction'=>$transaction,
                'payments'=>$paymentDate,
            ]);
        }
        return redirect()->back();
    }

    public function getOrderUser($id){
        $result =  DB::table('invoices')
                    ->where('invoices.invoice_id',$id)
                    ->select('invoice_id','transaction_id','client_id')
                    ->get();
        if($result) {
            return $result[0];
        }
        return null;
    }



    public function updateTransaction(Request $request){

        $action = strtoupper($request->query('action'));

        $notification = new NotificationController;

        $order = $this->getOrderUser($request->query('id'));
        
        if($action != 'PENDING' && $action != 'SHIPPING' && $action != 'DELIVERED' && $action != 'CANCEL'){
            return redirect()->back()->with('error',true);
        }

        Invoice::where('invoice_id', $request->query('id'))
                ->update(['delivery_status' => $action]);

        $message = 'Administrator set the status of your transaction id # '. $order->transaction_id .' to '. $action .'';

        $notification->createNotification($order->client_id,'ADMIN','ORDER',$message);

        return redirect()->back()->with('success',true);
    }


    public function updatePaymentStatus($id,Request $request){
        
            $status =  strtoupper($request->query('status'));
        
            if($status == 'NOTPAID' || $status == 'PAID'){
                TransactionInstallment::where('installment_id', $request->query('id'))
                    ->update(['payment_status' => $status]);
                $this->checkInstallmentTransaction($id);
                    return redirect()->back()->with('paid',true);
            }
                return redirect()->back()->with('paid',false);
        
    }

    public function checkInstallmentTransaction($invoiceId){
        
        $result =  DB::table('transaction_installments')
                    ->where('invoice_id',$invoiceId)
                    ->count(DB::raw('DISTINCT payment_status'));
        $paymentStatus = 'NOTPAID';

            if($result == 1) {
                $paymentStatus = 'PAID';

            }

            Invoice::where('invoice_id', $invoiceId)
                    ->update(['payment_status' => $paymentStatus]);
    

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
                
                $this->updateCartStatus(session()->get('currentInvoiceId'));
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


    public function showOrderDetails($id){

        $order = $this->getOrderDetails($id,session()->get('currentClient')['id']);

        $paymentDate = $this->getPaymentDate($id);

        return view('home.partials.cart.order_details',[
            'orderedProducts' => $order['orderedProducts'],
            'paymentDate'     => $paymentDate,
            'total'           => $order['total'],
            'transaction'     => $order['transaction']
        ]);     
        
    }

    public function getOrderDetails($orderId,$clientId){
        $total = 0;

        $transaction = DB::table('invoices')
                        ->where('invoices.client_id',session()->get('currentClient')['id'])
                        ->where('invoices.invoice_id',$orderId)
                        ->get();

        $orderedProducts = DB::table('invoice_details')
                            ->join('invoices', 'invoices.invoice_id' ,'=','invoice_details.invoice_id')
                            ->join('products', 'products.product_code','=','invoice_details.product_code')
                            ->where('invoice_details.invoice_id',$orderId)
                            ->where('invoices.client_id' ,$clientId)
                            ->select('invoice_details.*','products.*')
                            ->get();
        
        foreach($orderedProducts as $product){
            $total = $total + ($product->purchase_quantity * $product->purchase_amount);
        }

        return [
            'transaction' => $transaction[0],
            'orderedProducts' => $orderedProducts,
            'total' => $total
        ];
    }

    public function getPaymentDate($invoiceId){

        return  DB::table('transaction_installments')
                ->leftJoin('invoices','invoices.invoice_id','transaction_installments.invoice_id')
                ->where('invoices.invoice_id',$invoiceId)
                ->select('transaction_installments.*','invoices.transaction_id')
                ->get();
    }


    // PDF

    public function downloadOrderReceipt($orderId,Request $request){

        $order = $this->getOrderDetails($orderId,session()->get('currentClient')['id']);
        $paymentDate = $this->getPaymentDate($orderId);
        PDF::setOptions(['defaultFont' => 'sans-serif','isHtml5ParserEnabled' => true]);
        
        $pdf = PDF::loadView('pdf.order_receipt',  [
            'transaction'      => $order['transaction'],
            'orderedProducts'  => $order['orderedProducts'],
            'paymentDate'      => $paymentDate,
            'total'            => $order['total']
        ]);
        
            
        return $pdf->download('receipt.pdf');
    }

    public function cancelPendingOrder($orderId,Request $request){
 
        Invoice::where('invoice_id', $orderId)
        ->update(['delivery_status' => 'CANCEL']);

        return redirect()->back()->with('cancelled',true);
    }

    
        
}