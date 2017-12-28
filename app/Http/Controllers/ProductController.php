<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\User;
use DB;
use Storage;
use Session;

class ProductController extends Controller {

    public function addProduct(){
        $categories = Category::all()->toArray();

        return view('admin.partials.products.add_products',[
            'categories'=>$categories
        ]);
    }


    
    public function showProducts(Request $request){

        $categories = Category::all()->toArray();

        $products = DB::table('products')
        ->leftJoin('categories', 'products.product_type' ,'=','categories.id')
        ->get()
        ->toArray();


        return view('admin.partials.products.edit_products', [
            'products' => $products,
            'categories'=>$categories
        ]);
    }


    public function searchProducts(Request $request){

        $categories = Category::all()->toArray();

        if($request->product_search_category == 'ALL') {
            $products = DB::table('products')
            ->leftJoin('categories', 'products.product_type' ,'=','categories.id')
            ->get();
        }
        else{
            $products = DB::table('products')
            ->leftJoin('categories', 'products.product_type' ,'=','categories.id')
            ->where('product_type','=',$request->product_search_category)
            ->get();
        }

        return view('admin.partials.products.edit_products', [
            'products' => $products,
            'categories'=>$categories,
            'category_keyword' => $request->product_search_category
        ]);

    }


    public function saveNewProduct(Request $request){

        $request->validate([
            'product_code'  => 'required|max:5|unique:products',
            'product_name'  => 'required|max:30',
            'price'         => 'required|numeric',
            'product_unit'  => 'required|numeric'
        ]);

        $imageUrl = Storage::disk('local')->put('products', $request->productImage);
        
        $product = new Product;

        $product->product_code = $request->product_code;

        $product->product_name = $request->product_name;

        $product->product_unit = $request->product_unit;

        $product->product_measurement = $request->product_measurement;

        $product->description = $request->description;

        $product->price = $request->price;

        $product->image = $imageUrl;

        $product->user_id = session()->get('currentUser')->id;

        $product->product_type = $request->productCategory;



        $product->save();

        return redirect()->back()->with('success',true);
    }   

    public function deleteProduct($productId,Request $request){

        $product = Product::find($productId);
        $product->delete();

        return redirect()->back();
    }

    public function updateProducts(Request $request){

        Product::where('id', $request->hiddenProductId)
            ->update(['product_code' => $request->editProductCode,
                'product_name' => $request->editProductName,
                'product_type' => $request->productCategory,
                'user_id' => session()->get('currentUser')->id
        ]);

        if($request->productImage){
            $imageUrl = Storage::disk('local')->put('products', $request->productImage);
            Product::where('id', $request->hiddenProductId)
            ->update(['image' => $imageUrl]);
        }

        return redirect()->back();

    }

    public function getAllProducts($categoryId = null){

        $products =  DB::table('products')
                ->leftJoin('inventories', 'products.product_code' ,'=','inventories.product_code');
    
        $products = $categoryId ?  $products->leftJoin('categories','products.product_type','=','categories.id')->where('categories.id','=',$categoryId) : $products;

        return $products->get()
                ->toArray();
    }

    // CLIENT 

    public function displayProductList(){
  
        $category = new CategoryController;
        $categories = $category->getAllCategory();
        $products = $this->getAllProducts(null);

        return view('home.partials.products.products',[
            'categories' => $categories,
            'products'   => $products
        ]);
    }

    public function filterByCategory($categoryId){

        $category = new CategoryController;
        $categories = $category->getAllCategory();
        $products = $this->getAllProducts($categoryId);

        return view('home.partials.products.products',[
            'categories' => $categories,
            'products'   => $products
        ]);      
    }

}