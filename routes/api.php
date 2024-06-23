<?php

use App\Http\Controllers\ProductCT;
use App\Http\Controllers\UserCT;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('product-has-category',function(){
//     $products = \App\Models\Product::find(2);

//     echo $products->product_name;

//     echo "<ul>";
//     foreach($products->categories as $r) {
//         echo "<li>".$r->category_name."</li>";
//     }
//     echo "</li>";
// });


Route::post('login', [UserCT::class, 'login'])->middleware('throttle:login');
Route::get('product', [ProductCT::class, 'show']);
Route::get('get-user/{id}', [UserCT::class, 'getUserById']);

Route::middleware(['admin.jwt'])->group( function() {
    Route::post('product', [ProductCT::class, 'store']);
    
    Route::get('products/', function() {
        $products = Product::all();
        return response()->json([
            'data-produk' => $products
        ], 200);
    });


    Route::get('product/{id}', [ProductCT::class, 'showById']);
    Route::put('product/{id}', [ProductCT::class, 'update']);
    Route::delete('product/{id}', [ProductCT::class, 'delete']);
    Route::get('product/{id}/restore', [ProductCT::class, 'restore']);
} );
