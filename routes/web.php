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
route::get('/dd',function(){
$dd=\App\Models\channel::find(55);
$dd->load('videos');
return $dd;
});
Route::get('/', function () {
    return view('welcome');
});
route::get('register',[App\Http\Controllers\Auth\RegisterController::class,'index'])->name('register');
route::get('channel-edit/{id}',\App\Http\Livewire\Channel\ChannelEdit::class);
route::Post('register',[App\Http\Controllers\Auth\RegisterController::class,'create'])->name('register.create');
// Authentication Routes...
route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {

    Route::get('/channel/{channel}/edit', [App\Http\Controllers\ChannelController::class, 'edit'])->name('channel.edit');
});

Route::group(['middleware'=>'auth','namespace'=>'App\Http\Livewire\Video'], function() {
    Route::get('/create/{channel}','Create')->name('video.create');
    Route::get('/all/videos/{channel}','AllVideos')->name('video.all');
    Route::get('/edit/{channel}/{video}','Edit')->name('video.edit');
    Route::get('/show/{channel}/{video}','Show')->name('video.show');
});

Route::get('/watch/{video}','App\Http\Livewire\WatchVideo')->name('video.watch');
