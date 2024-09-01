<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PaymentController, WaControllers};
use App\Http\Controllers\admin\UserController;

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

Route::get('/tugasDWBI', [UserController::class,'TugasKuliah']);

Route::get('test/payment',[PaymentController::class,'testPayment']);

Route::get('test/wa',[WaControllers::class,'wa1']);
