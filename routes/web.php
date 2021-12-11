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

Route::group(['middleware' => 'auth'],function(){

    // subject routes
    Route::resource('/subject', App\Http\Controllers\SubjectController::class);
    Route::get('/data', [App\Http\Controllers\SubjectController::class, 'data'])->name('subject.data');
    Route::get('/subject/{id}/edit', [App\Http\Controllers\SubjectController::class, 'edit'])->name('subject.edit');
    Route::get('/subject/{id}/delete', [App\Http\Controllers\SubjectController::class, 'destroy'])->name('subject.delete');

    // Teacher routes
    Route::resource('/teacher', App\Http\Controllers\TeacherController::class);
    Route::get('/teacherdata', [App\Http\Controllers\TeacherController::class, 'teacherdata'])->name('teacher.teacherdata');
    Route::get('/teacher/{id}/edit', [App\Http\Controllers\TeacherController::class, 'edit'])->name('teacher.edit');
    Route::get('/teacher/{id}/delete', [App\Http\Controllers\TeacherController::class, 'destroy'])->name('teacher.delete');

    // Student routes
    Route::resource('/student', App\Http\Controllers\StudentController::class);
    Route::get('/studentdata', [App\Http\Controllers\StudentController::class, 'studentdata'])->name('student.studentdata');
    Route::get('/student/{id}/edit', [App\Http\Controllers\StudentController::class, 'edit'])->name('student.edit');
    Route::get('/student/{id}/delete', [App\Http\Controllers\StudentController::class, 'destroy'])->name('student.delete');
});

Route::get('/export', [App\Http\Controllers\StudentController::class, 'export'])->name('export');