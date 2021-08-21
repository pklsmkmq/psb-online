<?php

namespace App\Http\Controllers;

use App\Models\dataWali;
use Illuminate\Http\Request;
use Validator;

class DataWaliController extends Controller
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
        $users = dataWali::where('name_wali', 'like', '%'.strtolower($request->keywords)."%")->orderBy("created_at", 'desc')->paginate($request->perpage, [
            'data_wali.nik_wali',
            'data_wali.nik_siswa',
            'data_wali.name_wali',
            'data_wali.tempat_lahir_wali',
            'data_wali.tanggal_lahir_wali',
            'data_wali.pekerjaan_wali',
            'data_wali.nomor_telepon_wali',
            'data_wali.penghasilan_wali',
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
            'nik_wali' => 'required|numeric|unique:data_wali,nik_wali',
            'nik_siswa' => 'required|numeric|unique:data_wali,nik_siswa',
            'name_wali' => 'required|string|max:255',
            'tempat_lahir_wali' => 'required|string|max:255',
            'tanggal_lahir_wali' => 'required',
            'pekerjaan_wali' => 'required|string|max:50',
            'nomor_telepon_wali' => 'required',
            'penghasilan_wali' => 'required|numeric',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_wali);
            $tanggal = date('Y-m-d',$time);
            $dataWali = dataWali::create([
                'nik_wali' => $request->nik_wali,
                'nik_siswa' => $request->nik_siswa,
                'name_wali' => $request->name_wali,
                'tempat_lahir_wali' => $request->tempat_lahir_wali,
                'tanggal_lahir_wali' => $tanggal,
                'pekerjaan_wali' => $request->pekerjaan_wali,
                'nomor_telepon_wali' => $request->nomor_telepon_wali,
                'penghasilan_wali' => $request->penghasilan_wali,
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
        $dataWali = dataWali::where('nik_wali', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $dataWali
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
        $dataWali = dataWali::where('nik_wali', $id)->first(); 

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $dataWali
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
            'name_wali' => 'required|string|max:255',
            'tempat_lahir_wali' => 'required|string|max:255',
            'tanggal_lahir_wali' => 'required',
            'pekerjaan_wali' => 'required|string|max:50',
            'nomor_telepon_wali' => 'required',
            'penghasilan_wali' => 'required|numeric'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $time = strtotime($request->tanggal_lahir_wali);
            $tanggal = date('Y-m-d',$time);
            $dataWali = dataWali::where('nik_wali',$id)->first();
            $dataWali->nik_siswa = $request->nik_siswa;
            $dataWali->name_wali = $request->name_wali;
            $dataWali->tempat_lahir_wali = $request->tempat_lahir_wali;
            $dataWali->tanggal_lahir_wali = $tanggal;
            $dataWali->pekerjaan_wali = $request->pekerjaan_wali;
            $dataWali->nomor_telepon_wali = $request->nomor_telepon_wali;
            $dataWali->penghasilan_wali = $request->penghasilan_wali;

            if($dataWali->save()){
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
           for($i = 0 ; $i < count($request->nik_wali) ; $i++){
            
            $delete = dataWali::find($request->nik_wali[$i]);
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
                "message" => 'NIK Wali tidak ditemukan'
            ]);
        }
    }
}
