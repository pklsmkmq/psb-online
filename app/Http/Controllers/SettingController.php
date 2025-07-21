<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Setting
};

class SettingController extends Controller
{
    public function tahun_ajaran(Request $request)
    {
        if ($request->tahun_ajaran) {
            $data = Setting::where('name_setting','tahun ajaran')->first();
            if ($data) {
                $data->value = $request->tahun_ajaran;
                if($data->save()){
                    return response()->json([
                        "status" => "success",
                        "message" => 'Berhasil Merubah Tahun Ajaran'
                    ]);
                }else{
                    return response()->json([
                        "status" => "failed",
                        "message" => 'Gagal Menyimpan Data'
                    ]);
                }
            }else {
                $buat = Setting::create([
                    'name_setting' => 'tahun ajaran',
                    'value' => $request->tahun_ajaran
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }
        }else{
            $data = Setting::where('name_setting','tahun ajaran')->first();
            if (!$data) {
                $buat = Setting::create([
                    'name_setting' => 'tahun ajaran',
                    'value' => '2026 - 2027'
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data'
                ]);
            }
        }
    }
}
