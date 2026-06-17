<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Enjoy building your API!
*/

Route::middleware('auth:sanctum')->get('/pos-products', function () {
    return Product::select('id', 'name', 'selling_price')
        ->orderBy('name')
        ->get();
});
