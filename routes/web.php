<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/email/verify', function () {
  return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/', function () {
  $brands = DB::table('brands')->get();

  return view('home', compact('brands'));
});
Route::get('/home', function () {
    // return view('welcome');
    echo " This is Home Page";
});

Route::get('/about', function () {
     return view('about');
    //echo "This is About Page";
});

// Route::get('/contact', function () {
//      return view('contact');
//     //echo "This is Contact Page";
// });
Route::get('/contactadfrfrtz-asd', [ContactController::class,'index'])->name('con');
//***********************************************************/
//*********  Start Routing Category Controller  *************/
Route::get('/category/all',[CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'AddCat'])->name('store.category');
// Edit and Update Category
Route::get('/category/edit/{id}',[CategoryController::class, 'EditCat']);
Route::post('/category/update/{id}',[CategoryController::class, 'UpdateCat']);

// Softdelete Category
Route::get('/softdelete/category/{id}',[CategoryController::class, 'SoftDelete']);

// Permanent Delete Category
Route::get('/softdelete/category/{id}',[CategoryController::class, 'SoftDelete']);

// Restore Softdeleted Category Item
Route::get('/pdelete/category/{id}',[CategoryController::class, 'Pdelete']);
//*********  End Routing Category Controller  *************/


//***********************************************************/
//*********  Start Routing Brand Controller  ***************/
Route::get('/brand/all', [BrandController:: class, 'AllBrand'])->name('all.brand');
//   Add Brand to table
Route::post('/brand/add', [BrandController::class, 'StoreBrand'])->name('store.brand');

// Edit and Update Brand
Route::get('/brand/edit/{id}',[BrandController::class, 'EditBrand']);
Route::post('/brand/update/{id}',[BrandController::class, 'UpdateBrand']);

// Delete Brand
Route::get('/brand/delete/{id}',[BrandController::class, 'DeleteBrand']);

//*********  End Routing Brand Controller  *************/

//***********************************************************/
//*********  Start Routing Multi Image handling in Brand Controller***************/
Route::get('/multi/image', [BrandController:: class, 'MultiPic'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StoreImg'])->name('store.image');


//*********  End Routing Multi Image Handling  *************/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //Eloquent ORM Read Users Data
   // $users = User::all();

   //Query Builder Read Users data
   //$users = DB::table('users')->get();

    return view('admin.index');
})->name('dashboard');

//*************** New Logou Route ******************/
Route::get('/user/logout', [brandController::class, 'UserLogout'])->name('user.logout');
