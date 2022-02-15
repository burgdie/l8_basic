<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function AllBrand() {
      $brands = Brand::latest()->paginate(5);
      return view('admin.brand.index', compact('brands'));

    }
    public function StoreBrand(Request $request) {
      $validatedData = $request->validate([
        'brand_name' => 'required|unique:brands|min:4',
        'brand_image' => 'required|mimes:jpg,jpeg,png',

      ],
      [
        'brand_name.required' => 'Please Input Brand Name',
        'brand_name.min'=> 'Brand Name has to have more than 4 characters',
        'brand_image.required' => 'Brand image is required',
        'brand.mimes' => 'Brand image file extension has to be .jpg, .jpeg or .png'
      ]);

      $brand_image = $request->file('brand_image');

      //Use Laravel function hexdec() to create image id when an image is uploaded
      //and after the original extensaion will be added
      $name_gen = hexdec(uniqid());
      // get extension of original image
      $img_ext = strtolower($brand_image->getClientOriginalExtension());
      $img_name = $name_gen.'.'.$img_ext;

      // Upload the image
      $up_location ='image/brand/';
      $last_img = $up_location.$img_name;
      $brand_image->move($up_location,$img_name);

      Brand::insert([
        'brand_name' => $request->brand_name,
        'brand_image'=>$last_img,
        'created_at' => Carbon::now()
      ]);

      return Redirect()->back()->with('success','brand Inserted Successfully');
    }

    public function EditBrand($id) {
      $brands = Brand::find($id);
      //dd($brands);

      return view('admin.brand.edit', compact('brands'));

    }
    /**
     * Method UpdateBrand
     *
     */
    public function UpdateBrand(Request $request, $id) {

      $validatedData = $request->validate([
        'brand_name' => 'required|min:4',
        ],
        [
          'brand_name.required' => 'Please Input Brand Name',
          'brand_name.min'=> 'Brand Name has to have more than 4 characters',
        ]);

      // Get already stored image from $request data set
      $old_image = $request->old_image;
      //dd($old_image);
      // $old_image_start = $old_image;
      $brand_image = $request->file('brand_image');


      if($brand_image){
        $name_gen = hexdec(uniqid());
        // get extension of original image
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;

        $up_location ='image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        if (unlink($old_image)){

          Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'updated_at' => Carbon::now()
          ]);
            return Redirect()->back()->with('success','Brand Update was  Successful');
          }else
          {
            return Redirect()->back()->with('danger','Brand Update was not successfully');
          }

        }else {

          Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'updated_at' => Carbon::now()
          ]);
            return Redirect()->back()->with('success','Brand Update was  Successful');

        }




    }
  }




