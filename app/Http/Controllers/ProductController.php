<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\Measurement;
use App\User;




use DB;
use PDF;
use Storage;
use Session;

class ProductController extends Controller {


    public function addProduct(){
        $categories = Category::all()->toArray();
        $measurement = new MeasurementController;
        $measurements = $measurement->getMeasurementList();
        return view('admin.partials.products.add_products',[
            'categories'=>$categories,
            'measurements'  => $measurements
        ]);
    }


    
    public function showProducts(Request $request){

        $categories = Category::all()->toArray();

        $measurement = new MeasurementController;
        $measurements = $measurement->getMeasurementList();

        $products = DB::table('products')
                    ->leftJoin('categories', 'products.product_type' ,'=','categories.id')
                    ->get()
                    ->toArray();


        return view('admin.partials.products.edit_products', [
            'categories'    => $categories,
            'measurements'  => $measurements,
            'products'      => $products,
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
            'product_code'      => 'required|min:10|max:20|unique:products',
            'product_name'      => 'required|max:30',
            'price'             => 'required|numeric',
            'price_per_item'    => 'required|numeric',
            'product_unit'      => 'required|numeric',
            'critical_level'    => 'required|numeric',
            'pcs_per_bundle'    => 'required|numeric',
            'discount'          => 'numeric'
        ]); 
        $imageUrl = Storage::disk('local')->put('products', $request->product_images);
        
        $product = new Product;

        $product->product_code = $request->product_code;

        $product->product_name = $request->product_name;

        $product->product_unit = $request->product_unit;

        $product->pcs_per_bundle = $request->pcs_per_bundle;

        $product->product_measurement = $request->product_measurement;

        $product->description = $request->description;

        $product->price = $request->price;

        $product->price_per_item = $request->price_per_item;

        $product->barcode_image = $request->barcode_image;

        if($request->discount){
            $product->discount = 0;
        }

        $product->image = $imageUrl;

        $product->user_id = session()->get('currentUser')->id;

        $product->product_type = $request->product_category;

        $product->critical_level = $request->critical_level;

        //$product->manufactured_date = $request->manufactured_date;

        //$product->expiration_date = $request->expiration_date;

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
                'product_name'       => $request->editProductName,
                'pcs_per_bundle'     => $request->editPcsPerBundle,
                'price'              => $request->editProductPrice,
                'price_per_item'     => $request->editProductPricePerItem,
                'discount'           => $request->editDiscountPercentage,
                'critical_level'     => $request->editCriticalLevel,
                'product_type'       => $request->productCategory,
                'user_id'            => session()->get('currentUser')->id
        ]);

        if($request->productImage){
            $imageUrl = Storage::disk('local')->put('products', $request->productImage);
            Product::where('product_code', $request->editProductCode)
            ->update(['image' => $imageUrl, 'user_id' => session()->get('currentUser')->id]);

        }

        return redirect()->back();

    }

    public function getAllProducts($categoryId = null){

        $products =  DB::table('products');
    
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


    public function downloadProductList(){
        
        $categories = Category::all()->toArray();
            
        $products = DB::table('products')
                                ->leftJoin('categories', 'products.product_type' ,'=','categories.id')
                                ->get()
                                ->toArray();
        PDF::setOptions(['defaultFont' => 'sans-serif','isHtml5ParserEnabled' => true]);
                $pdf = PDF::loadView('pdf.product_list',  [
                    'products'      => $products,
        ]);
                
        return $pdf->download('products.pdf');
    }

}