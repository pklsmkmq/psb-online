<?php

namespace App\Http\Controllers;

use App\Models\pendidikanSebelumnya;
use Illuminate\Http\Request;
use Validator;

class PendidikanSebelumnyaController extends Controller
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
        $users = pendidikanSebelumnya::where('asal_sekolah', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'pendidikan_sebelumnya.id',
            'pendidikan_sebelumnya.nik_siswa',
            'pendidikan_sebelumnya.asal_sekolah',
            'pendidikan_sebelumnya.alamat_sekolah',
            'pendidikan_sebelumnya.nomor_telepon_sekolah',
            'pendidikan_sebelumnya.nisn',
            'pendidikan_sebelumnya.npsn',
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
        $rules = array(
            'nik_siswa' => 'required|numeric',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => 'required|unique:pendidikan_sebelumnya,nisn',
            'npsn' => 'required'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $pendidikanSebelumnya = pendidikanSebelumnya::create([
                'nik_siswa' => $request->nik_siswa,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
                'nomor_telepon_sekolah' => $request->nomor_telepon_sekolah,
                'nisn' => $request->nisn,
                'npsn' => $request->npsn
            ]);
    
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pendidikanSebelumnya  $pendidikanSebelumnya
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendidikanSebelumnya = pendidikanSebelumnya::where('id', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $pendidikanSebelumnya
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
        $pendidikanSebelumnya = pendidikanSebelumnya::where('id', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $pendidikanSebelumnya
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
        $rules = array(
            'nik_siswa' => 'required|numeric',
            'asal_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required',
            'nomor_telepon_sekolah' => 'required',
            'nisn' => 'required',
            'npsn' => 'required'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $pendidikanSebelumnya = pendidikanSebelumnya::where('id',$id)->first();
            $pendidikanSebelumnya->nik_siswa = $request->nik_siswa;
            $pendidikanSebelumnya->asal_sekolah = $request->asal_sekolah;
            $pendidikanSebelumnya->alamat_sekolah = $request->alamat_sekolah;
            $pendidikanSebelumnya->nomor_telepon_sekolah = $request->nomor_telepon_sekolah;
            $pendidikanSebelumnya->nisn = $request->nisn;
            $pendidikanSebelumnya->npsn = $request->npsn;    

            if($pendidikanSebelumnya->save()){
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
            
            $delete = pendidikanSebelumnya::find($request->id[$i]);
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