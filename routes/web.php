<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
})->middleware('auth');
Route::get('/items/showByCode/{code}', 'App\Http\Controllers\ItemsController@showByCode');
Route::get('/items/sellItem/{id}', 'App\Http\Controllers\ItemsController@sellItem');
Route::resource('items', 'App\Http\Controllers\ItemsController')->middleware('auth');
Route::post('/categories/addsub/{id}', 'App\Http\Controllers\CategoriesController@addsub');
Route::resource('categories', 'App\Http\Controllers\CategoriesController')->middleware('auth');
Route::post('/cars/addmodel/{id}', 'App\Http\Controllers\CarsController@addmodel');
Route::resource('cars', 'App\Http\Controllers\CarsController')->middleware('auth');
Route::get('/pictures/remove/{id}', 'App\Http\Controllers\PicturesController@remove');
Route::resource('pictures', 'App\Http\Controllers\PicturesController')->middleware('auth');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
