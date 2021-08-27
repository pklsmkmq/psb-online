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
Route::get('/login', function () {
    return abort('404');
})->name('login');

Route::get('send-mail', function () {
    $details = [
        'title' => 'Mail from ppdb.smkmadinatulquran.sch.id',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('thenanungsr@gmail.com')->send(new \App\Mail\SenderMail($details));
   
    dd("Email is Sent.");
});