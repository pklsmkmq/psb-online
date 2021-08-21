<?php

namespace App\Http\Controllers;

use App\Models\dataIbu;
use Illuminate\Http\Request;
use Validator;

class DataIbuController extends Controller
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
        $users = dataIbu::where('name_ibu', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'data_ibu.nik_ibu',
            'data_ibu.nik_siswa',
            'data_ibu.name_ibu',
            'data_ibu.tempat_lahir_ibu',
            'data_ibu.tanggal_lahir_ibu',
            'data_ibu.pekerjaan_ibu',
            'data_ibu.nomor_telepon_ibu',
            'data_ibu.penghasilan_ibu',
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
            'nik_ibu' => 'required|numeric|unique:data_ibu,nik_ibu',
            'nik_siswa' => 'required|numeric|unique:data_ibu,nik_siswa',
            'name_ibu' => 'required|string|max:255',
            'tempat_lahir_ibu' => 'required|string|max:255',
            'tanggal_lahir_ibu' => 'required',
            'pekerjaan_ibu' => 'required|string|max:50',
            'nomor_telepon_ibu' => 'required',
            'penghasilan_ibu' => 'required|numeric',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_ibu);
            $tanggal = date('Y-m-d',$time);
            $dataIbu = dataIbu::create([
                'nik_ibu' => $request->nik_ibu,
                'nik_siswa' => $request->nik_siswa,
                'name_ibu' => $request->name_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $tanggal,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'nomor_telepon_ibu' => $request->nomor_telepon_ibu,
                'penghasilan_ibu' => $request->penghasilan_ibu,
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
        $dataIbu = dataIbu::where('nik_ibu', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $dataIbu
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
        $dataIbu = dataIbu::where('nik_ibu', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $dataIbu
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
            'name_ibu' => 'required|string|max:255',
            'tempat_lahir_ibu' => 'required|string|max:255',
            'tanggal_lahir_ibu' => 'required',
            'pekerjaan_ibu' => 'required|string|max:50',
            'nomor_telepon_ibu' => 'required',
            'penghasilan_ibu' => 'required|numeric'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_ibu);
            $tanggal = date('Y-m-d',$time);
            $dataIbu = dataIbu::where('nik_ibu',$id)->first();
            $dataIbu->nik_siswa = $request->nik_siswa;
            $dataIbu->name_ibu = $request->name_ibu;
            $dataIbu->tempat_lahir_ibu = $request->tempat_lahir_ibu;
            $dataIbu->tanggal_lahir_ibu = $tanggal;
            $dataIbu->pekerjaan_ibu = $request->pekerjaan_ibu;
            $dataIbu->nomor_telepon_ibu = $request->nomor_telepon_ibu;
            $dataIbu->penghasilan_ibu = $request->penghasilan_ibu;

            if($dataIbu->save()){
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
           for($i = 0 ; $i < count($request->nik_ibu) ; $i++){
            
            $delete = dataIbu::find($request->nik_ibu[$i]);
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
                "message" => 'NIK Ibu tidak ditemukan'
            ]);
        }
    }
}
