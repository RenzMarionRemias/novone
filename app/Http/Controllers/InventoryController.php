<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Inventory;
use App\Product;
use App\ProductPullIn;
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
        return Inventory::where('product_code','=',$productCode)->first();
    }

    public function updateQuantity(Request $request){

        $request->validate([
            'quantity'      => 'required|numeric',
        ]);

        $products = $this->getProduct($productCode);
        if($products){

            Inventory::where('product_code', $request->product_code)
                ->update(['quantity' => $request->quantity+$products->quantity
            ]);
            
            $this->triggerPullIn($request->product_code,$request->quantity);

            return redirect()->back()->with('success',true);
        }
        else{

            $inventory = new Inventory;

            $inventory->product_code = $request->product_code;
            
            $inventory->quantity = $request->quantity;
            
            $inventory->user_id = session()->get('currentUser')->id;
            
            $inventory->save();

            $this->triggerPullIn($request->product_code,$request->quantity);
            
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

    public function showInventory(){

        /*
        $q = "SELECT inventory.inventory_id,inventory.product_code,inventory.quantity,inventory.critical,products.product_name,products.product_type,pruducts.price ";
        $q = "FROM inventories as `inventory`,products as `products` ";
        $q = "WHERE inventory.product_code = products.product_code ";
        */
        $inventories = DB::table('inventories')
        ->leftJoin('products', 'inventories.product_code', '=', 'products.product_code')
        ->get()
        ->toArray();

        //$inventories = Inventory::all()->toArray();
        return view('admin.partials.inventory.list_inventory',[
            'inventories' => $inventories
        ]);

    }


    // PULL IN //

    
    public function triggerPullIn($productCode,$quantity){
        
        $productPullIn = new ProductPullIn;
        
        $productPullIn->product_code = $productCode;
        
        $productPullIn->quantity = $quantity;

        $productPullIn->user_id = session()->get('currentUser')->id;
        
        $productPullIn->save();
    }

    public function showPullInProducts(){
        $products = ProductPullIn::all()->toArray();

        return view('admin.partials.inventory.pull_in_inventory',[
                    'products' => $products
        ]);
    }
    


}