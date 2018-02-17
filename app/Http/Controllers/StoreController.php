<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


use App\Log;
use App\ProductPullOut;
use App\Store;
use App\User;


use DB;
use Storage;
use Session;

class StoreController extends Controller {

	public function showStoreProducts() {
		
		$storeProducts = DB::table('stores')
        	->leftJoin('products', 'stores.product_code' ,'=','products.product_code')
        	->select('stores.*','products.product_name','products.description','products.price','products.critical_level',
        		'products.price_per_item')
        	->get();

        return view('admin.partials.store.store_list',[
        	'storeProducts' => $storeProducts
        ]);
	}


	public function pullOutStoreProducts(Request $request) {
	
		$pullOut = new ProductPullOut;

        $pullOut->product_code = $request->product_code;

        $pullOut->pull_out_type = $request->pull_out_type;

        $pullOut->pull_out_deduct_type = $request->deduct_type;

        $pullOut->quantity = $request->item_amount;

        $pullOut->user_id = session()->get('currentUser')->id;

        $pullOut->save();
        
        $products = $this->getStoreProduct($request->product_code);

        if($products){

        	if($request->item_amount <= $products->total_quantity){
        		$totalQuantity = 0;
				//$products->total_quantity - $request->item_amount
        		if($request->deduct_type == 'BUNDLE'){
        			$totalQuantity = $products->total_quantity - ($request->item_amount * $products->pcs_per_bundle);
        		}
        		else if($request->deduct_type == 'ITEM'){
        			$totalQuantity = $products->total_quantity - $request->item_amount;
        		}
        		//$pcsPerBundle  = $request->pull_out_total_amount - $request->item_amount;

        		Store::where('product_code', $products->product_code)
            		->update([
            			'total_quantity' => $totalQuantity
        		]);
        	}
        	else{
              	return redirect()->back()->with('quantityError',true);
        	}



            return redirect()->back()->with('success',true);
        }

	}



	public function getStoreProduct($productCode){
		return DB::table('stores')
        	->leftJoin('products', 'stores.product_code', '=', 'products.product_code')
        	->where('products.product_code',$productCode)
        	->select('stores.*','products.pcs_per_bundle')
        	->get()->first();
	}



}