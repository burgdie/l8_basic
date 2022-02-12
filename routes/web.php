<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
Route::get('/', function () {
    return view('welcome');
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

//Category Controller
Route::get('/category/all',[CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'AddCat'])->name('store.category');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //Eloquent ORM Read Users Data
   // $users = User::all();

   //Query Builder Read Users data
   $users = DB::table('users')->get();

    return view('dashboard', compact('users'));
})->name('dashboard');
