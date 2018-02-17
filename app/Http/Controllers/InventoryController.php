<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Mail\AccountVerification;

use App\Category;
use App\Inventory;
use App\Product;
use App\ProductPullIn;
use App\Store;
use App\User;
use DB;
use Storage;
use Session;

class InventoryController extends Controller {

    public function addInventory(){
        $products = Product::all()->toArray();

        return view('admin.partials.inventory.add_inventory',[
            'products' => $products
        ]);
    }

    public function getProduct($productCode){

        return DB::table('inventories')
        ->leftJoin('products', 'inventories.product_code', '=', 'products.product_code')
        ->where('products.product_code',$productCode)
        ->select('inventories.*','products.pcs_per_bundle')
        ->get()->first();
    }

    public function updateQuantity(Request $request){

        $productCode = $request->product_code;
        $addType     = $request->add_type;
        
        $request->validate([
            'quantity'      => 'required|numeric',
        ]);

        if($request->manufactured_date > $request->expiration_date){
            return redirect()->back()->with('dateError',true);
        }
        
        $products = $this->getProduct($productCode);

        if($products){
        
                if($addType == 'INVENTORY'){
                    Inventory::where('product_code', $productCode)
                        ->update(['quantity' => $request->quantity+$products->quantity
                    ]);
            
                    $this->triggerPullIn($request,$addType);
                }
                else if($addType == 'STORE'){
                    if($request->quantity <= $products->quantity){

                        $storeProduct = Store::where('product_code','=',$productCode)->first();

                        if($storeProduct){

                            $totalBundle = $request->quantity  + $storeProduct->pcs_per_bundle;
                            Store::where('product_code', $productCode)
                                ->update([
                                    'pcs_per_bundle' => $totalBundle,
                                    'total_quantity' => $totalBundle * $products->pcs_per_bundle
                            ]);
            
                        }
                        else{

                            $store = new Store;

                            $store->product_code = $request->product_code;
            
                            $store->pcs_per_bundle = $request->quantity;
                    
                            $store->total_quantity = $request->quantity * $products->pcs_per_bundle;

                            $store->user_id = session()->get('currentUser')->id;
            
                            $store->save();
                        }

                        Inventory::where('product_code', $request->product_code)
                            ->update(['quantity' => $products->quantity -  $request->quantity
                        ]);

                        $this->triggerPullIn($request,$addType);
                    }
                    else{
                        return redirect()->back()->with('quantityError',true);
                    }
 
            }
        
            return redirect()->back()->with('success',true);
        }
        else{

            $inventory = new Inventory;

            $inventory->product_code = $request->product_code;
            
            $inventory->quantity = $request->quantity;
            
            $inventory->user_id = session()->get('currentUser')->id;
            
            $inventory->save();

            $this->triggerPullIn($request,'INVENTORY');
            
            return redirect()->back()->with('success',true);
        }

        return redirect()->back()->with('error',true);
    }

    // PURCHASE ITEMS
    public function purchaseItem($productCode,$quantity){
        
        $products = $this->getProduct($productCode);

        Inventory::where('product_code', $productCode)
            ->update(['quantity' => $products->quantity - $quantity
        ]);
    }

/*

    public function updateCriticalValue(Request $request) {
        $request->validate([
            'critical' => 'required|numeric',
        ]);

        $inventory = Inventory::where('product_code','=',$request->product_code)->first();
        if($inventory){
            Inventory::where('product_code', $request->product_code)
            ->update(['critical' => (int)$request->critical
        ]);
            return redirect()->back()->with('success',true);
        }

        
        return redirect()->back()->with('error',true);
    }

*/
    public function showInventory(){

        /*
        $q = "SELECT inventory.inventory_id,inventory.product_code,inventory.quantity,inventory.critical,products.product_name,products.product_type,pruducts.price ";
        $q = "FROM inventories as `inventory`,products as `products` ";
        $q = "WHERE inventory.product_code = products.product_code ";
        */
        $inventories = DB::table('inventories')
        ->leftJoin('products', 'inventories.product_code', '=', 'products.product_code')
        ->select('inventories.*','products.product_name','products.critical_level','products.price',
            'products.price_per_item','products.pcs_per_bundle')
        ->get()
        ->toArray();

        //$inventories = Inventory::all()->toArray();
        return view('admin.partials.inventory.list_inventory',[
            'inventories' => $inventories
        ]);

    }


    // PULL IN //

    
    public function triggerPullIn($request,$type){

        $productPullIn = new ProductPullIn;
        
        $productPullIn->product_code = $request->product_code;

        $productPullIn->pull_in_type = $type;
        
        $productPullIn->quantity = $request->quantity;

        $productPullIn->manufactured_date = $request->manufactured_date;

        $productPullIn->expiration_date = $request->expiration_date;

        $productPullIn->user_id = session()->get('currentUser')->id;
        
        $productPullIn->save();
    }

    public function showPullInProducts(){
     

        $products = DB::table('product_pull_ins')
                    ->leftJoin('products', 'product_pull_ins.product_code', '=', 'products.product_code')
                    ->leftJoin('users', 'users.id', '=', 'product_pull_ins.user_id')
                    ->select('product_pull_ins.*','products.product_name','users.email')
                    ->orderBy('product_pull_ins.product_pull_in_id','desc')
                    ->get();

        return view('admin.partials.inventory.pull_in_inventory',[
                    'products' => $products
        ]);
    }


        public function showPullOutProducts(){
     

        $products = DB::table('product_pull_outs')
                    ->leftJoin('products', 'product_pull_outs.product_code', '=', 'products.product_code')
                    ->leftJoin('users', 'users.id', '=', 'product_pull_outs.user_id')
                    ->select('product_pull_outs.*','products.product_name','users.email')
                    ->orderBy('created_at','desc')
                    ->get();

        return view('admin.partials.inventory.pull_out_inventory',[
                    'products' => $products
        ]);
    }
    


}