<?php

use App\Http\Controllers\Api\AuthorController;
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


Route::controller(AuthorController::class)->group(function() {
    Route::get('authors', 'index')->name('api.authors.index');
    Route::post('authors', 'store')->name('api.authors.store');
    Route::put('authors/{author}', 'update')->name('api.authors.update');
    Route::delete('authors/{author}', 'destroy')->name('api.authors.destroy');
});