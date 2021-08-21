<?php

namespace App\Http\Controllers;

use App\Models\prestasiSmp;
use Illuminate\Http\Request;
use Validator;

class PrestasiSmpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->keywords;
        $request->page;
        $request->role;
        $users = prestasiSmp::where('cabang_lomba', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'prestasi_smp.id',
            'prestasi_smp.nik_siswa',
            'prestasi_smp.cabang_lomba',
            'prestasi_smp.peringkat_tingkat_kab',
            'prestasi_smp.peringkat_tingkat_provinsi',
            'prestasi_smp.peringkat_tingkat_nasional',
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $users 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prestasiSmp = prestasiSmp::create([
            'nik_siswa' => $request->nik_siswa,
            'cabang_lomba' => $request->cabang_lomba,
            'peringkat_tingkat_kab' => $request->peringkat_tingkat_kab,
            'peringkat_tingkat_provinsi' => $request->peringkat_tingkat_provinsi,
            'peringkat_tingkat_nasional' => $request->peringkat_tingkat_nasional,
        ]);

        return response()->json([
            "status" => "success",
            "message" => 'Berhasil Menyimpan Data'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pendidikanSebelumnya  $pendidikanSebelumnya
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prestasiSmp = prestasiSmp::where('id', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $prestasiSmp
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pendidikanSebelumnya  $pendidikanSebelumnya
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prestasiSmp = prestasiSmp::where('id', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $prestasiSmp
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\calonSiswa  $calonSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prestasiSmp = prestasiSmp::where('id',$id)->first();
        $prestasiSmp->nik_siswa = $request->nik_siswa;
        $prestasiSmp->cabang_lomba = $request->cabang_lomba;
        $prestasiSmp->peringkat_tingkat_kab = $request->peringkat_tingkat_kab;
        $prestasiSmp->peringkat_tingkat_provinsi = $request->peringkat_tingkat_provinsi;
        $prestasiSmp->peringkat_tingkat_nasional = $request->peringkat_tingkat_nasional;

        if($prestasiSmp->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Menyimpan Data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\calonSiswa  $calonSiswa
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        try {
           for($i = 0 ; $i < count($request->id) ; $i++){
            
            $delete = prestasiSmp::find($request->id[$i]);
            $delete -> delete();
           }
           return response()->json([
            "status" => "success",
            "message" => 'Berhasil Menghapus Data'
           ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => "failed",
                "message" => 'ID tidak ditemukan'
            ]);
        }
    }
}