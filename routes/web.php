<?php

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('FrontEnd.home');
});
Route::get('/details',[OrderController::class,"index"]);
Route::get('/products',function(){
    $count = count(Product::all());
    return response()->json(['count' => $count]);

});
Route::post('/store',[OrderController::class,"store"])->name("store");
Route::post("/yt",function(Request $request){
    $paths = [];
    if ($request->hasFile(["image_path"])) {
        // $request->validate([
        //     'image_path.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        // ]);

        foreach ($request->file('image_path') as $image) {
            // Store the image file and get its path
            $imagePath = $image->store('images', 'public');
            array_push($paths,  $imagePath);
            
        }
        // Save the image path to the database
        Image::create(['image_path' =>implode(", ", $paths), 'product_id' => $request->input('product_id')]);

        
    }

    return response()->json(['message' => 'Images uploaded successfully']);
});
Route::get('/search', function () {
    return view('FrontEnd.filter');
});
Route::get('/cart', function () {
    return view('FrontEnd.cart');
});
Route::get('/dashboard', function () {
    return view('Dashboard.index');
});
Route::get('/dashboardcart', function () {
    return view('Dashboard.ui-card');
});
Route::resource("product",ProductController::class);

