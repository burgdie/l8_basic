<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function AllCat() {

      //Get Data using Eloquent
      $categories = Category::latest()->paginate(5);;

       //Get Data using Querybuilder
      // $categories = DB::table('categories')->latest()->paginate(5);

      return view('admin.category.index', compact('categories'));




    }

    public function AddCat(Request $request) {
      $validatedData =$request->validate([
        'category_name' => 'required|unique:categories|max:255',
      ],
      [
        'category_name.required' =>'Please input category name',
        'category_name.max' =>'Category name not more than 255 Characters are allowed',
      ]);

    // Eloquent insert data
      Category::insert([
        'category_name' => $request->category_name,
        'user_id' => Auth::user()->id,
        'created_at' => Carbon::now(),
      ]);

    //
    // $category = new Category;
    // $category->category_name = $request->category_name;
    // $category->user_id = Auth::user()->id;
    // //Carbon not necessary created at and updated at automatically inserted
    // //$category->created_at = Carbon::now();
    // $category->save();

    //Query Builder

    // $data = array();
    // $data['category_name'] = $request->category_name;
    // $data['user_id'] = Auth::user()->id;
    // $actual_date = Carbon::now();
    // $data['created_at'] = Carbon::now();
    // DB::table('categories')->insert($data);


    return redirect()->back()->with('success', 'Category inserted Successful');

     }
}
