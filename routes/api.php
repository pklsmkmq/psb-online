<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\{
    UserController, 
};
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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/login', function () {
    return response()->json([
        'message' => 'Hayoo Antum Mau Ngapain?, halaman ini terlarang buat antum masuki'
    ], 401);
});
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class, 'register']);

// Auth by sanctum
Route::middleware(['auth:sanctum'])->group(function () {
 Route::get('/authme', [AuthController::class ,'authMe']);
 
//Fitur admin
 Route::middleware('role:admin')->group(function () {
        Route::resource('user', UserController::class);
        Route::delete('user', [UserController::class, "destroy"]);
     });
});