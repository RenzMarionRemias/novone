<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\User;
use Storage;
use Session;

class CategoryController extends Controller {

    public function addCategory(){
        return view('admin.partials.category.add_category');
    }

    public function saveNewCategory(Request $request){
       
        $category = new Category;
        $category->name = $request->category_name;
        $category->save();

        return redirect()->back()->with('success',true);
    }
    
    public function updateCategory(Request $request){

        Category::where('id',  $request->category_id)->update(['name' => $request->category_name]);

        return redirect()->back()->with('success',true);
    }

    public function showCategory(){
        $categories = Category::all()->toArray();

        return view('admin.partials.category.edit_category',[
            'categories'=>$categories
        ]);
    }

    public function deleteCategory($categoryId){

        $category = Category::find($categoryId);
        $category->delete();

        return redirect()->back();
        
    }

    public function getAllCategory(){
        return Category::all()->toArray();
    }

}