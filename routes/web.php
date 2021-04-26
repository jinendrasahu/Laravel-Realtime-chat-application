<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/message/{id}', [App\Http\Controllers\HomeController::class, 'getMessage'])->name('home');
//'HomeController@getMessage'
//[App\Http\Controllers\HomeController::class, 'getMessage']
// Route::get('/message/(:id)',function($id){
//     return $id;
// })->name('message');
Route::post('message', [App\Http\Controllers\HomeController::class, 'sendMessage']);
