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


Route::group(['middleware' => 'auth'],function(){
	// student routes
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('/student', [App\Http\Controllers\StudentController::class,'index'])->name('student');
	Route::post('/student/store', [App\Http\Controllers\StudentController::class,'store'])->name('student.store');
	Route::get('/student/{id}/edit', [App\Http\Controllers\StudentController::class,'edit'])->name('student.edit');
	Route::post('/student/{id}/update', [App\Http\Controllers\StudentController::class,'update'])->name('student.update');
	Route::get('/student/{id}/delete', [App\Http\Controllers\StudentController::class,'destroy'])->name('student.delete');


	// address routes
	Route::get('/addresslist', [App\Http\Controllers\AddressController::class,'addresslist'])->name('addresslist');
	Route::get('/address', [App\Http\Controllers\AddressController::class,'index'])->name('address');
	Route::post('/address/store', [App\Http\Controllers\AddressController::class,'store'])->name('address.store');
	Route::get('/address/{id}/edit', [App\Http\Controllers\AddressController::class,'edit'])->name('address.edit');
	Route::post('/address/{id}/update', [App\Http\Controllers\AddressController::class,'update'])->name('address.update');
	Route::get('/address/{id}/delete', [App\Http\Controllers\AddressController::class,'destroy'])->name('address.delete');
});
