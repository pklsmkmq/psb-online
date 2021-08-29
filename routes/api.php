<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CalonSiswaController,
    PendidikanSebelumnyaController,
    DataAyahController,
    DataIbuController,
    DataWaliController,
    PrestasiBelajarController,
    PrestasiSmpController,
    PendaftaranController,
    BuktiController,
    TesDiniyyahController
   
};
use App\Http\Controllers\admin\{
    UserController, 
};

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
        // User crud
        Route::resource('user', UserController::class);
        Route::delete('user', [UserController::class, "destroy"]);

        // Calon Siswa crud
        Route::resource('calonSiswa', CalonSiswaController::class);
        Route::delete('calonSiswa', [CalonSiswaController::class, "destroy"]);
       

        // Pendidikan Sebelumnya crud
        Route::resource('pendidikanSebelumnya', PendidikanSebelumnyaController::class);
        Route::delete('pendidikanSebelumnya', [PendidikanSebelumnyaController::class, "destroy"]);

        // Data Ayah crud
        Route::resource('ayah', DataAyahController::class);
        Route::delete('ayah', [DataAyahController::class, "destroy"]);

        // Data Ibu crud
        Route::resource('ibu', DataIbuController::class);
        Route::delete('ibu', [DataIbuController::class, "destroy"]);

        // Data Wali crud
        Route::resource('wali', DataWaliController::class);
        Route::delete('wali', [DataWaliController::class, "destroy"]);

        // Prestasi Belajar / nilai rapot crud
        Route::resource('prestasiBelajar', PrestasiBelajarController::class);
        Route::delete('prestasiBelajar', [PrestasiBelajarController::class, "destroy"]);

        // Prestasi SMP / Perlombaan crud
        Route::resource('prestasiSmp', PrestasiSmpController::class);
        Route::delete('prestasiSmp', [PrestasiSmpController::class, "destroy"]);

        // Pendaftaran Crud
        Route::resource('pendaftaran', PendaftaranController::class);
        Route::delete('pendaftaran', [PendaftaranController::class, "destroy"]);
     });

    //  Fitur User
     Route::middleware('role:user')->group(function () {
        Route::prefix('dataSiswa')->group(function () {
            Route::post('save', [CalonSiswaController::class, "saveData"]);
            Route::get('detail', [CalonSiswaController::class, "showData"]);
            Route::put('update', [CalonSiswaController::class, "updateData"]);
            Route::get('getme', [CalonSiswaController::class, "getme"]);
        });
        
        Route::prefix('dataPendidikan')->group(function () {
            Route::post('save', [PendidikanSebelumnyaController::class, "saveData"]);
            Route::get('detail', [PendidikanSebelumnyaController::class, "showData"]);
            Route::put('update', [PendidikanSebelumnyaController::class, "updateData"]);
        });

        Route::prefix('dataAyah')->group(function () {
            Route::post('save', [DataAyahController::class, "saveData"]);
            Route::get('detail', [DataAyahController::class, "showData"]);
            Route::put('update', [DataAyahController::class, "updateData"]);
            Route::get('detail/{id}', [DataAyahController::class, "show"]);
            Route::put('update/{id}', [DataAyahController::class, "update"]);
        });
        
        Route::prefix('dataIbu')->group(function () {
            Route::post('save', [DataIbuController::class, "store"]);
            Route::get('detail/{id}', [DataIbuController::class, "show"]);
            Route::put('update/{id}', [DataIbuController::class, "update"]);
        });

        Route::prefix('dataWali')->group(function () {
            Route::post('save', [DataWaliController::class, "store"]);
            Route::get('detail/{id}', [DataWaliController::class, "show"]);
            Route::put('update/{id}', [DataWaliController::class, "update"]);
        });

        Route::prefix('nilaiRapot')->group(function () {
            Route::post('save', [PrestasiBelajarController::class, "store"]);
            Route::get('detail/{id}', [PrestasiBelajarController::class, "show"]);
            Route::put('update/{id}', [PrestasiBelajarController::class, "update"]);
        });

        Route::prefix('lombaSmp')->group(function () {
            Route::post('save', [PrestasiSmpController::class, "store"]);
            Route::get('detail/{id}', [PrestasiSmpController::class, "show"]);
            Route::put('update/{id}', [PrestasiSmpController::class, "update"]);
        });

        Route::prefix('tesMasuk')->group(function () {
            Route::post('save', [PendaftaranController::class, "store"]);
            Route::get('detail/{id}', [PendaftaranController::class, "show"]);
            Route::put('update/{id}', [PendaftaranController::class, "update"]);
        });

        Route::prefix('uploadBukti')->group(function () {
            Route::post('save', [BuktiController::class, "store"]);
            Route::get('detail', [BuktiController::class, "show"]);
            Route::get('status', [BuktiController::class, "updateStatus"]);
            Route::put('update', [BuktiController::class, "update"]);
        });

        Route::resource('tesDiniyah', TesDiniyyahController::class);
        Route::prefix('tesDiniyahSaya')->group(function () {
            Route::get('tes-saya', [ TesDiniyyahController::class, "tesSaya"]);
           
        });
     });
});