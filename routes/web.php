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

Route::group(['middleware' => ['auth']], function() {
    Route::get('folders/upload', 'App\Http\Controllers\FolderController@upload')->name('folders.upload');
    Route::post('folders/media', 'App\Http\Controllers\FolderController@storeMedia')->name('folders.storeMedia');
    Route::post('folders/upload', 'App\Http\Controllers\FolderController@postUpload')->name('folders.postUpload');

    Route::resource('folders', 'App\Http\Controllers\FolderController');

    Route::get('delete-file/{id}', [App\Http\Controllers\FolderController::class, 'delete' ]);
    Route::get('delete-folder/{id}', [App\Http\Controllers\FolderController::class, 'deleteFolder' ]);
});
