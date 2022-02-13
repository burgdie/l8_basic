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
     $categories = Category::latest()->paginate(5);
     $trashCat = Category::onlyTrashed()->latest()->paginate(3);



       //Get Data using Querybuilder
      // $categories = DB::table('categories')->latest()->paginate(5);

      // $categories = DB::table('categories')
      //   ->join('users','categories.user_id', 'users.id')
      //   ->select('categories.*', 'users.name')
      //   ->latest()->paginate(5);

      return view('admin.category.index', compact('categories','trashCat'));




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
     public function EditCat($id){

      //Use Eloquent ORM
      // $categories = Category::find($id);

      // Use Query Builder
      $categories = DB::table('categories')->where('id', $id)->first();

      return view('admin.category.edit', compact('categories') );
     }

     public function UpdateCat(Request $request, $id){

      //Use Eloquent ORM
      // $update = Category::find($id)->update([

      //   'category_name' => $request->category_name,
      //   'user_id' => Auth::user()->id
      // ]);

      //Use Query Builder
      $data = array();
      $data['category_name'] = $request->category_name;
      $data['user_id'] = Auth::user()->id;

      DB::table('categories')->where('id', $id)
      ->update($data);


    //  return Redirect()->back()->with('success', 'Category Inserted Successfull');
     return Redirect()->route('all.category')->with('success', 'Category Updated Successfull');

     }

     public function SoftDelete($id) {
       $delete = Category::find($id)->delete();
       return Redirect()->back()->with('success', 'Category SoftDelete Successfully');
     }

     public function Restore($id){
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
     }

     public function Pdelete($id){
      $delete = Category::onlyTrashed()->find($id)->forceDelete();
      return Redirect()->back()->with('success', 'Category Permanently Deleted ');

     }


}
